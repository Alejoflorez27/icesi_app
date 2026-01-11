<div id="modalAddDimensionCompromiso" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formDimensionCompromisoedit" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="5">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-dimensionFamilia">27. ACTITUD Y COMPROMISO DEL EVALUADO CON EL PROCESO</h4>
                </div>


                <div class="modal-body">
                    <!-- ENTRADA PARA EL VARIABLE A ANALIZAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="variableCompromisoEdit" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input" id="variableCompromisoEdit" name="variableCompromisoEdit" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA DESCRIPCION POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion_edit" class="control-label">Informacion completa de variable a Analizar: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="descripcion_edit" name="descripcion_edit" readonly ></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE RIESGO --> 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nivel_riesgoEdit" class="control-label">Nivel de actitud identificada (si no se escribió nada, al guardar emitir un mensaje): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="nivel_riesgoEdit" name="nivel_riesgoEdit" placeholder="Nivel de riesgo" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA INFORME POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="respuestaEdit" class="control-label">Informe por Variable: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="respuestaEdit" name="respuestaEdit"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-dimensionEditCompromiso" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>