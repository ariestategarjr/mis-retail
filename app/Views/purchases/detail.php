<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga Beli</th>
            <th>Sub Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($dataPurchaseDetail->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode']; ?></td>
                <td><?= $row['namaproduk']; ?></td>
                <td><?= $row['jml']; ?></td>
                <td style="text-align: right;"><?= number_format($row['hargabeli'], 0, ",", "."); ?></td>
                <td style="text-align: right;"><?= number_format($row['subtotal'], 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="
                        deleteItem('<?= $row['id'] ?>', '<?= $row['namaproduk'] ?>')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>

<div id="print-area" style="display: none;">
    <table class="tg tg-center">
        <thead>
            <tr>
                <th class="tg-baqh" colspan="3"><span style="font-weight:bold">SiToko</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-baqh" colspan="3">Pasar Karanganyar, Kebumen</td>
            </tr>
            <tr>
                <td class="tg-baqh" colspan="3">080123456789</td>
            </tr>
            <tr>
                <td class="tg-baqh" colspan="3" style="padding: 5px 0px;"></td>
            </tr>
            <tr>
                <td class="tg-0lax" colspan="3">=============================================</td>
            </tr>

            <?php foreach ($dataPurchaseDetail->getResultArray() as $row) : ?>
                <tr>
                    <td class="tg-0lax"><?= $row['namaproduk']; ?></td>
                    <td class="tg-0lax"></td>
                    <td class="tg-0lax"></td>
                </tr>
                <tr>
                    <td class="tg-0lax"><?= $row['jml']; ?> x <?= number_format($row['hargabeli'], 0, ",", "."); ?></td>
                    <td class="tg-0lax"></td>
                    <td class="tg-0lax"><?= number_format($row['subtotal'], 0, ",", "."); ?></td>
                </tr>

            <?php endforeach; ?>

            <tr>
                <td class="tg-0lax" colspan="3">=============================================</td>
            </tr>
            <tr>
                <td class="tg-0lax">Total</td>
                <td class="tg-0lax">Rp.</td>
                <td class="tg-0lax print-total"></td>
            </tr>
            <tr>
                <td class="tg-0lax">Bayar</td>
                <td class="tg-0lax">Rp.</td>
                <td class="tg-0lax print-bayar">-</td>
            </tr>
            <tr>
                <td class="tg-0lax">Kembali</td>
                <td class="tg-0lax">Rp.</td>
                <td class="tg-0lax print-kembali">-</td>
            </tr>
            <tr>
                <td class="tg-0lax" colspan="3"></td>
            </tr>
            <tr>
                <td class="tg-baqh" colspan="3" style="padding: 5px 0px;"></td>
            </tr>
            <tr>
                <td class="tg-wp8o print-tanggal" colspan="3">================= 2023/03/03 =================</td>
            </tr>
            <tr>
                <td class="tg-wp8o print-jam" colspan="3">================= 00:00 =================</td>
            </tr>
        </tbody>
    </table>
</div>

<iframe id="printing-frame" name="print_frame" src="about:blank" style="display: none;"></iframe>

<script>
    function deleteItem(id, name) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin',
            html: `<h4 style="display: inline;">menghapus <strong style="color: #d33;">${name}</strong> ?</h4>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('purchase/deleteItem') ?>",
                    data: {
                        'idItem': id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            displayPurchaseDetail();
                            reset();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(`${xhr.status} ${xhr.responseText} ${thrownError}`);
                    }
                });
            }
        })
    }
</script>