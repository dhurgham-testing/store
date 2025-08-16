<?php

namespace App\Filament\Resources\Admin\Categories;

use App\Filament\Resources\Admin\Categories\Pages\ListCategories;
use App\Filament\Resources\Admin\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Admin\Categories\Tables\CategoriesTable;
use App\Models\Category;
use App\Models\Image;
use BackedEnum;
use Exception;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('image')->where(function ($query) {
            if (!auth()->user()->hasAnyRole('admin','super-admin')) {
                $query->whereRaw('1 = 0');
            }
        });
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Store Management';
    }

    protected static function afterCreate(Category $record, array $data): void
    {
        // Handle image upload
        if (isset($data['image']) && is_array($data['image'])) {
            $imagePath = $data['image'][0] ?? null;

            if ($imagePath) {
                $image = Image::create([
                    'path' => $imagePath,
                    'alt_text' => $record->name . ' category image',
                ]);

                $record->update(['image_id' => $image->id]);
            }
        }
    }

    protected static function afterUpdate(Category $record, array $data): void
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
                    'alt_text' => $record->name . ' category image',
                ]);

                $record->update(['image_id' => $image->id]);
            }
        }
    }

    protected static function afterDelete(Category $record): void
    {
        // Delete associated image
        if ($record->image) {
            Storage::disk(config('filesystems.default'))->delete($record->image->path);
            $record->image->delete();
        }
    }
}
