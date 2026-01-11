<?php
$solicitudId = $router->param('id_solicitud');
//$resp = CtrSolSolicitud::findById($solicitudId);

$servicioId = $router->param('id_servicio');
//$resp_menu = CtrMenuFormatos::findAll($servicioId);
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
    <h1>Configuración SLA</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="modal-header">
                        <div class="row">

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_sla " name="id_sla " value="">

 
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <center><h1 class="box-title" style="font-weight: bold;">Semaforo</h1></center>
                                        <br><br>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <center><h1 class="box-title" style="font-weight: bold;">Inicio %</h1></center>
                                        <br><br>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <center><h1 class="box-title" style="font-weight: bold;">Fin %</h1></center>
                                        <br><br>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <br>
                                        <center><strong><h1 class="box-title" style="color: green; font-weight: bold;">Verde</h1></strong></center>
                                    </div>

                                    <!-- ENTRADA PARA LA PREGUNTA UNO -->
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="inicio_verde" class="control-label"></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>
                                                <input type="text" class="form-control input solo-numero" id="inicio_verde" name="inicio_verde" required>
                                                </input>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA DOS -->
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="fin_verde" class="control-label"></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-hourglass-3"></i></span>
                                                <input type="text" class="form-control input solo-numero" id="fin_verde" name="fin_verde" required>
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <br>
                                    <center><strong><h1 class="box-title" style="color: #CCCC00; font-weight: bold;">Amarillo</h1></strong></center>
                                    </div>

                                    <!-- ENTRADA PARA LA PREGUNTA UNO -->
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="inicio_amarillo" class="control-label"></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>
                                                <input type="text" class="form-control input solo-numero" id="inicio_amarillo" name="inicio_amarillo" readonly>
                                                </input>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA DOS -->
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="fin_amarillo" class="control-label"></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-hourglass-3"></i></span>
                                                <input type="text" class="form-control input solo-numero" id="fin_amarillo" name="fin_amarillo" required>
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <br>
                                    <center><strong><h1 class="box-title" style="color: red; font-weight: bold;">Rojo</h1></strong></center>
                                    </div>

                                    <!-- ENTRADA PARA LA PREGUNTA UNO -->
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="inicio_rojo" class="control-label"></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-hourglass-start"></i></span>
                                                <input type="text" class="form-control input solo-numero" id="inicio_rojo" name="inicio_rojo" readonly>
                                                </input>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ENTRADA PARA COMENTARIOS LA PREGUNTA DOS -->
                                    <div class="col-xs-12 col-sm-4 center-block">
                                        <div class="form-group">
                                            <label for="fin_rojo" class="control-label"></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-hourglass-3"></i></span>
                                                <input type="text" class="form-control input solo-numero" id="fin_rojo" name="fin_rojo" required>
                                                </input>
                                            </div>
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
<script src="<?= constant('APP_URL') ?>app/js/sol/sla.js"></script> 