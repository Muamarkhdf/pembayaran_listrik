# Sistem Pembayaran Listrik

Sistem manajemen pembayaran listrik berbasis CodeIgniter 3 dengan MySQL.

## Fitur Utama

### 🔐 Sistem Login & Autentikasi

- Login dengan username dan password
- Session management yang aman
- Role-based access control
- Logout functionality
- Middleware untuk proteksi halaman

### 📊 Dashboard dengan Statistik Lengkap

- Total pelanggan aktif
- Total tagihan dan pembayaran
- Statistik penggunaan listrik
- Grafik dan chart interaktif
- Recent activities

### 👥 Manajemen Data Pelanggan

- CRUD operasi pelanggan
- Data lengkap: nama, alamat, nomor KWH
- Relasi dengan tarif listrik
- Validasi data yang ketat

### ⚡ Manajemen Tarif Listrik

- **Tambah Tarif Baru**: Menambah jenis tarif dengan daya dan harga
- **Edit Tarif**: Mengubah data tarif yang sudah ada
- **Hapus Tarif**: Menghapus tarif (hanya jika tidak digunakan pelanggan)
- **Preview Perhitungan**: Kalkulasi otomatis tagihan berdasarkan tarif
- **Statistik Tarif**: Total jenis tarif, rata-rata tarif, distribusi pelanggan

### 📋 Manajemen Tagihan Listrik

- **Tambah Tagihan**: Input meter awal dan akhir untuk periode tertentu
- **Edit Tagihan**: Mengubah data meteran
- **Hapus Tagihan**: Menghapus tagihan yang belum dibayar
- **Proses Pembayaran**: Sistem pembayaran dengan biaya admin
- **Status Tracking**: Monitoring status pembayaran

### 👤 Manajemen User Admin

- CRUD operasi user admin
- Role-based permissions
- Password encryption dengan MD5
- Session management

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx web server
- XAMPP/WAMP/LAMP

## Instalasi

1. **Clone atau download project ini ke folder web server**

   ```
   C:/xampp/htdocs/pembayaran_listrik/
   ```

2. **Import database**

   - Buka phpMyAdmin
   - Buat database baru dengan nama `pembayaran_listrik`
   - Import file `listrik2.sql`

3. **Konfigurasi database**

   - Edit file `application/config/database.php`
   - Sesuaikan username dan password database

4. **Konfigurasi base URL**

   - Edit file `application/config/config.php`
   - Sesuaikan `base_url` dengan URL project Anda

5. **Akses aplikasi**
   - Buka browser
   - Akses: `http://localhost/pembayaran_listrik/`
   - Login dengan kredensial default

## Login Default

Setelah import database, Anda dapat login dengan:

- **Username**: `admin`
- **Password**: `admin123`

Atau:

- **Username**: `petugas`
- **Password**: `petugas123`

## Struktur Database

### Tabel User (Admin)

- id_user (Primary Key)
- username
- password (MD5 encrypted)
- nama_admin
- id_level (Foreign Key)

### Tabel Level

- id_level (Primary Key)
- nama_level (Administrator, Petugas, Reguler)

### Tabel Pelanggan

- id_pelanggan (Primary Key)
- username
- password
- nomor_kwh
- nama_pelanggan
- alamat
- id_tarif

### Tabel Tarif

- id_tarif (Primary Key)
- daya (VA)
- tarifperkwh (Rupiah per kWh)

### Tabel Penggunaan

- id_penggunaan (Primary Key)
- id_pelanggan (Foreign Key)
- bulan
- tahun
- meter_awal
- meter_ahir

### Tabel Tagihan

- id_tagihan (Primary Key)
- id_penggunaan (Foreign Key)
- id_pelanggan (Foreign Key)
- bulan
- tahun
- jumlah_meter
- status (belum_bayar/sudah_bayar)

### Tabel Pembayaran

- id_pembayaran (Primary Key)
- id_tagihan (Foreign Key)
- id_pelanggan (Foreign Key)
- tanggal_pembayaran
- bulan_bayar
- biaya_admin
- total_bayar
- id_user

## Kontroller

- `Auth` - Sistem login dan logout
- `Dashboard` - Halaman utama dengan statistik
- `Pelanggan` - Manajemen data pelanggan
- `Tarif` - Manajemen tarif listrik
- `Tagihan` - Manajemen tagihan dan pembayaran
- `User` - Manajemen user admin

## View

- `auth/login.php` - Halaman login
- `layouts/main.php` - Layout utama aplikasi
- `pages/dashboard.php` - Halaman dashboard
- `pages/pelanggan.php` - Daftar pelanggan
- `pages/pelanggan_form.php` - Form tambah/edit pelanggan
- `pages/tarif.php` - Daftar tarif listrik
- `pages/tarif_form.php` - Form tambah/edit tarif
- `pages/tagihan.php` - Daftar tagihan listrik
- `pages/tagihan_form.php` - Form tambah/edit tagihan
- `pages/tagihan_bayar.php` - Form pembayaran tagihan
- `pages/user.php` - Daftar user admin
- `pages/user_form.php` - Form tambah/edit user

