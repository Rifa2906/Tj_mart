<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>

    </div>

    <div class="row">

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data_pertahun as $key => $value) {
                            ?>
                                <tr>

                                    <td><?= date("F Y", strtotime($value['tanggal_keluar'])) ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-eye"></i></button>
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
    function cari() {

        tahun = $('#tahun').val();
        $.ajax({
            method: "POST",
            url: "<?= base_url('Data_perTahun/tahun') ?>",
            data: {
                tahun: tahun
            },
            dataType: "json",
            success: function(data) {

            }
        })
    }
</script>