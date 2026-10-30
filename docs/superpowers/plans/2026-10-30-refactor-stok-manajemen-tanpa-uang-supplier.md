# Rencana Implementasi: Perombakan Manajemen Stok Tanpa Supplier & Data Uang

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Menghapus entitas Supplier dan seluruh data harga/uang dari aplikasi, menyederhanakan Master Bahan Baku menjadi katalog murni, menambahkan menu Stok Bahan, serta mengimplementasikan pencatatan stok otomatis real-time pada transaksi Bahan Masuk dan Penggunaan Bahan.

**Architecture:** Arsitektur MVC Laravel 10. Master `bahan_baku` menyimpan identitas bahan dan saldo stok saat ini (`stok`). Transaksi `bahan_masuk` dan `penggunaan_bahan` menggunakan `DB::transaction` untuk memutasi saldo stok secara atomik dan konsisten dengan validasi ketat agar stok tidak minus.

**Tech Stack:** Laravel 10, Blade Templates, Bootstrap 5, MySQL / Eloquent ORM.

**Spec:** Diskusi kebutuhan pengguna: penghapusan supplier, pembersihan total data mata uang (Rp), perombakan skema database bahan baku, penambahan menu Stok Bahan, dan otomasi perhitungan stok harian tanpa expired date.

## Global Constraints

- Hapus seluruh kolom, model, controller, rute, seeder, dan tampilan yang berhubungan dengan `Supplier`.
- Hapus seluruh kolom, kalkulasi, dan tampilan harga/rupiah (`harga`, `Rp`, `total_harga`) di seluruh aplikasi.
- Hapus `stok_minimum`, `harga`, dan `tanggal_expired` dari master `bahan_baku`.
- Simpan saldo stok riil pada tabel `bahan_baku.stok` (tipe `decimal(12,2) default 0`) yang dimutasi otomatis oleh transaksi.
- Tambahkan menu baru **Stok Bahan** (`stok-bahan.index`) di bawah seksi "Manajemen Stok" pada sidebar layout.
- Pastikan semua file blade menggunakan `@extends('layouts.layouts_app')`.

## Review Focus

- Transaksi Penggunaan Bahan harus memvalidasi bahwa `jumlah` pemakaian tidak melebihi stok yang tersedia saat itu.
- Penghapusan data transaksi Bahan Masuk atau Penggunaan Bahan harus merefleksikan pengembalian saldo stok (revert) yang tepat.
- Input pencarian dan paginasi pada semua tabel harus mempertahankan parameter query string (`withQueryString()`).
- Relasi Eloquent `bahan_baku` dengan `bahan_masuk` dan `penggunaan_bahan` harus terdefinisi lengkap.
- Dashboard dan Laporan tidak boleh lagi memuat teks, grafik, atau card bertema supplier atau nominal rupiah.

---

### Task 1: Pembersihan Skema Database & Migrasi

