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
                                <h4 class="box-title">19. ANTECEDENTES</h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_preg_com_delitos_pol" name="id_preg_com_delitos_pol" value="">



                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="col-xs-12 col-sm-10 center-block">
                                    <p>Hace referencia a haber incurrido en cualquier momento de la vida, en la comisión de cualquier conducta tipificada como violatorio de la ley en el Código de procedimiento penal, en el Código de policía o en la constitución política. <br>
                                        Un delito se puede cometer por acción u omisión, e implica haber incurrido en cualquiera de las etapas necesarias para su ejecución: planeación, colaboración, comisión, encubrimiento, beneficio, etc. Pudo haber sido procesado judicialmente o como nunca ser descubierto o haber sido procesado. <br>
                                        De acuerdo a su tipo, los delitos pueden estar incluidos dentro de las siguientes categorías (sin estar limitados a las mismas): <br>
                                        CONTRA LA VIDA: Homicidio, Lesiones Personales (Golpear a alguien), Secuestro, Desaparición Forzada, Actos sexuales abusivos, Proxenetismo, Trata de Personas. <br>
                                        CONTRA EL PATRIMONIO: Robo o hurto, Asaltos, Extorsiones, Estafas, Fraudes, Contrabando, Lavado de activos, Falsificación de dinero, suplantación de personas, Incendio, Vandalismo. <br>
                                        ROBO CUELLO BLANCO. Peculado (apropiarse de dineros), Malversación, Cohecho (soborno a Evaluados púbicos). Celebración Indebida de Contratos, Prevaricato, Perjurio, Robos a gobierno.
                                        DELITOS MENORES EDAD: Abuso Sexual, Explotación o mendicidad, Trafico de un menor,
                                        pornografía, Abandono de un menor. <br>
                                        OTROS DELITOS: Terrorismo, Trafico o distribución de armas, Porte legal de armas, Trafico de drogas, Rebelión- Sedición o Asonada, Genocidio Omisión de socoro. Fraude electrónico o computarizado, Hackeo o crackeo de software o sistemas informáticos, Violación de comunicaciones, Falsificación de documentos públicos o privados. <br>
                                        Los delitos pueden tener motivaciones económicas. políticas, ideológicas o pueden ser llevados a cabo solo o acompañados. <br>
                                        Los delitos no necesariamente implican que usted haya sido judicializado. Estos delitos pueden haber sido o no descubierto.
                                    </p>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA UNO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">1. Ha cometido usted algún delito? *</label>
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
                                        <label for="pregunta_dos" class="control-label">2. Alguna vez ha sido citado en una comisaria,juzgado, inspección o fiscalia? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_dos" name="pregunta_dos" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA TRES 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">3. Alguna vez ha sido detenido en CAI, URI, INSPECCIONES o cualquier otro lugar una autoridad civil o militar por más de 12 horas? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_tres" name="pregunta_tres" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA CUATRO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cuatro" class="control-label">4. Alguna vez ha participado en disturbios? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <select class="form-control input select2" id="pregunta_cuatro" name="pregunta_cuatro" required>
                                                <option value="A">Aceptó</option>
                                                <option value="N">Negó</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA CINCO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cinco" class="control-label">6. Comentarios del examinador - Información que aparecerá en el informe:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <textarea class="form-control input"  id="pregunta_cinco" name="pregunta_cinco" placeholder="Comentarios del examinador"></textarea>
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
</section> -->
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
                                        <h4>19. ANTECEDENTES</h4>
                                        <h5>Por favor explique cada tema, antes de hacer las preguntas:</h5>
                                        <!--<h4>ludopatía:</h4>
                                        <p>La ludopatía es un trastorno en el que la persona se ve obligada, por una urgencia psicológica e incontrolable a jugar y apostar en un casino u otro sistema de apuestas, de forma persistente y progresiva, afectando de forma negativa a la vida personal, familiar y vocacional.
                                        </p>-->
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
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/antecedentes_pol_pre.js"></script> 