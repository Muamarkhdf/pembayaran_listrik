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

# 📝 Laporan Hasil Pengujian Integrasi Modul Pembayaran Listrik

## 1. Tujuan Pengujian

Memastikan seluruh fungsi utama pada modul pembayaran listrik terintegrasi dengan baik dan berjalan sesuai dengan kebutuhan sistem.

---

## 2. Skenario & Langkah Pengujian

| No  | Skenario Pengujian               | Langkah Uji                                                         | Data Uji           | Hasil Ekspektasi                         | Hasil Aktual | Status |
| --- | -------------------------------- | ------------------------------------------------------------------- | ------------------ | ---------------------------------------- | ------------ | ------ |
| 1   | Input Pembayaran                 | Tambah pembayaran untuk tagihan belum bayar                         | Tagihan A, Admin X | Data pembayaran tersimpan, status lunas  | Sesuai       | LULUS  |
| 2   | Edit Pembayaran                  | Ubah biaya admin pada pembayaran yang sudah ada                     | Biaya admin baru   | Total bayar terupdate, data tersimpan    | Sesuai       | LULUS  |
| 3   | Hapus Pembayaran                 | Hapus data pembayaran tertentu                                      | ID pembayaran Y    | Data terhapus, status tagihan unpaid     | Sesuai       | LULUS  |
| 4   | Laporan Pembayaran               | Filter laporan berdasarkan bulan/tahun/petugas                      | Bulan Mei 2025     | Data sesuai filter, kolom petugas tampil | Sesuai       | LULUS  |
| 5   | Validasi Perhitungan Total Bayar | Cek perhitungan total bayar (tagihan + admin) di laporan dan detail | Tagihan B, Admin Y | Nilai sesuai rumus                       | Sesuai       | LULUS  |
| 6   | Pelacakan Petugas                | Pastikan nama admin muncul di setiap transaksi pembayaran           | Semua pembayaran   | Nama admin tampil di laporan & detail    | Sesuai       | LULUS  |
| 7   | ...                              | ...                                                                 | ...                | ...                                      | ...          | ...    |

---

## 3. Kesimpulan

Berdasarkan hasil pengujian integrasi, seluruh fungsi utama pada modul pembayaran listrik **berjalan dengan baik** dan sesuai dengan kebutuhan sistem. Tidak ditemukan bug/kesalahan pada skenario yang diuji.

**Catatan:**

- Jika ditemukan kasus gagal, lakukan analisis dan perbaikan pada modul terkait.
- Laporan ini dapat diperbarui sesuai siklus pengujian berikutnya.

# 🛠️ Lembar Peralatan Pengujian Integrasi

Berikut adalah daftar peralatan yang digunakan untuk pengujian integrasi modul pembayaran listrik.

---

## 1. Tabel Peralatan Pengujian

| No  | Nama Peralatan  | Spesifikasi/Versi                 | Keterangan                  |
| --- | --------------- | --------------------------------- | --------------------------- |
| 1   | Komputer/Laptop | Intel i5/AMD Ryzen, RAM 8GB+      | Untuk menjalankan server    |
| 2   | XAMPP           | Versi 8.2.x (PHP 8, MySQL 8)      | Web server & database lokal |
| 3   | Browser         | Chrome 124, Firefox 126           | Pengujian UI/web            |
| 4   | Code Editor     | VS Code 1.89, Sublime Text 4      | Pengeditan kode             |
| 5   | Postman         | Versi 10.x                        | Pengujian API/manual        |
| 6   | Git             | Versi 2.40+                       | Kontrol versi               |
| 7   | Sistem Operasi  | Windows 10/11, Linux Ubuntu 22.04 | Lingkungan pengujian        |
| 8   | ...             | ...                               | ...                         |

---

# 📄 Dokumentasi Modul: Pembayaran Listrik

## 1. Identitas Modul

| Atribut        | Keterangan                  |
| -------------- | --------------------------- |
| **Nama Modul** | Pembayaran Listrik          |
| **Versi**      | 1.0                         |
| **Tanggal**    | 2024-06-14                  |
| **Pengembang** | [Nama Anda/Nama Tim]        |
| **Kontak**     | [Email/WA/Telegram]         |
| **Repository** | [Link GitHub/Repo jika ada] |

---

## 2. Deskripsi Modul

Modul ini menangani seluruh proses pembayaran tagihan listrik pelanggan, mulai dari input pembayaran, pelaporan, hingga rekapitulasi dan pelacakan pembayaran oleh admin/operator. Setiap transaksi pembayaran dicatat lengkap dengan identitas petugas untuk memudahkan audit dan pelacakan.

---

## 3. Lokasi File

- **Controller:**
  - `application/controllers/Pembayaran.php`
  - `application/controllers/Laporan.php`
- **Model:**
  - `application/models/Pembayaran_model.php`
- **View:**
  - `application/views/pages/pembayaran.php`
  - `application/views/pages/laporan_pembayaran.php`
  - `application/views/pages/pembayaran_report.php`

---

## 4. Fitur Utama

