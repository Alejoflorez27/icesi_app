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
        <li><a href="solicitud/detalle?solicitud=<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-dashboard"></i> Activos del Evaluado y Familia</a></li>
        <li class="active">Análisis de reportes en centrales</li>
    </ol>
</section>

<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">10. ANÁLISIS DE REPORTE EN CENTRALES</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formVivFinanciero" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_financiero" name="id_financiero" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                

            <div class="box-body">

                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="persona_evaluada" class="control-label">Persona Evaluda (cadidato/Familiar): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="persona_evaluada" name="persona_evaluada" required>
                                </select>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="concepto_financiero" class="control-label">Aspecto consultado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2 " id="concepto_financiero" name="concepto_financiero" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CONCEPTO FINANCIERO COMPLETO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="concepto_financiero_completo" class="control-label">Descripción del aspecto consultado:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="concepto_financiero_completo" name="concepto_financiero_completo" placeholder="Descripción completa de aspecto consultado" readonly=»readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE ESTADO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estado" class="control-label">Se Encuentra Reportado (Si/No): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="estado" name="estado" required>
                                <option value="selecione"> Se Encuentra Reportado</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIONES -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="descripcion_financiero" class="control-label">Observaciones: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="descripcion_financiero" name="descripcion_financiero" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-vivFinanciero" type="submit" class="btn btn-primary btnAddVivFinanciero">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
            <div class="box-header with-border">
                </div>

                <div class="box-body">
                    <table id="tbl-vivFinanciero" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <!--<th>Persona Evaluada</th>-->
                                <th>Aspecto Consultado</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.financiero_pol_especifico.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_especifico/financiero_pol_especifico.js"></script>
