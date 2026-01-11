<div id="modalEditCentroCosto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditCentroCosto" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal">Centro de Costos  </h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="accion" name="accion" value="">
                    <input type="hidden" id="id_solicitud" name="id_solicitud" value="">

                    <div class="modal-body">
                        <div class="row">
                        
                            <!-- ENTRADA PARA OBSERVACION -->
                            
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="centro_costo" class="control-label">Observación:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                            <textarea class="form-control input" name="centro_costo" id="centro_costo" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                                <button id="btn-submit-costo" type="submit" class="btn btn-primary" >Guardar</button>
                            </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>