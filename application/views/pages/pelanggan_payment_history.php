<?php
// Customer Payment History Page View
// This view displays all payment records for the logged-in customer
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history mr-2"></i>Riwayat Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($pembayaran_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Bayar</th>
                                    <th>Periode</th>
                                    <th>Meter (kWh)</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Biaya Admin</th>
                                    <th>Total Bayar</th>
                                    <th>Status Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembayaran_list as $pembayaran): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($pembayaran['tanggal_pembayaran'])) ?></td>
                                        <td>
                                            <strong><?= $pembayaran['bulan'] ?>/<?= $pembayaran['tahun'] ?></strong>
                                        </td>
                                        <td><?= number_format($pembayaran['jumlah_meter'], 0, ',', '.') ?> kWh</td>
                                        <td>Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($pembayaran['biaya_admin'], 0, ',', '.') ?></td>
                                        <td>
                                            <strong>Rp <?= number_format($pembayaran['total_bayar'], 0, ',', '.') ?></strong>
                                        </td>
                                        <td>
                                            <?php if ($pembayaran['tagihan_status'] == 'sudah_bayar'): ?>
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
                    
                    <!-- Payment Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Pembayaran</h6>
                                    <h4><?= count($pembayaran_list) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Bayar</h6>
                                    <h4>Rp <?= number_format(array_sum(array_column($pembayaran_list, 'total_bayar')), 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Rata-rata Bayar</h6>
                                    <h4>Rp <?= count($pembayaran_list) > 0 ? number_format(array_sum(array_column($pembayaran_list, 'total_bayar')) / count($pembayaran_list), 0, ',', '.') : 0 ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Admin</h6>
                                    <h4>Rp <?= number_format(array_sum(array_column($pembayaran_list, 'biaya_admin')), 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada riwayat pembayaran</h5>
                        <p class="text-muted">Riwayat pembayaran akan muncul setelah Anda melakukan pembayaran tagihan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 