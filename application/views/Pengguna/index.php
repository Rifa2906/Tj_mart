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
                    <button type="button" data-toggle="modal" data-target="#Modal_user" id="#exampleModal" onclick="submit('tambah')" class="btn btn-primary">Tambah</button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kata sandi</th>
                                <th>Peran</th>
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
                                    <td><?= $value['email']; ?></td>
                                    <td><?= $value['kata_sandi']; ?></td>
                                    <td><?= $value['peran']; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#Modal_user" id="#exampleModal" onclick="submit(<?= $value['id_pengguna'] ?>)" class="btn btn-warning btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="#" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
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

<!-- Modal -->
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
                    <div class="form-group">
                        <input type="hidden" id="id_pengguna">
                        <input type="hidden" id="peran">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control" id="nama">
                        <span class="text-danger" id="nama-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" id="email">
                        <span class="text-danger" id="email-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kata sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="pass1">
                            <div class="input-group-append">
                                <span class="input-group-text"><a id="eye"><i class='fas fa-solid fa-eye-slash'></i></a></span>
                            </div>
                        </div>
                        <span class="text-danger" id="pass1-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Konfirmasi kata sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="pass2">
                            <div class="input-group-append">
                                <span class="input-group-text"><a id="eyeKonf"><i class="fas fa-solid fa-eye-slash"></i></a></span>
                            </div>
                        </div>
                        <span class="text-danger" id="pass2-error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Kembali</button>
                <button type="button" id="btn-ubah" class="btn btn-primary" onclick="ubah()">Ubah</button>
                <button type="button" id="btn-tambah" class="btn btn-primary" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function simpan() {

        var nama = $("#nama").val();
        var email = $("#email").val();
        var Pass1 = $("#pass1").val();
        var Pass2 = $("#pass2").val();


        $.ajax({
            type: 'POST',
            url: '<?= base_url('Pengguna/tambah_pengguna') ?>',
            data: {
                nama: nama,
                email: email,
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

                    swall_tambah('pengguna', 'Ditambahkan')


                }

            }
        })

    }

    function submit(x) {
        if (x == 'tambah') {
            $("#btn-tambah").show();
            $("#btn-ubah").hide();
        } else {
            $("#btn-tambah").hide();
            $("#btn-ubah").show();

            $.ajax({
                type: 'POST',
                url: '<?= base_url('Pengguna/ambil_IdPengguna') ?>',
                data: {
                    id_pengguna: x
                },
                dataType: 'json',
                success: function(data) {
                    $("#id_pengguna").val(data.id_pengguna);
                    $("#nama").val(data.nama);
                    $("#email").val(data.email);
                    $("#pass1").val(data.pass1);
                    $("#peran").val(data.p);
                }
            })
        }
    }

    function ubah() {

        var id_pengguna = $("#id_pengguna").val();
        var peran = $("#peran").val();
        var nama = $("#nama").val();
        var email = $("#email").val();
        var Pass1 = $("#pass1").val();
        var Pass2 = $("#pass2").val();


        $.ajax({
            type: 'POST',
            url: '<?= base_url('Pengguna/ubah_data') ?>',
            data: {
                id_pengguna: id_pengguna,
                peran: peran,
                nama: nama,
                email: email,
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
                    $("#id_pengguna").val('');
                    $("#nama").val('');
                    $("#email").val('');
                    $("#pass1").val('');
                    $("#pass2").val('');

                    swall_tambah('pengguna', 'Diubah')


                }

            }
        })

    }

    function swall_tambah(params1, params2) {
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
</script>