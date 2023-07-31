<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Home</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="card card-row card-dark">
    <div class="card-body">
        <div class="jumbotron jumbotron-fluid text-center">
            <div class="container">
                <h2 class="display-4">Halo, Selamat Datang Kembali!</h2>
                <h1 class="display-4"><b><?= session()->get('username'); ?></b></h1>
            </div>
        </div>
    </div>
</div>
<!-- <div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Fluid jumbotron</h1>
        <h5><?= session()->get('username'); ?></h5>
        <p>This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
    </div>
</div> -->


<?= $this->endSection(); ?>