<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Display a listing of kategori.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('bahanBaku');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('kode_kategori', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->latest()->paginate(10)->withQueryString();

        return view('kategori_bahan.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new kategori.
     */
    public function create()
    {
        return view('kategori_bahan.create');
    }

    /**
     * Store a newly created kategori in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:50', 'unique:kategori,kode_kategori'],
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified kategori.
     */
    public function show(Kategori $kategori)
    {
        return redirect()->route('kategori.edit', $kategori->id);
    }

    /**
     * Show the form for editing the specified kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori_bahan.edit', compact('kategori'));
    }

    /**
     * Update the specified kategori in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'kode_kategori' => [
                'required',
                'string',
                'max:50',
                Rule::unique('kategori', 'kode_kategori')->ignore($kategori->id),
            ],
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique' => 'Kode kategori sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified kategori from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->bahanBaku()->exists()) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan pada data bahan baku.');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data kategori berhasil dihapus.');
    }
}
