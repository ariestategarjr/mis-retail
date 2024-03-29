<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Manajemen Data Kategori</h3>
<?= $this->endSection(); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


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
                    <th>Kode Kategori</th>
                    <th>Nama Kategori</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($categories as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['katid']; ?></td>
                        <td><?= $row['katnama']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="
                                editModalForm('<?= $row['katid']; ?>', 
                                         '<?= $row['katnama']; ?>')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="
                                deleteAlert('<?= $row['katid']; ?>', 
                                           '<?= $row['katnama']; ?>')">
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

<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    function addModalForm() {
        $.ajax({
            type: "post",
            url: "<?= site_url('category/addModalCategory') ?>",
            dataType: "json",
            data: {
                'reload': true
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
    }

    function editModalForm(id, name) {
        $.ajax({
            type: "post",
            url: "<?= site_url('category/editModalCategory') ?>",
            data: {
                'idCategory': id,
                'nameCategory': name
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modal-container').html(response.data).show();
                    $('#editModalCategory').on('shown.bs.modal', function(event) {
                        $('#nameCategory').focus();
                    });
                    $('#editModalCategory').modal('show');
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    function deleteAlert(id, name) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin',
            html: `<h4 style="display: inline;">menghapus <strong style="color: #d33;">${name}</strong> ?</h4>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('category/deleteCategory') ?>",
                    data: {
                        'idCategory': id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
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
                        // alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                        alert('Data tidak dapat dihapus! Data sedang digunakan.');
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>

<?= $this->endSection(); ?>