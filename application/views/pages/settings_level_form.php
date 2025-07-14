<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Level</h1>
        <a href="<?= base_url('settings/level') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Level</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('settings/edit_level/' . $level['id_level']) ?>" method="post">
                        <div class="form-group">
                            <label for="nama_level">Nama Level</label>
                            <input type="text" class="form-control" id="nama_level" name="nama_level" value="<?= $level['nama_level'] ?>" required>
                            <?= form_error('nama_level', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Level</button>
                        <a href="<?= base_url('settings/level') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Level</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID Level:</strong><br>
                        <span class="text-muted"><?= $level['id_level'] ?></span>
                    </div>
                    <div class="mb-3">
                        <strong>Nama Level Saat Ini:</strong><br>
                        <span class="text-muted"><?= $level['nama_level'] ?></span>
                    </div>
                    <div class="mb-3">
                        <strong>Jumlah User:</strong><br>
                        <span class="text-muted">
                            <?php
                            $this->db->where('id_level', $level['id_level']);
                            $user_count = $this->db->count_all_results('user');
                            echo $user_count;
                            ?>
                        </span>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Perubahan nama level akan mempengaruhi user yang menggunakan level ini.
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid --> 