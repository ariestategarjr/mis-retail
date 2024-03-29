<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Input Penjualan</h3>
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
                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;" name="nofaktur" id="nofaktur" readonly value="<?= $nofaktur; ?>">
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
                    <label for="napel">Pelanggan</label>
                    <div class="input-group mb-3">
                        <input type="text" value="-" class="form-control form-control-sm" name="napel" id="napel" readonly>
                        <input type="hidden" name="kopel" id="kopel" value="0">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button" id="search-customer">
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
            <div class="col-md-12 dataDetailPenjualan">
                <!-- berisi Tabel Penjualan -->
            </div>
        </div>
    </div>
</div>

<div class="modal-container" style="display: none;"></div>
<div class="modal-container-payment" style="display: none;"></div>

<!-- <iframe id="printing-frame" name="print_frame" src="about:blank" style="display: none;"></iframe> -->


<script>
    function checkCodeBarcode() {
        let code = $('#kodebarcode').val();

        if (code.length == 0) {
            $.ajax({
                url: "<?= site_url('sale/getModalProduct') ?>",
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
            const uniqueId = 'JL' + Math.random().toString(8).substring(2, 5);
            $.ajax({
                type: "post",
                url: "<?= site_url('sale/saveTemp') ?>",
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
                            url: "<?= site_url('sale/getModalProduct') ?>",
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
                        displaySaleDetail();
                        reset();
                    }

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: response.error,
                        });
                        displaySaleDetail();
                        reset();
                    }
                },
                error: function(xhr, thrownError) {
                    // alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                    alert("Jumlah barang belum diisi.");
                }
            });
        }
    }

    function getModalCustomer() {
        $.ajax({
            url: "<?= site_url('sale/getModalCustomer') ?>",
            datatype: "json",
            success: function(response) {
                if (JSON.parse(response).data) {
                    $('.modal-container').html(JSON.parse(response).data).show();

                    $('#getModalCustomer').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.state} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function displaySaleDetail() {
        $.ajax({
            type: "post",
            url: "<?= site_url('sale/displaySaleDetail') ?>",
            data: {
                fakturcode: $('#nofaktur').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailPenjualan').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.dataDetailPenjualan').html(response.data);
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
            url: "<?= site_url('sale/calculateTotalPay') ?>",
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
            url: "<?= site_url('sale/processTransaction') ?>",
            data: {
                fakturcode: fakturcode,
                datefaktur: $('#tanggal').val(),
                customercode: $('#kopel').val()
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
                    url: "<?= site_url('sale/deleteTransaction') ?>",
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

        $('#search-customer').click(function(e) {
            e.preventDefault();
            getModalCustomer();
        });

        $('#jumlah').keydown(function(e) {
            if (e.keyCode == 27) {
                e.preventDefault();
                $('#kodebarcode').focus();
            }
        });

        $(this).keydown(function(e) {
            if (e.keyCode == 27) {
                e.preventDefault();
                $('#kodebarcode').focus();
            }

            if (e.keyCode == 115) {
                e.preventDefault();
                deleteTransaction();
            }

            if (e.keyCode == 119) {
                e.preventDefault();
                saveTransaction();
            }
        });

        $('#btnSimpanTransaksi').click(function(e) {
            e.preventDefault();

            saveTransaction();
        });

        $('#btnHapusTransaksi').click(function(e) {
            e.preventDefault();

            deleteTransaction();
        });

        displaySaleDetail();
        calculateTotalPay();
    });
</script>
<?= $this->endSection(); ?>