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
     * Relasi ke Supplier Bahan Baku.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Scope untuk bahan baku dengan stok kritis / menipis.
     */
    public function scopeKritis(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereColumn('stok', '<=', 'stok_minimum')
              ->orWhere('status', 'habis');
        });
    }

    /**
     * Scope untuk bahan baku yang masih tersedia.
     */
    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tersedia')->where('stok', '>', 0);
    }
}
