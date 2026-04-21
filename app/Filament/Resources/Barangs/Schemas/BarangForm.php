<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'kategori_nama') // Memanggil fungsi relasi di model Barang.php
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('barang_kode')
                    ->label('Kode Barang')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('barang_nama')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(100),
                TextInput::make('harga_beli')
                    ->label('Harga Beli')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('harga_jual')
                    ->label('Harga Jual')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
            ]);
    }
}
