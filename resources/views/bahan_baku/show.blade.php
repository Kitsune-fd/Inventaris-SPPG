@extends('layouts.layouts_app')

@section('title', 'Detail Bahan Baku')

@section('breadcrumb')
    <a href="{{ route('bahan-baku.index') }}" class="text-decoration-none">Bahan Baku</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Detail</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0 fw-semibold">Detail Bahan Baku: {{ $bahanBaku->nama_bahan }}</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('bahan-baku.edit', $bahanBaku->id) }}" class="btn btn-warning btn-sm text-white">
                <i class="bi bi-pencil-square me-1"></i> Ubah Data
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <table class="table table-striped table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="35%" class="bg-light">Kode Bahan</th>
                            <td><span class="badge bg-secondary fs-6">{{ $bahanBaku->kode_bahan }}</span></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nama Bahan</th>
                            <td class="fw-semibold">{{ $bahanBaku->nama_bahan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kategori</th>
                            <td>{{ $bahanBaku->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Supplier</th>
                            <td>{{ $bahanBaku->supplier->nama_supplier ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td>
                                @if ($bahanBaku->status === 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table table-striped table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="35%" class="bg-light">Stok Tersedia</th>
                            <td class="fw-bold fs-5 text-primary">{{ number_format($bahanBaku->stok, 2, ',', '.') }} {{ $bahanBaku->satuan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Stok Minimum</th>
                            <td>{{ number_format($bahanBaku->stok_minimum, 2, ',', '.') }} {{ $bahanBaku->satuan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Harga Satuan</th>
                            <td>Rp {{ number_format($bahanBaku->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal Kadaluarsa</th>
                            <td>{{ $bahanBaku->tanggal_expired ? \Carbon\Carbon::parse($bahanBaku->tanggal_expired)->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Terakhir Diperbarui</th>
                            <td>{{ $bahanBaku->updated_at ? $bahanBaku->updated_at->diffForHumans() : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-12">
                <div class="border rounded p-3 bg-light">
                    <h6 class="fw-semibold text-secondary mb-2">Deskripsi / Catatan:</h6>
                    <p class="mb-0 text-muted">{{ $bahanBaku->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
