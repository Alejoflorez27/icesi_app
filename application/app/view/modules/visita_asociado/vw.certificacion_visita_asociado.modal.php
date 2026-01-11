<div id="modalEditInfo" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCertificacionAsociado" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_certificacion" name="id_certificacion" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">2. Información General</h4>
                </div>

                <div class="modal-body">
                             <!-- ENTRADA PARA sistema_gestion -->
                             <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="sistema_gestion_edit" class="control-label">Sistema de Gestión: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="sistema_gestion_edit" name="sistema_gestion_edit" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA REQUISITO COMPLETO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="estado_edit" class="control-label">Estado: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="text" class="form-control input" id="estado_edit" name="estado_edit"></input>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="afirmativo_edit" class="control-label">SI: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="text" class="form-control input" id="afirmativo_edit" name="afirmativo_edit" required></input>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="numero_edit" class="control-label">Número: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input class="form-control input" id="numero_edit" name="numero_edit" required></input>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
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
                    <button id="btn-submit-editCertificacion" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>