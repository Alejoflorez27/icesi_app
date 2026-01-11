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
                                <h4 class="box-title"></h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_preg_info_falsa_pol" name="id_preg_info_falsa_pol" value="">



                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="col-xs-12 col-sm-12 center-block">

                                    <center>
                                        <h3>ÁREAS DE RIESGO</h3>
                                    </center>
                                    <h4>20. Información falsa, modificada, mejorada o con omisiones.</h4>
                                    <h5>Por favor explique cada tema, antes de hacer las preguntas:</h5>
                                        
                                    <p>
                                        Es común que dentro de los procesos de selección las personas omitan, cambien, mejoren la información presentada, en un entono altamente competitivo algunas personas sienten presión por modificar o mejorar su información. <br>
                                        <br><strong>Algunas de las conductas más comunes son: </strong><br><br>
                                        <strong>1.</strong> Omitir intencionalmente empleos. <br>
                                        <strong>2.</strong>  Cambiar fechas de los mismos. <br>
                                        <strong>3.</strong>  Haber conseguido certificaciones de empresas con amigos o familiares. <br>
                                        <strong>4.</strong>  Modificar cargo, funciones y/o responsabilidades. <br>
                                        <strong>5.</strong>  Cambiar el valor de los ingresos recibidos. <br>
                                        <strong>6.</strong>  Elaborar certificaciones académicas falsas. <br>
                                        <strong>7.</strong>  Comprar diplomas o certificados de estudio. <br>
                                    </p>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA UNO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">1. Presentó usted en la información de su solicitud de empleo información, falsa, adulterada, imprecisa o con omiciones intencionales.</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_uno" name="pregunta_uno" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="div-Afisicos">
                                    <input type="hidden" id="idCaracteristica">
                                        <div class="box-body">
                                        <br><br>
                                        <label class="control-label">2. Seleccione las conductas que apliquen:*</label>
                                            <table id="tbl-Afisicos" class="table table-bordered table-striped " width="100%">
                                                <thead>
                                                    <tr>
                                                        <td colspan="2" id="aspectos" ></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" id="fisicos-desc"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-Afisicos-combo"> </tbody>
                                            </table>
                                        </div>
                                </div>

                                <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA DOS -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">3. Comentarios del examinador - Información que aparecerá en el informe:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <textarea class="form-control input"  id="pregunta_dos" name="pregunta_dos" placeholder="Comentarios del examinador"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-2 form-group form-check">
                                    <br>
                                    <input type="checkbox" class="form-check-input" id="admitio" name="admitio" value="0">
                                    <label class="form-check-label" for="admitio">El Evaluado Admite</label>
                                </div>

                                <!-- ENTRADA PARA INFORME POR VARIABLE --> 
                                <div class="col-xs-12 col-sm-10 center-block" id="ocultar">
                                    <div class="form-group">
                                        <label for="resumen" class="control-label">Admisiones el evaluados:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                            <textarea class="form-control input" id="resumen" name="resumen"></textarea>
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
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/info_falsa_pol_pre.js"></script> 