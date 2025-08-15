<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
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
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                ImageColumn::make('image.path')
                    ->label('Image')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl('https://via.placeholder.com/40x40?text=No+Image'),

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
                    ->modalHeading('Edit Category')
                    ->modalDescription('Update the category information.')
                    ->modalSubmitActionLabel('Save Changes')
                    ->action(function (array $data, $record) {
                        if (!empty($data['image'])) {
                            $imageService = app(\App\Services\ImageService::class);
                            $image = $imageService->handleUpload($data['image'], $data['name'] . ' category image');

                            if ($image) {
                                $data['image_id'] = $image->id;
                            }
                        }

                        unset($data['image']);

                        $record->update($data);
                    }),

                Action::make('debug')
                    ->label('🐛 Debug')
                    ->icon('heroicon-o-bug-ant')
                    ->color('warning')
                    ->visible(fn () => auth()->user()->hasRole('super-admin'))
                    ->action(function ($record) {
                        dd([
                            'Category Record' => $record->toArray(),
                            'Category ID' => $record->id,
                            'Category Name' => $record->name,
                            'Image ID' => $record->image_id,
                            'Image Relationship' => $record->image ? $record->image->toArray() : 'No image relationship',
                            'Image Path' => $record->image ? $record->image->path : 'No image path',
                            'Storage URL' => $record->image ? \Illuminate\Support\Facades\Storage::url($record->image->path) : 'No storage URL',
                            'Filesystem Disk' => config('filesystems.default'),
                            'S3 Config' => config('filesystems.disks.s3'),
                            'Environment' => config('app.env'),
                            'APP_URL' => config('app.url'),
                            'Storage URL Test' => $record->image ? \Illuminate\Support\Facades\Storage::disk('s3')->url($record->image->path) : 'No S3 URL',
                        ]);
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
                    ->modalHeading('Create Category')
                    ->modalDescription('Add a new category to the store.')
                    ->modalSubmitActionLabel('Create Category')
                    ->action(function (array $data) {
                        if (!empty($data['image'])) {
                            $imageService = app(\App\Services\ImageService::class);
                            $image = $imageService->handleUpload($data['image'], $data['name'] . ' category image');

                            if ($image) {
                                $data['image_id'] = $image->id;
                            }
                        }

                        unset($data['image']);
                        Category::query()->create($data);
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
