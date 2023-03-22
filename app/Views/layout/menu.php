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
<li class="nav-header">Master</li>
<li class="nav-item">
    <a href="<?= site_url('category/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        <p>
            Kategori
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('unit/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-list"></i>
        <p>
            Satuan
        </p>
    </a>
</li>
<?= $this->endSection(); ?>