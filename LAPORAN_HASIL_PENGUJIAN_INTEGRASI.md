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
