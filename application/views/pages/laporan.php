<?php
$page_title = 'Laporan';
$active_page = 'laporan';
?>

<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Laporan</h1>
    <div class="btn-group" role="group">
        <a href="<?= base_url('laporan/pembayaran') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-money-bill"></i> Laporan Pembayaran
        </a>
        <a href="<?= base_url('laporan/tagihan') ?>" class="btn btn-info btn-sm">
            <i class="fas fa-file-invoice"></i> Laporan Tagihan
        </a>
        <a href="<?= base_url('laporan/pelanggan') ?>" class="btn btn-success btn-sm">
            <i class="fas fa-users"></i> Laporan Pelanggan
        </a>
        <a href="<?= base_url('laporan/penggunaan') ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-tachometer-alt"></i> Laporan Penggunaan
        </a>
    </div>
</div> -->

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex gap-2 align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Laporan</h1>
        <div class="flex gap-2" role="group">
            <a href="<?= base_url('pembayaran/report') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-receipt"></i> Laporan Pembayaran
            </a>
            <a href="<?= base_url('laporan/tagihan') ?>" class="btn btn-info btn-sm">
                <i class="fas fa-file-invoice"></i> Laporan Tagihan
            </a>
            <a href="<?= base_url('laporan/pelanggan') ?>" class="btn btn-success btn-sm">
                <i class="fas fa-users"></i> Laporan Pelanggan
            </a>
            <a href="<?= base_url('laporan/penggunaan') ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-tachometer-alt"></i> Laporan Penggunaan
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-users mr-1"></i>Total Pelanggan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($summary['total_pelanggan'] ?? 0) ?>
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
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <i class="fas fa-check-circle mr-1"></i>Tagihan Lunas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($summary['tagihan_lunas'] ?? 0) ?>
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
                                        <i class="fas fa-clock mr-1"></i>Tagihan Belum Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($summary['tagihan_belum_bayar'] ?? 0) ?>
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
                                        <i class="fas fa-money-bill mr-1"></i>Total Pembayaran
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format($summary['total_pembayaran'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Monthly Statistics Chart -->
                <!-- <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Statistik Pembayaran Bulanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Recent Payments -->
                <div class="col-xl-12 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history mr-2"></i>Pembayaran Terbaru
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_payments)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($recent_payments as $payment): ?>
                                        <div class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><?= htmlspecialchars($payment['nama_pelanggan'] ?? 'Tidak Diketahui') ?></h6>
                                                <small class="text-success">Rp <?= number_format($payment['total_bayar'] ?? 0, 0, ',', '.') ?></small>
                                            </div>
                                            <p class="mb-1">
                                                <small class="text-muted">
                                                    <?= $payment['bulan'] ?? '-' ?> <?= $payment['tahun'] ?? '-' ?> | 
                                                    <?= $payment['tanggal_pembayaran'] ? date('d M Y H:i', strtotime($payment['tanggal_pembayaran'])) : '-' ?>
                                                </small>
                                            </p>
                                            <small class="text-muted">Petugas: <?= htmlspecialchars($payment['nama_admin'] ?? 'Tidak Diketahui') ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Tidak ada pembayaran terbaru</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Customers and Quick Actions -->
            <div class="row">
                <!-- Top Customers -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-trophy mr-2"></i>Top 5 Pelanggan
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($top_customers)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Pelanggan</th>
                                                <th>Jumlah Tagihan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($top_customers as $customer): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= htmlspecialchars($customer['nama_pelanggan'] ?? 'Tidak Diketahui') ?></strong><br>
                                                        <small class="text-muted"><?= htmlspecialchars($customer['nomor_kwh'] ?? '-') ?></small>
                                                    </td>
                                                    <td><?= number_format($customer['jumlah_tagihan'] ?? 0) ?></td>
                                                    <td>
                                                        <?php if (($customer['tagihan_lunas'] ?? 0) > 0): ?>
                                                            <span class="badge badge-success"><?= $customer['tagihan_lunas'] ?> Lunas</span>
                                                        <?php endif; ?>
                                                        <?php if (($customer['tagihan_belum_bayar'] ?? 0) > 0): ?>
                                                            <span class="badge badge-warning"><?= $customer['tagihan_belum_bayar'] ?> Belum Bayar</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>Tidak ada data pelanggan</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <a href="<?= base_url('laporan/pembayaran') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-money-bill mr-2"></i>Laporan Pembayaran
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="<?= base_url('laporan/tagihan') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-file-invoice mr-2"></i>Laporan Tagihan
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="<?= base_url('laporan/pelanggan') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-users mr-2"></i>Laporan Pelanggan
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="<?= base_url('laporan/penggunaan') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Laporan Penggunaan
                                    </a>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-primary">Filter Laporan</h6>
                                    <div class="form-group">
                                        <label>Bulan:</label>
                                        <select class="form-control form-control-sm" id="filterBulan">
                                            <option value="">Semua Bulan</option>
                                            <option value="Januari">Januari</option>
                                            <option value="Februari">Februari</option>
                                            <option value="Maret">Maret</option>
                                            <option value="April">April</option>
                                            <option value="Mei">Mei</option>
                                            <option value="Juni">Juni</option>
                                            <option value="Juli">Juli</option>
                                            <option value="Agustus">Agustus</option>
                                            <option value="September">September</option>
                                            <option value="Oktober">Oktober</option>
                                            <option value="November">November</option>
                                            <option value="Desember">Desember</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tahun:</label>
                                        <select class="form-control form-control-sm" id="filterTahun">
                                            <option value="">Semua Tahun</option>
                                            <?php for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++): ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyFilters()">
                                        <i class="fas fa-filter mr-1"></i>Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Monthly Statistics Chart
var monthlyData = <?= json_encode($monthly_stats ?? []) ?>;
var labels = [];
var paymentData = [];
var adminData = [];

monthlyData.forEach(function(item) {
    var date = new Date(item.bulan_tahun + '-01');
    labels.push(date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' }));
    paymentData.push(parseFloat(item.total_pembayaran || 0));
    adminData.push(parseFloat(item.total_biaya_admin || 0));
});

var ctx = document.getElementById('monthlyChart').getContext('2d');
var monthlyChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Pembayaran',
            data: paymentData,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: 'Biaya Admin',
            data: adminData,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                    }
                }
            }
        }
    }
});

// Filter function
function applyFilters() {
    var bulan = document.getElementById('filterBulan').value;
    var tahun = document.getElementById('filterTahun').value;
    
    var url = '<?= base_url('laporan/pembayaran') ?>?';
    if (bulan) url += 'bulan=' + bulan + '&';
    if (tahun) url += 'tahun=' + tahun;
    
    window.location.href = url;
}
</script> 