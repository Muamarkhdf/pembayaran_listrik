<?php
// Bill Form Page
$page_title = isset($tagihan) ? 'Edit Tagihan' : 'Tambah Tagihan';
$active_page = 'tagihan';
?>

<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
    <a href="<?= base_url('tagihan') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div> -->

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

<!-- Form Card -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i>Form Tagihan Listrik
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('', ['method' => 'post']) ?>
                    <div class="row">
                        <?php if (!isset($tagihan)): ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_pelanggan">Pelanggan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                                        <option value="">Pilih Pelanggan</option>
                                        <?php if (isset($pelanggan) && !empty($pelanggan)): ?>
                                            <?php foreach ($pelanggan as $p): ?>
                                                <option value="<?= $p['id_pelanggan'] ?>" 
                                                        data-tarif="<?= $p['tarifperkwh'] ?>"
                                                        data-daya="<?= $p['daya'] ?>">
                                                    <?= $p['nama_pelanggan'] ?> - <?= $p['nomor_kwh'] ?> (<?= $p['daya'] ?> VA)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php if (form_error('id_pelanggan')): ?>
                                    <small class="text-danger"><?= form_error('id_pelanggan') ?></small>
                                <?php endif; ?>
                                <small class="text-muted">Pilih pelanggan yang akan ditagih</small>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan">Bulan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="bulan" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        <option value="Januari" <?= set_select('bulan', 'Januari') ?>>Januari</option>
                                        <option value="Februari" <?= set_select('bulan', 'Februari') ?>>Februari</option>
                                        <option value="Maret" <?= set_select('bulan', 'Maret') ?>>Maret</option>
                                        <option value="April" <?= set_select('bulan', 'April') ?>>April</option>
                                        <option value="Mei" <?= set_select('bulan', 'Mei') ?>>Mei</option>
                                        <option value="Juni" <?= set_select('bulan', 'Juni') ?>>Juni</option>
                                        <option value="Juli" <?= set_select('bulan', 'Juli') ?>>Juli</option>
                                        <option value="Agustus" <?= set_select('bulan', 'Agustus') ?>>Agustus</option>
                                        <option value="September" <?= set_select('bulan', 'September') ?>>September</option>
                                        <option value="Oktober" <?= set_select('bulan', 'Oktober') ?>>Oktober</option>
                                        <option value="November" <?= set_select('bulan', 'November') ?>>November</option>
                                        <option value="Desember" <?= set_select('bulan', 'Desember') ?>>Desember</option>
                                    </select>
                                </div>
                                <?php if (form_error('bulan')): ?>
                                    <small class="text-danger"><?= form_error('bulan') ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">Tahun <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" id="tahun" name="tahun" 
                                           value="<?= set_value('tahun', isset($tagihan) ? $tagihan['tahun'] : date('Y')) ?>" 
                                           min="2020" max="2030" required>
                                </div>
                                <?php if (form_error('tahun')): ?>
                                    <small class="text-danger"><?= form_error('tahun') ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meter_awal">Meter Awal (kWh) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" id="meter_awal" name="meter_awal" 
                                           value="<?= set_value('meter_awal', isset($tagihan) ? $tagihan['meter_awal'] : '') ?>" 
                                           placeholder="Contoh: 1000" min="0" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">kWh</span>
                                    </div>
                                </div>
                                <?php if (form_error('meter_awal')): ?>
                                    <small class="text-danger"><?= form_error('meter_awal') ?></small>
                                <?php endif; ?>
                                <small class="text-muted">Angka meteran di awal periode</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meter_akhir">Meter Akhir (kWh) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" id="meter_akhir" name="meter_akhir" 
                                           value="<?= set_value('meter_akhir', isset($tagihan) ? $tagihan['meter_ahir'] : '') ?>" 
                                           placeholder="Contoh: 1500" min="0" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">kWh</span>
                                    </div>
                                </div>
                                <?php if (form_error('meter_akhir')): ?>
                                    <small class="text-danger"><?= form_error('meter_akhir') ?></small>
                                <?php endif; ?>
                                <small class="text-muted">Angka meteran di akhir periode</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> <?= isset($tagihan) ? 'Update' : 'Simpan' ?>
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
        <!-- Customer Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Pelanggan
                </h6>
            </div>
            <div class="card-body">
                <div id="customer-info" class="text-center">
                    <i class="fas fa-user fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">Pilih pelanggan untuk melihat informasi</p>
                </div>
            </div>
        </div>
        
        <!-- Calculation Preview -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calculator mr-2"></i>Preview Perhitungan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">Estimasi Tagihan:</h6>
                    <div id="calculation-result">
                        <p class="mb-1">Daya: <span id="preview-daya">-</span> VA</p>
                        <p class="mb-1">Tarif: Rp <span id="preview-tarif">-</span>/kWh</p>
                        <p class="mb-1">Penggunaan: <span id="preview-usage">-</span> kWh</p>
                        <p class="mb-0 font-weight-bold">Total: Rp <span id="preview-total">-</span></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bill Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i>Informasi Tagihan
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Meter Awal</h6>
                    <p class="text-muted small">Angka meteran listrik di awal periode tagihan</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-success">Meter Akhir</h6>
                    <p class="text-muted small">Angka meteran listrik di akhir periode tagihan</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-info">Penggunaan</h6>
                    <p class="text-muted small">Selisih antara meter akhir dan meter awal</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-warning">Total Tagihan</h6>
                    <p class="text-muted small">Penggunaan × Tarif per kWh + Biaya Admin</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Customer selection and calculation preview
