<!-- Modal -->
<div class="modal fade" id="editModalCategory" tabindex="-1" aria-labelledby="editModalCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalCategoryLabel">Form Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $action = 'category/editCategory';
            $attributes = array('id' => 'editFormCategory', 'autocomplete' => 'on', 'required' => 'required')
            ?>
            <?= form_open($action, $attributes) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="idCategory">Kode Kategori</label>
                    <input type="text" class="form-control form-control-sm" id="idCategory" name="idCategory" value="<?= $idCategory ?>" required readonly>
                    <div id="errorIdCategory" class="invalid-feedback" style="display: none;">
                        <!-- Please provide a valid data. -->
                    </div>
                </div>
                <div class="form-group">
                    <label for="nameCategory">Nama Kategori</label>
                    <input type="text" class="form-control form-control-sm" id="nameCategory" name="nameCategory" value="<?= $nameCategory ?>">
                    <div id="errorNameCategory" class="invalid-feedback" style="display: none;">
                        <!-- Please provide a valid data. -->
                    </div>
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
    $('#editFormCategory').submit(function(e) {
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

                    if (dataError.errorIdCategory) {
                        // $('#errorIdCategory').html(dataError.errorIdCategory).show();
                        // $('#idCategory').addClass('is-invalid');
                        Swal.fire(
                            'Error!',
                            dataError.errorIdCategory,
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#errorIdCategory').fadeOut();
                        $('#idCategory').removeClass('is-invalid');
                        $('#idCategory').addClass('is-valid');
                    }

                    if (dataError.errorNameCategory) {
                        // $('#errorNameCategory').html(dataError.errorNameCategory).show();
                        // $('#nameCategory').addClass('is-invalid');
                        Swal.fire(
                            'Error!',
                            dataError.errorNameCategory,
                            'error'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        $('#errorNameCategory').fadeOut();
                        $('#nameCategory').removeClass('is-invalid');
                        $('#nameCategory').addClass('is-valid');
                    }
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    });
</script>