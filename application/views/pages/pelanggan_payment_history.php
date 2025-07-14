<?php
// Pelanggan Payment History Page
$page_title = 'Riwayat Pembayaran';
$active_page = 'payment_history';

// Get data from controller
$pembayaran = isset($pembayaran) ? $pembayaran : [];
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Alert untuk notifikasi -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-credit-card mr-2"></i>Riwayat Pembayaran
                </h1>
                <div>
                    <button class="btn btn-success" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <button class="btn btn-info" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-credit-card mr-1"></i>Total Pembayaran
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($pembayaran) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-credit-card fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-dollar-sign mr-1"></i>Total Bayar
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
                                        <i class="fas fa-calendar mr-1"></i>Bulan Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count(array_filter($pembayaran, function($p) { 
                                            return date('Y-m', strtotime($p['tanggal_pembayaran'])) == date('Y-m'); 
                                        })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-clock mr-1"></i>Terakhir Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= !empty($pembayaran) ? date('d M', strtotime($pembayaran[0]['tanggal_pembayaran'])) : '-' ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Daftar Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($pembayaran)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada data pembayaran</h5>
                            <p class="text-muted">Riwayat pembayaran akan muncul setelah Anda melakukan pembayaran tagihan</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Periode Tagihan</th>
                                        <th>Jumlah Meter</th>
                                        <th>Biaya Admin</th>
                                        <th>Total Bayar</th>
                                        <th>Petugas</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pembayaran as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= date('d M Y', strtotime($p['tanggal_pembayaran'] ?? '')) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= date('H:i', strtotime($p['tanggal_pembayaran'] ?? '')) ?> WIB</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">
                                                    <?= htmlspecialchars($p['bulan'] ?? '') ?> <?= htmlspecialchars($p['tahun'] ?? '') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">
                                                    <?= number_format($p['jumlah_meter'] ?? 0, 0, ',', '.') ?> kWh
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                Rp <?= number_format($p['biaya_admin'] ?? 0, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-right font-weight-bold text-success">
                                                Rp <?= number_format($p['total_bayar'] ?? 0, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">
                                                    <?= htmlspecialchars($p['nama_admin'] ?? 'Admin') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $p['id_pembayaran'] ?>">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
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
    </div>
</div>

<!-- ======================================== -->
<!-- DETAIL MODALS -->
<!-- ======================================== -->
<?php foreach ($pembayaran as $p): ?>
<div class="modal fade" id="detailModal<?= $p['id_pembayaran'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $p['id_pembayaran'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel<?= $p['id_pembayaran'] ?>">
                    <i class="fas fa-credit-card mr-2"></i>Detail Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID Pembayaran</strong></td>
                                <td>: <?= $p['id_pembayaran'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Bayar</strong></td>
                                <td>: <?= date('d M Y H:i', strtotime($p['tanggal_pembayaran'] ?? '')) ?> WIB</td>
                            </tr>
                            <tr>
                                <td><strong>Periode Tagihan</strong></td>
                                <td>: <?= htmlspecialchars($p['bulan'] ?? '') ?> <?= htmlspecialchars($p['tahun'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Meter</strong></td>
                                <td>: <?= number_format($p['jumlah_meter'] ?? 0, 0, ',', '.') ?> kWh</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Tagihan</strong></td>
                                <td>: Rp <?= number_format($p['total_tagihan'] ?? 0, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Biaya Admin</strong></td>
                                <td>: Rp <?= number_format($p['biaya_admin'] ?? 0, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Bayar</strong></td>
                                <td>: <span class="font-weight-bold text-success">Rp <?= number_format($p['total_bayar'] ?? 0, 0, ',', '.') ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Petugas</strong></td>
                                <td>: <?= htmlspecialchars($p['nama_admin'] ?? 'Admin') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Payment Breakdown -->
                <hr>
                <h6 class="text-primary">
                    <i class="fas fa-calculator mr-2"></i>Rincian Pembayaran
                </h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tagihan Listrik:</strong><br>
                                    <?= number_format($p['jumlah_meter'] ?? 0, 0, ',', '.') ?> kWh × Rp <?= number_format($p['tarifperkwh'] ?? 0, 0, ',', '.') ?> = 
                                    <span class="font-weight-bold">Rp <?= number_format($p['total_tagihan'] ?? 0, 0, ',', '.') ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Biaya Admin:</strong><br>
                                    <span class="font-weight-bold">Rp <?= number_format($p['biaya_admin'] ?? 0, 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <h5 class="text-success">
                                    <strong>TOTAL BAYAR: Rp <?= number_format($p['total_bayar'] ?? 0, 0, ',', '.') ?></strong>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="printReceipt(<?= $p['id_pembayaran'] ?>)">
                    <i class="fas fa-print"></i> Cetak Bukti
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- ======================================== -->
<!-- SCRIPTS -->
<!-- ======================================== -->
<script>
function exportToPDF() {
    // Implementation for PDF export
    alert('Fitur export PDF akan segera tersedia!');
}

function printReceipt(paymentId) {
    // Implementation for printing receipt
    alert('Fitur cetak bukti pembayaran akan segera tersedia!');
}
</script> 