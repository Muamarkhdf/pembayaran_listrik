<?php
// Customer Bills Page View
// This view displays all bills for the logged-in customer
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-invoice mr-2"></i>Tagihan Saya
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($tagihan_list)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Meter (kWh)</th>
                                    <th>Tarif/kWh</th>
                                    <th>Total Tagihan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tagihan_list as $tagihan): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $tagihan['bulan'] ?>/<?= $tagihan['tahun'] ?></strong>
                                        </td>
                                        <td><?= number_format($tagihan['jumlah_meter'], 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($tagihan['tarifperkwh'], 0, ',', '.') ?></td>
                                        <td>
                                            <strong>Rp <?= number_format($tagihan['total_tagihan'], 0, ',', '.') ?></strong>
                                        </td>
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
                    
                    <!-- Summary -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Total Tagihan</h6>
                                    <h4><?= count($tagihan_list) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Belum Bayar</h6>
                                    <h4><?= count(array_filter($tagihan_list, function($t) { return $t['status'] == 'belum_bayar'; })) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Sudah Bayar</h6>
                                    <h4><?= count(array_filter($tagihan_list, function($t) { return $t['status'] == 'sudah_bayar'; })) ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada tagihan</h5>
                        <p class="text-muted">Tagihan akan muncul setelah data penggunaan listrik dimasukkan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 