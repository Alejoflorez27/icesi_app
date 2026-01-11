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
                <h4 class="box-title">5. EVALUACIÓN DE LA ACTITUD Y COMPROMISO DEL EVALUADO CON EL PROCESO </h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formDimensionCompromiso" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_respuesta" name="id_respuesta" value="">
                <input type="hidden" id="id_dimension" name="id_dimension" value="5">
                

            <div class="box-body">

                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua text-center">
                                    <div class="inner">
                                    <sup style="font-size: 15px">RIESGO INEXISTENTE</sup>

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel muy bajo de riesgo en la actitud y colaboración con estudio de confiabilidad 
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

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel bajo de riesgo en la actitud y colaboración con el estudio de confiabilidad  
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

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un nivel intermedio de riesgo en la actitud y colaboración con el estudio de confiabilidad
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

                                    <p style="font-size: 14px">En la variable analizada el Evaluado evidencia un alto de riesgo en la actitud y colaboración con el estudio de confiabilidad
                                    </p>
                                    </div>
                                    <a class="small-box-footer">3</a>
                                </div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->

                    <!-- ENTRADA PARA EL VARIABLE A ANALIZAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="variableCompromiso" class="control-label">Variable a Analizar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<select class="form-control input select2" id="variableCompromiso" name="variableCompromiso" placeholder="variables" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA DESCRIPCION POR VARIABLE  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Información completa de variable a Analizar:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="descripcion" name="descripcion" readonly ></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA SEÑALES DE ALERTA 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="senal_alerta" class="control-label">Señales de Alerta:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="senal_alerta" name="senal_alerta" readonly>
*Maltrato Intrafamiliar (Psicólogico, Físico, Sexual, Negligencia etc).
*Separaciones de los padres o figuras representativas.
*Desarraigo. 
*Carencia de una red de apoyo.
*Inestabilidad afectiva varias relaciones de pareja, hijos de varias relaciones, por quienes debe asumir una responsabilidad económica.
*Antecedentes familiares en el consumo de alcohol y drogas.
*Problemas con exparejas, que pueden acarrear acoso, demandas, etc.
*Carencia de figuras de autoridad y pautas de crianza claras.
*Separaciones del Evaluado o Evaluado y su responsabilidad con sus obligaciones. (Demandas de alimentos).
*Evaluado, que no asume sus dificultades y las evade o  no participan en la solución de las mismas.
*Dificultades o problemáticas que sobrepasan al Evaluado y su familia y que afecta sus relaciones actualmente.
* Aficiones personales que interfieran su labor, o que puedan llevarlo a presentar ausentismos. (Juegos de video el línea, con apuestas, redes sociales etc aficiones a equipos de fútbol y por ir a los partidos falten al trabajo.) Con que frecuencia, ahondar en esta parte.
*Estudios actuales que puedan interferir con su horario laboral.
*Alto nivel de rotación laboral y motivos de retiro. Solicitar hoja de vida.
*Rol del Evaluado: único proveedor, puede ser un riesgo, que puede llevarlo a actos de robo. Como lo reconocen en su núcleo familiar. En la visita debe estar un familiar.</textarea>
                            </div>
                        </div>
                    </div> -->

                    <!-- ENTRADA PARA NIVEL DE RIESGO --> 
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="nivel_riesgo" class="control-label">Nivel De Riesgo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_riesgo" name="nivel_riesgo" placeholder="Nivel de riesgo" required>
                                </select>
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
                                <textarea class="form-control input" id="respuesta" name="respuesta" required></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-dimensionCompromiso" type="submit" class="btn btn-primary btnAddDimensionCompromiso">Guardar</button>
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

                    <table id="tbl-compromisoDimension" class="table table-bordered table-striped dt-responsive tablas" width="100%">
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
<?php include 'vw.dim_confiabilidad_compromiso_ver_laboral.modal.php' ?>
<?php include 'vw.plantilla_var_ver_laboral.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ver_laboral/dim_confiabilidad_compromiso_ver_laboral.js"></script>
