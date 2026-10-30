<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BahanBakuFactory extends Factory
{
    public function definition(): array
    {
        $bahan = [
            'Beras Premium',
            'Telur Ayam',
            'Daging Ayam Fillet',
            'Minyak Goreng',
            'Susu UHT',
            'Wortel Segar',
            'Kentang Dieng',
            'Bayam Hijau',
            'Gula Pasir',
            'Garam Dapur',
            'Tempe Kedelai',
            'Tahu Putih',
            'Ikan Kembung',
            'Kacang Hijau',
            'Bawang Merah',
            'Bawang Putih'
        ];

        $satuan = [
            'Kg',
            'Liter',
            'Tray',
            'Ikat',
            'Butir'
        ];

        return [
            'kategori_id' => Kategori::inRandomOrder()->first()?->id ?? 1,
            'kode_bahan' => 'BHN-' . fake()->unique()->numberBetween(1000, 9999),
            'nama_bahan' => fake()->randomElement($bahan),
            'stok' => fake()->numberBetween(0, 100),
            'satuan' => fake()->randomElement($satuan),
            'deskripsi' => fake()->sentence(),
        ];
    }
}
