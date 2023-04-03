<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga Jual</th>
            <th>Sub Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($dataSaleDetail->getResultArray() as $row) :
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['kode']; ?></td>
                <td><?= $row['namaproduk']; ?></td>
                <td><?= $row['jml']; ?></td>
                <td style="text-align: right;"><?= number_format($row['hargajual'], 0, ",", "."); ?></td>
                <td style="text-align: right;"><?= number_format($row['subtotal'], 0, ",", "."); ?></td>
                <td>Button</td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>