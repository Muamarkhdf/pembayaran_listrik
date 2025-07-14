<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-bolt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PLN Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $active_page == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Pelanggan -->
    <li class="nav-item <?= $active_page == 'pelanggan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pelanggan') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pelanggan</span>
        </a>
    </li>

    <!-- Nav Item - Tarif -->
    <li class="nav-item <?= $active_page == 'tarif' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('tarif') ?>">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Data Tarif</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    <!-- Nav Item - Penggunaan -->
    <li class="nav-item <?= $active_page == 'penggunaan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('penggunaan') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Data Penggunaan</span>
        </a>
    </li>

    <!-- Nav Item - Tagihan -->
    <li class="nav-item <?= $active_page == 'tagihan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('tagihan') ?>">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Data Tagihan</span>
        </a>
    </li>

    <!-- Nav Item - Pembayaran -->
    <li class="nav-item <?= $active_page == 'pembayaran' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('pembayaran') ?>">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Laporan -->
    <li class="nav-item <?= $active_page == 'laporan' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse <?= $active_page == 'laporan' ? 'show' : '' ?>" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('laporan') ?>">
                    <i class="fas fa-fw fa-chart-bar mr-2"></i>Laporan Umum
                </a>
                <a class="collapse-item" href="<?= base_url('pembayaran/report') ?>">
                    <i class="fas fa-fw fa-receipt mr-2"></i>Laporan Pembayaran
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sistem
    </div>

    <!-- Nav Item - User Management -->
    <li class="nav-item <?= $active_page == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user') ?>">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User Management</span>
        </a>
    </li>

    <!-- Nav Item - Settings -->
    <li class="nav-item <?= $active_page == 'settings' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('settings') ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
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