<?= $this->extend('layout/main'); ?>

<?= $this->section('menu'); ?>
<li class="nav-item">
    <a href="<?= site_url('layout/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Home
        </p>
    </a>
</li>
<li class="nav-header">Master</li>
<li class="nav-item">
    <a href="<?= site_url('category/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>
            Kategori
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('unit/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-balance-scale"></i>
        <p>
            Satuan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('product/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-box"></i>
        <p>
            Produk
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('customer/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Pelanggan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('supplier/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-people-carry"></i>
        <p>
            Penyuplai
        </p>
    </a>
</li>
<li class="nav-header">Transaksi</li>
<li class="nav-item">
    <a href="<?= site_url('sale/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-store"></i>
        <p>
            Penjualan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('purchase/index') ?>" class="nav-link">
        <i class="nav-icon fas fa-shopping-cart"></i>
        <p>
            Pembelian
        </p>
    </a>
</li>
<?= $this->endSection(); ?>