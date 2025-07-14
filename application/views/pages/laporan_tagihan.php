<?php
$page_title = 'Laporan Tagihan';
$active_page = 'laporan';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-file-invoice mr-2"></i>Laporan Tagihan
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
                    <form method="GET" action="<?= base_url('laporan/tagihan') ?>" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="sudah_bayar" <?= ($filter_status == 'sudah_bayar') ? 'selected' : '' ?>>Sudah Bayar</option>
                                    <option value="belum_bayar" <?= ($filter_status == 'belum_bayar') ? 'selected' : '' ?>>Belum Bayar</option>
                                </select>
                            </div>
                        </div>
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
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search mr-1"></i>Filter
                                    </button>
                                    <a href="<?= base_url('laporan/tagihan') ?>" class="btn btn-secondary">
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
                                        <i class="fas fa-list mr-1"></i>Total Tagihan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format(count($tagihan)) ?>
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
                                        <i class="fas fa-check-circle mr-1"></i>Sudah Bayar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format($total_paid, 0, ',', '.') ?>
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
                                        Rp <?= number_format($total_unpaid, 0, ',', '.') ?>
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
                                        <i class="fas fa-money-bill mr-1"></i>Total Tagihan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format($total_tagihan, 0, ',', '.') ?>
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

            <!-- Bill Report Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>Data Tagihan
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
                    <?php if (!empty($tagihan)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="billTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>No. KWH</th>
                                        <th>Periode</th>
                                        <th>Daya</th>
                                        <th>Penggunaan (kWh)</th>
                                        <th>Tarif/kWh</th>
                                        <th>Total Tagihan</th>
                                        <th>Status</th>
                                        <th>Tanggal Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($tagihan as $bill): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($bill['nama_pelanggan'] ?? 'Tidak Diketahui') ?></td>
                                            <td><?= htmlspecialchars($bill['nomor_kwh'] ?? '-') ?></td>
                                            <td><?= ($bill['bulan'] ?? '-') . ' ' . ($bill['tahun'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($bill['daya'] ?? '-') ?></td>
                                            <td><?= number_format($bill['jumlah_meter'] ?? 0) ?></td>
                                            <td>Rp <?= number_format($bill['tarifperkwh'] ?? 0, 0, ',', '.') ?></td>
                                            <td>
                                                <strong>
                                                    Rp <?= number_format($bill['total_tagihan'] ?? 0, 0, ',', '.') ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <?php if (($bill['status'] ?? '') == 'sudah_bayar'): ?>
                                                    <span class="badge badge-success">Sudah Bayar</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Belum Bayar</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $bill['tanggal_bayar'] ? date('d/m/Y H:i', strtotime($bill['tanggal_bayar'])) : '-' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <th colspan="7" class="text-right"><strong>TOTAL:</strong></th>
                                        <th><strong>Rp <?= number_format($total_tagihan, 0, ',', '.') ?></strong></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-4x mb-3"></i>
                            <h5>Tidak ada data tagihan</h5>
                            <p>Belum ada data tagihan yang ditemukan dengan filter yang dipilih.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Status Distribution Chart -->
            <?php if (!empty($tagihan)): ?>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Distribusi Status Tagihan
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar mr-2"></i>Tagihan per Bulan
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart"></canvas>
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
    if ($('#billTable tbody tr').length > 0) {
        $('#billTable').DataTable({
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
    var table = $('#billTable').DataTable();
    table.button('.buttons-excel').trigger();
}

function exportToPDF() {
    var table = $('#billTable').DataTable();
    table.button('.buttons-pdf').trigger();
}

<?php if (!empty($tagihan)): ?>
// Status Distribution Chart
var statusData = {
    labels: ['Sudah Bayar', 'Belum Bayar'],
    datasets: [{
        data: [<?= $total_paid > 0 ? $total_paid : 0 ?>, <?= $total_unpaid > 0 ? $total_unpaid : 0 ?>],
        backgroundColor: ['#28a745', '#ffc107'],
        borderWidth: 2,
        borderColor: '#fff'
    }]
};

var statusCtx = document.getElementById('statusChart').getContext('2d');
var statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: statusData,
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
                        return label + ': Rp ' + new Intl.NumberFormat('id-ID').format(value) + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Monthly Bill Chart
var monthlyData = <?= json_encode(array_reduce($tagihan, function($carry, $item) {
    $period = ($item['bulan'] ?? '') . ' ' . ($item['tahun'] ?? '');
    if (!isset($carry[$period])) {
        $carry[$period] = 0;
    }
    $carry[$period] += $item['total_tagihan'] ?? 0;
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
            label: 'Total Tagihan',
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
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Total: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                    }
                }
            }
        }
    }
});
<?php endif; ?>
</script> 