<div id="modalEditSolicitud" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditSolicitud" role="form" method="post" enctype="multipart/form-data" autocomplete="off" class='hide'>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-edit-solicitud">Editar Solicitud</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="accionSolicitud" name="accionSolicitud" value="">
                    <input type="hidden" id="idSolicitud" name="idSolicitud" value="">
                    <input type="hidden" id="idCandidato" name="idCandidato" value="">


                    <div class="modal-body">
                        <div class="div-editar">
                            <!-- ENTRADA FECHA SOLICITUD -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="numero_doc" class="control-label">Fecha Solicitud:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="fecha_edit" id="fecha_edit" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA RESPONSABLE -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="numero_doc" class="control-label">Responable:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="responsable_edit" id="responsable_edit" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA CLIENTE -->
                            <div class="col-xs-12 col-sm-8 center-block">
                                <div class="form-group">
                                    <label for="combo" class="control-label">Cliente:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="cliente_edit" id="cliente_edit" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA COMBO -->
                            <div class="col-xs-12 col-sm-4 center-block">
                                <div class="form-group">
                                    <label for="combo" class="control-label">Combo:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="combo_edit" id="combo_edit" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DOCUMENTO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="tipo_id" class="control-label">Tipo Doc.:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="tipo_id_edit" name="tipo_id_edit" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA NRO DUCOMENTO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="numero_doc" class="control-label">Nro Doc.:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="documento_edit" id="documento_edit">
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA NOMBRE -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="nombre" class="control-label">Nombre:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="nombre_edit" id="nombre_edit">
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA APELLIDO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="apellido" class="control-label">Apellido:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="apellido_edit" id="apellido_edit">
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA PAIS -->
                            <div class="col-xs-12 col-sm-4 center-block">
                                <div class="form-group">
                                    <label for="pais_edit" class="control-label">País:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                        <select class="form-control input" id="pais_edit" name="pais_edit">
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- ENTRADA PARA DEPARTAMENTO -->
                            <div class="col-xs-12 col-sm-4 center-block">
                                <div class="form-group">
                                    <label for="departamento_edit" class="control-label">Departamento:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                        <select class="form-control input" id="departamento_edit" name="departamento_edit">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA CIUDAD -->
                            <div class="col-xs-12 col-sm-4 center-block">
                                <div class="form-group">
                                    <label for="id_ciudad_act_edit" class="control-label">Ciudad:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                        <select class="form-control input" id="id_ciudad_act_edit" name="id_ciudad_act_edit">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA LOCALIDAD -->
                            <div class="div-localidad hide">
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="localidad" class="control-label">Localidad:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                            <input type="text" class="form-control input solo-mayuscula" name="localidad_edit" id="localidad_edit">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA CORREO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="email" class="control-label">Correo:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="correo_edit" id="correo_edit">
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TELEFONO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="telefono" class="control-label">Teléfono:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="telefono_edit" id="telefono_edit">
                                    </div>
                                </div>
                            </div>



                            <!-- ENTRADA PARA DIRECCION -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="direccion" class="control-label">Dirección:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="direccion_edit" id="direccion_edit">
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA CARGO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="cargo_desempeno" class="control-label">Cargo:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-mayuscula" name="cargo_edit" id="cargo_edit">
                                    </div>
                                </div>
                            </div>


                            <!-- ENTRADA PARA OBSERVACION -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="observacion" class="control-label">Observación:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                            <textarea class="form-control input" name="observacion_edit" id="observacion_edit" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                                <button id="btn-edt-solicitud" type="submit" class="btn btn-primary">Guardar Solicitud</button>
                            </div>
                        </div>

                        <!-- ENTRADA PARA SERVICIOS ADICIONALES -->
                        <div class="div-add-srvadicionales">
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="valor_adicional" class="control-label">Valor:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                        <input type="text" class="form-control input solo-numero" name="valor_adicional" id="valor_adicional">
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA OBSERVACION VALOR ADICIONAL-->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <label for="observacion_adicional" class="control-label">Observación:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-commenting-o"></i></span>
                                            <textarea class="form-control input" name="observacion_adicional" id="observacion_adicional" rows="1" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                                <button id="btn-srv-adc" type="submit" class="btn btn-primary">Agregar Vlr Adicional</button>
                            </div>
                        </div>

                        <!-- ENTRADA PARA AGREGAR SERVICIOS-->
                        <div class="div-add-servicios">
                            <div class="col-xs-12 col-sm-12 center-block" style="
                                padding : 4px;
                                width : 100%;
                                height : 200px;
                                overflow-y : scroll; ">
                                <div class="col-xs-12 col-sm-12 center-block">
                                    <table class="table table-bordered table-striped " width="90%">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Productos</th>
                                                <th colspan="2">Servicios</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productos-edt"> </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <br>
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                                <button id="btn-add-srv" type="submit" class="btn btn-primary">Agregar Servicio</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>