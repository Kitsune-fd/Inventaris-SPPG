@extends('layouts.layouts_app')

@section('title', 'Bahan Masuk')

@section('breadcrumb')
    <span class="bc-current">Bahan Masuk</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
        <div>
            <h5 class="mb-1 fw-semibold">Riwayat Bahan Masuk</h5>
            <p class="text-muted small mb-0">Penerimaan pengiriman harian dan pencatatan sisa bahan yang menambah saldo stok</p>
        </div>

        <a href="{{ route('bahan-masuk.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Catat Bahan Masuk
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('bahan-masuk.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari kode transaksi atau nama bahan..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <input type="date"
                           name="tanggal_dari"
                           class="form-control"
                           value="{{ request('tanggal_dari') }}"
                           placeholder="Dari tanggal">
                </div>

                <div class="col-md-2">
                    <input type="date"
                           name="tanggal_sampai"
                           class="form-control"
                           value="{{ request('tanggal_sampai') }}"
                           placeholder="Sampai tanggal">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                </div>

                @if(request('search') || request('tanggal_dari') || request('tanggal_sampai'))
                    <div class="col-md-2">
                        <a href="{{ route('bahan-masuk.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th>Tanggal Masuk</th>
                        <th>Kode Transaksi</th>
                        <th>Bahan Baku</th>
                        <th>Kategori</th>
                        <th class="text-end">Jumlah Masuk</th>
                        <th>Keterangan</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bahanMasuk as $item)
                        <tr>
                            <td class="text-center">{{ $bahanMasuk->firstItem() ? ($bahanMasuk->firstItem() + $loop->index) : $loop->iteration }}</td>
                            <td>{{ $item->tanggal_masuk ? $item->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                            <td><span class="badge bg-secondary font-monospace">{{ $item->kode_transaksi }}</span></td>
                            <td class="fw-semibold">
                                {{ $item->bahanBaku->nama_bahan ?? 'Bahan Dihapus' }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->bahanBaku->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="text-end fw-bold text-success">
                                +{{ number_format($item->jumlah, 2, ',', '.') }} {{ $item->bahanBaku->satuan ?? '' }}
                            </td>
                            <td class="text-muted small">
                                {{ $item->keterangan ?: '-' }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('bahan-masuk.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan bahan masuk ini? Stok bahan akan otomatis dikurangi kembali.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Catatan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Belum ada catatan bahan masuk. Klik "Catat Bahan Masuk" untuk menambah penerimaan stok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bahanMasuk->links() }}
        </div>
    </div>
</div>
@endsection
