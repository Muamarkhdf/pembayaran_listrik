<?php
// Customer Dashboard Simple View
// This view displays customer dashboard with statistics and recent activities
?>

<div class="row">
    <!-- Welcome Section -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="fas fa-user-circle mr-2"></i>
                    Selamat Datang, <?= $customer_info['nama_pelanggan'] ?? 'Pelanggan' ?>!
                </h4>
                <p class="card-text text-muted">
                    Nomor KWH: <?= $customer_info['nomor_kwh'] ?? '-' ?> | 
                    Daya: <?= $customer_info['daya'] ?? '-' ?> VA | 
                    Tarif: Rp <?= number_format($customer_info['tarifperkwh'] ?? 0, 0, ',', '.') ?>/kWh
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Tagihan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $total_tagihan ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Belum Bayar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tagihan_belum_bayar ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Sudah Bayar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tagihan_sudah_bayar ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card border-left-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Penggunaan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count($statistik_penggunaan) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Bills -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i>Tagihan Terbaru
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($tagihan_terbaru)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Meter</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tagihan_terbaru as $tagihan): ?>
                                    <tr>
                                        <td><?= $tagihan['bulan'] ?>/<?= $tagihan['tahun'] ?></td>
                                        <td><?= $tagihan['jumlah_meter'] ?> kWh</td>
                                        <td>Rp <?= number_format($tagihan['total_tagihan'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($tagihan['status'] == 'sudah_bayar'): ?>
                                                <span class="badge badge-success">Lunas</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Belum Bayar</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Belum ada tagihan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-history mr-2"></i>Pembayaran Terbaru
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($pembayaran_terbaru)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Periode</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembayaran_terbaru as $pembayaran): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($pembayaran['tanggal_pembayaran'])) ?></td>
                                        <td><?= $pembayaran['bulan'] ?>/<?= $pembayaran['tahun'] ?></td>
                                        <td>Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Belum ada pembayaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Usage Statistics -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-chart-line mr-2"></i>Statistik Penggunaan (6 Bulan Terakhir)
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($statistik_penggunaan)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Meter Awal</th>
                                    <th>Meter Akhir</th>
                                    <th>Total kWh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($statistik_penggunaan as $penggunaan): ?>
                                    <tr>
                                        <td><?= $penggunaan['bulan'] ?>/<?= $penggunaan['tahun'] ?></td>
                                        <td><?= number_format($penggunaan['meter_awal'], 0, ',', '.') ?></td>
                                        <td><?= number_format($penggunaan['meter_ahir'], 0, ',', '.') ?></td>
                                        <td><?= number_format($penggunaan['total_kwh'], 0, ',', '.') ?> kWh</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-0">Belum ada data penggunaan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('customer/bills') ?>" class="btn btn-primary btn-block">
                            <i class="fas fa-file-invoice mr-2"></i>Lihat Tagihan
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('customer/usage') ?>" class="btn btn-info btn-block">
                            <i class="fas fa-chart-line mr-2"></i>Penggunaan
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('customer/payment_history') ?>" class="btn btn-success btn-block">
                            <i class="fas fa-history mr-2"></i>Riwayat Bayar
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('customer/usage_charts') ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-chart-pie mr-2"></i>Grafik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 