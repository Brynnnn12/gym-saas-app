<?php

namespace App\Filament\Resources\Gyms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class GymForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Gym')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Slug (URL)')
                    ->helperText('Akan otomatis dibuat dari nama gym'),

                Select::make('user_id')
                    ->relationship('owner', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Pemilik Gym'),

                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull()
                    ->label('Deskripsi'),

                TextInput::make('address')
                    ->required()
                    ->maxLength(500)
                    ->label('Alamat Lengkap'),

                TextInput::make('city')
                    ->required()
                    ->maxLength(100)
                    ->label('Kota'),

                TextInput::make('phone')
                    ->tel()
                    ->label('No. Telepon'),

                FileUpload::make('image')
                    ->image()
                    ->directory('gyms')
                    ->label('Foto Gym')
                    ->imageEditor()
                    ->maxSize(2048),
            ]);
    }
}
