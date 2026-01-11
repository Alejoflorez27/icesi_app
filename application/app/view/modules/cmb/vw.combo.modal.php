<div id="modalAddCombo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCombo" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_combo" name="id_combo" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-combo">Combo</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA NOMBRE COMBO-->
                    <div class="col-xs-12 col-sm-9 center-block">
                        <div class="form-group">
                            <label for="nom_combo" class="control-label">Nombre: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nom_combo" id="nom_combo" placeholder="Ingrese el nombre del combo">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA ENVIA CORREO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="env_correo" class="control-label">Envía Correo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-toggle-on"></i></span>
                                <select class="form-control input" id="env_correo" name="env_correo">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA VALOR BOGOTÁ-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor" class="control-label">Valor Bogotá: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                <input type="text" class="form-control input solo-numero" name="valor_bogota" id="valor_bogota" placeholder="Ingrese el valor del combo para Bogotá">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA SLA BOGOTÁ-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sla" class="control-label">SLA Bogotá: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                                <input type="text" class="form-control input solo-numero" name="sla_bogota" id="sla_bogota" placeholder="Ingrese el SLA del combo para Bogotá">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA VALOR FUERA BOGOTÁ-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="valor" class="control-label">Valor  Fuera Bogotá: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                <input type="text" class="form-control input solo-numero" name="valor_externo" id="valor_externo" placeholder="Ingrese el valor del combo para Fuera Bogotá">
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA SLA FUERA BOGOTÁ-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="sla" class="control-label">SLA  Fuera Bogotá: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                                <input type="text" class="form-control input solo-numero" name="sla_externo" id="sla_externo" placeholder="Ingrese el SLA del combo para Fuera Bogotá">
                            </div>
                        </div>
                    </div>



                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-combo" type="submit" class="btn btn-primary">Guardar Combo</button>
                </div>
            </form>
        </div>
    </div>
</div>