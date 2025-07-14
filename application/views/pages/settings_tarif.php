<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Settings - Tarif</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addTarifModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tarif
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Tarif Statistics -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tarif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($tarifs) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tarif Tertinggi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= !empty($tarifs) ? 'Rp ' . number_format(max(array_column($tarifs, 'tarifperkwh')), 0, ',', '.') : 'Rp 0' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tarif Terendah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= !empty($tarifs) ? 'Rp ' . number_format(min(array_column($tarifs, 'tarifperkwh')), 0, ',', '.') : 'Rp 0' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Rata-rata Tarif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= !empty($tarifs) ? 'Rp ' . number_format(array_sum(array_column($tarifs, 'tarifperkwh')) / count($tarifs), 0, ',', '.') : 'Rp 0' ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Tarif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Daya (Watt)</th>
                            <th>Tarif per KWH</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($tarifs as $tarif): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= number_format($tarif['daya'], 0, ',', '.') ?> Watt</td>
                            <td>Rp <?= number_format($tarif['tarifperkwh'], 0, ',', '.') ?></td>
                            <td>
                                <a href="<?= base_url('settings/edit_tarif/' . $tarif['id_tarif']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('settings/delete_tarif/' . $tarif['id_tarif']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus tarif ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Add Tarif Modal -->
<div class="modal fade" id="addTarifModal" tabindex="-1" role="dialog" aria-labelledby="addTarifModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTarifModalLabel">Tambah Tarif Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('settings/tarif') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="daya">Daya (Watt)</label>
                        <input type="number" class="form-control" id="daya" name="daya" required>
                    </div>
                    <div class="form-group">
                        <label for="tarifperkwh">Tarif per KWH</label>
                        <input type="number" class="form-control" id="tarifperkwh" name="tarifperkwh" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script> 