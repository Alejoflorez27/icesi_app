<div id="modalEditPreguntas" class="modal fade" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formPreguntas" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_preg_relevante" name="id_preg_relevante" value="">

                <div class="modal-header" id="div-crear">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="titulo-modal-distribucion">8. LAS PREGUNTAS RELEVANTES FUERON LAS SIGUIENTES</h4>
                </div>

                <div class="modal-body">
                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_rn_edit" class="control-label">Tipo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_rn_edit" name="tipo_rn_edit" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CONCEPTO FINANCIERO COMPLETO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="pregunta_edit" class="control-label">Pregunta:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="pregunta_edit" name="pregunta_edit"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE ESTADO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="resp_candidato_edit" class="control-label">Respuesta Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="resp_candidato_edit" name="resp_candidato_edit" required>
                                <option value="selecione">- Seleccione -</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIONES -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="calificacion_edit" class="control-label">Calificación de la pregunta con polígrafo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <div class="btn-group" data-toggle="buttons">
                                    <!-- Generar botones de radio para la escala del -9 al 9 -->
                                    <?php
                                    for ($i = -15; $i <= 15; $i++) {
                                        $id = "calificacion_edit$i"; // Identificador único basado en el valor de la calificación
                                        echo "<label class=\"btn btn-default\">";
                                        echo "<input type=\"radio\" name=\"calificacion_edit\" id=\"$id\" value=\"$i\" autocomplete=\"off\">$i";
                                        echo "</label>";
                                    }
                                    ?>
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
                    <button id="btn-submit-vivEditPreguntas" type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>