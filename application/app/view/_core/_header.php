<header class="main-header">

    <!-- LOGOTIPO -->
    <a href="<?= constant('APP_URL') ?>inicio" class="logo">
        <!-- logo mini -->
        <span class="logo-mini">
            <!-- <b><?= constant('APP_NAME') ?></b> -->
            <img src=<?= constant('APP_URL') . constant('APP_ROUTES_IMAGE_DIR') . constant('APP_ROUTES_IMAGE_ISOLOGO') ?> class="img-responsive" style="padding:10px">
        </span>

        <!-- logo normal -->
        <span class="logo-lg">
            <!-- <b><?= constant('APP_NAME') ?></b> -->
            <img src=<?= constant('APP_URL') . constant('APP_ROUTES_IMAGE_DIR') . constant('APP_ROUTES_IMAGE_LOGO') ?> class="img-responsive" style="padding:10px">
        </span>
    </a>

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">
                            <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p>
                                <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong>
                                <br><br>
                                <small><strong>Usuario:</strong>
                                    <?= $_SESSION[constant('APP_NAME')]['user']['username'] ?></small>
                                <small><strong>Email:</strong>
                                    <?= $_SESSION[constant('APP_NAME')]['user']['email'] ?></small>
                                <small><strong>Miembro desde:</strong>
                                    <?= date("d-m-Y", strtotime($_SESSION[constant('APP_NAME')]['user']['create_time'])) ?></small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a data-toggle="modal" href="#modalPassword" class="btn btn-default btn-flat">Cambiar
                                    Password</a>
                            </div>
                            <div class="pull-right">
                                <a href=<?= constant('APP_URL') . "salir" ?> class="btn btn-default btn-flat cerrarSesion">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            <!--    <li>
                    <a id="about" href="#" data-toggle="modal" data-target="#modalAbout"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>

<?php include 'vw.login-password.php' ?>
