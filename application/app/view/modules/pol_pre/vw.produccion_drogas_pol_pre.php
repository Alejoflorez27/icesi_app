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

<!-- <section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="modal-header">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 center-block">
                                <h4 class="box-title">15. Producción – Almacenamiento- transporte- venta de drogas ilegales todas incluyendo Marihuana.</h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_preg_pro_drogas_pol" name="id_preg_pro_drogas_pol" value="">



                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="col-xs-12 col-sm-10 center-block">
                                    <p>En cuanto al cultivo y producción de drogas legales, mentir implica haber omitido información acerca de cualquier participación, directa o indirectamente en el procesamiento de drogas, sean sintéticas o sean cultivadas, en actividades relacionadas como haber servido de raspachin.<br>
                                        Almacenar drogas licitas en cualquier forma excediendo las cantidades admitidas por la ley para uso personal son consideradas conductas de almacenamiento sin importar el tiempo de almacenamiento. <br>
                                        En cuanto al transporte de drogas legales, mentir consiste por ejemplo en no informar acerca de movilizaciones de drogas legales, que incluyen transportes dentro de la misma ciudad, el país u otros países, a cambio de algún beneficio o sin que haya existido este beneficio. Estos transportes pueden o no haber tenido una motivación económica, pueden haber sido retribuidos en especie, en favores o privilegios, o pueden no haber sido retribuidos de ninguna forma. <br>
                                        Mentir con relación a la venta de drogas legales se refiere a no informar, omitir, alterar o cambiar información con relación a cualquier tipo de trato o negociación que tenga de por medio drogas ilegales; puede haber implicado beneficio económico material o de cualquier otra especie. Puede haberse dado en pequeñas, medianas o grandes cantidades, puede haberse realizado de manera ocasional esporádica o permanente: puede haberse dado a nivel de colaboración encubrimiento o realizado directa y personalmente la venta.
                                    </p>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA UNO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">1. Alguna vez en su vida ha participado de alguna forma en el cultivo, transporte o venta de drogas ilícitas con base a la anterior información?</label>
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
                                        <label class="control-label">2. Seleccione las actividades que mas apliquen:*</label>
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

                                <!-- ENTRADA PARA LA PREGUNTA DOS 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">3. Seleccione la ultima vez que lo hizo *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_dos" name="pregunta_dos" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA TRES 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">4. Seleccione la frecuencia con la que lo hizo *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_tres" name="pregunta_tres" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA CUATRO 
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cuatro" class="control-label">5. Comentarios del examinador - Información que aparecerá en el informe:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                            <textarea class="form-control input"  id="pregunta_cuatro" name="pregunta_cuatro" placeholder="Comentarios del examinador"></textarea>
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
                                        <h4>15. Producción – Almacenamiento- transporte- venta de drogas ilegales todas incluyendo Marihuana</h4>
                                        <h5>Por favor explique cada tema, antes de hacer las preguntas:</h5>
                                        <p>Abordar consumo de otras sustancias alucinógenas a parte de la marihuana y otro tipo de contacto que haya tenido el evaluado con drogas ilegales como venta, tráfico, procesamiento, almacenamiento y actividades de narcotráfico. <br>
                                            Participación, directa o indirectamente en el procesamiento de drogas, sean sintéticas o sean cultivadas

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
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/produccion_drogas_pol_pre.js"></script> 