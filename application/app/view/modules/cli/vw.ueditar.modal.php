<div id="modalEditarUsuarioCli" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUsuario3" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-usu">Editar Usuario</h4>
                    <span id="lbl-archivo2"></span>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_user_empresa" name="id_user_empresa">
                        <input type="hidden" id="id_empresa_usuario_edit" name="id_empresa_usuario_edit">
                        <input type="hidden" id="flag_subemp_usuario" name="flag_subemp_usuario" value="0">

                        <!-- ENTRADA USERNAME (solo lectura en edición) -->
                        <div class="col-xs-12 col-sm-12 center-block div-username">
                            <div class="form-group">
                                <label for="username1" class="control-label">USUARIO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control input" name="username1" autocomplete="nope" 
                                           placeholder="username" id="username1" required readonly>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA LAS EMPRESAS (REEMPLAZA EL SELECT ACTUAL) -->
                        <div id="div-empresas-edit" class="col-xs-12 center-block">
                            <div class="form-group">
                                <label class="control-label">Empresas del Usuario: * <span id="contador-empresas-edit" class="text-muted"></span></label>
                                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                    <table class="table table-bordered table-hover" id="tabla-empresas-edit">
                                        <thead>
                                            <tr>
                                                <th width="50px" class="text-center">
                                                    <input type="checkbox" id="seleccionar-todos-edit">
                                                </th>
                                                <th>Empresa</th>
                                                <!--<th>RUC/Identificación</th>-->
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-empresas-edit">
                                            <!-- Las empresas se cargarán aquí dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-muted">Seleccione una o más empresas</small>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL PERFIL -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="perfil1" class="control-label">PERFIL: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input" id="perfil1" name="perfil1" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL BASH -->
                        <div id="bandera_bashinput1" class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="bandera_bash1" class="control-label">Usuario Basc: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                    <select class="form-control input" id="bandera_bash1" name="bandera_bash1" required>
                                        <option value="" disabled selected style="display:none;">Seleccione</option>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL NOMBRES -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="nombres1" class="control-label">NOMBRES: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="nombres1" id="nombres1" 
                                           placeholder="Ingresar nombres" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL APELLIDOS -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="apellidos1" class="control-label">APELLIDOS: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="apellidos1" id="apellidos1" 
                                           placeholder="Ingresar apellidos" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL TIPO IDENTIFICACIÓN -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="tipo_identificacion1" class="control-label">TIPO IDENTIFICACIÓN: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input" id="tipo_identificacion1" name="tipo_identificacion1" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL No. IDENTIFICACIÓN -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="numero_identificacion1" class="control-label">No. IDENTIFICACIÓN: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input solo-numero" name="numero_identificacion1" 
                                           id="numero_identificacion1" placeholder="Ingresar numero_identificacion" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL CARGO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="cargo1" class="control-label">CARGO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="cargo1" id="cargo1" 
                                           placeholder="Ingresar cargo" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA LA EMAIL -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="email1" class="control-label">E-MAIL: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                    <input type="email" class="form-control input" name="email1" id="email1" 
                                           placeholder="Ingresar e-mail" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-edit-usuario3" type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>