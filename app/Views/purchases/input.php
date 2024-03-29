<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Input Pembelian</h3>
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
                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="nofaktur" id="nofaktur" readonly value="<?= $faktur ?>">
                </div>
            </div>
            <div class="col-md-2">
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
            <div class="col-md-2">
                <div class="form-group">
                    <label for="tanggal">Jenis Bayar</label>
                    <!-- <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal"> -->
                    <select name="jenisbayar" id="jenisbayar" class="form-control form-control-sm">
                        <?php foreach ($jenisbayar as $value) : ?>
                            <option value="<?= $value ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
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
                    <label for="kodebarcode">Kode Produk / Nama Produk</label>
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
                    <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1" readonly>
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
            <div class="col-md-12 dataDetailPembelian">
                <!-- berisi Tabel Pembelian -->
            </div>
        </div>
    </div>
</div>

<div class="modal-container" style="display: none;"></div>
<div class="modal-container-payment" style="display: none;"></div>

<script>
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
        } else {
            const uniqueId = 'BL' + Math.random().toString(8).substring(2, 5);
            $.ajax({
                type: "post",
                url: "<?= site_url('purchase/saveTemp') ?>",
                data: {
                    id: uniqueId,
                    codeBarcode: code,
                    nameProduct: $('#namaproduk').val(),
                    amount: $('#jumlah').val(),
                    noFaktur: $('#nofaktur').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.data == 'many') {
                        $.ajax({
                            type: "post",
                            url: "<?= site_url('purchase/getModalProduct') ?>",
                            data: {
                                keyword: code
                            },
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

                    if (response.success) {
                        displayPurchaseDetail();
                        reset();
                    }

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: response.error,
                        });
                        displayPurchaseDetail();
                        reset();
                    }
                },
                error: function(xhr, thrownError) {
                    alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                }
            });
        }
    }

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

    function displayPurchaseDetail() {
        $.ajax({
            type: "post",
            url: "<?= site_url('purchase/displayPurchaseDetail') ?>",
            data: {
                fakturcode: $('#nofaktur').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailPembelian').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailPembelian').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function calculateTotalPay() {
        $.ajax({
            type: "post",
            url: "<?= site_url('purchase/calculateTotalPay') ?>",
            data: {
                fakturcode: $('#nofaktur').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#totalbayar').val(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function reset() {
        $('#kodebarcode').val('');
        $('#namaproduk').val('');
        $('#jumlah').val('1');
        $('#kodebarcode').focus();

        calculateTotalPay()
    }

    function saveTransaction() {
        let fakturcode = $('#nofaktur').val();

        $.ajax({
            type: "post",
            url: "<?= site_url('purchase/saveTransaction') ?>",
            data: {
                fakturcode: fakturcode,
                datefaktur: $('#tanggal').val(),
                suppliercode: $('#kopen').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modal-container-payment').html(response.data).show();
                    $('#getModalPayment').on('shown.bs.modal', function(event) {
                        $('#amountmoney').focus();
                    });
                    $('#getModalPayment').modal('show');
                }
                if (response.error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error',
                        text: response.error,
                    })
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function deleteTransaction() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin',
            html: `<h4 style="display: inline;">menghapus <strong style="color: #d33;">transaksi</strong> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('purchase/deleteTransaction') ?>",
                    data: {
                        fakturcode: $('#nofaktur').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        $('body').addClass('sidebar-collapse');

        $('#kodebarcode').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                checkCodeBarcode();
            }
        });

        $('#search-supplier').click(function(e) {
            e.preventDefault();
            getModalSupplier();
        });

        $('#btnSimpanTransaksi').click(function(e) {
            e.preventDefault();

            saveTransaction();
        });

        $('#btnHapusTransaksi').click(function(e) {
            e.preventDefault();

            deleteTransaction();
        });

        displayPurchaseDetail();
        calculateTotalPay();
    });
</script>

<?= $this->endSection(); ?>