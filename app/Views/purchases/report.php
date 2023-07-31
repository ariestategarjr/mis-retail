<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Laporan Pembelian</h3>
<?= $this->endSection(); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pembelian</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <form action="<?= site_url('purchase/report') ?>" method="get">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label class="col-form-label">Periode</label>
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" id="periode-dari" name="periode_dari" required>
                        </div>
                        <div class="col-auto">
                            -
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" id="periode-ke" name="periode_ke" required>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="col-sm-12 col-md-3">
                    <div class="dt-buttons btn-group flex-wrap">
                        <button onclick="printDiv('print-area')" class="btn btn-secondary buttons-print" tabindex="0" aria-controls="example1" type="button"><span>Cetak</span></button>
                    </div>
                    <!-- <div class="dt-buttons btn-group flex-wrap">
                        <button class="btn btn-danger" type="button" onclick="deleteFilter()"><span>Delete By Date</span></button>
                    </div> -->
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-sm-12" id="print-area">
                    <table class="table table-sm table-striped datatables-report-purchase">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($purchases as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['detbeli_faktur']; ?></td>
                                    <td><?= $row['beli_tgl']; ?></td>
                                    <td><?= $row['namaproduk']; ?></td>
                                    <td><?= $row['detbeli_hargabeli']; ?></td>
                                    <td><?= $row['detbeli_jml']; ?></td>
                                    <td><?= $row['detbeli_subtotal']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tr>
                            <td colspan="6"><b>Total</b></td>
                            <td><?= $purchasesTotal['total_jumlah']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<iframe id="printing-frame" name="print_frame" src="about:blank" style="display: none;"></iframe>

<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    function printDiv(elementId) {
        let elementPrinted = document.getElementById(elementId).innerHTML;

        window.frames["print_frame"].document.title = document.title;
        window.frames["print_frame"].document.body.innerHTML =
            `<style>
                .no-print { display: none }
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {    
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                .dataTables_length,
                .dataTables_filter,
                .dataTables_info,
                .dataTables_paginate 
                {
                    display: none;
                }
            </style>
            ${elementPrinted}`;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }

    function deleteFilter() {
        $.ajax({
            type: "POST",
            url: "<?= site_url('purchases/deleteFilter'); ?>",
            data: {
                periodedari: $('#periode-dari').val(),
                periodeke: $('#periode-ke').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    $(document).ready(function() {
        $('.datatables-report-purchase').DataTable();
    });
</script>


<?= $this->endSection(); ?>