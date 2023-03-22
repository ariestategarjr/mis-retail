<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Manajemen Data Satuan</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary" onclick="addModalForm()">
            <i class="fas fa-plus"></i>Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped" id="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id Satuan</th>
                    <th>Nama Satuan</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($units as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['satid']; ?></td>
                        <td><?= $row['satnama']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="
                                editFormModal('<?= $row['satid']; ?>', 
                                         '<?= $row['satnama']; ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="
                                deleteAlert('<?= $row['satid']; ?>', 
                                           '<?= $row['satnama']; ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-container" style="display: none;"></div>

<script>
    function addModalForm() {
        $.ajax({
            url: "<?= site_url('unit/addModalUnit') ?>",
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
    }
</script>
<?= $this->endSection(); ?>