<div id="modalResetPassword" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPassword" role="form" method="post" enctype="multipart/form-data" autocomplete="off">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset Password</h4>
                </div>


                <div class="modal-body">

                    <div class="box-body">

                        <!-- ENTRADA PARA LA CONTRASEÑA ANTERIOR -->
                        <div class="col-xs-12  center-block">
                            <div class="form-group">
                                <label for="usuario_reset" class="control-label">USUARIO:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input-lg" name="usuario_reset"
                                        id="usuario_reset" autocomplete="off" placeholder="Ingresar Usuario" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="btn-reset-password" type="button" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>

</div>