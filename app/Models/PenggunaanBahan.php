<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanBahan extends Model
{
    use HasFactory;

    protected $table = 'penggunaan_bahan';
    protected $guarded = [];

    protected $casts = [
        'tanggal_penggunaan' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Relasi ke Bahan Baku.
     */
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    /**
     * Relasi ke Sekolah Penerima (opsional).
     */
    public function sekolah()
    {
        return $this->belongsTo(SekolahPenerima::class, 'sekolah_id');
    }
}
