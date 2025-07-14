<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Settings - Sistem</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan Sistem</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('settings/system') ?>" method="post">
                        
                        <!-- Company Information -->
                        <h5 class="text-primary mb-3">Informasi Perusahaan</h5>
                        <div class="form-group">
                            <label for="nama_perusahaan">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="PT PLN (Persero)" required>
                            <?= form_error('nama_perusahaan', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="alamat_perusahaan">Alamat Perusahaan</label>
                            <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" rows="3" required>Jl. Gatot Subroto Kav. 18, Jakarta 12710</textarea>
                            <?= form_error('alamat_perusahaan', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="telepon_perusahaan">Telepon Perusahaan</label>
                            <input type="text" class="form-control" id="telepon_perusahaan" name="telepon_perusahaan" value="021-7251234" required>
                            <?= form_error('telepon_perusahaan', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="email_perusahaan">Email Perusahaan</label>
                            <input type="email" class="form-control" id="email_perusahaan" name="email_perusahaan" value="info@pln.co.id">
                        </div>
                        <div class="form-group">
                            <label for="website_perusahaan">Website Perusahaan</label>
                            <input type="url" class="form-control" id="website_perusahaan" name="website_perusahaan" value="https://www.pln.co.id">
                        </div>

                        <hr class="my-4">

                        <!-- System Configuration -->
                        <h5 class="text-primary mb-3">Konfigurasi Sistem</h5>
                        <div class="form-group">
                            <label for="biaya_admin">Biaya Admin (Rp)</label>
                            <input type="number" class="form-control" id="biaya_admin" name="biaya_admin" value="5000" step="100" required>
                            <?= form_error('biaya_admin', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="denda_keterlambatan">Denda Keterlambatan (%)</label>
                            <input type="number" class="form-control" id="denda_keterlambatan" name="denda_keterlambatan" value="2" step="0.1" min="0" max="10">
                        </div>
                        <div class="form-group">
                            <label for="batas_waktu_pembayaran">Batas Waktu Pembayaran (Hari)</label>
                            <input type="number" class="form-control" id="batas_waktu_pembayaran" name="batas_waktu_pembayaran" value="20" min="1" max="31">
                        </div>

                        <hr class="my-4">

                        <!-- Notification Settings -->
                        <h5 class="text-primary mb-3">Pengaturan Notifikasi</h5>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="notif_email" name="notif_email" checked>
                                <label class="custom-control-label" for="notif_email">Aktifkan notifikasi email</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="notif_sms" name="notif_sms">
                                <label class="custom-control-label" for="notif_sms">Aktifkan notifikasi SMS</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="notif_wa" name="notif_wa" checked>
                                <label class="custom-control-label" for="notif_wa">Aktifkan notifikasi WhatsApp</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Security Settings -->
                        <h5 class="text-primary mb-3">Pengaturan Keamanan</h5>
                        <div class="form-group">
                            <label for="min_password_length">Panjang Password Minimum</label>
                            <input type="number" class="form-control" id="min_password_length" name="min_password_length" value="6" min="4" max="20">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="require_special_char" name="require_special_char">
                                <label class="custom-control-label" for="require_special_char">Wajib karakter khusus</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="require_number" name="require_number" checked>
                                <label class="custom-control-label" for="require_number">Wajib angka</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Pengaturan
                        </button>
                        <a href="<?= base_url('settings') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Versi Sistem:</strong><br>
                        <span class="text-muted">v1.0.0</span>
                    </div>
                    <div class="mb-3">
                        <strong>Framework:</strong><br>
                        <span class="text-muted">CodeIgniter 3.1.13</span>
                    </div>
                    <div class="mb-3">
                        <strong>Database:</strong><br>
                        <span class="text-muted">MySQL</span>
                    </div>
                    <div class="mb-3">
                        <strong>Server:</strong><br>
                        <span class="text-muted">Apache</span>
                    </div>
                    <div class="mb-3">
                        <strong>PHP Version:</strong><br>
                        <span class="text-muted"><?= phpversion() ?></span>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Pengaturan ini akan mempengaruhi seluruh sistem. Pastikan untuk menyimpan dengan hati-hati.
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <a href="<?= base_url('settings/tarif') ?>" class="btn btn-sm btn-primary btn-block">
                            <i class="fas fa-dollar-sign"></i> Kelola Tarif
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="<?= base_url('settings/level') ?>" class="btn btn-sm btn-success btn-block">
                            <i class="fas fa-users"></i> Kelola Level
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-info btn-block">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid --> 