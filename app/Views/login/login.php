<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiToko</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css">

    <!-- jQuery -->
    <script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Sweet Alert 2 Script -->
    <!-- Sweet Alert 2 Style -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url('assets') ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="login-page" style="min-height: 463.333px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-dark">
            <div class="card-header text-center">
                <a href="<?= site_url('login/index') ?>" class="h3">Si<b>Toko</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login</p>

                <?php
                $action = 'login/actionLogin';
                $attributes = ['id' => 'checkFormLogin'];
                ?>
                <?= form_open($action, $attributes) ?>
                <div class="input-group mb-3">
                    <input type="username" class="form-control" placeholder="username" name="username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="password" name="password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-dark btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= form_close(); ?>

                <p>
                    <?php if (!empty(session()->getFlashdata('gagal'))) { ?>
                <div class="alert alert-warning">
                    <?php echo session()->getFlashdata('gagal') ?>
                </div>
            <?php } ?>
            </p>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets') ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url('assets') ?>/dist/js/demo.js"></script>
</body>

<script>
    function actionLogin() {
        $.ajax({
            type: "post",
            url: "<?= site_url('login/actionLogin') ?>",
            data: "data",
            dataType: "dataType",
            success: function(response) {

            }
        });
    }

    $(document).ready(function() {

    });
</script>

</html>