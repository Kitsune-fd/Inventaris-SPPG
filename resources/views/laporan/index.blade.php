@extends('layouts.layouts_app')

@section('title', 'Laporan Mutasi Stok')

@section('breadcrumb')
    <span class="bc-current">Laporan Mutasi Stok</span>
@endsection

@section('content')
<style>
@media print {
    #sidebar, header, .main-footer, .no-print, .btn, form {
        display: none !important;
    }
    #mainContent {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 20px;
    }
}
.print-header {
    display: none;
}
</style>

<div class="print-header">
    <h3 class="mb-1">SPPG — SATUAN PELAYANAN PEMENUHAN GIZI</h3>
    <h5>LAPORAN MUTASI & STOK BAHAN BAKU</h5>
    <p class="text-muted small">Periode: {{ \Carbon\Carbon::parse($tanggalDari)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSampai)->translatedFormat('d F Y') }}</p>
    <hr>
</div>

<div class="row g-3 mb-4 no-print">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-3">
                <span class="text-muted small">Total Jenis Bahan</span>
                <h3 class="mb-0 fw-bold">{{ $totalJenis }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-3">
                <span class="text-muted small">Stok Tersedia</span>
                <h3 class="mb-0 fw-bold text-success">{{ $totalTersedia }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-3">
                <span class="text-muted small">Stok Habis</span>
                <h3 class="mb-0 fw-bold text-danger">{{ $totalHabis }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-1 fw-semibold">Laporan Mutasi & Ketersediaan Stok</h5>
            <p class="text-muted small mb-0">Rekapitulasi penerimaan bahan masuk, pengeluaran bahan, dan sisa stok fisik</p>
        </div>

        <button onclick="window.print()" class="btn btn-outline-success btn-sm no-print">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
    </div>

    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="mb-4 no-print">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ $tanggalDari }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ $tanggalSampai }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Kategori Bahan</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ $kategoriId == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i> Terapkan
                    </button>
                </div>

                <div class="col-md-1">
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Kode</th>
                        <th>Nama Bahan Baku</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th class="text-end text-success">Total Masuk (Periode)</th>
                        <th class="text-end text-danger">Total Dipakai (Periode)</th>
                        <th class="text-end">Sisa Stok Saat Ini</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bahanList as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><span class="badge bg-secondary font-monospace">{{ $item->kode_bahan }}</span></td>
                            <td class="fw-semibold">{{ $item->nama_bahan }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $item->kategori }}</span></td>
                            <td>{{ $item->satuan }}</td>
                            <td class="text-end text-success fw-medium">
                                {{ $item->total_masuk > 0 ? '+' . number_format($item->total_masuk, 2, ',', '.') : '0' }}
                            </td>
                            <td class="text-end text-danger fw-medium">
                                {{ $item->total_pakai > 0 ? '-' . number_format($item->total_pakai, 2, ',', '.') : '0' }}
                            </td>
                            <td class="text-end fw-bold {{ $item->stok_sekarang > 0 ? 'text-primary' : 'text-danger' }}">
                                {{ number_format($item->stok_sekarang, 2, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if($item->stok_sekarang > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                Tidak ada data bahan baku yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
