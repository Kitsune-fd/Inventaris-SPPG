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
}
