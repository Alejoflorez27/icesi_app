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

<div class="container-fluid">
  <section>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="modal-header">
          <div class="row">
            <div class="col-xs-12 col-sm-6 center-block">
              <h4 class="box-title">8. ELECTRODOMESTICOS DE LA VIVIENDA</h4>
            </div>
            <div class="col-xs-12 col-sm-6 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="tabla-electrodomesticos">
              <thead class="thead-dark">
                <tr>
                  <th>Tipo De Elemento</th>
                  <th>Cantidad</th>
                  <th>Estado Electrodomestico</th>
                  <th>Tenencia Electrodomestico</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><select class="form-control form-control-sm tipo-elemento" id="tipo_elemento_inicial"></select></td>
                  <td><input type="number" class="form-control form-control-sm cant-espacios" value="1" min="1"></td>
                  <td><select class="form-control form-control-sm estado-electrodomestico" id="estado_electrodomestico_inicial"></select></td>
                  <td><select class="form-control form-control-sm tenencia-electrodomestico" id="tenencia_elecrodomestico_inicial"></select></td>
                  <td class="text-center">
                    <button class="btn btn-danger btn-bg btn-eliminar"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row mt-3">
            <div class="col-md-12 text-right">
              <button type="button" class="btn btn-success btn-bg" id="btn-agregar-fila">
                <i class="fa fa-plus"></i> Agregar Espacio
              </button>
              <button type="button" class="btn btn-primary btn-bg" id="btn-guardar">
                <i class="fa fa-save"></i> GUARDAR TODO
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </section>
</div>

<script src="<?= constant('APP_URL') ?>app/js/visita_ingreso/electrodomesticos_visita_ingresonew.js"></script>

<style>
.table td, .table th { vertical-align: middle; }
.form-control-sm { height: calc(1.5em + 0.5rem + 2px); }
.btn-sm { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
.is-invalid { border-color: #dc3545; }
</style>
