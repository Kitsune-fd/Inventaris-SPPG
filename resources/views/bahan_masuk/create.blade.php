@extends('layouts.layouts_app')

@section('title', 'Catat Bahan Masuk')

@section('breadcrumb')
    <a href="{{ route('bahan-masuk.index') }}" class="text-decoration-none">Bahan Masuk</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Catat Penerimaan</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-1 fw-semibold">Catat Penerimaan Bahan Masuk</h5>
        <p class="text-muted small mb-0">Input penerimaan bahan untuk menambah saldo stok secara otomatis</p>
    </div>

    <div class="card-body">
        <form action="{{ route('bahan-masuk.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label d-flex align-items-center justify-content-between">
                        <span>Kode Transaksi <span class="text-danger">*</span></span>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small">Dibuat Otomatis</span>
                    </label>
                    <input
                        type="text"
                        name="kode_transaksi"
                        class="form-control font-monospace bg-light @error('kode_transaksi') is-invalid @enderror"
                        value="{{ old('kode_transaksi', $kodeTransaksi) }}"
                        readonly
                        required>
                    @error('kode_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                    <input
                        type="date"
                        name="tanggal_masuk"
                        class="form-control @error('tanggal_masuk') is-invalid @enderror"
                        value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                        required>
                    @error('tanggal_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Bahan Baku <span class="text-danger">*</span></label>
                    <select
                        name="bahan_baku_id"
                        id="bahanBakuSelect"
                        class="form-select @error('bahan_baku_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Bahan Baku --</option>
                        @foreach ($bahanBaku as $item)
                            <option
                                value="{{ $item->id }}"
                                data-satuan="{{ $item->satuan }}"
                                data-stok="{{ $item->stok }}"
                                {{ old('bahan_baku_id', $selectedBahanId) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_bahan }} ({{ $item->kode_bahan }}) — Stok Saat Ini: {{ number_format($item->stok, 2) }} {{ $item->satuan }}
                            </option>
                        @endforeach
                    </select>
                    @error('bahan_baku_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah') }}"
                            placeholder="0.00"
                            required>
                        <span class="input-group-text" id="satuanLabel">Satuan</span>
                    </div>
                    @error('jumlah')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Keterangan / Catatan Penerimaan</label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Contoh: Pengiriman pagi dari pasar, bahan sisa olahan kemarin dicatat kembali, dll.">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('bahan-masuk.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan & Tambah Stok
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('bahanBakuSelect');
        const satuanLabel = document.getElementById('satuanLabel');

        function updateSatuan() {
            const selected = select.options[select.selectedIndex];
            if (selected && selected.dataset.satuan) {
                satuanLabel.textContent = selected.dataset.satuan;
            } else {
                satuanLabel.textContent = 'Satuan';
            }
        }

        select.addEventListener('change', updateSatuan);
        updateSatuan();
    });
</script>
@endsection
