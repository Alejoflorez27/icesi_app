<div id="modalEditLaboralPeriodo" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formLaboralPeriodo" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_laboral_periodos" name="id_laboral_periodos" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal">3. BRECHAS O INACTIVIDAD LABORAL</h4>
                </div>

                <div class="modal-body">
                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="periodo_edit" class="control-label">Periodo de inactividad: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="periodo_edit" name="periodo_edit" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DOTACION MOBILIARIA -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="tmp_periodo_edit" class="control-label">Tiempo aproximado del periodo: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="tmp_periodo_edit" name="tmp_periodo_edit" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA INFORME POR VARIABLE  -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="descripcion_edit" class="control-label">Descripción (por que se dio esta inactivada y que actividades realizó durante este periodo): *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <textarea class="form-control input" id="descripcion_edit" name="descripcion_edit" required></textarea>
                                    </div>
                                </div>
                            </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-periodoedit" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>