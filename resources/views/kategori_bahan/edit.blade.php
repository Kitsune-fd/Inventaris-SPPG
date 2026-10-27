@extends('layouts.layouts_app')

@section('title', 'Ubah Kategori')

@section('breadcrumb')
    <a href="{{ route('kategori.index') }}" class="text-decoration-none">Kategori</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Ubah Data</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Ubah Kategori Bahan</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Kategori <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="kode_kategori"
                        class="form-control @error('kode_kategori') is-invalid @enderror"
                        value="{{ old('kode_kategori', $kategori->kode_kategori) }}"
                        placeholder="Contoh: KTG-001"
                        required>
                    @error('kode_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control @error('nama_kategori') is-invalid @enderror"
                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        placeholder="Contoh: Karbohidrat / Protein / Sayuran"
                        required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi / Keterangan</label>
                    <textarea
                        name="deskripsi"
                        rows="3"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="Keterangan kategori bahan makanan...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
