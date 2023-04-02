<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Form Tambah Pelanggan</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<!-- AutoNumeric Plugin -->
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>

<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-secondary" onclick="window.location='<?= site_url('supplier/index') ?>'">
            <i class="fas fa-backward"></i> Kembali
        </button>
    </div>
    <div class="card-body">
        <?php
        $action = '';
        $attributes = ['id' => 'addFormSupplier'];
        ?>
        <?= form_open_multipart($action, $attributes) ?>
        <div class="form-group row">
            <label for="idSupplier" class="col-sm-2 col-form-label">Id Penyuplai</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="idSupplier" name="idSupplier">
                <div id="errorIdSupplier" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="nameSupplier" class="col-sm-2 col-form-label">Nama Penyuplai</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nameSupplier" name="nameSupplier" autofocus>
                <div id="errorNameSupplier" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="addressSupplier" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="addressSupplier" name="addressSupplier">
                <div id="errorAddressSupplier" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="telpSupplier" class="col-sm-2 col-form-label">Telepon</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="telpSupplier" name="telpSupplier">
                <div id="errorTelpSupplier" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
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
        const uniqueId = 'SUP' + Math.random().toString(8).substring(2, 5);
        $('#idSupplier').val(uniqueId);

        $('.save-button').click(function(e) {
            e.preventDefault();

            let form = $('#addFormSupplier')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('supplier/addSupplier') ?>",
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

                        if (dataError.errorIdSupplier) {
                            $('#errorIdSupplier').html(dataError.errorIdSupplier).show();
                            $('#idSupplier').addClass('is-invalid');
                        } else {
                            $('#errorIdSupplier').fadeOut();
                            $('#idSupplier').removeClass('is-invalid');
                            $('#idSupplier').addClass('is-valid');
                        }
                        if (dataError.errorNameSupplier) {
                            $('#errorNameSupplier').html(dataError.errorNameSupplier).show();
                            $('#nameSupplier').addClass('is-invalid');
                        } else {
                            $('#errorNameSupplier').fadeOut();
                            $('#nameSupplier').removeClass('is-invalid');
                            $('#nameSupplier').addClass('is-valid');
                        }
                        if (dataError.errorAddressSupplier) {
                            $('#errorAddressSupplier').html(dataError.errorAddressSupplier).show();
                            $('#addressSupplier').addClass('is-invalid');
                        } else {
                            $('#errorAddressSupplier').fadeOut();
                            $('#addressSupplier').removeClass('is-invalid');
                            $('#addressSupplier').addClass('is-valid');
                        }
                        if (dataError.errorTelpSupplier) {
                            $('#errorTelpSupplier').html(dataError.errorTelpSupplier).show();
                            $('#telpSupplier').addClass('is-invalid');
                        } else {
                            $('#errorTelpSupplier').fadeOut();
                            $('#telpSupplier').removeClass('is-invalid');
                            $('#telpSupplier').addClass('is-valid');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            html: response.success
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
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