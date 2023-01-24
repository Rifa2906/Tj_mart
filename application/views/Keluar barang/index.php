<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">

        </ol>
    </div>



    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="table-responsive p-3">
                    <div class="row">
                        <div class="col-2">
                            <button data-toggle="tooltip" data-placement="right" title="Hapus semua data" class="btn btn-danger mb-4" onclick="hapus()">Hapus semua</button>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Cetak Laporan </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="<?= base_url('Keluar_barang/cetak_excel'); ?>"><i class="fas fa-file-excel"> Excel</i></a>
                                    <a class="dropdown-item" href="<?= base_url('Keluar_barang/cetak_pdf'); ?>"><i class="fas fa-file-pdf"></i> Pdf</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Jenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($kd as $key => $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['tanggal_kadaluarsa']; ?></td>
                                    <td><?= $value['kode_barang']; ?></td>
                                    <td><?= $value['jumlah']; ?></td>
                                    <td><?= $value['satuan']; ?></td>
                                    <td><?= $value['nama_jenis']; ?></td>
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
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function swall(params1, params2) {
        Swal.fire({
            title: 'Data ' + params1,
            text: 'Berhasil  ' + params2,
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            location.reload();
        })

    }

    function hapus() {
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus semua data?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            icon: 'warning'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('Keluar_barang/hapus_semua_data') ?>',
                    dataType: 'json',
                    success: function(data) {}
                })

                swall('Barang yang dikeluarkan', 'dihapus')

            }
        })

    }
</script>