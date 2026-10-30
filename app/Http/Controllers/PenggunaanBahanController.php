<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\PenggunaanBahan;
use App\Models\SekolahPenerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaanBahanController extends Controller
{
    /**
     * Display a listing of used ingredients transactions.
     */
    public function index(Request $request)
    {
        $query = PenggunaanBahan::with(['bahanBaku.kategori', 'sekolah']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhereHas('bahanBaku', function ($b) use ($search) {
                      $b->where('nama_bahan', 'like', "%{$search}%")
                        ->orWhere('kode_bahan', 'like', "%{$search}%");
                  })
                  ->orWhereHas('sekolah', function ($s) use ($search) {
                      $s->where('nama_sekolah', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_penggunaan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_penggunaan', '<=', $request->tanggal_sampai);
        }

        $penggunaanBahan = $query->latest('tanggal_penggunaan')->latest('id')->paginate(10)->withQueryString();

        return view('penggunaan_bahan.index', compact('penggunaanBahan'));
    }

    /**
     * Generate Kode Transaksi Penggunaan Bahan otomatis (contoh: PB-20261030-001).
     */
    protected function generateKodeTransaksi(): string
    {
        $prefix = 'PB-' . date('Ymd') . '-';
        $allCodes = PenggunaanBahan::where('kode_transaksi', 'like', "{$prefix}%")->pluck('kode_transaksi')->toArray();
        $maxNum = 0;

        foreach ($allCodes as $code) {
            $part = substr($code, strlen($prefix));
            if (is_numeric($part)) {
                $num = (int) $part;
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }

        $next = $maxNum + 1;
        $candidate = $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);

        while (PenggunaanBahan::where('kode_transaksi', $candidate)->exists()) {
            $next++;
            $candidate = $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    /**
     * Show the form for creating a new ingredient usage record.
     */
    public function create(Request $request)
    {
        $bahanBaku = BahanBaku::with('kategori')->orderBy('nama_bahan')->get();
        $sekolah = SekolahPenerima::where('status', 'aktif')->orderBy('nama_sekolah')->get();
        $selectedBahanId = $request->query('bahan_baku_id');
        $kodeTransaksi = $this->generateKodeTransaksi();

        return view('penggunaan_bahan.create', compact('bahanBaku', 'sekolah', 'selectedBahanId', 'kodeTransaksi'));
    }

    /**
     * Store a newly created usage record and decrement stock.
     */
    public function store(Request $request)
    {
        if (!$request->filled('kode_transaksi')) {
            $request->merge(['kode_transaksi' => $this->generateKodeTransaksi()]);
        }

        $validated = $request->validate([
            'kode_transaksi' => ['required', 'string', 'max:50', 'unique:penggunaan_bahan,kode_transaksi'],
            'bahan_baku_id' => ['required', 'exists:bahan_baku,id'],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'tanggal_penggunaan' => ['required', 'date'],
            'sekolah_id' => ['nullable', 'exists:sekolah,id'],
            'keperluan' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ], [
            'kode_transaksi.required' => 'Kode transaksi wajib diisi.',
            'kode_transaksi.unique' => 'Kode transaksi sudah digunakan.',
            'bahan_baku_id.required' => 'Pilih bahan baku yang digunakan.',
            'jumlah.required' => 'Jumlah pemakaian wajib diisi.',
            'jumlah.min' => 'Jumlah pemakaian minimal 0.01.',
            'tanggal_penggunaan.required' => 'Tanggal penggunaan wajib diisi.',
        ]);

        $bahanBaku = BahanBaku::findOrFail($validated['bahan_baku_id']);

        // Validasi ketersediaan stok fisik
        if ($validated['jumlah'] > $bahanBaku->stok) {
            return back()->withErrors([
                'jumlah' => "Stok '{$bahanBaku->nama_bahan}' tidak mencukupi! Stok yang tersedia saat ini hanya " . number_format($bahanBaku->stok, 2, ',', '.') . " {$bahanBaku->satuan}."
            ])->withInput();
        }

        DB::transaction(function () use ($validated, $bahanBaku) {
            PenggunaanBahan::create($validated);

            // Mutasi stok berkurang otomatis
            $bahanBaku->decrement('stok', $validated['jumlah']);
        });

        return redirect()
            ->route('penggunaan-bahan.index')
            ->with('success', "Penggunaan bahan {$bahanBaku->nama_bahan} berhasil dicatat dan stok otomatis berkurang.");
    }

    /**
     * Remove the specified usage record and revert stock decrement.
     */
    public function destroy(PenggunaanBahan $penggunaanBahan)
    {
        DB::transaction(function () use ($penggunaanBahan) {
            $bahanBaku = $penggunaanBahan->bahanBaku;
            if ($bahanBaku) {
                // Kembalikan stok yang sebelumnya dikurangi
                $bahanBaku->increment('stok', $penggunaanBahan->jumlah);
            }
            $penggunaanBahan->delete();
        });

        return redirect()
            ->route('penggunaan-bahan.index')
            ->with('success', 'Catatan penggunaan bahan berhasil dihapus dan mutasi stok dikembalikan.');
    }
}
