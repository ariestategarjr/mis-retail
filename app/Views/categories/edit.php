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
                    <label for="idCategory">Id Kategori</label>
                    <input type="text" class="form-control form-control-sm" id="idCategory" name="idCategory" value="<?= $idCategory ?>">
                </div>
                <div class="form-group">
                    <label for="nameCategory">Nama Kategori</label>
                    <input type="text" class="form-control form-control-sm" id="nameCategory" name="nameCategory" value="<?= $nameCategory ?>">
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
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    });
</script>