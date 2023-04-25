<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('title'); ?>
<h3>Laporan Pembelian</h3>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="view-chart">
    <!-- display chart -->
</div>

<script>
    function getChart() {
        $.ajax({
            type: "post",
            url: "<?= site_url('purchase/getChart') ?>",
            data: {
                date: "2023-04"
            },
            dataType: "json",
            beforeSend: function() {
                $('.view-chart').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.view-chart').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
            }
        });
    }

    $(document).ready(function() {
        getChart();
    });
</script>
<?= $this->endSection(); ?>