<?php
$page_title = 'Laporan Pelanggan';
$active_page = 'laporan';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-users mr-2"></i>Laporan Pelanggan
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
                    <form method="GET" action="<?= base_url('laporan/pelanggan') ?>" class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tarif">Tarif/Daya</label>
                                <select name="tarif" id="tarif" class="form-control">
                                    <option value="">Semua Tarif</option>
                                    <?php foreach ($tarif_list as $tarif): ?>
                                        <option value="<?= $tarif['id_tarif'] ?>" <?= ($filter_tarif == $tarif['id_tarif']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($tarif['daya']) ?> - Rp <?= number_format($tarif['tarifperkwh'], 0, ',', '.') ?>/kWh
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status Aktivitas</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="active" <?= ($filter_status == 'active') ? 'selected' : '' ?>>Aktif (Ada Tagihan)</option>
                                    <option value="inactive" <?= ($filter_status == 'inactive') ? 'selected' : '' ?>>Tidak Aktif (Tidak Ada Tagihan)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search mr-1"></i>Filter
                                    </button>
                                    <a href="<?= base_url('laporan/pelanggan') ?>" class="btn btn-secondary">
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
                                        <i class="fas fa-users mr-1"></i>Total Pelanggan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($total_customers) ?>
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
                                        <i class="fas fa-check-circle mr-1"></i>Pelanggan Aktif
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($active_customers) ?>
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
                                        <i class="fas fa-clock mr-1"></i>Pelanggan Tidak Aktif
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format($inactive_customers) ?>
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
                                        <i class="fas fa-percentage mr-1"></i>Rasio Aktif
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_customers > 0 ? number_format(($active_customers / $total_customers) * 100, 1) : 0 ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Report Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>Data Pelanggan
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
                    <?php if (!empty($pelanggan)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="customerTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>No. KWH</th>
                                        <th>Alamat</th>
                                        <th>Daya</th>
                                        <th>Tarif/kWh</th>
                                        <th>Jumlah Tagihan</th>
                                        <th>Tagihan Lunas</th>
                                        <th>Tagihan Belum Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pelanggan as $customer): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($customer['nama_pelanggan'] ?? 'Tidak Diketahui') ?></td>
                                            <td><?= htmlspecialchars($customer['nomor_kwh'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($customer['alamat'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($customer['daya'] ?? '-') ?></td>
                                            <td>Rp <?= number_format($customer['tarifperkwh'] ?? 0, 0, ',', '.') ?></td>
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?= number_format($customer['jumlah_tagihan'] ?? 0) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (($customer['tagihan_lunas'] ?? 0) > 0): ?>
                                                    <span class="badge badge-success">
                                                        <?= number_format($customer['tagihan_lunas']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">0</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (($customer['tagihan_belum_bayar'] ?? 0) > 0): ?>
                                                    <span class="badge badge-warning">
                                                        <?= number_format($customer['tagihan_belum_bayar']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">0</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (($customer['jumlah_tagihan'] ?? 0) > 0): ?>
                                                    <span class="badge badge-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-users fa-4x mb-3"></i>
                            <h5>Tidak ada data pelanggan</h5>
                            <p>Belum ada data pelanggan yang ditemukan dengan filter yang dipilih.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Customer Distribution Charts -->
            <?php if (!empty($pelanggan)): ?>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie mr-2"></i>Distribusi Status Pelanggan
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
                                <i class="fas fa-chart-bar mr-2"></i>Pelanggan per Tarif
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="tarifChart"></canvas>
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
    if ($('#customerTable tbody tr').length > 0) {
        $('#customerTable').DataTable({
            "pageLength": 25,
            "order": [[1, "asc"]], // Sort by customer name ascending
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
    var table = $('#customerTable').DataTable();
    table.button('.buttons-excel').trigger();
}

function exportToPDF() {
    var table = $('#customerTable').DataTable();
    table.button('.buttons-pdf').trigger();
}

<?php if (!empty($pelanggan)): ?>
// Status Distribution Chart
var statusData = {
    labels: ['Aktif', 'Tidak Aktif'],
    datasets: [{
        data: [<?= $active_customers ?>, <?= $inactive_customers ?>],
        backgroundColor: ['#28a745', '#6c757d'],
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
                        return label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Tarif Distribution Chart
var tarifData = <?= json_encode(array_reduce($pelanggan, function($carry, $item) {
    $tarif = ($item['daya'] ?? 'Tidak Diketahui');
    if (!isset($carry[$tarif])) {
        $carry[$tarif] = 0;
    }
    $carry[$tarif]++;
    return $carry;
}, [])) ?>;

var tarifLabels = Object.keys(tarifData);
var tarifValues = Object.values(tarifData);

var tarifCtx = document.getElementById('tarifChart').getContext('2d');
var tarifChart = new Chart(tarifCtx, {
    type: 'bar',
    data: {
        labels: tarifLabels,
        datasets: [{
            label: 'Jumlah Pelanggan',
            data: tarifValues,
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
                    stepSize: 1
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Jumlah: ' + context.parsed.y + ' pelanggan';
                    }
                }
            }
        }
    }
});
<?php endif; ?>
</script> 