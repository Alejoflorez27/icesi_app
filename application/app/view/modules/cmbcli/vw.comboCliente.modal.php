<div id="modalAddComboCliente" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formComboCliente" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="metodo" name="metodo" value="">
                <input type="hidden" id="id_combo_cli" name="id_combo_cli" value="">
                <input type="hidden" id="id_combo_cliEdit" name="id_combo_cliEdit" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-comboCli">Combo</h4>
                </div>

                <div class="modal-body">
                    <div class="div-crear">
                        <!-- ENTRADA PARA EMPRESA -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="id_empresa" class="control-label">Empresa: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <select class="form-control input" id="id_empresa" name="id_empresa" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA COMBO SERVICIO -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="id_combo" class="control-label">Combo Servicio: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                    <select class="form-control input" id="id_combo" name="id_combo" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- MANEJO DE LOS CAMPOS EN LA EDICIÓN -->
                    <div class="div-editar">
                        <!-- ENTRADA PARA EMPRESA EDIT-->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="empresa2" class="control-label">Empresa: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <input type="text" class="form-control input solo-numero" name="empresa2" id="empresa2">
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA COMBO SERVICIO EDIT -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="combo" class="control-label">Combo Servicio: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                    <input type="text" class="form-control input solo-numero" name="combo" id="combo">
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ENTRADA PARA VALOR-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor" class="control-label">Valor Bogotá: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                <input type="text" class="form-control input solo-numero" name="valor_bogota" id="valor_bogota" placeholder="Ingrese el valor del combo para Bogotá">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA VALOR-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor" class="control-label">Valor Externo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                <input type="text" class="form-control input solo-numero" name="valor_externo" id="valor_externo" placeholder="Ingrese el valor del combo para fuera de Bogotá">
                            </div>
                        </div>
                    </div>

                    <div class="div-crear">
                        <!-- ENTRADA PARA ESTADO -->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="estado" class="control-label">Estado: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                    <select class="form-control input" id="estado" name="estado">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-comboCliente" type="submit" class="btn btn-primary">Guardar Combo</button>
                </div>
            </form>
        </div>
    </div>
</div>