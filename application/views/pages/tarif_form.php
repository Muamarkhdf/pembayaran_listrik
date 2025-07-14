<?php
// Tariff Form Page
$page_title = isset($tarif) ? 'Edit Tarif' : 'Tambah Tarif';
$active_page = 'tarif';
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
    <a href="<?= base_url('tarif') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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

<!-- Form Card -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt mr-2"></i>Form Tarif Listrik
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('', ['method' => 'post']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="daya">Daya (VA) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" id="daya" name="daya" 
                                           value="<?= set_value('daya', isset($tarif) ? $tarif['daya'] : '') ?>" 
                                           placeholder="Contoh: 900, 1300, 2200" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">VA</span>
                                    </div>
                                </div>
                                <?php if (form_error('daya')): ?>
                                    <small class="text-danger"><?= form_error('daya') ?></small>
                                <?php endif; ?>
                                <small class="text-muted">Masukkan daya dalam satuan VA (Volt Ampere)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tarifperkwh">Tarif per kWh <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="tarifperkwh" name="tarifperkwh" 
                                           value="<?= set_value('tarifperkwh', isset($tarif) ? $tarif['tarifperkwh'] : '') ?>" 
                                           placeholder="Contoh: 1352.00" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/kWh</span>
                                    </div>
                                </div>
                                <?php if (form_error('tarifperkwh')): ?>
                                    <small class="text-danger"><?= form_error('tarifperkwh') ?></small>
                                <?php endif; ?>
                                <small class="text-muted">Masukkan tarif dalam Rupiah per kWh</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> <?= isset($tarif) ? 'Update' : 'Simpan' ?>
                                </button>
                                <a href="<?= base_url('tarif') ?>" class="btn btn-secondary">
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
        <!-- Tariff Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Tarif
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Daya (VA)</h6>
                    <p class="text-muted small">Daya listrik yang tersedia untuk pelanggan. Semakin tinggi daya, semakin besar kapasitas listrik yang dapat digunakan.</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-success">Tarif per kWh</h6>
                    <p class="text-muted small">Harga per unit konsumsi listrik. Tarif ini akan dikalikan dengan jumlah kWh yang digunakan pelanggan.</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-info">Contoh Tarif Standar</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-circle text-primary"></i> 900 VA: Rp 1.352/kWh</li>
                        <li><i class="fas fa-circle text-success"></i> 1300 VA: Rp 1.444/kWh</li>
                        <li><i class="fas fa-circle text-info"></i> 2200 VA: Rp 1.699/kWh</li>
                    </ul>
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
                <div class="form-group">
                    <label for="preview_kwh">Konsumsi (kWh)</label>
                    <input type="number" class="form-control" id="preview_kwh" value="100" min="1">
                </div>
                
                <div class="alert alert-info">
                    <h6 class="alert-heading">Estimasi Tagihan:</h6>
                    <div id="preview_result">
                        <p class="mb-1">Daya: <span id="preview_daya">-</span> VA</p>
                        <p class="mb-1">Tarif: Rp <span id="preview_tarif">-</span>/kWh</p>
                        <p class="mb-0 font-weight-bold">Total: Rp <span id="preview_total">-</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview calculation
document.addEventListener('DOMContentLoaded', function() {
    const dayaInput = document.getElementById('daya');
    const tarifInput = document.getElementById('tarifperkwh');
    const kwhInput = document.getElementById('preview_kwh');
    
    function updatePreview() {
        const daya = dayaInput.value || 0;
        const tarif = tarifInput.value || 0;
        const kwh = kwhInput.value || 0;
        
        const total = daya * tarif * kwh;
        
        document.getElementById('preview_daya').textContent = daya;
        document.getElementById('preview_tarif').textContent = tarif.toLocaleString('id-ID');
        document.getElementById('preview_total').textContent = total.toLocaleString('id-ID');
    }
    
    dayaInput.addEventListener('input', updatePreview);
    tarifInput.addEventListener('input', updatePreview);
    kwhInput.addEventListener('input', updatePreview);
    
    // Initial preview
    updatePreview();
});
</script> 