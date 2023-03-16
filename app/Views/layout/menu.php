<?= $this->extend('layout/template') ?>

<?= $this->section('menu') ?>
<li class="nav-item">
    <a href="<?= site_url('/') ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Home
        </p>
    </a>
</li>
<li class="nav-header">Master</li>
<li class="nav-item">
    <a href="<?= site_url('/category') ?>" class="nav-link">
        <i class="nav-icon fa fa-tasks"></i>
        <p>
            Categories
        </p>
    </a>
</li>
<?= $this->endSection() ?>