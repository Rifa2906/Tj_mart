<!-- Pie Chart -->
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4 class="m-0 font-weight-bold text-black">Profile</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <table>
                    <tr>
                        <td>
                            <div class="text-black">
                                Nama
                            </div>
                        </td>
                        <td>
                            <div class="text-black" style="margin-left: 80px ;">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="text-black ml-2">
                                <?= $detail['nama']; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mb-3">
                <table>
                    <tr>
                        <td>
                            <div class="text-black">
                                Alamat
                            </div>
                        </td>
                        <td>
                            <div class="text-black" style="margin-left: 72px ;">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="text-black ml-2">
                                <?= $detail['alamat']; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mb-3">
                <table>
                    <tr>
                        <td>
                            <div class="text-black">
                                No Telpon
                            </div>
                        </td>
                        <td>
                            <div class="text-black" style="margin-left: 52px ;">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="text-black ml-2">
                                <?php
                                function replace_last_character($string, $jum_digit_terakhir = 1)
                                {
                                    $arr_split = str_split($string);
                                    $jum_str = strlen($string); //bisa juga dengan count($arr_split)

                                    $replace_with = '*';
                                    $replace_start = $jum_str - $jum_digit_terakhir;

                                    if ($replace_start < 0) {
                                        return $string;
                                    }

                                    $str_fmt = '';
                                    for ($i = 0; $i < $jum_str; $i++) {
                                        if ($i < $replace_start) {
                                            $str_fmt .= $arr_split[$i];
                                        } else {
                                            $str_fmt .= $replace_with;
                                        }
                                    }

                                    return $str_fmt;
                                }
                                $hasil = replace_last_character($detail['no_telpon'], 5);

                                echo $hasil;
                                ?>

                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mb-3">
                <table>
                    <tr>
                        <td>
                            <div class="text-black">
                                Email
                            </div>
                        </td>
                        <td>
                            <div class="text-black" style="margin-left: 86px ;">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="text-black ml-2">
                                <?= $detail['email']; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mb-3">
                <table>
                    <tr>
                        <td>
                            <div class="text-black">
                                Hak pengguna
                            </div>
                        </td>
                        <td>
                            <div class="text-black" style="margin-left: 20px ;">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="text-black ml-2">
                                <?= $detail['hak_pengguna']; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mb-3">
                <div class="mb-3">
                    <table>
                        <tr>
                            <td>
                                <div class="text-black">
                                    Kata Sandi
                                </div>
                            </td>
                            <td>
                                <div class="text-black" style="margin-left: 48px ;">
                                    :
                                </div>
                            </td>
                            <td>
                                <div class="text-black ml-2">
                                    <?php
                                    $hasil = replace_last_character($detail['kata_sandi'], 2);

                                    echo $hasil;
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary btn-edit-pass" data-toggle="modal" data-target="#exampleModal" id="#myBtn">
                Ubah kata sandi
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah kata sandi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="id_pengguna" value=" <?= $detail['id_pengguna']; ?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kata Sandi Lama</label>
                        <input type="password" class="form-control" id="passLama" aria-describedby="emailHelp">
                        <span class="text-danger" id="passLama-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Kata sandi baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passBaru">
                            <div class="input-group-append">
                                <span class="input-group-text"><a id="eye"><i class='fas fa-solid fa-eye-slash'></i></a></span>
                            </div>
                        </div>
                        <span class="text-danger" id="passBaru-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi kata sandi</label>
                        <div class="input-group">

                            <input type="password" class="form-control" id="passKonf">
                            <div class="input-group-append">
                                <span class="input-group-text"><a id="eyeKonf"><i class="fas fa-solid fa-eye-slash"></i></a></span>
                            </div>
                        </div>
                        <span class="text-danger" id="passKonf-error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button type="button" onclick="simpan()" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    $("#eye").click(function() {
        event.preventDefault();
        if ($('#passBaru').attr("type") == "password") {
            $('#passBaru').attr('type', 'text');
            $('#eye i').removeClass("fas fa-solid fa-eye-slash");
            $("#eye i").addClass('fas fa-solid fa-eye')
        } else if ($('#passBaru').attr("type") == "text") {
            $('#passBaru').attr('type', 'password');
            $('#eye i').removeClass("fas fa-solid fa-eye");
            $("#eye i").addClass('fas fa-solid fa-eye-slash')

        }
    })

    $("#eyeKonf").click(function() {
        event.preventDefault();
        if ($('#passKonf').attr("type") == "password") {
            $('#passKonf').attr('type', 'text');
            $('#eyeKonf i').removeClass("fas fa-solid fa-eye-slash");
            $("#eyeKonf i").addClass('fas fa-solid fa-eye')
        } else if ($('#passKonf').attr("type") == "text") {
            $('#passKonf').attr('type', 'password');
            $('#eyeKonf i').removeClass("fas fa-solid fa-eye");
            $("#eyeKonf i").addClass('fas fa-solid fa-eye-slash')

        }
    })

    function simpan() {

        var passBaru = $("#passBaru").val();
        var passKonf = $("#passKonf").val();
        var passLama = $("#passLama").val();
        var id_p = $("#id_pengguna").val();


        $.ajax({
            type: 'POST',
            url: '<?= base_url('Detail_pengguna/edit_pass') ?>',
            data: {
                id_p: id_p,
                passLama: passLama,
                passBaru: passBaru,
                passKonf: passKonf
            },
            dataType: 'json',
            success: function(data) {

                if (data['status'] == 0) {


                    if (data['passBaru'] != "") {
                        $("#passBaru-error").html(data['passBaru']);
                    } else {
                        $("#passBaru-error").html('');
                    }

                    if (data['passBaru'] != data['passKonf']) {
                        $("#passKonf-error").html(data['passKonf']);
                    } else {
                        $("#passKonf-error").html('');
                    }

                    if (data['passLama'] != data['passBaru']) {
                        $("#passBaru-error").html(data['passBaru']);
                    } else {
                        $("#passBaru-error").html('');
                    }



                } else if (data['status'] == 1) {
                    $("#exampleModal").modal('hide');
                    $("#id_pengguna").val('');
                    $("#nama").val('');
                    $("#email").val('');
                    $("#passBaru").val('');
                    $("#passKonf").val('');
                    $("#no_telpon").val('');
                    $("#alamat").val('');
                    $("#peran").val('');

                    swall('kata sandi baru', 'Ditambahkan')


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
    //mengganti string digit terakhir dengan PHP
    //0856-568-8373 menjadi 0856-568-8***
</script>