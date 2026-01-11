<div id="modalAddVivCaracteristica" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCaracteristicaViv" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_caracteristica" name="id_caracteristica" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-combo">4. DESCRIPCIÓN DE LUGAR DE RESIDENCIA</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA DIRECCION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="direccion" class="control-label">Dirección de residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input class="form-control input" id="direccion" name="direccion" required></input>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA telefono -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Teléfono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input class="form-control input" id="telefono" name="telefono" required></input>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA barrio -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="barrio" class="control-label">Barrio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input class="form-control input" id="barrio" name="barrio" required></input>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA estrato -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="estrato" class="control-label">Estrato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input class="form-control input" id="estrato" name="estrato" required></input>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA zona -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="zona" class="control-label">Zona: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="zona" name="zona" required>
                                </select>
                            </div>
                        </div>
                    </div>

                <!-- Descripcion el entorno -->

                    <!-- ENTRADA PARA ambiente -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="ambiente" class="control-label">Ambiente: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="ambiente" name="ambiente" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA sector -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="sector" class="control-label">Sector: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="sector" name="sector" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA lugar -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="lugar" class="control-label">Lugar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="lugar" name="lugar" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO VIVIENDA -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="tipo_vivienda" class="control-label">Tipo De Vivienda: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_vivienda" name="tipo_vivienda" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA tipo_construccion -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_vivienda_estado" class="control-label">Tipo de construcción: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_vivienda_estado" name="tipo_vivienda_estado" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO TENENCIA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_tenencia" class="control-label">Tipo de Tenencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_tenencia" name="tipo_tenencia" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO TAMAÑO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tipo_tamano_vivienda" class="control-label">Tamaño aproximado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_tamano_vivienda" name="tipo_tamano_vivienda" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO ESTADO VIVIENDA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="limpieza" class="control-label">Organización y limpieza: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="limpieza" name="limpieza" required>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA OBSERVACIONES DE CARACTERISTICAS DE LA VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="aclaracion_viv" class="control-label">Descripción de la seguridad del sector y de la residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="aclaracion_viv" name="aclaracion_viv" placeholder="Descripción de la seguridad del sector"></textarea>
                            </div>
                        </div>
                    </div>                  

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-caracteristicaViv" type="submit" class="btn btn-primary">Guardar Caracteristica</button>
                </div>
            </form>
        </div>
    </div>
</div>