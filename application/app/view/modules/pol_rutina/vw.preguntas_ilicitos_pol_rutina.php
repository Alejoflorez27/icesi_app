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
                            
                            <div class="div-Afisicos">
                                <input type="hidden" id="idCaracteristica">
                                <input type="hidden" id="lista_emp_poli">
                                <input type="hidden" id="id_empresa" value="<?= $solicitud['id_empresa'] ?>">
                                    <div class="box-body">
                                    <center>
                                        <h3>ÁREAS DE RIESGO</h3>
                                        </center>
                                        <h4>10. Preguntas de Verificación de Ilícitos en el empleo actual <br><br>
                                            Conducta laboral actual: </h4>
                                        <h5>Por favor explique cada tema, antes de hacer las preguntas:</h5>
                                        <p>Los empleadores generalmente son realistas respecto de que algunas conductas sucedan dentro de 
                                            sus organizaciones, lo importante es poder valorar su sinceridad respecto de las situaciones <strong>que 
                                            pueden estar ocurriendo en su empleo actual</strong>, entenderlas y explicarlas si admite alguna o varias 
                                            conductas, al final contará con un espacio para que pueda explicar las circunstancias de por qué 
                                            sucedieron. Le animamos a ser sincero y de esta forma evitar reaccionar en la sesión que tendrá 
                                            validación fisiológica. La mayoría de <strong>funcionarios</strong> admiten mas de una conducta de las que se le 
                                            preguntaran a continuación:
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

                                <!-- <input type="hidden" id="id_preg_ilicito_pol" name="id_preg_ilicito_pol" value="">

                                <!-- ENTRADA PARA LA PREGUNTA UNO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">¿Ha llegado a tener algún problema con sus jefes? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input" id="pregunta_uno" name="pregunta_uno" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA DOS 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">Ve algun riesgo que pueda afectar a la empresa *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_dos" name="pregunta_dos" required>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA TRES 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">Amplie información del riesgo percibido *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input" id="pregunta_tres" name="pregunta_tres" required></textarea>
                                        </div>
                                    </div>
                                </div>-->

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
<script src="<?= constant('APP_URL') ?>app/js/pol_rutina/preguntas_ilicitos_pol_rutina.js"></script> 