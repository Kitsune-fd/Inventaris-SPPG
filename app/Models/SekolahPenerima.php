<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahPenerima extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $guarded = [];

    /**
     * Relasi ke catatan penggunaan bahan.
     */
    public function penggunaanBahan()
    {
        return $this->hasMany(PenggunaanBahan::class, 'sekolah_id');
    }
}
