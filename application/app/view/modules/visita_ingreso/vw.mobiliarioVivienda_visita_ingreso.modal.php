<div id="modalEditVivMobiliario" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivDistribucion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_mobiliario" name="id_mobiliario" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">8. Mobiliario de la Vivienda</h4>
                </div>

                <div class="modal-body">
                    
                    <!-- ENTRADA PARA TIPO DE ELEMENTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_elemento_edit" class="control-label">Tipo De Elemento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_elemento_edit" name="tipo_elemento_edit">
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE ELEMENTOS -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="cantidad_edit" class="control-label">Cantidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="cantidad_edit" id="cantidad_edit" placeholder="No. de Elementos" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO ESTADO MOBILIARIO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estado_mobiliario_edit" class="control-label">Estado Mobiliario: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="estado_mobiliario_edit" name="estado_mobiliario_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TENENCIA MOBILIARIA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tenencia_mobiliario_edit" class="control-label">Tenencia Mobiliario: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tenencia_mobiliario_edit" name="tenencia_mobiliario_edit" required>
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
                    <button id="btn-submit-vivEditMobiliario" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>