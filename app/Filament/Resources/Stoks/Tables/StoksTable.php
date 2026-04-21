<?php

namespace App\Filament\Resources\Stoks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class StoksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('stok_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i') // Format tampilan: 21 Apr 2026, 14:30
                    ->sortable(),
                TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stok_jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.nama')
                    ->label('Petugas')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Disembunyikan secara default agar tabel tidak penuh
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
