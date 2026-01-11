<style>
    .lbl-subir {
        padding: 5px 10px;
        background: #f39c12;
        color: #fff;
        border: 0px solid #fff;
    }

    .lbl-subir:hover {
        color: #fff;
        background: #00a65a;
    }
</style>
<div id="modalAgregarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUsuario" role="form" method="post" enctype="multipart/form-data" autocomplete="off">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Administrar Usuario</h4>
                </div>


                <div class="modal-body"> 

                    <div class="box-body">
                        <input type="hidden" id="accion" name="accion" value="">

                        <!-- ENTRADA USERNAME-->
                        <div class="col-xs-12 col-sm-6 center-block div-username">
                            <div class="form-group">
                                <label for="username" class="control-label">USUARIO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control input" name="username" autocomplete="nope"
                                        placeholder="username" id="username" required>
                                </div>
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
                        
                        
                        <!-- ENTRADA PARA EL EMPRESA -->
                <!--        <div id="div-perfil" class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="id_empresa" class="control-label">EMPRESA: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <select class="form-control input" id="id_empresa" name="id_empresa">
                                    </select>
                                </div>
                            </div>
                        </div>
                -->

                        <!-- ENTRADA PARA EL NOMBRES -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="nombres" class="control-label">NOMBRES: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="nombres" id="nombres"
                                        placeholder="Ingresar nombres" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL APELLIDOS -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="apellidos" class="control-label">APELLIDOS: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="apellidos" id="apellidos"
                                        placeholder="Ingresar apellidos" required>
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
                                    <input type="text" class="form-control input solo-numero" name="numero_identificacion" id="numero_identificacion"
                                        placeholder="Ingresar numero_identificacion" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EL NUMERO DE REGIDTRO -->
                        <div class="col-xs-12 col-sm-12 center-block" id="registroinput">
                            <div class="form-group">
                                <label for="registro" class="control-label">REGISTRO: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input" name="registro" id="registro"
                                        placeholder="Ingresar registro" required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA LA EMAIL -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="email" class="control-label">E-MAIL: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                    <input type="email" class="form-control input" name="email" id="email"
                                        placeholder="Ingresar e-mail" required>
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
                                        <input type="password" class="form-control input" name="password" id="password"
                                            autocomplete="off" placeholder="Ingresar contraseña" required>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA LA CONTRASEÑA -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="password_confirma" class="control-label">CONFIRME PASSWORD: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" class="form-control input" name="password_confirma"
                                            id="password_confirma" autocomplete="off" placeholder="Confirmar contraseña"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <tr>
                        
                            <!-- Visualiza la firma -->
                            <div class="col-xs-12 col-sm-12 center-block" id="infoImage">
                                <div class="form-group">
                                    <label for="firma" class="control-label">FIRMA: </label>
                                    <td colspan="2"><img id="mi_imagen" width="120" height="70"/></td>
                                </div>
                            </div>

                            <!-- ENTRADA PARA Firma -->
                            <div class="col-xs-12 col-sm-12 center-block div-archivo" id="infoEdit">
                                    <label class="control-label">Firma Guardada: </label>
                                    <span id="info-edit"></span>
                                    <input type="hidden" id="nomLogo" name="nomLogo" value="">  
                            </div>
                            <div class="col-xs-12 col-sm-12 center-block div-archivo" id="idArchivo">
                                    <label class="control-label">Firma - Archivo: </label>
                                    <span id="info"></span>
                                </div>
                            <div class="col-xs-12 col-sm-12  center-block div-archivo" id="idArchivo2">
                                    <label for="archivo" class="lbl-subir">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <span id="lbl-archivo">Seleccionar Archivo</span>
                                    </label>
                                    <input id="archivo" name="archivo" class="archivo" type="file" style='display: none;' accept=".jpg, .png" />
                            </div>
                            <?php
                            // print_r($_FILES);
                            ?>    
                            <!-- ESPACIO en BLANCO -->
                            <div class="col-xs-12 col-sm-12  center-block" style="color:red;">
                            <br>                                    
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
                    <button id="btn-submit-usuario" type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>

</div>
