<div class="login-box">

    <div class="login-box-body">

        <div class="login-logo">
            <img src="<?= constant('APP_URL') . constant('APP_ROUTES_IMAGE_DIR') . constant('APP_ROUTES_IMAGE_LOGO') ?>" alt="<?= constant('APP_NAME') ?>" width="285">
        </div>

        <p class="login-box-msg"><b>Inicia Sesión</b></p>

        <form id="formLogin" method="post" autocomplete="off">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" autocomplete="off">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <!-- /.col -->
                <div id="divSubmit" class="col-xs-4 pull-right">
                    <button id="btn-ingresar" type="button" class="btn btn-primary btn-block btn-flat btn-me-submit">Sign In</button>
                </div>
                <!-- /.col -->
            </div>

            <div>
                <a data-toggle="modal" href="#modalResetPassword">Olvidé mi contraseña</a>
            </div>
            <br>
            <div id="mensaje-login">
            </div>

        </form>
        <br />

    </div>
    <!-- /.login-box-body -->

</div>
<!-- /.login-box -->

<script src="<?= constant('APP_URL') . 'app/js/_core/usr/login.js?v=' . time() ?>"></script>

<?php include 'vw.login-reset-password.php' ?>