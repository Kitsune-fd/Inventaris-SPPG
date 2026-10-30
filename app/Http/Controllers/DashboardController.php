<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\BahanMasuk;
use App\Models\PenggunaanBahan;
use App\Models\SekolahPenerima;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard summary.
     */
    public function index()
    {
        $today = Carbon::today();

        // 1. STAT CARDS: AKTIVITAS STOK HARI INI & STATUS
        $transaksiMasukHariIni = BahanMasuk::whereDate('tanggal_masuk', $today)->count();
        $totalQtyMasukHariIni = BahanMasuk::whereDate('tanggal_masuk', $today)->sum('jumlah');

        $transaksiPakaiHariIni = PenggunaanBahan::whereDate('tanggal_penggunaan', $today)->count();
        $totalQtyPakaiHariIni = PenggunaanBahan::whereDate('tanggal_penggunaan', $today)->sum('jumlah');

        $totalBahanBaku = BahanBaku::count();
        $totalBahanTersedia = BahanBaku::where('stok', '>', 0)->count();
        $totalBahanKritis = BahanBaku::where('stok', '<=', 0)->count();

        $totalSekolah = SekolahPenerima::count();
        $totalSekolahAktif = SekolahPenerima::where('status', 'aktif')->count();

        // 2. PEMANTAUAN STOK TERENDAH / HABIS (Untuk persiapan esok hari)
        $stokHampirHabis = BahanBaku::with('kategori')
            ->orderBy('stok', 'asc')
            ->take(7)
            ->get()
            ->map(function ($item) {
                $kondisi = 'normal';
                if ($item->stok <= 0) {
                    $kondisi = 'kritis';
                } elseif ($item->stok <= 10) {
                    $kondisi = 'rendah';
                }

                $persen = $item->stok > 0 ? min(100, max(10, round(($item->stok / 50) * 100))) : 0;

                return (object) [
                    'id' => $item->id,
                    'nama' => $item->nama_bahan,
                    'kategori' => $item->kategori->nama_kategori ?? 'Umum',
                    'stok' => number_format($item->stok, 2, ',', '.') . ' ' . $item->satuan,
                    'kondisi' => $kondisi,
                    'progress' => $persen,
                ];
            });

        // 3. GRAFIK MUTASI STOK 7 HARI TERAKHIR (OPSI A: Bahan Masuk vs Penggunaan Bahan)
        $chartDays = [];
        $chartMasuk = [];
        $chartPakai = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartDays[] = $date->translatedFormat('D');

            $masukQty = (float) BahanMasuk::whereDate('tanggal_masuk', $date->toDateString())->sum('jumlah');
            $pakaiQty = (float) PenggunaanBahan::whereDate('tanggal_penggunaan', $date->toDateString())->sum('jumlah');

            $chartMasuk[] = $masukQty;
            $chartPakai[] = $pakaiQty;
        }

        $maxVal = max(array_merge([1], $chartMasuk, $chartPakai));
        $totalMasuk7Hari = array_sum($chartMasuk);
        $totalPakai7Hari = array_sum($chartPakai);

        // 4. SEKOLAH PENERIMA HARI INI
        $sekolahList = SekolahPenerima::where('status', 'aktif')->take(6)->get();

        // 5. AKTIVITAS TERBARU
        $activityFeed = [];

        // Peringatan Bahan Habis
        $habisItems = BahanBaku::where('stok', '<=', 0)->take(2)->get();
        foreach ($habisItems as $h) {
            $activityFeed[] = [
                'dot' => 'red',
                'icon' => 'bi-exclamation-triangle',
                'title' => "Stok {$h->nama_bahan} kosong (0 {$h->satuan})!",
                'meta' => 'Peringatan Stok · Perlu dicatat bahan masuk',
                'time' => $h->updated_at,
            ];
        }

        // Penerimaan Bahan Masuk Terbaru
        $recentMasuk = BahanMasuk::with('bahanBaku')->latest('id')->take(3)->get();
        foreach ($recentMasuk as $bm) {
            $activityFeed[] = [
                'dot' => 'green',
                'icon' => 'bi-box-arrow-in-down',
                'title' => "Bahan Masuk: {$bm->bahanBaku->nama_bahan} (+{$bm->jumlah} {$bm->bahanBaku->satuan})",
                'meta' => "Penerimaan · " . ($bm->keterangan ?: 'Stok bertambah'),
                'time' => $bm->created_at,
            ];
        }

        // Penggunaan Bahan Terbaru
        $recentPakai = PenggunaanBahan::with(['bahanBaku', 'sekolah'])->latest('id')->take(3)->get();
        foreach ($recentPakai as $pb) {
            $tujuan = $pb->sekolah->nama_sekolah ?? $pb->keperluan ?? 'Dapur';
            $activityFeed[] = [
                'dot' => 'blue',
                'icon' => 'bi-box-arrow-up',
                'title' => "Penggunaan: {$pb->bahanBaku->nama_bahan} (-{$pb->jumlah} {$pb->bahanBaku->satuan})",
                'meta' => "Tujuan: {$tujuan}",
                'time' => $pb->created_at,
            ];
        }

        // Sort activity feed by time desc
        usort($activityFeed, function ($a, $b) {
            return ($b['time'] ?? Carbon::now()) <=> ($a['time'] ?? Carbon::now());
        });

        $activityFeed = array_slice($activityFeed, 0, 6);

        return view('dashboard', compact(
            'transaksiMasukHariIni',
            'totalQtyMasukHariIni',
            'transaksiPakaiHariIni',
            'totalQtyPakaiHariIni',
            'totalBahanBaku',
            'totalBahanTersedia',
            'totalBahanKritis',
            'totalSekolah',
            'totalSekolahAktif',
            'stokHampirHabis',
            'chartDays',
            'chartMasuk',
            'chartPakai',
            'maxVal',
            'totalMasuk7Hari',
            'totalPakai7Hari',
            'sekolahList',
            'activityFeed'
        ));
    }
}
