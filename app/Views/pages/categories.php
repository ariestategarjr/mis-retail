<?= $this->extend('layout/menu') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-primary">
                <i class="fas fa-plus">Add New Data</i>
            </button>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($categories as $row) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->id_kategori ?></td>
                        <td><?= $row->nama_kategori ?></td>
                        <td>
                            <!-- <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button> -->
                            <!-- <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $pager->links() ?>
    </div>
    <!-- /.card-body -->
</div>
<?= $this->endSection() ?>