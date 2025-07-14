<?php
// Pelanggan Detail Page
$page_title = 'Detail Pelanggan';
$active_page = 'pelanggan';

// Get data from controller
$pelanggan_data = isset($pelanggan) ? $pelanggan : [];
$penggunaan_data = isset($penggunaan) ? $penggunaan : [];
$tagihan_data = isset($tagihan) ? $tagihan : [];
$pembayaran_data = isset($pembayaran) ? $pembayaran : [];
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
                <h1 class="h3 mb-0 text-gray-800">Detail Pelanggan</h1>
                <div>
                    <a href="<?= base_url('pelanggan/edit/' . $pelanggan_data['id_pelanggan']) ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?= base_url('pelanggan') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Customer Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Nama Pelanggan</strong></td>
                                    <td>: <?= $pelanggan_data['nama_pelanggan'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td>: <?= $pelanggan_data['username'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor KWH</strong></td>
                                    <td>: <?= $pelanggan_data['nomor_kwh'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Alamat</strong></td>
                                    <td>: <?= $pelanggan_data['alamat'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Daya</strong></td>
                                    <td>: <?= $pelanggan_data['daya'] ?> VA</td>
                                </tr>
                                <tr>
                                    <td><strong>Tarif per kWh</strong></td>
                                    <td>: Rp <?= number_format($pelanggan_data['tarifperkwh'], 0, ',', '.') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Data Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Penggunaan</h6>
                    <a href="<?= base_url('penggunaan/add') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Penggunaan
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($penggunaan_data)): ?>
                        <div class="text-center py-3">
                            <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Belum ada data penggunaan</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total kWh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($penggunaan_data as $penggunaan): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $penggunaan['bulan'] ?> <?= $penggunaan['tahun'] ?></td>
                                            <td><?= number_format($penggunaan['meter_awal'], 0, ',', '.') ?></td>
                                            <td><?= number_format($penggunaan['meter_ahir'], 0, ',', '.') ?></td>
                                            <td><?= number_format($penggunaan['meter_ahir'] - $penggunaan['meter_awal'], 0, ',', '.') ?></td>
                                            <td>
                                                <a href="<?= base_url('penggunaan/detail/' . $penggunaan['id_penggunaan']) ?>" 
                                                   class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bills Data Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Tagihan</h6>
                    <a href="<?= base_url('tagihan/add') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Tagihan
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($tagihan_data)): ?>
                        <div class="text-center py-3">
                            <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Belum ada data tagihan</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Jumlah Meter</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($tagihan_data as $tagihan): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $tagihan['bulan'] ?> <?= $tagihan['tahun'] ?></td>
                                            <td><?= number_format($tagihan['jumlah_meter'], 0, ',', '.') ?> kWh</td>
                                            <td>Rp <?= number_format($tagihan['jumlah_meter'] * $pelanggan_data['tarifperkwh'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php if ($tagihan['status'] == 'sudah_bayar'): ?>
                                                    <span class="badge bg-success">Sudah Bayar</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Belum Bayar</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('tagihan/detail/' . $tagihan['id_tagihan']) ?>" 
                                                   class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($tagihan['status'] == 'belum_bayar'): ?>
                                                    <a href="<?= base_url('tagihan/bayar/' . $tagihan['id_tagihan']) ?>" 
                                                       class="btn btn-success btn-sm" title="Bayar">
                                                        <i class="fas fa-credit-card"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Data Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($pembayaran_data)): ?>
                        <div class="text-center py-3">
                            <i class="fas fa-credit-card fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Belum ada data pembayaran</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Bulan Bayar</th>
                                        <th>Biaya Admin</th>
                                        <th>Total Bayar</th>
                                        <th>Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pembayaran_data as $pembayaran): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($pembayaran['tanggal_pembayaran'])) ?></td>
                                            <td><?= $pembayaran['bulan_bayar'] ?></td>
                                            <td>Rp <?= number_format($pembayaran['biaya_admin'], 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?></td>
                                            <td><?= $pembayaran['nama_admin'] ?? 'Tidak Diketahui' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid --> 