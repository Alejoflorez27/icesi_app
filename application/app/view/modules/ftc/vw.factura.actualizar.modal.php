<div id="modalUpdFact" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUpdFact" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-combo">Actualizar Valor Factura</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA SOLICITUD-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">Solicitud: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="id_solicitud" id="id_solicitud" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FACTURA-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">Factura: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="factura" id="factura" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CANDIDATO-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="candidato" id="candidato" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA DOCUMENTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">Documento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nro_doc" id="nro_doc" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA VALOR CONTRATO-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">Valor Contratado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-numero" name="valor" id="valor" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA VALOR NUEVO-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">Valor Nuevo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-numero" name="valor_nuevo" id="valor_nuevo">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACION -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="observacion" class="control-label">Observación:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                    <textarea class="form-control input" name="observacion_edit" id="observacion_edit" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-updfact" type="submit" class="btn btn-primary">Guardar Valor</button>
                </div>
            </form>
        </div>
    </div>
</div>