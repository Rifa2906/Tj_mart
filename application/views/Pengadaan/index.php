<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>

    </div>

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Pengadaan</th>
                                <th>Untuk Tanggal</th>
                                <th>Supplier</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($pengadaan as $key => $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['kode_barang']; ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['jumlah_pengadaan']; ?></td>
                                    <td><?= $value['bulan']; ?></td>
                                    <td><?= $value['pemasok']; ?></td>
                                    <td>

                                        <button onclick="Kirim(<?= $value['id_pengadaan'] ?>)" class="btn btn-primary btn-sm"><i class="fas fa-sharp fa-solid fa-paper-plane"></i></button>

                                        <button onclick="hapus(<?= $value['id_pengadaan'] ?>)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus data"><i class="fas fa-trash"></i></button>

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
    <!---Container Fluid-->

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('.select2-single').select2();
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

        function Kirim(id_pengadaan) {

            Swal.fire({
                title: 'Apakah anda yakin ingin melakukan permintaan pengadaan barang?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                icon: 'warning'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        method: "POST",
                        url: "<?= base_url('Pengadaan/kirim') ?>",
                        data: {
                            id_pengadaan: id_pengadaan
                        },
                        dataType: "json",
                        success: function() {}
                    })
                    swall('Barang', 'melakukan permintaan');
                }
            })
        }



        function hapus(x) {
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapusnya?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                icon: 'warning'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url('Pengadaan/hapus_data') ?>",
                        data: {
                            id_pengadaan: x
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 1) {
                                Swal.fire({
                                    title: 'Data Pengadaan',
                                    text: 'Berhasil dihapus',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    location.reload();
                                })
                            }
                        }
                    })



                }
            })
        }
    </script>