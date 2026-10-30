@extends('layouts.layouts_app')

@section('title', 'Tambah Bahan Baku')

@section('breadcrumb')
    <a href="{{ route('bahan-baku.index') }}" class="text-decoration-none">Bahan Baku</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Tambah Bahan</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Tambah Katalog Bahan Baku</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('bahan-baku.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label d-flex align-items-center justify-content-between">
                        <span>Kode Bahan <span class="text-danger">*</span></span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small">Dibuat Otomatis</span>
                    </label>
                    <input
                        type="text"
                        name="kode_bahan"
                        class="form-control font-monospace bg-light @error('kode_bahan') is-invalid @enderror"
                        value="{{ old('kode_bahan', $kodeBahan) }}"
                        readonly
                        required>
                    @error('kode_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nama_bahan"
                        class="form-control @error('nama_bahan') is-invalid @enderror"
                        value="{{ old('nama_bahan') }}"
                        placeholder="Contoh: Beras Premium / Telur Ayam"
                        required autofocus>
                    @error('nama_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select
                        name="kategori_id"
                        class="form-select @error('kategori_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $item)
                            <option
                                value="{{ $item->id }}"
                                {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan Ukur <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="satuan"
                        class="form-control @error('satuan') is-invalid @enderror"
                        value="{{ old('satuan') }}"
                        placeholder="Contoh: Kg / Liter / Tray / Ikat / Butir"
                        required>
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi / Catatan Tambahan</label>
                    <textarea
                        name="deskripsi"
                        rows="3"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Catatan spesifikasi atau penanganan bahan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="alert alert-info py-2 small d-flex align-items-center">
                <i class="bi bi-info-circle-fill fs-5 me-2"></i>
                <span>Jumlah stok bahan akan otomatis bertambah saat Anda mencatat transaksi pada menu <strong>Bahan Masuk</strong>.</span>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan Bahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
