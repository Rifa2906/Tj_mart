<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>

    </div>

    <div class="row">

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="<?= base_url('Laporan'); ?>" class="btn btn-primary">Tahun</a>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Periode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data_perbulan as $key => $value) {
                            ?>
                                <tr>

                                    <td><?= date("F Y", strtotime($value['tanggal_keluar'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('Laporan/Detail_bulan/') . date("m", strtotime($value['tanggal_keluar'])) ?>" class="btn btn-success btn-sm text-white"><i class="fas fa-eye"></i></a>
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
<script>

</script>