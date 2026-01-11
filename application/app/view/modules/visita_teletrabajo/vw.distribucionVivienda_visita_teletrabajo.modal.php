<div id="modalEditVivDistribucion" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formVivDistribucion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_distribucion" name="id_distribucion" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">Distribución de la Vivienda</h4>
                </div>

                <div class="modal-body">
                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="tipo_espacio_edit" class="control-label">Habitaciones: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input" id="tipo_espacio_edit" name="tipo_espacio_edit" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA NUMERO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="numero_espacio_edit" class="control-label">Número de Espacios:*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="number" class="form-control input solo-mayuscula" name="numero_espacio_edit" id="numero_espacio_edit" placeholder="Número de Espacios" required>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="descripcion_edit" class="control-label">Descripción: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" id="descripcion_edit" name="descripcion_edit" placeholder="Descripción" required></textarea>
                                    </div>
                                </div>
                            </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-vivEditDristribucion" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>