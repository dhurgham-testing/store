<?php

namespace App\Filament\Resources\Admin\Products\Tables;

use App\Models\Product;
use App\ProductStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
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
                    ->weight('bold')
                    ->limit(30),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->color('blue'),

                TextColumn::make('brand.name')
                    ->label('Brand')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->color('purple'),

                ImageColumn::make('image.path')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->image ? \Illuminate\Support\Facades\Storage::url($record->image->path) : null)
                    ->circular()
                    ->toggleable()
                    ->imageSize(40),

                TextColumn::make('cost')
                    ->label('Cost')
                    ->money('IQD')
                    ->sortable()
                    ->toggleable()
                    ->color('gray'),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('IQD')
                    ->sortable()
                    ->toggleable()
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->toggleable()
                    ->color(fn (int $state): string => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    })
                    ->badge(),

                TextColumn::make('status')
                    ->badge()
                    ->toggleable()
                    ->color(fn (ProductStatus $state): string => match ($state) {
                        ProductStatus::DRAFT => 'gray',
                        ProductStatus::PUBLISHED => 'success',
                    }),

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
                    ->modalHeading('Edit Product')
                    ->modalDescription('Update the product information.')
                    ->modalSubmitActionLabel('Save Changes')
                    ->action(function (array $data, $record) {
                        if (! empty($data['image'])) {
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
                    ->disabled(fn ($record) => ! $record->image),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->modalHeading('Create Product')
                    ->modalDescription('Add a new Product to the store.')
                    ->modalSubmitActionLabel('Create Product')
                    ->action(function (array $data) {
                        if (! empty($data['image'])) {
                            $image = app(\App\Services\ImageService::class)->handleUpload($data['image']);

                            if ($image) {
                                $data['image_id'] = $image->id;
                            }
                        }

                        unset($data['image']);
                        Product::query()->create($data);
                    }),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
