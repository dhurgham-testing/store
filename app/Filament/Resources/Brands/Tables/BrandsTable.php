<?php

namespace App\Filament\Resources\Brands\Tables;

use App\BrandStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BrandsTable
{
    /**
     * @throws \Exception
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->color('gray'),

                TextColumn::make('description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                ImageColumn::make('image.path')
                    ->label('Image')
                    ->circular()
                    ->toggleable()
                    ->imageSize(40),

                TextColumn::make('status')
                    ->badge()
                    ->toggleable()
                    ->color(fn (BrandStatus $state): string => match ($state) {
                        BrandStatus::DRAFT => 'gray',
                        BrandStatus::PUBLISHED => 'success',
                    }),

                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Edit Brand')
                    ->modalDescription('Update the brand information.')
                    ->modalSubmitActionLabel('Save Changes')
                    ->action(function (array $data, $record) {
                        if (!empty($data['image'])) {
                            $imageService = app(\App\Services\ImageService::class);
                            $image = $imageService->handleUpload($data['image'], $data['name'] . ' brand image');

                            if ($image) {
                                $data['image_id'] = $image->id;
                            }
                        }

                        unset($data['image']);

                        $record->update($data);
                    }),
                Action::make('open_image')
                    ->label('🖼️ Open Image')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('info')
                    ->visible(fn () => auth()->user()->hasRole('super-admin'))
                    ->url(fn ($record) => $record->image ? \Illuminate\Support\Facades\Storage::url($record->image->path) : null)
                    ->openUrlInNewTab()
                    ->disabled(fn ($record) => !$record->image),

                Action::make('debug_cors')
                    ->label('🔍 Debug CORS')
                    ->icon('heroicon-o-bug-ant')
                    ->color('warning')
                    ->visible(fn () => auth()->user()->hasRole('super-admin'))
                    ->action(function ($record) {
                        if ($record->image) {
                            $url = \Illuminate\Support\Facades\Storage::url($record->image->path);

                            // Test if image is accessible
                            $headers = get_headers($url, 1);
                            $isAccessible = strpos($headers[0], '200') !== false;

                            $debugInfo = "Image URL: {$url}\n";
                            $debugInfo .= "Accessible: " . ($isAccessible ? 'YES' : 'NO') . "\n";
                            $debugInfo .= "Response: " . $headers[0] . "\n";
                            $debugInfo .= "Content-Type: " . ($headers['Content-Type'] ?? 'Unknown') . "\n";
                            $debugInfo .= "Current Domain: " . request()->getHost() . "\n\n";
                            $debugInfo .= "Instructions:\n";
                            $debugInfo .= "1. Open browser DevTools (F12)\n";
                            $debugInfo .= "2. Go to Network tab\n";
                            $debugInfo .= "3. Refresh the table page\n";
                            $debugInfo .= "4. Look for failed image requests\n";
                            $debugInfo .= "5. Check Console for CORS errors";

                            \Filament\Notifications\Notification::make()
                                ->title('Comprehensive Debug Info')
                                ->body($debugInfo)
                                ->persistent()
                                ->send();

                            // Log for debugging
                            \Illuminate\Support\Facades\Log::info('Comprehensive CORS Debug', [
                                'image_url' => $url,
                                'is_accessible' => $isAccessible,
                                'response_headers' => $headers,
                                'current_domain' => request()->getHost(),
                                'user_agent' => request()->userAgent(),
                            ]);
                        }
                    })
                    ->disabled(fn ($record) => !$record->image),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->modalHeading('Create Brand')
                    ->modalDescription('Add a new brand to the store.')
                    ->modalSubmitActionLabel('Create Brand')
                    ->action(function (array $data) {
                        if (!empty($data['image'])) {
                            $imageService = app(\App\Services\ImageService::class);
                            $image = $imageService->handleUpload($data['image'], $data['name'] . ' brand image');

                            if ($image) {
                                $data['image_id'] = $image->id;
                            }
                        }

                        unset($data['image']);

                        \App\Models\Brand::create($data);
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
