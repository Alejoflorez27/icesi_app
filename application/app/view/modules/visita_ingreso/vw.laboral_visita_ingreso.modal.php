<div id="modalAddLaboral" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formLaboral" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_laboral" name="id_laboral" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-laboral">Información Laboral</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA NOMBRE EMPRESA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre_empresa_edit" class="control-label">Nombre de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_empresa_edit" id="nombre_empresa_edit" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TELÉFONO EMPRESA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="telefono_empresa_edit" class="control-label">Teléfolo de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="telefono_empresa_edit" id="telefono_empresa_edit" placeholder="Teléfono de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE INGRESO --> 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="fch_ingreso_edit" class="control-label">Fecha de Ingreso de Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_ingreso_edit" id="fch_ingreso_edit" placeholder="Fecha de Ingreso de Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE RETIRO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="fch_retiro_edit" class="control-label">Fecha de Retiro de Empresa:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_retiro_edit" id="fch_retiro_edit" placeholder="Fecha de Retiro de Empresa">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO AL QUE INGRESO 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="cargo_ingreso_edit" class="control-label">Cargo al que Ingreso:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_ingreso_edit" id="cargo_ingreso_edit" placeholder="Cargo al que Ingreso el Evaluado">
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA CARGO EL QUE FINALIZÓ -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="cargo_finalizo_edit" class="control-label">Último cargo:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_finalizo_edit" id="cargo_finalizo_edit" placeholder="Último cargo del Evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL TIPO DE CONTRATO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_contrato_edit" class="control-label">Tipo de Contrato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="tipo_contrato_edit" name="tipo_contrato_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="jefe_inmediato_edit" class="control-label">Jefe Inmediato:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="jefe_inmediato_edit" id="jefe_inmediato_edit" placeholder="Nombre del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CARGO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="cargo_jefe_edit" class="control-label">Cargo Jefe Inmediato:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_jefe_edit" id="cargo_jefe_edit" placeholder="Cargo del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="numero_jefe_edit" class="control-label">Número Jefe Inmediato:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="numero_jefe_edit" id="numero_jefe_edit" placeholder="Número del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FUNCIONES DESARROLLADAS 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="funciones_desarrolladas_edit" class="control-label">Funciones Desarrolladas:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="funciones_desarrolladas_edit" id="funciones_desarrolladas_edit" placeholder="Ingrese las Funciones Desarrolladas">
                            </div>
                        </div>
                    </div>-->

                    <!-- ENTRADA PARA EL TIPO DE MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_retiro_edit" class="control-label">Tipo de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="tipo_retiro_edit" name="tipo_retiro_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA MOTIVO DE RETIRO --> 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="motivo_retiro_edit" class="control-label">Motivo Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="motivo_retiro_edit" id="motivo_retiro_edit" placeholder="Motivo Retiro" required>
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