- Input Pembayaran: Admin dapat menambah pembayaran berdasarkan tagihan yang belum dibayar.
- Edit & Hapus Pembayaran: Admin dapat mengubah atau menghapus data pembayaran.
- Laporan Pembayaran: Menampilkan rekap pembayaran, filter berdasarkan bulan/tahun/pelanggan, dan ekspor ke Excel/PDF.
- Pelacakan Petugas: Setiap transaksi pembayaran mencatat nama petugas/admin yang memproses.
- Validasi Otomatis: Total bayar selalu dihitung otomatis dari total tagihan + biaya admin.

---

## 5. Alur Data

1. **Input Pembayaran**

   - Admin memilih tagihan yang belum dibayar.
   - Sistem menghitung total tagihan, biaya admin, dan total bayar.
   - Data pembayaran disimpan ke tabel `pembayaran` dan status tagihan diubah menjadi "sudah bayar".

2. **Edit Pembayaran**

   - Admin dapat mengubah biaya admin.
   - Sistem otomatis menghitung ulang total bayar.

3. **Laporan Pembayaran**
   - Data pembayaran dapat difilter dan diekspor.
   - Kolom petugas selalu tampil untuk pelacakan.

---

## 6. Struktur Database Terkait

### Tabel `pembayaran`

| Field              | Tipe Data | Keterangan                 |
| ------------------ | --------- | -------------------------- |
| id_pembayaran      | INT (PK)  | Primary key                |
| id_tagihan         | INT (FK)  | Relasi ke tabel tagihan    |
| id_pelanggan       | INT (FK)  | Relasi ke tabel pelanggan  |
| tanggal_pembayaran | DATETIME  | Waktu pembayaran           |
| bulan_bayar        | VARCHAR   | Bulan pembayaran           |
| biaya_admin        | INT       | Biaya administrasi         |
| total_bayar        | INT       | Total yang dibayarkan      |
| id_user            | INT (FK)  | Relasi ke tabel user/admin |

### Tabel `user`

| Field      | Tipe Data | Keterangan         |
| ---------- | --------- | ------------------ |
| id_user    | INT (PK)  | Primary key        |
| nama_admin | VARCHAR   | Nama petugas/admin |

---

## 7. Pelacakan & Audit

- Setiap pembayaran menyimpan `id_user` dan `nama_admin` yang memproses.
- Log perubahan dapat ditambahkan pada level database atau aplikasi jika diperlukan (misal: trigger, log table, atau fitur audit trail di aplikasi).
- Kolom “Petugas” selalu tampil di laporan untuk memudahkan pelacakan siapa yang memproses pembayaran.

---

## 8. Riwayat Perubahan

| Tanggal    | Perubahan                        | Oleh        |
| ---------- | -------------------------------- | ----------- |
| 2024-06-14 | Pembuatan dokumentasi awal       | [Nama Anda] |
| 2024-06-14 | Penambahan kolom Petugas di view | [Nama Anda] |
| ...        | ...                              | ...         |

---

# 🏷️ Identifikasi Modul: Pembayaran Listrik

Dokumentasi identifikasi ini dibuat untuk memudahkan pelacakan, audit, dan pengelolaan perubahan pada modul pembayaran listrik di aplikasi.

---

## 1. Informasi Identitas Modul

| Atribut        | Keterangan                  |
| -------------- | --------------------------- |
| **ID Modul**   | PL-20240614-01              |
| **Nama Modul** | Pembayaran Listrik          |
| **Versi**      | 1.0                         |
| **Tanggal**    | 2024-06-14                  |
| **Pengembang** | [Nama Anda/Nama Tim]        |
| **Kontak**     | [Email/WA/Telegram]         |
| **Repository** | [Link GitHub/Repo jika ada] |

---

## 2. Tujuan Identifikasi

- Memudahkan pelacakan perubahan dan audit modul.
- Menyediakan informasi identitas yang jelas untuk setiap modul.
- Memastikan setiap modul terdokumentasi dengan baik dan dapat diidentifikasi secara unik.

---

# 📚 Dokumentasi Fungsi/Method Modul Pembayaran Listrik

Berikut adalah dokumentasi fungsi, prosedur, atau method utama yang terdapat pada modul pembayaran listrik.

---

## 1. Controller: `application/controllers/Pembayaran.php`

### `add()`

- **Deskripsi:** Menambah data pembayaran baru berdasarkan tagihan yang belum dibayar.
- **Parameter:** (none, menggunakan POST)
- **Return:** View form pembayaran atau redirect ke daftar pembayaran.

### `edit($id)`

- **Deskripsi:** Mengedit data pembayaran yang sudah ada.
- **Parameter:**
  - `$id` (int): ID pembayaran yang akan diedit
- **Return:** View form edit pembayaran atau redirect ke daftar pembayaran.

### `delete($id)`

- **Deskripsi:** Menghapus data pembayaran.
- **Parameter:**
  - `$id` (int): ID pembayaran yang akan dihapus
- **Return:** Redirect ke daftar pembayaran.

### `detail($id)`

- **Deskripsi:** Menampilkan detail pembayaran.
- **Parameter:**
  - `$id` (int): ID pembayaran
- **Return:** View detail pembayaran.

### `report()`

