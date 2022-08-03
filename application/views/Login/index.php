<!-- Login Content -->
<div class="container-login">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-12 col-md-2">
            <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="login-form">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="POST">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address">
                                        <small class="text-danger"> <?= form_error('email') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password">
                                        <small class="text-danger"> <?= form_error('password') ?></small>
                                    </div>
                                    <div class="form-group">
                                        <a href="<?= base_url('Login/sendEmail'); ?>">Lupa kata sandi?</a>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
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
<!-- Login Content -->