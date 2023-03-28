<!-- Modal -->
<div class="modal fade" id="addModalUnit" tabindex="-1" aria-labelledby="addModalUnitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalUnitLabel">Form Tambah Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $action = 'unit/addUnit';
            $attributes = ['id' => 'addFormUnit'];
            ?>
            <?= form_open($action, $attributes) ?>
            <div class="modal-body">
                <input type="hidden" id="reload" value="<?= $reload ?>">
                <div class="form-group">
                    <label for="idUnit">Id Unit</label>
                    <input type="text" class="form-control form-control-sm" id="idUnit" name="idUnit" required>
                </div>
                <div class="form-group">
                    <label for="nameUnit">Nama Unit</label>
                    <input type="text" class="form-control form-control-sm" id="nameUnit" name="nameUnit">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary save-button">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $('#addFormUnit').submit(function(e) {
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
                    let reload = $('#reload').val();

                    if (reload === 'true') {
                        Swal.fire(
                            'Berhasil!',
                            response.success,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#addModalUnit').modal('hide');
                        listUnits();
                    }
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    });
</script>