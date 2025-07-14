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
<!-- Chart.js 2.9.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom Scripts -->
<script>
// DataTables Initialization
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
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