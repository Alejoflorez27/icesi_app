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
                <h4 class="box-title">6. REFERENCIAS PERSONALES Y OBSERVACIÓN ADICIONAL</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formReferencias" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_ref_personal" name="id_ref_personal" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">

                    <!-- ENTRADA PARA REFERENCIA PERSONAL 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="referencia_personal" class="control-label">Referencia Personal: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="referencia_personal" name="referencia_personal" required></textarea>
                            </div>
                        </div>
                    </div> -->
                    <!-- ENTRADA PARA EL NOMBRE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombre: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NÙMERO DE TELEFONO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Telefono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="telefono" id="telefono" placeholder="Ingrese el telefono" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONCEPTO  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto" class="control-label">Concepto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="concepto" name="concepto" required></textarea>
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

                    <div class="modal-footer">
                        <button id="btn-submit-referencia" type="submit" class="btn btn-primary btnAddReferencia">Guardar</button>
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
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 center-block">
                            <table id="tbl-referencias" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Concepto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 center-block">
                            <button class="btn btn-primary pull-left btnAddFamiliaObs" title="Dar Clic para Observación adicional" id="obsFamilia" type="button" data-toggle="modal" data-target="#modalAddObservacion">Observación Adicional</button>
                            <!--<p class="pull-left" id="viewObservacion"></p>-->
                        </div>
                        <!-- ENTRADA PARA OBSERVACIONES DE REFERENCIAS ADICIONALES -->
                        <div class="col-xs-12 col-sm-6 center-block">
                            <div class="form-group">
                                <label for="viewObservacion" class="control-label"></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                    <textarea class="form-control input"  id="viewObservacion" name="viewObservacion" placeholder="Observaciones adicionales" disabled></textarea>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
            
        </div>
    </div>
</section>
<?php include 'vw.obs_adicional_ver_laboral.modal.php' ?>
<?php include 'vw.observacion_ver_laboral.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ver_laboral/obs_adicional_ver_laboral.js"></script>
