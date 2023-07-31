<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Form Edit Produk</h3>
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
        $attributes = ['id' => 'editFormProduct'];
        ?>
        <?= form_open_multipart($action, $attributes) ?>
        <div class="form-group row">
            <label for="codeBarcode" class="col-sm-2 col-form-label">Kode Barcode</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="codeBarcode" name="codeBarcode" value="<?= $codeBarcode ?>" readonly>
                <div id="errorCodeBarcode" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid data. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="nameProduct" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="nameProduct" name="nameProduct" value="<?= $nameProduct ?>" autofocus>
                <div id="errorNameProduct" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="stockProduct" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="stockProduct" name="stockProduct" value="<?= $stockProduct ?>">
                <div id="errorStockProduct" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid data. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="unitProduct" class="col-sm-2 col-form-label">Satuan</label>
            <div class="col-sm-4">
                <select class="form-control" id="unitProduct" name="unitProduct">
                    <!-- <option>Default select</option> -->
                    <?php
                    foreach ($unitData as $data) :
                        if ($data['satid'] == $unitProduct) :
                            echo "<option value=\"$data[satid]\" selected>$data[satnama]</option>";
                        else :
                            echo "<option value=\"$data[satid]\">$data[satnama]</option>";
                        endif;
                    endforeach;
                    ?>
                </select>
                <div id="errorUnitProduct" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid data. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="categoryProduct" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-4">
                <select class="form-control" id="categoryProduct" name="categoryProduct">
                    <!-- <option>Default select</option> -->
                    <?php
                    foreach ($categoryData as $data) :
                        if ($data['katid'] == $categoryProduct) :
                            echo "<option value=\"$data[katid]\" selected>$data[katnama]</option>";
                        else :
                            echo "<option value=\"$data[katid]\">$data[katnama]</option>";
                        endif;
                    endforeach;
                    ?>
                </select>
                <div id="errorCategoryProduct" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid data. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="purchasePrice" class="col-sm-2 col-form-label">Harga Beli (Rp.)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="purchasePrice" name="purchasePrice" value="<?= $purchasePrice ?>" style="text-align: right;">
                <div id="errorPurchasePrice" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid data. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="sellingPrice" class="col-sm-2 col-form-label">Harga Jual (Rp.)</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="sellingPrice" name="sellingPrice" value="<?= $sellingPrice ?>" style="text-align: right;">
                <div id="errorSellingPrice" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid data. -->
                </div>
            </div>
        </div>
        <!-- Upload Gambar -->
        <div class="form-group row" hidden>
            <label for="imageUpload" class="col-sm-2 col-form-label">Gambar Produk</label>
            <div class="col-sm-4">
                <img src="<?= base_url($imageUpload) ?>" style="width: 100%;" alt="gambar-produk">
            </div>
        </div>
        <div class="form-group row" hidden>
            <label for="imageUpload" class="col-sm-2 col-form-label">Ubah Gambar Produk</label>
            <div class="col-sm-4">
                <input type="file" class="form-control" id="imageUpload" name="imageUpload">
                <div id="errorImageUpload" class="invalid-feedback" style="display: none;">

                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-success save-button">Simpan</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>

    <div class="modal-container" style="display: none;"></div>

</div>

<script>
    $(document).ready(function() {
        $('#purchasePrice').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('#sellingPrice').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('#stockProduct').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('.save-button').click(function(e) {
            e.preventDefault();

            let form = $('#editFormProduct')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('product/editProduct') ?>",
                data: data,
                dataType: "json",
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.save-button').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.save-button').prop('disabled', true);
                },
                complete: function() {
                    $('.save-button').html('Simpan');
                    $('.save-button').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let dataError = response.error;
                        // console.log(dataError);

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

                        if (dataError.errorStockProduct) {
                            $('#errorStockProduct').html(dataError.errorStockProduct).show();
                            $('#stockProduct').addClass('is-invalid');
                        } else {
                            $('#errorStockProduct').fadeOut();
                            $('#stockProduct').removeClass('is-invalid');
                            $('#stockProduct').addClass('is-valid');
                        }

                        if (dataError.errorUnitProduct) {
                            $('#errorUnitProduct').html(dataError.errorUnitProduct).show();
                            $('#unitProduct').addClass('is-invalid');
                        } else {
                            $('#errorUnitProduct').fadeOut();
                            $('#unitProduct').removeClass('is-invalid');
                            $('#unitProduct').addClass('is-valid');
                        }

                        if (dataError.errorCategoryProduct) {
                            $('#errorCategoryProduct').html(dataError.errorCategoryProduct).show();
                            $('#categoryProduct').addClass('is-invalid');
                        } else {
                            $('#errorCategoryProduct').fadeOut();
                            $('#categoryProduct').removeClass('is-invalid');
                            $('#categoryProduct').addClass('is-valid');
                        }

                        if (dataError.errorPurchasePrice) {
                            $('#errorPurchasePrice').html(dataError.errorPurchasePrice).show();
                            $('#purchasePrice').addClass('is-invalid');
                        } else {
                            $('#errorPurchasePrice').fadeOut();
                            $('#purchasePrice').removeClass('is-invalid');
                            $('#purchasePrice').addClass('is-valid');
                        }

                        if (dataError.errorSellingPrice) {
                            $('#errorSellingPrice').html(dataError.errorSellingPrice).show();
                            $('#sellingPrice').addClass('is-invalid');
                        } else {
                            $('#errorSellingPrice').fadeOut();
                            $('#sellingPrice').removeClass('is-invalid');
                            $('#sellingPrice').addClass('is-valid');
                        }

                        if (dataError.errorImageUpload) {
                            $('#errorImageUpload').html(dataError.errorImageUpload).show();
                            $('#imageUpload').addClass('is-invalid');
                        } else {
                            $('#errorImageUpload').fadeOut();
                            $('#imageUpload').removeClass('is-invalid');
                            $('#imageUpload').addClass('is-valid');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            html: response.success
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "/product/index";
                            }
                        })
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