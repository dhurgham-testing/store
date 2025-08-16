<?php

namespace App\Filament\Resources\Admin\Brands\Tables;

use App\BrandStatus;
use App\Models\Brand;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->getStateUsing(fn($record) => $record->image ? \Illuminate\Support\Facades\Storage::url($record->image->path) : null)
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
                            $image_service = app(\App\Services\ImageService::class);
                            $image = $image_service->handleUpload($data['image']);

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
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->modalHeading('Create Brand')
                    ->modalDescription('Add a new Brand to the store.')
                    ->modalSubmitActionLabel('Create Brand')
                    ->action(function (array $data) {
                        if (!empty($data['image'])) {
                            $image = app(\App\Services\ImageService::class)->handleUpload($data['image']);

                            if ($image) {
                                $data['image_id'] = $image->id;
                            }
                        }

                        unset($data['image']);
                        Brand::query()->create($data);
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
