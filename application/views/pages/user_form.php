<?php
// User Form Page
$page_title = isset($user) ? 'Edit User' : 'Tambah User';
$active_page = 'user';
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
    <a href="<?= base_url('user') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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
        <h6 class="m-0 font-weight-bold text-primary">Form User</h6>
    </div>
    <div class="card-body">
        <?= form_open('', ['method' => 'post']) ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= set_value('username', isset($user) ? $user['username'] : '') ?>" 
                               placeholder="Masukkan username" required>
                        <?php if (form_error('username')): ?>
                            <small class="text-danger"><?= form_error('username') ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password <?= isset($user) ? '' : '<span class="text-danger">*</span>' ?></label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="<?= isset($user) ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password' ?>" 
                               <?= isset($user) ? '' : 'required' ?>>
                        <?php if (form_error('password')): ?>
                            <small class="text-danger"><?= form_error('password') ?></small>
                        <?php endif; ?>
                        <?php if (isset($user)): ?>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_admin">Nama Admin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_admin" name="nama_admin" 
                               value="<?= set_value('nama_admin', isset($user) ? $user['nama_admin'] : '') ?>" 
                               placeholder="Masukkan nama admin" required>
                        <?php if (form_error('nama_admin')): ?>
                            <small class="text-danger"><?= form_error('nama_admin') ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_level">Level <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_level" name="id_level" required>
                            <option value="">Pilih Level</option>
                            <?php if (isset($levels) && !empty($levels)): ?>
                                <?php foreach ($levels as $level): ?>
                                    <option value="<?= $level['id_level'] ?>" 
                                            <?= set_select('id_level', $level['id_level'], isset($user) && $user['id_level'] == $level['id_level']) ?>>
                                        <?= htmlspecialchars($level['nama_level']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (form_error('id_level')): ?>
                            <small class="text-danger"><?= form_error('id_level') ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= isset($user) ? 'Update' : 'Simpan' ?>
                        </button>
                        <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>

<!-- Level Information Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Level</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-left-primary">
                    <div class="card-body">
                        <h6 class="card-title text-primary">Administrator</h6>
                        <p class="card-text">Memiliki akses penuh ke semua fitur sistem</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-left-info">
                    <div class="card-body">
                        <h6 class="card-title text-info">Petugas</h6>
                        <p class="card-text">Memiliki akses terbatas untuk input data</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-left-success">
                    <div class="card-body">
                        <h6 class="card-title text-success">Reguler</h6>
                        <p class="card-text">Level untuk pelanggan biasa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 