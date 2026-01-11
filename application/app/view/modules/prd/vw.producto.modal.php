<div id="modalAddProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formProducto" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_producto" name="id_producto" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-producto">Producto</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA NOMBRE -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nom_prod" class="control-label">Nombre: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nom_prod" id="nom_prod" placeholder="Ingrese el nombre del producto">
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
                    <button id="btn-submit-producto" type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>