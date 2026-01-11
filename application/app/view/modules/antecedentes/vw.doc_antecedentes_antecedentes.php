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

  <style>

    .d-inline
    {
        display: inline-block;
      /*  color:blue; */
    }
</style>
<section class="content-header">
<div class="box box-primary">
    <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">2.VERIFICACIÓN DE ANTECEDENTES Y DOCUMENTOS</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formDimensionFamilia" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="11">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                <input type="hidden" id="nombre_completo" name="nombre_completo" value="<?= $solicitud['nombre_candidato'] ?>">
                <input type="hidden" id="num_cedula" name="num_cedula" value="<?= $solicitud['numero_documento'] ?>">

            <div class="box-body">

                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada, la información documental o de antecedentes, es totalmente confiable y se ajusta totalmente a las necesidades del cargo.
A. Ajuste documental entre un 95% y 100%
B. Nivel de importancia del antecedente o reporte para la empresa cliente 
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

                                    <p style="font-size: 14px">En la variable analizada, la información documental o de antecedentes, es confiable y se ajusta en un alto nivel a las necesidades del cargo.
A. Ajuste documental entre un 90% y 95%
B. Nivel de importancia del antecedente o reporte para la empresa cliente
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

                                    <p style="font-size: 14px">En la variable analizada la información documental o de antecedentes, es medianamente confiable y se ajusta en medio nivel a las necesidades del cargo. A. Ajuste documental entre un 85% y 90%
B. Nivel de importancia del antecedente o reporte para la empresa cliente
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

                                    <p style="font-size: 14px">En la variable analizada la información documental o de antecedentes, es poco confiable y se ajusta poco a las necesidades del cargo. A. Ajuste documental entre un 80% y 85%
b. Nivel de importancia del antecedente o reporte para la empresa cliente
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
                            <label for="variableFamilia" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input select2" id="variableFamilia" name="variableFamilia" placeholder="variables" required>
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
                    <div class="div-Afisicos">
                    <div class="col-md-12">
                        <input type="hidden" id="idCaracteristica">
                        <div class="box box-primary">
                            <div class="box-body">
                                <table id="tbl-Afisicos" class="table table-bordered table-striped " width="100%">
                                    <thead>
                                        <tr>
                                            <td colspan="12" id="aspectos" ></td>
                                        </tr>
                                        <tr>
                                            <td><center>Lista</center></td>
                                            <td><center>Seleccióne</center></td>
                                            <td><center>Observación</center></td>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl-Afisicos-combo"> </tbody>
                                </table>
                            </div>
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
                                <textarea class="form-control input" id="respuesta" name="respuesta" disabled></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- el pie de pagina del form -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div style="color:red;">
                            Campos señalados con * son obligatorios
                        </div>                    

                        <div class="modal-footer">
                            <button id="btn-submit-dimensionFamilia" type="submit" class="btn btn-primary btnAddDimensionFamilia">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<?php include 'vw.plantilla_antecedentes.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/antecedentes/doc_antecedentes.js"></script>
