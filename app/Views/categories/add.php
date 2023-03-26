<!-- Modal -->
<div class="modal fade" id="addModalCategory" tabindex="-1" aria-labelledby="addModalCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalCategoryLabel">Form Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
            $action = 'category/addCategory';
            $attributes = ['id' => 'addFormCategory'];
            ?>
            <?= form_open($action, $attributes) ?>
            <input type="text" id="reload" name="reload" value="<?= $reload ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label for="idCategory">Id Kategori</label>
                    <input type="text" class="form-control form-control-sm" id="idCategory" name="idCategory">
                </div>
                <div class="form-group">
                    <label for="nameCategory">Nama Kategori</label>
                    <input type="text" class="form-control form-control-sm" id="nameCategory" name="nameCategory">
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
    $('#addFormCategory').submit(function(e) {
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
                let reload = $('#reload').val();

                if (response.success) {
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
                        $('#addModalCategory').modal('hide');
                        listCategories();
                    }
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    });
</script>