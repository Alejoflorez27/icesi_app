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
                                <input type="hidden" id="id_preg_pers_ilegales_pol" name="id_preg_pers_ilegales_pol" value="">



                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="col-xs-12 col-sm-10 center-block">

                                    <center>
                                        <h3>ÁREAS DE RIESGO</h3>
                                    </center>
                                        <h4>17. Vínculo ilícitos con personas al margen de la ley</h4>
                                        <h5>Por favor explique cada tema, antes de hacer las preguntas:</h5>
                                        <p>Colombia es un país que tiene unas circunstancias de seguridad y orden público complejo, la mayoría de las empresas son realistas respecto que es común que los evaluados en algún momento hayan tenido contacto de alguna manera con alguien al margen de la ley. <br>
                                            Usted puede reaccionar cuando presente la prueba de detección fisiológica si omitió dar información acerca de cualquier relación, directa o indirecta que se tenga o se haya tenido, con personas, organizaciones o grupos, que cometan algún tipo de acción penalizada por la ley y considera como delito. <br>
                                            Esta relación puede ser a nivel: <br>
                                            familiar, sentimental, laboral, de amistad, de vecindad, de conocimiento, comunicación, participación, encubrimiento y/o beneficio de las actividades irregulares desarrolladas por esas personas o grupos. <br>
                                            Puede tratarse de parientes o amigos que hayan optado por el ejercicio de actividades legales así uno mismo no haya tenido nada que ver al respecto o no mantenga contacto o comunicación permanente con esta o estas personas. <br>
                                            Puede tratarse de vecinos con los que uno tenga un contacto limitado al saludo, y de quienes se sabe o se tiene una fuente sospecha que están al margen de la ley. <br>
                                            Puede tratarse de un vínculo en el que uno participe, colabore, se entere, encubra, se beneficie o se relaciones de cualquier forma con los delitos cometidos por este tipo de personas. Puede ser un vínculo actual o del pasado e incluye situaciones de esta naturaleza que le hayan ocurrido a familiares.
                                            <br><br>
                                        </p>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA UNO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">1. Ha tenido usted vinculo con personas al margen de la Ley.</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_uno" name="pregunta_uno" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                                                <!-- ENTRADA PARA LA PREGUNTA TRES -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">1. ¿ha participado usted en actividades ilícitas con personas al margen de la ley? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_tres" name="pregunta_tres" required>
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
                                        <label class="control-label">2. ¿Con quien tiene vínculos?:*</label>
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

                                <div class="div-Avinculo">
                                    <input type="hidden" id="idCaracteristicaVinculo">
                                        <div class="box-body">
                                        <br><br>
                                        <label class="control-label">3. Clase de vinculos:*</label>
                                            <table id="tbl-Avinculo" class="table table-bordered table-striped " width="100%">
                                                <thead>
                                                    <tr>
                                                        <td colspan="2" id="aspectosvinculo" ></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" id="vinculo-desc"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-Avinculo-combo"> </tbody>
                                            </table>
                                        </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA DOS -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">4. Cuando fue la última vez que tuvo contacto *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <input type="text" class="form-control input" id="pregunta_dos" name="pregunta_dos" required>
                                            </input>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA TRES 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">5. Seleccione la frecuencia con la que tenia contacto *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_tres" name="pregunta_tres" required>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->


                                

                                <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA CUATRO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cuatro" class="control-label">5. Comentarios del examinador:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <textarea class="form-control input"  id="pregunta_cuatro" name="pregunta_cuatro" placeholder="Comentarios del examinador"></textarea>
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
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/vinculo_personas_ilegales_pol_pre.js"></script> 