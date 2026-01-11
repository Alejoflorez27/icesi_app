<?php require_once 'cnf.solicitud.button.php'; ?>
<?php require_once 'common.solicitud.php'; ?>

<?php
$usuario = CtrUsuario::getUsuarioApp();
$respuesta_usr = CtrUsuario::consultar($usuario);
$empresa = $respuesta_usr['id_empresa'];

$empresaSub = CtrTrcEmpresa::findById($empresa);
$razon_social = $empresaSub['data']['razon_social'];
$id_empresa_padre = $empresaSub['data']['id_empresa_padre'];

if ($id_empresa_padre != null) {
    $empresa = $id_empresa_padre;
}

$subEmpresa = CtrTrcEmpresa::findSubEmpresas($empresa);

//print_r($subEmpresa['data']);
?>

<style>
    .btnDetalleSolicitud,
    .btnResumenServiciosSolicitud {
        cursor: pointer;
    }
</style>

<section class="content-header">
    <h1>Solicitudes</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Solicitud</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Filtros:</h4>
                </div>
                <div class="box-body">

                    <div class="form-group div-fechas col-md-2">
                        <label for="fecha_desde">Fecha:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="me-edit-info form-control input-sm" id="filter_fecha_rango" name="filter_fecha_rango" placeholder="Fecha de solicitud" autocomplete="off" readonly>

                            <input type="hidden" name="filter_fecha_desde" id="filter_fecha_desde" class="form-control" value="">
                            <input type="hidden" name="filter_fecha_hasta" id="filter_fecha_hasta" class="form-control" value="">
                            <input type="hidden" name="perfil_campo" id="perfil_campo" class="form-control" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil'] ?>">
                            <input type="hidden" name="id_empresa_campo" id="id_empresa_campo" class="form-control" value="<?= $_SESSION[constant('APP_NAME')]['user']['id_empresa'] ?>">
                            <input type="hidden" name="username" id="username" class="form-control" value="<?= $_SESSION[constant('APP_NAME')]['user']['username'] ?>">
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="filter_cliente">Cliente:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                            <select name="filter_cliente" id="filter_cliente" class="form-control select2">
                                <option value="">-- Seleccione uno --</option>
                                <?php 
                                if ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 7) {
                                    // Solo mostrar la empresa del usuario logueado
                                    echo '<option value="'.$empresa.'" selected>'.$razon_social.'</option>';

                                } else {
                                    // Mostrar todas las empresas enroladas
                                    foreach ($clientes_enrol as $cli) : ?>
                                        <option value="<?= $cli['id_empresa'] ?>" 
                                            <?= ($cli['id_empresa'] == $empresa) ? 'selected' : '' ?>>
                                            <?= $cli['razon_social'] ?>
                                        </option>
                                    <?php endforeach; 
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="filter_subempresa">SubEmpresa:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                            <select name="filter_subempresa" id="filter_subempresa" class="form-control select2">
                                <option value="">-- Seleccione uno --</option>
                                <?php 
                                if ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 7) {
                                    // Solo mostrar la empresa del usuario logueado
                                    //echo '<option value="'.$empresa.'" selected>'.$razon_social.'</option>';

                                                                        // Mostrar todas las empresas enroladas
                                    foreach ($subEmpresa['data'] as $cli) : ?>
                                        <option value="<?= $cli['id_empresa'] ?>" 
                                            <?= ($cli['id_empresa'] == $empresa) ? 'selected' : '' ?>>
                                            <?= $cli['razon_social'] ?>
                                        </option>
                                    <?php endforeach; 
                                } else {
                                    // Mostrar todas las empresas enroladas
                                    foreach ($clientes_enrol as $cli) : ?>
                                        <option value="<?= $cli['id_empresa'] ?>" 
                                            <?= ($cli['id_empresa'] == $empresa) ? 'selected' : '' ?>>
                                            <?= $cli['razon_social'] ?>
                                        </option>
                                    <?php endforeach; 
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <?php 
                    $perfil_usr = $_SESSION[constant('APP_NAME')]['user']['perfil'];
                    // print_r($perfil_usr); 
                    ?>
                    <?php if ($perfil_usr == 10 || $perfil_usr == 11 || $perfil_usr == 15 || $perfil_usr == 16) : ?>
                        <!-- Campo oculto para establecer el valor "Todos" -->
                        <input type="hidden" id="filter_estado" name="filter_estado" value="">
                    <?php else: ?>
                    <div class="form-group col-md-3">
                        <label for="filter_estado">Estado:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            <select class="form-control input select2" id="filter_estado" name="filter_estado">
                                <option value="">-- Seleccione uno --</option>
                                <?php foreach ($filter_estados_solicitud as $est) : ?>
                                    <option value="<?= $est['codigo'] ?>"><?= $est['descripcion'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>



                    <?php $perfil = CtrTrcComboCli::findAllClienteFilter($_SESSION[constant('APP_NAME')]['user']['id_empresa']); 
                    //print_r($perfil); ?>

                    <div class="form-group col-md-3">
                        <label for="filter_combo">Combo:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            <select class="form-control input select2" id="filter_combo" name="filter_combo">
                                <option value="">-- Seleccione uno --</option>

                                <?php if ($_SESSION[constant('APP_NAME')]['user']['id_empresa'] === null || $_SESSION[constant('APP_NAME')]['user']['id_empresa'] === ''): ?>
                                    <?php foreach ($filter_combos as $cmb): ?>
                                        <option value="<?= $cmb['id_combo'] ?>"><?= $cmb['nom_combo'] ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($perfil as $cmb): ?>
                                        <option value="<?= $cmb['id_combo'] ?>"><?= $cmb['nom_combo'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </select>
                        </div>
                    </div>

                    <div class="input-group col-md-1">
                        <label>Buscar:</label>
                        <div class="input-group">
                            <button id="btnBuscar" type="button" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <?php if (!in_array($perfil_usr, [10, 11, 15, 16])) :?>
                    <div class="box-header with-border">
                        <button class="btn btn-primary btnAddSolicitud" data-toggle="modal" data-target="#modalAddSolicitud">
                            Agregar Solicitud
                        </button>
                    </div>
                <?php endif; ?>
                <div class="box-body">
                    <table id="tbl-solicitudes" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Solicitado Por</th>
                                <th>Candidato</th>
                                <th>Cédula</th>
                                <th>Cargo</th>
                                <th>Ciudad</th>
                                <th>Combo</th>
                                <!--<th>Servicios</th>-->
                                <!--<th>Responsable</th>-->
                                <th>Estado Proceso</th>
                                <th>Fch Solicitud</th>
                                <th>Fch Est Solución</th>
                                <th>Fch Preliminar</th>
                                <th>Fch Fin Solicitud</th>
                                <th>Fecha Crea</th>
                                <!--<th>Srv Ant</th>-->
                                <!--<th>Estado</th>-->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'vw.solicitud.modal.php' ?>
<?php include 'vw.solicitud.list.resumen.modal.php' ?>
<?php include 'vw.solicitud.list.ant.modal.php' ?>
<?php include 'vw.obs.calidad.edit.modal.php' ?>
<?php include 'vw.evaluado.resumen.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/sol/solicitud.js"></script>