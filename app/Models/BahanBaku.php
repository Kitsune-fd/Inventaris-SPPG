<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';
    protected $guarded = [];

    /**
     * Relasi ke Kategori Bahan Baku.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi riwayat bahan masuk.
     */
    public function bahanMasuk()
    {
        return $this->hasMany(BahanMasuk::class, 'bahan_baku_id');
    }

    /**
     * Relasi riwayat penggunaan bahan.
     */
    public function penggunaanBahan()
    {
        return $this->hasMany(PenggunaanBahan::class, 'bahan_baku_id');
    }

    /**
     * Scope untuk bahan baku yang masih tersedia (stok > 0).
     */
    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }

    /**
     * Scope untuk bahan baku yang habis (stok <= 0).
     */
    public function scopeHabis(Builder $query): Builder
    {
        return $query->where('stok', '<=', 0);
    }

    /**
     * Accessor status ketersediaan stok.
     */
    public function getStatusAttribute(): string
    {
        return $this->stok > 0 ? 'tersedia' : 'habis';
    }
}
