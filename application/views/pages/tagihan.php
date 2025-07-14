<?php
// Bill Management Page
$page_title = 'Data Tagihan';
$active_page = 'tagihan';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Tagihan</h1>
                <a href="<?= base_url('tagihan/add') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tagihan
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

<!-- Bill Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <i class="fas fa-file-invoice mr-1"></i>Total Tagihan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tagihan) ? count($tagihan) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Tagihan listrik
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
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
                            <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tagihan) ? count(array_filter($tagihan, function($t) { return $t['status'] == 'sudah_bayar'; })) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Tagihan lunas
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <i class="fas fa-clock mr-1"></i>Belum Bayar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tagihan) ? count(array_filter($tagihan, function($t) { return $t['status'] == 'belum_bayar'; })) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Tagihan pending
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <i class="fas fa-dollar-sign mr-1"></i>Total Pendapatan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= isset($tagihan) ? number_format(array_sum(array_column(array_filter($tagihan, function($t) { return $t['status'] == 'sudah_bayar'; }), 'total_tagihan')), 0, ',', '.') : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Dari pembayaran
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
            <i class="fas fa-list mr-2"></i>Daftar Tagihan Listrik
        </h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Opsi:</div>
                <a class="dropdown-item" href="<?= base_url('tagihan/add') ?>">
                    <i class="fas fa-plus mr-2"></i>Tambah Tagihan
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
                        <th>Pelanggan</th>
                        <th>Periode</th>
                        <th>Daya</th>
                        <th>Meter</th>
                        <th>Tarif</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($tagihan) && !empty($tagihan)): ?>
                        <?php foreach ($tagihan as $index => $t): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div>
                                    <strong><?= $t['nama_pelanggan'] ?></strong>
                                    <br>
                                    <small class="text-muted"><?= $t['nomor_kwh'] ?></small>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <i class="fas fa-calendar mr-1"></i><?= $t['bulan'] ?> <?= $t['tahun'] ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    <i class="fas fa-bolt mr-1"></i><?= number_format($t['daya']) ?> VA
                                </span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-success">
                                    <?= number_format($t['jumlah_meter']) ?> kWh
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">
                                    Rp <?= number_format($t['tarifperkwh'], 0, ',', '.') ?>/kWh
                                </span>
                            </td>
                            <td>
                                <span class="font-weight-bold text-success">
                                    Rp <?= number_format($t['total_tagihan'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($t['status'] == 'sudah_bayar'): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check mr-1"></i>Sudah Bayar
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock mr-1"></i>Belum Bayar
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <?php if ($t['status'] == 'belum_bayar'): ?>
                                        <a href="<?= base_url('tagihan/bayar/' . $t['id_tagihan']) ?>" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-money-bill"></i> Bayar
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?= base_url('tagihan/edit/' . $t['id_tagihan']) ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <?php if ($t['status'] == 'belum_bayar'): ?>
                                        <a href="<?= base_url('tagihan/delete/' . $t['id_tagihan']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-file-invoice fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">Tidak ada data tagihan</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bill Information Cards -->
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Tagihan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">Meter Awal</h6>
                                <p class="card-text">Angka meteran listrik di awal periode</p>
                                <small class="text-muted">Contoh: 1000 kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">Meter Akhir</h6>
                                <p class="card-text">Angka meteran listrik di akhir periode</p>
                                <small class="text-muted">Contoh: 1500 kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <h6 class="card-title text-info">Penggunaan</h6>
                                <p class="card-text">Selisih meter akhir dan meter awal</p>
                                <small class="text-muted">Contoh: 500 kWh</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">Total Tagihan</h6>
                                <p class="card-text">Penggunaan × Tarif per kWh</p>
                                <small class="text-muted">Contoh: Rp 676.000</small>
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
                    <i class="fas fa-chart-bar mr-2"></i>Statistik Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <canvas id="paymentChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div> -->

<script>
// Payment Statistics Chart
var ctx = document.getElementById("paymentChart");
var paymentChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Sudah Bayar', 'Belum Bayar'],
        datasets: [{
            data: [
                <?= isset($tagihan) ? count(array_filter($tagihan, function($t) { return $t['status'] == 'sudah_bayar'; })) : '0' ?>,
                <?= isset($tagihan) ? count(array_filter($tagihan, function($t) { return $t['status'] == 'belum_bayar'; })) : '0' ?>
            ],
            backgroundColor: ['#1cc88a', '#f6c23e'],
            hoverBackgroundColor: ['#17a673', '#f4b619'],
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