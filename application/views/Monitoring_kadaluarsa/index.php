<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">


                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $warning = date('d', strtotime('-14 day', strtotime(date('d'))));
                            foreach ($mkd as $key => $value) { ?>

                                <tr>
                                    <td><?= date("j F Y", strtotime($value['tanggal_kadaluarsa']))  ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['jumlah']; ?></td>
                                    <td>
                                        <center>
                                            <?php
                                            $warning = date('Y-m-d', strtotime('-14 day', strtotime($value['tanggal_kadaluarsa'])));
                                            echo $warning;
                                            if (strtotime('now') >= strtotime($warning)) {
                                                $tgl1 = strtotime('now');
                                                $tgl2 = strtotime($value['tanggal_kadaluarsa']);

                                                $jarak = $tgl2 - $tgl1;
                                                $hari = $jarak / 60 / 60 / 24;
                                            ?>
                                                <span class="badge badge-warning p-2"><i class="fas fa-exclamation-triangle"></i> Segera kadaluarsa</span><br>
                                                <small><?= date('d', strtotime($hari)) . ' hari lagi '; ?></small>
                                            <?php } else { ?>
                                                <span class="badge badge-success p-2">
                                                    <i class="fas fa-shield-alt"></i>
                                                    Aman
                                                </span>
                                            <?php } ?>
                                        </center>
                                    </td>
                                    <td>
                                        <?php
                                        if (date("d", strtotime($value['tanggal_kadaluarsa'])) >= $warning) { ?>
                                            <button type="button" onclick="barang_keluar(<?= $value['id_monitoring'] ?>)" class="btn btn-danger btn-sm" id="btn-kdl"><i class="fas fa-solid fa-arrow-right"></i></button>
                                        <?php
                                        }

                                        ?>
                                    </td>
                                </tr>
                            <?php

                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>
<!---Container Fluid-->

<script>
    function barang_keluar(id) {
        let text;
        if (confirm("Apakah anda yakin ingin mengeluarkan barang ini?") == true) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Monitoring_kadaluarsa/barang_keluar') ?>',
                data: {
                    id_monitoring: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data['status'] == 1) {
                        location.reload()
                    }

                }
            })
        } else {
            text = "You canceled!";
        }
    }
</script>