# SPPG — Sistem Manajemen Inventaris Bahan Baku & Pemenuhan Gizi

Aplikasi web modern berbasis **Laravel 10** dan **Bootstrap 5** yang dirancang untuk mengelola stok bahan baku makanan bergizi pada **Satuan Pelayanan Pemenuhan Gizi (SPPG)**. Sistem ini memudahkan dapur gizi untuk memantau ketersediaan bahan mentah secara riil, pencatatan transaksi bahan masuk & penggunaan bahan, pengelompokan nutrisi/kategori, dan pendistribusian makanan bergizi ke sekolah-sekolah penerima manfaat.

---

## 🌟 Fitur Utama

- 📊 **Dashboard Analitik & Statistik Real-Time**
  - **Stat Cards**: Transaksi bahan masuk hari ini, kuantitas penggunaan bahan hari ini, bahan baku kosong/habis, dan jumlah sekolah penerima aktif.
  - **Tabel Stok Terkini & Kritis**: Menampilkan status stok bahan baku riil dilengkapi status badge (*Aman*, *Menipis*, *Habis*) dan aksi cepat penerimaan bahan.
  - **Grafik Mutasi Stok (7 Hari)**: Visualisasi perbandingan harian antara kuantitas bahan masuk vs bahan yang digunakan di dapur.
  - **Feed Aktivitas Transaksi Terbaru**: Log real-time dari peringatan stok habis, penerimaan bahan baru, dan riwayat pemakaian bahan.
  - **Panel Sekolah Penerima**: Monitoring ringkas lembaga/sekolah binaan SPPG yang aktif menerima distribusi gizi.
  - **Aksi Cepat (Quick Actions)**: Pintasan navigasi ke menu operasional penting (Bahan Masuk, Penggunaan, Sekolah, Stok, Tambah Bahan, Laporan).

- 📦 **Master Data Bahan Baku (Katalog Murni)**
  - Pencatatan katalog bahan baku: kode unik otomatis (`BHN-001`), nama, kategori nutrisi, satuan (*Kg, Liter, Butir, Pcs, Ikat, dll*), dan deskripsi.
  - Saldo stok awal otomatis bertambah dari transaksi bahan masuk dan berkurang dari transaksi penggunaan.
  - Operasi CRUD penuh (Tambah, Lihat Detail, Ubah, Hapus) dengan proteksi data berelasi.

- 📈 **Manajemen & Monitoring Stok Bahan**
  - Tampilan ringkas seluruh ketersediaan stok fisik bahan baku dapur gizi.
  - Status ketersediaan otomatis (*Tersedia / Menipis / Habis*).
  - Pintasan cepat untuk input Bahan Masuk atau Penggunaan Bahan langsung dari tabel stok.

- 📥 **Transaksi Bahan Masuk (Otomasi Stok Masuk)**
  - Kode transaksi dibuat otomatis (`BM-YYYYMMDD-001`).
  - Pencatatan riwayat pasokan bahan baku yang masuk ke gudang/dapur SPPG.
  - Menggunakan database transaction (`DB::transaction`) untuk menambah saldo stok bahan secara otomatis dan atomik.
  - Otomatis mengembalikan saldo stok jika data transaksi bahan masuk dihapus.

- 📤 **Transaksi Penggunaan Bahan (Otomasi Stok Keluar & Validasi Ketat)**
  - Kode transaksi dibuat otomatis (`PB-YYYYMMDD-001`).
  - Pencatatan alokasi bahan baku untuk pengolahan menu harian ke sekolah penerima atau keperluan dapur bersama.
  - Validasi pencegahan stok minus: transaksi ditolak secara otomatis jika jumlah pemakaian melebihi stok yang tersedia.
  - Mengurangi saldo stok secara otomatis dan mengembalikannya jika data transaksi dibatalkan.

- 🏷️ **Kategori Bahan Gizi**
  - Kode kategori dibuat otomatis (`KTG-001`).
  - Pengelompokan bahan berdasarkan kebutuhan gizi (Karbohidrat, Protein Hewani/Nabati, Sayur, Lemak, Bumbu/Pendukung).
  - Penghitungan otomatis jumlah jenis bahan baku yang terhubung pada setiap kategori serta proteksi penghapusan data berelasi.

- 🏫 **Sekolah Penerima Manfaat**
  - Manajemen CRUD lengkap data sekolah penerima program gizi (NPSN, nama sekolah, jenjang pendidikan [SD/MI/SMP/MTS/SMA/SMK/MA/Lainnya], kecamatan, alamat, dan status aktif/nonaktif).
  - Proteksi penghapusan jika sekolah memiliki riwayat penyaluran bahan.

- 📑 **Laporan Mutasi & Stok Bahan**
  - Rekapitulasi mutasi bahan masuk dan pemakaian bahan dengan filter rentang tanggal dan kategori bahan.
  - Tampilan bersih fokus pada pergerakan fisik bahan tanpa data uang/biaya.

- 🌐 **Dukungan Tunneling Demo Online (ngrok Ready)**
  - Sudah dikonfigurasi dengan *Trusted Proxies* Laravel sehingga aman diakses via HTTPS melalui ngrok tanpa kendala *CSRF 419 Page Expired*.

---

## 🛠️ Tech Stack

