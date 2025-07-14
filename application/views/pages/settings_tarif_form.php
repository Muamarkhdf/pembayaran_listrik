<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Tarif</h1>
        <a href="<?= base_url('settings/tarif') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Tarif</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('settings/edit_tarif/' . $tarif['id_tarif']) ?>" method="post">
                        <div class="form-group">
                            <label for="daya">Daya (Watt)</label>
                            <input type="number" class="form-control" id="daya" name="daya" value="<?= $tarif['daya'] ?>" required>
                            <?= form_error('daya', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="form-group">
                            <label for="tarifperkwh">Tarif per KWH</label>
                            <input type="number" class="form-control" id="tarifperkwh" name="tarifperkwh" step="0.01" value="<?= $tarif['tarifperkwh'] ?>" required>
                            <?= form_error('tarifperkwh', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Tarif</button>
                        <a href="<?= base_url('settings/tarif') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Tarif</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID Tarif:</strong><br>
                        <span class="text-muted"><?= $tarif['id_tarif'] ?></span>
                    </div>
                    <div class="mb-3">
                        <strong>Daya Saat Ini:</strong><br>
                        <span class="text-muted"><?= number_format($tarif['daya'], 0, ',', '.') ?> Watt</span>
                    </div>
                    <div class="mb-3">
                        <strong>Tarif Saat Ini:</strong><br>
                        <span class="text-muted">Rp <?= number_format($tarif['tarifperkwh'], 0, ',', '.') ?></span>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Perubahan tarif akan mempengaruhi perhitungan tagihan pelanggan yang menggunakan tarif ini.
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid --> 