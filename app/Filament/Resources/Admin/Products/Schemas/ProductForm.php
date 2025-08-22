<?php

namespace App\Filament\Resources\Admin\Products\Schemas;

use App\Models\Brand;
use App\Models\Category;
use App\ProductStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    /**
     * @throws \Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->placeholder('Select a category'),

                Select::make('brand_id')
                    ->label('Brand')
                    ->options(Brand::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->placeholder('Select a brand'),

                Textarea::make('description')
                    ->maxLength(1000)
                    ->columnSpanFull(),

                TextInput::make('cost')
                    ->label('Cost Price')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->required(),

                TextInput::make('price')
                    ->label('Selling Price')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->required(),

                TextInput::make('stock')
                    ->label('Stock Quantity')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->default(0),

                FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->imageEditor()
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->disk(config('filesystems.default'))
                    ->directory('products')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->getUploadedFileNameForStorageUsing(fn ($file) => sanitize_image_name($file->getClientOriginalName()))
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        ProductStatus::DRAFT->value => 'Draft',
                        ProductStatus::PUBLISHED->value => 'Published',
                    ])
                    ->default(ProductStatus::DRAFT->value)
                    ->required(),
            ]);
    }
}
