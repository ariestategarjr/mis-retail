<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Form Tambah Produk</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
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
            </div>
        </div>
        <div class="form-group row">
            <label for="nameProduct" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="nameProduct" name="nameProduct">
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
                <button type="submit" class="btn btn-success">Simpan</button>
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
        listCategories();
        listUnits();

        $('.add-category-button').click(function() {
            $.ajax({
                type: "post",
                url: "<?= site_url('category/addModalCategory'); ?>",
                dataType: "json",
                data: {
                    'reload': false
                },
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
    });
</script>
<?= $this->endSection(); ?>