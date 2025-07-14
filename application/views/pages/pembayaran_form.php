<?php
$page_title = 'Tambah Pembayaran';
$active_page = 'pembayaran';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <?= isset($pembayaran) ? 'Edit Pembayaran' : 'Tambah Pembayaran' ?>
        </h1>
        <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
    </a>
    </div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-credit-card mr-2"></i>
                <?= isset($pembayaran) ? 'Edit Data Pembayaran' : 'Form Pembayaran Baru' ?>
                </h6>
            </div>
            <div class="card-body">
            <?php if (isset($pembayaran)): ?>
                <!-- Edit Form -->
                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pelanggan">Nama Pelanggan</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($pembayaran['nama_pelanggan']) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_kwh">Nomor KWH</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($pembayaran['nomor_kwh']) ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulan">Bulan/Tahun</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($pembayaran['bulan']) ?>/<?= htmlspecialchars($pembayaran['tahun']) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_meter">Jumlah Meter</label>
                                <input type="text" class="form-control" value="<?= number_format($pembayaran['jumlah_meter']) ?> kWh" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="biaya_admin">Biaya Admin <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="biaya_admin" value="<?= $pembayaran['biaya_admin'] ?>" required>
                                <small class="form-text text-muted">Biaya administrasi pembayaran</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_bayar">Total Bayar <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="total_bayar" value="<?= $pembayaran['total_bayar'] ?>" required>
                                <small class="form-text text-muted">Total yang harus dibayar</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Pembayaran
                        </button>
                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <!-- Add Form -->
                <?php if (empty($tagihan)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">Semua tagihan sudah dibayar!</h5>
                        <p class="text-muted">Tidak ada tagihan yang belum dibayar saat ini.</p>
                        <a href="<?= base_url('tagihan') ?>" class="btn btn-primary">
                            <i class="fas fa-list"></i> Lihat Data Tagihan
                        </a>
                    </div>
                <?php else: ?>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="id_tagihan">Pilih Tagihan <span class="text-danger">*</span></label>
                            <select class="form-control" name="id_tagihan" id="id_tagihan" required>
                                <option value="">-- Pilih Tagihan --</option>
                                <?php foreach ($tagihan as $t): ?>
                                    <option value="<?= $t['id_tagihan'] ?>"
                                        data-tarif="<?= $t['tarifperkwh'] ?>"
                                            data-meter="<?= $t['jumlah_meter'] ?>"
                                            data-admin="10000">
                                        <?= htmlspecialchars($t['nama_pelanggan']) ?> - 
                                        <?= htmlspecialchars($t['nomor_kwh']) ?> - 
                                        <?= htmlspecialchars($t['bulan']) ?>/<?= htmlspecialchars($t['tahun']) ?> 
                                        (<?= number_format($t['total_bayar'], 0, ',', '.') ?>)
                                    </option>
                                <?php endforeach; ?>
                        </select>
                            <small class="form-text text-muted">Pilih tagihan yang akan dibayar</small>
                    </div>
                    
                    <div id="payment-details" style="display: none;">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-calculator mr-2"></i>Detail Pembayaran</h6>
                                </div>
                                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                                <label>Nama Pelanggan</label>
                                                <input type="text" class="form-control" id="nama_pelanggan" readonly>
                                            </div>
                                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                                <label>Nomor KWH</label>
                                                <input type="text" class="form-control" id="nomor_kwh" readonly>
                                    </div>
                                </div>
                            </div>
                            
                                    <div class="row">
                                        <div class="col-md-4">
                                <div class="form-group">
                                                <label>Bulan/Tahun</label>
                                                <input type="text" class="form-control" id="periode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jumlah Meter</label>
                                                <input type="text" class="form-control" id="jumlah_meter" readonly>
                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Daya</label>
                                                <input type="text" class="form-control" id="daya" readonly>
                                    </div>
                                </div>
                            </div>
                            
                                    <div class="row">
                                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tarif per kWh</label>
                                                <input type="text" class="form-control" id="tarif_perkwh" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Total Tagihan</label>
                                                <input type="text" class="form-control" id="total_tagihan" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Biaya Admin</label>
                                                <input type="text" class="form-control" id="biaya_admin" readonly>
                                    </div>
                                </div>
                            </div>
                            
                                    <div class="row">
                                        <div class="col-md-12">
                                <div class="form-group">
                                                <label class="h5 text-primary">Total Bayar</label>
                                                <input type="text" class="form-control form-control-lg font-weight-bold text-primary" id="total_bayar" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary" id="btn-submit">
                                <i class="fas fa-credit-card"></i> Proses Pembayaran
                                    </button>
                                    <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#id_tagihan').change(function() {
        var selectedOption = $(this).find('option:selected');
        var tarif = parseFloat(selectedOption.data('tarif')) || 0;
        var meter = parseFloat(selectedOption.data('meter')) || 0;
        var admin = parseFloat(selectedOption.data('admin')) || 0;
    
        if (selectedOption.val()) {
            // Calculate payment details
            var totalTagihan = tarif * meter;
            var totalBayar = totalTagihan + admin;
        
        // Update form fields
            $('#nama_pelanggan').val(selectedOption.text().split(' - ')[0]);
            $('#nomor_kwh').val(selectedOption.text().split(' - ')[1]);
            $('#periode').val(selectedOption.text().split(' - ')[2]);
            $('#jumlah_meter').val(meter.toLocaleString() + ' kWh');
            $('#daya').val('900 VA'); // Default, should be dynamic
            $('#tarif_perkwh').val('Rp ' + tarif.toLocaleString());
            $('#total_tagihan').val('Rp ' + totalTagihan.toLocaleString());
            $('#biaya_admin').val('Rp ' + admin.toLocaleString());
            $('#total_bayar').val('Rp ' + totalBayar.toLocaleString());
            
            // Show payment details
            $('#payment-details').show();
            $('#btn-submit').prop('disabled', false);
    } else {
        // Hide payment details
            $('#payment-details').hide();
            $('#btn-submit').prop('disabled', true);
    }
    });
});
</script> 