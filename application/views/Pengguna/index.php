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
                    <button type="button" data-toggle="modal" data-target="#Modal_user" id="#exampleModal" class="btn btn-primary">Tambah</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telpon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($user as $key => $value) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $value['nama']; ?></td>
                                    <td><?= $value['alamat']; ?></td>
                                    <td><?= $value['no_telpon']; ?></td>
                                    <td>


                                        <a class="btn btn-success btn-sm btn-detail" href="<?= base_url('Detail_pengguna/detail/') . $value['id_pengguna'] ?>" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fas fa-light fa-user"></i></a>

                                        <a data-toggle="tooltip" data-placement="top" title="Ubah">
                                            <button data-toggle="modal" data-target="#Modal_user_edit" id="#exampleModal" onclick="submit(<?= $value['id_pengguna'] ?>)" class="btn btn-warning btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </a>

                                        <a data-toggle="tooltip" data-placement="top" title="Hapus">
                                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= $value['id_pengguna'] ?>)">
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
                </div>
            </div>
        </div>
    </div>



</div>
<!---Container Fluid-->

<!-- Modal tambah user -->
<div class="modal fade" id="Modal_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="hidden" id="id_pengguna">
                                <input type="hidden" id="peran">
                                <input type="text" class="form-control" id="nama">
                                <span class="text-danger" id="nama-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control" id="email">
                                <span class="text-danger" id="email-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea id="alamat" class="form-control" rows="3"></textarea>
                                <span class="text-danger" id="alamat-error"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">No telpon</label>
                                <input type="text" class="form-control" id="no_telpon">
                                <span class="text-danger" id="no_telpon-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Kata sandi</label>
                                <div class="input-group">

                                    <input type="password" class="form-control" id="pass1">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a id="eye"><i class='fas fa-solid fa-eye-slash'></i></a></span>
                                    </div>
                                </div>
                                <span class="text-danger" id="pass1-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Konfirmasi kata sandi</label>
                                <div class="input-group">

                                    <input type="password" class="form-control" id="pass2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a id="eyeKonf"><i class="fas fa-solid fa-eye-slash"></i></a></span>
                                    </div>
                                </div>
                                <span class="text-danger" id="pass2-error"></span>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                <button type="button" id="btn-tambah" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal user edit -->
