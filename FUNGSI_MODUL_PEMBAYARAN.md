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

**Catatan:**

- Dokumentasi ini dapat dikembangkan sesuai kebutuhan dan perubahan kode.
- Untuk detail parameter dan return value, lihat langsung pada kode sumber masing-masing fungsi.
