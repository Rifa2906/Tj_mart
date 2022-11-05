<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
        </ol>
    </div>

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="<?= base_url('Barang_keluar/form_tambah'); ?>" class="btn btn-primary">
                        Tambah
                    </a>

                </div>
                <div class="table-responsive p-3">
                    <?php
                    if ($this->session->flashdata('message')) { ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Data barang keluar berhasil <?= $this->session->flashdata('message') ?>
                        </div>
                    <?php
                    }
                    ?>
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal keluar</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Jenis Barang</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($barang_keluar as $key => $value) { ?>
                                <tr>
                                    <td><?= date('d F Y', strtotime($value['tanggal_keluar'])); ?></td>
                                    <td><?= $value['nama_barang']; ?></td>
                                    <td><?= $value['jumlah']; ?></td>
                                    <td><?= $value['nama_jenis']; ?></td>
                                    <td><?= $value['satuan']; ?></td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_keluar'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </a>



                                        <a href="<?= base_url('Barang_keluar/form_ubah/') . $value['id_keluar']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah">
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
            confirmButtonText: 'Oke'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
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
                    url: '<?= base_url('Barang_keluar/hapus_data') ?>',
                    data: {
                        id_keluar: x
                    },
                    dataType: 'json',
                    success: function(data) {}
                })

                swall('barang keluar', 'dihapus')

            }
        })
    }


    $("#nama_barang").change(function() {
        id_barang = $("#nama_barang").val();
        $.ajax({
            method: "POST",
            url: "<?= base_url('Barang_keluar/tampil_brg') ?>",
            data: {
                id_brg: id_barang
            },
            dataType: "json",
            success: function(data) {
                $("#jumlah_stok").text("Jangan lebih dari : " +
                    data.stok);
                $("#jumlah_stok_G").val(data.stok);
                $("#jml_stok").val(data.stok);
            }
        })
    })
</script>