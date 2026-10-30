@extends('layouts.layouts_app')

@section('title', 'Katalog Bahan Baku')

@section('breadcrumb')
    <span class="bc-current">Katalog Bahan Baku</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-1 fw-semibold">Master Data Bahan Baku</h5>
            <p class="text-muted small mb-0">Daftar katalog bahan baku makanan untuk pelayanan gizi</p>
        </div>

        <a href="{{ route('bahan-baku.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Tambah Bahan
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('bahan-baku.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control"
                        placeholder="Cari kode atau nama bahan..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>

                @if(request('search') || request('kategori_id'))
                    <div class="col-md-2">
                        <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary w-100">
                            Reset
                        </a>
                    </div>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">Kode</th>
                        <th>Nama Bahan Baku</th>
                        <th>Kategori</th>
                        <th>Satuan Ukur</th>
                        <th>Keterangan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bahanBaku as $item)
                        <tr>
                            <td class="text-center">{{ $bahanBaku->firstItem() ? ($bahanBaku->firstItem() + $loop->index) : $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-secondary font-monospace">
                                    {{ $item->kode_bahan }}
                                </span>
                            </td>
                            <td class="fw-semibold text-dark">
                                {{ $item->nama_bahan }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-medium text-primary">
                                    {{ $item->satuan }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $item->deskripsi ?: '-' }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('bahan-baku.show', $item->id) }}"
                                        class="btn btn-info btn-sm text-white" title="Detail Bahan">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('bahan-baku.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm text-white" title="Ubah Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('bahan-baku.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan baku ini dari katalog?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Data bahan baku belum tersedia. Silakan klik tombol "Tambah Bahan" di atas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bahanBaku->links() }}
        </div>
    </div>
</div>
@endsection
