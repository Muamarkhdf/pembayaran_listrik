<?php
$page_title = 'Laporan Penggunaan';
$active_page = 'laporan';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-tachometer-alt mr-2"></i>Laporan Penggunaan
                </h1>
                <a href="<?= base_url('laporan') ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
            </div>

            <!-- Filter Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter mr-2"></i>Filter Laporan
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= base_url('laporan/penggunaan') ?>" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    <option value="">Semua Bulan</option>
                                    <?php foreach ($bulan_list as $bulan): ?>
                                        <option value="<?= $bulan ?>" <?= ($filter_bulan == $bulan) ? 'selected' : '' ?>>
                                            <?= $bulan ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    <?php foreach ($tahun_list as $tahun): ?>
                                        <option value="<?= $tahun ?>" <?= ($filter_tahun == $tahun) ? 'selected' : '' ?>>
                                            <?= $tahun ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pelanggan">Pelanggan</label>
                                <select name="pelanggan" id="pelanggan" class="form-control">
                                    <option value="">Semua Pelanggan</option>
                                    <?php foreach ($pelanggan_list as $pelanggan): ?>
                                        <option value="<?= $pelanggan['id_pelanggan'] ?>" <?= ($filter_pelanggan == $pelanggan['id_pelanggan']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($pelanggan['nama_pelanggan']) ?> - <?= htmlspecialchars($pelanggan['nomor_kwh']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search mr-1"></i>Filter
                                    </button>
                                    <a href="<?= base_url('laporan/penggunaan') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times mr-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                        <i class="fas fa-list mr-1"></i>Total Penggunaan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format(count($penggunaan)) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list fa-2x text-gray-300"></i>
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
                                        <?= number_format($total_usage, 0, ',', '.') ?> kWh
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
                                        <i class="fas fa-chart-line mr-1"></i>Rata-rata kWh
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($average_usage, 2, ',', '.') ?> kWh
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
                                        <i class="fas fa-users mr-1"></i>Pelanggan Aktif
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format(count(array_unique(array_column($penggunaan, 'id_pelanggan')))) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Report Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>Data Penggunaan
                    </h6>
                    <div>
                        <button type="button" class="btn btn-success btn-sm" onclick="exportToExcel()">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf mr-1"></i>Export PDF
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($penggunaan)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="usageTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>No. KWH</th>
                                        <th>Periode</th>
                                        <th>Daya</th>
                                        <th>Meter Awal</th>
                                        <th>Meter Akhir</th>
                                        <th>Penggunaan (kWh)</th>
                                        <th>Tarif/kWh</th>
                                        <th>Total Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($penggunaan as $usage): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($usage['nama_pelanggan'] ?? 'Tidak Diketahui') ?></td>
                                            <td><?= htmlspecialchars($usage['nomor_kwh'] ?? '-') ?></td>
                                            <td><?= ($usage['bulan'] ?? '-') . ' ' . ($usage['tahun'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($usage['daya'] ?? '-') ?></td>
                                            <td><?= number_format($usage['meter_awal'] ?? 0) ?></td>
                                            <td><?= number_format($usage['meter_ahir'] ?? 0) ?></td>
                                            <td>
                                                <strong class="text-primary">
                                                    <?= number_format($usage['penggunaan_kwh'] ?? 0) ?> kWh
                                                </strong>
                                            </td>
                                            <td>Rp <?= number_format($usage['tarifperkwh'] ?? 0, 0, ',', '.') ?></td>
                                            <td>
                                                <strong class="text-success">
                                                    Rp <?= number_format(($usage['penggunaan_kwh'] ?? 0) * ($usage['tarifperkwh'] ?? 0), 0, ',', '.') ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <th colspan="7" class="text-right"><strong>TOTAL:</strong></th>
                                        <th><strong><?= number_format($total_usage, 0, ',', '.') ?> kWh</strong></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-tachometer-alt fa-4x mb-3"></i>
                            <h5>Tidak ada data penggunaan</h5>
                            <p>Belum ada data penggunaan yang ditemukan dengan filter yang dipilih.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Usage Charts -->
            <?php if (!empty($penggunaan)): ?>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar mr-2"></i>Penggunaan per Bulan
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Distribusi Penggunaan per Tarif
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="tarifChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Trend Penggunaan Tahunan
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    if ($('#usageTable tbody tr').length > 0) {
        $('#usageTable').DataTable({
            "pageLength": 25,
            "order": [[3, "desc"]], // Sort by period descending
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "dom": 'Bfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    }
});

// Export functions
function exportToExcel() {
    var table = $('#usageTable').DataTable();
    table.button('.buttons-excel').trigger();
}

function exportToPDF() {
    var table = $('#usageTable').DataTable();
    table.button('.buttons-pdf').trigger();
}

<?php if (!empty($penggunaan)): ?>
// Monthly Usage Chart
var monthlyData = <?= json_encode(array_reduce($penggunaan, function($carry, $item) {
    $period = ($item['bulan'] ?? '') . ' ' . ($item['tahun'] ?? '');
    if (!isset($carry[$period])) {
        $carry[$period] = 0;
    }
    $carry[$period] += $item['penggunaan_kwh'] ?? 0;
    return $carry;
}, [])) ?>;

var monthlyLabels = Object.keys(monthlyData);
var monthlyValues = Object.values(monthlyData);

var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
var monthlyChart = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Total kWh',
            data: monthlyValues,
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
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
                        return value.toLocaleString('id-ID') + ' kWh';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Total: ' + context.parsed.y.toLocaleString('id-ID') + ' kWh';
                    }
                }
            }
        }
    }
});

// Tarif Distribution Chart
var tarifData = <?= json_encode(array_reduce($penggunaan, function($carry, $item) {
    $tarif = ($item['daya'] ?? 'Tidak Diketahui');
    if (!isset($carry[$tarif])) {
        $carry[$tarif] = 0;
    }
    $carry[$tarif] += $item['penggunaan_kwh'] ?? 0;
    return $carry;
}, [])) ?>;

var tarifLabels = Object.keys(tarifData);
var tarifValues = Object.values(tarifData);

var tarifCtx = document.getElementById('tarifChart').getContext('2d');
var tarifChart = new Chart(tarifCtx, {
    type: 'doughnut',
    data: {
        labels: tarifLabels,
        datasets: [{
            data: tarifValues,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        var value = context.parsed;
                        var total = context.dataset.data.reduce((a, b) => a + b, 0);
                        var percentage = ((value / total) * 100).toFixed(1);
                        return label + ': ' + value.toLocaleString('id-ID') + ' kWh (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Trend Chart
var trendData = <?= json_encode(array_reduce($penggunaan, function($carry, $item) {
    $year = $item['tahun'] ?? 'Tidak Diketahui';
    if (!isset($carry[$year])) {
        $carry[$year] = 0;
    }
    $carry[$year] += $item['penggunaan_kwh'] ?? 0;
    return $carry;
}, [])) ?>;

var trendLabels = Object.keys(trendData).sort();
var trendValues = trendLabels.map(function(key) {
    return trendData[key];
});

var trendCtx = document.getElementById('trendChart').getContext('2d');
var trendChart = new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: trendLabels,
        datasets: [{
            label: 'Total kWh per Tahun',
            data: trendValues,
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
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('id-ID') + ' kWh';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Total: ' + context.parsed.y.toLocaleString('id-ID') + ' kWh';
                    }
                }
            }
        }
    }
});
<?php endif; ?>
</script> 