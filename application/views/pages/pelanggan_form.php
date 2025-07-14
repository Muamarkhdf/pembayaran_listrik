<?php
// Pelanggan Form Page
$page_title = isset($pelanggan) ? 'Edit Pelanggan' : 'Tambah Pelanggan';
$active_page = 'pelanggan';

// Get tarif data from controller
$tarif_options = [];
if (isset($tarif)) {
    foreach ($tarif as $t) {
        $tarif_options[$t['id_tarif']] = $t['daya'] . ' VA - Rp ' . number_format($t['tarifperkwh'], 0, ',', '.') . '/kWh';
    }
}

// Check if editing
$is_edit = isset($pelanggan);
$pelanggan_data = $is_edit ? $pelanggan : [];
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
                <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
                <a href="<?= base_url('pelanggan') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form <?= $page_title ?></h6>
                </div>
                <div class="card-body">
                    <?= form_open($is_edit ? 'pelanggan/edit/' . $pelanggan_data['id_pelanggan'] : 'pelanggan/add', ['class' => 'needs-validation', 'novalidate' => '']) ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= form_error('nama_pelanggan') ? 'is-invalid' : '' ?>" 
                                           id="nama_pelanggan" 
                                           name="nama_pelanggan" 
                                           value="<?= set_value('nama_pelanggan', $is_edit ? $pelanggan_data['nama_pelanggan'] : '') ?>" 
                                           placeholder="Masukkan nama pelanggan" 
                                           required>
                                    <?= form_error('nama_pelanggan', '<div class="invalid-feedback">', '</div>') ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" 
                                           id="username" 
                                           name="username" 
                                           value="<?= set_value('username', $is_edit ? $pelanggan_data['username'] : '') ?>" 
                                           placeholder="Masukkan username" 
                                           required>
                                    <?= form_error('username', '<div class="invalid-feedback">', '</div>') ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">
                                        Password 
                                        <?php if (!$is_edit): ?>
                                            <span class="text-danger">*</span>
                                        <?php else: ?>
                                            <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>
                                        <?php endif; ?>
                                    </label>
                                    <input type="password" 
                                           class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan password" 
                                           <?= !$is_edit ? 'required' : '' ?>>
                                    <?= form_error('password', '<div class="invalid-feedback">', '</div>') ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nomor_kwh" class="form-label">Nomor KWH <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= form_error('nomor_kwh') ? 'is-invalid' : '' ?>" 
                                           id="nomor_kwh" 
                                           name="nomor_kwh" 
                                           value="<?= set_value('nomor_kwh', $is_edit ? $pelanggan_data['nomor_kwh'] : '') ?>" 
                                           placeholder="Masukkan nomor KWH" 
                                           required>
                                    <?= form_error('nomor_kwh', '<div class="invalid-feedback">', '</div>') ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_tarif" class="form-label">Daya/Tarif <span class="text-danger">*</span></label>
                                    <select class="form-control <?= form_error('id_tarif') ? 'is-invalid' : '' ?>" 
                                            id="id_tarif" 
                                            name="id_tarif" 
                                            required>
                                        <option value="">Pilih Daya/Tarif</option>
                                        <?php foreach ($tarif_options as $id => $label): ?>
                                            <option value="<?= $id ?>" <?= set_select('id_tarif', $id, $is_edit ? ($pelanggan_data['id_tarif'] == $id) : FALSE) ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('id_tarif', '<div class="invalid-feedback">', '</div>') ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= form_error('alamat') ? 'is-invalid' : '' ?>" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap" 
                                      required><?= set_value('alamat', $is_edit ? $pelanggan_data['alamat'] : '') ?></textarea>
                            <?= form_error('alamat', '<div class="invalid-feedback">', '</div>') ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?= $is_edit ? 'Update' : 'Simpan' ?>
                            </button>
                            <a href="<?= base_url('pelanggan') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>

                    <?= form_close() ?>
                </div>
            </div>
            
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid -->

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script> 