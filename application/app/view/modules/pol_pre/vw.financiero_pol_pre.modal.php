<div id="modalEditVivFinanciero" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivFinanciero" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_financiero" name="id_financiero" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">8. ANÁLISIS DE REPORTE EN CENTRALES</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="persona_evaluada_edit" class="control-label">Persona Evaluda (cadidato/Familiar): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="persona_evaluada_edit" name="persona_evaluada_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_financiero_edit" class="control-label">Aspecto consultado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="concepto_financiero_edit" name="concepto_financiero_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
    
                    <!-- ENTRADA PARA COONCEPTO FINANCIERO COMPLETO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_financiero_completo_edit" class="control-label">Descripción del aspecto consultado:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="concepto_financiero_completo_edit" name="concepto_financiero_completo_edit" placeholder="Descripción completa de aspecto consultado" readonly=»readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA ESTADO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="estado_edit" class="control-label">Se Encuentra Reportado (Si/No): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="estado_edit" name="estado_edit" required>
                                <option value="selecione">Se Encuentra Reportado</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACION -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion_financiero_edit" class="control-label">Observaciones: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="descripcion_financiero_edit" name="descripcion_financiero_edit"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditFinanciero" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>