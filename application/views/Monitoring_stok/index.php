<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light text-center">
                            <th>Barang</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($brg as $key => $value) {
                                $jenis_barang = $value['nama_jenis'];
                                $stok = $value['stok'];
                            ?>
                                <tr>

                                    <td>

                                        <?php
                                        if (($jenis_barang == 'Minuman' && $stok < 10) ||  ($jenis_barang == 'Makanan' && $stok < 3)) { ?>
                                            <div class="small text-black-500 font-weight-bold mb-2"><?= $value['nama_barang']; ?>
                                            </div>
                                            <div class="progress" style="height: 12px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $value['stok']; ?>%" aria-valuenow="<?= $value['stok']; ?>" aria-valuemin="0" aria-valuemax="0"></div>
                                            </div>

                                        <?php
                                        } else { ?>

                                            <div class="small text-black-500 font-weight-bold mb-2"><?= $value['nama_barang']; ?>

                                            </div>
                                            <div class="progress" style="height: 12px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $value['stok']; ?>%" aria-valuenow="<?= $value['stok']; ?>" aria-valuemin="0" aria-valuemax="0"></div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </td>

                                    <td class="text-center">
                                        <?= $value['stok']; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        if (($jenis_barang == 'Minuman' && $stok < 24) ||  ($jenis_barang == 'Makanan' && $stok < 12)) { ?>
                                            <span class="badge badge-danger p-2"><i class="fas fa-exclamation-triangle"></i></span>

                                        <?php
                                        } else { ?>
                                            <span class="badge badge-success p-2"><i class="fas fa-shield-alt"></i></span>

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
                    <div class="card-footer text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!---Container Fluid-->