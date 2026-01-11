<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$servicioId = $router->param('id_servicio');
$resp_menu = CtrMenuFormatos::findAll($servicioId);
//print_r($resp_menu);

$servicio = null;
if (Result::isSuccess($resp_menu))
    $servicio = Result::getData($resp_menu);
//print_r($servicio);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>
  <section class="content-header">
    <div class="row">
      <div class="col-xs-12 col-sm-8">
        <h3>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h3>
      </div>

      <div class="col-xs-12 col-sm-4">
        <div class="box box-primary collapsed-box" style="position: absolute; top: 0; right: 0; z-index: 9999;">
          <div class="box-header with-border">
            <h3 class="box-title">MENÚ <?= $servicio[0]['nom_servicio'] ?></h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool btn-primary" data-widget="collapse"><i class="fa fa-bars"></i></button>
              <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
            </div>
          </div>

          <div class="box-body">
            <!-- Contenido de tu tabla -->
            <ul>
              <!-- <h1></h1>  -->
              <?php 
                foreach ($servicio as $file) : ?>
                    

                    <li style="margin-left:0px;">
                        <a href="<?= $file['url']. '?id_solicitud='.$solicitudId.'&id_servicio='.$servicioId ?>"><?= $file['nombre'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

          </div>

          <div class="box-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-flat pull-left" data-widget="collapse">Cerrar</a>
            <button id="btn-submit-solicitud" type="submit" class="btn btn-sm btn-success btnSolicitudVolver">Solicitud</button>
          </div>
        </div>
      </div>
    </div>
  </section>

<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">7. LAS PREGUNTAS RELEVANTES FUERON LAS SIGUIENTES:</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formPreguntas" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_preg_relevante" name="id_preg_relevante" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                

            <div class="box-body">

                    <!-- ENTRADA PARA TIPO CONCEPTO FINANCIERO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_rn" class="control-label">Tipo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2 " id="tipo_rn" name="tipo_rn" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CONCEPTO FINANCIERO COMPLETO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="pregunta" class="control-label">Pregunta:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="pregunta" name="pregunta"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DE ESTADO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="resp_candidato" class="control-label">Respuesta Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="resp_candidato" name="resp_candidato" required>
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
                            <label for="calificacion" class="control-label">Calificación de la pregunta con polígrafo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <div class="btn-group" data-toggle="buttons">
                                    <!-- Generar botones de radio para la escala del -9 al 9 -->
                                    <?php
                                    for ($i = -15; $i <= 15; $i++) {
                                        $id = "calificacion_$i"; // Identificador único basado en el valor de la calificación
                                        echo "<label class=\"btn btn-default\">";
                                        echo "<input type=\"radio\" name=\"calificacion\" id=\"$id\" value=\"$i\" autocomplete=\"off\">$i";
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

                    <div class="modal-footer">
                        <button id="btn-submit-preguntas" type="submit" class="btn btn-primary btnAddPreguntas">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
            <div class="box-header with-border">
                </div>

                <div class="box-body">
                    <table id="tbl-preguntas" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <!--<th>Persona Evaluada</th>-->
                                <th>Tipo</th>
                                <th>Pregunta</th>
                                <th>Respuesta Evaluado</th>
                                <th>Califición de la pregunta con el polígrafo</th>
                                <!--<th>Resultado</th>-->
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h2><strong>Resultado de la Prueba es:</strong></h2>
                        </div>
                        <div class="col-xs-12 col-sm-6 center-block">
                            <h1 id="total_ingreso"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.preguntas_relevantes_pol_especifico.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_especifico/preguntas_relevantes_pol_especifico.js"></script>
