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
    <div class="col-xs-6 col-sm-6 center-block">

    <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="col-xs-6 col-sm-12 center-block">
                            <h4 class="box-title">3. BRECHAS O INACTIVIDAD LABORAL</h4>
                        </div>
                    <div class="box-header with-border">
                    </div>

                        <div class="box-body">
                            <table id="tbl-laboral" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Empresa</th>
                                        <th>Fecha de ingreso</th>
                                        <th>Fecha de retiro</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin de Distribución de la vivienda-->

        <!-- Distribución de la vivienda-->
        <section class="content-header">
        <div class="box box-primary">
            <div class="modal-header">
            </div>
            <form id="formBrechas" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_laboral_brechas" name="id_laboral_brechas" value="">

                    <div class="box-body">

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-9 center-block">
                                <p>1. Se encontrarón en la historia laboral del candidato, brechas o tiempos laborales de inactividad superiores a 2 meses (Si la respuesta es SI, escriba en la casillas que se activaran, cuáles fueron las brechas o periodos de inactividad encontrados, los tiempos aproximados y las fechas aproximadas?</p>
                            </div>

                            <!-- ENTRADA PARA NUMERO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="pregunta_uno" class="control-label"></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="pregunta_uno" name="pregunta_uno" required>
                                            <option value="" disabled selected style="display:none;">Seleccione</option>
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-9 center-block">
                                <p>2. Se validó información ante base de datos de seguridad social y se confirma que los periodos de inactividad corresponden a la realidad. </p>
                            </div>

                            <!-- ENTRADA PARA NUMERO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-3 center-block">
                                <div class="form-group">
                                    <label for="pregunta_dos" class="control-label"></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="pregunta_dos" name="pregunta_dos" required>
                                            <option value="" disabled selected style="display:none;">Seleccione</option>
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button id="btn-submit-brechas" type="submit" class="btn btn-primary btnAddBrechas">Guardar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>


    </div>


     <!-- Inicio otra Distribución de la vivienda-->
    <div  class="col-xs-6 col-sm-6 center-block">
        <!-- Distribución de la vivienda-->
        <section class="content-header">
        <div class="box box-primary">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm- center-block">
                        <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                        <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                    </div>
                </div>
            </div>
            <form id="formPeriodo" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_laboral_periodos" name="id_laboral_periodos" value="">

                    <div class="box-body">

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="periodo" class="control-label">Periodo de inactividad: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="periodo" name="periodo" disabled required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DOTACION MOBILIARIA -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="tmp_periodo" class="control-label">Tiempo aproximado del periodo: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="tmp_periodo" name="tmp_periodo" disabled required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA INFORME POR VARIABLE  -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción (por que se dio esta inactivada y que actividades realizó durante este periodo): *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <textarea class="form-control input" id="descripcion" name="descripcion" disabled required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div style="color:red;">
                                Campos señalados con * son obligatorios
                            </div>                    

                            <div class="modal-footer">
                                <button id="btn-submit-periodo" type="submit" class="btn btn-primary btnAddperiodo">Guardar</button>
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
                            <table id="tbl-laboralBrechas" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Periodo</th>
                                        <th>Tiempo aproximado del periodo</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin de Distribución de la vivienda-->
    </div>

</div>



<?php include 'vw.brechas_laboral_ver_laboral.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ver_laboral/brechas_laboral_ver_laboral.js"></script>
