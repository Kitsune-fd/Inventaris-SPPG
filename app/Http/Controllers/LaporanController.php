<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\BahanMasuk;
use App\Models\Kategori;
use App\Models\PenggunaanBahan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display inventory mutation report.
     */
    public function index(Request $request)
    {
        $tanggalDari = $request->input('tanggal_dari', Carbon::now()->startOfMonth()->toDateString());
        $tanggalSampai = $request->input('tanggal_sampai', Carbon::now()->toDateString());
        $kategoriId = $request->input('kategori_id');

        $query = BahanBaku::with('kategori');

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        $bahanList = $query->orderBy('nama_bahan')->get()->map(function ($bahan) use ($tanggalDari, $tanggalSampai) {
            $totalMasuk = BahanMasuk::where('bahan_baku_id', $bahan->id)
                ->whereBetween('tanggal_masuk', [$tanggalDari, $tanggalSampai])
                ->sum('jumlah');

            $totalPakai = PenggunaanBahan::where('bahan_baku_id', $bahan->id)
                ->whereBetween('tanggal_penggunaan', [$tanggalDari, $tanggalSampai])
                ->sum('jumlah');

            return (object) [
                'id' => $bahan->id,
                'kode_bahan' => $bahan->kode_bahan,
                'nama_bahan' => $bahan->nama_bahan,
                'kategori' => $bahan->kategori->nama_kategori ?? 'Umum',
                'satuan' => $bahan->satuan,
                'stok_sekarang' => $bahan->stok,
                'total_masuk' => $totalMasuk,
                'total_pakai' => $totalPakai,
                'status' => $bahan->stok > 0 ? 'Tersedia' : 'Habis',
            ];
        });

        // Summary Cards
        $totalJenis = BahanBaku::count();
        $totalTersedia = BahanBaku::where('stok', '>', 0)->count();
        $totalHabis = BahanBaku::where('stok', '<=', 0)->count();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('laporan.index', compact(
            'bahanList',
            'kategoris',
            'tanggalDari',
            'tanggalSampai',
            'kategoriId',
            'totalJenis',
            'totalTersedia',
            'totalHabis'
        ));
    }
}
