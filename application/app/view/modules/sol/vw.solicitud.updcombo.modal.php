<div id="modalUpdCombo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUpdCombo" role="form" method="post" enctype="multipart/form-data" autocomplete="off" class='hide'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Actualizar Combo</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="accionSolicitud" name="accionSolicitud" value="">
                    <input type="hidden" id="idSolicitud" name="idSolicitud" value="">

                    <div class="modal-body">
                        <!-- ENTRADA PARA COMBO -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="tipo_id" class="control-label">Combos:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <select class="form-control input" id="combo_upd" name="combo_upd">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                        <button id="btn-upd-combo" type="submit" class="btn btn-primary">Actualizar Combo</button>
                    </div>
            </form>
        </div>
    </div>
</div>