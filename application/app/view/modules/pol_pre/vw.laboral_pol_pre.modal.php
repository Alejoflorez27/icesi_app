<div id="modalAddLaboral" class="modal fade" role="dialog" style="z-index: 9999;">
    <div data-target=".bs-modal-lg">
        <div class="modal-content">
            <form id="formLaboral" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_laboral" name="id_laboral" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-laboral">10. TRAYECTORIA LABORAL</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA NOMBRE EMPRESA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre_empresa_edit" class="control-label">Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_empresa_edit" id="nombre_empresa_edit" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO AL QUE INGRESO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_ingreso_edit" class="control-label">Cargo inicial desempeñado / Área: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_ingreso_edit" id="cargo_ingreso_edit" placeholder="Cargo al que Ingreso el Evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO EL QUE FINALIZÓ -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_finalizo_edit" class="control-label">Último cargo desempeñado / Área: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_finalizo_edit" id="cargo_finalizo_edit" placeholder="Último cargo del Evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE INGRESO --> 
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_ingreso_edit" class="control-label">Fecha de Ingreso: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_ingreso_edit" id="fch_ingreso_edit" placeholder="Fecha de Ingreso de Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_retiro_edit" class="control-label">Fecha de Retiro:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_retiro_edit" id="fch_retiro_edit" placeholder="Fecha de Retiro de Empresa">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tmp_total_laborado_edit" class="control-label">Tiempo total laborado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="tmp_total_laborado_edit" id="tmp_total_laborado_edit" placeholder="Tiempo total laborado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL TIPO DE MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_retiro_edit" class="control-label">Motivo de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="tipo_retiro_edit" name="tipo_retiro_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA MOTIVO DE RETIRO
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="motivo_retiro_edit" class="control-label">Motivo Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="motivo_retiro_edit" id="motivo_retiro_edit" placeholder="Motivo Retiro" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA PAIS DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="pais_edit" class="control-label">País Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input" id="pais_edit" name="pais_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DEPARTAMENTO DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="departamento_edit" class="control-label">Departamento:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select class="form-control input" id="departamento_edit" name="departamento_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CIUDAD -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act_edit" class="control-label">Ciudad de Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input" id="id_ciudad_act_edit" name="id_ciudad_act_edit" placeholder="Ingrese Residencia del Familiar" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA FUNCIONES DESARROLLADAS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="funciones_desarrolladas_edit" class="control-label">Principales actividades o responsabilidades del cargo:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <textarea class="form-control input" id="funciones_desarrolladas_edit" name="funciones_desarrolladas_edit" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIÓN  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="observaciones_edit" class="control-label">Observación: *
                                <!--<button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalPlantilla">
                                    <i class="fa fa-info-circle"></i>
                                </button>-->
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="observaciones_edit" name="observaciones_edit" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-laborall" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>