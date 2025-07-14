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

**Catatan:**  
Silakan lengkapi bagian [Nama Anda], kontak, dan repository sesuai identitas tim/proyek Anda. Dokumentasi ini dapat dikembangkan sesuai kebutuhan pelacakan dan audit di masa mendatang.
