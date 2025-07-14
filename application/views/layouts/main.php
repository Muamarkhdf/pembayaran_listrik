<?php
// Set default values
$page_title = $page_title ?? 'Dashboard';
$active_page = $active_page ?? 'dashboard';
$content = $content ?? 'application/views/pages/dashboard.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - Sistem Pembayaran Listrik</title>
    
    <!-- Bootstrap 4.6.0 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- Font Awesome 5.15.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts Nunito -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- SB Admin 2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css">
    
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Custom CSS aktif -->
    
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include 'application/views/layouts/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include 'application/views/layouts/topbar.php'; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <!-- <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1> -->
                    <?php if (isset($page_breadcrumb)): ?>
                    <ol class="breadcrumb">
                        <?php foreach ($page_breadcrumb as $breadcrumb): ?>
                        <li class="breadcrumb-item <?= $breadcrumb['active'] ? 'active' : '' ?>">
                            <?php if (!$breadcrumb['active']): ?>
                            <a href="<?= $breadcrumb['url'] ?>"><?= $breadcrumb['text'] ?></a>
                            <?php else: ?>
                            <?= $breadcrumb['text'] ?>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                    <?php endif; ?>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <!-- Content akan di-include di sini -->
                    <?php if (isset($content)): ?>
                        <?php include $content; ?>
                    <?php endif; ?>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container-fluid my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Sistem Pembayaran Listrik <?= date('Y') ?></span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 3.6.0 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4.6.0 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- jQuery Easing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- SB Admin 2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>
<!-- Chart.js (pastikan sebelum script dashboard) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom Scripts -->
<script>
// DataTables Initialization
$(document).ready(function() {
    // Initialize DataTables with error handling
    try {
        $('#dataTable').each(function() {
            var table = $(this);
            
            // Check if table already has DataTable instance
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }
            
            // Check if table has data
            var rowCount = table.find('tbody tr').length;
            if (rowCount === 0) {
                console.log('Table has no data rows, skipping DataTable initialization');
                table.addClass('table-striped table-hover');
                return;
            }
            
            // Check if first row has the "no data" message
            var firstRow = table.find('tbody tr:first');
            if (firstRow.find('td').length === 1 && firstRow.find('td').text().includes('Tidak ada data')) {
                console.log('Table has no data message, skipping DataTable initialization');
                table.addClass('table-striped table-hover');
                return;
            }
            
            // Check if table has proper structure
            var headerCount = table.find('thead th').length;
            var firstRowCells = table.find('tbody tr:first td').length;
            
            if (headerCount !== firstRowCells) {
                console.error('Column count mismatch: headers=' + headerCount + ', cells=' + firstRowCells);
                table.addClass('table-striped table-hover');
                return;
            }
            
            // Initialize DataTable
            table.DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: [
                    {
                        targets: -1, // Last column (actions)
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[0, 'asc']], // Sort by first column (No) ascending
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                drawCallback: function(settings) {
                    // Additional callback for debugging
                    console.log('DataTable initialized successfully');
                }
            });
        });
    } catch (error) {
        console.error('DataTables initialization error:', error);
        // Fallback: show table without DataTables
        $('#dataTable').addClass('table-striped table-hover');
        console.log('Using fallback table styling');
    }
    
    // Alternative initialization for tables without DataTables
    $('.table:not(.datatable)').addClass('table-striped table-hover');
});

// SweetAlert2 Functions
function showSuccess(message) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message
    });
}

function showConfirm(message, callback) {
    Swal.fire({
        title: 'Konfirmasi',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// Delete Confirmation
function confirmDelete(url, message = 'Data akan dihapus permanen!') {
    showConfirm(message, function() {
        window.location.href = url;
    });
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form.checkValidity()) {
        form.reportValidity();
        return false;
    }
    return true;
}

// Auto-hide alerts
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});
</script>

</body>
</html> 