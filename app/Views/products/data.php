<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Manajemen Data Produk</h3>
<?= $this->endSection(); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('product/add') ?>'">
            <i class="fas fa-plus"></i>Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped" id="product-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barcode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($products as $row) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['kodebarcode']; ?></td>
                        <td><?= $row['namaproduk']; ?></td>
                        <td><?= $row['katnama']; ?></td>
                        <td style="text-align: right;"><?= number_format($row['stok_tersedia'], '0', ',', '.'); ?></td>
                        <td><?= $row['satnama']; ?></td>
                        <td style="text-align: right;"><?= number_format($row['harga_beli'], '2', ',', '.'); ?></td>
                        <td style="text-align: right;"><?= number_format($row['harga_jual'], '2', ',', '.'); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" onclick="window.location = '/product/edit/<?= $row['kodebarcode'] ?>'">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="
                                deleteAlert('<?= $row['kodebarcode'] ?>',
                                            '<?= $row['namaproduk'] ?>')">
                                <i class="fas fa-trash-alt"></i>
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
    function deleteAlert(code, name) {
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
                    url: "<?= site_url('product/deleteProduct') ?>",
                    data: {
                        'codeProduct': code
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
        $('#product-table').DataTable();
    });
</script>

<?= $this->endSection(); ?>