- **Backend:** [Laravel 10](https://laravel.com/) (PHP 8.1 - 8.4)
- **Database:** MySQL / MariaDB
- **Frontend:** [Bootstrap 5](https://getbootstrap.com/), [Bootstrap Icons](https://icons.getbootstrap.com/), [Vite](https://vitejs.dev/)
- **ORM:** Eloquent ORM
- **Web Server:** Laragon / Apache / Nginx / PHP Built-in Server

---

## 📋 Prasyarat Sistem

Pastikan komputer/server Anda telah terpasang:
- PHP >= 8.1 dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`.
- [Composer](https://getcomposer.org/) (versi 2.x)
- [Node.js](https://nodejs.org/) (versi 18.x atau lebih baru) & `npm`
- [MySQL](https://www.mysql.com/) atau MariaDB (dapat menggunakan **Laragon** atau XAMPP di Windows)
- [Git](https://git-scm.com/)

---

## 🚀 Panduan Instalasi Langkah Demi Langkah

### 1. Clone Repositori
Buka terminal dan clone repositori ini ke komputer Anda:
```bash
git clone https://github.com/Kitsune-fd/Inventaris-SPPG.git
cd Inventaris-SPPG
```

### 2. Pasang Dependensi PHP (Composer)
Jalankan perintah berikut untuk mengunduh seluruh dependensi framework:
```bash
composer install
```

### 3. Konfigurasi Lingkungan (`.env`)
Salin file template `.env.example` menjadi `.env`:
```bash
# Windows PowerShell
copy .env.example .env

# Atau Linux/macOS
cp .env.example .env
```

Lalu buat kunci aplikasi (*Application Key*):
```bash
php artisan key:generate
```

### 4. Konfigurasi Database
Buka file `.env` dengan teks editor favorit Anda, lalu sesuaikan koneksi database MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stok_bahan_baku_sppg
DB_USERNAME=root
DB_PASSWORD=
```
> **Catatan:** Pastikan database `stok_bahan_baku_sppg` sudah dibuat di MySQL Anda:
> ```sql
> CREATE DATABASE IF NOT EXISTS stok_bahan_baku_sppg;
> ```

### 5. Jalankan Migrasi & Seeder Database
Jalankan migrasi tabel dan data awal (seeder kategori, bahan baku, sekolah, dan akun admin):
```bash
php artisan migrate --seed
```

### 6. Buat Tautan Storage (Storage Link)
Hubungkan folder penyimpanan publik:
```bash
php artisan storage:link
```
*(Di Windows jika terjadi kendala hak akses simbolik link, gunakan `mklink /J public\storage storage\app\public`)*.

### 7. Pasang Dependensi Frontend & Kompilasi Aset
Jalankan instalasi paket frontend dan bangun aset produksi dengan Vite:
```bash
npm install
npm run build
```
*(Gunakan `npm run dev` jika sedang melakukan pengembangan antarmuka secara langsung).*

---

## 💻 Menjalankan Aplikasi

### Pilihan A: Menggunakan Artisan Server
```bash
php artisan serve
```
Buka browser Anda dan akses: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

### Pilihan B: Menggunakan Laragon (Virtual Host)
Jika Anda menggunakan Laragon dan menaruh proyek di folder `laragon/www/Dafa`:
1. Nyalakan tombol **Start All** di Laragon.
2. Akses melalui: **[http://dafa.test](http://dafa.test)** atau **[http://localhost/Dafa/public](http://localhost/Dafa/public)**.

---

## 🔑 Kredensial Akun Default

Setelah menjalankan `--seed`, Anda dapat langsung login menggunakan akun administrator default:

| Keterangan | Nilai |
|---|---|
| **URL Login** | `/` (Halaman Utama) |
| **Email** | `admin@gmail.com` |
| **Password** | `123` |

---

## 🌐 Demo Online Menggunakan ngrok (Opsional)

Jika Anda ingin memperlihatkan aplikasi ini ke orang lain / smartphone via internet publik:
```powershell
# Jika menggunakan php artisan serve (port 8000):
ngrok http 8000

# Jika menggunakan virtual host Laragon (port 80):
ngrok http dafa.test:80 --host-header="dafa.test"
```
Salin URL publik HTTPS yang diberikan oleh ngrok dan bagikan untuk demo.

---

## 📁 Struktur Direktori Utama

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php      # Logika analitik, grafik & statistik dashboard
│   │   ├── BahanBakuController.php      # Katalog data bahan baku
│   │   ├── StokBahanController.php      # Monitoring stok bahan riil
│   │   ├── BahanMasukController.php     # Transaksi penambahan stok bahan masuk
│   │   ├── PenggunaanBahanController.php# Transaksi pemakaian stok & validasi
│   │   ├── KategoriController.php       # Data kategori nutrisi
│   │   ├── SekolahPenerimaController.php# Data sekolah penerima manfaat
│   │   ├── LaporanController.php        # Rekap mutasi dan laporan stok
│   │   └── LoginController.php          # Autentikasi sistem
│   └── Middleware/
│       └── TrustProxies.php             # Penanganan reverse proxy / tunnel HTTPS
├── Models/
│   ├── BahanBaku.php
│   ├── BahanMasuk.php
│   ├── PenggunaanBahan.php
│   ├── Kategori.php
│   ├── SekolahPenerima.php
│   └── User.php
database/
├── migrations/                          # Skema tabel database
└── seeders/                             # Data awal (Admin, Kategori, Bahan, Sekolah)
resources/
└── views/                               # Template Blade UI (Dashboard, Stok, Transaksi, Laporan)
```

---

## 📄 Lisensi

Proyek ini dikembangkan di bawah lisensi [MIT License](LICENSE).
