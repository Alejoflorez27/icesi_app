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
                    <!-- ENTRADA PARA TIPO ESPACIOS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_espacio_edit" class="control-label">Tipo De Espacios: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_espacio_edit" name="tipo_espacio_edit" disabled>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CANTIDAD -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarCantidadEdit">
                        <div class="form-group">
                            <label for="numero_espacio_edit" class="control-label">Cantidad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="numero_espacio_edit" id="numero_espacio_edit" placeholder="Número de Espacios" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OCUPANTE -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarOcupanteEdit">
                        <div class="form-group">
                            <label for="ocupante_edit" class="control-label">Ocupante: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <input type="text" class="form-control input" id="ocupante_edit" name="ocupante_edit" required>
                                </input>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DESCRIPCION -->
                    <div class="col-xs-12 col-sm-12 center-block" id="ocultarDescripcionEdit">
                        <div class="form-group">
                            <label for="descripcion_edit" class="control-label">Descripción : *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="descripcion_edit" name="descripcion_edit" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 center-block">
                        <div style="color:red;">
                            Campos señalados con * son obligatorios
                        </div>    
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