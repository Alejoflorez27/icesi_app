<div id="modalEditVivActivos" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivActivos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_activo" name="id_activo" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">7. ACTIVOS DEL EVALUADO</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="otrosActEdit" class="control-label">Observación General: *
                            <!--<button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda">
                                    <i class="fa fa-info-circle"></i>
                                </button>-->
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input" id="otros" name="otros" required>
                                </select>-->
                                <textarea class="form-control input" style="height: 100px;" id="otrosActEdit" name="otrosActEdit"></textarea>
                                <!--<input type="text" class="form-control input" name="otrosAct" id="otrosAct" placeholder="Otros Activos Cuales?" required> -->
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL 
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarActEdit">
                        <div class="form-group">
                            <label for="otrosActEdit" class="control-label"></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="otros" name="otros" required>
                                </select>
                                <input type="text" class="form-control input" name="otrosActEdit" id="otrosActEdit" placeholder="Otros Cuales?" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y EVALUADO 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_familiar_act_edit" class="control-label">Propietario: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_familiar_act_edit" name="tipo_familiar_act_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA TIPO OTRO PROPIETARIO SE DESCRIBE CUAL 
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarPropietarioActEdit">
                        <div class="form-group">
                            <label for="otro_propietario_actEdit" class="control-label"></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="otros" name="otros" required>
                                </select>
                                <input type="text" class="form-control input" name="otro_propietario_actEdit" id="otro_propietario_actEdit" placeholder="Ingrese el propietario" required>
                            </div>
                        </div>
                    </div>-->
                    
                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE ACTIVO 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor_activo_edit" class="control-label">Valor Activo comercial($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_activo_edit" id="valor_activo_edit" placeholder="Valor de Activo Comercial" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA CANTIDAD DE VALOR DE ACTIVO 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor_activo_catastral_edit" class="control-label">Valor Activo catastral($): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="valor_activo_catastral_edit" id="valor_activo_catastral_edit" placeholder="Valor de Activo Catastral" required>
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA TIPO DE DESCRIPCIÓN 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion_general_viv_edit" class="control-label">Descripción General/Tenencia(Ubicación, Marca, ect): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="descripcion_general_viv_edit" id="descripcion_general_viv_edit" placeholder="Descripción General" required>
                            </div>
                        </div>
                    </div>-->

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditActivos" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>