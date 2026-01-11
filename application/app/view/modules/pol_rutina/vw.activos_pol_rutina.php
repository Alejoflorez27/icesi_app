<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">7. ACTIVOS DEL EVALUADO</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formVivActivos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_activo" name="id_activo" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                
            <div class="box-body">

                    <!-- ENTRADA PARA TIPO CONCEPTO DEL PASIVO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_activo" class="control-label">Tipo Activo: *
                                <button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda">
                                    Observación
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="concepto_activo" name="concepto_activo" required>
                                </select>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="otrosAct" class="control-label">Observación General: *
                            <!--<button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda">
                                    <i class="fa fa-info-circle"></i>
                                </button>-->
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input select2" id="otros" name="otros" required>
                                </select>-->
                                <textarea class="form-control input" style="height: 100px;" id="otrosAct" name="otrosAct"></textarea>
                                <!--<input type="text" class="form-control input" name="otrosAct" id="otrosAct" placeholder="Otros Activos Cuales?" required> -->
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y EVALUADO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_familiar_act" class="control-label">Propietario: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="tipo_familiar_act" name="tipo_familiar_act" required>
                                </select>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA TIPO OTRO PROPIETARIO SE DESCRIBE CUAL 
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarPropietarioAct">
                        <div class="form-group">
                            <label for="otro_propietario_act" class="control-label"></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="otros" name="otros" required>
                                </select>
                                <input type="text" class="form-control input" name="otro_propietario_act" id="otro_propietario_act" placeholder="Ingrese el propietario" required>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE ACTIVO 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor_activo" class="control-label">Valor Activo Comercial($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_activo" id="valor_activo" placeholder="Valor de Activo Comercial" required>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE ACTIVO 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor_activo_catastral" class="control-label">Valor Activo catastral($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_activo_catastral" id="valor_activo_catastral" placeholder="Valor de Activo Catastral" required>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA TIPO DE DESCRIPCION GFENERAL 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion_general_viv" class="control-label">Descripción General/Tenencia(Ubicación, Marca, ect): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="descripcion_general_viv" id="descripcion_general_viv" placeholder="Descripción General" required>
                            </div>
                        </div>
                    </div>-->

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-vivActivos" type="submit" class="btn btn-primary btnAddVivActivos">Guardar</button>
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
                    <table id="tbl-vivActivos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Observación General</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <!--<div class="row">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h2><strong>Total Activos:</strong></h2>
                        </div>
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h1 id="total_activos"></h1>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.activos_pol_rutina.modal.php' ?>
<?php include 'vw.ayuda_pol_rutina.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_rutina/activos_pol_rutina.js"></script>
