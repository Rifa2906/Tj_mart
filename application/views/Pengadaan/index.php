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
                                <th>Untuk Tanggal</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($pengadaan as $key => $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['jumlah_pengadaan']; ?></td>
                                    <td><?= $value['bulan']; ?></td>
                                    <td><?= $value['pemasok']; ?></td>
                                    <td>
                                        <?php
                                        if ($value['status'] == "Sudah Diajukan") { ?>
                                            <span class="badge badge-success p-2"><?= $value['status']; ?></span>
                                        <?php
                                        } elseif ($value['status'] == "Belum Diajukan") { ?>
                                            <span class="badge badge-warning p-2"><?= $value['status']; ?></span>
                                        <?php

                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($value['status'] == "Sudah Diajukan") { ?>

                                        <?php
                                        } else { ?>
                                            <button onclick="kirim(<?= $value['id_pengadaan'] ?>,<?= $value['id_barang'] ?>)" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Kirim ke tabel permintaan"><i class="fas fa-sharp fa-solid fa-paper-plane"></i></button>

                                            <button data-toggle="modal" data-target="#Modal_supplier" id="#exampleModal" onclick=" tampil_supplier(<?= $value['id_pengadaan'] ?>,<?= $value['id_barang'] ?>)" class="btn btn-success btn-sm"><i data-toggle="tooltip" data-placement="top" title="Pilih supplier" class="fas fa-truck-moving"></i></button>


                                            <button onclick="hapus(<?= $value['id_pengadaan'] ?>)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus data"><i class="fas fa-trash"></i></button>
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
    <!---Container Fluid-->


    <!-- Modal pilih supplier -->
    <div class="modal fade" id="Modal_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Menentukan supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_pengadaan">
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th>Pemasok</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('.select2-single').select2();


        })








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


        function kirim(id_pengadaan, id_barang) {
            $.ajax({
                method: "POST",
                url: "<?= base_url('Pengadaan/kirim') ?>",
                data: {
                    id_pengadaan: id_pengadaan,
                    id_barang: id_barang
                },
                dataType: "json",
                success: function(data) {

                    if (data.status == 1) {

                        Swal.fire({
                            title: 'Data',
                            text: 'Berhasi disimpan ke tabel permintaan',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            location.reload();
                        })
                    } else
                    if (data.status == 0) {
                        Swal.fire({
                            title: 'Supplier',
                            text: 'Belum dipilih',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    }


                }
            })
        }

        function tampil_supplier(id_pengadaan, id_barang) {
            $.ajax({
                method: "POST",
                url: "<?= base_url('Pengadaan/tampil_supplier') ?>",
                data: {
                    id_pengadaan: id_pengadaan,
                    id_barang: id_barang
                },
                dataType: "json",
                success: function(data) {
                    $("#id_pengadaan").val(data.id_pengadaan)
                    var html = '';
                    var i;
                    var data = data.supplier;
                    for (i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            '<td>' + data[i].nama_pemasok + '</td>' +
                            '<td>' + data[i].produk + '</td>' +
                            '<td>' + data[i].harga + '</td>' +
                            '<td><button onclick="pilih_supplier(' + data[i].id_pemasok + ')" class="btn btn-success btn-sm">Pilih</button></td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);

                }
            })
        }

        function pilih_supplier(id_pemasok) {
            id_pengadaan = $("#id_pengadaan").val()
            $.ajax({
                method: "POST",
                url: "<?= base_url('Pengadaan/pilih_suplier') ?>",
                data: {
                    id_pengadaan: id_pengadaan,
                    id_pemasok: id_pemasok
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        $("#Modal_supplier").modal('hide');
                        Swal.fire({
                            title: 'Supplier',
                            text: 'Berhasil dipilih',
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