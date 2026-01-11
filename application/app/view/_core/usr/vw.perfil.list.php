<section class="content-header">
    <h1>Listar Perfiles</h1>
    <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Perfiles</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="box">

        <div class="box-header with-border">
            <button class="btn btn-primary btnAgregarPerfil" data-toggle="modal" data-target="#modalAgregarPerfil">
                Agregar Perfil
            </button>
        </div>

        <div class="box-body">
            <table id="tbl-perfiles" class="table table-striped dt-responsive tablas" width="100%">
                <thead>
                    <tr>
                        <th style="width:10px">Id</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Usuario Sistema</th>
                        <th>Fecha Sistema</th>
                        <th></th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>

</section>

<?php include 'vw.perfil.modal.php'?>

<script src="<?= constant('APP_URL') ?>app/js/_core/usr/perfil.js"></script>