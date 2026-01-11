<div id="modalEditVivFinanciero" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivSeguridad" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_seguridad" name="id_seguridad" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">18. ANÁLISIS DE REPORTE EN CENTRALES</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_seguridad_edit" class="control-label">Aspecto consultado al Evaluado y la familia con la que convive: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="concepto_seguridad_edit" name="concepto_seguridad_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
    
                    <!-- ENTRADA PARA COONCEPTO FINANCIERO COMPLETO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_seguridad_completo_edit" class="control-label">Aspecto completo consultado al Evaluado y la familia con la que convive: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="concepto_seguridad_completo_edit" name="concepto_seguridad_completo_edit" placeholder="Descripción completa de aspecto consultado" readonly=»readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA ESTADO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="respuesta_edit" class="control-label">Estado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="respuesta_edit" name="respuesta_edit" required>
                                <option value="selecione">- Seleccione -</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACION -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion_seguridad_edit" class="control-label">Observaciones: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="descripcion_seguridad_edit" name="descripcion_seguridad_edit"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditSeguridad" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>