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
                            <a class="btn btn-primary" href="<?= base_url('Retur_barang/cetak_pdf'); ?>">Cetak PDF</a>
                        </div>
                    </div>

                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <th>No</th>
                            <th>Barang</th>
                            <th>Pemasok</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($retur as $key => $value) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['nama_pemasok']; ?></td>
                                    <td><?= $value['jumlah']; ?></td>
                                    <td><?= $value['satuan']; ?></td>
                                    <td>
                                        <?php
                                        if ($value['status'] == 'Belum diterima') { ?>
                                            <a class="text-primary" style="cursor: pointer;" onclick="diterima('Sudah diterima')"><?= $value['status'] ?></a>
                                        <?php
                                        }
                                        ?>
                                    </td>
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
                        <select class="form-control" id="barang">
                            <option value="">Pilih barang</option>
                            <?php
                            foreach ($brg as $key => $value) { ?>
                                <option value="<?= $value['id_barang']; ?>"><?= $value['nama_barang']; ?></option>

                            <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger" id="barang-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah">
                        <span class="text-danger" id="jumlah-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="select2Single">Pemasok</label><br>
                        <select class="form-control" id="pemasok">
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

        var barang = $("#barang").val();
        var jumlah = $("#jumlah").val();
        var pemasok = $("#pemasok").val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url('Retur_barang/tambah_retur') ?>',
            data: {
                barang: barang,
                jumlah: jumlah,
                pemasok: pemasok
            },
            dataType: 'json',
            success: function(data) {

                if (data['status'] == 0) {
                    $("#barang-error").html(data['barang']);
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
</script>