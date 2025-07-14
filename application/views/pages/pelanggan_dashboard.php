<?php
// Pelanggan Dashboard Page
$page_title = 'Dashboard Pelanggan';
$active_page = 'dashboard';

// Get data from controller
$customer_info = isset($customer_info) ? $customer_info : [];
$total_tagihan = isset($total_tagihan) ? $total_tagihan : 0;
$tagihan_belum_bayar = isset($tagihan_belum_bayar) ? $tagihan_belum_bayar : 0;
$tagihan_sudah_bayar = isset($tagihan_sudah_bayar) ? $tagihan_sudah_bayar : 0;
$tagihan_terbaru = isset($tagihan_terbaru) ? $tagihan_terbaru : [];
$pembayaran_terbaru = isset($pembayaran_terbaru) ? $pembayaran_terbaru : [];
$statistik_penggunaan = isset($statistik_penggunaan) ? $statistik_penggunaan : [];
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

            <!-- Customer Welcome Section -->
            <div class="customer-welcome">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">
                            <i class="fas fa-user-circle mr-2"></i>
                            Selamat datang, <?= htmlspecialchars($customer_info['nama_pelanggan'] ?? 'Pelanggan') ?>!
                        </h4>
                        <p class="mb-0">
                            <i class="fas fa-bolt mr-1"></i>
                            Nomor KWH: <?= htmlspecialchars($customer_info['nomor_kwh'] ?? '-') ?> | 
                            Daya: <?= htmlspecialchars($customer_info['daya'] ?? '-') ?> VA
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="text-white-50">
                            <small>Status: <span class="badge badge-success">Aktif</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================== -->
            <!-- STATISTICS CARDS SECTION -->
            <!-- ======================================== -->
            <div class="row mb-4">
                <!-- Total Tagihan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-file-invoice mr-1"></i>Total Tagihan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($total_tagihan) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tagihan Belum Bayar Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Belum Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($tagihan_belum_bayar) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tagihan Sudah Bayar Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($tagihan_sudah_bayar) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarif per kWh Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        <i class="fas fa-dollar-sign mr-1"></i>Tarif per kWh
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format($customer_info['tarifperkwh'] ?? 0, 0, ',', '.') ?>
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

            <!-- ======================================== -->
            <!-- CHARTS AND TABLES SECTION -->
            <!-- ======================================== -->
            <div class="row">
                <!-- Usage Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Grafik Penggunaan Listrik (6 Bulan Terakhir)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="usageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Status Tagihan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="billsPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Sudah Bayar
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-warning"></i> Belum Bayar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================== -->
            <!-- RECENT ACTIVITIES SECTION -->
            <!-- ======================================== -->
            <div class="row">
                <!-- Tagihan Terbaru -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-file-invoice mr-2"></i>Tagihan Terbaru
                            </h6>
                            <a href="<?= base_url('pelanggan_dashboard/bills') ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (empty($tagihan_terbaru)): ?>
                                <div class="text-center py-3">
                                    <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">Belum ada data tagihan</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($tagihan_terbaru as $index => $tagihan): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 <?= $index % 2 == 0 ? 'bg-light' : '' ?> rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold"><?= htmlspecialchars($tagihan['bulan'] ?? '') ?> <?= htmlspecialchars($tagihan['tahun'] ?? '') ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-bolt mr-1"></i>
                                                <?= number_format($tagihan['jumlah_meter'] ?? 0, 0, ',', '.') ?> kWh
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-weight-bold text-primary">
                                            Rp <?= number_format($tagihan['total_tagihan'] ?? 0, 0, ',', '.') ?>
                                        </div>
                                        <small class="<?= ($tagihan['status'] == 'sudah_bayar') ? 'text-success' : 'text-warning' ?>">
                                            <?= ($tagihan['status'] == 'sudah_bayar') ? 'Sudah Bayar' : 'Belum Bayar' ?>
                                        </small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Terbaru -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-credit-card mr-2"></i>Pembayaran Terbaru
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (empty($pembayaran_terbaru)): ?>
                                <div class="text-center py-3">
                                    <i class="fas fa-credit-card fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">Belum ada data pembayaran</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($pembayaran_terbaru as $index => $pembayaran): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 <?= $index % 2 == 0 ? 'bg-light' : '' ?> rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-credit-card fa-2x text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold"><?= htmlspecialchars($pembayaran['bulan'] ?? '') ?> <?= htmlspecialchars($pembayaran['tahun'] ?? '') ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar mr-1"></i>
                                                <?= date('d M Y', strtotime($pembayaran['tanggal_pembayaran'] ?? '')) ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-weight-bold text-success">
                                            Rp <?= number_format($pembayaran['total_bayar'] ?? 0, 0, ',', '.') ?>
                                        </div>
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> Berhasil
                                        </small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

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
            if (!empty($statistik_penggunaan)) {
                foreach (array_reverse($statistik_penggunaan) as $penggunaan) {
                    echo "'" . $penggunaan['bulan'] . " " . $penggunaan['tahun'] . "',";
                }
            }
            ?>
        ],
        datasets: [{
            label: 'Penggunaan (kWh)',
            data: [
                <?php 
                if (!empty($statistik_penggunaan)) {
                    foreach (array_reverse($statistik_penggunaan) as $penggunaan) {
                        echo ($penggunaan['meter_ahir'] - $penggunaan['meter_awal']) . ",";
                    }
                }
                ?>
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Bills Pie Chart
var ctxPie = document.getElementById("billsPieChart");
var billsPieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ['Sudah Bayar', 'Belum Bayar'],
        datasets: [{
            data: [<?= $tagihan_sudah_bayar ?>, <?= $tagihan_belum_bayar ?>],
            backgroundColor: ['#1cc88a', '#f6c23e'],
            hoverBackgroundColor: ['#17a673', '#f4b619'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script> 