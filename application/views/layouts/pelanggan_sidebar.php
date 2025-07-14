<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('pelanggan_dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bolt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PLN Customer</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $active_page == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Informasi Saya
    </div>

    <!-- Nav Item - Profile -->
    <li class="nav-item <?= $active_page == 'profile' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/profile') ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Profil Saya</span>
        </a>
    </li>

    <!-- Nav Item - Bills -->
    <li class="nav-item <?= $active_page == 'bills' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/bills') ?>">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Tagihan Saya</span>
        </a>
    </li>

    <!-- Nav Item - Usage -->
    <li class="nav-item <?= $active_page == 'usage' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/usage') ?>">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Penggunaan Listrik</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Layanan
    </div>

    <!-- Nav Item - Payment History -->
    <li class="nav-item <?= $active_page == 'payment_history' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/payment_history') ?>">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Riwayat Pembayaran</span>
        </a>
    </li>

    <!-- Nav Item - Usage Chart -->
    <li class="nav-item <?= $active_page == 'usage_chart' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/usage_chart') ?>">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Grafik Penggunaan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Bantuan
    </div>

    <!-- Nav Item - Help -->
    <li class="nav-item <?= $active_page == 'help' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/help') ?>">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>Bantuan</span>
        </a>
    </li>

    <!-- Nav Item - Contact -->
    <li class="nav-item <?= $active_page == 'contact' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan_dashboard/contact') ?>">
            <i class="fas fa-fw fa-phone"></i>
            <span>Kontak Kami</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar --> 