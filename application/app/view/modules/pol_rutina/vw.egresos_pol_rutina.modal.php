<div id="modalEditVivEgresos" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivEgresos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_ingreso" name="id_ingreso" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">5. EGRESOS MENSUALES DEL EVALUADO</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y EVALUADO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_familiar_egre_edit" class="control-label">Integrante: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="tipo_familiar_egre_edit" id="tipo_familiar_egre_edit" placeholder="Integrante de la Familia" required>
                            </div>
                        </div>
                    </div> -->

                    <!-- ENTRADA PARA TIPO CONCEPTO DEL EGRESO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_ingreso_edit" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="concepto_ingreso_edit" name="concepto_ingreso_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="otrosEdit" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input" id="otros" name="otros" required>
                                </select>-->
                                <input type="text" class="form-control input" name="otrosEdit" id="otrosEdit" placeholder="Otros Cuales?" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO PERIOCIDAD DEL EGRESO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="periocidad_edit" class="control-label">Periodicidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="periocidad_edit" name="periocidad_edit" required>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE EGRESOS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="valor_egreso_edit" class="control-label">Valor egreso ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_egreso_edit" id="valor_egreso_edit" placeholder="Valor de egreso" required>
                            </div>
                        </div>
                    </div>

                  <!-- ENTRADA PARA CANTIDAD DE VALOR DE EGRESOS 
                  <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="total_egresoVI_edit" class="control-label">Total del egreso ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="total_egresoVI_edit" id="total_egresoVI_edit" placeholder="Valor total del egreso" required>
                            </div>
                        </div>
                    </div> -->

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditEgresos" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>