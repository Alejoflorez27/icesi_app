<section class="content-header">
    <h1>Listar Usuarios</h1>
    <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="box">

        <div class="box-header with-border">
            <button class="btn btn-primary btnAgregarUsuario" data-toggle="modal" data-target="#modalAgregarUsuario">
                Agregar Usuario
            </button>
        </div>

        <div class="box-body">
            <table id="tbl-usuarios" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                    <tr>
                        <th style="width:10px">Id</th>
                        <th>Nombre</th>
    <!--                <th>Empresa</th>    -->
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Perfil Acceso</th>
                        <th>Último login</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>

</section>

<?php include 'vw.usuario.modal.php'?>
<?php include 'vw.usuario.access.log.modal.php' ?>

<script src="<?= constant('APP_URL') ?>app/js/_core/usr/usuario.js"></script>