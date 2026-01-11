<div id="modalEditInfoFinanciero" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formInfoFinanciera" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_info_obl_fin" name="id_info_obl_fin" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">3. CONFIABILIDAD FINANCIERA/CIFIN - CRÉDITOS Y OBLIGACIONES FINANCIERAS</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA NOMBRE DE LA ENTIDAD -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="entidad_edit" class="control-label">Nombre de la entidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="entidad_edit" id="entidad_edit" placeholder="Nombre de la entidad" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PRODUCTO Y CLASE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="producto_clase_edit" class="control-label">Producto y clase: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="producto_clase_edit" id="producto_clase_edit" placeholder="Ingrese producto y clase" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE EXPEDICION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_expedicion_edit" class="control-label">Fecha de expedición: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="date" class="form-control input" name="fch_expedicion_edit" id="fch_expedicion_edit" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE TERMINACION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_terminacion_edit" class="control-label">Fecha de terminación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="date" class="form-control input" name="fch_terminacion_edit" id="fch_terminacion_edit" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CUPO INICIAL DE CREDITO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="cupo_inicial" class="control-label">Cupo inicial de crédito($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="cupo_inicial_edit" id="cupo_inicial_edit" placeholder="Cupo inicial" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA SALDO PENDIENTE -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="saldo_pendiente_edit" class="control-label">Saldo pendiente($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="saldo_pendiente_edit" id="saldo_pendiente_edit" placeholder="Saldo pendiente" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PAGO MINIMO MENSUAL -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="pago_minimo_edit" class="control-label">Pago minimo mensual($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="pago_minimo_edit" id="pago_minimo_edit" placeholder="Pago minimo mensual" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ESTADO DE LA OBLIGACION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="estado_obligacion_edit" class="control-label">Estado de la obligación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="estado_obligacion_edit" name="estado_obligacion_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CALIDAD -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="calidad_edit" class="control-label">Calidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="calidad_edit" id="calidad_edit" placeholder="Calidad" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA VALOR DE LA MORA -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="valor_mora_edit" class="control-label">Valor de la mora ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_mora_edit" id="valor_mora_edit" placeholder="Valor de la mora" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EDAD DE LA MORA -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="edad_mora" class="control-label">Edad de la mora: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="edad_mora_edit" id="edad_mora_edit" placeholder="Edad de la mora" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-infoEditFinanciero" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>