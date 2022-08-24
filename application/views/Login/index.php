<!-- Login Content -->
<center>
    <div class="container-login">
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
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Masukan kata sandi">
                                            <small class="text-danger"> <?= form_error('password') ?></small>
                                        </div>
                                        <div class="form-group">
                                            <a href="<?= base_url('Lupa_kataSandi'); ?>">Lupa kata sandi?</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger btn-user btn-block">
                                                Masuk
                                            </button>
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
</center>

<!-- Login Content -->