<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of bahan baku (Master Catalog).
     */
    public function index(Request $request)
    {
        $query = BahanBaku::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_bahan', 'like', "%{$search}%")
                  ->orWhere('nama_bahan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bahanBaku = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('bahan_baku.index', compact('bahanBaku', 'kategoris'));
    }

    /**
     * Generate Kode Bahan otomatis (contoh: BHN-001, BHN-002, dst).
     */
    protected function generateKodeBahan(): string
    {
        $allCodes = BahanBaku::pluck('kode_bahan')->toArray();
        $maxNum = 0;

        foreach ($allCodes as $code) {
            if (preg_match('/^BHN-(\d+)$/i', $code, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }

        $next = $maxNum + 1;
        $candidate = 'BHN-' . str_pad($next, 3, '0', STR_PAD_LEFT);

        while (BahanBaku::where('kode_bahan', $candidate)->exists()) {
            $next++;
            $candidate = 'BHN-' . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    /**
     * Show the form for creating a new bahan baku.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $kodeBahan = $this->generateKodeBahan();

        return view('bahan_baku.create', compact('kategori', 'kodeBahan'));
    }

    /**
     * Store a newly created bahan baku in storage.
     */
    public function store(Request $request)
    {
        // Jika kode_bahan kosong, generate otomatis
        if (!$request->filled('kode_bahan')) {
            $request->merge(['kode_bahan' => $this->generateKodeBahan()]);
        }

        $validated = $request->validate([
            'kode_bahan' => ['required', 'string', 'max:50', 'unique:bahan_baku,kode_bahan'],
            'nama_bahan' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'satuan' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_bahan.required' => 'Kode bahan baku wajib diisi.',
            'kode_bahan.unique' => 'Kode bahan baku sudah terdaftar.',
            'nama_bahan.required' => 'Nama bahan baku wajib diisi.',
            'kategori_id.required' => 'Pilih kategori bahan baku.',
            'satuan.required' => 'Satuan bahan baku wajib diisi.',
        ]);

        $validated['stok'] = 0; // Stok awal 0, diisi melalui menu Bahan Masuk

        BahanBaku::create($validated);

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Bahan baku baru berhasil ditambahkan ke katalog.');
    }

    /**
     * Display the specified bahan baku.
     */
    public function show(BahanBaku $bahanBaku)
    {
        $bahanBaku->load(['kategori', 'bahanMasuk' => fn($q) => $q->latest()->take(5), 'penggunaanBahan' => fn($q) => $q->latest()->take(5)]);

        return view('bahan_baku.show', compact('bahanBaku'));
    }

    /**
     * Show the form for editing the specified bahan baku.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('bahan_baku.edit', compact('bahanBaku', 'kategori'));
    }

    /**
     * Update the specified bahan baku in storage.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        $validated = $request->validate([
            'kode_bahan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bahan_baku', 'kode_bahan')->ignore($bahanBaku->id),
            ],
            'nama_bahan' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'satuan' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_bahan.required' => 'Kode bahan baku wajib diisi.',
            'kode_bahan.unique' => 'Kode bahan baku sudah terdaftar.',
            'nama_bahan.required' => 'Nama bahan baku wajib diisi.',
            'kategori_id.required' => 'Pilih kategori bahan baku.',
            'satuan.required' => 'Satuan bahan baku wajib diisi.',
        ]);

        $bahanBaku->update($validated);

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Data bahan baku berhasil diperbarui.');
    }

    /**
     * Remove the specified bahan baku from storage.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        if ($bahanBaku->bahanMasuk()->exists() || $bahanBaku->penggunaanBahan()->exists()) {
            return redirect()
                ->route('bahan-baku.index')
                ->with('error', 'Bahan baku tidak dapat dihapus karena memiliki riwayat transaksi bahan masuk atau penggunaan.');
        }

        $bahanBaku->delete();

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil dihapus dari katalog.');
    }
}
