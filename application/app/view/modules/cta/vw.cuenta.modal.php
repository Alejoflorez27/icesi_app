<div id="modalAddCuenta" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCuenta" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_cuenta" name="id_cuenta" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-cuenta">Cuenta Contable</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA ITEM -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_servicio" class="control-label">Item: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-italic"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="item" id="item" placeholder="Ingrese la descripción del item">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CONCEPTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nom_servicio" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-align-center"></i></span>
                                <input type="text" class="form-control input" name="concepto" id="concepto" placeholder="Ingrese el concepto">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA COMBO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="producto" class="control-label">Combo: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                <select class="form-control input select2" id="combo" name="combo" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA UBICACION CUENTA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estado" class="control-label">Ubicación Cuenta: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                <select class="form-control input" id="ubicacion_cuenta" name="ubicacion_cuenta">
                                    <option value="B">Bogotá</option>
                                    <option value="E">Fuera Bogotá</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA UBICACION CUENTA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estado" class="control-label">Destino Cuenta: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                <select class="form-control input" id="destino_cuenta" name="destino_cuenta">
                                    <option value="P">Proveedor</option>
                                    <option value="C">Cliente</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA ESTADO -->
                    <div class="div-editar">
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
                    <button id="btn-submit-cuenta" type="submit" class="btn btn-primary">Guardar Cuenta Contable</button>
                </div>
            </form>
        </div>
    </div>
</div>