@extends('layouts.layouts_app')

@section('title', 'Sekolah Penerima')

@section('breadcrumb')
    <span class="bc-current">Sekolah Penerima</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-1 fw-semibold">Data Sekolah Penerima</h5>
            <p class="text-muted small mb-0">Daftar lembaga / sekolah tujuan penyaluran makanan bergizi SPPG</p>
        </div>

        <a href="{{ route('sekolah.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Tambah Sekolah
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('sekolah.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-5">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari NPSN, nama sekolah, atau kecamatan..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>

                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('sekolah.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th width="12%">NPSN</th>
                        <th>Nama Sekolah</th>
                        <th width="10%" class="text-center">Jenjang</th>
                        <th width="18%">Kecamatan</th>
                        <th>Alamat</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="14%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sekolah as $item)
                    <tr>
                        <td class="text-center">{{ $sekolah->firstItem() ? ($sekolah->firstItem() + $loop->index) : $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-secondary font-monospace">{{ $item->npsn }}</span>
                        </td>
                        <td class="fw-semibold text-dark">{{ $item->nama_sekolah }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $item->jenjang }}</span>
                        </td>
                        <td>{{ $item->kecamatan ?: '-' }}</td>
                        <td class="text-muted small">{{ $item->alamat ?: '-' }}</td>
                        <td class="text-center">
                            @if($item->status === 'aktif')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="bi bi-check-circle me-1"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                    <i class="bi bi-x-circle me-1"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('sekolah.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm text-white" title="Ubah Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('sekolah.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah {{ $item->nama_sekolah }}?');">
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
                        <td colspan="8" class="text-center py-4 text-muted">
                            <div class="py-3">
                                <i class="bi bi-building-slash fs-1 text-secondary d-block mb-2"></i>
                                <span>Data sekolah penerima belum tersedia.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $sekolah->links() }}
        </div>
    </div>
</div>
@endsection
