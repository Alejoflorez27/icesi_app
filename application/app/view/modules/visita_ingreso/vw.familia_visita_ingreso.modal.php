<div id="modalAddFamilia" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formFamilia" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_familia" name="id_familia" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-familia">Datos Familiares</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA EL PARENTESCO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="parentesco_edit" class="control-label">Parentesco: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<!--<select class="form-control input" id="parentesco_edit" name="parentesco_edit" placeholder="Parentesco Evaluado" required>
                                </select>-->
                                <input type="text" class="form-control input" name="parentesco_edit" id="parentesco_edit" placeholder="Parentesco con el Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE FAMILIAR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre_edit" class="control-label">Nombre del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nombre_edit" id="nombre_edit" placeholder="Nombre del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA APELLIDO FAMILIAR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="apellido_edit" class="control-label">Apellido del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="apellido_edit" id="apellido_edit" placeholder="Apellido del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA IDENTIFICACION -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="identificacion_edit" class="control-label">Identificación del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="identificacion_edit" id="identificacion_edit" placeholder="Identificación del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EDAD FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="edad_edit" class="control-label">Edad del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="edad_edit" id="edad_edit" placeholder="Edad del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="telefono_edit" class="control-label">Número de contacto del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="telefono_edit" id="telefono_edit" placeholder="Número del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD DEL FAMILIAR --> 
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="nivel_escolar_edit" class="control-label">Nivel Escolaridad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="nivel_escolar_edit" name="nivel_escolar_edit" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OCUPACIÓN FAMILIAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="ocupacion_edit" class="control-label">Ocupación del Familiar: *
                                <button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalOcuFamilia" title="Colocar en las ocupaciones, cargo, empresa y tiempo laborado, si son independientes-que labor independiente y tiempo. Si son estudiantes colocar curso o semestre y nombre del colegio y universidad. Si es pensionado de donde es pensionado y hace cuanto.">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input" name="ocupacion_edit" id="ocupacion_edit" placeholder="(Cargo o labor que realiza) Nombre de la empresa / Tiempo o Institución Educativa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE EMPRESA DEL FAMILIAR 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="empresa_edit" class="control-label">Nombre de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="empresa_edit" id="empresa_edit" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA ESTADO CIVIL FAMILIAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="estado_civil_edit" class="control-label">Estado Civil del Familiar:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <select class="form-control input" id="estado_civil_edit" name="estado_civil_edit" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>
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
                    <!-- ENTRADA PARA RECIDENCIA 
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="residencia" class="control-label">Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="residencia_edit" id="residencia_edit" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA VIVE CON EL Evaluado -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="viv_candidato_edit" class="control-label">Vive con el Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="viv_candidato_edit" name="viv_candidato_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA DEPENDE ECONOMICAMENTE DEL Evaluado -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="depende_candidato_edit" class="control-label">Depende económicamente del Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="depende_candidato_edit" name="depende_candidato_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-familiaa" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>