<div class="modal fade" id="Modal_user_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="hidden" id="id_pengguna_edit">
                                <input type="hidden" id="peran_edit">
                                <input type="hidden" class="form-control" id="pass1_edit">
                                <input type="text" class="form-control" id="nama_edit">
                                <span class="text-danger" id="nama_edit-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control" id="email_edit">
                                <span class="text-danger" id="email_edit-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">No telpon</label>
                                <input type="text" class="form-control" id="no_telpon_edit">
                                <span class="text-danger" id="no_telpon_edit-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea id="alamat_edit" class="form-control" rows="3"></textarea>
                                <span class="text-danger" id="alamat_edit-error"></span>
                            </div>
                        </div>


                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary btn-kembali" data-dismiss="modal">Kembali</button>
                <button type="button" id="btn-ubah" class="btn btn-primary" onclick="ubah()">Ubah</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(".btn-kembali").click(function() {
        $("#id_pengguna_edit").val('');
        $("#nama_edit").val('');
        $("#email_edit").val('');
        $("#pass1_edit").val('');
        $("#no_telpon_edit").val('');
        $("#alamat_edit").val('');
    })

    $(".close").click(function() {
        $("#id_pengguna_edit").val('');
        $("#nama_edit").val('');
        $("#email_edit").val('');
        $("#pass1_edit").val('');
        $("#no_telpon_edit").val('');
        $("#alamat_edit").val('');
    })


    function simpan() {

        var nama = $("#nama").val();
        var email = $("#email").val();
        var no_telpon = $("#no_telpon").val();
        var alamat = $("#alamat").val();
        var Pass1 = $("#pass1").val();
        var Pass2 = $("#pass2").val();


        $.ajax({
            type: 'POST',
            url: '<?= base_url('Pengguna/tambah_pengguna') ?>',
            data: {
                nama: nama,
                email: email,
                no_telpon: no_telpon,
                alamat: alamat,
                Pass1: Pass1,
                Pass2: Pass2
            },
            dataType: 'json',
            success: function(data) {

                if (data['status'] == 0) {
                    if (data['nama'] != "") {
                        $("#nama-error").html(data['nama']);
                    } else {
                        $("#nama-error").html('');
                    }

                    if (data['email'] != "") {
                        $("#email-error").html(data['email']);
                    } else {
                        $("#email-error").html('');
                    }

                    if (data['alamat'] != "") {
                        $("#alamat-error").html(data['alamat']);
                    } else {
                        $("#alamat-error").html('');
                    }

                    if (data['no_telpon'] != "") {
                        $("#no_telpon-error").html(data['no_telpon']);
                    } else {
                        $("#no_telpon-error").html('');
                    }

                    if (data['pass1'] != "") {
                        $("#pass1-error").html(data['pass1']);
                    } else {
                        $("#pass1-error").html('');
                    }

                    if (data['pass1'] != data['pass2']) {
                        $("#pass2-error").html(data['pass2']);
                    } else {
                        $("#pass2-error").html('');
                    }


                } else if (data['status'] == 1) {
                    $("#Modal_user").modal('hide');
                    $("#nama").val('');
                    $("#email").val('');
                    $("#pass1").val('');
                    $("#pass2").val('');
                    $("#no_telpon").val('');
                    $("#alamat").val('');

                    swall('pengguna', 'Ditambahkan')


                }

            }
        })

    }

    function submit(x) {

        $.ajax({
            type: 'POST',
            url: '<?= base_url('Pengguna/ambil_IdPengguna') ?>',
            data: {
                id_pengguna: x
            },
            dataType: 'json',
            success: function(data) {
                $("#id_pengguna_edit").val(data.id_pengguna);
                $("#nama_edit").val(data.nama);
                $("#email_edit").val(data.email);
                $("#pass1_edit").val(data.kata_sandi);
                $("#peran_edit").val(data.hak_pengguna);
                $("#no_telpon_edit").val(data.no_telpon);
                $("#alamat_edit").val(data.alamat);
            }
        })

    }

    function ubah() {

        var id_pengguna = $("#id_pengguna_edit").val();
        var peran = $("#peran_edit").val();
        var no_telpon = $("#no_telpon_edit").val();
        var alamat = $("#alamat_edit").val();
        var nama = $("#nama_edit").val();
        var email = $("#email_edit").val();
        var Pass1 = $("#pass1_edit").val();


        $.ajax({
            type: 'POST',
            url: '<?= base_url('Pengguna/ubah_data') ?>',
            data: {
                id_pengguna: id_pengguna,
                peran: peran,
                nama: nama,
                email: email,
                alamat: alamat,
                no_telpon: no_telpon,
                email: email,
                Pass1: Pass1,
            },
            dataType: 'json',
            success: function(data) {

                if (data['status'] == 0) {
                    if (data['nama'] != "") {
                        $("#nama_edit-error").html(data['nama']);
                    } else {
                        $("#nama_edit-error").html('');
                    }

                    if (data['alamat'] != "") {
                        $("#alamat_edit-error").html(data['alamat']);
                    } else {
                        $("#alamat_edit-error").html('');
                    }

                    if (data['no_telpon'] != "") {
                        $("#no_telpon_edit-error").html(data['no_telpon']);
                    } else {
                        $("#no_telpon_edit-error").html('');
                    }

                    if (data['email'] != "") {
                        $("#email_edit-error").html(data['email']);
                    } else {
                        $("#email_edit-error").html('');
                    }

                    if (data['pass1'] != "") {
                        $("#pass1_edit-error").html(data['pass1']);
                    } else {
                        $("#pass1_edit-error").html('');
                    }

                } else if (data['status'] == 1) {
                    $("#Modal_user_edit").modal('hide');
                    $("#id_pengguna_edit").val('');
                    $("#nama_edit").val('');
                    $("#email_edit").val('');
                    $("#pass1_edit").val('');
                    $("#no_telpon_edit").val('');
                    $("#alamat_edit").val('');

                    swall('pengguna', 'Diubah')


                }

            }
        })

    }

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
                    url: '<?= base_url('Pengguna/hapus_data') ?>',
                    data: {
                        id_pengguna: x
                    },
                    dataType: 'json',
                    success: function(data) {}
                })

                swall('pengguna', 'dihapus')

            }
        })
    }

    $("#eye").click(function() {
        event.preventDefault();
        if ($('#pass1').attr("type") == "password") {
            $('#pass1').attr('type', 'text');
            $('#eye i').removeClass("fas fa-solid fa-eye-slash");
            $("#eye i").addClass('fas fa-solid fa-eye')
        } else if ($('#pass1').attr("type") == "text") {
            $('#pass1').attr('type', 'password');
            $('#eye i').removeClass("fas fa-solid fa-eye");
            $("#eye i").addClass('fas fa-solid fa-eye-slash')

        }
    })

    $("#eyeKonf").click(function() {
        event.preventDefault();
        if ($('#pass2').attr("type") == "password") {
            $('#pass2').attr('type', 'text');
            $('#eyeKonf i').removeClass("fas fa-solid fa-eye-slash");
            $("#eyeKonf i").addClass('fas fa-solid fa-eye')
        } else if ($('#pass2').attr("type") == "text") {
            $('#pass2').attr('type', 'password');
            $('#eyeKonf i').removeClass("fas fa-solid fa-eye");
            $("#eyeKonf i").addClass('fas fa-solid fa-eye-slash')

        }
    })

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>