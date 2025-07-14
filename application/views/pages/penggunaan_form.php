<?php
// Usage Form Page
$page_title = isset($penggunaan) ? 'Edit Penggunaan' : 'Tambah Penggunaan';
$active_page = 'penggunaan';

// Sample data untuk edit - dalam implementasi nyata, data ini akan diambil dari database
$data = [];
if (isset($penggunaan)) {
    $data = [
        'id_penggunaan' => $penggunaan['id_penggunaan'],
        'id_pelanggan' => $penggunaan['id_pelanggan'],
        'bulan' => $penggunaan['bulan'],
        'tahun' => $penggunaan['tahun'],
        'meter_awal' => $penggunaan['meter_awal'],
        'meter_ahir' => $penggunaan['meter_ahir']
    ];
}

// Sample data pelanggan untuk dropdown
$pelanggan_options = [];
if (isset($pelanggan)) {
    foreach ($pelanggan as $p) {
        $pelanggan_options[$p['id_pelanggan']] = $p['nama_pelanggan'] . ' - ' . $p['nomor_kwh'];
    }
}

// Konfigurasi field untuk form
$fields = [
    [
        'name' => 'id_pelanggan',
        'label' => 'Pelanggan',
        'type' => 'select',
        'required' => true,
        'options' => $pelanggan_options
    ],
    [
        'name' => 'bulan',
        'label' => 'Bulan',
        'type' => 'select',
        'required' => true,
        'options' => [
            'Januari' => 'Januari',
            'Februari' => 'Februari',
            'Maret' => 'Maret',
            'April' => 'April',
            'Mei' => 'Mei',
            'Juni' => 'Juni',
            'Juli' => 'Juli',
            'Agustus' => 'Agustus',
            'September' => 'September',
            'Oktober' => 'Oktober',
            'November' => 'November',
            'Desember' => 'Desember'
        ]
    ],
    [
        'name' => 'tahun',
        'label' => 'Tahun',
        'type' => 'number',
        'required' => true,
        'placeholder' => 'Masukkan tahun (contoh: 2025)',
        'min' => '2020',
        'max' => '2030'
    ],
    [
        'name' => 'meter_awal',
        'label' => 'Meter Awal (kWh)',
        'type' => 'number',
        'required' => true,
        'placeholder' => 'Masukkan angka meteran awal',
        'min' => '0'
    ],
    [
        'name' => 'meter_ahir',
        'label' => 'Meter Akhir (kWh)',
        'type' => 'number',
        'required' => true,
        'placeholder' => 'Masukkan angka meteran akhir',
        'min' => '0'
    ]
];

// Konfigurasi untuk komponen form
$form_title = $page_title;
$action_url = isset($penggunaan) ? base_url('penggunaan/edit/' . $penggunaan['id_penggunaan']) : base_url('penggunaan/add');
$method = 'POST';
$submit_text = isset($penggunaan) ? 'Update' : 'Simpan';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $form_title ?></h1>
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

            <!-- Form Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tachometer-alt mr-2"></i><?= $form_title ?>
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= $action_url ?>" method="<?= $method ?>" id="formPenggunaan">
                        
                        <?php foreach ($fields as $field): ?>
                        <div class="form-group">
                            <label for="<?= $field['name'] ?>">
                                <?= $field['label'] ?>
                                <?php if (isset($field['required']) && $field['required']): ?>
                                    <span class="text-danger">*</span>
                                <?php endif; ?>
                            </label>
                            
                            <?php if ($field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'password' || $field['type'] == 'number'): ?>
                                <input type="<?= $field['type'] ?>" 
                                       class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                                       id="<?= $field['name'] ?>" 
                                       name="<?= $field['name'] ?>"
                                       value="<?= htmlspecialchars($data[$field['name']] ?? '') ?>"
                                       <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                                       <?= isset($field['placeholder']) ? 'placeholder="' . $field['placeholder'] . '"' : '' ?>
                                       <?= isset($field['min']) ? 'min="' . $field['min'] . '"' : '' ?>
                                       <?= isset($field['max']) ? 'max="' . $field['max'] . '"' : '' ?>
                                       <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                            
                            <?php elseif ($field['type'] == 'select'): ?>
                                <select class="form-control <?= isset($field['class']) ? $field['class'] : '' ?>" 
                                        id="<?= $field['name'] ?>" 
                                        name="<?= $field['name'] ?>"
                                        <?= isset($field['required']) && $field['required'] ? 'required' : '' ?>
                                        <?= isset($field['attributes']) ? $field['attributes'] : '' ?>>
                                    <option value="">Pilih <?= $field['label'] ?></option>
                                    <?php if (isset($field['options'])): ?>
                                        <?php foreach ($field['options'] as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= ($data[$field['name']] ?? '') == $value ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            
                            <?php endif; ?>
                            
                            <?php if (isset($field['help_text'])): ?>
                                <small class="form-text text-muted"><?= $field['help_text'] ?></small>
                            <?php endif; ?>
                            
                            <?php if (form_error($field['name'])): ?>
                                <div class="invalid-feedback d-block"><?= form_error($field['name']) ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?= $submit_text ?>
                            </button>
                            <a href="<?= base_url('penggunaan') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Penggunaan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Cara Mengisi Data Penggunaan:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success mr-2"></i>Pilih pelanggan dari dropdown</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Pilih bulan dan tahun periode</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Masukkan angka meteran awal</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Masukkan angka meteran akhir</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Sistem akan menghitung penggunaan otomatis</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-warning">Perhitungan Tagihan:</h6>
                            <div class="alert alert-warning">
                                <strong>Penggunaan = Meter Akhir - Meter Awal</strong><br>
                                <strong>Total Tagihan = Penggunaan × Tarif per kWh</strong><br>
                                <small>Contoh: 1500 kWh - 1000 kWh = 500 kWh<br>
                                500 kWh × Rp 1.352 = Rp 676.000</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid -->

<script>
// Form validation
document.getElementById('formPenggunaan').addEventListener('submit', function(e) {
    const meterAwal = parseInt(document.getElementById('meter_awal').value);
    const meterAkhir = parseInt(document.getElementById('meter_akhir').value);
    
    if (meterAkhir <= meterAwal) {
        e.preventDefault();
        alert('Meter akhir harus lebih besar dari meter awal!');
        return false;
    }
    
    if (!validateForm('formPenggunaan')) {
        e.preventDefault();
        return false;
    }
});

// Auto-calculate usage
document.getElementById('meter_ahir').addEventListener('input', function() {
    const meterAwal = parseInt(document.getElementById('meter_awal').value) || 0;
    const meterAkhir = parseInt(this.value) || 0;
    const usage = meterAkhir - meterAwal;
    
    if (usage > 0) {
        this.setCustomValidity('');
    } else {
        this.setCustomValidity('Meter akhir harus lebih besar dari meter awal');
    }
});
</script> 