<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= constant('APP_NAME') ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="icon" href="<?= constant('APP_URL') . constant('APP_ROUTES_IMAGE_DIR') . constant('APP_ROUTES_IMAGE_ISOLOGO') ?>">

    <?php require_once '__view.vendor.css.php' ?>
    <?php require_once '__view.vendor.js.php' ?>


    <?= "<script>var URL_APP = '" . constant('APP_URL') . "'</script>" ?>
    <?= "<script>function url_site(path = '') {return URL_APP + path}</script>" ?>
    <?= "<script>function setToken(token) { localStorage.setItem('" . constant('APP_TOKEN_NAME') . "', token) }</script>" ?>
    <?= "<script>function getToken() { return localStorage.getItem('" . constant('APP_TOKEN_NAME') . "') }</script>" ?>
    <?= "<script>function deleteToken() { return localStorage.removeItem('" . constant('APP_TOKEN_NAME') . "') }</script>" ?>

    <script src="<?= constant('APP_URL') ?>app/js/_core/util.js"></script>

    <!-- SweetAlert2 v8: requerido para mostrar modal amplios como en v7 -->
    <style>
        .swal2-popup {
            font-size: 1.6rem !important;
        }
    </style>

    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <style>
        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #d2d6de;
        }
    </style>


</head>

<body class="hold-transition <?= $_SESSION[constant('APP_NAME')]['user']['modo'] ?? 'skin-blue' ?> sidebar-mini login-page">

    <?php if (CtrUsuario::isLogged(true)) : ?>
        <div class="wrapper">

            <?php require_once "_header.php"; ?>
            <?php require_once "_menu.php"; ?>

            <div class="content-wrapper">
                <?php include_once dirname(__FILE__, 2) . '/' . $modules_route . ($module != '' ? $module : ($file_view != '_salir.php' ? 'ini/' : '')) . $file_view; ?>
            </div>

            <?php require_once "_footer.php"; ?>
            <?php require_once "_sidebar.php"; ?>
            <?php require_once "_about.php"; ?>

        </div>

    <?php else : ?>
        <?php include "vw.login.php"; ?>
    <?php endif; ?>


    <?php if (CtrUsuario::isLogged(true)) : ?>
        <script src="<?= constant('APP_URL') ?>app/js/_core/plantilla.js"></script>
    <?php endif; ?>

</body>

</html>