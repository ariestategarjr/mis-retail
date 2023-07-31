<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Menu Pembelian</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Hitung</h3>

                <p>Pembelian</p>
            </div>
            <div class="icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <a href="<?= site_url('purchase/input') ?>" class="small-box-footer">Hitung Pembelian<i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Laporan</h3>

                <p>Pembelian</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <a href="<?= site_url('purchase/report') ?>" class="small-box-footer">Laporan Pembelian<i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>