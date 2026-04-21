<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Informasi Transaksi')
                            ->schema([
                                TextInput::make('penjualan_kode')
                                    ->label('Kode Transaksi')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20),
                                TextInput::make('pembeli')
                                    ->label('Nama Pembeli')
                                    ->required()
                                    ->maxLength(50),
                                DateTimePicker::make('penjualan_tanggal')
                                    ->label('Tanggal Penjualan')
                                    ->default(now())
                                    ->required(),
                                Select::make('user_id')
                                    ->label('Kasir (Petugas)')
                                    ->relationship('user', 'nama')
                                    ->default(fn() => \Illuminate\Support\Facades\Auth::id()) // Mengubah cara pemanggilan ID
                                    ->disabled() // Dimatikan agar tidak bisa diubah manual
                                    ->dehydrated() // Wajib ada agar data yang disabled tetap disimpan ke database
                                    ->required(),
                            ])->columns(2), // Membagi menjadi 2 kolom agar rapi
                    ])->columnSpanFull(),

                Group::make()
                    ->schema([
                        Section::make('Detail Barang yang Dibeli')
                            ->schema([
                                // INI ADALAH REPEATER UNTUK TABEL DETAIL
                                Repeater::make('penjualanDetails') // Nama relasi di model Penjualan.php
                                    ->relationship()
                                    ->schema([
                                        Select::make('barang_id')
                                            ->label('Pilih Barang')
                                            ->relationship('barang', 'barang_nama')
                                            ->required()
                                            ->searchable()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(), // Agar tidak pilih barang yang sama 2x
                                        TextInput::make('harga')
                                            ->label('Harga Satuan')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp'),
                                        TextInput::make('jumlah')
                                            ->label('Jumlah Beli')
                                            ->required()
                                            ->numeric()
                                            ->minValue(1)
                                            ->default(1),
                                    ])
                                    ->columns(3) // Form repeater dibagi jadi 3 kolom sebaris
                                    ->addActionLabel('Tambah Barang Baru')
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
