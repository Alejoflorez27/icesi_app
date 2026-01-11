<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">11. EGRESOS  MENSUALES DEL EVALUADO (Y CONYUGUE SI APLICA) </h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formVivEgresos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_egreso" name="id_egreso" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">
                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y CANDIDATO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_familiar_egre" class="control-label">Integrante: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input select2" id="tipo_familiar_egre" name="tipo_familiar_egre" required>
                                </select>-->
                                <input type="text" class="form-control input" name="tipo_familiar_egre" id="tipo_familiar_egre" placeholder="Integrante de la Familia" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO CONCEPTO DEL EGRESO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_ingreso" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="concepto_ingreso" name="concepto_ingreso" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultar">
                        <div class="form-group">
                            <label for="otros" class="control-label"></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input select2" id="otros" name="otros" required>
                                </select>-->
                                <input type="text" class="form-control input" name="otros" id="otros" placeholder="Otros Cuales?" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO PERIOCIDAD DEL EGRESO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="periocidad" class="control-label">Periodicidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="periocidad" name="periocidad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE EGRESOS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="valor_egreso" class="control-label">Valor aporte egreso ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_egreso" id="valor_egreso" placeholder="Valor de aporte al egreso" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE EGRESOS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="total_egresoVI" class="control-label">Total del egreso ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="total_egresoVI" id="total_egresoVI" placeholder="Valor total del egreso" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-vivEgresos" type="submit" class="btn btn-primary btnAddVivEgresos">Guardar</button>
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
                    <h2 style="color: red;"><strong>Egresos Mensuales</strong></h2>
                    <table id="tbl-vivEgresos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Concepto</th>
                                <th>Otros</th>
                                <th>Periodicidad</th>
                                <th>Responsable</th>
                                <th>Valor Egreso </th>
                                <th>Total Egreso </th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h2><strong>Total Egresos Mensuales:</strong></h2>
                        </div>
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h1 id="total_egreso"></h1>
                        </div>
                    </div>
                    <h2 style="color: red;"><strong>Egresos Adicionales</strong></h2>
                    <table id="tbl-vivEgresosAdicional" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Concepto</th>
                                <th>Otros</th>
                                <th>Periodicidad</th>
                                <th>Responsable</th>
                                <th>Valor Egreso </th>
                                <th>Total Egreso </th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h2><strong>Total Egresos Adicionales:</strong></h2>
                        </div>
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h1 id="total_egreso_adicional"></h1>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.egresos_visita_mantenimiento.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_mantenimiento/egresos_visita_mantenimiento.js"></script>
