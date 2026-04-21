<?php

namespace App\Filament\Resources\Users\Schemas;

use Dom\Text;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('level_id')
                    ->label('Level User')
                    ->relationship('level', 'level_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(100),
                TextInput::make('password')
                    ->label('Password')
                    ->password() // Mengubah input menjadi titik-titik (hidden)
                    ->required(fn(string $operation): bool => $operation === 'create') // Wajib diisi saat Create, opsional saat Edit
                    ->dehydrated(fn(?string $state) => filled($state)) // Hanya simpan ke database jika field ini diisi
                    ->maxLength(255),
            ]);
    }
}
