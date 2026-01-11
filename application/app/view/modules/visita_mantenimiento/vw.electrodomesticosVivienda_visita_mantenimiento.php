<section class="content-header">
<div class="box box-primary">
    <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">6. ELECTRODOMESTICOS DE LA VIVIENDA</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formVivElectrodomestico" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_electrodomestico" name="id_electrodomestico" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">

                    <!-- ENTRADA PARA TIPO DE ELEMENTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_elemento" class="control-label">Tipo De Elemento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_elemento" name="tipo_elemento" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE ELEMENTOS -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="cantidad" class="control-label">Cantidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="cantidad" id="cantidad" placeholder="No. de Elementos" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO ESTADO ELECTRODOMESTICO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estado_electrodomestico" class="control-label">Estado Electrodomestico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="estado_electrodomestico" name="estado_electrodomestico" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TENENCIA ELECTRODOMESTICO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tenencia_electrodomestico" class="control-label">Tenencia Electrodomestico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tenencia_electrodomestico" name="tenencia_electrodomestico" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-vivElectrodomestico" type="submit" class="btn btn-primary btnAddVivElectrodomestico">Guardar</button>
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
                    <table id="tbl-vivElectrodomestico" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tipo de Elemento</th>
                                <th>Cantidad</th>
                                <th>Estado </th>
                                <th>Tenencia </th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.electrodomesticoVivienda_visita_mantenimiento.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_mantenimiento/electrodomestico_vivienda_visita_mantenimiento.js"></script>
