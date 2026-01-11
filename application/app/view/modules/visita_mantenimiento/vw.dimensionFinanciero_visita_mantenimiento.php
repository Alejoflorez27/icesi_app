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
                <h4 class="box-title">15. MATRIZ VALORACIÓN DEL RIESGO FINANCIERO Y ECONÓMICO DEL EVALUADO Y SU FAMILIA</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formDimensionFinanciero" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="3">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">

                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada el Evaluado no evidencia riesgo financiero y económico, con respecto a sus ingresos, egresos, activos y nivel de endeudamiento.
                                    </p>
                                    </div>
                                    <a class="small-box-footer">0</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO BAJO</sup>

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un bajo riesgo financiero y económico, con respecto a sus ingresos, egresos, activos y nivel de endeudamiento.
                                    </p>
                                    </div>
                                    <a class="small-box-footer">1</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INTERMEDIO</sup>

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel medio de riesgo financiero y económico, con respecto a sus ingresos, egresos, activos y nivel de endeudamiento.
                                    </p>
                                    </div>
                                    <a class="small-box-footer">2</a>
                                </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red text-center">
                                <div class="inner">
                                    <sup style="font-size: 15px">RIESGO ALTO</sup>

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel alto de riesgo financiero y económico, con respecto a sus ingresos, egresos, activos y nivel de endeudamiento.
                                    </p>
                                    </div>
                                    <a class="small-box-footer">3</a>
                                </div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->

                    <!-- ENTRADA PARA EL VARIABLE A ANALIZAR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="variableFinanciero" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input select2" id="variableFinanciero" name="variableFinanciero" placeholder="variables" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE RIESGO --> 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nivel_riesgo" class="control-label">Nivel De Riesgo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_riesgo" name="nivel_riesgo" placeholder="Nivel de riesgo" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA DESCRIPCION POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Información completa de variable a Analizar:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="descripcion" name="descripcion" readonly ></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA SEÑALES DE ALERTA  -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="senal_alerta" class="control-label">Señales de Alerta:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="senal_alerta" name="senal_alerta" readonly>
*Desequilibrio económico.
*Ingresos injustificados.
* Nivel de endeudamiento frente a sus ingresos y reportes en centrales de riesgo, no itención de pago., porque no
las ha cancelado.
* Adquisición de bienes inmuebles de manera injustificada,
* Coherencia del patrimonio con el nivel educativo y laboral.
*Como adquirió el patrimonio relacionado.
* Red de apoyo familiar, cuando no está trabajando. Analizar cuando no estan trabajando, hace cuanto y quien les
ayuda mientras se ubica laboralmente.
</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA INFORME POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="respuesta" class="control-label">Informe por Variable: *
                                <button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalPlantilla">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="respuesta" name="respuesta"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-dimensionFinanciero" type="submit" class="btn btn-primary btnAddDimensionFinanciero">Guardar</button>
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

                    <table id="tbl-financieroDimension" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Variable a Analizar</th>
                                <th>Nivel De Riesgo</th>
                                <th>Informe por Variable</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.dimensionFinanciero_visita_mantenimiento.modal.php' ?>
<?php include 'vw.plantilla_var_visita_mantenimiento.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_mantenimiento/dimensionFinanciero_visita_mantenimiento.js"></script>
