<?php

namespace App\Filament\Resources\Stoks\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;

class StokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'barang_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('user_id')
                    ->label('Petugas (User)')
                    ->relationship('user', 'nama')
                    ->default(fn() => \Illuminate\Support\Facades\Auth::id()) // Mengubah cara pemanggilan ID
                    ->required()
                    ->searchable(),
                DateTimePicker::make('stok_tanggal')
                    ->label('Tanggal Stok Masuk')
                    ->default(now()) // Otomatis terisi tanggal & jam saat ini
                    ->required(),
                TextInput::make('stok_jumlah')
                    ->label('Jumlah Stok')
                    ->required()
                    ->numeric()
                    ->minValue(1),
            ]);
    }
}
