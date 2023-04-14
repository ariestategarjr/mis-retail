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
                <td style="text-align: right;"><?= number_format($row['hargajual'], 0, ",", "."); ?></td>
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

<script>
    function deleteItem(id, name) {
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
        // Swal.fire({
        //     title: 'Apakah Anda yakin ingin',
        //     html: `<h4 style="display: inline;">menghapus <strong style="color: #d33;">${name}</strong> ?</h4>`,
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Ya, hapus!',
        //     cancelButtonText: 'Tunda'
        // }).then((result) => {
        //     if (result.isConfirmed) {

        //     }
        // })
    }
</script>