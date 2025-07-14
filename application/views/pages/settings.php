<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Settings</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Tarif Settings Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tarif Settings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tarif_count ?> Tarif</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('settings/tarif') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-cog"></i> Kelola Tarif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Level Settings Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Level Settings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $level_count ?> Level</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('settings/level') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-cog"></i> Kelola Level
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Settings Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                System Settings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Konfigurasi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('settings/system') ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-cog"></i> Pengaturan Sistem
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Settings Information -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Settings</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-dollar-sign fa-3x text-primary mb-3"></i>
                                <h5>Tarif Settings</h5>
                                <p class="text-muted">Kelola tarif listrik berdasarkan daya yang digunakan pelanggan.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-users fa-3x text-success mb-3"></i>
                                <h5>Level Settings</h5>
                                <p class="text-muted">Kelola level akses user untuk sistem administrasi.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-cogs fa-3x text-info mb-3"></i>
                                <h5>System Settings</h5>
                                <p class="text-muted">Konfigurasi umum sistem dan informasi perusahaan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid --> 