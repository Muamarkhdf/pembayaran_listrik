<?php
// Pelanggan Profile Page
$page_title = 'Profil Saya';
$active_page = 'profile';

// Get data from controller
$customer_info = isset($customer_info) ? $customer_info : [];
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-user-circle mr-2"></i>Profil Saya
                </h1>
                <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                    <i class="fas fa-edit"></i> Edit Profil
                </button>
            </div>

            <!-- Profile Information -->
            <div class="row">
                <!-- Profile Card -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user mr-2"></i>Informasi Pribadi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150"><strong>Nama Lengkap</strong></td>
                                            <td>: <?= htmlspecialchars($customer_info['nama_pelanggan'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Username</strong></td>
                                            <td>: <?= htmlspecialchars($customer_info['username'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nomor KWH</strong></td>
                                            <td>: <?= htmlspecialchars($customer_info['nomor_kwh'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150"><strong>Alamat</strong></td>
                                            <td>: <?= htmlspecialchars($customer_info['alamat'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Daya Listrik</strong></td>
                                            <td>: <?= htmlspecialchars($customer_info['daya'] ?? '-') ?> VA</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tarif per kWh</strong></td>
                                            <td>: Rp <?= number_format($customer_info['tarifperkwh'] ?? 0, 0, ',', '.') ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Statistik Singkat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Total Tagihan</span>
                                    <span class="font-weight-bold"><?= number_format($total_tagihan ?? 0) ?></span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Sudah Bayar</span>
                                    <span class="font-weight-bold text-success"><?= number_format($tagihan_sudah_bayar ?? 0) ?></span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-success" style="width: <?= ($total_tagihan > 0) ? ($tagihan_sudah_bayar / $total_tagihan * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Belum Bayar</span>
                                    <span class="font-weight-bold text-warning"><?= number_format($tagihan_belum_bayar ?? 0) ?></span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <div class="progress-bar bg-warning" style="width: <?= ($total_tagihan > 0) ? ($tagihan_belum_bayar / $total_tagihan * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-shield-alt mr-2"></i>Status Akun
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <h6 class="text-success">Akun Aktif</h6>
                            <small class="text-muted">Terdaftar sejak: <?= date('d M Y') ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-lock mr-2"></i>Keamanan Akun
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Password</h6>
                                    <p class="text-muted">Terakhir diubah: <?= date('d M Y') ?></p>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#changePasswordModal">
                                        <i class="fas fa-key"></i> Ubah Password
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <h6>Login Terakhir</h6>
                                    <p class="text-muted"><?= date('d M Y H:i') ?></p>
                                    <small class="text-info">
                                        <i class="fas fa-info-circle"></i> 
                                        Aktivitas login akan dicatat untuk keamanan
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ======================================== -->
<!-- MODALS -->
<!-- ======================================== -->

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pelanggan_dashboard/update_profile') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pelanggan">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" 
                                       value="<?= htmlspecialchars($customer_info['nama_pelanggan'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= htmlspecialchars($customer_info['username'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_kwh">Nomor KWH</label>
                                <input type="text" class="form-control" id="nomor_kwh" name="nomor_kwh" 
                                       value="<?= htmlspecialchars($customer_info['nomor_kwh'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($customer_info['alamat'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-key mr-2"></i>Ubah Password
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pelanggan_dashboard/change_password') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <small class="form-text text-muted">Minimal 6 karakter</small>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 