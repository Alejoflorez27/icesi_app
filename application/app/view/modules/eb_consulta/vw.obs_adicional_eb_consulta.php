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
        <li><a href="solicitud/detalle?solicitud=<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-dashboard"></i> Antecedentes Documentales</a></li>
        <li class="active">Referencias Personales</li>
    </ol>
</section>

<section class="content-header">
<div class="box box-primary">
    <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">3.REFERENCIAS PERSONALES Y OBSERVACIÓN ADICIONAL</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formReferencias" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_ref_personal" name="id_ref_personal" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">

                    <!-- ENTRADA PARA REFERENCIA PERSONAL 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="referencia_personal" class="control-label">Referencia Personal: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="referencia_personal" name="referencia_personal" required></textarea>
                            </div>
                        </div>
                    </div> -->
                    <!-- ENTRADA PARA EL NOMBRE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombre: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NÙMERO DE TELEFONO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Telefono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="telefono" id="telefono" placeholder="Ingrese el telefono" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONCEPTO  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="concepto" name="concepto" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIÓN Y HALLAZGOS  
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="observacion_adicional" class="control-label">Observaciones Adicionales: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="observacion_adicional" name="observacion_adicional" required></textarea>
                            </div>
                        </div>
                    </div>-->

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-referencia" type="submit" class="btn btn-primary btnAddReferencia">Guardar</button>
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
                    <table id="tbl-referencias" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Concepto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="col-xs-12 col-sm-12 center-block">
                                <button class="btn btn-primary pull-left btnAddFamiliaObs" title="Dar Clic para Observación adicional" id="obsFamilia" type="button" data-toggle="modal" data-target="#modalAddObservacion">Observación Adicional</button>
                                <!--<p class="pull-left" id="viewObservacion"></p>-->
                            </div>
                            <!-- ENTRADA PARA OBSERVACIONES DE REFERENCIAS ADICIONALES -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="viewObservacion" class="control-label"></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input"  id="viewObservacion" name="viewObservacion" placeholder="Observaciones adicionales" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.obs_adicional_eb_consulta.modal.php' ?>
<?php include 'vw.observacion_eb_consulta.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/eb_consulta/obs_adicional_eb_consulta.js"></script>
