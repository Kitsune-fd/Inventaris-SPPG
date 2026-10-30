@extends('layouts.layouts_app')

@section('title', 'Tambah Sekolah Penerima')

@section('breadcrumb')
    <a href="{{ route('sekolah.index') }}" class="text-decoration-none">Sekolah Penerima</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Tambah Sekolah</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Tambah Data Sekolah Penerima</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('sekolah.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NPSN (Nomor Pokok Sekolah Nasional) <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="npsn"
                        class="form-control font-monospace @error('npsn') is-invalid @enderror"
                        value="{{ old('npsn') }}"
                        placeholder="Contoh: 102011"
                        required autofocus>
                    @error('npsn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nama_sekolah"
                        class="form-control @error('nama_sekolah') is-invalid @enderror"
                        value="{{ old('nama_sekolah') }}"
                        placeholder="Contoh: SDN 01 Kota Medan"
                        required>
                    @error('nama_sekolah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                    <select
                        name="jenjang"
                        class="form-select @error('jenjang') is-invalid @enderror"
                        required>
                        @foreach ($jenjangList as $item)
                            <option
                                value="{{ $item }}"
                                {{ old('jenjang', 'SD') == $item ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenjang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input
                        type="text"
                        name="kecamatan"
                        class="form-control @error('kecamatan') is-invalid @enderror"
                        value="{{ old('kecamatan') }}"
                        placeholder="Contoh: Medan Kota">
                    @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Status Sekolah <span class="text-danger">*</span></label>
                    <select
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required>
                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif (Menerima Penyaluran)</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif (Tidak Menerima)</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea
                        name="alamat"
                        rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Contoh: Jl. Pemuda No. 12, Medan Kota...">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('sekolah.index') }}" class="btn btn-outline-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan Sekolah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
