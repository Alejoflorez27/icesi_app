<section class="content-header">
    <h1>Servicios</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Servicios</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
    <div class="col-md-12" id="div-box-servicios">

            <div class="box">

                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddServicio" data-toggle="modal" data-target="#modalAddServicio">
                        Agregar Servicio
                    </button>
                </div>
                <div class="box-body">
                    <table id="tbl-servicios" class="table table-bordered table-striped dt-responsive tablas" width="100%"  width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre Producto</th>
                                <th>Nombre Servicio</th>
                                <th>Gestión Servicio</th>
                                <th>Reporte</th>
                                <th>Ruta</th>
                                <th>Valor Adicional</th>
                                <th>Valor Bogotá Prov</th>
                                <th>Valor Fuera Bogotá Prov</th>
                                <th>Estado</th>
                                <th>Usuario Crea</th>
                                <th>Fecha Crea</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="div-perfiles hide">
            <div class="col-md-3">
                <input type="hidden" id="idServcio">
                <div class="box">
                    <div class="box-body">
                        <table id="tbl-servicio-perfil" class="table table-bordered table-striped " width="100%">
                            <thead>
                                <tr>
                                    <td colspan="2">Servicios Asignables a:</td>
                                </tr>
                                <tr>
                                    <th colspan="2" id="servicio-desc"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl-perfiles"> </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.servicio.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/srv/servicio.js"></script>