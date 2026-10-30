<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\BahanMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanMasukController extends Controller
{
    /**
     * Display a listing of incoming ingredients transactions.
     */
    public function index(Request $request)
    {
        $query = BahanMasuk::with('bahanBaku.kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('bahanBaku', function ($b) use ($search) {
                      $b->where('nama_bahan', 'like', "%{$search}%")
                        ->orWhere('kode_bahan', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_masuk', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_masuk', '<=', $request->tanggal_sampai);
        }

        $bahanMasuk = $query->latest('tanggal_masuk')->latest('id')->paginate(10)->withQueryString();

        return view('bahan_masuk.index', compact('bahanMasuk'));
    }

    /**
     * Generate Kode Transaksi Bahan Masuk otomatis (contoh: BM-20261030-001).
     */
    protected function generateKodeTransaksi(): string
    {
        $prefix = 'BM-' . date('Ymd') . '-';
        $allCodes = BahanMasuk::where('kode_transaksi', 'like', "{$prefix}%")->pluck('kode_transaksi')->toArray();
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

        while (BahanMasuk::where('kode_transaksi', $candidate)->exists()) {
            $next++;
            $candidate = $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    /**
     * Show the form for creating a new incoming shipment.
     */
    public function create(Request $request)
    {
        $bahanBaku = BahanBaku::with('kategori')->orderBy('nama_bahan')->get();
        $selectedBahanId = $request->query('bahan_baku_id');
        $kodeTransaksi = $this->generateKodeTransaksi();

        return view('bahan_masuk.create', compact('bahanBaku', 'selectedBahanId', 'kodeTransaksi'));
    }

    /**
     * Store a newly created incoming transaction and increment stock.
     */
    public function store(Request $request)
    {
        if (!$request->filled('kode_transaksi')) {
            $request->merge(['kode_transaksi' => $this->generateKodeTransaksi()]);
        }

        $validated = $request->validate([
            'kode_transaksi' => ['required', 'string', 'max:50', 'unique:bahan_masuk,kode_transaksi'],
            'bahan_baku_id' => ['required', 'exists:bahan_baku,id'],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'tanggal_masuk' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ], [
            'kode_transaksi.required' => 'Kode transaksi wajib diisi.',
            'kode_transaksi.unique' => 'Kode transaksi sudah digunakan.',
            'bahan_baku_id.required' => 'Pilih bahan baku yang masuk.',
            'jumlah.required' => 'Jumlah bahan masuk wajib diisi.',
            'jumlah.min' => 'Jumlah bahan masuk minimal 0.01.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
        ]);

        DB::transaction(function () use ($validated) {
            $bahanMasuk = BahanMasuk::create($validated);

            // Mutasi stok bertambah otomatis
            $bahanBaku = BahanBaku::findOrFail($validated['bahan_baku_id']);
            $bahanBaku->increment('stok', $validated['jumlah']);
        });

        return redirect()
            ->route('bahan-masuk.index')
            ->with('success', 'Catatan bahan masuk berhasil disimpan dan stok otomatis bertambah.');
    }

    /**
     * Remove the specified incoming shipment and revert stock increment.
     */
    public function destroy(BahanMasuk $bahanMasuk)
    {
        DB::transaction(function () use ($bahanMasuk) {
            $bahanBaku = $bahanMasuk->bahanBaku;
            if ($bahanBaku) {
                // Revert penambahan stok
                $bahanBaku->decrement('stok', min($bahanBaku->stok, $bahanMasuk->jumlah));
            }
            $bahanMasuk->delete();
        });

        return redirect()
            ->route('bahan-masuk.index')
            ->with('success', 'Data bahan masuk berhasil dihapus dan mutasi stok dikembalikan.');
    }
}
