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

<section class="content">
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">9. CARACTERISTICAS DEL SECTOR</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
            <button class="btn btn-primary btnAddSectorViv" data-toggle="modal" data-target="#modalAddVivSector">
                Crear Caracteristicas del Sector
            </button>
        </div>
    </div>

    
                </div>
                <div class="box-body">
                    <table id="tbl-vivSector" class="table table-bordered table-striped dt-responsive  collapsed tablas">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Sector</th>
                                <th>Estrato</th>
                                <th>Ubicación</th>
                                <th>Tiempo de Desplazamiento al Lugar de Trabajo</th>
                                <th>Tiempo en la actual vivienda</th>
                                <th>Puntos de Referencia</th>
                                <th>Principales Vias de Acceso</th>
                                <!--<th>Estado de Calles y Vías de acceso</th>-->
                                <th>Seguridad del Sector</th>
                                <th>Concepto del Vecino</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="div-Asector">
            <div class="col-md-2">
                <input type="hidden" id="id_sector">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="tbl-Asector" class="table table-bordered table-striped " width="100%">
                            <thead>
                                <tr>
                                    <td colspan="2" id="aspectos" ></td>
                                </tr>
                                <tr>
                                    <th colspan="2" id="fisicos-desc"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl-Asector-combo"> </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.sectorVivienda_visita_ingreso.modal.php' ?>
<?php include 'vw.ayuda_visita_ingreso.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_ingreso/caracteristicas_sector_visita_ingreso.js"></script> 