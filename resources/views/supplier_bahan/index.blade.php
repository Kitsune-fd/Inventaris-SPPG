@extends('layouts.layouts_app')

@section('title', 'Supplier Bahan')

@section('breadcrumb')
    <span class="bc-current">Supplier Bahan</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <h5 class="mb-0 fw-semibold">Data Supplier Bahan</h5>

        <a href="{{ route('supplier.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Tambah Supplier
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('supplier.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari kode, nama, atau telepon supplier..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>

                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Supplier</th>
                        <th>Telepon / Kontak</th>
                        <th>Alamat</th>
                        <th>Bahan Terpasok</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($suppliers as $index => $item)
                    <tr>
                        <td>{{ $suppliers->firstItem() + $index }}</td>
                        <td><span class="badge bg-secondary">{{ $item->kode_supplier }}</span></td>
                        <td class="fw-semibold">{{ $item->nama_supplier }}</td>
                        <td>{{ $item->telepon ?: '-' }}</td>
                        <td>{{ $item->alamat ?: '-' }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $item->bahan_baku_count }} Bahan
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('supplier.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Ubah">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('supplier.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');">
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
                            Data supplier belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection
