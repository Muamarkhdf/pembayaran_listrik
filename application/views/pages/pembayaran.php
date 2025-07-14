<?php
$page_title = 'Data Pembayaran';
$active_page = 'pembayaran';

// Statistik
$total_pembayaran = 0;
$total_admin = 0;
$total_lunas = 0;
$pembayaran_hari_ini = 0;
if (isset($pembayaran)) {
    foreach ($pembayaran as $p) {
        $total_pembayaran += $p['total_bayar'];
        $total_admin += $p['biaya_admin'];
        if ($p['tanggal_pembayaran'] && date('Y-m-d', strtotime($p['tanggal_pembayaran'])) == date('Y-m-d')) {
            $pembayaran_hari_ini++;
        }
        $total_lunas++;
    }
}
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pembayaran</h1>
        <a href="<?= base_url('pembayaran/add') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Pembayaran
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h6>
        </div>
        <div class="card-body">
            <?php if (empty($pembayaran)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data pembayaran</h5>
                    <p class="text-muted">Silakan tambah pembayaran baru untuk memulai</p>
                    <a href="<?= base_url('pembayaran/add') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pembayaran Pertama
                    </a>
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
                                <th>Bulan/Tahun</th>
                                <th>Jumlah Meter</th>
                                <th>Biaya Admin</th>
                                <th>Total Bayar</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pembayaran as $bayar): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= date('d/m/Y H:i', strtotime($bayar['tanggal_pembayaran'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($bayar['nama_pelanggan']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <?= htmlspecialchars($bayar['nomor_kwh']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?= htmlspecialchars($bayar['bulan']) ?>/<?= htmlspecialchars($bayar['tahun']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <?= number_format($bayar['jumlah_meter']) ?> kWh
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">
                                            Rp <?= number_format($bayar['biaya_admin'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-primary font-weight-bold">
                                            Rp <?= number_format($bayar['total_bayar'], 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($bayar['nama_admin']) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('pembayaran/detail/' . $bayar['id_pembayaran']) ?>" 
                                               class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('pembayaran/edit/' . $bayar['id_pembayaran']) ?>" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('pembayaran/delete/' . $bayar['id_pembayaran']) ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
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

    <!-- Statistics Cards -->
    <?php if (!empty($pembayaran)): ?>
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
                                    <?= count($pembayaran) ?>
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
                                    Rp <?= number_format(array_sum(array_column($pembayaran, 'total_bayar')), 0, ',', '.') ?>
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
                                    Rp <?= number_format(array_sum(array_column($pembayaran, 'total_bayar')) / count($pembayaran), 0, ',', '.') ?>
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
                                    <?= count(array_unique(array_column($pembayaran, 'id_pelanggan'))) ?>
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
                                <?php endif; ?>
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

 