<div id="modalfactura" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formFactura" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="factura" name="factura" value="">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-producto">Factura</h4>

                <div class="modal-body">

                    <!-- ENTRADA CLIENTE-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="cliente" class="control-label">Cliente: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="clienteFC" id="clienteFC" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA FACTURA CONTABLA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="numero_factura_contable" class="control-label">Factura Contable: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="numero_factura_contableFC" id="numero_factura_contableFC" placeholder="Ingrese el número de factura Contable">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-factura" type="submit" class="btn btn-primary">Guardar Factura</button>
                </div>
            </form>
        </div>
    </div>
</div>