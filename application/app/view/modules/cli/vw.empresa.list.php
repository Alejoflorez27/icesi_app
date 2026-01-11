<section class="content-header">
    <h1>Empresas</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Indicadores</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" id="div-box-clientes">

            <div class="box">

                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddEmpresa" data-toggle="modal" data-target="#modalAddEmpresa">
                        Agregar Empresa
                    </button>
                </div>
                <div class="box-body">
                    <table id="tbl-empresas" class="table table-striped dt-responsive tablas  table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Razon Social </th>
                                <th>Identificación </th>
                                <th>Ciudad </th>
                                <th>Representante </th>
                                <th>Correo </th>
                                <th>Estado</th>
                                <th>Terceros </th>
                                <th>Subempresas</th>
                                <th>Usuarios</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.empresa.modal.php' ?>
<?php include 'vw.tercero.modal.php' ?>
<?php include 'vw.tercero.modal.list.php' ?>
<?php include 'vw.subemp.modal.list.php' ?>
<?php include 'vw.subemp.modal.php' ?>
<?php include 'vw.usuario.modal.php' ?>
<?php include 'vw.usuario.modal.list.php' ?>


<script src="<?= constant('APP_URL') ?>app/js/cli/empresa.js"></script>