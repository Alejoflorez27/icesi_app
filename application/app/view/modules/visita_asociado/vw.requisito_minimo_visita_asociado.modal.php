<div id="modalEditRequisito" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formRequisito" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_requisito" name="id_requisito" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">4. Concepto Seguridad Física y Control de Acceso</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA REQUISITO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="requisito_edit" class="control-label">Concepto Seguridad Física y Control de Acceso: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <select class="form-control input" id="requisito_edit" name="requisito_edit" disabled required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA REQUISITO COMPLETO -->
                        <div class="col-xs-12 col-sm- center-block">
                            <div class="form-group">
                                <label for="requisito_completo_edit" class="control-label">Concepto Seguridad Física y Control de Acceso Completo: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <textarea class="form-control input" id="requisito_completo_edit" name="requisito_completo_edit" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="calificacion_edit" class="control-label">Calificacion: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <select class="form-control input" id="calificacion_edit" name="calificacion_edit" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="observacion_edit" class="control-label">Observación: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <textarea class="form-control input" id="observacion_edit" name="observacion_edit" required></textarea>
                                </div>
                            </div>
                        </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-editRequisito" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>