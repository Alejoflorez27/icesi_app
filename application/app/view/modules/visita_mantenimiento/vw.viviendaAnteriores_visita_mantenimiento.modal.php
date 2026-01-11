<div id="modalEditVivAnterior" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivAnterior" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_viv_anterior" name="id_viv_anterior" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">8. SITIOS DE VIVIENDA ANTERIORES Y TIEMPO DE ESTADÍA EN ESTOS</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA NOMBRE DE LA UBICACIÓN -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="ubicacion_edit" class="control-label">Ubicación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="ubicacion_edit" id="ubicacion_edit" placeholder="Ingrese la Ubicación de la Vivienda" >
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA Tiempo en el que reside en la vivienda actual (Arraigo) -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="Tiempo_estadia_edit" class="control-label">Tiempo en el que reside en la vivienda actual (Arraigo): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="Tiempo_estadia_edit" name="Tiempo_estadia_edit" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NOMBRE DE LA INSTITUCION -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="motivo_cambio_edit" class="control-label">Motivo de Cambio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="motivo_cambio_edit" id="motivo_cambio_edit" placeholder="Ingrese el Motivo del cambio de la vivienda" >
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditVivAnteriores" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>