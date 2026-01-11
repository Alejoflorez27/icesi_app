<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$servicioId = $router->param('id_servicio');
$resp_menu = CtrMenuFormatos::findAll($servicioId);

$servicio = null;
if (Result::isSuccess($resp_menu))
    $servicio = Result::getData($resp_menu);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>

<section class="content-header">
  <div class="row">
    <div class="col-12 col-md-8">
      <h3>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h3>
    </div>

    <div class="col-12 col-md-4">
      <div class="box box-primary collapsed-box" style="position: relative; z-index: 9999;">
        <div class="box-header with-border">
          <h3 class="box-title">MENÚ <?= $servicio[0]['nom_servicio'] ?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool btn-primary" data-widget="collapse"><i class="fa fa-bars"></i></button>
          </div>
        </div>
        <div class="box-body">
          <ul class="list-unstyled">
            <?php foreach ($servicio as $file) : ?>
              <li>
                <a href="<?= $file['url'] . '?id_solicitud=' . $solicitudId . '&id_servicio=' . $servicioId ?>"><?= $file['nombre'] ?></a>
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
  <div class="col-12 col-md-6">
    <section class="content-header">
      <div class="box box-primary">
        <div class="modal-header">
          <div class="row">
            <div class="col-12">
              <h4 class="box-title">7. DISTRIBUCIÓN DE LA VIVIENDA</h4>
            </div>
          </div>
        </div>
        <form id="formVivDistribucion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
          <input type="hidden" id="accion" name="accion" value="">
          <input type="hidden" id="id_distribucion" name="id_distribucion" value="">
          <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion'] ?>">

          <div class="box-body row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="tipo_espacio" class="control-label">Tipo De Espacios: *</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                  <select class="form-control select2" id="tipo_espacio" name="tipo_espacio" required></select>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="numero_espacio" class="control-label">Número de Espacios:*</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                  <input type="number" class="form-control solo-mayuscula" name="numero_espacio" id="numero_espacio" placeholder="Número de Espacios" required>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="estado_espacio" class="control-label">Estados de los Espacios: *</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                  <select class="form-control select2" id="estado_espacio" name="estado_espacio" required></select>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="dotacion_mobiliaria" class="control-label">Dotación Mobiliaria: *</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                  <select class="form-control select2" id="dotacion_mobiliaria" name="dotacion_mobiliaria" required></select>
                </div>
              </div>
            </div>

            <div class="col-12 text-danger mb-3">
              Campos señalados con * son obligatorios
            </div>

            <div class="col-12 modal-footer">
              <button id="btn-submit-vivDristribucion" type="submit" class="btn btn-primary btnAddVivDistribucion">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box box-primary">
            <div class="box-header with-border"></div>
            <div class="box-body">
              <div class="col-12">
                <h4>Por favor diligenciar el mobiliario de cada espacio de vivienda en la tabla. La opción se encuentra en Mobiliario de la vivienda</h4>
              </div>
              <table id="tbl-vivDistribucion" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Tipo de Espacios</th>
                    <th>Número de espacios</th>
                    <th>Estado de los Espacios</th>
                    <th>Dotación mobiliaria</th>
                    <th>Mobiliario de la vivienda</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Otra Distribución de la vivienda -->
  <div class="col-12 col-md-6">
    <?php include 'vw.electrodomesticosVivienda_visita_ingreso.php' ?>
  </div>
</div>

<?php include 'vw.distribucionVivienda_visita_ingreso.modal.php' ?>
<?php include 'vw.mobiliarioVivienda_visita_ingreso.modal.php' ?>
<?php include 'vw.electrodomesticoVivienda_visita_ingreso.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_ingreso/distribucion_vivienda_visita_ingreso.js"></script>
