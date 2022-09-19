<!-- Login Content -->
<div class="container-login ml-5">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-12 col-md-2">
            <div class="card shadow-sm my-5 w-75">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="login-form">
                                <div class="text-center mb-3">
                                    <img src="<?= base_url('assets/ruang-admin'); ?>/img/logo/Tj.png">
                                    TJ MART
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="POST">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukan Email">
                                        <small class="text-danger"> <?= form_error('email') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_baru" class="form-control" placeholder="Masukan Kata sandi baru" id="exampleInputPassword">
                                        <small class="text-danger"> <?= form_error('password_baru') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_conf" class="form-control" placeholder="Konfirmasi Kata sandi" id="exampleInputPassword">
                                        <small class="text-danger"> <?= form_error('password_conf') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                                    Simpan
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <a class="btn btn-warning btn-user btn-block" href="<?= base_url('Login'); ?>">Kembali</a>
                                            </div>
                                        </div>


                                    </div>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Content -->