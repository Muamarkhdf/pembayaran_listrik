<?php
// Customer Usage Page View
// This view displays all electricity usage data for the logged-in customer
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line mr-2"></i>Penggunaan Listrik
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($penggunaan_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Meter Awal</th>
                                    <th>Meter Akhir</th>
                                    <th>Total kWh</th>
                                    <th>Tarif/kWh</th>
                                    <th>Estimasi Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penggunaan_list as $penggunaan): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $penggunaan['bulan'] ?>/<?= $penggunaan['tahun'] ?></strong>
                                        </td>
                                        <td><?= number_format($penggunaan['meter_awal'], 0, ',', '.') ?></td>
                                        <td><?= number_format($penggunaan['meter_ahir'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge badge-info">
                                                <?= number_format($penggunaan['total_kwh'], 0, ',', '.') ?> kWh
                                            </span>
                                        </td>
                                        <td>Rp <?= number_format($penggunaan['tarifperkwh'], 0, ',', '.') ?></td>
                                        <td>
                                            <strong>Rp <?= number_format($penggunaan['estimasi_tagihan'], 0, ',', '.') ?></strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Usage Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Periode</h6>
                                    <h4><?= count($penggunaan_list) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total kWh</h6>
                                    <h4><?= number_format(array_sum(array_column($penggunaan_list, 'total_kwh')), 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Rata-rata/bulan</h6>
                                    <h4><?= count($penggunaan_list) > 0 ? number_format(array_sum(array_column($penggunaan_list, 'total_kwh')) / count($penggunaan_list), 0, ',', '.') : 0 ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Estimasi</h6>
                                    <h4>Rp <?= number_format(array_sum(array_column($penggunaan_list, 'estimasi_tagihan')), 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada data penggunaan</h5>
                        <p class="text-muted">Data penggunaan listrik akan muncul setelah admin memasukkan data meter.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 