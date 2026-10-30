<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class StokBahanController extends Controller
{
    /**
     * Display a listing of real-time stock balances.
     */
    public function index(Request $request)
    {
        $query = BahanBaku::with('kategori');

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_bahan', 'like', "%{$search}%")
                  ->orWhere('nama_bahan', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter Status Ketersediaan
        if ($request->filled('status')) {
            if ($request->status === 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->status === 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        // Statistik Stok
        $totalJenis = BahanBaku::count();
        $totalTersedia = BahanBaku::where('stok', '>', 0)->count();
        $totalHabis = BahanBaku::where('stok', '<=', 0)->count();

        $stokBahan = $query->orderBy('stok', 'asc')->paginate(12)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('stok_bahan.index', compact('stokBahan', 'kategoris', 'totalJenis', 'totalTersedia', 'totalHabis'));
    }
}
