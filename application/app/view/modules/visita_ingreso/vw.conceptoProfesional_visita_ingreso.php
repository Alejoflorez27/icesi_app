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
                <h4 class="box-title">21. CONCEPTO PROFESIONAL</h4>
            </div>
            <div class="col-xs-12 col-sm-6 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>

    </div>
    <!--<form id="formCandidato" role="form" method="post" enctype="multipart/form-data" autocomplete="off">-->
    <form id="formVivConceptoProfesional" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_concepto" name="id_concepto" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">

                    <!-- ENTRADA PARA OBSERVACIONES -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="expectativas" class="control-label">Expectativas familiares frente al cargo y la empresa(Explorar con el Evaluado y su familia con la que convive, las expectativas que tienen frente al cargo a nivel de desarrollo profesional, personal, financiero,etc.): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="expectativas" name="expectativas" placeholder="Descripción"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA OBSERVACIONES -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="metas" class="control-label">Metas y Proyectos ( Corto, mediano y largo plazo, a nivel laboral, profesional, académico, y personal): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="metas" name="metas" placeholder="Descripción"></textarea>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA NOMBRE -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="medio_hv" class="control-label">Como llega la hoja de vida a la empresa.  Se encuentra en otros procesos de Selección?: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="medio_hv" id="medio_hv" placeholder="Ingrese como llego la hoja de vida" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA APELLIDO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="condicion_laboral" class="control-label">Tiene usted  conocimiento  de las condiciones laborales de la entidad y está de acuerdo con ellas?: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="condicion_laboral" id="condicion_laboral" placeholder="Ingrese conocimiento de condicion laboral" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TIPO DOCUMENTO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto_final" class="control-label">Concepto Final Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input select2" id="concepto_final" name="concepto_final" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA OBSERVACIONES -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="observacion" class="control-label">Observaciones: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="observacion" name="observacion" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA REFERENCIA -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="referencia" class="control-label">Referencia: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <textarea class="form-control input" id="referencia" name="referencia" placeholder="Referencia Personal"></textarea>
                            </div>
                        </div>
                    </div>

                <!-- Small boxes (Stat box) -->

                    <div class="col-xs-12 col-sm-2 center-block">
                    <!-- small box -->
                    <div class="small-box bg-primary text-center">
                        <div class="inner">
                        <sup style="font-size: 15px"><strong>MATRIZ<br>FAMILIAR</strong></sup>
                        </div>
                        <a id="dimfamilia" class="small-box-footer" style="font-size: 18px;" title="Clic para ingresar concepto" data-id="1"></a>
                    </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-xs-12 col-sm-2 center-block">
                    <!-- small box -->
                    <div class="small-box bg-primary text-center">
                    <div class="inner">
                        <sup style="font-size: 15px"><strong>MATRIZ<br>SOCIAL Y HABITACIONAL</strong></sup>
                        </div>
                        <a id="dimSocial" class="small-box-footer" style="font-size: 18px;" title="Clic para ingresar concepto" data-id="2"></a>
                    </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-xs-12 col-sm-2 center-block">
                    <!-- small box -->
                    <div class="small-box bg-primary text-center">
                    <div class="inner">
                        <sup style="font-size: 15px"><strong>MATRIZ<br>FINANCIERA Y ECONOMICA</strong></sup>
                        </div>
                        <a id="dimFinanciera" class="small-box-footer" style="font-size: 18px;" title="Clic para ingresar concepto" data-id="3"></a>
                    </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-xs-12 col-sm-2 center-block">
                    <!-- small box -->
                    <div class="small-box bg-primary text-center">
                    <div class="inner">
                        <sup style="font-size: 15px"><strong>MATRIZ<br>SALUD</strong></sup>
                        </div>
                        <a id="dimSalud" class="small-box-footer" style="font-size: 18px;" title="Clic para ingresar concepto" data-id="4"></a>
                    </div> 
                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                    <div class="col-xs-12 col-sm-2 center-block">
                    <!-- small box -->
                    <div class="small-box bg-primary text-center">
                    <div class="inner">
                        <sup style="font-size: 15px"><strong>MATRIZ<br>ACTITUD Y COMPROMISO</strong></sup>
                        </div>
                        <a id="dimCompromiso" class="small-box-footer" style="font-size: 18px;" title="Clic para ingresar concepto" data-id="5"></a>
                    </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div style="color:red;">
                            Campos señalados con * son obligatorios
                        </div>  
                    </div>                  
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="modal-footer">
                            <button id="btn-submit-vivConceptoProfesional" type="submit" class="btn btn-primary btnAddConceptoProfecional">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<?php include 'vw.dimConcepto_visita_ingreso.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_ingreso/conceptoProfesional_visita_ingreso.js"></script>
