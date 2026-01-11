<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>
<section class="content-header">
    <h1>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="solicitud/detalle?solicitud=<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-dashboard"></i> vinculo con personas ilegales</a></li>
        <li class="active">Sanciones Laborales</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="modal-header">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 center-block">
                                <h4 class="box-title">12. SANCIONES LABORALES</h4>
                            </div>
                            <div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>
                            
                        <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" id="accion" name="accion" value="">
                            <input type="hidden" id="id_preg_sancion_pol" name="id_preg_sancion_pol" value="">
                                <br>
                                <br>
                                <br>
                                <!-- ENTRADA PARA LA PREGUNTA UNO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_uno" class="control-label">¿Ha recibido sanciones escritas memorandos, llamados de atención o ha sido objeto de investigaciones administrativas o disciplinarias por actos cometidos en contra de la empresa?</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_uno" name="pregunta_uno" required>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA DOS -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_dos" class="control-label">Explique:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input" id="pregunta_dos" name="pregunta_dos" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA TRES -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_tres" class="control-label">¿Usted ha tenido alguna falla en el cumplimiento de sus funciones? *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <select class="form-control input select2" id="pregunta_tres" name="pregunta_tres" required>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- ENTRADA PARA LA PREGUNTA CUATRO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cuatro" class="control-label">Explique:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input" id="pregunta_cuatro" name="pregunta_cuatro" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="div-Afisicos">
                                    <input type="hidden" id="idCaracteristica">
                                        <div class="box-body">
                                        <br><br>
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

                                <!-- ENTRADA PARA LA PREGUNTA CINCO -->
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="pregunta_cinco" class="control-label">Ampliación de por que ha recibido estas sanciones *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                            <textarea class="form-control input" id="pregunta_cinco" name="pregunta_cinco" required></textarea>
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
<script src="<?= constant('APP_URL') ?>app/js/pol_especifico/preguntas_sancion_laboral_pol_especifico.js"></script> 