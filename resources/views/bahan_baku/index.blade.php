@extends('layouts.layouts_app')

@section('title', 'Bahan Baku')

@section('breadcrumb')
    <span class="bc-current">Bahan Baku</span>
@endsection

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-0 fw-semibold">Data Bahan Baku</h5>
        </div>

        <a href="{{ route('bahan-baku.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Bahan Baku
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

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </div>

                @if(request('search'))
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
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Bahan</th>
                        <th>Stok</th>
                        <th>Stok Minimum</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Expired</th>
                        <th>Status</th>
                        <th width="18%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bahanBaku as $item)
                        <tr>
                            <td>{{ $bahanBaku->firstItem() ? ($bahanBaku->firstItem() + $loop->index) : $loop->iteration }}</td>

                            <td>
                                <span class="fw-semibold">
                                    {{ $item->kode_bahan }}
                                </span>
                            </td>

                            <td>
                                {{ $item->nama_bahan }}
                            </td>

                            <td>
                                {{ number_format($item->stok, 2) }}
                            </td>

                            <td>
                                {{ number_format($item->stok_minimum, 2) }}
                            </td>

                            <td>
                                {{ $item->satuan }}
                            </td>

                            <td>
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->tanggal_expired ?? '-' }}
                            </td>

                            <td>
                                @if ($item->status == 'tersedia')
                                    <span class="badge bg-success">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    <a href="{{ route('bahan-baku.show', $item->id) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('bahan-baku.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm text-white">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('bahan-baku.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                Data bahan baku belum tersedia
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