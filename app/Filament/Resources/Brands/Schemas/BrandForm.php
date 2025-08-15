<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\BrandStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
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
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash']),

                Textarea::make('description')
                    ->maxLength(1000)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Brand Image')
                    ->image()
                    ->imageEditor()
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->disk(config('filesystems.default'))
                    ->directory('brands')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->storeFileNamesIn('original_filename')
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        BrandStatus::DRAFT->value => 'Draft',
                        BrandStatus::PUBLISHED->value => 'Published',
                    ])
                    ->default(BrandStatus::DRAFT->value)
                    ->required(),
            ]);
    }
}
