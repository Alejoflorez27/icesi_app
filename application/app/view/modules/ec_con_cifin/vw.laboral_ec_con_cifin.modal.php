<div id="modalAddLaboral" class="modal fade" role="dialog">
    <div data-target=".bs-modal-lg">
        <div class="modal-content">
            <form id="formLaboral" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_laboral" name="id_laboral" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-laboral">7. VERIFICACIÓN DE CONFIABILIDAD Y COHERENCIA DE LA INFORMACIÓN E HISTORIA LABORAL</h4>
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
                    <!-- ENTRADA PARA TELÉFONO EMPRESA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono_empresa_edit" class="control-label">Teléfolo de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="telefono_empresa_edit" id="telefono_empresa_edit" placeholder="Teléfono de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE DEL FUNCIONARIO QUE CONFIRMA LA INFORMACIÓN -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="jefe_inmediato_edit" class="control-label">Nombre del funcionario que confirma la informacion: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="jefe_inmediato_edit" id="jefe_inmediato_edit" placeholder="Nombre del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CARGO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_jefe_edit" class="control-label">Cargo / Área:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_jefe_edit" id="cargo_jefe_edit" placeholder="Cargo del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL ESTADO ACTUAL DE LA EMPRESA  -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="estado_empresa_edit" class="control-label">Estado actual de la empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="estado_empresa_edit" name="estado_empresa_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO AL QUE INGRESO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_ingreso_edit" class="control-label">Cargo inicial desempeñado / Área: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_ingreso_edit" id="cargo_ingreso_edit" placeholder="Cargo al que Ingreso el evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO EL QUE FINALIZÓ -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_finalizo_edit" class="control-label">Último cargo desempeñado / Área: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_finalizo_edit" id="cargo_finalizo_edit" placeholder="Último cargo del evaluado">
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
                            <label for="fch_retiro_edit" class="control-label">Fecha de Retiro: *</label>
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
                    <!-- ENTRADA PARA EL TIPO DE CONTRATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_contrato_edit" class="control-label">Tipo de Contrato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="tipo_contrato_edit" name="tipo_contrato_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL TIPO DE MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_retiro_edit" class="control-label">Tipo de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="tipo_retiro_edit" name="tipo_retiro_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="motivo_retiro_edit" class="control-label">Motivo Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="motivo_retiro_edit" id="motivo_retiro_edit" placeholder="Motivo Retiro" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL HORARIO DE TRABAJO (JORNADA) -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="horario_trabajo_edit" class="control-label">Horario de trabajo (jornada): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="horario_trabajo_edit" name="horario_trabajo_edit" required>
                                </select>
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
                    <div class="col-xs-12 col-sm-12 center-block">
                        <h3><strong>Verificación por parte del jefe</strong></h3>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE DEL JEFE QUE CONFIRMA LA INFORMACIÓN -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="nom_jefe_valida_edit" class="control-label">Nombre del jefe que valida la información: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nom_jefe_valida_edit" id="nom_jefe_valida_edit" placeholder="Nombre del Jefe">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CARGO DEL JEFE -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="cargo_jefe_valida_edit" class="control-label">Cargo del jefe que valida la información:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_jefe_valida_edit" id="cargo_jefe_valida_edit" placeholder="Cargo del Jefe">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="numero_jefe_edit" class="control-label">Número Jefe Inmediato:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="numero_jefe_edit" id="numero_jefe_edit" placeholder="Número del Jefe">
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

                    <div class="col-xs-12 col-sm-12 center-block">
                        <h3><strong>Concepto desempeño laboral</strong></h3>
                        <h4><strong>Criterios evaluados:</strong><br><br>
                            1.	Principales aspectos que destaca del evaluado<br>
                            2.	Manejo de información de información confidencial <br>
                            3.	Nivel de confiabilidad del evaluado (valores, cumplimiento de las normas, ética profesional) <br>
                            4.	Capacidad de aprendizaje<br>
                            5.	Capacidad de adaptación al cargo<br>
                            6.	Relaciones con jefes y pares <br>
                            7.	Aspectos a mejorar y observaciones<br>

                        </h4>
                    </div>

                    <!-- ENTRADA PARA FUNCIONES DESARROLLADAS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_edit" class="control-label">Concepto:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <textarea class="form-control input" id="concepto_edit" name="concepto_edit" placeholder="CONCEPTO: El concepto debe integrar todos los aspectos mencionados anteriormente. Dos o tres párrafos" required></textarea>
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