- **Deskripsi:** Menampilkan laporan pembayaran dengan filter.
- **Parameter:** (GET: bulan, tahun, status)
- **Return:** View laporan pembayaran.

---

## 2. Controller: `application/controllers/Laporan.php`

### `pembayaran()`

- **Deskripsi:** Menampilkan laporan pembayaran dengan filter dan rekap total.
- **Parameter:** (GET: bulan, tahun, pelanggan)
- **Return:** View laporan pembayaran.

### `get_payment_report($bulan, $tahun, $pelanggan)`

- **Deskripsi:** Mengambil data pembayaran dari database sesuai filter.
- **Parameter:**
  - `$bulan` (string|null)
  - `$tahun` (string|null)
  - `$pelanggan` (int|null)
- **Return:** Array data pembayaran.

### `calculate_total_payment($payments)`

- **Deskripsi:** Menghitung total pembayaran dari array pembayaran.
- **Parameter:**
  - `$payments` (array)
- **Return:** Integer total pembayaran.

### `calculate_total_admin($payments)`

- **Deskripsi:** Menghitung total biaya admin dari array pembayaran.
- **Parameter:**
  - `$payments` (array)
- **Return:** Integer total biaya admin.

---

## 3. Model: `application/models/Pembayaran_model.php`

### `get_all_pembayaran()`

- **Deskripsi:** Mengambil seluruh data pembayaran beserta relasi pelanggan, tagihan, dan admin.
- **Parameter:** (none)
- **Return:** Array data pembayaran.

### `get_by_id($id)`

- **Deskripsi:** Mengambil data pembayaran berdasarkan ID.
- **Parameter:**
  - `$id` (int): ID pembayaran
- **Return:** Array data pembayaran.

### `insert($data)`

- **Deskripsi:** Menyimpan data pembayaran baru ke database.
- **Parameter:**
  - `$data` (array): Data pembayaran
- **Return:** Boolean sukses/gagal.

### `update($id, $data)`

- **Deskripsi:** Memperbarui data pembayaran berdasarkan ID.
- **Parameter:**
  - `$id` (int): ID pembayaran
  - `$data` (array): Data pembayaran baru
- **Return:** Boolean sukses/gagal.

### `delete($id)`

- **Deskripsi:** Menghapus data pembayaran berdasarkan ID.
- **Parameter:**
  - `$id` (int): ID pembayaran
- **Return:** Boolean sukses/gagal.

### `get_payment_report($bulan, $tahun, $status)`

- **Deskripsi:** Mengambil data pembayaran dengan filter bulan, tahun, dan status.
- **Parameter:**
  - `$bulan` (string|null)
  - `$tahun` (string|null)
  - `$status` (string|null)
- **Return:** Array data pembayaran.

### `get_payment_stats($bulan, $tahun, $status)`

- **Deskripsi:** Mengambil statistik pembayaran (total, rata-rata, dsb) dengan filter.
- **Parameter:**
  - `$bulan` (string|null)
  - `$tahun` (string|null)
  - `$status` (string|null)
- **Return:** Array statistik pembayaran.

---

# 📊 Evaluasi Hasil Keluaran Modul Pembayaran Listrik

## 1. Tujuan Evaluasi

Evaluasi ini bertujuan untuk membandingkan data hasil keluaran dari modul pembayaran listrik dengan data yang direncanakan, guna memastikan akurasi, kelengkapan, dan kesesuaian sistem.

---

## 2. Tabel Perbandingan Data

| No  | Data Direncanakan (Input/Target) | Data Hasil Keluaran Sistem | Keterangan/Kesesuaian |
| --- | -------------------------------- | -------------------------- | --------------------- |
| 1   | Total Tagihan: Rp 577.880        | Total Tagihan: Rp 577.880  | ✔️ Sesuai             |
| 2   | Biaya Admin: Rp 10.000           | Biaya Admin: Rp 10.000     | ✔️ Sesuai             |
| 3   | Total Bayar: Rp 587.880          | Total Bayar: Rp 587.880    | ✔️ Sesuai             |
| 4   | Petugas: Administrator           | Petugas: Administrator     | ✔️ Sesuai             |
| 5   | ...                              | ...                        | ...                   |

---

## 3. Analisis Kesesuaian

- **Akurasi:** Semua nilai yang dihasilkan sistem (total tagihan, biaya admin, total bayar, petugas) sudah sesuai dengan data yang direncanakan.
- **Kelengkapan:** Seluruh field penting (tagihan, admin, total bayar, dsb) tampil di laporan dan detail pembayaran.
- **Validasi Otomatis:** Perhitungan total bayar otomatis mengikuti rumus yang direncanakan (`total_tagihan + biaya_admin`).
- **Pelacakan:** Nama petugas/admin tercatat dan tampil di setiap transaksi.

---

## 4. Kesimpulan

Berdasarkan evaluasi, data hasil keluaran modul pembayaran listrik **sesuai** dengan data yang direncanakan. Sistem telah berjalan dengan baik dan dapat diandalkan untuk pelaporan serta audit.


## Lisensi

Project ini dibuat untuk keperluan pembelajaran dan pengembangan sistem pembayaran listrik.
