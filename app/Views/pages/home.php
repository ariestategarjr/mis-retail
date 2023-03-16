<?= $this->extend('layout/menu') ?>

<?= $this->section('content') ?>
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Selamat Datang!</h5>
    Ini adalah Aplikasi Point Of Sales.
</div>
<?= $this->endSection() ?>