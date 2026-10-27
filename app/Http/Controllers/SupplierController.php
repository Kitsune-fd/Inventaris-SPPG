<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of supplier.
     */
    public function index(Request $request)
    {
        $query = Supplier::withCount('bahanBaku');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_supplier', 'like', "%{$search}%")
                  ->orWhere('kode_supplier', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('supplier_bahan.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('supplier_bahan.create');
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_supplier' => ['required', 'string', 'max:50', 'unique:supplier,kode_supplier'],
            'nama_supplier' => ['required', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
        ], [
            'kode_supplier.required' => 'Kode supplier wajib diisi.',
            'kode_supplier.unique' => 'Kode supplier sudah digunakan.',
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Data supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified supplier.
     */
    public function show(Supplier $supplier)
    {
        return redirect()->route('supplier.edit', $supplier->id);
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier_bahan.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'kode_supplier' => [
                'required',
                'string',
                'max:50',
                Rule::unique('supplier', 'kode_supplier')->ignore($supplier->id),
            ],
            'nama_supplier' => ['required', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
        ], [
            'kode_supplier.required' => 'Kode supplier wajib diisi.',
            'kode_supplier.unique' => 'Kode supplier sudah digunakan.',
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if ($supplier->bahanBaku()->exists()) {
            return redirect()
                ->route('supplier.index')
                ->with('error', 'Supplier tidak dapat dihapus karena masih terikat dengan data bahan baku.');
        }

        $supplier->delete();

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Data supplier berhasil dihapus.');
    }
}
