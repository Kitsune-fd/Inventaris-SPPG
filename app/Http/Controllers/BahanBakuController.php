<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of bahan baku.
     */
    public function index(Request $request)
    {
        $query = BahanBaku::with(['kategori', 'supplier']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_bahan', 'like', "%{$search}%")
                  ->orWhere('nama_bahan', 'like', "%{$search}%");
            });
        }

        $bahanBaku = $query->latest()->paginate(10)->withQueryString();

        return view('bahan_baku.index', compact('bahanBaku'));
    }

    /**
     * Show the form for creating a new bahan baku.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $supplier = Supplier::orderBy('nama_supplier')->get();

        return view('bahan_baku.create', compact('kategori', 'supplier'));
    }

    /**
     * Store a newly created bahan baku in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_bahan' => ['required', 'string', 'max:50', 'unique:bahan_baku,kode_bahan'],
            'nama_bahan' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'supplier_id' => ['required', 'exists:supplier,id'],
            'stok' => ['required', 'numeric', 'min:0'],
            'stok_minimum' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['required', 'string', 'max:50'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tanggal_expired' => ['nullable', 'date'],
            'status' => ['required', 'in:tersedia,habis'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_bahan.required' => 'Kode bahan baku wajib diisi.',
            'kode_bahan.unique' => 'Kode bahan baku sudah digunakan.',
            'nama_bahan.required' => 'Nama bahan baku wajib diisi.',
            'kategori_id.required' => 'Pilih kategori bahan baku.',
            'supplier_id.required' => 'Pilih supplier bahan baku.',
            'stok.required' => 'Jumlah stok wajib diisi.',
            'satuan.required' => 'Satuan bahan baku wajib diisi.',
            'harga.required' => 'Harga bahan baku wajib diisi.',
        ]);

        $validated['stok_minimum'] = $validated['stok_minimum'] ?? 0;

        BahanBaku::create($validated);

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Data bahan baku berhasil ditambahkan.');
    }

    /**
     * Display the specified bahan baku.
     */
    public function show(BahanBaku $bahanBaku)
    {
        $bahanBaku->load(['kategori', 'supplier']);

        return view('bahan_baku.show', compact('bahanBaku'));
    }

    /**
     * Show the form for editing the specified bahan baku.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $supplier = Supplier::orderBy('nama_supplier')->get();

        return view('bahan_baku.edit', compact('bahanBaku', 'kategori', 'supplier'));
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
            'supplier_id' => ['required', 'exists:supplier,id'],
            'stok' => ['required', 'numeric', 'min:0'],
            'stok_minimum' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['required', 'string', 'max:50'],
            'harga' => ['required', 'numeric', 'min:0'],
            'tanggal_expired' => ['nullable', 'date'],
            'status' => ['required', 'in:tersedia,habis'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_bahan.required' => 'Kode bahan baku wajib diisi.',
            'kode_bahan.unique' => 'Kode bahan baku sudah digunakan.',
            'nama_bahan.required' => 'Nama bahan baku wajib diisi.',
            'kategori_id.required' => 'Pilih kategori bahan baku.',
            'supplier_id.required' => 'Pilih supplier bahan baku.',
            'stok.required' => 'Jumlah stok wajib diisi.',
            'satuan.required' => 'Satuan bahan baku wajib diisi.',
            'harga.required' => 'Harga bahan baku wajib diisi.',
        ]);

        $validated['stok_minimum'] = $validated['stok_minimum'] ?? 0;

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
        $bahanBaku->delete();

        return redirect()
            ->route('bahan-baku.index')
            ->with('success', 'Data bahan baku berhasil dihapus.');
    }
}
