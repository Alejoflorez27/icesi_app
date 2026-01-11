<div id="modalAddServicio" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formServicio" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_servicio" name="id_servicio" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-servicio">Servicio</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA PRODUCTO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="producto" class="control-label">Producto: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                                <select class="form-control input" id="producto" name="producto" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA SERVICIO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nom_servicio" class="control-label">Nombre Servicio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-align-justify"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nom_servicio" id="nom_servicio" placeholder="Ingrese el nombre del servicio">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA TIPO SERVICIO-->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_servicio" class="control-label">Gestión Servicio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                <select class="form-control input" id="tipo_servicio" name="tipo_servicio">
                                    <option value="M">Manual</option>
                                    <option value="F">Formulario</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA VALOR ADICIONAL-->
                    <div class="col-xs-6 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_servicio" class="control-label">Valor Adicional: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                <select class="form-control input" id="valor_adicional" name="valor_adicional">
                                    <option value="N">No</option>
                                    <option value="S">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="div-tipo-servicio">
                        <!-- ENTRADA REPORTE-->
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="reporte" class="control-label">Nombre Reporte: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-header"></i></span>
                                    <input type="text" class="form-control input solo-mayuscula" name="reporte" id="reporte" placeholder="Ingrese el nombre del reporte">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="ruta_reporte" class="control-label">Ingrese La Ruta del Reporte: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                    <input type="text" class="form-control input solo-mayuscula" name="ruta_reporte" id="ruta_reporte" placeholder="Ingrese la ruta del reporte">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="div-valor-servicio">
                        <!-- ENTRADA REPORTE-->
                        <div class="col-xs-6 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="reporte" class="control-label">Valor Bogotá: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <input type="text" class="form-control input solo-numero" name="valor_bogota" id="valor_bogota" placeholder="Ingrese el valor para Bogotá">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="ruta_reporte" class="control-label">Valor Fuera Bogotá: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <input type="text" class="form-control input solo-numero" name="valor_fuera_bogota" id="valor_fuera_bogota" placeholder="Ingrese el valor fuera Bogotá">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA ESTADO -->
                    <div class="div-editar">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="estado" class="control-label">Estado: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                    <select class="form-control input" id="estado" name="estado">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-servicio" type="submit" class="btn btn-primary">Guardar Servicio</button>
                </div>
            </form>
        </div>
    </div>
</div>