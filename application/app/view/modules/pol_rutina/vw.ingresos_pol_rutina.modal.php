<div id="modalEditVivIngresos" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivIngresos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_ingreso" name="id_ingreso" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">4. INGRESOS MENSUALES DEL EVALUADO</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y Evaluado 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_familiar_edit" class="control-label">Integrante: *
                                <button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="tipo_familiar_edit" id="tipo_familiar_edit" placeholder="Integrante de la Familia" required>
                            </div>
                        </div>
                    </div> -->

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE INGRESOS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="valor_ingreso_edit" class="control-label">Valor Ingreso ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_ingreso_edit" id="valor_ingreso_edit" placeholder="Valor de Ingresos" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE APORTE 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="valor_aporte_edit" class="control-label">Valor Aporte ($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input" name="valor_aporte_edit" id="valor_aporte_edit" placeholder="Valor Aporte" required>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA CANTIDAD DE DONDE PROVIENE -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="ingreso_proveniente_edit" class="control-label">Donde Proviene: *
                                <button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda1">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="ingreso_proveniente_edit" id="ingreso_proveniente_edit" placeholder="De Donde Proviene" required>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditIngresos" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>