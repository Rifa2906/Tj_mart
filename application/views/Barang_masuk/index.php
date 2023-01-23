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
                            <a href="<?= base_url('Barang_masuk/form_tambah'); ?>" class="btn btn-primary">
                                Tambah
                            </a>
                        </div>
                        <div class="col-7">
                            <div class="dropdown">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Cetak Laporan </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="<?= base_url('Barang_masuk/cetak_excel'); ?>"><i class="fas fa-file-excel"> Excel</i></a>
                                    <a class="dropdown-item" href="<?= base_url('Barang_masuk/cetak_pdf'); ?>"><i class="fas fa-file-pdf"></i> Pdf</a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="table-responsive p-3">
                    <?php
                    if ($this->session->flashdata('message')) { ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Data barang masuk berhasil <?= $this->session->flashdata('message') ?>
                        </div>
                    <?php
                    }
                    ?>
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal Masuk</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Jenis Barang</th>
                                <th>Satuan</th>
                                <th>Pemasok</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($barang_masuk as $key => $value) { ?>
                                <tr>
                                    <td><?= date('d F Y', strtotime($value['tanggal_masuk'])); ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['jumlah']; ?></td>
                                    <td><?= $value['nama_jenis']; ?></td>
                                    <td><?= $value['satuan']; ?></td>
                                    <td><?= $value['nama_pemasok']; ?></td>
                                    <td><?= date('d F Y', strtotime($value['tanggal_kadaluarsa'])); ?></td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_masuk'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </a>



                                        <a href="<?= base_url('Barang_masuk/form_ubah/') . $value['id_masuk']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
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
                    url: '<?= base_url('Barang_masuk/hapus_data') ?>',
                    data: {
                        id_masuk: x
                    },
                    dataType: 'json',
                    success: function(data) {}
                })

                swall('barang masuk', 'dihapus')

            }
        })
    }
</script>