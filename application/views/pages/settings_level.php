<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Settings - Level</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addLevelModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Level
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Level Statistics -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Level</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($levels) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Level Terbanyak Digunakan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                $level_counts = array();
                                foreach ($levels as $level) {
                                    $this->db->where('id_level', $level['id_level']);
                                    $count = $this->db->count_all_results('user');
                                    $level_counts[$level['nama_level']] = $count;
                                }
                                echo !empty($level_counts) ? array_search(max($level_counts), $level_counts) : 'Tidak ada';
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $this->db->count_all('user') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Level</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Level</th>
                            <th>Jumlah User</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($levels as $level): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $level['nama_level'] ?></td>
                            <td>
                                <?php
                                $this->db->where('id_level', $level['id_level']);
                                $user_count = $this->db->count_all_results('user');
                                echo $user_count;
                                ?>
                            </td>
                            <td>
                                <a href="<?= base_url('settings/edit_level/' . $level['id_level']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($user_count == 0): ?>
                                <a href="<?= base_url('settings/delete_level/' . $level['id_level']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus level ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled title="Level sedang digunakan">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
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

<!-- Add Level Modal -->
<div class="modal fade" id="addLevelModal" tabindex="-1" role="dialog" aria-labelledby="addLevelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLevelModalLabel">Tambah Level Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('settings/level') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_level">Nama Level</label>
                        <input type="text" class="form-control" id="nama_level" name="nama_level" required>
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