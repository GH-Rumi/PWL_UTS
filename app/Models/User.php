<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Gunakan Attributes gaya baru Laravel 12
#[Fillable(['level_id', 'username', 'nama', 'password'])]
#[Hidden(['password'])]
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    // 1. Arahkan model ini ke tabel m_user
    protected $table = 'm_user';

    // 2. Tentukan primary key-nya
    protected $primaryKey = 'user_id';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Memastikan password selalu di-hash otomatis
        ];
    }

    /* =======================================
       RELASI DATABASE (Sesuai ERD)
       ======================================= */
       
    // Relasi ke tabel m_level (Setiap user punya 1 level)
    public function level(): BelongsTo
    {
        return $this->belongsTo(level::class, 'level_id', 'level_id');
    }

    // Relasi ke tabel t_stok (1 User bisa menginput banyak stok)
    public function stoks(): HasMany
    {
        return $this->hasMany(t_stok::class, 'user_id', 'user_id');
    }

    // Relasi ke tabel t_penjualan (1 User bisa melayani banyak penjualan)
    public function penjualans(): HasMany
    {
        return $this->hasMany(t_penjualan::class, 'user_id', 'user_id');
    }

    /* =======================================
       KONFIGURASI FILAMENT & LOGIN
       ======================================= */

    // Nama yang muncul di pojok kanan atas panel Filament
    public function getFilamentName(): string
    {
        return $this->nama;
    }

    // Gunakan 'username' untuk login, bukan 'email'
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // Syarat akses panel Filament (Sementara izinkan semua yang bisa login)
    public function canAccessPanel(Panel $panel): bool
    {
        return true; 
    }
}