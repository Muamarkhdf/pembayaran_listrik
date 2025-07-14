<?php
// Pelanggan Usage Page
$page_title = 'Penggunaan Listrik';
$active_page = 'usage';

// Get data from controller
$penggunaan = isset($penggunaan) ? $penggunaan : [];
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
                    <i class="fas fa-chart-line mr-2"></i>Penggunaan Listrik
                </h1>
                <div>
                    <button class="btn btn-success" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </button>
                    <button class="btn btn-info" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-calendar mr-1"></i>Total Periode
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($penggunaan) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-bolt mr-1"></i>Total kWh
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format(array_sum(array_column($penggunaan, 'total_kwh')), 0, ',', '.') ?>
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
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        <i class="fas fa-chart-line mr-1"></i>Rata-rata/bulan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($penggunaan) > 0 ? number_format(array_sum(array_column($penggunaan, 'total_kwh')) / count($penggunaan), 0, ',', '.') : 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-tachometer-alt mr-1"></i>Meter Terakhir
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= !empty($penggunaan) ? number_format($penggunaan[0]['meter_ahir'] ?? 0, 0, ',', '.') : 0 ?>
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

            <!-- Charts Section -->
            <div class="row">
                <!-- Usage Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Grafik Penggunaan Listrik
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="usageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Statistik Penggunaan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Penggunaan Tertinggi</span>
                                    <span class="font-weight-bold text-success">
                                        <?= !empty($penggunaan) ? number_format(max(array_column($penggunaan, 'total_kwh')), 0, ',', '.') : 0 ?> kWh
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <?= !empty($penggunaan) ? array_search(max(array_column($penggunaan, 'total_kwh')), array_column($penggunaan, 'total_kwh')) !== false ? $penggunaan[array_search(max(array_column($penggunaan, 'total_kwh')), array_column($penggunaan, 'total_kwh'))]['bulan'] . ' ' . $penggunaan[array_search(max(array_column($penggunaan, 'total_kwh')), array_column($penggunaan, 'total_kwh'))]['tahun'] : '-' : '-' ?>
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Penggunaan Terendah</span>
                                    <span class="font-weight-bold text-warning">
                                        <?= !empty($penggunaan) ? number_format(min(array_column($penggunaan, 'total_kwh')), 0, ',', '.') : 0 ?> kWh
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <?= !empty($penggunaan) ? array_search(min(array_column($penggunaan, 'total_kwh')), array_column($penggunaan, 'total_kwh')) !== false ? $penggunaan[array_search(min(array_column($penggunaan, 'total_kwh')), array_column($penggunaan, 'total_kwh'))]['bulan'] . ' ' . $penggunaan[array_search(min(array_column($penggunaan, 'total_kwh')), array_column($penggunaan, 'total_kwh'))]['tahun'] : '-' : '-' ?>
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Rata-rata per Bulan</span>
                                    <span class="font-weight-bold text-info">
                                        <?= count($penggunaan) > 0 ? number_format(array_sum(array_column($penggunaan, 'total_kwh')) / count($penggunaan), 0, ',', '.') : 0 ?> kWh
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Riwayat Penggunaan
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($penggunaan)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada data penggunaan</h5>
                            <p class="text-muted">Data penggunaan akan muncul setelah admin input data meteran</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Total kWh</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($penggunaan as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($p['bulan'] ?? '') ?> <?= htmlspecialchars($p['tahun'] ?? '') ?></strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary">
                                                    <?= number_format($p['meter_awal'] ?? 0, 0, ',', '.') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">
                                                    <?= number_format($p['meter_ahir'] ?? 0, 0, ',', '.') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success font-weight-bold">
                                                    <?= number_format($p['total_kwh'] ?? 0, 0, ',', '.') ?> kWh
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $p['id_penggunaan'] ?>">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ======================================== -->
<!-- DETAIL MODALS -->
<!-- ======================================== -->
<?php foreach ($penggunaan as $p): ?>
<div class="modal fade" id="detailModal<?= $p['id_penggunaan'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $p['id_penggunaan'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel<?= $p['id_penggunaan'] ?>">
                    <i class="fas fa-chart-line mr-2"></i>Detail Penggunaan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Periode</strong></td>
                                <td>: <?= htmlspecialchars($p['bulan'] ?? '') ?> <?= htmlspecialchars($p['tahun'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Meter Awal</strong></td>
                                <td>: <span class="badge badge-secondary"><?= number_format($p['meter_awal'] ?? 0, 0, ',', '.') ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Meter Akhir</strong></td>
                                <td>: <span class="badge badge-primary"><?= number_format($p['meter_ahir'] ?? 0, 0, ',', '.') ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Total kWh</strong></td>
                                <td>: <span class="font-weight-bold text-success"><?= number_format($p['total_kwh'] ?? 0, 0, ',', '.') ?> kWh</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID Penggunaan</strong></td>
                                <td>: <?= $p['id_penggunaan'] ?? '-' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Input</strong></td>
                                <td>: <?= date('d M Y', strtotime($p['created_at'] ?? 'now')) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>: <span class="badge badge-success">Valid</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Usage Visualization -->
                <hr>
                <h6 class="text-primary">
                    <i class="fas fa-chart-bar mr-2"></i>Visualisasi Penggunaan
                </h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-secondary" style="width: 30%;">
                                Meter Awal: <?= number_format($p['meter_awal'] ?? 0, 0, ',', '.') ?>
                            </div>
                            <div class="progress-bar bg-success" style="width: 70%;">
                                Penggunaan: <?= number_format($p['total_kwh'] ?? 0, 0, ',', '.') ?> kWh
                            </div>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">
                                Total: <?= number_format($p['meter_ahir'] ?? 0, 0, ',', '.') ?> kWh
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- ======================================== -->
<!-- CHART SCRIPTS -->
<!-- ======================================== -->
<script>
// Usage Chart
var ctx = document.getElementById("usageChart");
var usageChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            <?php 
            if (!empty($penggunaan)) {
                foreach (array_reverse($penggunaan) as $p) {
                    echo "'" . $p['bulan'] . " " . $p['tahun'] . "',";
                }
            }
            ?>
        ],
        datasets: [{
            label: 'Penggunaan (kWh)',
            data: [
                <?php 
                if (!empty($penggunaan)) {
                    foreach (array_reverse($penggunaan) as $p) {
                        echo $p['total_kwh'] . ",";
                    }
                }
                ?>
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'kWh'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Periode'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

function exportToPDF() {
    // Implementation for PDF export
    alert('Fitur export PDF akan segera tersedia!');
}
</script> 