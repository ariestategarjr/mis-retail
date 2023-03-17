<?= $this->extend('layout/main'); ?>

<?= $this->section('menu'); ?>
<li class="nav-item">
    <a href="<?= site_url('layout/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Home
        </p>
    </a>
</li>
<?= $this->endSection(); ?>