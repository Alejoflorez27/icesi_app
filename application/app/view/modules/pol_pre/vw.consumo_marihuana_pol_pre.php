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

<!--<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="modal-header">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 center-block">
                                <h4 class="box-title">14. Consumo de Marihuana</h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_preg_marihuana_pol" name="id_preg_marihuana_pol" value="">



                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="col-xs-12 col-sm-10 center-block">
                                        <p>La marihuana es una es una mezcla de hojas secas, tallos, flores y semillas de la planta del cáñamo indico. Tiene un color normalmente verde, marrón o gris. <br>
                                        El hachís es una resina de color canela, marrón o negra que se seca y se prensa en barras, trozos o bolas. Cuando se fuma, tanto la marihuana como el hachís<br>
                                        emiten un aroma dulzón y característico. <br>
                                        El consumo de cannabis en forma de cigarrillo, canuto, porro,.. es el más conocido por la gran mayoría de personas que usan esta planta. De todas formas, hoy en día <br>
                                        es fácil de encontrar diferentes maneras de consumirla aspirando el humo como resultado de una combustión. Las pipas, cachimbas, bongs... son algunos ejemplos de esta <br>
                                        forma de consumo aunque entre ellas hay pequeñas diferencias como son la cantidad de humo aspirado o la prolongación de la aspiración y las toxinas producidas. También se  <br>
                                        puede consumir la marihuana mediante infusiones de leche, "tortas", "Sopas" o similares. <br>
                                        Muchas personas solo la han probado, o la han usado como estimulante para jornadas de trabajo o para incrementar la creatividad, si es su caso admítalo y Justifique su uso.

                                        </p>
                                    </div>
                                </div>


                                <!-- ENTRADA PARA LA PREGUNTA UNO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">1. Alguna vez en su vida a consumido marihuana en cualquier forma?*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_uno" name="pregunta_uno" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA DOS 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">2. Seleccione la ultima vez que lo hizo*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_dos" name="pregunta_dos" required>
                                                <!--<option value="A">Aceptó</option>
                                                <option value="N">Negó</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA TRES 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">3. Seleccione la primera vez que lo hizo*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_tres" name="pregunta_tres" required>
                                                <!--<option value="A">Aceptó</option>
                                                <option value="N">Negó</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA CUATRO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cuatro" class="control-label">4. Seleccione la frecuencia con la que consume*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_cuatro" name="pregunta_cuatro" required>
                                                <!--<option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA LA PREGUNTA CINCO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cinco" class="control-label">5. Alguna vez ha trabajado bajos de sustancias?*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_cinco" name="pregunta_cinco" required>
                                                <!--<option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA 6 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_seis" class="control-label">6. Comentarios del examinador - Información que aparecerá en el informe:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <textarea class="form-control input"  id="pregunta_seis" name="pregunta_seis" placeholder="Comentarios del examinador"></textarea>
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
</section>-->

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

                            <div class="div-Afisicos">
                                <input type="hidden" id="idCaracteristica">
                                    <div class="box-body">
                                        <center>
                                        <h3>ÁREAS DE RIESGO</h3>
                                        </center>
                                        <h4>14. Consumo de Marihuana</h4>
                                        <h5>Por favor explique cada tema, antes de hacer las preguntas:</h5>
                                        <p>Hablemos de la marihuana¡¡¡<br>
                                           El consumo de cannabis es frecuente en nuestra sociedad actual, se consume ya sea mediante el cigarrillo, pipas, porros, tortas entre otras. <br>  
                                           Muchas personas solo la han probado, o la usan como estimulante para jornadas de trabajo o para incrementar la creatividad, es una práctica común, cuénteme si es su caso y que experiencia ha tenido con ella.

                                        </p>
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

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_observacion" name="id_observacion" value="">
                                <!-- ENTRADA PARA INFORME POR VARIABLE --> 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="respuesta" class="control-label">Comentarios del examinador:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                            <textarea class="form-control input" id="respuesta" name="respuesta"></textarea>
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
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/consumo_marihuana_pol_pre.js"></script> 