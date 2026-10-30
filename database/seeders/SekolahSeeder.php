<?php

namespace Database\Seeders;

use App\Models\SekolahPenerima;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = [
            [
                'npsn' => '102001',
                'nama_sekolah' => 'SDN 01 Kota Medan',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Kota',
                'alamat' => 'Jl. Pemuda No. 12, Medan Kota',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102002',
                'nama_sekolah' => 'SDN 05 Helvetia',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Helvetia',
                'alamat' => 'Jl. Gaperta No. 45, Medan Helvetia',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102003',
                'nama_sekolah' => 'MI Nurul Huda',
                'jenjang' => 'MI',
                'kecamatan' => 'Medan Sunggal',
                'alamat' => 'Jl. Sunggal No. 88, Medan Sunggal',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102004',
                'nama_sekolah' => 'SDN 03 Amplas',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Amplas',
                'alamat' => 'Jl. Panglima Denai, Medan Amplas',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102005',
                'nama_sekolah' => 'SDN 12 Selayang',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Selayang',
                'alamat' => 'Jl. Dr. Mansyur, Medan Selayang',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102006',
                'nama_sekolah' => 'MIN 1 Medan',
                'jenjang' => 'MI',
                'kecamatan' => 'Medan Denai',
                'alamat' => 'Jl. Bromo No. 10, Medan Denai',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102007',
                'nama_sekolah' => 'SMPN 10 Medan',
                'jenjang' => 'SMP',
                'kecamatan' => 'Medan Baru',
                'alamat' => 'Jl. Jamin Ginting, Medan Baru',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102008',
                'nama_sekolah' => 'SDN 08 Marelan',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Marelan',
                'alamat' => 'Jl. Marelan Raya, Medan Marelan',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102009',
                'nama_sekolah' => 'SD Swasta Al-Ikhlas',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Johor',
                'alamat' => 'Jl. Karya Wisata, Medan Johor',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102010',
                'nama_sekolah' => 'SDN 15 Belawan',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Belawan',
                'alamat' => 'Jl. Sumatera, Medan Belawan',
                'status' => 'aktif',
            ],
        ];

        foreach ($sekolahs as $data) {
            SekolahPenerima::updateOrCreate(['npsn' => $data['npsn']], $data);
        }
    }
}
