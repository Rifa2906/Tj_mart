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
                                <th>Nama Barang</th>
                                <th>Jumlah Pengadaan</th>
                                <th>Satuan</th>
                                <th>Pemasok</th>
                                <th>Status</th>
                                <?php
                                if ($this->session->userdata('hak_pengguna') == 'staf administrasi') { ?>
                                    <th>Aksi</th>
                                <?php
                                } else  if ($this->session->userdata('hak_pengguna') == 'kepala gudang') { ?>
                                    <th>Aksi</th>
                                <?php
                                }
                                ?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($permintaan as $key => $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['jumlah_pengadaan']; ?></td>
                                    <td><?= $value['satuan']; ?></td>
                                    <td><?= $value['pemasok']; ?></td>
                                    <td>
                                        <?php
                                        if ($value['status'] == 'Meminta persetujuan') { ?>
                                            <span class="badge badge-warning p-2">
                                                <?= $value['status']; ?>
                                            </span>
                                        <?php
                                        } else
                                        if ($value['status'] == 'Sudah disetujui') { ?>
                                            <span class="badge badge-success p-2">
                                                <?= $value['status']; ?>
                                            </span>
                                        <?php
                                        } else
                                        if ($value['status'] == 'Tidak disetujui') { ?>
                                            <span class="badge badge-danger p-2">
                                                <?= $value['status']; ?>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if ($this->session->userdata('hak_pengguna') == 'staf administrasi') { ?>
                                        <td>
                                            <?php
                                            if ($value['status'] == "Meminta persetujuan") { ?>
                                                <button data-toggle="tooltip" data-placement="left" title="Disetujui" onclick=" disetujui(<?= $value['id_permintaan'] ?>)" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>



                                                <button data-toggle="tooltip" data-placement="left" title="Ditolak" onclick="ditolak(<?= $value['id_permintaan'] ?>)" class="btn btn-danger btn-sm">

                                                    <i class="fas fa-exclamation-circle"></i>
                                                </button>

                                                <button data-toggle="tooltip" data-placement="left" title="Dihapus" onclick="hapus_permintaan_AM(<?= $value['id_permintaan'] ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </td>

                                    <?php
                                            }
                                    ?>




                                <?php
                                    } else if ($this->session->userdata('hak_pengguna') == 'kepala gudang') { ?>
                                    <td>
                                        <button data-toggle="tooltip" data-placement="left" title="Dihapus" onclick="hapus_permintaan_KG(<?= $value['id_permintaan'] ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </td>

                                <?php
                                    }
                                ?>

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

        function gagal_peramalan(produk) {
            Swal.fire({
                title: 'Data ' + produk + ' belum bisa diramalkan',
                confirmButtonText: 'Oke'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            })
        }

        function peramalan(id_barang, min_stok, stok) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Peramalan/peramalan') ?>',
                dataType: 'json',
                data: {
                    id_barang: id_barang,
                    min_stok: min_stok
                },
                success: function(data) {

                    if (data.status == 1) {
                        produk = data.produk;
                        peramalan = data.peramalan
                        bulan = data.bulan_berikutnya
                        satuan = data.satuan
                        jenis = data.jenis

                        swall(produk, peramalan, satuan, bulan)
                    } else if (data.status == 0) {
                        produk = data.produk;
                        gagal_peramalan(produk)
                    }


                }
            })
        }

        function disetujui(x) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Permintaan/Disetujui') ?>',
                dataType: 'json',
                data: {
                    id_permintaan: x,
                },
                success: function(data) {
                    if (data.status == 1) {

                        swall('permintaan', 'Disetujui')
                    }
                }
            })
        }

        function ditolak(x) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Permintaan/Ditolak') ?>',
                dataType: 'json',
                data: {
                    id_permintaan: x,
                },
                success: function(data) {
                    if (data.status == 1) {

                        swall('permintaan', 'Ditolak')
                    }
                }
            })
        }

        function hapus_permintaan_KG(id_permintaan) {
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapusnya?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                icon: 'warning'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('Permintaan/hapus') ?>',
                        dataType: 'json',
                        data: {
                            id_permintaan: id_permintaan,
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                swall('permintaan', 'dihapus')
                            }
                        }
                    })



                }
            })


        }

        function hapus_permintaan_AM(id_permintaan) {
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapusnya?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                icon: 'warning'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('Permintaan/hapus') ?>',
                        dataType: 'json',
                        data: {
                            id_permintaan: id_permintaan,
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                swall('permintaan', 'dihapus')
                            }
                        }
                    })



                }
            })


        }
    </script>