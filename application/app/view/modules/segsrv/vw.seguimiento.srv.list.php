<section class="content-header">
    <h1>Seguimiento de Servicios</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Servicios Seguimiento</li>
        <li class="active">Lista</li>
    </ol>
</section>


<section class="content-header">
<div class="box box-primary">

    <!--<form id="formVivFinanciero" role="form" method="post" enctype="multipart/form-data" autocomplete="off">-->
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']?>">
                <input type="hidden" id="accion_perfil" name="accion_perfil" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil']?>">

    <div class="box-body" >
        <div >
            <h3><?= $_SESSION[constant('APP_NAME')]['user']['nombres']." ".$_SESSION[constant('APP_NAME')]['user']['apellidos']?></h3>
        </div>
        <div id="ocultar" class="col-xs-12 col-sm-7 center-block">
            <!-- ENTRADA PARA PERFIL-->
            <div class="col-xs-12 col-sm-6 center-block">
                <div class="form-group">
                    <label for="perfil" class="control-label">Perfil: *</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                        <select class="form-control input" id="perfil" name="perfil" required>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ENTRADA PARA NOMBRE USUARIO PROVEEDOR-->
            <div class="col-xs-12 col-sm-6 center-block">
                <div class="form-group">
                    <label for="id_usuario_calidad" class="control-label">Usuario a Asignar: *</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                        <select class="form-control input" id="id_usuario_calidad" name="id_usuario_calidad" required>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- ENTRADA PARA NOMBRE ESTADO PROCESO-->
        <div class="col-xs-12 col-sm-4 center-block">
            <div class="form-group">
                <label for="estado_servicio" class="control-label">Estado Proceso: *</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                    <select class="form-control input" id="estado_servicio" name="estado_servicio" required>
                    </select>
                </div>
            </div>
        </div>
        <div>
            <br>
            <button id="btn-submit-buscar" type="button" class="btn btn-primary btnBuscar">Buscar</button>
        </div>
    </div>



                <!--</form>-->
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<style>
/* Estilo para la lista de proveedores */
#provider-count-container {
    padding: 10px;
    background-color: #fff;
    border-radius: 5px;
    margin-bottom: 15px;
}

#provider-count li {
    margin: 5px 0;
    padding: 8px;
    border-radius: 4px;
    font-size: 1.1em;
}

/* Colores para proveedores */
.provider {
    background-color: #e0f7fa; /* Azul claro */
    color: #00796b;
    font-weight: bold;
}

/* Colores para servicios sin asignar */
.no-provider {
    background-color: #ffebee; /* Rojo claro */
    color: #c62828;
    font-weight: bold;
}
</style>


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                    <div class="box-header with-border">
                    </div>
                <div class="box-body">
                   <!-- <div id="provider-count-container">
                        <h3 style="cursor: pointer;" onclick="toggleProviderCount()">Contador de Proveedores: Dar click</h3>
                        <ul id="provider-count" style="display: none;"></ul>
                    </div>-->

                    <div id="provider-count-container">
                        <button id="toggle-button" class="btn btn-primary" onclick="toggleProviderCount()">Contador de Proveedores: Dar click</button>
                        <ul id="provider-count" style="display: none; padding: 10px;"></ul>
                    </div>


                    <table id="tbl-servicios-calidad" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Proveedor/Calidad</th>
                                <th>Prioridad</th>
                                <th>Cliente</th>
                                <th>Candidato</th>
                                <th>Documento</th>
                                <th>Nom Servicio</th>
                                <th>Estado Calidad</th>
                                <th>Estado</th>
                                <th>Estado Proceso</th>
                                <th>Fch Solicitud</th>
                                <th>Fch Est Solucion</th>
                                <td>Ver Detalle</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/srv/servicios_seguimiento.js"></script>