<div id="modalAddDimConcepto" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formCaracteristicaViv" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_caracteristica" name="id_caracteristica" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-dimension">Concepto Matriz</h4>
                </div>

                <div class="modal-body">

                    <!-- ENTRADA PARA TIPO ESTADO VIVIENDA 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_vivienda_estado" class="control-label">Estado De Vivienda: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_vivienda_estado" name="tipo_vivienda_estado" required>
                                </select>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA OBSERVACIONES DE CARACTERISTICAS DE LA VIVIENDA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="dimObservacion" class="control-label">Observación de Matriz: *
                                <button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalAyuda" title="Ayuda: Anotar en las dimensiones familiar, habitacional y del sector, salud y actitud del 
evaluado los cambios y riesgos encontrados. Dimensión económica. (a) y (conyugue)
aportan el presupuesto familiar, denotándose una economía …( equilibrada, en 
desequilibrio,ajustada.) No se han presentado cambios en los ingresos y egresos, 
nivel de endeudamiento y patrimonio, si se han presentado enunciarlos y sino 
solamente se deja No se han presentadocambios. Si se evidencian riesgos en las 
variables evaluadas enunciarlos.

Producto del análisis socioeconómico comparativo de la visita realizada hace 
aproximadamente hace 2 años, la cual fue suministrada y la visita actual, se 
establece lo siguiente. (Analizar al detalle el aspecto económico) En el factor 
económico se advierte.">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="dimObservacion" name="dimObservacion" placeholder="Anotar las señales de alerta o riesgos encontrados en esta variable."></textarea>
                            </div>
                        </div>
                    </div>                

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button id="btn-submit-dimconcepto" type="submit" class="btn btn-primary btnAddConceptoDim">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>