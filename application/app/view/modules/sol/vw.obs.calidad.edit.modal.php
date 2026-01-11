<div id="modalEditObsCalidad" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditObsCalidad" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal">Observación de Calidad</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="accion" name="accion" value="">
                    <input type="hidden" id="id_solicitud" name="id_solicitud" value="">

                    <div class="row">
                        <!-- ENTRADA PARA CONCEPTO FINAL -->
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="concepto_final" class="control-label">Concepto Final: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <select class="form-control select2" id="concepto_final" name="concepto_final" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Rechazado">Rechazado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                        <!-- ENTRADA PARA OBSERVACION -->
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="obs_calidad" class="control-label">Observación: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                    <textarea class="form-control" name="obs_calidad" id="obs_calidad" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-calidad" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
