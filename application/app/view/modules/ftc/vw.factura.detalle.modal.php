<div id="modalVerfactura" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVerFactura" name="formVerFactura" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ver Factura</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" id="id" name="id" value="">

                        <!-- ENTRADA PARA CONTRATO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="clase" class="control-label">Cliente: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                    <input type="text" class="form-control input solo-mayusculas" name="cliente" id="cliente" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA OBSERVACIÓN -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="clase" class="control-label">Fecha Factura: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-align-left"></i></span>
                                    <input type="text" class="form-control input solo-mayusculas" name="fecha_facturacion" id="fecha_facturacion">
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA RESPONSABLE -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="clase" class="control-label">Valor Neto: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input solo-mayusculas" name="valor_neto" id="valor_neto" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- ENTRADA PARA ESTADO -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="clase" class="control-label">Factura Contable: </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input solo-mayusculas" name="numero_factura_contable" id="numero_factura_contable" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="box-body">
                        <div class="div-cliente hide">
                            <table id="tbl-detalle-facturaC" class="table table-striped dt-responsive tablas  table-bordered" width="100%">

                                <thead>
                                    <tr>
                                        <th>Solicitud</th>
                                        <th>Combo</th>
                                        <th>Candidato</th>
                                        <th>Doc. Identidad</th>
                                        <th>Observación Cambio Vlr</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="div-proveedor hide">
                            <table id="tbl-detalle-facturaP" class="table table-striped dt-responsive tablas  table-bordered" width="100%">

                                <thead>
                                <tr>
                                        <th>Solicitud</th>
                                        <th>Servicio</th>
                                        <th>Valor</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>