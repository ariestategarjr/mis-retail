<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Manajemen Data Produk</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('product/addFormProduct') ?>'">
            <i class="fas fa-plus"></i>Tambah Data
        </button>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped" id="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barcode</th>
                    <th>Nama Produk</th>
                    <th>Satuan</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Gambar</th>
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
                        <td><?= $row['satnama']; ?></td>
                        <td><?= $row['katnama']; ?></td>
                        <td><?= $row['stok_tersedia'] ?></td>
                        <td><?= $row['harga_beli']; ?></td>
                        <td><?= $row['harga_jual']; ?></td>
                        <td><?= $row['gambar'] ?></td>
                        <td>Button</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal-container" style="display: none;"></div>

    <script>
        function addModalForm() {
            alert('add');
        }
    </script>

    <?= $this->endSection(); ?>