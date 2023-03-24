<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Form Tambah Produk</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-secondary" onclick="window.location='<?= site_url('product/index') ?>'">
            <i class="fas fa-backward"></i> Kembali
        </button>
    </div>
    <div class="card-body">

    </div>

    <div class="modal-container" style="display: none;"></div>


    <?= $this->endSection(); ?>