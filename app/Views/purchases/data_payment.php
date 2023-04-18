<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- AutoNumeric Plugin -->
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>

<!-- Modal -->
<div class="modal fade" id="getModalPayment" tabindex="-1" aria-labelledby="getModalPaymentLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getModalPaymentLabel">Data Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('purchase/savePayment', ['id' => 'addFormPayment']) ?>
            <div class="modal-body">
                <input type="hidden" name="fakturcode" value="<?= $fakturcode ?>">
                <input type="hidden" name="suppliercode" value="<?= $suppliercode ?>">
                <input type="hidden" name="totalbruto" id="totalbruto" value="<?= $totalpayment ?>">

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Disc(%)</label>
                            <input type="text" name="disprecent" id="disprecent" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Disc(Rp)</label>
                            <input type="text" name="discash" id="discash" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Total Pembayaran</label>
                    <input type="text" name="totalnetto" id="totalnetto" class="form-control form-control-lg" value="<?= $totalpayment ?>" style="font-weight: bold; text-align: right; color: blue; font-size: 24pt;" readonly>
                </div>
                <div class="form-group">
                    <label for="">Jumlah Uang</label>
                    <input type="text" name="amountmoney" id="amountmoney" class="form-control" style="font-weight: bold; text-align: right; color: red; font-size: 20pt;">
                </div>
                <div class="form-group">
                    <label for="">Sisa Uang</label>
                    <input type="text" name="restmoney" id="restmoney" class="form-control" style="font-weight: bold; text-align: right; color: blue; font-size: 20pt;" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary save-button">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    function calculateDiscount() {
        let totalbruto = $('#totalbruto').val();
        let disprecent = ($('#disprecent').val() == '') ? 0 : $('#disprecent').autoNumeric('get');
        let discash = ($('#discash').val() == '') ? 0 : $('#discash').autoNumeric('get');

        let result = 0;
        result = parseFloat(totalbruto) - (parseFloat(totalbruto) * parseFloat(disprecent) / 100) - parseFloat(discash);

        $('#totalnetto').val(result);

        let totalNetto = $('#totalnetto').val();
        $('#totalnetto').autoNumeric('set', totalNetto);
    }

    function calculateChangeMoney() {
        let totalNetto = $('#totalnetto').autoNumeric('get');
        let amountMoney = ($('#amountmoney').val() == '') ? 0 : $('#amountmoney').autoNumeric('get');

        let result = 0;
        result = parseFloat(amountMoney) - parseFloat(totalNetto);

        $('#restmoney').val(result);

        let restMoney = $('#restmoney').val();
        $('#restmoney').autoNumeric('set', restMoney);
    }

    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $('#disprecent').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '2',
        });

        $('#discash').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('#totalnetto').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('#amountmoney').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('#restmoney').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            nDec: '0',
        });

        $('#disprecent').keyup(function(e) {
            calculateDiscount();
        });

        $('#discash').keyup(function(e) {
            calculateDiscount();
        });

        $('#amountmoney').keyup(function(e) {
            calculateChangeMoney();
        });

        $('#addFormPayment').submit(function(e) {
            e.preventDefault();

            let amountMoney = ($('#amountmoney').val() == '') ? 0 : $('#amountmoney').autoNumeric('get');
            let restMoney = ($('#restmoney').val() == '') ? 0 : $('#restmoney').autoNumeric('get');

            if (parseFloat(amountMoney) == 0 || parseFloat(amountMoney) == '') {
                Toast.fire({
                    icon: 'warning',
                    title: 'Maaf, jumlah uang belum dimasukkan.'
                });
            } else if (parseFloat(restMoney) < 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Maaf, jumlah uang belum mencukupi.'
                });
            } else {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.save-button').prop('disable', true);
                        $('.save-button').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.save-button').prop('disable', false);
                        $('.save-button').html('Simpan');
                    },
                    success: function(response) {
                        if (response.success == 'berhasil') {
                            Swal.fire({
                                title: 'Cetak',
                                text: "Apakah Anda yakin ingin cetak struk ?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, cetak!',
                                cancelButtonText: 'Tunda'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    alert('cetak struk');
                                    window.location.reload();
                                } else {
                                    window.location.reload();
                                }
                            })
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                    }
                });
            }

            return false;
        });
    });
</script>