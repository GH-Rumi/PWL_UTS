<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class kategori extends Model
{
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';
    protected $fillable = ['kategori_kode', 'kategori_nama'];

    public function barangs(): HasMany
    {
        return $this->hasMany(m_barang::class, 'kategori_id', 'kategori_id');
    }
}
