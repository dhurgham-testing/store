<?php

namespace App\Filament\Resources\Admin\Products;

use App\Filament\Resources\Admin\Products\Pages\ListProducts;
use App\Filament\Resources\Admin\Products\Schemas\ProductForm;
use App\Filament\Resources\Admin\Products\Tables\ProductsTable;
use App\Models\Image;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @throws \Exception
     */
    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['image', 'category', 'brand'])->where(function ($query) {
            if (! auth()->user()->hasAnyRole(['admin', 'super-admin'])) {
                $query->whereRaw('1 = 0');
            }
        });
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Store Management';
    }

    protected static function afterCreate(Product $record, array $data): void
    {
        // Handle image upload
        if (isset($data['image']) && is_array($data['image'])) {
            $imagePath = $data['image'][0] ?? null;

            if ($imagePath) {
                $image = Image::create([
                    'path' => $imagePath,
                    'alt_text' => $record->name.' product image',
                ]);

                $record->update(['image_id' => $image->id]);
            }
        }
    }

    protected static function afterUpdate(Product $record, array $data): void
    {
        // Handle image upload/update
        if (isset($data['image']) && is_array($data['image'])) {
            $imagePath = $data['image'][0] ?? null;

            if ($imagePath) {
                // Delete old image if exists
                if ($record->image) {
                    Storage::disk(config('filesystems.default'))->delete($record->image->path);
                    $record->image->delete();
                }

                // Create new image record
                $image = Image::create([
                    'path' => $imagePath,
                    'alt_text' => $record->name.' product image',
                ]);

                $record->update(['image_id' => $image->id]);
            }
        }
    }

    protected static function afterDelete(Product $record): void
    {
        // Delete associated image
        if ($record->image) {
            Storage::disk(config('filesystems.default'))->delete($record->image->path);
            $record->image->delete();
        }
    }
}
