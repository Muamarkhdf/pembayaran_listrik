<?php
// Usage Management Page
$page_title = 'Data Penggunaan';
$active_page = 'penggunaan';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Penggunaan Listrik</h1>
                <a href="<?= base_url('penggunaan/add') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penggunaan
                </a>
            </div>

            <!-- Alert Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Usage Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-tachometer-alt mr-1"></i>Total Penggunaan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= isset($penggunaan) ? count($penggunaan) : '0' ?>
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Data penggunaan listrik
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tachometer-alt fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-bolt mr-1"></i>Total kWh
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                        $total_kwh = 0;
                                        if (isset($penggunaan)) {
                                            foreach ($penggunaan as $p) {
                                                $total_kwh += ($p['meter_ahir'] - $p['meter_awal']);
                                            }
                                        }
                                        echo number_format($total_kwh);
                                        ?>
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Kilowatt hour
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-bolt fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-file-invoice mr-1"></i>Tagihan Terbuat
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                        $tagihan_count = 0;
                                        if (isset($penggunaan)) {
                                            foreach ($penggunaan as $p) {
                                                // Check if tagihan exists for this usage
                                                $this->load->model('Tagihan_model');
                                                $tagihan = $this->Tagihan_model->check_by_penggunaan($p['id_penggunaan']);
                                                if ($tagihan) {
                                                    $tagihan_count++;
                                                }
                                            }
                                        }
                                        echo $tagihan_count;
                                        ?>
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Tagihan otomatis
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
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
                                        <i class="fas fa-calendar mr-1"></i>Bulan Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                        $current_month = date('F');
                                        $current_year = date('Y');
                                        $monthly_kwh = 0;
                                        if (isset($penggunaan)) {
                                            foreach ($penggunaan as $p) {
                                                if ($p['bulan'] == $current_month && $p['tahun'] == $current_year) {
                                                    $monthly_kwh += ($p['meter_ahir'] - $p['meter_awal']);
                                                }
                                            }
                                        }
                                        echo number_format($monthly_kwh);
                                        ?>
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        kWh bulan ini
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Daftar Penggunaan Listrik
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="<?= base_url('penggunaan/add') ?>">
                                <i class="fas fa-plus mr-2"></i>Tambah Penggunaan
                            </a>
                            <a class="dropdown-item" href="#" onclick="exportData()">
                                <i class="fas fa-download mr-2"></i>Export Data
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="printTable()">
                                <i class="fas fa-print mr-2"></i>Print
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggan</th>
                                    <th>Periode</th>
                                    <th>Meter Awal</th>
                                    <th>Meter Akhir</th>
                                    <th>Penggunaan</th>
                                    <th>Daya</th>
                                    <th>Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($penggunaan) && !empty($penggunaan)): ?>
                                    <?php foreach ($penggunaan as $index => $p): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <div>
                                                <strong><?= htmlspecialchars($p['nama_pelanggan']) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= htmlspecialchars($p['nomor_kwh']) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                <i class="fas fa-calendar mr-1"></i><?= $p['bulan'] ?> <?= $p['tahun'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                <?= number_format($p['meter_awal']) ?> kWh
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-success">
                                                <?= number_format($p['meter_ahir']) ?> kWh
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-warning">
                                                <?= number_format($p['meter_ahir'] - $p['meter_awal']) ?> kWh
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <i class="fas fa-bolt mr-1"></i><?= number_format($p['daya']) ?> VA
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                            // Check if tagihan exists for this usage
                                            $this->load->model('Tagihan_model');
                                            $tagihan = $this->Tagihan_model->check_by_penggunaan($p['id_penggunaan']);
                                            if ($tagihan): ?>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check mr-1"></i>Terbuat
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    <?php if ($tagihan['status'] == 'sudah_bayar'): ?>
                                                        <span class="text-success">Sudah Bayar</span>
                                                    <?php else: ?>
                                                        <span class="text-warning">Belum Bayar</span>
                                                    <?php endif; ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-times mr-1"></i>Belum Ada
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('penggunaan/detail/' . $p['id_penggunaan']) ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="<?= base_url('penggunaan/edit/' . $p['id_penggunaan']) ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= base_url('penggunaan/delete/' . $p['id_penggunaan']) ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data penggunaan ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-tachometer-alt fa-3x text-gray-300 mb-3"></i>
                                                <p class="text-muted">Tidak ada data penggunaan</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Usage Information Card -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle mr-2"></i>Informasi Penggunaan & Tagihan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">Meter Awal</h6>
                                            <p class="card-text">Angka meteran listrik di awal periode penagihan</p>
                                            <small class="text-muted">Contoh: 1000 kWh</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-left-success">
                                        <div class="card-body">
                                            <h6 class="card-title text-success">Meter Akhir</h6>
                                            <p class="card-text">Angka meteran listrik di akhir periode penagihan</p>
                                            <small class="text-muted">Contoh: 1500 kWh</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-left-info">
                                        <div class="card-body">
                                            <h6 class="card-title text-info">Penggunaan</h6>
                                            <p class="card-text">Selisih meter akhir dan meter awal</p>
                                            <small class="text-muted">Contoh: 500 kWh</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-warning">
                                        <div class="card-body">
                                            <h6 class="card-title text-warning">Perhitungan Tagihan</h6>
                                            <p class="card-text">Penggunaan × Tarif per kWh = Total Tagihan</p>
                                            <small class="text-muted">Contoh: 500 × Rp 1.352 = Rp 676.000</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-danger">
                                        <div class="card-body">
                                            <h6 class="card-title text-danger">Tagihan Otomatis</h6>
                                            <p class="card-text">Tagihan akan dibuat otomatis saat menambah data penggunaan</p>
                                            <small class="text-muted">Status: Belum Bayar (default)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid -->

<script>
function exportData() {
    // Export functionality
    alert('Fitur export akan segera tersedia');
}

function printTable() {
    // Print functionality
    window.print();
}
</script> 