**Files:**
- Modify: `database/migrations/2026_05_25_154349_create_bahan_bakus_table.php`
- Delete: `database/migrations/2026_05_25_155037_create_suppliers_table.php`
- Modify: `database/migrations/2026_05_25_155425_foreign_bahan_baku.php`
- Modify: `database/migrations/2026_06_08_141401_create_bahan_masuks_table.php`
- Modify: `database/migrations/2026_06_08_143338_create_penggunaan_bahans_table.php`
- Delete: `database/seeders/SupplierSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Modify: `database/seeders/BahanBakuSeeder.php`

- [x] Perbarui `create_bahan_bakus_table.php`: simpan kolom `id`, `kode_bahan`, `nama_bahan`, `stok`, `satuan`, `deskripsi`, `timestamps`. Hapus kolom `harga`, `stok_minimum`, `tanggal_expired`, dan `status`.
- [x] Hapus file migrasi `create_suppliers_table.php`.
- [x] Perbarui `foreign_bahan_baku.php`: hanya menambahkan foreign key `kategori_id` ke tabel `kategori`. Hapus relasi `supplier_id`.
- [x] Perbarui `create_bahan_masuks_table.php`: kolom `id`, `kode_transaksi`, `bahan_baku_id` (foreign key cascade/restrict), `jumlah`, `tanggal_masuk`, `keterangan`, `timestamps`.
- [x] Perbarui `create_penggunaan_bahans_table.php`: kolom `id`, `kode_transaksi`, `bahan_baku_id` (foreign key), `sekolah_id` (foreign key nullable), `jumlah`, `tanggal_penggunaan`, `keperluan`, `keterangan`, `timestamps`.
- [x] Hapus `database/seeders/SupplierSeeder.php`, perbarui `DatabaseSeeder.php` dan `BahanBakuSeeder.php` agar bebas dari supplier dan harga.

---

### Task 2: Perombakan Model Eloquent

**Files:**
- Delete: `app/Models/Supplier.php`
- Modify: `app/Models/BahanBaku.php`
- Modify: `app/Models/BahanMasuk.php`
- Modify: `app/Models/PenggunaanBahan.php`
- Modify: `app/Models/SekolahPenerima.php`

- [x] Hapus `app/Models/Supplier.php`.
- [x] Perbarui `BahanBaku.php`: hapus relasi `supplier()`, tambahkan relasi `hasMany(BahanMasuk::class)` dan `hasMany(PenggunaanBahan::class)`. Tambahkan accessor helper status stok (`stok > 0 ? 'Tersedia' : 'Habis'`).
- [x] Perbarui `BahanMasuk.php`: tambahkan relasi `belongsTo(BahanBaku::class, 'bahan_baku_id')`.
- [x] Perbarui `PenggunaanBahan.php`: tambahkan relasi `belongsTo(BahanBaku::class, 'bahan_baku_id')` dan `belongsTo(SekolahPenerima::class, 'sekolah_id')`.

---

### Task 3: Penghapusan Supplier & Penataan Ulang Rute

**Files:**
- Delete: `app/Http/Controllers/SupplierController.php`
- Delete folder: `resources/views/supplier_bahan/`
- Modify: `routes/web.php`
- Modify: `resources/views/layouts/layouts_app.blade.php`

- [x] Hapus controller `SupplierController.php` dan seluruh view di dalam folder `resources/views/supplier_bahan/`.
- [x] Perbarui `routes/web.php`: hapus resource rute `supplier`. Tambahkan rute `stok-bahan.index`, serta resource rute untuk `bahan-masuk` dan `penggunaan-bahan`.
- [x] Perbarui sidebar di `resources/views/layouts/layouts_app.blade.php`: hapus link Supplier dari Master Data, tambahkan menu **Stok Bahan** (`stok-bahan.index`) di seksi Manajemen Stok, dan perbarui pengecekan rute aktif.

---

### Task 4: Perombakan Master Data Bahan Baku (Katalog Murni)

**Files:**
- Modify: `app/Http/Controllers/BahanBakuController.php`
- Modify: `resources/views/bahan_baku/index.blade.php`
- Modify: `resources/views/bahan_baku/create.blade.php`
- Modify: `resources/views/bahan_baku/edit.blade.php`
- Modify: `resources/views/bahan_baku/show.blade.php`

- [x] Perbarui `BahanBakuController.php`:
  - `store()` dan `update()` hanya memvalidasi `kode_bahan`, `nama_bahan`, `kategori_id`, `satuan`, dan `deskripsi`.
  - Hapus input stok, harga, supplier, expired dari form master. Saldo `stok` default adalah 0 saat bahan baru didaftarkan.
- [x] Perbarui `bahan_baku/index.blade.php`: tabel menampilkan Kolom No, Kode Bahan, Nama Bahan, Kategori, Satuan, Keterangan, dan Aksi (Show, Edit, Hapus).
- [x] Perbarui `bahan_baku/create.blade.php` dan `edit.blade.php`: form bersih hanya untuk data identitas bahan baku.
- [x] Perbarui `bahan_baku/show.blade.php`: menampilkan detail katalog bahan tanpa data supplier/harga.

---

### Task 5: Pembuatan Menu Baru: Stok Bahan

**Files:**
- Create: `app/Http/Controllers/StokBahanController.php`
- Create: `resources/views/stok_bahan/index.blade.php`

- [x] Buat `StokBahanController.php`:
  - Mengambil data seluruh bahan baku dengan relasi kategori dan riwayat transaksi.
  - Fitur pencarian nama/kode bahan dan filter kategori.
  - Perhitungan statistik stok: Total Jenis Bahan, Bahan Tersedia (stok > 0), Bahan Habis (stok = 0).
- [x] Buat tampilan `resources/views/stok_bahan/index.blade.php`:
  - Ringkasan kartu statistik ketersediaan bahan.
  - Tabel pemantauan stok: Kode, Nama Bahan, Kategori, Jumlah Stok Tersedia, Satuan, Status (Badge Hijau Tersedia / Merah Habis), dan tombol aksi cepat untuk input Bahan Masuk atau Penggunaan.

---

### Task 6: Implementasi Transaksi Bahan Masuk (Otomatis Tambah Stok)

**Files:**
- Modify: `app/Http/Controllers/BahanMasukController.php`
- Modify: `resources/views/bahan_masuk/index.blade.php`
- Create: `resources/views/bahan_masuk/create.blade.php`

- [x] Buat logic `BahanMasukController.php`:
  - `index()`: menampilkan daftar riwayat bahan masuk berpaginasi dengan filter pencarian dan tanggal.
  - `create()`: form input bahan masuk (pilih bahan baku, jumlah, tanggal masuk, keterangan).
  - `store()`: menggunakan `DB::transaction` untuk menyimpan catatan `BahanMasuk` dan otomatis memanggil `$bahanBaku->increment('stok', $jumlah)`.
  - `destroy()`: menghapus riwayat bahan masuk dan mengembalikan saldo stok `$bahanBaku->decrement('stok', $jumlah)`.
- [x] Buat view `resources/views/bahan_masuk/create.blade.php` dan perbarui `resources/views/bahan_masuk/index.blade.php` (tanpa kolom harga/supplier).

---

### Task 7: Implementasi Transaksi Penggunaan Bahan (Otomatis Kurang Stok & Validasi)

**Files:**
- Modify: `app/Http/Controllers/PenggunaanBahanController.php`
- Modify: `resources/views/penggunaan_bahan/index.blade.php`
- Create: `resources/views/penggunaan_bahan/create.blade.php`

- [x] Buat logic `PenggunaanBahanController.php`:
  - `index()`: menampilkan daftar pemakaian bahan berpaginasi dengan pencarian.
  - `create()`: form input pemakaian bahan (pilih bahan baku, tampilkan info stok saat ini, input jumlah dipakai, pilih sekolah tujuan / keperluan, tanggal).
  - `store()`: validasi bahwa `jumlah <= $bahanBaku->stok`. Jika tidak cukup, redirect back dengan pesan error *"Stok bahan tidak mencukupi (Tersedia: X satuan)"*. Gunakan `DB::transaction` untuk menyimpan catatan dan `$bahanBaku->decrement('stok', $jumlah)`.
  - `destroy()`: menghapus catatan pemakaian dan mengembalikan saldo stok `$bahanBaku->increment('stok', $jumlah)`.
- [x] Buat view `resources/views/penggunaan_bahan/create.blade.php` dan perbarui `resources/views/penggunaan_bahan/index.blade.php`.

---

### Task 8: Penyesuaian Dashboard & Laporan

**Files:**
- Modify: `app/Http/Controllers/DashboardController.php`
- Modify: `resources/views/dashboard.blade.php`
- Modify: `app/Http/Controllers/LaporanController.php`
- Modify: `resources/views/laporan/index.blade.php`

- [x] Perbarui `DashboardController.php` dan `dashboard.blade.php`:
  - Hapus import dan query Supplier.
  - Hitung statistik riil: Total Bahan Terdaftar, Bahan Tersedia, Bahan Habis, Total Porsi Terkirim, dan Aktivitas Transaksi Terbaru (Bahan Masuk & Pemakaian).
  - Hapus simbol rupiah atau angka biaya.
- [x] Perbarui `LaporanController.php` dan `laporan/index.blade.php`:
  - Hubungkan tabel laporan dengan query riil bahan baku, saldo stok, total masuk, dan total penggunaan.
  - Filter berdasarkan rentang tanggal dan kategori bahan.
  - Hapus total nominal uang.

---

### Task 9: Verifikasi & Pengujian Akhir

- [x] Jalankan `php artisan route:list` untuk memastikan semua rute terdaftar sempurna tanpa error.
- [x] Jalankan `php artisan view:cache` untuk memvalidasi seluruh sintaks template Blade.
- [x] Linting seluruh file PHP yang dibuat/dimodifikasi dengan `php -l`.
