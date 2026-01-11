<div id="modalEditVivDistribucion" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivDistribucion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_riesgo" name="id_riesgo" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">6. Factores de riesgo</h4>
                </div>

                <div class="modal-body">
                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="factor_edit" class="control-label">Factor de Riesgo: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="factor_edit" name="factor_edit"  disabled>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="aspecto_edit" class="control-label">Aspecto Identicado: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input class="form-control input" id="aspecto_edit" name="aspecto_edit" readonly>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA TIPO DE ESPACIOS 
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="descripcion_edit" class="control-label">Descripción: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="descripcion_edit" name="descripcion_edit" required>
                                        </select>
                                    </div>
                                </div>
                            </div>-->

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="descripcion_com_edit" class="control-label">Descripción completa: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" id="descripcion_com_edit" name="descripcion_com_edit" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="calificacion_edit" class="control-label">Calificacion: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="calificacion_edit" name="calificacion_edit" required>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="observacion_edit" class="control-label">Observaciones: *</label>
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
                    <button id="btn-submit-vivEditDristribucion" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>