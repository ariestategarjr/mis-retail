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
        <button type="button" class="btn btn-secondary" onclick="window.location='<?= site_url('customer/index') ?>'">
            <i class="fas fa-backward"></i> Kembali
        </button>
    </div>
    <div class="card-body">
        <?php
        $action = '';
        $attributes = ['id' => 'addFormCustomer'];
        ?>
        <?= form_open_multipart($action, $attributes) ?>
        <div class="form-group row">
            <label for="idCustomer" class="col-sm-2 col-form-label">Id Pelanggan</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="idCustomer" name="idCustomer" readonly>
                <div id="errorIdCustomer" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="nameCustomer" class="col-sm-2 col-form-label">Nama Pelanggan</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nameCustomer" name="nameCustomer" autofocus>
                <div id="errorNameCustomer" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="addressCustomer" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="addressCustomer" name="addressCustomer">
                <div id="errorAddressCustomer" class="invalid-feedback" style="display: none;">
                    <!-- Please provide a valid city. -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="telpCustomer" class="col-sm-2 col-form-label">Telepon</label>
            <div class="col-sm-4">
                <input type="tel" class="form-control" id="telpCustomer" name="telpCustomer">
                <div id="errorTelpCustomer" class="invalid-feedback" style="display: none;">
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
        const uniqueId = 'PEL' + Math.random().toString(8).substring(2, 5);
        $('#idCustomer').val(uniqueId);

        $('.save-button').click(function(e) {
            e.preventDefault();

            let form = $('#addFormCustomer')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('customer/addCustomer') ?>",
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

                        if (dataError.errorIdCustomer) {
                            $('#errorIdCustomer').html(dataError.errorIdCustomer).show();
                            $('#idCustomer').addClass('is-invalid');
                        } else {
                            $('#errorIdCustomer').fadeOut();
                            $('#idCustomer').removeClass('is-invalid');
                            $('#idCustomer').addClass('is-valid');
                        }
                        if (dataError.errorNameCustomer) {
                            $('#errorNameCustomer').html(dataError.errorNameCustomer).show();
                            $('#nameCustomer').addClass('is-invalid');
                        } else {
                            $('#errorNameCustomer').fadeOut();
                            $('#nameCustomer').removeClass('is-invalid');
                            $('#nameCustomer').addClass('is-valid');
                        }
                        if (dataError.errorAddressCustomer) {
                            $('#errorAddressCustomer').html(dataError.errorAddressCustomer).show();
                            $('#addressCustomer').addClass('is-invalid');
                        } else {
                            $('#errorAddressCustomer').fadeOut();
                            $('#addressCustomer').removeClass('is-invalid');
                            $('#addressCustomer').addClass('is-valid');
                        }
                        if (dataError.errorTelpCustomer) {
                            $('#errorTelpCustomer').html(dataError.errorTelpCustomer).show();
                            $('#telpCustomer').addClass('is-invalid');
                        } else {
                            $('#errorTelpCustomer').fadeOut();
                            $('#telpCustomer').removeClass('is-invalid');
                            $('#telpCustomer').addClass('is-valid');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            html: response.success
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "/customer/index";
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