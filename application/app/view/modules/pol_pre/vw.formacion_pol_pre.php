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
                <h4 class="box-title">9. FORMACIÓN ACADÉMICA</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="formFormacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_formacion" name="id_formacion" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

            <div class="box-body">

                    <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nivel_escolaridad" class="control-label">Nivel de Escolaridad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_escolaridad" name="nivel_escolaridad" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NOMBRE DE LA INSTITUCION -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="nombre_institucion" class="control-label">Nombre de la Institución: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_institucion" id="nombre_institucion" placeholder="Ingrese el Nombre de la Institución del Evaluado" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PROGRAMA ACADEMICO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="programa_academico" class="control-label">Programa Académico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="programa_academico" id="programa_academico" placeholder="Ingrese el Programa Académico del Evaluado" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE GRADUACIÓN -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_grado" class="control-label">Fecha de Graduación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_grado" id="fch_grado" placeholder="Ingrese Fecha de Graduación" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ACTA Y FOLIO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="acta_folio" class="control-label">Acta y Folio:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="acta_folio" id="acta_folio" placeholder="Ingrese Acta y Folio" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA OBSERVACIÓN Y HALLAZGOS  -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="obs_academica" class="control-label">Observaciones / hallazgos durante la verificación: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <textarea class="form-control input" id="obs_academica" name="obs_academica" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class="modal-footer">
                        <button id="btn-submit-formacion" type="submit" class="btn btn-primary btnAddFormacion">Guardar</button>
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
                    <table id="tbl-formacion" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nivel de Escolaridad</th>
                                <th>Nombre Institucion</th>
                                <th>Programa Academico</th>
                                <th>Fecha de Graduacion</th>
                                <th>Acta y Folio</th>
                                <th>Observación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <form id="formObservacion" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_observacion" name="id_observacion" value="">
                        <input type="hidden" id="id_observacion2" name="id_observacion2" value="">
                        <input type="hidden" id="id_observacion3" name="id_observacion3" value="">
                        <!-- ENTRADA PARA INFORME POR VARIABLE --> 
                        <div class="col-xs-12 col-sm-4 center-block">
                            <div class="form-group">
                                <label for="respuesta" class="control-label">Comentarios del examinador:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <textarea class="form-control input" id="respuesta" name="respuesta"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA EDUCACIÓN NO FORMAL  -->
                        <div class="col-xs-12 col-sm-4 center-block">
                            <div class="form-group">
                                <label for="edu_no_formal" class="control-label">Educación no formal: *</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <textarea class="form-control input" id="edu_no_formal" name="edu_no_formal"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA CURSOS REQUERIDOS --> 
                        <div class="col-xs-12 col-sm-4 center-block">
                            <div class="form-group">
                                <label for="cursos" class="control-label">Cursos requeridos por la empresa solicitante:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                    <textarea class="form-control input" id="cursos" name="cursos"></textarea>
                                </div>
                            </div>
                        </div>
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
<?php include 'vw.formacion_pol_pre.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_pre/formacion_pol_pre.js"></script>
