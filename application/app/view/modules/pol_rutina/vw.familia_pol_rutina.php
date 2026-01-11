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
            <div class="col-xs-12 col-sm-6 center-block">
                <h4 class="box-title">3. Área Familiar: Información de las personas con las que vive </h4>
            </div>
            <div class="col-xs-12 col-sm-6 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formFamilia" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_familia" name="id_familia" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                

            <div class="box-body">

                    <!-- ENTRADA PARA EL PARENTESCO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="parentesco" class="control-label">Parentesco: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<!--<select class="form-control input select2" id="parentesco" name="parentesco" placeholder="Parentesco Evaluado" required>
                                </select>-->
                                <input type="text" class="form-control input" name="parentesco" id="parentesco" placeholder="Parentesco con el Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombre del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Nombre del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA APELLIDO FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellido del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="apellido" id="apellido" placeholder="Apellido del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EDAD FAMILIAR -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="edad" class="control-label">Edad del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="edad" id="edad" placeholder="Edad del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL FAMILIAR 
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Número de contacto Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="telefono" id="telefono" placeholder="Número del Familiar" required>
                            </div>
                        </div>
                    </div> -->
                    <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD DEL FAMILIAR --> 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nivel_escolar" class="control-label">Nivel Escolaridad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_escolar" name="nivel_escolar" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA OCUPACIÓN FAMILIAR -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="ocupacion" class="control-label">Ocupación del Familiar: *
                                <button class="btn btn-primary btnPlantilla" type="button" data-toggle="modal" data-target="#modalOcuFamilia">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input" name="ocupacion" id="ocupacion" placeholder="( Cargo o labor que realiza) Nombre de la empresa / Tiempo o Institución Educativa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE EMPRESA DEL FAMILIAR 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="empresa" class="control-label">Nombre de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="empresa" id="empresa" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA ESTADO CIVIL FAMILIAR -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="estado_civil" class="control-label">Estado Civil del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <select class="form-control input select2" id="estado_civil" name="estado_civil" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA RECIDENCIA
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="residencia" class="control-label">Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="residencia" id="residencia" placeholder="Nombre de la Residencia" required>
                            </div>
                        </div>
                    </div>-->
                    <!-- ENTRADA PARA PAIS DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input select2" id="pais" name="pais" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DEPARTAMENTO DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="departamento" class="control-label">Departamento Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select class="form-control input select2" id="departamento" name="departamento" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CIUDAD -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Ciudad de Residencia: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input select2" id="id_ciudad_act" name="id_ciudad_act" placeholder="Ingrese Residencia del Familiar" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA VIVE CON EL Evaluado -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="viv_candidato" class="control-label">Vive con el Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="viv_candidato" name="viv_candidato" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA DEPENDE ECONOMICAMENTE DEL Evaluado -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="depende_candidato" class="control-label">Depende económicamente del Evaluado</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="depende_candidato" name="depende_candidato" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 center-block">
                                <button id="btn-submit-familia" type="submit" class="btn btn-primary btnAddFamilia">Guardar</button>
                            </div>
                        </div>
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

                    <table id="tbl-familia" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Parentesco</th>
                                <th>Nombre Familiar</th>
                                <th>Apellido Familiar</th>
                                <th>Edad</th>
                                <th>Estado Civil</th>
                                <th>Nivel Escolar</th>
                                <th>Ocupación</th>
                                <th>Vive Evaluado</th>
                                <th>Depende Evaluado</th>
                                <!-- <th>Télefono</th> -->
                                <th>Ciudad Residencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="col-xs-12 col-sm-12 center-block">
                                <button class="btn btn-primary pull-left btnAddFamiliaObs" title="Dar Clic para Observación del nucleo Familiar" id="obsFamilia" type="button" data-toggle="modal" data-target="#modalAddObservacion">Observación General</button>
                                <!--<p class="pull-left" id="viewObservacion"></p>-->
                            </div>
                            <!-- ENTRADA PARA OBSERVACIONES DE NUCLEO FAMILIAR -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="viewObservacion" class="control-label"></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input"  id="viewObservacion" name="viewObservacion" placeholder="Realizar la aclaración del cuadro familiar en este espacio, en caso de ser necesarios" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.familia_pol_rutina.modal.php' ?>
<?php include 'vw.observacion_pol_rutina.modal.php' ?>
<?php include 'vw.info_ocu_familia_pol_rutina.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_rutina/familia_pol_rutina.js"></script>
