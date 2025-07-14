<?php
// Payment Form Page
$page_title = 'Proses Pembayaran';
$active_page = 'tagihan';
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Proses Pembayaran</h1>
    <a href="<?= base_url('tagihan') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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

<!-- Payment Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-money-bill mr-2"></i>Form Pembayaran Tagihan
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('', ['method' => 'post']) ?>
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
                                    <input type="text" class="form-control" value="<?= $tagihan['nama_pelanggan'] ?>" readonly>
                                </div>
                                <small class="text-muted"><?= $tagihan['nomor_kwh'] ?></small>
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
                                    <input type="text" class="form-control" value="<?= $tagihan['bulan'] ?> <?= $tagihan['tahun'] ?>" readonly>
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
                                    <input type="text" class="form-control" value="<?= number_format($tagihan['daya']) ?> VA" readonly>
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
                                    <input type="text" class="form-control" value="<?= number_format($jumlah_meter) ?> kWh" readonly>
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
                                    <input type="text" class="form-control" value="Rp <?= number_format($tarif, 0, ',', '.') ?>" readonly>
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
                                    <input type="text" class="form-control" value="Rp <?= number_format($biaya_admin, 0, ',', '.') ?>" readonly>
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
                                    Rp <?= number_format($total_bayar, 0, ',', '.') ?>
                                </h3>
                                <small class="text-muted">
                                    Tagihan: Rp <?= number_format($tarif * $jumlah_meter, 0, ',', '.') ?> + 
                                    Admin: Rp <?= number_format($biaya_admin, 0, ',', '.') ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-money-bill"></i> Proses Pembayaran
                                </button>
                                <a href="<?= base_url('tagihan') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Bill Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i>Detail Tagihan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card border-left-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">Meter Awal</h6>
                                <p class="card-text font-weight-bold"><?= number_format($tagihan['meter_awal']) ?> kWh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">Meter Akhir</h6>
                                <p class="card-text font-weight-bold"><?= number_format($tagihan['meter_ahir']) ?> kWh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <h6 class="card-title text-info">Penggunaan</h6>
                                <p class="card-text font-weight-bold"><?= number_format($jumlah_meter) ?> kWh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">Total Tagihan</h6>
                                <p class="card-text font-weight-bold">Rp <?= number_format($tarif * $jumlah_meter, 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
                    <p class="text-muted small"><?= date('d F Y H:i') ?></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-success">Petugas</h6>
                    <p class="text-muted small"><?= $this->session->userdata('nama_admin') ?></p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-info">Status</h6>
                    <span class="badge badge-warning">
                        <i class="fas fa-clock mr-1"></i>Belum Bayar
                    </span>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-warning">Biaya Admin</h6>
                    <p class="text-muted small">Biaya administrasi tetap sebesar Rp 10.000</p>
                </div>
            </div>
        </div>
        
        <!-- Payment Summary -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calculator mr-2"></i>Ringkasan Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td>Tagihan Listrik</td>
                        <td class="text-right">Rp <?= number_format($tarif * $jumlah_meter, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Admin</td>
                        <td class="text-right">Rp <?= number_format($biaya_admin, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="border-top">
                        <td><strong>Total Bayar</strong></td>
                        <td class="text-right"><strong>Rp <?= number_format($total_bayar, 0, ',', '.') ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Payment confirmation
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.querySelector('form');
    
    paymentForm.addEventListener('submit', function(e) {
        const confirmed = confirm('Apakah Anda yakin ingin memproses pembayaran ini?');
        if (!confirmed) {
            e.preventDefault();
        }
    });
});
</script> 