<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pembayaran</h1>
        <div>
            <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter mr-2"></i>Filter Laporan
            </h6>
        </div>
        <div class="card-body">
            <form method="get" action="<?= base_url('pembayaran/report') ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select class="form-control" name="bulan" id="bulan">
                                <option value="">Semua Bulan</option>
                                <option value="Januari" <?= ($filter['bulan'] == 'Januari') ? 'selected' : '' ?>>Januari</option>
                                <option value="Februari" <?= ($filter['bulan'] == 'Februari') ? 'selected' : '' ?>>Februari</option>
                                <option value="Maret" <?= ($filter['bulan'] == 'Maret') ? 'selected' : '' ?>>Maret</option>
                                <option value="April" <?= ($filter['bulan'] == 'April') ? 'selected' : '' ?>>April</option>
                                <option value="Mei" <?= ($filter['bulan'] == 'Mei') ? 'selected' : '' ?>>Mei</option>
                                <option value="Juni" <?= ($filter['bulan'] == 'Juni') ? 'selected' : '' ?>>Juni</option>
                                <option value="Juli" <?= ($filter['bulan'] == 'Juli') ? 'selected' : '' ?>>Juli</option>
                                <option value="Agustus" <?= ($filter['bulan'] == 'Agustus') ? 'selected' : '' ?>>Agustus</option>
                                <option value="September" <?= ($filter['bulan'] == 'September') ? 'selected' : '' ?>>September</option>
                                <option value="Oktober" <?= ($filter['bulan'] == 'Oktober') ? 'selected' : '' ?>>Oktober</option>
                                <option value="November" <?= ($filter['bulan'] == 'November') ? 'selected' : '' ?>>November</option>
                                <option value="Desember" <?= ($filter['bulan'] == 'Desember') ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" name="tahun" id="tahun">
                                <option value="">Semua Tahun</option>
                                <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
                                    <option value="<?= $year ?>" <?= ($filter['tahun'] == $year) ? 'selected' : '' ?>><?= $year ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Semua Status</option>
                                <option value="sudah_bayar" <?= ($filter['status'] == 'sudah_bayar') ? 'selected' : '' ?>>Sudah Bayar</option>
                                <option value="belum_bayar" <?= ($filter['status'] == 'belum_bayar') ? 'selected' : '' ?>>Belum Bayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="<?= base_url('pembayaran/report') ?>" class="btn btn-secondary">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pembayaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($statistics['total_pembayaran'] ?? 0) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($statistics['total_pendapatan'] ?? 0, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rata-rata Pembayaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($statistics['rata_rata_pembayaran'] ?? 0, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pelanggan Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format($statistics['jumlah_pelanggan'] ?? 0) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table mr-2"></i>Data Pembayaran
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($payments)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data pembayaran</h5>
                    <p class="text-muted">Coba ubah filter untuk melihat data yang berbeda</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>No. KWH</th>
                                <th>Periode</th>
                                <th>Jumlah Meter</th>
                                <th>Total Tagihan</th>
                                <th>Biaya Admin</th>
                                <th>Total Bayar</th>
                                <th>Petugas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($payments as $payment): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= date('d/m/Y H:i', strtotime($payment['tanggal_pembayaran'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($payment['nama_pelanggan']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <?= htmlspecialchars($payment['nomor_kwh']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?= htmlspecialchars($payment['bulan']) ?>/<?= htmlspecialchars($payment['tahun']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <?= number_format($payment['jumlah_meter']) ?> kWh
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            Rp <?= number_format($payment['total_bayar'] - $payment['biaya_admin'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-info">
                                            Rp <?= number_format($payment['biaya_admin'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-primary font-weight-bold">
                                            Rp <?= number_format($payment['total_bayar'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($payment['nama_admin']) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if ($payment['status_tagihan'] == 'sudah_bayar'): ?>
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Lunas
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Belum Bayar
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('pembayaran/detail/' . $payment['id_pembayaran']) ?>" 
                                               class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('pembayaran/edit/' . $payment['id_pembayaran']) ?>" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "order": [[1, "desc"]], // Sort by date descending
        "pageLength": 25,
        "responsive": true
    });
});
</script> 