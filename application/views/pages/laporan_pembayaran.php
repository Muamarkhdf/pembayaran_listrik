<?php
$page_title = 'Laporan Pembayaran';
$active_page = 'laporan';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-money-bill mr-2"></i>Laporan Pembayaran
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
                    <form method="GET" action="<?= base_url('laporan/pembayaran') ?>" class="row">
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
                                    <a href="<?= base_url('laporan/pembayaran') ?>" class="btn btn-secondary">
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
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-list mr-1"></i>Total Pembayaran
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= number_format(count($pembayaran)) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <i class="fas fa-money-bill mr-1"></i>Total Pembayaran
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format($total_pembayaran, 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        <i class="fas fa-percentage mr-1"></i>Total Biaya Admin
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rp <?= number_format($total_admin, 0, ',', '.') ?>
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

            <!-- Payment Report Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table mr-2"></i>Data Pembayaran
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
                    <?php if (!empty($pembayaran)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="paymentTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>No. KWH</th>
                                        <th>Periode</th>
                                        <th>Daya</th>
                                        <th>Penggunaan (kWh)</th>
                                        <th>Tarif/kWh</th>
                                        <th>Total Tagihan</th>
                                        <th>Biaya Admin</th>
                                        <th>Total Bayar</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pembayaran as $payment): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?= $payment['tanggal_pembayaran'] ? date('d/m/Y H:i', strtotime($payment['tanggal_pembayaran'])) : '-' ?>
                                            </td>
                                            <td><?= htmlspecialchars($payment['nama_pelanggan'] ?? 'Tidak Diketahui') ?></td>
                                            <td><?= htmlspecialchars($payment['nomor_kwh'] ?? '-') ?></td>
                                            <td><?= ($payment['bulan'] ?? '-') . ' ' . ($payment['tahun'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($payment['daya'] ?? '-') ?></td>
                                            <td><?= number_format($payment['jumlah_meter'] ?? 0) ?></td>
                                            <td>Rp <?= number_format($payment['tarifperkwh'] ?? 0, 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format(($payment['tarifperkwh'] ?? 0) * ($payment['jumlah_meter'] ?? 0), 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($payment['biaya_admin'] ?? 0, 0, ',', '.') ?></td>
                                            <td>
                                                <strong class="text-success">
                                                    Rp <?= number_format($payment['total_bayar'] ?? 0, 0, ',', '.') ?>
                                                </strong>
                                            </td>
                                            <td><?= htmlspecialchars($payment['nama_admin'] ?? 'Tidak Diketahui') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <th colspan="9" class="text-right"><strong>TOTAL:</strong></th>
                                        <th>Rp <?= number_format($total_admin, 0, ',', '.') ?></th>
                                        <th><strong>Rp <?= number_format($total_pembayaran, 0, ',', '.') ?></strong></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-4x mb-3"></i>
                            <h5>Tidak ada data pembayaran</h5>
                            <p>Belum ada data pembayaran yang ditemukan dengan filter yang dipilih.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    if ($('#paymentTable tbody tr').length > 0) {
        $('#paymentTable').DataTable({
            "pageLength": 25,
            "order": [[1, "desc"]], // Sort by date descending
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
    var table = $('#paymentTable').DataTable();
    table.button('.buttons-excel').trigger();
}

function exportToPDF() {
    var table = $('#paymentTable').DataTable();
    table.button('.buttons-pdf').trigger();
}
</script> 