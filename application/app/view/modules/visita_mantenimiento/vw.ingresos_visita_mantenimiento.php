<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$servicioId = $router->param('id_servicio');
$resp_menu = CtrMenuFormatos::findAll($servicioId);
//print_r($resp_menu);

$servicio = null;
if (Result::isSuccess($resp_menu))
    $servicio = Result::getData($resp_menu);
//print_r($servicio);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>
  <section class="content-header">
    <div class="row">
      <div class="col-xs-12 col-sm-8">
        <h3>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h3>
      </div>

      <div class="col-xs-12 col-sm-4">
        <div class="box box-primary collapsed-box" style="position: absolute; top: 0; right: 0; z-index: 9999;">
          <div class="box-header with-border">
            <h3 class="box-title">MENÚ <?= $servicio[0]['nom_servicio'] ?></h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool btn-primary" data-widget="collapse"><i class="fa fa-bars"></i></button>
              <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
            </div>
          </div>

          <div class="box-body">
            <!-- Contenido de tu tabla -->
            <ul>
              <!-- <h1></h1>  -->
              <?php 
                foreach ($servicio as $file) : ?>
                    

                    <li style="margin-left:0px;">
                        <a href="<?= $file['url']. '?id_solicitud='.$solicitudId.'&id_servicio='.$servicioId ?>"><?= $file['nombre'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

          </div>

          <div class="box-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-flat pull-left" data-widget="collapse">Cerrar</a>
            <button id="btn-submit-solicitud" type="submit" class="btn btn-sm btn-success btnSolicitudVolver">Solicitud</button>
          </div>
        </div>
      </div>
    </div>
  </section>

<div class="row">
    <div class="col-md-6 col-12">
    <section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-9 center-block">
                <h4 class="box-title">10. INGRESOS MENSUALES DEL EVALUADO (Y CONYUGUE SI APLICA) </h4>
            </div>
            <!--<div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>-->
        </div>
    </div>
    <form id="formVivIngresos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_ingreso" name="id_ingreso" value="">
                <input type="hidden" id="id_candidato" name="id_candidato" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">


            <div class="box-body">

                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y EVALUADO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                        <h4 id="salario">El salario actual del funcionario (a)</h4>
                            <label for="tipo_familiar" class="control-label">Integrante: *
                                <button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input select2" id="tipo_familiar" name="tipo_familiar" required>
                                </select>-->
                                <input type="text" class="form-control input" name="tipo_familiar" id="tipo_familiar" placeholder="Integrante de la familia" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE INGRESOS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="valor_ingreso" class="control-label">Valor Ingreso ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_ingreso" id="valor_ingreso" placeholder="Valor de Ingresos" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE APORTE 
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="valor_aporte" class="control-label">Valor Aporte ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_aporte" id="valor_aporte" placeholder="Valor Aporte" required>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA  DE DONDE PROVIENE -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="ingreso_proveniente" class="control-label">Donde Proviene: *
                                <button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda1">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="ingreso_proveniente" id="ingreso_proveniente" placeholder="De Donde Proviene" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-vivIngresos" type="submit" class="btn btn-primary btnAddVivIngresos">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
            <div class="box-header with-border">
                </div>

                <div class="box-body">
                    <table id="tbl-vivIngresos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Integrante de la Familia</th>
                                <th>Valor Ingreso</th>
                                <!--<th>Valor Aporte </th>-->
                                <th>Donde Proviene </th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h2><strong>Total Ingresos:</strong></h2>
                        </div>
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h1 id="total_ingreso"></h1>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 center-block" style="margin-left: 40px;">
                            <br>
                            <h3><strong>&nbsp;&nbsp;INCREMENTOS SALARIALES DESDE LA ÚLTIMA VISITA</strong></h3>
                    </div>
                    <form id="formSalarioAnterior" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                    <!-- ENTRADA PARA EL INGRESO DEL SALARIO ANTERIOR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="salario_anterior" class="control-label">Salario Anterior del Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="salario_anterior" id="salario_anterior" placeholder="Salario Anterior" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-salarioAnterior" type="submit" class="btn btn-primary btnAddSalarioAnterior">Guardar</button>
                    </div>
                    </form>
                    <table id="tbl-salario" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>SALARIO ANTERIOR</th>
                                <th>SALARIO ACTUAL</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
    </div>
     <!-- Inicio otra Egresos de la vivienda-->
     <div  class="col-md-6 col-12">
        <?php include 'vw.egresos_visita_mantenimiento.php' ?>
    </div>
</div>


<?php include 'vw.ingresos_visita_mantenimiento.modal.php' ?>
<?php include 'vw.ayuda_visita_mantenimiento.modal.php' ?>
<?php include 'vw.ayuda1_visita_mantenimiento.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_mantenimiento/ingresos_visita_mantenimiento.js"></script>
