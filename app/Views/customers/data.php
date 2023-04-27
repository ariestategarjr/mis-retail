<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Manajemen Data Pelanggan</h3>
<?= $this->endSection(); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('customer/add') ?>'">
            <i class="fas fa-plus"></i>Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped" id="customer-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($customers as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['pel_kode']; ?></td>
                        <td><?= $row['pel_nama']; ?></td>
                        <td><?= $row['pel_alamat']; ?></td>
                        <td><?= $row['pel_telp']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="window.location = '/customer/edit/<?= $row['pel_kode'] ?>'">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="
                                deleteAlert('<?= $row['pel_kode'] ?>',
                                            '<?= $row['pel_nama'] ?>')">
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
    function deleteAlert(id, name) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin',
            html: `<h4 style="display: inline;">menghapus <strong style="color: #d33;">${name}</strong> ?</h4>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tunda'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('customer/deleteCustomer') ?>",
                    data: {
                        'idCustomer': id
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
                        alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        $('#customer-table').DataTable();
    });
</script>

<?= $this->endSection(); ?>