<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Dashboard Pelanggan' ?> - Sistem Pembayaran Listrik</title>
    
    <!-- Bootstrap 4.6.0 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- Font Awesome 5.15.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fc;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('customer') ?>">
            <i class="fas fa-bolt mr-2"></i>Sistem Pembayaran Listrik
        </a>
        
        <div class="navbar-nav ml-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    <i class="fas fa-user mr-1"></i><?= $this->session->userdata('nama_pelanggan') ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?= base_url('pelanggan_dashboard/profile') ?>">
                        <i class="fas fa-user-edit mr-2"></i>Profil Saya
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bars mr-2"></i>Menu</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="<?= base_url('customer') ?>" class="list-group-item list-group-item-action <?= ($active_page == 'dashboard') ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="<?= base_url('customer/bills') ?>" class="list-group-item list-group-item-action <?= ($active_page == 'bills') ? 'active' : '' ?>">
                            <i class="fas fa-file-invoice mr-2"></i>Tagihan Saya
                        </a>
                        <a href="<?= base_url('customer/usage') ?>" class="list-group-item list-group-item-action <?= ($active_page == 'usage') ? 'active' : '' ?>">
                            <i class="fas fa-chart-line mr-2"></i>Penggunaan Listrik
                        </a>
                        <a href="<?= base_url('customer/payment_history') ?>" class="list-group-item list-group-item-action <?= ($active_page == 'payment_history') ? 'active' : '' ?>">
                            <i class="fas fa-history mr-2"></i>Riwayat Pembayaran
                        </a>
                        <a href="<?= base_url('customer/usage_charts') ?>" class="list-group-item list-group-item-action <?= ($active_page == 'usage_charts') ? 'active' : '' ?>">
                            <i class="fas fa-chart-pie mr-2"></i>Grafik Penggunaan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="col-md-9">
            <?php if (isset($page_title) && $page_title == 'Dashboard Pelanggan'): ?>
                <?php $this->load->view('pages/pelanggan_dashboard_simple'); ?>
            <?php elseif (isset($page_title) && $page_title == 'Tagihan Saya'): ?>
                <?php $this->load->view('pages/pelanggan_bills'); ?>
            <?php elseif (isset($page_title) && $page_title == 'Penggunaan Listrik'): ?>
                <?php $this->load->view('pages/pelanggan_usage'); ?>
            <?php elseif (isset($page_title) && $page_title == 'Riwayat Pembayaran'): ?>
                <?php $this->load->view('pages/pelanggan_payment_history'); ?>
            <?php elseif (isset($page_title) && $page_title == 'Grafik Penggunaan'): ?>
                <?php $this->load->view('pages/pelanggan_usage_charts'); ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    <h4>Halaman tidak ditemukan</h4>
                    <p>Konten yang diminta tidak dapat dimuat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- jQuery 3.6.0 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4.6.0 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

</body>
</html> 