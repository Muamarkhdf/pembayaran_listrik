<?php
// Usage Detail Page
$page_title = 'Detail Penggunaan';
$active_page = 'penggunaan';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detail Penggunaan Listrik</h1>
                <a href="<?= base_url('penggunaan') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>

            <!-- Alert Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($penggunaan) && $penggunaan): ?>
                <!-- Detail Cards -->
                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-user mr-2"></i>Informasi Pelanggan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Nama Pelanggan:</label>
                                        <p class="text-primary"><?= htmlspecialchars($penggunaan['nama_pelanggan']) ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Nomor KWH:</label>
                                        <p class="text-info"><?= htmlspecialchars($penggunaan['nomor_kwh']) ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Daya:</label>
                                        <p class="text-success"><?= number_format($penggunaan['daya']) ?> VA</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Tarif per kWh:</label>
                                        <p class="text-warning">Rp <?= number_format($penggunaan['tarifperkwh'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Informasi Penggunaan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Periode:</label>
                                        <p class="text-primary"><?= $penggunaan['bulan'] ?> <?= $penggunaan['tahun'] ?></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Meter Awal:</label>
                                        <p class="text-info"><?= number_format($penggunaan['meter_awal']) ?> kWh</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Meter Akhir:</label>
                                        <p class="text-success"><?= number_format($penggunaan['meter_ahir']) ?> kWh</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-gray-800">Total Penggunaan:</label>
                                        <p class="text-warning font-weight-bold"><?= number_format($penggunaan['meter_ahir'] - $penggunaan['meter_awal']) ?> kWh</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calculation Card -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-calculator mr-2"></i>Perhitungan Tagihan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">Rumus Perhitungan:</h6>
                                        <div class="alert alert-info">
                                            <strong>Penggunaan = Meter Akhir - Meter Awal</strong><br>
                                            <strong>Total Tagihan = Penggunaan × Tarif per kWh</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-success">Hasil Perhitungan:</h6>
                                        <div class="alert alert-success">
                                            <strong>Penggunaan:</strong> <?= number_format($penggunaan['meter_ahir'] - $penggunaan['meter_awal']) ?> kWh<br>
                                            <strong>Tarif per kWh:</strong> Rp <?= number_format($penggunaan['tarifperkwh'], 0, ',', '.') ?><br>
                                            <strong>Total Tagihan:</strong> Rp <?= number_format(($penggunaan['meter_ahir'] - $penggunaan['meter_awal']) * $penggunaan['tarifperkwh'], 0, ',', '.') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-cogs mr-2"></i>Aksi
                                </h6>
                            </div>
                            <div class="card-body">
                                <a href="<?= base_url('penggunaan/edit/' . $penggunaan['id_penggunaan']) ?>" 
                                   class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Penggunaan
                                </a>
                                <a href="<?= base_url('penggunaan/delete/' . $penggunaan['id_penggunaan']) ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data penggunaan ini?')">
                                    <i class="fas fa-trash"></i> Hapus Penggunaan
                                </a>
                                <a href="<?= base_url('penggunaan') ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- No Data -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-gray-300 mb-3"></i>
                                <h5 class="text-gray-600">Data Penggunaan Tidak Ditemukan</h5>
                                <p class="text-muted">Data penggunaan yang Anda cari tidak ditemukan atau telah dihapus.</p>
                                <a href="<?= base_url('penggunaan') ?>" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid --> 