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
                                <h4 class="box-title">22. ¿Información complementaria?</h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_preg_como_hv_pol" name="id_preg_como_hv_pol" value="">


                                <!-- ENTRADA PARA LA PREGUNTA UNO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">1. ¿Cómo se enteró del proceso de selección, en esta empresa?: *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <input type="text" class="form-control input" id="pregunta_uno" name="pregunta_uno" required>
                                            </input>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA DOS -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">2. ¿Conoce a alguien que trabaje en la empresa?  *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_dos" name="pregunta_dos" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="ocultar">
                                    <!-- ENTRADA PARA LA PREGUNTA TRES -->
                                    <div class="col-xs-12 col-sm-12 center-block">
                                        <div class="form-group">
                                            <label for="pregunta_tres" class="control-label">3. Nombre de la persona que trabaja en la empresa *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                                <input type="text" class="form-control input" id="pregunta_tres" name="pregunta_tres" required></input>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ENTRADA PARA LA PREGUNTA CUATRO -->
                                    <div class="col-xs-12 col-sm-12 center-block">
                                        <div class="form-group">
                                            <label for="pregunta_cuatro" class="control-label">4. Cargo de la persona que trabaja en la empresa *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                                <input type="text" class="form-control input" id="pregunta_cuatro" name="pregunta_cuatro" required></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA CINCO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cinco" class="control-label">5. ¿Tiene algún vínculo con alguien (familiar o amigo) que trabaje en una empresa del mismo sector (empresas de la competencia) ? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_cinco" name="pregunta_cinco" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="ocultar_kaizen">
                                    <div class="col-xs-12 col-sm-12 center-block">
                                        <div class="form-group">
                                            <label for="pregunta_kaizen" class="control-label">5.1. ¿Usted ha trabajado con empresas, o tiene familiares que trabajen con empresas y con actividades similares a proyectos de metalmecánica, proyectos hidráulicos y demás? *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                                <input type="text" class="form-control input" id="pregunta_kaizen" name="pregunta_kaizen" required></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CONTENEDOR PARA LA PREGUNTA SEIS -->
                                <div id="ocultar_dos">

                                    <div class="col-xs-12 col-sm-12 center-block">
                                        <div class="form-group">
                                            <label for="pregunta_seis" class="control-label">6. Nombre de la persona *</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                                <input type="text" class="form-control input" id="pregunta_seis" name="pregunta_seis" required></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA LA PREGUNTA SIETE -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_siete" class="control-label">7. ¿Es la primera vez que se postula a esta empresa? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <input type="text" class="form-control input" id="pregunta_siete" name="pregunta_siete" required></input>
                                        </div>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA LA PREGUNTA OCHO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_ocho" class="control-label">8. Cargo *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <input type="text" class="form-control input" id="pregunta_ocho" name="pregunta_ocho" required></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-submit-observacion" type="submit" class="btn btn-primary btnAddObservacion">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/como_hoja_vida_pol_pre.js"></script> 