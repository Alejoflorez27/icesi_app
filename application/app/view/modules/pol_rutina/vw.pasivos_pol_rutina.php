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
    <div class="col-xs-6 col-sm-6 center-block">
        <section class="content-header">
        <div class="box box-primary">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 center-block">
                        <h4 class="box-title">6. PASIVOS DEL EVALUADO</h4>
                    </div>
                    <!--<div class="col-xs-12 col-sm-4 center-block">
                        <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                        <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                    </div>-->
                </div>
            </div>
            <form id="formVivPasivos" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_pasivo" name="id_pasivo" value="">
                        <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

                    <div class="box-body">

                            <!-- ENTRADA PARA TIPO CONCEPTO DEL PASIVO 
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="concepto_pasivo" class="control-label">Tipo Pasivo: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="concepto_pasivo" name="concepto_pasivo" required>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <!-- ENTRADA PARA TIPO OTRO SE DESCRIBE CUAL -->
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="otros" class="control-label">Observación General: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <!--<select class="form-control input select2" id="otros" name="otros" required>
                                        </select>-->
                                        <textarea class="form-control input" style="height: 100px;" id="otros" name="otros"></textarea>
                                        <!--<input type="text" class="form-control input" name="otros" id="otros" placeholder="Otros Activos Cuales?" required> -->
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA TIPO DE INTEGRANTE DE LA FAMILIA Y Evaluado 
                            <div class="col-xs-12 col-sm-12 center-block">
                                <div class="form-group">
                                    <label for="tipo_familiar" class="control-label">Responsable: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="tipo_familiar" name="tipo_familiar" required>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ENTRADA PARA TIPO OTRO PROPIETARIO SE DESCRIBE CUAL 
                            <div class="col-xs-12 col-sm-12 center-block" id="ocultarPropietarioPas">
                                <div class="form-group">
                                    <label for="otro_propietario_pas" class="control-label"></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        select class="form-control input select2" id="otros" name="otros" required>
                                        </select>
                                        <input type="text" class="form-control input" name="otro_propietario_pas" id="otro_propietario_pas" placeholder="Ingrese el propietario" required>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ENTRADA PARA CANTIDAD DE VALOR DE PASIVO 
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="valor_pasivo" class="control-label">Saldo pendiente por pagar ($): *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="number" class="form-control input solo-mayuscula" name="valor_pasivo" id="valor_pasivo" placeholder="Valor de Pasivo" required>
                                    </div>
                                </div>
                            </div> -->

                            <!-- ENTRADA PARA TIPO DE PLAZO DEL PASIVO 
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="plazo_pasivo" class="control-label">Plazo Pasivo: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="plazo_pasivo" name="plazo_pasivo" required>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <!-- ENTRADA PARA CANTIDAD DE LA COUTA 
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="couta" class="control-label">Cuota mensual: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="number" class="form-control input solo-mayuscula" name="couta" id="couta" placeholder="Cuota mensual" required>
                                    </div>
                                </div>
                            </div> -->

                            <!-- ENTRADA PARA TIPO DE PLAZO DEL PASIVO 
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="estado_obligacion" class="control-label">Estado de la obligación: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <select class="form-control input select2" id="estado_obligacion" name="estado_obligacion" required>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <!-- ENTRADA PARA EL VALOR DE LA MORA 
                            <div class="col-xs-12 col-sm-12 center-block" id="ocultar_valor">
                                <div class="form-group">
                                    <label for="valor_mora" class="control-label">Valor de la mora: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="number" class="form-control input solo-mayuscula" name="valor_mora" id="valor_mora" placeholder="Valor de la mora" required>
                                    </div>
                                </div>
                            </div> -->

                            <div style="color:red;">
                                Campos señalados con * son obligatorios
                            </div>                    

                            <div class="modal-footer">
                                <button id="btn-submit-vivPasivos" type="submit" class="btn btn-primary btnAddVivPasivos">Guardar</button>
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
                            <table id="tbl-vivPasivos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                    <tr>
                                    <th>Id</th>
                                        <th>Observación General</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                            <!--<div class="row">
                                <div class="col-xs-12 col-sm-6 center-block">
                                    <h2><strong>Total Pasivos:</strong></h2>
                                </div>
                                <div class="col-xs-12 col-sm-6 center-block">
                                    <h1 id="total_pasivos"></h1>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Inicio otra Distribución de la vivienda-->
    <div  class="col-xs-6 col-sm-6 center-block">
        <?php include 'vw.activos_pol_rutina.php' ?>
    </div>
    <!-- Inicio para los totales de pasivos activos y el patrimonio
    <div  class="col-xs-6 col-sm-12 center-block">
    <section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
            <div class="box-header with-border">
                </div>

                <div class="box-body">
                <style>
                    .tamano-letra-grande {
                        font-size: 40px;
                    }
                </style>
                    <table id="tbl-vivTotales" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>TOTALES PASIVOS DEL EVALUADO (A)</th>
                                <th>TOTALES ACTIVOS DEL EVALUADO (A)</th>
                                <th>PATRIMONIO  EVALUADO (A)</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
    </div>-->
</div>

<?php include 'vw.pasivos_pol_rutina.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_rutina/pasivos_pol_rutina.js"></script>
