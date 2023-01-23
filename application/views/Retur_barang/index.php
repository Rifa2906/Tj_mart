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
                    <div class="row">
                        <div class="col-5">
                            <button type="button" data-toggle="modal" data-target="#Modal_retur" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                        </div>
                        <div class="col-7">
                            <div class="dropdown">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Cetak Laporan </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="<?= base_url('Retur_barang/cetak_excel'); ?>"><i class="fas fa-file-excel"> Excel</i></a>
                                    <a class="dropdown-item" href="<?= base_url('Retur_barang/cetak_pdf'); ?>"><i class="fas fa-file-pdf"></i> Pdf</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Barang</th>
                            <th>Pemasok</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($retur as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['kode_barang']; ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['nama_pemasok']; ?></td>
                                    <td><?= $value['jumlah']; ?></td>
                                    <td><?= $value['satuan']; ?></td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_retur'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </a>
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

<!-- Modal tambah retur -->
<div class="modal fade" id="Modal_retur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="select2Single">Barang</label><br>
                        <select class="select2-single form-control" id="kode_barang">
                            <option value="">Pilih barang</option>
                            <?php
                            foreach ($brg as $key => $value) { ?>
                                <option value="<?= $value['kode_barang']; ?>"><?= $value['kode_barang']; ?> - <?= $value['nama_barang']; ?></option>

                            <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger" id="kode_barang-error"></span>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="jumlah">Retur</label>
                                <input type="number" class="form-control" id="jumlah">
                                <span class="text-danger" id="jumlah-error"></span>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="jumlah">Stok Gudang</label>
                                <input type="number" class="form-control" readonly id="stok_g">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select2Single">Pemasok</label><br>
                        <select class="select2-single form-control" id="pemasok">
                            <option value="">Pilih pemasok</option>
                            <?php
                            foreach ($pm as $key => $value) { ?>
                                <option value="<?= $value['id_pemasok']; ?>"><?= $value['nama_pemasok']; ?></option>

                            <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger" id="pemasok-error"></span>
                    </div>
            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                <button type="button" id="btn-tambah" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>
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


    function simpan() {

        var kode_barang = $("#kode_barang").val();
        var jumlah = $("#jumlah").val();
        var pemasok = $("#pemasok").val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url('Retur_barang/tambah_retur') ?>',
            data: {
                kode_barang: kode_barang,
                jumlah: jumlah,
                pemasok: pemasok
            },
            dataType: 'json',
            success: function(data) {

                if (data['status'] == 0) {
                    $("#kode_barang-error").html(data['kode_barang']);
                    $("#jumlah-error").html(data['jumlah']);
                    $("#pemasok-error").html(data['pemasok']);

                } else if (data['status'] == 1) {
                    $("#Modal_retur").modal('hide');
                    $("#jumlah").val('');
                    swall('Retur', 'Ditambahkan')


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
                    type: 'POST',
                    url: '<?= base_url('Retur_barang/hapus_data') ?>',
                    data: {
                        id_retur: x
                    },
                    dataType: 'json',
                    success: function(data) {}
                })

                swall('Retur', 'dihapus')

            }
        })
    }

    function diterima(x) {
        Swal.fire({
            title: 'Apakah barang yang di retur sudah diterima?',
            showDenyButton: true,
            confirmButtonText: 'Sudah',
            denyButtonText: 'Belum',
            icon: 'warning'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('Retur_barang/hapus_data') ?>',
                    data: {
                        diterima: x
                    },
                    dataType: 'json',
                    success: function(data) {}
                })

                swall('Retur', 'dihapus')

            }
        })
    }

    $("#kode_barang").change(function() {
        kode_barang = $("#kode_barang").val();
        $.ajax({
            method: "POST",
            url: "<?= base_url('Retur_barang/tampil_stok') ?>",
            data: {
                kode_barang: kode_barang
            },
            dataType: "json",
            success: function(data) {
                $("#stok_g").val(data);
            }
        })
    })
</script>