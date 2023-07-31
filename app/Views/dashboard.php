<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Dashboard</h3>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>
<!-- Main content -->
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $count_products ?></h3>

                    <p>Produk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?= site_url('product/index') ?>" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $count_sales ?></h3>

                    <p>Penjualan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?= site_url('sale/report') ?>" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $count_purchases ?></h3>

                    <p>Pembelian</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?= site_url('purchase/report') ?>" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card card-row card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        Stok Habis
                    </h3>
                </div>
                <div class="card-body">
                    <?php foreach ($empty_stock as $row) : ?>
                        <div class="card card-danger card-outline">
                            <div class="card-header">
                                <h5 class="card-title"><?= $row['namaproduk'] ?></h5>
                                <div class="card-tools">
                                    <a href="<?= site_url('product/index') ?>" class="btn btn-tool">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card card-row card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        Barang Terlaris
                    </h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($best_sellers as $row) : ?>
                                <tr>
                                    <td><?= $row['namaproduk'] ?></td>
                                    <td><?= $row['harga_jual'] ?></td>
                                    <td>
                                        <bold class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            <?= $row['TotalPenjualan'] ?>
                                        </bold>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->

<!-- /.content -->
<?= $this->endSection(); ?>