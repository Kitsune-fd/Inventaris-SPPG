@extends('layouts.layouts_app')

@section('title', 'Stok Bahan')

@section('breadcrumb')
    <span class="bc-current">Stok Bahan</span>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary me-3">
                    <i class="bi bi-boxes fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1">Total Jenis Bahan</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalJenis }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success me-3">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1">Bahan Tersedia</h6>
                    <h3 class="mb-0 fw-bold text-success">{{ $totalTersedia }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger me-3">
                    <i class="bi bi-exclamation-octagon fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1">Bahan Habis / Kosong</h6>
                    <h3 class="mb-0 fw-bold text-danger">{{ $totalHabis }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-1 fw-semibold">Pemantauan Stok Bahan Baku</h5>
            <p class="text-muted small mb-0">Perhitungan stok otomatis dari akumulasi bahan masuk dan pemakaian harian</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('bahan-masuk.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Catat Bahan Masuk
            </a>
            <a href="{{ route('penggunaan-bahan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-dash-lg me-1"></i> Catat Penggunaan
            </a>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('stok-bahan.index') }}" method="GET" class="mb-4">
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
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia (> 0)</option>
                        <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis (0)</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                @if(request('search') || request('kategori_id') || request('status'))
                    <div class="col-md-2">
                        <a href="{{ route('stok-bahan.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th width="15%">Kode Bahan</th>
                        <th>Nama Bahan Baku</th>
                        <th>Kategori</th>
                        <th width="18%" class="text-end">Stok Tersedia</th>
                        <th width="12%" class="text-center">Status</th>
                        <th width="18%" class="text-center">Aksi Cepat</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($stokBahan as $item)
                        <tr>
                            <td class="text-center">{{ $stokBahan->firstItem() ? ($stokBahan->firstItem() + $loop->index) : $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-secondary font-monospace">
                                    {{ $item->kode_bahan }}
                                </span>
                            </td>
                            <td class="fw-semibold">
                                <a href="{{ route('bahan-baku.show', $item->id) }}" class="text-decoration-none text-dark">
                                    {{ $item->nama_bahan }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold fs-6 {{ $item->stok > 0 ? 'text-primary' : 'text-danger' }}">
                                    {{ number_format($item->stok, 2, ',', '.') }}
                                </span>
                                <span class="text-muted small ms-1">{{ $item->satuan }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->stok > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('bahan-masuk.create', ['bahan_baku_id' => $item->id]) }}" 
                                       class="btn btn-outline-success btn-sm py-1 px-2" title="Tambah Stok (Bahan Masuk)">
                                        <i class="bi bi-box-arrow-in-down"></i> Masuk
                                    </a>
                                    @if($item->stok > 0)
                                        <a href="{{ route('penggunaan-bahan.create', ['bahan_baku_id' => $item->id]) }}" 
                                           class="btn btn-outline-danger btn-sm py-1 px-2" title="Pakai Bahan">
                                            <i class="bi bi-box-arrow-up"></i> Pakai
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Tidak ada data stok bahan yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $stokBahan->links() }}
        </div>
    </div>
</div>
@endsection
