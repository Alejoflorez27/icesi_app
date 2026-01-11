<div id="modalAddVivCaracteristica" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCaracteristicaViv" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_caracteristica" name="id_caracteristica" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-combo">Caracteristicas de Vivienda</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA TIPO VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_vivienda" class="control-label">Tipo De Vivienda: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_vivienda" name="tipo_vivienda" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO TENENCIA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_tenencia" class="control-label">Tenencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_tenencia" name="tipo_tenencia" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO TAMAÑO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_tamano_vivienda" class="control-label">Tamaño: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_tamano_vivienda" name="tipo_tamano_vivienda" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO ESTADO VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_vivienda_estado" class="control-label">Estado De Vivienda: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_vivienda_estado" name="tipo_vivienda_estado" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIONES DE CARACTERISTICAS DE LA VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="aclaracion_viv" class="control-label">Aclaraciones de la caracteristica de la vivienda: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="aclaracion_viv" name="aclaracion_viv" placeholder="(Anotaciones relevantes del mobiliario y electrodoméstico, ejemplo cuando encuentre que los muebles de baño están destruidos o muy dañados o algún mueble está muy deteriorado e inservible o una de las habitaciones es utilizada como depósito o estudio  etc)"></textarea>
                            </div>
                        </div>
                    </div>  

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-caracteristicaViv" type="submit" class="btn btn-primary">Guardar Caracteristica</button>
                </div>
            </form>
        </div>
    </div>
</div>