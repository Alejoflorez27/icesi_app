<div id="modalAddReferencia" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formReferencias" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_ref_personal" name="id_ref_personal" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-referencias">5.REFERENCIAS PERSONALES Y OBSERVACIÓN ADICIONAL</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA REFERENCIA PERSONAL  
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="referencia_personal_edit" class="control-label">Referencia Personal: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="referencia_personal_edit" name="referencia_personal_edit" required></textarea>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA EL NOMBRE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre_edit" class="control-label">Nombre: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_edit" id="nombre_edit" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NÙMERO DE TELEFONO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="telefono_edit" class="control-label">Telefono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="telefono_edit" id="telefono_edit" placeholder="Ingrese el telefono" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONCEPTO  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_edit" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="concepto_edit" name="concepto_edit" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIÓN Y HALLAZGOS  
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="observacion_adicional" class="control-label">Observaciones Adicionales: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="observacion_adicional" name="observacion_adicional" required></textarea>
                            </div>
                        </div>
                    </div>-->

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-referencias" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>