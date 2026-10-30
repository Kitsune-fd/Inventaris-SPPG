@extends('layouts.layouts_app')

@section('title', 'Detail Bahan Baku')

@section('breadcrumb')
    <a href="{{ route('bahan-baku.index') }}" class="text-decoration-none">Bahan Baku</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Detail</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-1 fw-semibold">{{ $bahanBaku->nama_bahan }}</h5>
            <span class="badge bg-secondary font-monospace">{{ $bahanBaku->kode_bahan }}</span>
            <span class="badge bg-light text-dark border">{{ $bahanBaku->kategori->nama_kategori ?? 'Umum' }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
            </a>
            <a href="{{ route('bahan-baku.edit', $bahanBaku->id) }}" class="btn btn-warning btn-sm text-white">
                <i class="bi bi-pencil-square me-1"></i> Ubah Data
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-3 border rounded bg-light text-center h-100 d-flex flex-column justify-content-center">
                    <span class="text-muted small text-uppercase fw-bold">Stok Tersedia Saat Ini</span>
                    <h2 class="display-6 fw-bold text-primary my-2">
                        {{ number_format($bahanBaku->stok, 2, ',', '.') }}
                    </h2>
                    <span class="badge {{ $bahanBaku->stok > 0 ? 'bg-success' : 'bg-danger' }} fs-6 mx-auto">
                        {{ $bahanBaku->satuan }} ({{ $bahanBaku->stok > 0 ? 'Tersedia' : 'Habis' }})
                    </span>
                </div>
            </div>

            <div class="col-md-8">
                <table class="table table-bordered align-middle mb-0">
                    <tbody>
                        <tr>
                            <th width="30%" class="bg-light">Kode Bahan</th>
                            <td class="font-monospace fw-bold">{{ $bahanBaku->kode_bahan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nama Bahan</th>
                            <td class="fw-semibold">{{ $bahanBaku->nama_bahan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kategori</th>
                            <td>{{ $bahanBaku->kategori->nama_kategori ?? 'Umum' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Satuan Ukur</th>
                            <td>{{ $bahanBaku->satuan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Keterangan</th>
                            <td class="text-muted">{{ $bahanBaku->deskripsi ?: 'Tidak ada keterangan tambahan.' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Terdaftar Pada</th>
                            <td>{{ $bahanBaku->created_at ? $bahanBaku->created_at->translatedFormat('d F Y H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Riwayat Bahan Masuk Terbaru --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="bi bi-box-arrow-in-down me-1"></i> 5 Penerimaan Terakhir
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanBaku->bahanMasuk as $bm)
                                <tr>
                                    <td>{{ $bm->tanggal_masuk ? $bm->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                                    <td class="font-monospace small">{{ $bm->kode_transaksi }}</td>
                                    <td class="fw-bold text-success">+{{ number_format($bm->jumlah, 2) }} {{ $bahanBaku->satuan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada riwayat bahan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Penggunaan Bahan Terbaru --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold text-danger">
                    <i class="bi bi-box-arrow-up me-1"></i> 5 Penggunaan Terakhir
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Tujuan / Keperluan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bahanBaku->penggunaanBahan as $pb)
                                <tr>
                                    <td>{{ $pb->tanggal_penggunaan ? $pb->tanggal_penggunaan->format('d/m/Y') : '-' }}</td>
                                    <td class="font-monospace small">{{ $pb->kode_transaksi }}</td>
                                    <td>{{ $pb->sekolah->nama_sekolah ?? $pb->keperluan ?? '-' }}</td>
                                    <td class="fw-bold text-danger">-{{ number_format($pb->jumlah, 2) }} {{ $bahanBaku->satuan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada riwayat penggunaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
