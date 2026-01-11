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
        <h3>Empresa <strong><?= $solicitud['razon_social'] ?></strong></h3>
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

<section class="content-header">
<div class="box box-primary">
    <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-6 center-block">
                <h4 class="box-title">9. CONCEPTO FINAL</h4>
            </div>
            <div class="col-xs-12 col-sm-6 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>

    </div>
    <!--<form id="formCandidato" role="form" method="post" enctype="multipart/form-data" autocomplete="off">-->
    <form id="formVivConceptoProfesional" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_concepto" name="id_concepto" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">
                            <!-- ENTRADA PARA PREGUNTA UNO -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="pregunta_uno" class="control-label">¿Cómo califica los aspectos y controles de seguridad evidenciados?: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="pregunta_uno" name="pregunta_uno" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA PREGUNTA DOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="pregunta_dos" class="control-label">¿Se evidencia buena atención al cliente?: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="pregunta_dos" name="pregunta_dos" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA OTRO POR QUE 2 -->
                            <div class="col-xs-12 col-sm-6 center-block" id="ocultar_dos">
                                <div class="form-group">
                                    <label for="otro_dos" class="control-label">¿Se evidencia buena atención al cliente?. Si es Otro ¿Por que?:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" id="otro_dos" name="otro_dos" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA PREGUNTA TRES 
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="pregunta_tres" class="control-label">Evidencio que las personas con las que trata comercialmente no son personas inexistentes:*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="pregunta_tres" name="pregunta_tres" required>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <!-- ENTRADA PARA OTRO POR QUE 3 
                            <div class="col-xs-12 col-sm-6 center-block" id="ocultar_tres">
                                <div class="form-group">
                                    <label for="otro_tres" class="control-label">Evidencio que las personas con las que trata comercialmente no son personas inexistentes. Si es Otro ¿Por que?:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" id="otro_tres" name="otro_tres" required></textarea>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <h4><br><strong>CONCEPTO DEL FUNCIONARIO QUE REALIZA LA VISITA</strong><br> <br></h4>
                            </div>
                            
                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="asociado_confiable" class="control-label">Asociado Confiable: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="asociado_confiable" name="asociado_confiable" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA REQUISITO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="requisito" class="control-label">¿El asociado autoriza la toma de registro fotográfico? Enuncie las restricciones si las hay.: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="requisito" name="requisito" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA OBSERVACIONES -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="observacion" class="control-label">Observaciones: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" style="height: 200px;" id="observacion" name="observacion"></textarea>
                                    </div>
                                </div>
                            </div>

                        <div class="col-xs-12 col-sm-12 center-block">
                            <div style="color:red;">
                                Campos señalados con * son obligatorios
                            </div>  
                        </div>                  
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="modal-footer">
                                <button id="btn-submit-vivConceptoProfesional" type="submit" class="btn btn-primary btnAddConceptoProfecional">Guardar</button>
                            </div>
                        </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<script src="<?= constant('APP_URL') ?>app/js/visita_asociado/conceptoProfesional_visita_asociado.js"></script>
