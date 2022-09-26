<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border="1">
        <thead class="thead-light">
            <tr>
                <th>Kode Barang</th>
                <th>Tanggal Masuk</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Jenis Barang</th>
                <th>Satuan</th>
                <th>Pemasok</th>
                <th>Tanggal Kadaluarsa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($brg as $key => $value) { ?>
                <tr>
                    <td><?= $value['kode_barang_masuk']; ?></td>
                    <td><?= date('d/m/Y', strtotime($value['tanggal_masuk'])); ?></td>
                    <td><?= $value['nama_barang']; ?></td>
                    <td><?= $value['jumlah']; ?></td>
                    <td><?= $value['nama_jenis']; ?></td>
                    <td><?= $value['satuan']; ?></td>
                    <td><?= $value['nama_pemasok']; ?></td>
                    <td><?= date('d/m/Y', strtotime($value['tanggal_kadaluarsa'])); ?></td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</body>

</html>