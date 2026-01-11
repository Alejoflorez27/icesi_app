<div id="modalAgregarPerfil" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPerfil" role="form" method="post" enctype="multipart/form-data" autocomplete="off">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Administrar Perfil</h4>
                </div>


                <div class="modal-body">

                    <div class="box-body">
                        <input type="hidden" id="accion" name="accion" value="">

                        <!-- ENTRADA PARA CONTRATO ID -->
                        <div class="col-xs-12 col-sm-6 center-block div-id hide">
                            <div class="form-group">
                                <label for="id" class="control-label">ID: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control input" name="id" autocomplete="off"
                                        placeholder="id" id="id">
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA NOMBRE -->
                        <div class="col-xs-12 col-sm-8 center-block">
                            <div class="form-group">
                                <label for="descripcion" class="control-label">NOMBRE: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-comment-o"></i></span>
                                    <input type="text" class="form-control input" name="descripcion" id="descripcion"
                                        placeholder="Ingresar descripción del perfil" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA ESTADO -->
                        <div id="div-estado" class="col-xs-12 col-sm-4 center-block">
                            <div class="form-group">
                                <label for="estado" class="control-label">ESTADO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input" id="estado" name="estado">
                                        <option value="A">Activo</option>
                                        <option value="I">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer" style="color:red;">
                            Campos señalados con * son obligatorios
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-perfil" type="submit" class="btn btn-primary">Guardar Perfil</button>
                </div>
            </form>
        </div>
    </div>

</div>
