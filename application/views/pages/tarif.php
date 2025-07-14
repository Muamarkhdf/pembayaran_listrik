<?php
// Tariff Management Page
$page_title = 'Data Tarif';
$active_page = 'tarif';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Tarif</h1>
                <a href="<?= base_url('tarif/add') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tarif
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

<!-- Tariff Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <i class="fas fa-bolt mr-1"></i>Total Tarif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tarif) ? count($tarif) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Jenis tarif tersedia
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bolt fa-2x text-gray-300"></i>
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
                            <i class="fas fa-users mr-1"></i>Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tarif) ? array_sum(array_column($tarif, 'total_pelanggan')) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Menggunakan tarif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <i class="fas fa-dollar-sign mr-1"></i>Rata-rata Tarif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= isset($tarif) && !empty($tarif) ? number_format(array_sum(array_column($tarif, 'tarifperkwh')) / count($tarif), 0, ',', '.') : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Per kWh
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <i class="fas fa-watt mr-1"></i>Daya Tertinggi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tarif) && !empty($tarif) ? max(array_column($tarif, 'daya')) : '0' ?> VA
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Kapasitas maksimal
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tachometer-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list mr-2"></i>Daftar Tarif Listrik
        </h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Opsi:</div>
                <a class="dropdown-item" href="<?= base_url('tarif/add') ?>">
                    <i class="fas fa-plus mr-2"></i>Tambah Tarif
                </a>
                <a class="dropdown-item" href="#" onclick="exportData()">
                    <i class="fas fa-download mr-2"></i>Export Data
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="printTable()">
                    <i class="fas fa-print mr-2"></i>Print
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Daya (VA)</th>
                        <th>Tarif per kWh</th>
                        <th>Total Pelanggan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($tarif) && !empty($tarif)): ?>
                        <?php foreach ($tarif as $index => $t): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <span class="badge badge-primary">
                                    <i class="fas fa-bolt mr-1"></i><?= number_format($t['daya']) ?> VA
                                </span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-success">
                                    Rp <?= number_format($t['tarifperkwh'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?= $t['total_pelanggan'] > 0 ? 'success' : 'secondary' ?>">
                                    <i class="fas fa-users mr-1"></i><?= $t['total_pelanggan'] ?> pelanggan
                                </span>
                            </td>
                            <td>
                                <?php if ($t['total_pelanggan'] > 0): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check mr-1"></i>Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock mr-1"></i>Tidak Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('tarif/edit/' . $t['id_tarif']) ?>" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <?php if ($t['total_pelanggan'] == 0): ?>
                                <a href="<?= base_url('tarif/delete/' . $t['id_tarif']) ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus tarif ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-bolt fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">Tidak ada data tarif</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tariff Information Card -->
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Tarif
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">900 VA</h6>
                                <p class="card-text">Tarif untuk rumah tangga dengan daya rendah</p>
                                <small class="text-muted">Rp 1.352/kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">1300 VA</h6>
                                <p class="card-text">Tarif untuk rumah tangga menengah</p>
                                <small class="text-muted">Rp 1.444/kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <h6 class="card-title text-info">2200 VA</h6>
                                <p class="card-text">Tarif untuk rumah tangga dengan daya tinggi</p>
                                <small class="text-muted">Rp 1.699/kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">Custom</h6>
                                <p class="card-text">Tarif khusus untuk kebutuhan bisnis</p>
                                <small class="text-muted">Sesuai perjanjian</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie mr-2"></i>Distribusi Pelanggan
                </h6>
            </div>
            <div class="card-body">
                <canvas id="tariffChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div> -->

<script>
// Tariff Distribution Chart
var ctx = document.getElementById("tariffChart");
var tariffChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
            <?php if (isset($tarif) && !empty($tarif)): ?>
                <?php foreach ($tarif as $t): ?>
                    '<?= $t['daya'] ?> VA',
                <?php endforeach; ?>
            <?php endif; ?>
        ],
        datasets: [{
            data: [
                <?php if (isset($tarif) && !empty($tarif)): ?>
                    <?php foreach ($tarif as $t): ?>
                        <?= $t['total_pelanggan'] ?>,
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02424'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: 'bottom'
        },
        cutoutPercentage: 80,
    },
});

function exportData() {
    // Export functionality
    alert('Fitur export akan segera tersedia');
}

function printTable() {
    // Print functionality
    window.print();
}
</script>

        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid --> 