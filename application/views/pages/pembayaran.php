<?php
$page_title = 'Data Pembayaran';
$active_page = 'pembayaran';

// Statistik
$total_pembayaran = 0;
$total_admin = 0;
$total_lunas = 0;
$pembayaran_hari_ini = 0;
if (isset($pembayaran)) {
    foreach ($pembayaran as $p) {
        $total_pembayaran += $p['total_bayar'];
        $total_admin += $p['biaya_admin'];
        if ($p['tanggal_pembayaran'] && date('Y-m-d', strtotime($p['tanggal_pembayaran'])) == date('Y-m-d')) {
            $pembayaran_hari_ini++;
        }
        $total_lunas++;
    }
}
?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <i class="fas fa-credit-card mr-1"></i>Total Pembayaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_pembayaran, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
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
                                <i class="fas fa-check-circle mr-1"></i>Total Tagihan Lunas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $total_lunas ?> Tagihan
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <i class="fas fa-coins mr-1"></i>Total Biaya Admin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_admin, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
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
                                <i class="fas fa-calendar-day mr-1"></i>Pembayaran Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $pembayaran_hari_ini ?> Transaksi
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Daftar Pembayaran
                    </h6>
                    <a href="<?= base_url('pembayaran/add') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pembayaran
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggan</th>
                                    <th>Periode</th>
                                    <th>Nomor KWH</th>
                                    <th>Daya</th>
                                    <th>Penggunaan</th>
                                    <th>Total Tagihan</th>
                                    <th>Biaya Admin</th>
                                    <th>Total Bayar</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Petugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($pembayaran) && !empty($pembayaran)): ?>
                                    <?php foreach ($pembayaran as $index => $p): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars(isset($p['nama_pelanggan']) ? $p['nama_pelanggan'] : '-') ?></td>
                                        <td><?= (isset($p['bulan']) ? $p['bulan'] : '-') ?> <?= (isset($p['tahun']) ? $p['tahun'] : '-') ?></td>
                                        <td><?= htmlspecialchars(isset($p['nomor_kwh']) ? $p['nomor_kwh'] : '-') ?></td>
                                        <td><?= number_format(isset($p['daya']) ? $p['daya'] : 0) ?> VA</td>
                                        <td><?= number_format(isset($p['jumlah_meter']) ? $p['jumlah_meter'] : 0) ?> kWh</td>
                                        <td>Rp <?= number_format(isset($p['total_tagihan']) ? $p['total_tagihan'] : 0, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format(isset($p['biaya_admin']) ? $p['biaya_admin'] : 0, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format(isset($p['total_bayar']) ? $p['total_bayar'] : 0, 0, ',', '.') ?></td>
                                        <td><?= (isset($p['tanggal_pembayaran']) && $p['tanggal_pembayaran']) ? date('d M Y H:i', strtotime($p['tanggal_pembayaran'])) : '-' ?></td>
                                        <td><?= htmlspecialchars(isset($p['nama_admin']) ? $p['nama_admin'] : '-') ?></td>
                                        <td>
                                            <?php if (isset($p['id_pembayaran'])): ?>
                                                <a href="<?= base_url('pembayaran/detail/' . $p['id_pembayaran']) ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href="<?= base_url('pembayaran/delete/' . $p['id_pembayaran']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pembayaran ini?')"><i class="fas fa-trash"></i></a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center">Tidak ada data pembayaran</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 