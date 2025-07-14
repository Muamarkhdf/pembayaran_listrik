<?php
// Pelanggan Usage Chart Page
$page_title = 'Grafik Penggunaan';
$active_page = 'usage_chart';

// Get data from controller
$penggunaan = isset($penggunaan) ? $penggunaan : [];
$statistik_tahunan = isset($statistik_tahunan) ? $statistik_tahunan : [];
$statistik_bulanan = isset($statistik_bulanan) ? $statistik_bulanan : [];
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
                    <i class="fas fa-chart-bar mr-2"></i>Grafik Penggunaan Listrik
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
                                        <i class="fas fa-trending-up mr-1"></i>Tren Penggunaan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                        if (count($penggunaan) >= 2) {
                                            $last = $penggunaan[0]['total_kwh'] ?? 0;
                                            $prev = $penggunaan[1]['total_kwh'] ?? 0;
                                            $trend = $last > $prev ? 'Naik' : ($last < $prev ? 'Turun' : 'Stabil');
                                            echo $trend;
                                        } else {
                                            echo 'Stabil';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-trending-up fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <!-- Line Chart - Monthly Usage -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Grafik Penggunaan Bulanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="monthlyUsageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart - Usage Distribution -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Distribusi Penggunaan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="usageDistributionChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Tinggi (>200 kWh)
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-warning"></i> Sedang (100-200 kWh)
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Rendah (<100 kWh)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Charts -->
            <div class="row">
                <!-- Bar Chart - Yearly Comparison -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar mr-2"></i>Perbandingan Tahunan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="yearlyComparisonChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Radar Chart - Usage Pattern -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-radar mr-2"></i>Pola Penggunaan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-radar">
                                <canvas id="usagePatternChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analysis Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-analytics mr-2"></i>Analisis Penggunaan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Statistik Penggunaan</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-arrow-up text-success mr-2"></i>
                                            <strong>Penggunaan Tertinggi:</strong> 
                                            <?= !empty($penggunaan) ? number_format(max(array_column($penggunaan, 'total_kwh')), 0, ',', '.') : 0 ?> kWh
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-arrow-down text-warning mr-2"></i>
                                            <strong>Penggunaan Terendah:</strong> 
                                            <?= !empty($penggunaan) ? number_format(min(array_column($penggunaan, 'total_kwh')), 0, ',', '.') : 0 ?> kWh
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-chart-line text-info mr-2"></i>
                                            <strong>Rata-rata per Bulan:</strong> 
                                            <?= count($penggunaan) > 0 ? number_format(array_sum(array_column($penggunaan, 'total_kwh')) / count($penggunaan), 0, ',', '.') : 0 ?> kWh
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-calculator text-primary mr-2"></i>
                                            <strong>Total Penggunaan:</strong> 
                                            <?= number_format(array_sum(array_column($penggunaan, 'total_kwh')), 0, ',', '.') ?> kWh
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Rekomendasi</h6>
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-lightbulb mr-2"></i>Tips Penghematan</h6>
                                        <ul class="mb-0">
                                            <li>Gunakan lampu LED untuk menghemat energi</li>
                                            <li>Matikan peralatan elektronik saat tidak digunakan</li>
                                            <li>Gunakan AC dengan suhu optimal (24-26°C)</li>
                                            <li>Lakukan maintenance rutin pada peralatan elektronik</li>
                                        </ul>
                                    </div>
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
<!-- CHART SCRIPTS -->
<!-- ======================================== -->
<script>
// Monthly Usage Line Chart
var ctx = document.getElementById("monthlyUsageChart");
var monthlyUsageChart = new Chart(ctx, {
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

// Usage Distribution Pie Chart
var ctxPie = document.getElementById("usageDistributionChart");
var usageDistributionChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ['Tinggi (>200 kWh)', 'Sedang (100-200 kWh)', 'Rendah (<100 kWh)'],
        datasets: [{
            data: [
                <?php 
                $high = count(array_filter($penggunaan, function($p) { return $p['total_kwh'] > 200; }));
                $medium = count(array_filter($penggunaan, function($p) { return $p['total_kwh'] >= 100 && $p['total_kwh'] <= 200; }));
                $low = count(array_filter($penggunaan, function($p) { return $p['total_kwh'] < 100; }));
                echo $high . ", " . $medium . ", " . $low;
                ?>
            ],
            backgroundColor: ['#1cc88a', '#f6c23e', '#36b9cc'],
            hoverBackgroundColor: ['#17a673', '#f4b619', '#2c9faf'],
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

// Yearly Comparison Bar Chart
var ctxBar = document.getElementById("yearlyComparisonChart");
var yearlyComparisonChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: [
            <?php 
            if (!empty($penggunaan)) {
                $years = array_unique(array_column($penggunaan, 'tahun'));
                foreach ($years as $year) {
                    echo "'" . $year . "',";
                }
            }
            ?>
        ],
        datasets: [{
            label: 'Total kWh per Tahun',
            data: [
                <?php 
                if (!empty($penggunaan)) {
                    $years = array_unique(array_column($penggunaan, 'tahun'));
                    foreach ($years as $year) {
                        $yearTotal = array_sum(array_column(array_filter($penggunaan, function($p) use ($year) { 
                            return $p['tahun'] == $year; 
                        }), 'total_kwh'));
                        echo $yearTotal . ",";
                    }
                }
                ?>
            ],
            backgroundColor: 'rgba(78, 115, 223, 0.8)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 1
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
            }
        }
    }
});

// Usage Pattern Radar Chart
var ctxRadar = document.getElementById("usagePatternChart");
var usagePatternChart = new Chart(ctxRadar, {
    type: 'radar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Penggunaan 2024',
            data: [
                <?php 
                $monthlyData = array_fill(0, 12, 0);
                foreach ($penggunaan as $p) {
                    $monthIndex = array_search($p['bulan'], ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
                    if ($monthIndex !== false) {
                        $monthlyData[$monthIndex] = $p['total_kwh'];
                    }
                }
                echo implode(', ', $monthlyData);
                ?>
            ],
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'kWh'
                }
            }
        }
    }
});

function exportToPDF() {
    // Implementation for PDF export
    alert('Fitur export PDF akan segera tersedia!');
}
</script> 