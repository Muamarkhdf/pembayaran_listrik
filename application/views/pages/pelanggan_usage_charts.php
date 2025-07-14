<?php
// Customer Usage Charts Page View
// This view displays usage data in chart format for the logged-in customer
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie mr-2"></i>Grafik Penggunaan Listrik
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($usage_data)): ?>
                    <!-- Chart Container -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Grafik Penggunaan (6 Bulan Terakhir)</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="usageChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Statistik Penggunaan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Penggunaan Tertinggi</span>
                                            <span class="font-weight-bold text-success">
                                                <?= number_format(max(array_column($usage_data, 'total_kwh')), 0, ',', '.') ?> kWh
                                            </span>
                                        </div>
                                        <small class="text-muted">
                                            <?php 
                                            $max_usage = max(array_column($usage_data, 'total_kwh'));
                                            $max_period = array_filter($usage_data, function($u) use ($max_usage) {
                                                return $u['total_kwh'] == $max_usage;
                                            });
                                            $max_period = reset($max_period);
                                            echo $max_period ? $max_period['bulan'] . '/' . $max_period['tahun'] : '-';
                                            ?>
                                        </small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Penggunaan Terendah</span>
                                            <span class="font-weight-bold text-warning">
                                                <?= number_format(min(array_column($usage_data, 'total_kwh')), 0, ',', '.') ?> kWh
                                            </span>
                                        </div>
                                        <small class="text-muted">
                                            <?php 
                                            $min_usage = min(array_column($usage_data, 'total_kwh'));
                                            $min_period = array_filter($usage_data, function($u) use ($min_usage) {
                                                return $u['total_kwh'] == $min_usage;
                                            });
                                            $min_period = reset($min_period);
                                            echo $min_period ? $min_period['bulan'] . '/' . $min_period['tahun'] : '-';
                                            ?>
                                        </small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Rata-rata per Bulan</span>
                                            <span class="font-weight-bold text-info">
                                                <?= number_format(array_sum(array_column($usage_data, 'total_kwh')) / count($usage_data), 0, ',', '.') ?> kWh
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Total kWh</span>
                                            <span class="font-weight-bold text-primary">
                                                <?= number_format(array_sum(array_column($usage_data, 'total_kwh')), 0, ',', '.') ?> kWh
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Usage Table -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Data Penggunaan Detail</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Periode</th>
                                                    <th>Meter Awal</th>
                                                    <th>Meter Akhir</th>
                                                    <th>Total kWh</th>
                                                    <th>Trend</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($usage_data as $index => $usage): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= $usage['bulan'] ?>/<?= $usage['tahun'] ?></strong>
                                                        </td>
                                                        <td><?= number_format($usage['meter_awal'], 0, ',', '.') ?></td>
                                                        <td><?= number_format($usage['meter_ahir'], 0, ',', '.') ?></td>
                                                        <td>
                                                            <span class="badge badge-info">
                                                                <?= number_format($usage['total_kwh'], 0, ',', '.') ?> kWh
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php if ($index > 0): ?>
                                                                <?php 
                                                                $prev_usage = $usage_data[$index - 1]['total_kwh'];
                                                                $current_usage = $usage['total_kwh'];
                                                                $diff = $current_usage - $prev_usage;
                                                                $percentage = $prev_usage > 0 ? ($diff / $prev_usage) * 100 : 0;
                                                                ?>
                                                                <?php if ($diff > 0): ?>
                                                                    <span class="text-danger">
                                                                        <i class="fas fa-arrow-up"></i> +<?= number_format($percentage, 1) ?>%
                                                                    </span>
                                                                <?php elseif ($diff < 0): ?>
                                                                    <span class="text-success">
                                                                        <i class="fas fa-arrow-down"></i> <?= number_format($percentage, 1) ?>%
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="text-muted">
                                                                        <i class="fas fa-minus"></i> 0%
                                                                    </span>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada data penggunaan</h5>
                        <p class="text-muted">Grafik penggunaan akan muncul setelah ada data penggunaan listrik.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($usage_data)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Usage Chart
var ctx = document.getElementById('usageChart').getContext('2d');
var usageChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            <?php 
            foreach (array_reverse($usage_data) as $usage) {
                echo "'" . $usage['bulan'] . "/" . $usage['tahun'] . "',";
            }
            ?>
        ],
        datasets: [{
            label: 'Penggunaan (kWh)',
            data: [
                <?php 
                foreach (array_reverse($usage_data) as $usage) {
                    echo $usage['total_kwh'] . ",";
                }
                ?>
            ],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true,
            pointBackgroundColor: 'rgb(75, 192, 192)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'kWh'
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Periode'
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y + ' kWh';
                    }
                }
            }
        },
        interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
        }
    }
});
</script>
<?php endif; ?> 