## URL Akses

- Login: `http://localhost/pembayaran_listrik/`
- Dashboard: `http://localhost/pembayaran_listrik/dashboard`
- Pelanggan: `http://localhost/pembayaran_listrik/pelanggan`
- Tarif: `http://localhost/pembayaran_listrik/tarif`
- Tagihan: `http://localhost/pembayaran_listrik/tagihan`
- User Management: `http://localhost/pembayaran_listrik/user`
- Logout: `http://localhost/pembayaran_listrik/auth/logout`

## Level User

1. **Administrator**

   - Akses penuh ke semua fitur
   - Dapat mengelola user lain
   - Dapat mengakses semua data

2. **Petugas**

   - Akses terbatas untuk input data
   - Tidak dapat mengelola user
   - Fokus pada transaksi

3. **Reguler**
   - Level untuk pelanggan
   - Akses terbatas

## Fitur Tarif Listrik

### Manajemen Tarif

- **Tambah Tarif Baru**: Menambah jenis tarif dengan daya dan harga
- **Edit Tarif**: Mengubah data tarif yang sudah ada
- **Hapus Tarif**: Menghapus tarif (hanya jika tidak digunakan pelanggan)
- **Preview Perhitungan**: Kalkulasi otomatis tagihan berdasarkan tarif

### Jenis Tarif Standar

- **900 VA**: Rp 1.352/kWh (Rumah tangga daya rendah)
- **1300 VA**: Rp 1.444/kWh (Rumah tangga menengah)
- **2200 VA**: Rp 1.699/kWh (Rumah tangga daya tinggi)
- **Custom**: Tarif khusus untuk kebutuhan bisnis

### Statistik Tarif

- Total jenis tarif tersedia
- Total pelanggan menggunakan tarif
- Rata-rata tarif per kWh
- Daya tertinggi yang tersedia
- Distribusi pelanggan per tarif (chart)

### Validasi

- Daya harus unik (tidak boleh duplikat)
- Tarif harus berupa angka positif
- Tidak dapat menghapus tarif yang masih digunakan pelanggan

## Fitur Tagihan Listrik

### Manajemen Tagihan

- **Tambah Tagihan**: Input meter awal dan akhir untuk periode tertentu
- **Edit Tagihan**: Mengubah data meteran
- **Hapus Tagihan**: Menghapus tagihan yang belum dibayar
- **Proses Pembayaran**: Sistem pembayaran dengan biaya admin
- **Status Tracking**: Monitoring status pembayaran

### Perhitungan Tagihan

- **Meter Awal**: Angka meteran di awal periode
- **Meter Akhir**: Angka meteran di akhir periode
- **Penggunaan**: Selisih meter akhir dan meter awal
- **Total Tagihan**: Penggunaan × Tarif per kWh
- **Biaya Admin**: Rp 10.000 (fixed)
- **Total Bayar**: Total Tagihan + Biaya Admin

### Statistik Tagihan

- Total tagihan listrik
- Tagihan sudah bayar vs belum bayar
- Total pendapatan dari pembayaran
- Grafik distribusi status pembayaran

### Validasi

- Meter akhir harus lebih besar dari meter awal
- Tidak boleh ada duplikasi data untuk periode yang sama
- Tagihan yang sudah dibayar tidak dapat dihapus

## Teknologi

- **Backend**: CodeIgniter 3
- **Database**: MySQL
- **Frontend**: Bootstrap 4, SB Admin 2
- **JavaScript**: jQuery, DataTables, SweetAlert2, Chart.js
- **Security**: Session management, MD5 encryption

## Troubleshooting

### Database Error

Jika muncul error database:

1. Pastikan database `pembayaran_listrik` sudah dibuat
2. Import file `listrik2.sql` dengan benar
3. Periksa konfigurasi database di `application/config/database.php`

### Login Error

Jika tidak bisa login:

1. Pastikan tabel `user` dan `level` sudah terisi
2. Coba login dengan kredensial default
3. Periksa session configuration

### URL Error

Jika URL tidak berfungsi:

1. Pastikan `.htaccess` sudah ada
2. Periksa konfigurasi `base_url` di `config.php`
3. Pastikan mod_rewrite Apache aktif

### Tarif Error

Jika ada masalah dengan tarif:

1. Pastikan tabel `tarif` sudah terisi dengan data default
2. Periksa relasi dengan tabel `pelanggan`
3. Pastikan format daya dan tarif sesuai

### Tagihan Error

Jika ada masalah dengan tagihan:

1. Pastikan tabel `penggunaan` dan `tagihan` terhubung dengan benar
2. Periksa relasi dengan tabel `pelanggan` dan `tarif`
3. Pastikan format meter awal dan akhir sesuai

## Lisensi

Project ini dibuat untuk keperluan pembelajaran dan pengembangan sistem pembayaran listrik.
