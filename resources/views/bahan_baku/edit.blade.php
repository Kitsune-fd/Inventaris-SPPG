@extends('layouts.layouts_app')

@section('title', 'Ubah Bahan Baku')

@section('breadcrumb')
    <a href="{{ route('bahan-baku.index') }}" class="text-decoration-none">Bahan Baku</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Ubah Data</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Ubah Katalog Bahan Baku</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('bahan-baku.update', $bahanBaku->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Bahan <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="kode_bahan"
                        class="form-control @error('kode_bahan') is-invalid @enderror"
                        value="{{ old('kode_bahan', $bahanBaku->kode_bahan) }}"
                        placeholder="Contoh: BHN-001"
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
                        value="{{ old('nama_bahan', $bahanBaku->nama_bahan) }}"
                        placeholder="Contoh: Beras Premium"
                        required>
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
                                {{ old('kategori_id', $bahanBaku->kategori_id) == $item->id ? 'selected' : '' }}>
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
                        value="{{ old('satuan', $bahanBaku->satuan) }}"
                        placeholder="Contoh: Kg / Liter / Tray"
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
                        placeholder="Catatan spesifikasi atau penanganan bahan...">{{ old('deskripsi', $bahanBaku->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary">
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
