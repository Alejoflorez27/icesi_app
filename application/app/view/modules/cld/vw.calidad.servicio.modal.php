<div id="modalAsigSrv" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAsigSrv" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_servicio" name="id_servicio" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-producto">Asignar Servicio</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA NOMBRE SERVICIO
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nom_prod" class="control-label">Servicio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nom_servicio" id="nom_servicio" disabled>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA NOMBRE RESPONSABLE
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nom_prod" class="control-label">Responsable: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nom_responsable" id="nom_responsable" disabled>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA NOMBRE USUARIO CALIDAD-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Usuario Calidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input" id="id_usuario_calidad" name="id_usuario_calidad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA PRIORIDAD-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Prioridad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input" id="prioridad" name="prioridad">
                                    <option value="alta">Alta</option>
                                    <option value="media">Media</option>
                                    <option value="baja">Baja</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-asignar" type="submit" class="btn btn-primary">Guardar Asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>