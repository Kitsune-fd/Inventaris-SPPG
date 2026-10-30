<?php

namespace App\Http\Controllers;

use App\Models\SekolahPenerima;
use Illuminate\Http\Request;

class SekolahPenerimaController extends Controller
{
    /**
     * Display a listing of sekolah penerima.
     */
    public function index(Request $request)
    {
        $query = SekolahPenerima::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }

        $sekolah = $query->latest()->paginate(10)->withQueryString();

        return view('sekolah.index', compact('sekolah'));
    }

    /**
     * Show the form for creating a new sekolah.
     */
    public function create()
    {
        $jenjangList = ['SD', 'MI', 'SMP', 'MTS', 'SMA', 'SMK', 'MA', 'Lainnya'];
        return view('sekolah.create', compact('jenjangList'));
    }

    /**
     * Store a newly created sekolah in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'npsn' => 'required|string|max:50|unique:sekolah,npsn',
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,MI,SMP,MTS,SMA,SMK,MA,Lainnya',
            'kecamatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'npsn.required' => 'NPSN wajib diisi.',
            'npsn.unique' => 'NPSN sudah terdaftar.',
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
            'status.required' => 'Status sekolah wajib dipilih.',
        ]);

        SekolahPenerima::create($validated);

        return redirect()->route('sekolah.index')->with('success', 'Data sekolah penerima berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SekolahPenerima $sekolah)
    {
        return redirect()->route('sekolah.edit', $sekolah->id);
    }

    /**
     * Show the form for editing the specified sekolah.
     */
    public function edit(SekolahPenerima $sekolah)
    {
        $jenjangList = ['SD', 'MI', 'SMP', 'MTS', 'SMA', 'SMK', 'MA', 'Lainnya'];
        return view('sekolah.edit', compact('sekolah', 'jenjangList'));
    }

    /**
     * Update the specified sekolah in storage.
     */
    public function update(Request $request, SekolahPenerima $sekolah)
    {
        $validated = $request->validate([
            'npsn' => 'required|string|max:50|unique:sekolah,npsn,' . $sekolah->id,
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,MI,SMP,MTS,SMA,SMK,MA,Lainnya',
            'kecamatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'npsn.required' => 'NPSN wajib diisi.',
            'npsn.unique' => 'NPSN sudah terdaftar pada sekolah lain.',
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
            'status.required' => 'Status sekolah wajib dipilih.',
        ]);

        $sekolah->update($validated);

        return redirect()->route('sekolah.index')->with('success', 'Data sekolah penerima berhasil diperbarui.');
    }

    /**
     * Remove the specified sekolah from storage.
     */
    public function destroy(SekolahPenerima $sekolah)
    {
        // Proteksi jika sekolah memiliki riwayat penggunaan bahan
        if ($sekolah->penggunaanBahan()->exists()) {
            return redirect()->route('sekolah.index')->with('error', 'Sekolah tidak dapat dihapus karena memiliki riwayat penggunaan bahan.');
        }

        $sekolah->delete();

        return redirect()->route('sekolah.index')->with('success', 'Data sekolah penerima berhasil dihapus.');
    }
}
