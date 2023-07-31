<!-- Modal -->
<div class="modal fade" id="editModalUnit" tabindex="-1" aria-labelledby="editModalUnitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalUnitLabel">Form Edit Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $action = 'unit/editUnit';
            $attributes = array('id' => 'editFormUnit', 'autocomplete' => 'on', 'required' => 'required');
            ?>
            <?= form_open($action, $attributes) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="idUnit">Kode Satuan</label>
                    <input type="text" class="form-control form-control-sm" id="idUnit" name="idUnit" value="<?= $idUnit ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="nameUnit">Nama Satuan</label>
                    <input type="text" class="form-control form-control-sm" id="nameUnit" name="nameUnit" value="<?= $nameUnit ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary save-button">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $('#editFormUnit').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function(e) {
                $('.save-button').prop('disabled', true);
                $('.save-button').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire(
                        'Berhasil!',
                        response.success,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else if (response.error) {
                    let dataError = response.error;

                    if (dataError.errorIdUnit) {
                        // $('#errorIdUnit').html(dataError.errorIdUnit).show();
                        // $('#idUnit').addClass('is-invalid');
                        Swal.fire(
                            'Error!',
                            dataError.errorIdUnit,
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#errorIdUnit').fadeOut();
                        $('#idUnit').removeClass('is-invalid');
                        $('#idUnit').addClass('is-valid');
                    }

                    if (dataError.errorNameUnit) {
                        // $('#errorNameUnit').html(dataError.errorNameUnit).show();
                        // $('#nameUnit').addClass('is-invalid');
                        Swal.fire(
                            'Error!',
                            dataError.errorNameUnit,
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#errorNameUnit').fadeOut();
                        $('#nameUnit').removeClass('is-invalid');
                        $('#nameUnit').addClass('is-valid');
                    }
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    });
</script>