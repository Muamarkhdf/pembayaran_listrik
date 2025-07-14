<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $page_title ?? 'Dashboard Pelanggan' ?> - Sistem Pembayaran Listrik</title>

    <!-- Google Fonts Nunito -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <!-- Font Awesome 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap 4.6.0 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background-color: #f8f9fc;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        }
        .sidebar .nav-link, .sidebar .sidebar-heading {
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-weight: bold;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        .sidebar .sidebar-heading {
            font-size: 0.8rem;
            font-weight: bold;
            padding: 1rem 1.5rem 0.5rem 1.5rem;
            letter-spacing: 1px;
        }
        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,0.15);
            margin: 0.5rem 0;
        }
        .sidebar-brand {
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            letter-spacing: 0.1rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-brand .sidebar-brand-icon {
            font-size: 2rem;
            margin-right: 0.5rem;
        }
        .topbar {
            height: 4.375rem;
        }
        .img-profile {
            height: 2rem;
            width: 2rem;
        }
        .card.shadow {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,0.15)!important;
        }
        .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
        .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
        .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
        .badge-success { background: #1cc88a; color: #fff; }
        .badge-warning { background: #f6c23e; color: #fff; }
        .badge-info { background: #36b9cc; color: #fff; }
        .table th, .table td { vertical-align: middle; }
        @media (max-width: 991.98px) {
            .sidebar { min-width: 0; width: 100%; position: relative; }
        }
    </style>
</head>
<body id="page-top">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <!-- Sidebar -->
            <nav class="col-lg-2 col-md-3 d-md-block sidebar sidebar-dark accordion p-0" id="accordionSidebar">
                <div class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('customer') ?>">
                    <div class="sidebar-brand-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="sidebar-brand-text mx-2">PLN</div>
                </div>
                <hr class="sidebar-divider my-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= ($active_page == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('customer') ?>">
                            <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <hr class="sidebar-divider">
                    <div class="sidebar-heading">Menu Pelanggan</div>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active_page == 'bills') ? 'active' : '' ?>" href="<?= base_url('customer/bills') ?>">
                            <i class="fas fa-fw fa-file-invoice"></i> Tagihan Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active_page == 'usage') ? 'active' : '' ?>" href="<?= base_url('customer/usage') ?>">
                            <i class="fas fa-fw fa-chart-line"></i> Penggunaan Listrik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active_page == 'payment_history') ? 'active' : '' ?>" href="<?= base_url('customer/payment_history') ?>">
                            <i class="fas fa-fw fa-history"></i> Riwayat Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active_page == 'usage_charts') ? 'active' : '' ?>" href="<?= base_url('customer/usage_charts') ?>">
                            <i class="fas fa-fw fa-chart-pie"></i> Grafik Penggunaan
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar -->
            <main class="col-lg-10 col-md-9 ml-sm-auto px-4" id="content-wrapper">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('nama_pelanggan') ?></span>
                                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End Topbar -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?? 'Dashboard Pelanggan' ?></h1>
                    </div>
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
                <footer class="sticky-footer bg-white mt-4">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Sistem Pembayaran Listrik <?= date('Y') ?></span>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html> 