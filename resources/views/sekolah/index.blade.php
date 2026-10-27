@extends('layouts.layouts_app')

@section('title', 'Sekolah Penerima')

@section('breadcrumb')
    <span class="bc-current">Sekolah Penerima</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <h5 class="mb-0 fw-semibold">Data Sekolah Penerima Gizi</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('sekolah.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
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
                        <th width="5%">No</th>
                        <th>NPSN</th>
                        <th>Nama Sekolah</th>
                        <th>Jenjang</th>
                        <th>Kecamatan / Alamat</th>
                        <th>Jumlah Siswa</th>
                        <th>Target Porsi</th>
                        <th>Distribusi</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sekolah as $index => $item)
                    <tr>
                        <td>{{ $sekolah->firstItem() + $index }}</td>
                        <td><span class="badge bg-secondary">{{ $item->npsn }}</span></td>
                        <td class="fw-semibold">{{ $item->nama_sekolah }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->jenjang }}</span></td>
                        <td>{{ $item->kecamatan ?? $item->alamat ?? '-' }}</td>
                        <td>{{ number_format($item->jumlah_siswa) }} siswa</td>
                        <td class="fw-bold text-primary">{{ number_format($item->porsi) }} porsi</td>
                        <td>
                            @if($item->status_distribusi === 'terkirim')
                                <span class="badge bg-success">Terkirim</span>
                            @elseif($item->status_distribusi === 'proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $item->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            Data sekolah penerima belum tersedia.
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
