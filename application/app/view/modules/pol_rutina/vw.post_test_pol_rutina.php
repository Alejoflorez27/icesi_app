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

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="modal-header">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 center-block">
                                <h4 class="box-title">16. POST-TEST</h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_post_test" name="id_post_test" value="">

                                <!-- Si aplica Post Test -->
                                <div class="col-xs-6 col-sm-2 form-group form-check">
                                    <br>
                                    <input type="checkbox" class="form-check-input" id="aplica" name="aplica" value="0">
                                    <label class="form-check-label" for="aplica">Aplica Post Test</label>
                                </div>

                                <!-- ENTRADA PARA EL post_test -->
                                <div class="col-xs-12 col-sm-12 center-block" id="ocultar">
                                    <div class="form-group">
                                        <label for="post_test" class="control-label"><br>Post - Test</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input"  id="post_test" name="post_test"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA EL comportamiento -->
                                <div class="col-xs-12 col-sm-12 center-block" id="ocultar1">
                                    <div class="form-group">
                                    <div class="col-xs-12 col-sm-8 center-block">
                                        <h4 class="box-title">CALIDAD DE LOS DATOS (GRÁFICAS)</h4>
                                    </div>
                                        <label for="comportamiento" class="control-label"><br>El comportamiento del evaluado durante aplicación de la prueba con el polígrafo (gráficas) fue: </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input"  id="comportamiento" name="comportamiento"></textarea>
                                        </div>
                                    </div>
                                </div>

                            <!-- ENTRADA PARA -->
                            <div class="col-xs-12 col-sm-12 center-block" id="ocultar2">
                                <div class="form-group">
                                    <label for="tipo_datos" class="control-label">Por lo tanto, en los datos fisiológicos obtenidos durante esta evaluación se observó que los registros (gráficos) se consideran: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="tipo_datos" name="tipo_datos" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA -->
                            <div class="col-xs-12 col-sm-12 center-block">
                            <div class="modal-footer">
                                    <button id="btn-submit-observacion" type="submit" class="btn btn-primary btnAddObservacion">Guardar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/pol_rutina/post_test_pol_rutina.js"></script> 