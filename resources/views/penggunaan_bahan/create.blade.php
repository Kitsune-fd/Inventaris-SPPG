@extends('layouts.layouts_app')

@section('title', 'Catat Penggunaan Bahan')

@section('breadcrumb')
    <a href="{{ route('penggunaan-bahan.index') }}" class="text-decoration-none">Penggunaan Bahan</a>
    <span class="mx-2">/</span>
    <span class="bc-current">Catat Pemakaian</span>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-1 fw-semibold">Catat Pemakaian / Pengolahan Bahan</h5>
        <p class="text-muted small mb-0">Input pemakaian bahan untuk pengolahan menu gizi harian yang otomatis memotong stok</p>
    </div>

    <div class="card-body">
        <form action="{{ route('penggunaan-bahan.store') }}" method="POST">
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
                    <label class="form-label">Tanggal Penggunaan <span class="text-danger">*</span></label>
                    <input
                        type="date"
                        name="tanggal_penggunaan"
                        class="form-control @error('tanggal_penggunaan') is-invalid @enderror"
                        value="{{ old('tanggal_penggunaan', date('Y-m-d')) }}"
                        required>
                    @error('tanggal_penggunaan')
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
                                {{ $item->nama_bahan }} ({{ $item->kode_bahan }}) — Stok: {{ number_format($item->stok, 2) }} {{ $item->satuan }}
                            </option>
                        @endforeach
                    </select>
                    @error('bahan_baku_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="stokNotice" class="form-text mt-1 text-primary fw-medium"></div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Pemakaian <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="jumlah"
                            id="jumlahInput"
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

                <div class="col-md-6 mb-3">
                    <label class="form-label">Sekolah Penerima (Opsional)</label>
                    <select
                        name="sekolah_id"
                        class="form-select @error('sekolah_id') is-invalid @enderror">
                        <option value="">-- Dapur Umum / Pengolahan Bersama --</option>
                        @foreach ($sekolah as $sek)
                            <option
                                value="{{ $sek->id }}"
                                {{ old('sekolah_id') == $sek->id ? 'selected' : '' }}>
                                {{ $sek->nama_sekolah }} ({{ $sek->kecamatan ? $sek->kecamatan . ' - ' : '' }}{{ $sek->jenjang }})
                            </option>
                        @endforeach
                    </select>
                    @error('sekolah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Pilih sekolah jika bahan digunakan khusus untuk distribusi sekolah tertentu.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Keperluan / Nama Menu</label>
                    <input
                        type="text"
                        name="keperluan"
                        class="form-control @error('keperluan') is-invalid @enderror"
                        value="{{ old('keperluan') }}"
                        placeholder="Contoh: Menu Siang (Nasi + Ayam Sayur)">
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Keterangan / Catatan Tambahan</label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Catatan penggunaan atau informasi lainnya...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('penggunaan-bahan.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan & Kurangi Stok
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('bahanBakuSelect');
        const satuanLabel = document.getElementById('satuanLabel');
        const stokNotice = document.getElementById('stokNotice');
        const jumlahInput = document.getElementById('jumlahInput');

        function updateBahanInfo() {
            const selected = select.options[select.selectedIndex];
            if (selected && selected.value) {
                const satuan = selected.dataset.satuan || 'Satuan';
                const stok = parseFloat(selected.dataset.stok || 0);

                satuanLabel.textContent = satuan;
                stokNotice.innerHTML = `<i class="bi bi-info-circle me-1"></i>Stok tersedia saat ini: <strong>${stok.toLocaleString('id-ID')} ${satuan}</strong>`;
                jumlahInput.max = stok;
            } else {
                satuanLabel.textContent = 'Satuan';
                stokNotice.innerHTML = '';
                jumlahInput.removeAttribute('max');
            }
        }

        select.addEventListener('change', updateBahanInfo);
        updateBahanInfo();
    });
</script>
@endsection
