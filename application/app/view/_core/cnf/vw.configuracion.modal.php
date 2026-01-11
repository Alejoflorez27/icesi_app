<div id="modalAgregarParametro" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formReferencia" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Maestro</h4>
                </div>


                <div class="modal-body">

                    <div class="box-body">
                        <input type="hidden" id="accion" name ="accion" value="" >

                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="categoria" class="control-label">CATEGORIA:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <select class="form-control input-lg" id="categoria" name="categoria"  required>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="codigo" class="control-label">CODIGO:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input-lg" id="codigo" name="codigo"  placeholder="Ingresar el codigo" required value="">
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="descripcion" class="control-label">DESCRIPCIÓN:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <input type="text" class="form-control input-lg" id="descripcion" name="descripcion"  placeholder="Ingresar descripción" value="">
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="observacion" class="control-label">OBSERVACIONES:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                    <input type="text" class="form-control input-lg" id="observacion" name="observacion"  placeholder="Ingresar observaciones" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="estado" class="control-label">ESTADO:</label>
                                <div class="input-group">
                                    <label class="radio-inline"><input type="radio" id="estado" name="estado" value="ACT">ACTIVO</label>
                                    <label class="radio-inline"><input type="radio" id="estado" name="estado" value="INA">INACTIVO</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-referencia" type="button" class="btn btn-primary">Guardar Maestro</button>
                </div>
            </form>
        </div>
    </div>

</div>
