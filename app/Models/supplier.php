<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class supplier extends Model
{
    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['supplier_kode', 'supplier_nama', 'supplier_alamat'];

    public function stoks(): HasMany
    {
        return $this->hasMany(t_stok::class, 'supplier_id', 'supplier_id');
    }
}