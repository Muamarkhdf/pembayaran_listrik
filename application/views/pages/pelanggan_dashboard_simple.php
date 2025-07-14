<?php
// Simple Dashboard View for Testing
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Dashboard Pelanggan</h1>
            
            <?php if (isset($customer_info) && !empty($customer_info)): ?>
                <div class="alert alert-info">
                    <h4>Selamat datang, <?= htmlspecialchars($customer_info['nama_pelanggan']) ?>!</h4>
                    <p>Nomor KWH: <?= htmlspecialchars($customer_info['nomor_kwh']) ?></p>
                    <p>Daya: <?= htmlspecialchars($customer_info['daya']) ?> VA</p>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <h4>Data pelanggan tidak ditemukan</h4>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Tagihan</h5>
                            <p class="card-text"><?= number_format($total_tagihan ?? 0) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Belum Bayar</h5>
                            <p class="card-text"><?= number_format($tagihan_belum_bayar ?? 0) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sudah Bayar</h5>
                            <p class="card-text"><?= number_format($tagihan_sudah_bayar ?? 0) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tarif per kWh</h5>
                            <p class="card-text">Rp <?= number_format($customer_info['tarifperkwh'] ?? 0) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h3>Tagihan Terbaru</h3>
                    <?php if (isset($tagihan_terbaru) && !empty($tagihan_terbaru)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>KWH</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tagihan_terbaru as $tagihan): ?>
                                    <tr>
                                        <td><?= $tagihan['bulan'] ?> <?= $tagihan['tahun'] ?></td>
                                        <td><?= number_format($tagihan['jumlah_meter']) ?></td>
                                        <td>Rp <?= number_format($tagihan['total_tagihan']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= ($tagihan['status'] == 'sudah_bayar') ? 'success' : 'warning' ?>">
                                                <?= ($tagihan['status'] == 'sudah_bayar') ? 'Sudah Bayar' : 'Belum Bayar' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada data tagihan</p>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                    <h3>Pembayaran Terbaru</h3>
                    <?php if (isset($pembayaran_terbaru) && !empty($pembayaran_terbaru)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                        <td><?= $pembayaran['bulan'] ?> <?= $pembayaran['tahun'] ?></td>
                                        <td>Rp <?= number_format($pembayaran['total_pembayaran']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada data pembayaran</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 