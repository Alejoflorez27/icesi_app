<div id="modalAddDimConcepto" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCaracteristicaViv" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_caracteristica" name="id_caracteristica" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-dimension">Concepto Matriz</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA TIPO ESTADO VIVIENDA 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_vivienda_estado" class="control-label">Estado De Vivienda: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_vivienda_estado" name="tipo_vivienda_estado" required>
                                </select>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA OBSERVACIONES DE CARACTERISTICAS DE LA VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="dimObservacion" class="control-label">Observación de Matriz: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="dimObservacion" name="dimObservacion" placeholder="Anotar las señales de alerta o riesgos encontrados en esta variable."></textarea>
                            </div>
                        </div>
                    </div>                

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-dimconcepto" type="submit" class="btn btn-primary btnAddConceptoDim">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>