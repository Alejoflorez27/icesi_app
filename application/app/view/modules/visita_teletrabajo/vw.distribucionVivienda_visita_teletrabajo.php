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

<div class="row">
    <div class="col-xs-6 col-sm-12 center-block">
        <!-- Distribución de la vivienda-->
        <section class="content-header">
        <div class="box box-primary">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 center-block">
                        <h4 class="box-title">5. DISTRIBUCIÓN DE LA VIVIENDA</h4>
                    </div>
                    <div class="col-xs-12 col-sm-6 center-block">
                        <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                        <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                    </div>
                </div>
            </div>
            <form id="formVivDistribucion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_distribucion" name="id_distribucion" value="">
                        <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

                    <div class="box-body">

                            <!-- ENTRADA PARA TIPO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="tipo_espacio" class="control-label">Habitaciones: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="tipo_espacio" name="tipo_espacio" required>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA NUMERO DE ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="numero_espacio" class="control-label">Número de Espacios:*</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="number" class="form-control input solo-mayuscula" name="numero_espacio" id="numero_espacio" placeholder="Número de Espacios" required>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" id="descripcion" name="descripcion" placeholder="Descripción" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div style="color:red;">
                                Campos señalados con * son obligatorios
                            </div>                    

                            <div class="modal-footer">
                                <button id="btn-submit-vivDristribucion" type="submit" class="btn btn-primary btnAddVivDistribucion">Guardar</button>
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

                            <table id="tbl-vivDistribucion" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Habitaciones</th>
                                        <th>Número de espacios</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="col-md-12">
                                <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" id="accion" name="accion" value="">
                                    <input type="hidden" id="id_observacion" name="id_observacion" value="">
                                    <!-- ENTRADA PARA INFORME POR VARIABLE --> 
                                    <div class="col-xs-12 col-sm-12 center-block">
                                        <div class="form-group">
                                            <label for="respuesta" class="control-label">Descripción del lugar de trabajo:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                                <textarea class="form-control input" id="respuesta" name="respuesta"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-submit-observacion" type="submit" class="btn btn-primary btnAddObservacion">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin de Distribución de la vivienda-->
    </div>
</div>



<?php include 'vw.distribucionVivienda_visita_teletrabajo.modal.php' ?>
<?php include 'vw.mobiliarioVivienda_visita_teletrabajo.modal.php' ?>
<?php include 'vw.electrodomesticoVivienda_visita_teletrabajo.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_teletrabajo/distribucion_vivienda_visita_teletrabajo.js"></script>
