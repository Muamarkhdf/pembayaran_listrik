<?php
// Pelanggan Form Page
$page_title = isset($_GET['id']) ? 'Edit Pelanggan' : 'Tambah Pelanggan';
$active_page = 'pelanggan';

// Sample data untuk edit - dalam implementasi nyata, data ini akan diambil dari database
$data = [];
if (isset($_GET['id'])) {
    $data = [
        'id_pelanggan' => $_GET['id'],
        'username' => 'john_doe',
        'password' => '',
        'nomor_kwh' => '123456789',
        'nama_pelanggan' => 'John Doe',
        'alamat' => 'Jl. Contoh No. 123',
        'id_tarif' => 1
    ];
}

// Sample data tarif untuk dropdown
$tarif_options = [
    1 => '900 VA - Rp 1.352/kWh',
    2 => '1300 VA - Rp 1.444,70/kWh',
    3 => '2200 VA - Rp 1.699,53/kWh'
];

// Konfigurasi field untuk form
$fields = [
    [
        'name' => 'username',
        'label' => 'Username',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Masukkan username'
    ],
    [
        'name' => 'password',
        'label' => 'Password',
        'type' => 'password',
        'required' => !isset($_GET['id']), // Required hanya untuk tambah baru
        'placeholder' => 'Masukkan password',
        'help_text' => isset($_GET['id']) ? 'Kosongkan jika tidak ingin mengubah password' : ''
    ],
    [
        'name' => 'nomor_kwh',
        'label' => 'Nomor KWH',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Masukkan nomor KWH'
    ],
    [
        'name' => 'nama_pelanggan',
        'label' => 'Nama Pelanggan',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Masukkan nama pelanggan'
    ],
    [
        'name' => 'alamat',
        'label' => 'Alamat',
        'type' => 'textarea',
        'required' => true,
        'placeholder' => 'Masukkan alamat lengkap',
        'rows' => 3
    ],
    [
        'name' => 'id_tarif',
        'label' => 'Daya/Tarif',
        'type' => 'select',
        'required' => true,
        'options' => $tarif_options
    ]
];

// Konfigurasi untuk komponen form
$form_title = $page_title;
$action_url = isset($_GET['id']) ? 'pelanggan_update.php' : 'pelanggan_store.php';
$method = 'POST';
$submit_text = isset($_GET['id']) ? 'Update' : 'Simpan';
?>

<!-- Alert untuk notifikasi -->
<?php if (isset($_SESSION['message'])): ?>
    <?php 
    $message = $_SESSION['message'];
    $type = $_SESSION['message_type'] ?? 'info';
    unset($_SESSION['message'], $_SESSION['message_type']);
    ?>
    <?php include 'application/views/components/alert.php'; ?>
<?php endif; ?>

<!-- Form Component -->
<?php include 'application/views/components/form.php'; ?> 