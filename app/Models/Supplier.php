<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'supplier';

    public function bahanBaku()
    {
        return $this->hasMany(BahanBaku::class, 'supplier_id');
    }
}
