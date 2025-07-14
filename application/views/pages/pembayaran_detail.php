<?php
$page_title = 'Detail Pembayaran';
$active_page = 'pembayaran';
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pembayaran</h1>
    <a href="<?= base_url('pembayaran') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<?php if (isset($pembayaran) && $pembayaran): ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Payment Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-money-bill mr-2"></i>Detail Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($pembayaran['nama_pelanggan']) ?>" readonly>
                            </div>
                            <small class="text-muted"><?= htmlspecialchars($pembayaran['nomor_kwh']) ?></small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Periode</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" value="<?= $pembayaran['bulan'] ?> <?= $pembayaran['tahun'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Daya</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-bolt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" value="<?= number_format($pembayaran['daya']) ?> VA" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Penggunaan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-tachometer-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" value="<?= number_format($pembayaran['jumlah_meter']) ?> kWh" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">kWh</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tarif per kWh</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" value="Rp <?= number_format($pembayaran['tarifperkwh'], 0, ',', '.') ?>" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">/kWh</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Biaya Admin</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-cog"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" value="Rp <?= number_format($pembayaran['biaya_admin'], 0, ',', '.') ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            <h5 class="alert-heading">
                                <i class="fas fa-calculator mr-2"></i>Total Pembayaran
                            </h5>
                            <h3 class="font-weight-bold text-success mb-0">
                                Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?>
                            </h3>
                            <small class="text-muted">
                                Tagihan: Rp <?= number_format($pembayaran['total_tagihan'], 0, ',', '.') ?> + 
                                Admin: Rp <?= number_format($pembayaran['biaya_admin'], 0, ',', '.') ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Payment Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Tanggal Pembayaran</h6>
                    <p class="text-muted small"><?= date('d F Y H:i', strtotime($pembayaran['tanggal_pembayaran'])) ?></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-success">Petugas</h6>
                    <p class="text-muted small"><?= htmlspecialchars($pembayaran['nama_admin']) ?></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-info">Status</h6>
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                    </span>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-warning">ID Pembayaran</h6>
                    <p class="text-muted small">#<?= $pembayaran['id_pembayaran'] ?></p>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-cogs mr-2"></i>Aksi
                </h6>
            </div>
            <div class="card-body">
                <a href="<?= base_url('pembayaran/delete/' . $pembayaran['id_pembayaran']) ?>" class="btn btn-danger btn-block mb-2" onclick="return confirm('Hapus pembayaran ini?')">
                    <i class="fas fa-trash"></i> Hapus Pembayaran
                </a>
                <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i> Data pembayaran tidak ditemukan.
</div>
<?php endif; ?> 