@extends('layouts.layouts_app')

@section('title', 'Ubah Supplier')

@section('breadcrumb')
    <a href="{{ route('supplier.index') }}" class="text-decoration-none">Supplier</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Ubah Data</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Ubah Data Supplier</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Supplier <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="kode_supplier"
                        class="form-control @error('kode_supplier') is-invalid @enderror"
                        value="{{ old('kode_supplier', $supplier->kode_supplier) }}"
                        placeholder="Contoh: SUP-001"
                        required>
                    @error('kode_supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Supplier / Perusahaan <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nama_supplier"
                        class="form-control @error('nama_supplier') is-invalid @enderror"
                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                        placeholder="Contoh: PT Sumber Pangan Makmur"
                        required>
                    @error('nama_supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Nomor Telepon / Kontak</label>
                    <input
                        type="text"
                        name="telepon"
                        class="form-control @error('telepon') is-invalid @enderror"
                        value="{{ old('telepon', $supplier->telepon) }}"
                        placeholder="Contoh: 081234567890">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea
                        name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Masukkan alamat gudang atau kantor supplier...">{{ old('alamat', $supplier->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">
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
