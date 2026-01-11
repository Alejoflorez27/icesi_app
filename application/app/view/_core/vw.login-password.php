<div id="modalPassword" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPassword" role="form" method="post" enctype="multipart/form-data" autocomplete="off">


                <div class="modal-header">
                    <button id="btn-cerrar-password" type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cambiar Password</h4>
                </div>


                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA LA CONTRASEÑA ANTERIOR -->
                        <div class="col-xs-12  center-block">
                            <div class="form-group">
                                <label for="password_old" class="control-label">PASSWORD ACTUAL:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control input-lg" name="password_old"
                                        id="password_old" autocomplete="off" placeholder="Ingresar contraseña anterior"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA LA CONTRASEÑA -->
                        <div class="col-xs-12  center-block">
                            <div class="form-group">
                                <label for="password_new" class="control-label">PASSWORD NUEVO:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control input-lg" name="password_new"
                                        id="password_new" autocomplete="off" placeholder="Ingresar contraseña nueva"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA LA CONTRASEÑA -->
                        <div class="col-xs-12  center-block">
                            <div class="form-group">
                                <label for="password_new_confirma" class="control-label">CONFIRME PASSWORD:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control input-lg" name="password_new_confirma"
                                        id="password_new_confirma" autocomplete="off"
                                        placeholder="Confirmar contraseña nueva" required>
                                </div>
                            </div>
                        </div>

                        <p style="color:red;">
                            <b>Nota:</b> La contraseña debe contener Mínimo 8 caracteres, usar al menos una Mayúscula un Número y al menos uno de los siguientes Símbolos <b>$@$!%*?&</b>
                        </p>

                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btn-salir-password" type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-password" type="submit" class="btn btn-primary">Guardar Password</button>
                </div>
            </form>
        </div>
    </div>

</div>
