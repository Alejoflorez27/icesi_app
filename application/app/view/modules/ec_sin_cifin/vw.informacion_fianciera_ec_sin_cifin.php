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
        <li class="active">Confiabilidad Financiera</li>
    </ol>
</section>
<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">3. CONFIABILIDAD FINANCIERA/CIFIN - CRÉDITOS Y OBLIGACIONES FINANCIERAS</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formInfoFinanciera" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_info_obl_fin" name="id_info_obl_fin" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                
            <div class="box-body">

                    <!-- ENTRADA PARA NOMBRE DE LA ENTIDAD -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="entidad" class="control-label">Nombre de la entidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="entidad" id="entidad" placeholder="Nombre de la entidad" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PRODUCTO Y CLASE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="producto_clase" class="control-label">Producto y clase: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="producto_clase" id="producto_clase" placeholder="Ingrese producto y clase" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE EXPEDICION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_expedicion" class="control-label">Fecha de expedición: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="date" class="form-control input" name="fch_expedicion" id="fch_expedicion" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE TERMINACION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_terminacion" class="control-label">Fecha de terminación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="date" class="form-control input" name="fch_terminacion" id="fch_terminacion" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CUPO INICIAL DE CREDITO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="cupo_inicial" class="control-label">Cupo inicial de crédito($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="cupo_inicial" id="cupo_inicial" placeholder="Cupo inicial" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA SALDO PENDIENTE -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="saldo_pendiente" class="control-label">Saldo pendiente($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="saldo_pendiente" id="saldo_pendiente" placeholder="Saldo pendiente" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PAGO MINIMO MENSUAL -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="pago_minimo" class="control-label">Pago mínimo mensual($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="pago_minimo" id="pago_minimo" placeholder="Pago mínimo mensual" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ESTADO DE LA OBLIGACION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="estado_obligacion" class="control-label">Estado de la obligación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="estado_obligacion" name="estado_obligacion" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CALIDAD -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="calidad" class="control-label">Calidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="calidad" id="calidad" placeholder="Calidad" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA VALOR DE LA MORA -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="valor_mora" class="control-label">Valor de la mora ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_mora" id="valor_mora" placeholder="Valor de la mora" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EDAD DE LA MORA -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="edad_mora" class="control-label">Edad de la mora: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="edad_mora" id="edad_mora" placeholder="Edad de la mora" required>
                            </div>
                        </div>
                    </div>


                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-infoFinanciero" type="submit" class="btn btn-primary btnAddinfoFinanciero">Guardar</button>
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
                    <table id="tbl-infoFinanciero" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Entidad</th>
                                <th>Producto y clase</th>
                                <th>Fecha expedición y terminación</th>
                                <th>Cupo inicial/Saldo pendiente/Pago Mínimo</th>
                                <th>Estado de la obligacion</th>
                                <th>Calidad</th>
                                <th>Valor en mora</th>
                                <th>Edad de la mora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
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
                </div>

                <div class="box-body">
                <style>
                    .tamano-letra-grande {
                        font-size: 40px;
                    }
                </style>
                    <table id="tbl-confTotales" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>CUPO INICIAL DE OBLIGACIONES FINANCIERAS</th>
                                <th>VALOR DE SALDOS PENDIENTES DE OBLIGACIONES</th>
                                <th>VALOR DE PAGOS MÍNIMOS MENSUALES</th>
                                <th>VALOR TOTAL DE LAS MORAS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.informacion_fianciera_ec_sin_cifin.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ec_sin_cifin/informacion_financiera_ec_sin_cifin.js"></script>
