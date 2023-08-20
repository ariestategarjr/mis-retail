<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


<!-- Modal -->
<div class="modal fade" id="getModalProduct" tabindex="-1" aria-labelledby="getModalProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getModalProductLabel">Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="keywordCode" id="keywordCode" value="<?= $keyword ?>">
                <table id="product-table" class="table table-bordered table-striped dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barcode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Jumlah</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--  -->
                    </tbody>

                </table>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    function selectProduct(code, name) {
        let numberItems = parseInt($(`#numberItems${code}`).val());

        // console.log(numberItems + " " + typeof numberItems);
        let jumlah = $('#jumlah').val(numberItems);
        // console.log(jumlah);

        $('#kodebarcode').val(code);
        $('#namaproduk').val(name);
        // $('#jumlah').val(numberItems);
        $('#getModalProduct').on('hidden.bs.modal', function(event) {
            $('#kodebarcode').focus();
            checkCodeBarcode();
        });
        $('#getModalProduct').modal('hide');
    }

    $(document).ready(function() {
        let table = $('#product-table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('sale/getListDataProduct') ?>",
                "type": "POST",
                "data": {
                    keywordCode: $('#keywordCode').val()
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
                "defaultContent ": " - ",
                "targets": "_all"
            }, ],
        });
    });
</script>