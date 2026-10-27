# SPPG — Sistem Manajemen Inventaris Bahan Baku & Pemenuhan Gizi

Aplikasi web modern berbasis **Laravel 10** dan **Bootstrap 5** yang dirancang untuk mengelola stok bahan baku makanan bergizi pada **Satuan Pelayanan Pemenuhan Gizi (SPPG)**. Sistem ini memudahkan dapur gizi untuk memantau ketersediaan bahan mentah, hubungan supplier, pengelompokan nutrisi/kategori, dan pendistribusian makanan bergizi ke sekolah-sekolah penerima manfaat.

---

## 🌟 Fitur Utama

- 📊 **Dashboard Analitik & Statistik Real-Time**
  - **Stat Cards**: Total bahan baku, sekolah penerima aktif, akumulasi target porsi harian, dan peringatan bahan kritis yang perlu di-*restock*.
  - **Tabel Stok Kritis Otomatis**: Menampilkan bahan baku dengan persentase stok terendah terhadap batas minimum aman, dilengkapi status badge (*Kritis*, *Rendah*, *Normal*) dan *progress bar* visual.
  - **Grafik Produksi (7 Hari)**: Visualisasi porsi makanan yang diproduksi setiap hari lengkap dengan kalkulasi total, rata-rata harian, dan angka produksi puncak.
  - **Feed Aktivitas Terbaru**: Log real-time dari perubahan stok, bahan baru terdaftar, dan status distribusi.
  - **Distribusi Sekolah Hari Ini**: Monitoring status pengiriman (*Terkirim*, *Proses*, *Menunggu*) beserta target porsi per sekolah.
  - **Aksi Cepat (Quick Actions)**: Pintasan navigasi ke menu-menu operasional penting.

- 📦 **Manajemen Bahan Baku**
  - Pencatatan lengkap data bahan baku: kode unik, nama, kategori gizi, supplier, stok aktual, batas stok minimum, satuan (*Kg, Liter, Tray, Pcs*), estimasi harga, dan tanggal kedaluwarsa (*expired date*).
  - Validasi stok habis vs tersedia secara otomatis.
  - Operasi CRUD penuh (Tambah, Lihat Detail, Ubah, Hapus) dengan perlindungan CSRF.

- 🏷️ **Kategori Bahan Gizi**
  - Pengelompokan bahan berdasarkan kebutuhan gizi (Karbohidrat, Protein, Sayur, Lemak, Bumbu/Pendukung).
  - Penghitungan otomatis jumlah bahan baku yang terhubung pada setiap kategori.

- 🚚 **Manajemen Supplier / Pemasok**
  - Data mitra penyuplai bahan baku (nama kontak, nomor telepon, alamat operasional).
  - Pelacakan jumlah bahan baku yang dipasok oleh masing-masing supplier.

- 🏫 **Sekolah Penerima Distribusi**
  - Data sekolah binaan penerima program gizi, NPSN, jenjang (SD/MI/SMP), kecamatan, jumlah siswa, dan alokasi porsi.
  - Pemantauan status distribusi harian.

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
Jalankan migrasi tabel dan data awal (seeder kategori, supplier, bahan baku, sekolah, dan akun admin):
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
│   │   ├── BahanBakuController.php      # CRUD lengkap bahan baku
│   │   ├── KategoriController.php       # Data kategori nutrisi
│   │   ├── SupplierController.php       # Data pemasok
│   │   ├── SekolahPenerimaController.php# Data sekolah penerima manfaat
│   │   └── LoginController.php          # Autentikasi sistem
│   └── Middleware/
│       └── TrustProxies.php             # Penanganan reverse proxy / tunnel HTTPS
├── Models/
│   ├── BahanBaku.php
│   ├── Kategori.php
│   ├── Supplier.php
│   ├── SekolahPenerima.php
│   └── User.php
database/
├── migrations/                          # Skema tabel database
└── seeders/                             # Data awal (Admin, Bahan, Sekolah, Kategori, Supplier)
resources/
└── views/                               # Template Blade UI (Dashboard, Master Data, Layouts)
```

---

## 📄 Lisensi

Proyek ini dikembangkan di bawah lisensi [MIT License](LICENSE).
