<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Form Tambah Produk</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<!-- AutoNumeric Plugin -->
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>

<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-secondary" onclick="window.location='<?= site_url('product/index') ?>'">
            <i class="fas fa-backward"></i> Kembali
        </button>
    </div>
    <div class="card-body">
        <?php
        $action = '';
        $attributes = ['id' => 'addFormProduct'];
        ?>
        <?= form_open_multipart($action, $attributes) ?>
        <div class="form-group row">
            <label for="codeBarcode" class="col-sm-2 col-form-label">Kode Barcode</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="codeBarcode" name="codeBarcode" autofocus>
                <div id="errorCodeBarcode" class="invalid-feedback" style="display: none;">
                    Please provide a valid city.
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="nameProduct" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="nameProduct" name="nameProduct">
                <div id="errorNameProduct" class="invalid-feedback" style="display: none;">
                    Please provide a valid city.
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="stockProduct" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="stockProduct" name="stockProduct" value="0">
            </div>
        </div>
        <div class="form-group row">
            <label for="unitProduct" class="col-sm-2 col-form-label">Satuan</label>
            <div class="col-sm-4">
                <select class="form-control" id="unitProduct">
                    <!-- <option>Default select</option> -->
                </select>
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-primary add-unit-button"><i class="fas fa-plus-circle"></i></button>
            </div>
        </div>
        <div class="form-group row">
            <label for="categoryProduct" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-4">
                <select class="form-control" id="categoryProduct">
                    <!-- <option>Default select</option> -->
                </select>
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-primary add-category-button"><i class="fas fa-plus-circle"></i></button>
            </div>
        </div>
        <div class="form-group row">
            <label for="purchasePrice" class="col-sm-2 col-form-label">Harga Beli (Rp.)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="purchasePrice" name="purchasePrice" style="text-align: right;">
            </div>
        </div>
        <div class="form-group row">
            <label for="sellingPrice" class="col-sm-2 col-form-label">Harga Jual (Rp.)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="sellingPrice" name="sellingPrice" style="text-align: right;">
            </div>
        </div>
        <div class="form-group row">
            <label for="imageUpload" class="col-sm-2 col-form-label">Gambar (<i>Jika ada</i>)</label>
            <div class="col-sm-4">
                <input type="file" class="form-control" id="imageUpload" name="imageUpload">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-success add-product-button">Simpan</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>

    <div class="modal-container" style="display: none;"></div>

</div>

<script>
    function listCategories() {
        $.ajax({
            url: "<?= site_url('product/getAllCategories'); ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#categoryProduct').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function listUnits() {
        $.ajax({
            url: "<?= site_url('product/getAllUnits') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#unitProduct').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    $(document).ready(function() {
        $('#purchasePrice').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '2',
            aSign: 'Rp. '
        });

        $('#sellingPrice').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
            aSign: 'Rp. '
        });

        $('#stockProduct').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        listCategories();
        listUnits();

        $('.add-category-button').click(function() {
            $.ajax({
                type: "post",
                url: "<?= site_url('category/addModalCategory'); ?>",
                data: {
                    'reload': false
                },
                dataType: "json",
                success: function(response) {
                    const uniqueId = 'KAT' + Math.random().toString(8).substring(2, 5);

                    if (response.data) {
                        $('.modal-container').html(response.data).show();
                        $('#addModalCategory').on('shown.bs.modal', function(event) {
                            $('#nameCategory').focus();
                        });
                        $('#addModalCategory').modal('show');
                        $('#idCategory').val(uniqueId);
                    }
                },
                error: function(xhr, thrownError) {
                    alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                }
            });
        });

        $('.add-unit-button').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "<?= site_url('unit/addModalUnit') ?>",
                data: {
                    'reload': false
                },
                dataType: "json",
                success: function(response) {
                    const uniqueId = 'SAT' + Math.random().toString(8).substring(2, 5);

                    if (response.data) {
                        $('.modal-container').html(response.data).show();
                        $('#addModalUnit').on('shown.bs.modal', function(event) {
                            $('#nameUnit').focus();
                        });
                        $('#addModalUnit').modal('show');
                        $('#idUnit').val(uniqueId);
                    }
                },
                error: function(xhr, thrownError) {
                    alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                }
            });
        });

        $('.add-product-button').click(function(e) {
            e.preventDefault();

            let form = $('#addFormProduct')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('product/addProduct') ?>",
                data: data,
                dataType: "json",
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.add-product-button').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.add-product-button').prop('disabled', true);
                },
                complete: function() {
                    $('.add-product-button').html('Simpan');
                    $('.add-product-button').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let dataError = response.error;

                        if (dataError.errorCodeBarcode) {
                            $('#errorCodeBarcode').html(dataError.errorCodeBarcode).show();
                            $('#codeBarcode').addClass('is-invalid');
                        } else {
                            $('#errorCodeBarcode').fadeOut();
                            $('#codeBarcode').removeClass('is-invalid');
                            $('#codeBarcode').addClass('is-valid');
                        }

                        if (dataError.errorNameProduct) {
                            $('#errorNameProduct').html(dataError.errorNameProduct).show();
                            $('#nameProduct').addClass('is-invalid');
                        } else {
                            $('#errorNameProduct').fadeOut();
                            $('#nameProduct').removeClass('is-invalid');
                            $('#nameProduct').addClass('is-valid');
                        }

                    }
                },
                error: function(xhr, thrownError) {
                    alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                }
            });


        });
    });
</script>
<?= $this->endSection(); ?>