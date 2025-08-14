<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Image;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    /**
     * @throws \Exception
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->afterStateUpdatedJs(<<<'JS'
                        $set('slug', ($state ?? '')
                            .toLowerCase()
                            .replaceAll(' ', '-')
                            .replaceAll(/[^a-z0-9\-]/g, ''))
                    JS),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash']),

                Textarea::make('description')
                    ->maxLength(1000)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Category Image')
                    ->image()
                    ->imageEditor()
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->directory('categories')
                    ->visibility('public')
                    ->dehydrated()
                    ->columnSpanFull(),
            ]);
    }
}
