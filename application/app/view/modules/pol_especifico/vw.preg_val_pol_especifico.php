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
                <h4 class="box-title">5. PREGUNTAS DE VALIDACION Y PROFUNDIZACION.</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formValidacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_validacion" name="id_validacion" value="">
                

            <div class="box-body">

            <P>
                Escriba la pregunta y la respuesta del evaluado que le permitan aclarar la narración de los hechos. 
                Realice las preguntas que el cliente solicita confirmar. <br>
                ESTAS PREGUNTAS SON UNA GUIA VAN EN EL FORMATO: EN EL INFORME DEBEN APARECER<br>

                <div class="col-xs-12 col-sm-6 center-block">
                •	Sospecha usted de alguien <br>
                •	Sabe usted con certeza quien cometio el hecho <br>
                •	Esta encubriendo usted a alguien  <br>
                •	¿Recibio usted alguna propuesta para comerter el hecho en cuestion? <br>
                •	¿Se confabulo usted con alguien? <br>
                •	Fue usted quien cometio el ilicito <br>
                •	Sabe usted donde se encuentra xxx <br>

                </div>

                <div class="col-xs-12 col-sm-6 center-block">
                •	Alguien lo esta presionando para que se quede callado  <br>
                •	Se encontraba usted en ese lugar  <br>
                •	Que cree usted que pudo haber pasado<br>
                •	Cree usted que aguien lo pueda señalar como el responsable del hecho <br>
                •	Por que deberiamos creer que usted no es culpable<br>
                •	Que deberia pasarle a la persona que cometio e hecho <br>
                •	Que haria usted si fuera su empresa <br>

                </div>
            </P>

                    <!-- ENTRADA PARA LAS PREGUNTAS -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="pregunta" class="control-label">Pregunta: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="pregunta" name="pregunta" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA LAS REPUESTA -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="respuesta" class="control-label">Respuesta: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" style="height: 120px;" id="respuesta" name="respuesta" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-validacion" type="submit" class="btn btn-primary btnAddValidacion">Guardar</button>
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
                    <table id="tbl-validacion" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <!--<th>Persona Evaluada</th>-->
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.preg_val_pol_especifico.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_especifico/preg_val_pol_especifico.js"></script>
