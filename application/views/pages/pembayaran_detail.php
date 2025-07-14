<?php
$page_title = 'Detail Pembayaran';
$active_page = 'pembayaran';
?>

<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pembayaran</h1>
        <div>
            <a href="<?= base_url('pembayaran/edit/' . $pembayaran['id_pembayaran']) ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit fa-sm"></i> Edit
            </a>
            <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
    </a>
        </div>
</div>

<div class="row">
        <!-- Payment Information -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-receipt mr-2"></i>Informasi Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>ID Pembayaran</strong></td>
                                    <td width="60%">: <?= $pembayaran['id_pembayaran'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Pembayaran</strong></td>
                                    <td>: <?= date('d F Y H:i', strtotime($pembayaran['tanggal_pembayaran'])) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Bulan Bayar</strong></td>
                                    <td>: <?= htmlspecialchars($pembayaran['bulan_bayar']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Petugas</strong></td>
                                    <td>: <?= htmlspecialchars($pembayaran['nama_admin']) ?></td>
                                </tr>
                            </table>
                                </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama Pelanggan</strong></td>
                                    <td width="60%">: <?= htmlspecialchars($pembayaran['nama_pelanggan']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor KWH</strong></td>
                                    <td>: <?= htmlspecialchars($pembayaran['nomor_kwh']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Periode</strong></td>
                                    <td>: <?= htmlspecialchars($pembayaran['bulan']) ?>/<?= htmlspecialchars($pembayaran['tahun']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Daya</strong></td>
                                    <td>: <?= number_format($pembayaran['daya']) ?> VA</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                        </div>
                    </div>
                    
            <!-- Usage Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-tachometer-alt mr-2"></i>Detail Penggunaan
                    </h6>
                                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="h4 text-primary mb-0"><?= number_format($pembayaran['jumlah_meter']) ?></div>
                                <div class="text-muted">kWh</div>
                                <small class="text-muted">Jumlah Meter</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="h4 text-success mb-0">Rp <?= number_format($pembayaran['tarifperkwh'], 0, ',', '.') ?></div>
                                <div class="text-muted">per kWh</div>
                                <small class="text-muted">Tarif</small>
                    </div>
                                </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="h4 text-warning mb-0">Rp <?= number_format($pembayaran['total_tagihan'], 0, ',', '.') ?></div>
                                <div class="text-muted">Total Tagihan</div>
                                <small class="text-muted">Tagihan Listrik</small>
                            </div>
                        </div>
                    </div>
                                </div>
                                </div>
                            </div>

        <!-- Payment Summary -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-calculator mr-2"></i>Ringkasan Pembayaran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Tagihan Listrik</span>
                            <span>Rp <?= number_format($pembayaran['total_tagihan'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Biaya Admin</span>
                            <span>Rp <?= number_format($pembayaran['biaya_admin'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                    <hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>Total Bayar</strong>
                            <strong class="text-primary">Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?></strong>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <div class="badge badge-success badge-lg p-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            LUNAS
                            </div>
                        </div>
                    </div>
                </div>
                
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs mr-2"></i>Aksi Cepat
                    </h6>
                        </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('pembayaran/edit/' . $pembayaran['id_pembayaran']) ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Pembayaran
                        </a>
                        <a href="<?= base_url('pembayaran/delete/' . $pembayaran['id_pembayaran']) ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                            <i class="fas fa-trash"></i> Hapus Pembayaran
                        </a>
                        <a href="<?= base_url('pelanggan/detail/' . $pembayaran['id_pelanggan']) ?>" 
                           class="btn btn-info btn-sm">
                            <i class="fas fa-user"></i> Lihat Pelanggan
                        </a>
                        <a href="<?= base_url('tagihan/detail/' . $pembayaran['id_tagihan']) ?>" 
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-file-invoice"></i> Lihat Tagihan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Information -->
    <div class="row">
        <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Tambahan
                </h6>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Perhitungan Tagihan</h6>
                            <p class="text-muted">
                                Total Tagihan = Jumlah Meter × Tarif per kWh<br>
                                <?= number_format($pembayaran['jumlah_meter']) ?> kWh × Rp <?= number_format($pembayaran['tarifperkwh'], 0, ',', '.') ?> = 
                                Rp <?= number_format($pembayaran['total_tagihan'], 0, ',', '.') ?>
                            </p>
                </div>
                        <div class="col-md-6">
                            <h6 class="text-success">Perhitungan Pembayaran</h6>
                            <p class="text-muted">
                                Total Bayar = Total Tagihan + Biaya Admin<br>
                                Rp <?= number_format($pembayaran['total_tagihan'], 0, ',', '.') ?> + 
                                Rp <?= number_format($pembayaran['biaya_admin'], 0, ',', '.') ?> = 
                                Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?>
                            </p>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>