<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanMasuk extends Model
{
    use HasFactory;

    protected $table = 'bahan_masuk';
    protected $guarded = [];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Relasi ke Bahan Baku.
     */
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
