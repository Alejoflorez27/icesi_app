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
                <h4 class="box-title">10. TRAYECTORIA LABORAL</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formLaboral" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_laboral" name="id_laboral" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">
                <div class="col-xs-12 col-sm-12 center-block">
                    <h4>En los campos que encontrará a continuación, verifique con el Evaluado su historia laboral y complemente la información que corresponda:
Experiencia laboral más reciente:</h4>
                </div>
                    <!-- ENTRADA PARA NOMBRE EMPRESA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre_empresa" class="control-label">Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_empresa" id="nombre_empresa" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO AL QUE INGRESO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_ingreso" class="control-label">Cargo inicial desempeñado / Área: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_ingreso" id="cargo_ingreso" placeholder="Cargo al que Ingreso el Evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO EL QUE FINALIZÓ -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_finalizo" class="control-label">Último cargo desempeñado / Área: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_finalizo" id="cargo_finalizo" placeholder="Último cargo del Evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE INGRESO --> 
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_ingreso" class="control-label">Fecha de Ingreso: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_ingreso" id="fch_ingreso" placeholder="Fecha de Ingreso de Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE RETIRO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_retiro" class="control-label">Fecha de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_retiro" id="fch_retiro" placeholder="Fecha de Retiro de Empresa">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIEMPO TOTAL LABORADO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="tmp_total_laborado" class="control-label">Tiempo total laborado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="tmp_total_laborado" id="tmp_total_laborado" placeholder="Tiempo total laborado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL TIPO DE MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="tipo_retiro" class="control-label">Motivo de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="tipo_retiro" name="tipo_retiro" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA MOTIVO DE RETIRO
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="motivo_retiro" class="control-label">Motivo Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="motivo_retiro" id="motivo_retiro" placeholder="Motivo Retiro" required>
                            </div>
                        </div>
                    </div> -->
                    <!-- ENTRADA PARA PAIS DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input select2" id="pais" name="pais" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DEPARTAMENTO DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="departamento" class="control-label">Departamento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select class="form-control input select2" id="departamento" name="departamento" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CIUDAD -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Ciudad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input select2" id="id_ciudad_act" name="id_ciudad_act" placeholder="Ingrese Residencia del Familiar" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA FUNCIONES DESARROLLADAS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="funciones_desarrolladas" class="control-label">Principales actividades o responsabilidades del cargo:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <textarea class="form-control input" id="funciones_desarrolladas" name="funciones_desarrolladas" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA OBSERVACIÓN  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="observaciones" class="control-label">Observación: *
                                <!--<button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalPlantilla">
                                    <i class="fa fa-info-circle"></i>
                                </button>-->
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="observaciones" name="observaciones" required></textarea>
                            </div>
                        </div>
                    </div>


                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-laboral" type="submit" class="btn btn-primary btnAddLaboral">Guardar</button>
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

                    <table id="tbl-laboral" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Empresa</th>
                                <th>Cargo inicial desempeñado / Área</th>
                                <th>Último cargo desempeñado / Área</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Retiro</th>
                                <th>Tiempo Total Laborado</th>
                                <!--<th>Tipo de Retiro</th>-->
                                <th>Motivo de Retiro</th>
                                <th>Ciudad</th>
                                <th>Principales actividades</th>
                                <th>Observación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_observacion" name="id_observacion" value="">
                        <input type="hidden" id="id_admision" name="id_admision" value="">
                        
                        <!-- ENTRADA PARA INFORME POR VARIABLE  
                        <div class="col-xs-12 col-sm-12 center-block">
                            <div class="form-group">
                                <label for="respuesta" class="control-label">Comentarios del examinador:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <textarea class="form-control input" id="respuesta" name="respuesta"></textarea>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-xs-6 col-sm-2 form-group form-check">
                            <br>
                            <input type="checkbox" class="form-check-input" id="admitio" name="admitio" value="0">
                            <label class="form-check-label" for="admitio">El Evaluado Admite</label>
                        </div>

                        <!-- ENTRADA PARA INFORME POR VARIABLE --> 
                        <div class="col-xs-12 col-sm-10 center-block" id="ocultar">
                            <div class="form-group">
                                <label for="resumen" class="control-label">Admisiones el evaluados:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <textarea class="form-control input" id="resumen" name="resumen"></textarea>
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
</section>
<?php include 'vw.laboral_pol_pre.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/laboral_pol_pre.js"></script>
