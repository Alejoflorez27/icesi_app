<div id="modalEditVivPasivos" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivPasivos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_pasivo" name="id_pasivo" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">12. PASIVOS DEL EVALUADO (CONYUGUE SI APLICA Y DEUDAS EN COMUN)</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA TIPO CONCEPTO DEL PASIVO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_pasivo_edit" class="control-label">Tipo Pasivo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="concepto_pasivo_edit" name="concepto_pasivo_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarEdit">
                        <div class="form-group">
                            <label for="otrosEdit" class="control-label"></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input" id="otros" name="otros" required>
                                </select>-->
                                <input type="text" class="form-control input" name="otrosEdit" id="otrosEdit" placeholder="Otros Cuales?" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y CANDIDATO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_familiar_edit" class="control-label">Responsable: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_familiar_edit" name="tipo_familiar_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO OTRO PROPIETARIO SE DESCRIBE CUAL -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarPropietarioPasEdit">
                        <div class="form-group">
                            <label for="otro_propietario_pasEdit" class="control-label"></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input" id="otros" name="otros" required>
                                </select>-->
                                <input type="text" class="form-control input" name="otro_propietario_pasEdit" id="otro_propietario_pasEdit" placeholder="Ingrese el propietario" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE PASIVO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="valor_pasivo_edit" class="control-label">Saldo pendiente por pagar ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_pasivo_edit" id="valor_pasivo_edit" placeholder="Valor de Pasivo" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE PLAZO PASIVO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="plazo_pasivo_edit" class="control-label">Plazo Pasivo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="plazo_pasivo_edit" name="plazo_pasivo_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE LA COUTA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="couta_edit" class="control-label">Cuota mensual: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="couta_edit" id="couta_edit" placeholder="Cuota mensual" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE PLAZO DEL PASIVO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="estado_obligacion_edit" class="control-label">Estado de la obligación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="estado_obligacion_edit" name="estado_obligacion_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA EL VALOR DE LA MORA -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultar_valor_edit">
                        <div class="form-group">
                            <label for="valor_mora_edit" class="control-label">Valor de la mora: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_mora_edit" id="valor_mora_edit" placeholder="Valor de la mora" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditPasivos" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>