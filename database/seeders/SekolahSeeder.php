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
                'jumlah_siswa' => 250,
                'porsi' => 250,
                'status_distribusi' => 'terkirim',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102002',
                'nama_sekolah' => 'SDN 05 Helvetia',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Helvetia',
                'alamat' => 'Jl. Gaperta No. 45, Medan Helvetia',
                'jumlah_siswa' => 185,
                'porsi' => 185,
                'status_distribusi' => 'terkirim',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102003',
                'nama_sekolah' => 'MI Nurul Huda',
                'jenjang' => 'MI',
                'kecamatan' => 'Medan Sunggal',
                'alamat' => 'Jl. Sunggal No. 88, Medan Sunggal',
                'jumlah_siswa' => 120,
                'porsi' => 120,
                'status_distribusi' => 'terkirim',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102004',
                'nama_sekolah' => 'SDN 03 Amplas',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Amplas',
                'alamat' => 'Jl. Panglima Denai, Medan Amplas',
                'jumlah_siswa' => 210,
                'porsi' => 210,
                'status_distribusi' => 'proses',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102005',
                'nama_sekolah' => 'SDN 12 Selayang',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Selayang',
                'alamat' => 'Jl. Dr. Mansyur, Medan Selayang',
                'jumlah_siswa' => 165,
                'porsi' => 165,
                'status_distribusi' => 'terkirim',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102006',
                'nama_sekolah' => 'MIN 1 Medan',
                'jenjang' => 'MI',
                'kecamatan' => 'Medan Denai',
                'alamat' => 'Jl. Bromo No. 10, Medan Denai',
                'jumlah_siswa' => 230,
                'porsi' => 230,
                'status_distribusi' => 'proses',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102007',
                'nama_sekolah' => 'SMPN 10 Medan',
                'jenjang' => 'SMP',
                'kecamatan' => 'Medan Baru',
                'alamat' => 'Jl. Jamin Ginting, Medan Baru',
                'jumlah_siswa' => 310,
                'porsi' => 310,
                'status_distribusi' => 'proses',
                'status' => 'aktif',
            ],
            [
                'npsn' => '102008',
                'nama_sekolah' => 'SDN 08 Marelan',
                'jenjang' => 'SD',
                'kecamatan' => 'Medan Marelan',
                'alamat' => 'Jl. Marelan Raya, Medan Marelan',
                'jumlah_siswa' => 195,
                'porsi' => 195,
                'status_distribusi' => 'menunggu',
                'status' => 'aktif',
            ],
        ];

        foreach ($sekolahs as $item) {
            SekolahPenerima::updateOrCreate(['npsn' => $item['npsn']], $item);
        }
    }
}
