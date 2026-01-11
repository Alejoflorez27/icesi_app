<div id="modalAddVivSector" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formSectorViv" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_sector" name="id_sector" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-combo">Caracteristicas del Sector</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA TIPO SECTOR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sector" class="control-label">Sector: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="sector" name="sector" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA ESTRACTO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="estracto" class="control-label">Estrato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input" name="estracto" id="estracto" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO UBICACION DEL SECTOR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="ubicacion_sector" class="control-label">Ubicación del Sector: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="ubicacion_sector" name="ubicacion_sector" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO TIEMPO DE DESPLAZAMIENTO AL TRABAJO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tmp_ida_trabajo" class="control-label">Tiempo de Desplazamiento al Lugar de Trabajo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tmp_ida_trabajo" name="tmp_ida_trabajo" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ENTRADA PARA TIEMPO EN LA VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tmp_en_vivienda" class="control-label">Tiempo que he estado en la actual vivienda (Arraigo): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="tmp_en_vivienda" id="tmp_en_vivienda" placeholder="Tiempo en la Vivienda" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LAS ZONAS VERDES -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="zonas_verdes" class="control-label">Puntos de Referencia (Lugares representativos del sector, almacenes de cadena, entidades
educativas, centros comerciales, centros de salud, etc): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="zonas_verdes" id="zonas_verdes" placeholder="Puntos de Referencia" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LAS VIAS PRINCIPALES -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="vias_principales" class="control-label">Principales Vías de Acceso y Estado de las vías:(Realizar una descripción genérica de las vías de acceso al espacio habitacional del evaluado) *</label>
                            <button class="btn btn-primary btnPlantilla" type="button" title="Ayuda" data-toggle="modal" data-target="#modalAyuda">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" name="vias_principales" id="vias_principales" placeholder="Principales Vías de Acceso y Estado de las vías" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ESTADO SECTOR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="estado_sector" class="control-label">Seguridad del Sector: (Problemáticas del sector) *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <!--<select class="form-control input" id="estado_sector" name="estado_sector" required>
                                </select>-->
                                <input type="text" class="form-control input" name="estado_sector" id="estado_sector" placeholder="Seguridad del Sector" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA EL CONCEPTO DEL VECINO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_vecino" class="control-label">Concepto del Vecino *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="concepto_vecino" name="concepto_vecino" placeholder="( Preguntar nombre y número de contacto del vecino- que puede ser el arrendador, el vigilante etc,- y  validar hace cuanto lo conoce, con quienes vive y el sitio de vivienda. Se pregunta además el concepto del evaluado, en su relación con su comunidad.)"></textarea>
                                <!--<input type="text" class="form-control input solo-mayuscula" name="concepto_vecino" id="concepto_vecino" placeholder="(Describa los comentarios y observaciones de la validación del evaluado con vecinos y personas del entorno)" required>-->
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-sectorViv" type="submit" class="btn btn-primary">Guardar Caracteristica sector</button>
                </div>
            </form>
        </div>
    </div>
</div>