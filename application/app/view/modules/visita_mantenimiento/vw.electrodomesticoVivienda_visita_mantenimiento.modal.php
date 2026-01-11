<div id="modalEditVivElectrodomestico" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivElectrodomestico" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_electrodomestico" name="id_electrodomestico" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">7.Electrodomestico de la Vivienda</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA TIPO DE ELEMENTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_elementoelectro_edit" class="control-label">Tipo De Elemento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_elementoelectro_edit" name="tipo_elementoelectro_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE ELEMENTOS -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="cantidadelectro_edit" class="control-label">Cantidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="cantidadelectro_edit" id="cantidadelectro_edit" placeholder="No. de Elementos" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO ESTADO MOBILIARIO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estado_electrodomestico_edit" class="control-label">Estado Electrodomestico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="estado_electrodomestico_edit" name="estado_electrodomestico_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TENENCIA MOBILIARIA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tenencia_electrodomestico_edit" class="control-label">Tenencia Electrodomestico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tenencia_electrodomestico_edit" name="tenencia_electrodomestico_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditElectrodomestico" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>