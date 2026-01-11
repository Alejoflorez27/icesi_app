<style>

#tabla-empresas {
    font-size: 12px;
}

.empresa-checkbox {
    transform: scale(1.2);
}

.table-responsive {
    border: 1px solid #ddd;
    border-radius: 4px;
}



</style>

<div id="modalAgregarUsuarioCli" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUsuario2" role="form" method="post" enctype="multipart/form-data" autocomplete="off">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-usu">Administrar Usuario</h4>
                    <span id=lbl-archivo2></span>
                </div>


                <div class="modal-body">

                    <div class="box-body">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_empresa_usuario" name="id_empresa_usuario">

                        <!-- ENTRADA USERNAME-->
                        <div class="col-xs-12 col-sm-12 center-block div-username">
                            <div class="form-group">
                                <label for="username" class="control-label">USUARIO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control input" name="username" autocomplete="nope" placeholder="username" id="username" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL PERFIL 
                        <div id="div-perfil" class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="usr_empresas" class="control-label">Empresa del Usuario: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input" id="usr_empresas" name="usr_empresas" required>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                        <!-- ENTRADA PARA LAS EMPRESAS (REEMPLAZA LA ACTUAL) -->
                        <div id="div-empresas" class="col-xs-12 center-block">
                            <div class="form-group">
                                <label class="control-label">Empresas del Usuario: *</label>
                                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                    <table class="table table-bordered table-hover" id="tabla-empresas">
                                        <thead>
                                            <tr>
                                                <th width="50px" class="text-center">Seleccionar</th>
                                                <th>Empresa</th>
                                                <!--<th>RUC/Identificación</th>-->
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-empresas">
                                            <!-- Las empresas se cargarán aquí dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-muted">Seleccione una o más empresas</small>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL PERFIL -->
                        <div id="div-perfil" class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="perfil" class="control-label">PERFIL: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input" id="perfil" name="perfil" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA EL BASH -->
                        <div id="bandera_bashinput" class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="bandera_bash" class="control-label">Usuario Basc: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                        <select class="form-control input" id="bandera_bash" name="bandera_bash" required>
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
                                <label for="nombres" class="control-label">NOMBRES: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="nombres" id="nombres" placeholder="Ingresar nombres" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL APELLIDOS -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="apellidos" class="control-label">APELLIDOS: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="apellidos" id="apellidos" placeholder="Ingresar apellidos" required>
                                </div>
                            </div>
                        </div>


                        <!-- ENTRADA PARA EL TIPO IDENTIFICACIÓN -->
                        <div id="div-tipo_identificacion" class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="tipo_identificacion" class="control-label">TIPO IDENTIFICACIÓN: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input" id="tipo_identificacion" name="tipo_identificacion" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL No. IDENTIFICACIÓN -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="numero_identificacion" class="control-label">No. IDENTIFICACIÓN: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input solo-numero" name="numero_identificacion" id="numero_identificacion" placeholder="Ingresar numero_identificacion" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL CARGO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="cargo" class="control-label">CARGO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="cargo" id="cargo" placeholder="Ingresar cargo" required>
                                </div>
                            </div>
                        </div>


                        <!-- ENTRADA PARA LA EMAIL -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="email" class="control-label">E-MAIL: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                    <input type="email" class="form-control input" name="email" id="email" placeholder="Ingresar e-mail" required>
                                </div>
                            </div>
                        </div>

                        <div class="me-password">
                            <!-- ENTRADA PARA LA CONTRASEÑA -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="password" class="control-label">PASSWORD: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" class="form-control input" name="password" id="password" autocomplete="off" placeholder="Ingresar contraseña" required>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA LA CONTRASEÑA -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="password_confirma" class="control-label">CONFIRME PASSWORD: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" class="form-control input" name="password_confirma" id="password_confirma" autocomplete="off" placeholder="Confirmar contraseña" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer hide" id="nota-contrasena">
                        <p style="color:red;">
                            <b>Nota:</b> La contraseña debe contener Mínimo 8 caracteres, usar al menos una Mayúscula un
                            Número y al menos uno de los siguientes Símbolos <b>$@$!%*?&</b>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-usuario2" type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
