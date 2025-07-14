<?php
// Penggunaan Detail Page
$page_title = 'Detail Penggunaan';
$active_page = 'penggunaan';

// Get data from controller
$penggunaan_data = isset($penggunaan) ? $penggunaan : [];
$tagihan_data = isset($tagihan) ? $tagihan : [];
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0 text-gray-800">Detail Penggunaan Listrik</h1>
                <div>
                    <a href="<?= base_url('penggunaan/edit/' . $penggunaan_data['id_penggunaan']) ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?= base_url('penggunaan') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Usage Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penggunaan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Pelanggan</strong></td>
                                    <td>: <?= $penggunaan_data['nama_pelanggan'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor KWH</strong></td>
                                    <td>: <?= $penggunaan_data['nomor_kwh'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Periode</strong></td>
                                    <td>: <?= $penggunaan_data['bulan'] ?> <?= $penggunaan_data['tahun'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Daya</strong></td>
                                    <td>: <?= $penggunaan_data['daya'] ?> VA</td>
                                </tr>
                                <tr>
                                    <td><strong>Tarif per kWh</strong></td>
                                    <td>: Rp <?= number_format($penggunaan_data['tarifperkwh'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Penggunaan</strong></td>
                                    <td>: <span class="font-weight-bold text-warning"><?= number_format($penggunaan_data['meter_ahir'] - $penggunaan_data['meter_awal']) ?> kWh</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meter Reading Details -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-tachometer-alt mr-1"></i>Meter Awal
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($penggunaan_data['meter_awal']) ?> kWh
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tachometer-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <i class="fas fa-tachometer-alt mr-1"></i>Meter Akhir
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($penggunaan_data['meter_ahir']) ?> kWh
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tachometer-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        <i class="fas fa-bolt mr-1"></i>Penggunaan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($penggunaan_data['meter_ahir'] - $penggunaan_data['meter_awal']) ?> kWh
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-bolt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tagihan Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Tagihan</h6>
                    <?php if ($tagihan_data): ?>
                        <a href="<?= base_url('tagihan/detail/' . $tagihan_data['id_tagihan']) ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail Tagihan
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if ($tagihan_data): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Status Tagihan</strong></td>
                                        <td>: 
                                            <?php if ($tagihan_data['status'] == 'sudah_bayar'): ?>
                                                <span class="badge bg-success">Sudah Bayar</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Belum Bayar</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah Meter</strong></td>
                                        <td>: <?= number_format($tagihan_data['jumlah_meter']) ?> kWh</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Tagihan</strong></td>
                                        <td>: <span class="font-weight-bold text-danger">Rp <?= number_format($tagihan_data['jumlah_meter'] * $penggunaan_data['tarifperkwh'], 0, ',', '.') ?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">Perhitungan Tagihan:</h6>
                                    <p class="mb-0">
                                        <?= number_format($tagihan_data['jumlah_meter']) ?> kWh × Rp <?= number_format($penggunaan_data['tarifperkwh'], 0, ',', '.') ?> = 
                                        <strong>Rp <?= number_format($tagihan_data['jumlah_meter'] * $penggunaan_data['tarifperkwh'], 0, ',', '.') ?></strong>
                                    </p>
                                </div>
                                <?php if ($tagihan_data['status'] == 'belum_bayar'): ?>
                                    <a href="<?= base_url('tagihan/bayar/' . $tagihan_data['id_tagihan']) ?>" class="btn btn-success">
                                        <i class="fas fa-credit-card"></i> Proses Pembayaran
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada tagihan untuk penggunaan ini</p>
                            <p class="text-muted small">Tagihan akan dibuat otomatis saat menambah data penggunaan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="<?= base_url('penggunaan/edit/' . $penggunaan_data['id_penggunaan']) ?>" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Penggunaan
                                    </a>
                                    <a href="<?= base_url('penggunaan/delete/' . $penggunaan_data['id_penggunaan']) ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data penggunaan ini?')">
                                        <i class="fas fa-trash"></i> Hapus Penggunaan
                                    </a>
                                </div>
                                <div>
                                    <a href="<?= base_url('penggunaan') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid --> 