document.addEventListener('DOMContentLoaded', function() {
    const customerSelect = document.getElementById('id_pelanggan');
    const meterAwalInput = document.getElementById('meter_awal');
    const meterAkhirInput = document.getElementById('meter_akhir');
    
    function updateCustomerInfo() {
        const selectedOption = customerSelect.options[customerSelect.selectedIndex];
        const customerInfo = document.getElementById('customer-info');
        
        if (selectedOption.value) {
            const customerName = selectedOption.text.split(' - ')[0];
            const customerNumber = selectedOption.text.split(' - ')[1].split(' (')[0];
            const daya = selectedOption.dataset.daya;
            const tarif = selectedOption.dataset.tarif;
            
            customerInfo.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-user fa-2x text-primary mb-2"></i>
                    <h6 class="font-weight-bold">${customerName}</h6>
                    <p class="text-muted small mb-1">${customerNumber}</p>
                    <span class="badge badge-primary">${daya} VA</span>
                    <br>
                    <small class="text-muted">Tarif: Rp ${parseFloat(tarif).toLocaleString('id-ID')}/kWh</small>
                </div>
            `;
        } else {
            customerInfo.innerHTML = `
                <i class="fas fa-user fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted">Pilih pelanggan untuk melihat informasi</p>
            `;
        }
    }
    
    function updateCalculation() {
        const selectedOption = customerSelect.options[customerSelect.selectedIndex];
        const meterAwal = parseFloat(meterAwalInput.value) || 0;
        const meterAkhir = parseFloat(meterAkhirInput.value) || 0;
        
        if (selectedOption.value && meterAwal > 0 && meterAkhir > 0) {
            const daya = selectedOption.dataset.daya;
            const tarif = parseFloat(selectedOption.dataset.tarif);
            const usage = meterAkhir - meterAwal;
            const total = usage * tarif;
            
            document.getElementById('preview-daya').textContent = daya;
            document.getElementById('preview-tarif').textContent = tarif.toLocaleString('id-ID');
            document.getElementById('preview-usage').textContent = usage.toLocaleString('id-ID');
            document.getElementById('preview-total').textContent = total.toLocaleString('id-ID');
        } else {
            document.getElementById('preview-daya').textContent = '-';
            document.getElementById('preview-tarif').textContent = '-';
            document.getElementById('preview-usage').textContent = '-';
            document.getElementById('preview-total').textContent = '-';
        }
    }
    
    if (customerSelect) {
        customerSelect.addEventListener('change', function() {
            updateCustomerInfo();
            updateCalculation();
        });
    }
    
    meterAwalInput.addEventListener('input', updateCalculation);
    meterAkhirInput.addEventListener('input', updateCalculation);
    
    // Initial updates
    updateCustomerInfo();
    updateCalculation();
});
</script> 