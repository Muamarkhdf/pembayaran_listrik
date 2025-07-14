<?php
// Pelanggan Page
$page_title = 'Data Pelanggan';
$active_page = 'pelanggan';

// Get data from controller
$pelanggan_data = isset($pelanggan) ? $pelanggan : [];

// Konfigurasi kolom untuk tabel
$columns = [
    [
        'field' => 'nomor_kwh',
        'label' => 'Nomor KWH'
    ],
    [
        'field' => 'nama_pelanggan',
        'label' => 'Nama Pelanggan'
    ],
    [
        'field' => 'username',
        'label' => 'Username'
    ],
    [
        'field' => 'alamat',
        'label' => 'Alamat'
    ],
    [
        'field' => 'daya',
        'label' => 'Daya'
    ],
    [
        'field' => 'tarifperkwh',
        'label' => 'Tarif per kWh',
        'format' => function($value) {
            return 'Rp ' . number_format($value, 0, ',', '.');
        }
    ]
];

// Konfigurasi untuk komponen CRUD table
//$table_name = 'Data Pelanggan';
$add_url = base_url('pelanggan/add');
$edit_url = base_url('pelanggan/edit/');
$delete_url = base_url('pelanggan/delete/');
$detail_url = base_url('pelanggan/detail/');
$primary_key = 'id_pelanggan';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Alert untuk notifikasi -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1>
                <a href="<?= base_url('pelanggan/add') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pelanggan
                </a>
            </div>

            <!-- Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($pelanggan_data)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pelanggan</p>
                            <a href="<?= base_url('pelanggan/add') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Pelanggan Pertama
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor KWH</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Username</th>
                                        <th>Alamat</th>
                                        <th>Daya</th>
                                        <th>Tarif per kWh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pelanggan_data as $pelanggan): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $pelanggan['nomor_kwh'] ?></td>
                                            <td><?= $pelanggan['nama_pelanggan'] ?></td>
                                            <td><?= $pelanggan['username'] ?></td>
                                            <td><?= $pelanggan['alamat'] ?></td>
                                            <td><?= $pelanggan['daya'] ?> VA</td>
                                            <td>Rp <?= number_format($pelanggan['tarifperkwh'], 0, ',', '.') ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('pelanggan/detail/' . $pelanggan['id_pelanggan']) ?>" 
                                                       class="btn btn-info btn-sm" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('pelanggan/edit/' . $pelanggan['id_pelanggan']) ?>" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('pelanggan/delete/' . $pelanggan['id_pelanggan']) ?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data pelanggan ini?')"
                                                       title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid -->

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script> 