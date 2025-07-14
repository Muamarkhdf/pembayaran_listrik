<?php
// Pelanggan Page
$page_title = 'Data Pelanggan';
$active_page = 'pelanggan';

// Sample data - dalam implementasi nyata, data ini akan diambil dari database
$data = [
    [
        'id_pelanggan' => 1,
        'username' => 'john_doe',
        'nomor_kwh' => '123456789',
        'nama_pelanggan' => 'John Doe',
        'alamat' => 'Jl. Contoh No. 123',
        'nama_tarif' => '900 VA',
        'tarif_perkwh' => '1352.00'
    ],
    [
        'id_pelanggan' => 2,
        'username' => 'jane_smith',
        'nomor_kwh' => '987654321',
        'nama_pelanggan' => 'Jane Smith',
        'alamat' => 'Jl. Sample No. 456',
        'nama_tarif' => '1300 VA',
        'tarif_perkwh' => '1444.70'
    ]
];

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
        'field' => 'nama_tarif',
        'label' => 'Daya/Tarif'
    ],
    [
        'field' => 'tarif_perkwh',
        'label' => 'Tarif per kWh',
        'format' => function($value) {
            return 'Rp ' . number_format($value, 0, ',', '.');
        }
    ]
];

// Konfigurasi untuk komponen CRUD table
$table_name = 'Data Pelanggan';
$add_url = 'pelanggan_add.php';
$edit_url = 'pelanggan_edit.php';
$delete_url = 'pelanggan_delete.php';
$primary_key = 'id_pelanggan';
?>

<!-- ======================================== -->
<!-- CONTAINER FLUID LAYOUT -->
<!-- ======================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Alert untuk notifikasi -->
            <?php if (isset($_SESSION['message'])): ?>
                <?php 
                $message = $_SESSION['message'];
                $type = $_SESSION['message_type'] ?? 'info';
                unset($_SESSION['message'], $_SESSION['message_type']);
                ?>
                <?php include 'application/views/components/alert.php'; ?>
            <?php endif; ?>

            <!-- CRUD Table Component -->
            <?php include 'application/views/components/crud_table.php'; ?>
            
        </div> <!-- col-md-12 -->
    </div> <!-- row -->
</div> <!-- container-fluid --> 