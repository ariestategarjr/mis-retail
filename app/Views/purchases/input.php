<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Input Kasir</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-warning btn-sm" onclick="window.location='<?= site_url('sale/index') ?>'">&laquo; Kembali</button>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nofaktur">Faktur</label>
                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="nofaktur" id="nofaktur" readonly value="<?= $kodebarcode ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="napel">Penyuplai</label>
                    <div class="input-group mb-3">
                        <input type="text" value="-" class="form-control form-control-sm" name="napen" id="napen" readonly>
                        <input type="hidden" name="kopen" id="kopen" value="0">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button" id="search-supplier">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Aksi</label>
                    <div class="input-group">
                        <button class="btn btn-danger btn-sm" type="button" id="btnHapusTransaksi">
                            <i class="fa fa-trash-alt"></i>
                        </button>&nbsp;
                        <button class="btn btn-success" type="button" id="btnSimpanTransaksi">
                            <i class="fa fa-save"></i>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="kodebarcode">Kode Produk</label>
                    <input type="text" class="form-control form-control-sm" name="kodebarcode" id="kodebarcode" autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="namaproduk">Nama Produk</label>
                    <input type="text" class="form-control form-control-sm" name="namaproduk" id="namaproduk" readonly style="font-size: 16pt; font-weight: 8bold;">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Jumlah</label>
                    <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Total Bayar</label>
                    <input type="text" class="form-control form-control-lg" name="totalbayar" id="totalbayar" style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 dataDetailPenjualan">
                <!-- berisi Tabel Penjualan -->
            </div>
        </div>
    </div>
</div>

<div class="modal-container" style="display: none;"></div>
<div class="modal-container-payment" style="display: none;"></div>

<script>
    function getModalSupplier() {
        $.ajax({
            url: "<?= site_url('purchase/getModalSupplier') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modal-container').html(response.data).show();

                    $('#getModalSupplier').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.state} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function checkCodeBarcode() {
        let code = $('#kodebarcode').val();

        if (code.length == 0) {
            $.ajax({
                url: "<?= site_url('purchase/getModalProduct') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.modal) {
                        $('.modal-container').html(response.modal).show();
                        $('#getModalProduct').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                }
            });
        }
    }

    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');

        $('#search-supplier').click(function(e) {
            e.preventDefault();
            getModalSupplier();
        });


        $('#kodebarcode').keydown(function(e) {
            if (e.keyCode === 13) {
                checkCodeBarcode();
            }
        });
    });
</script>

<?= $this->endSection(); ?>