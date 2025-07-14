<?php
// Dashboard Page
$page_title = 'Dashboard';
$active_page = 'dashboard';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- ======================================== -->
            <!-- STATISTICS CARDS SECTION (Lebih renggang) -->
            <!-- ======================================== -->
            <div class="row mb-5"> <!-- mb-5 agar lebih renggang -->
    <!-- Total Pelanggan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow  py-3"> <!-- py-3 agar lebih tinggi -->
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                            <i class="fas fa-users mr-1"></i>Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($total_pelanggan) ? number_format($total_pelanggan) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-2">
                            <i class="fas fa-arrow-up text-success"></i> Aktif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tagihan Bulan Ini Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow  py-3">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                            <i class="fas fa-file-invoice mr-1"></i>Tagihan Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($total_tagihan) ? number_format($total_tagihan) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-2">
                            <?= date('F Y') ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pembayaran Hari Ini Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow  py-3">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                            <i class="fas fa-credit-card mr-1"></i>Pembayaran Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($pembayaran_hari_ini) ? number_format($pembayaran_hari_ini) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-2">
                            <?= date('d M Y') ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tagihan Belum Bayar Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow  py-3">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                            <i class="fas fa-exclamation-triangle mr-1"></i>Tagihan Belum Bayar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($tagihan_belum_bayar) ? number_format($tagihan_belum_bayar) : '0' ?>
                        </div>
                        <div class="text-xs text-muted mt-2">
                            Perlu tindakan
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================== -->
<!-- CHARTS SECTION (Hanya Area Chart) -->
<!-- ======================================== -->


<!-- ======================================== -->
<!-- DATA LISTS SECTION -->
<!-- ======================================== -->
<div class="row">
    <!-- Tagihan Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i>Tagihan Terbaru
                </h6>
                <a href="<?= base_url('tagihan') ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <?php if (isset($tagihan_terbaru) && !empty($tagihan_terbaru)): ?>
                    <?php foreach ($tagihan_terbaru as $index => $tagihan): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 <?= $index % 2 == 0 ? 'bg-light' : '' ?> rounded">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold"><?= htmlspecialchars(isset($tagihan['nama_pelanggan']) ? $tagihan['nama_pelanggan'] : 'Pelanggan') ?></h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <?= isset($tagihan['bulan']) ? $tagihan['bulan'] : '' ?> <?= isset($tagihan['tahun']) ? $tagihan['tahun'] : '' ?>
                                </small>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-<?= (isset($tagihan['status']) && $tagihan['status'] == 'sudah_bayar') ? 'success' : 'warning' ?> mb-1">
                                <i class="fas fa-<?= (isset($tagihan['status']) && $tagihan['status'] == 'sudah_bayar') ? 'check' : 'clock' ?> mr-1"></i>
                                <?= ucfirst(str_replace('_', ' ', isset($tagihan['status']) ? $tagihan['status'] : 'belum_bayar')) ?>
                            </span>
                            <div class="text-sm font-weight-bold text-primary">
                                Rp <?= number_format($tagihan['total_tagihan'] ?? 0, 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-file-invoice fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Tidak ada tagihan terbaru</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Aktivitas Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history mr-2"></i>Aktivitas Terbaru
                </h6>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-list"></i> Semua Aktivitas
                </a>
            </div>
            <div class="card-body">
                <?php if (isset($aktivitas_terbaru) && !empty($aktivitas_terbaru)): ?>
                    <?php foreach ($aktivitas_terbaru as $index => $aktivitas): ?>
                    <div class="d-flex align-items-center mb-3 p-2 <?= $index % 2 == 0 ? 'bg-light' : '' ?> rounded">
                        <div class="mr-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-<?= isset($aktivitas['icon']) ? $aktivitas['icon'] : 'circle' ?> text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-sm font-weight-bold text-gray-800">
                                <?= htmlspecialchars(isset($aktivitas['title']) ? $aktivitas['title'] : 'Aktivitas') ?>
                            </div>
                            <div class="text-sm text-gray-600">
                                <?= htmlspecialchars(isset($aktivitas['description']) ? $aktivitas['description'] : 'Deskripsi aktivitas') ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                <?= isset($aktivitas['time']) ? $aktivitas['time'] : date('d M Y') ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Tidak ada aktivitas terbaru</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS SECTION DIHAPUS UNTUK MINIMALIS -->

        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid -->

<!-- ======================================== -->
<!-- CHARTS JAVASCRIPT -->
<!-- ======================================== -->
<script>
// Area Chart
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Penggunaan (kWh)",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function(value, index, values) {
                        return number_format(value);
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                }
            }
        }
    }
});

// Pie Chart
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Sudah Bayar", "Belum Bayar"],
        datasets: [{
            data: [<?= isset($sudah_bayar) ? $sudah_bayar : 0 ?>, <?= isset($belum_bayar) ? $belum_bayar : 0 ?>],
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
            display: false
        },
        cutoutPercentage: 80,
    },
});

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if ((sep.length > 0) && (s[0].length > 3)) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script> 