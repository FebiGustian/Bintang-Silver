<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'slug',
        'deskripsi',
        'warna',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
