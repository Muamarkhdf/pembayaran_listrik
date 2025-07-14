<?php
$page_title = 'Tambah Pembayaran';
$active_page = 'pembayaran';
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pembayaran</h1>
    <a href="<?= base_url('pembayaran') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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
                    <div class="form-group">
                        <label for="id_tagihan">Pilih Tagihan Belum Dibayar</label>
                        <select class="form-control" id="id_tagihan" name="id_tagihan" required>
                            <option value="">Pilih Tagihan</option>
                            <?php if (isset($tagihan) && !empty($tagihan)): ?>
                                <?php foreach ($tagihan as $t): ?>
                                    <option value="<?= $t['id_tagihan'] ?>"
                                        data-pelanggan="<?= htmlspecialchars($t['nama_pelanggan']) ?>"
                                        data-nomor_kwh="<?= htmlspecialchars($t['nomor_kwh']) ?>"
                                        data-bulan="<?= $t['bulan'] ?>"
                                        data-tahun="<?= $t['tahun'] ?>"
                                        data-daya="<?= $t['daya'] ?>"
                                        data-jumlah_meter="<?= $t['jumlah_meter'] ?>"
                                        data-tarif="<?= $t['tarifperkwh'] ?>"
                                        data-total_tagihan="<?= $t['total_tagihan'] ?>"
                                        data-total_bayar="<?= $t['total_bayar'] ?>">
                                        <?= $t['nama_pelanggan'] ?> - <?= $t['bulan'] ?> <?= $t['tahun'] ?> (<?= number_format($t['jumlah_meter']) ?> kWh)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div id="payment-details" style="display: none;">
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
                                        <input type="text" class="form-control" id="pelanggan-display" readonly>
                                    </div>
                                    <small class="text-muted" id="nomor-kwh-display"></small>
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
                                        <input type="text" class="form-control" id="periode-display" readonly>
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
                                        <input type="text" class="form-control" id="daya-display" readonly>
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
                                        <input type="text" class="form-control" id="penggunaan-display" readonly>
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
                                        <input type="text" class="form-control" id="tarif-display" readonly>
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
                                        <input type="text" class="form-control" value="Rp 10.000" readonly>
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
                                    <h3 class="font-weight-bold text-success mb-0" id="total-bayar-display">
                                        Rp 0
                                    </h3>
                                    <small class="text-muted" id="breakdown-display">
                                        Tagihan: Rp 0 + Admin: Rp 10.000
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
                                    <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?= form_close() ?>
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
                
                <div class="mb-3">
                    <h6 class="text-info">Perhitungan</h6>
                    <p class="text-muted small">
                        Total Bayar = (Penggunaan × Tarif per kWh) + Biaya Admin
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Available Bills -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Tagihan Tersedia
                </h6>
            </div>
            <div class="card-body">
                <?php if (isset($tagihan) && !empty($tagihan)): ?>
                    <div class="list-group">
                        <?php foreach ($tagihan as $t): ?>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= htmlspecialchars($t['nama_pelanggan']) ?></h6>
                                    <small class="text-muted"><?= $t['bulan'] ?> <?= $t['tahun'] ?></small>
                                </div>
                                <p class="mb-1">
                                    <small class="text-muted">
                                        <?= number_format($t['jumlah_meter']) ?> kWh × Rp <?= number_format($t['tarifperkwh'], 0, ',', '.') ?>
                                    </small>
                                </p>
                                <small class="text-success font-weight-bold">
                                    Rp <?= number_format($t['total_tagihan'], 0, ',', '.') ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>Tidak ada tagihan yang belum dibayar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
// Payment details handler
const tagihanSelect = document.getElementById('id_tagihan');
const paymentDetails = document.getElementById('payment-details');

tagihanSelect.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    
    if (this.value) {
        // Show payment details
        paymentDetails.style.display = 'block';
        
        // Update form fields
        document.getElementById('pelanggan-display').value = selected.getAttribute('data-pelanggan');
        document.getElementById('nomor-kwh-display').textContent = selected.getAttribute('data-nomor_kwh');
        document.getElementById('periode-display').value = selected.getAttribute('data-bulan') + ' ' + selected.getAttribute('data-tahun');
        document.getElementById('daya-display').value = selected.getAttribute('data-daya') + ' VA';
        document.getElementById('penggunaan-display').value = selected.getAttribute('data-jumlah_meter');
        document.getElementById('tarif-display').value = 'Rp ' + numberFormat(selected.getAttribute('data-tarif'));
        
        // Update total payment
        const totalTagihan = parseFloat(selected.getAttribute('data-total_tagihan'));
        const biayaAdmin = 10000;
        const totalBayar = totalTagihan + biayaAdmin;
        
        document.getElementById('total-bayar-display').textContent = 'Rp ' + numberFormat(totalBayar);
        document.getElementById('breakdown-display').textContent = 
            'Tagihan: Rp ' + numberFormat(totalTagihan) + ' + Admin: Rp ' + numberFormat(biayaAdmin);
    } else {
        // Hide payment details
        paymentDetails.style.display = 'none';
    }
});

// Number formatting function
function numberFormat(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}
</script> 