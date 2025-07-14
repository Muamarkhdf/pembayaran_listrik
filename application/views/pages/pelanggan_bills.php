<?php
// Pelanggan Bills Page
$page_title = 'Tagihan Saya';
$active_page = 'bills';

// Get data from controller
$tagihan = isset($tagihan) ? $tagihan : [];
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
                    <i class="fas fa-file-invoice mr-2"></i>Tagihan Saya
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
                                        <i class="fas fa-file-invoice mr-1"></i>Total Tagihan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($tagihan) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count(array_filter($tagihan, function($t) { return $t['status'] == 'sudah_bayar'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Belum Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count(array_filter($tagihan, function($t) { return $t['status'] == 'belum_bayar'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-dollar-sign mr-1"></i>Total Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format(array_sum(array_column($tagihan, 'total_tagihan')), 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bills Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Daftar Tagihan
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($tagihan)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada data tagihan</h5>
                            <p class="text-muted">Tagihan akan muncul setelah admin membuat tagihan untuk Anda</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Jumlah Meter (kWh)</th>
                                        <th>Tarif per kWh</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($tagihan as $t): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($t['bulan'] ?? '') ?> <?= htmlspecialchars($t['tahun'] ?? '') ?></strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info">
                                                    <?= number_format($t['jumlah_meter'] ?? 0, 0, ',', '.') ?> kWh
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                Rp <?= number_format($t['tarifperkwh'] ?? 0, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                Rp <?= number_format($t['total_tagihan'] ?? 0, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($t['status'] == 'sudah_bayar'): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>Belum Bayar
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $t['id_tagihan'] ?>">
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
<?php foreach ($tagihan as $t): ?>
<div class="modal fade" id="detailModal<?= $t['id_tagihan'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $t['id_tagihan'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel<?= $t['id_tagihan'] ?>">
                    <i class="fas fa-file-invoice mr-2"></i>Detail Tagihan
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
                                <td width="150"><strong>Periode</strong></td>
                                <td>: <?= htmlspecialchars($t['bulan'] ?? '') ?> <?= htmlspecialchars($t['tahun'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Meter</strong></td>
                                <td>: <?= number_format($t['jumlah_meter'] ?? 0, 0, ',', '.') ?> kWh</td>
                            </tr>
                            <tr>
                                <td><strong>Tarif per kWh</strong></td>
                                <td>: Rp <?= number_format($t['tarifperkwh'] ?? 0, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Tagihan</strong></td>
                                <td>: <span class="font-weight-bold text-primary">Rp <?= number_format($t['total_tagihan'] ?? 0, 0, ',', '.') ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Status</strong></td>
                                <td>: 
                                    <?php if ($t['status'] == 'sudah_bayar'): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Belum Bayar
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Tagihan</strong></td>
                                <td>: <?= date('d M Y', strtotime($t['created_at'] ?? 'now')) ?></td>
                            </tr>
                            <tr>
                                <td><strong>ID Tagihan</strong></td>
                                <td>: <?= $t['id_tagihan'] ?? '-' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Payment Information (if paid) -->
                <?php if ($t['status'] == 'sudah_bayar'): ?>
                <hr>
                <h6 class="text-success">
                    <i class="fas fa-credit-card mr-2"></i>Informasi Pembayaran
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Tanggal Bayar</strong></td>
                                <td>: <?= date('d M Y', strtotime($t['tanggal_pembayaran'] ?? 'now')) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Biaya Admin</strong></td>
                                <td>: Rp <?= number_format($t['biaya_admin'] ?? 0, 0, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Total Bayar</strong></td>
                                <td>: <span class="font-weight-bold text-success">Rp <?= number_format($t['total_bayar'] ?? 0, 0, ',', '.') ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Petugas</strong></td>
                                <td>: <?= htmlspecialchars($t['nama_admin'] ?? 'Admin') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <?php if ($t['status'] == 'belum_bayar'): ?>
                    <button type="button" class="btn btn-success" onclick="showPaymentInfo()">
                        <i class="fas fa-credit-card"></i> Informasi Pembayaran
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Payment Information Modal -->
<div class="modal fade" id="paymentInfoModal" tabindex="-1" role="dialog" aria-labelledby="paymentInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentInfoModalLabel">
                    <i class="fas fa-credit-card mr-2"></i>Informasi Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle mr-2"></i>Cara Pembayaran</h6>
                    <p class="mb-2">Untuk melakukan pembayaran tagihan, silakan:</p>
                    <ol>
                        <li>Kunjungi kantor PLN terdekat</li>
                        <li>Bawa nomor KWH Anda</li>
                        <li>Berikan informasi periode tagihan</li>
                        <li>Lakukan pembayaran sesuai jumlah tagihan</li>
                    </ol>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle mr-2"></i>Penting!</h6>
                    <ul class="mb-0">
                        <li>Pembayaran dapat dilakukan di kantor PLN atau mitra pembayaran</li>
                        <li>Simpan bukti pembayaran sebagai arsip</li>
                        <li>Status pembayaran akan diupdate oleh petugas</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================== -->
<!-- SCRIPTS -->
<!-- ======================================== -->
<script>
function showPaymentInfo() {
    $('#paymentInfoModal').modal('show');
}

function exportToPDF() {
    // Implementation for PDF export
    alert('Fitur export PDF akan segera tersedia!');
}
</script> 