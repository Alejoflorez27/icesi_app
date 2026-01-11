<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>
<section class="content-header">
    <h1>Evaluado <strong><?= $solicitud['nombre_candidato']." ".$solicitud['doc_candidato'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="solicitud/detalle?solicitud=<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-dashboard"></i> Formación Académica</a></li>
        <li class="active">Información Laboral</li>
    </ol>
</section>


<section class="content-header">
<div class="box box-primary">
    <div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">7. VERIFICACIÓN DE CONFIABILIDAD Y COHERENCIA DE LA INFORMACIÓN E HISTORIA LABORAL</h4>
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
                    <h3><strong>Verificación por parte del área de gestión humana</strong></h3>
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
                    <!-- ENTRADA PARA TELÉFONO EMPRESA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono_empresa" class="control-label">Teléfolo de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="telefono_empresa" id="telefono_empresa" placeholder="Teléfono de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE DEL FUNCIONARIO QUE CONFIRMA LA INFORMACIÓN -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="jefe_inmediato" class="control-label">Nombre del funcionario que confirma la información*</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="jefe_inmediato" id="jefe_inmediato" placeholder="Nombre del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CARGO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_jefe" class="control-label">Cargo / Área:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_jefe" id="cargo_jefe" placeholder="Cargo del Jefe Inmediato">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL ESTADO ACTUAL DE LA EMPRESA  -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="estado_empresa" class="control-label">Estado actual de la empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="estado_empresa" name="estado_empresa" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO AL QUE INGRESO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_ingreso" class="control-label">Cargo inicial desempeñado / Área: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_ingreso" id="cargo_ingreso" placeholder="Cargo al que Ingreso el evaluado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO EL QUE FINALIZÓ -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_finalizo" class="control-label">Último cargo desempeñado / Área: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_finalizo" id="cargo_finalizo" placeholder="Último cargo del evaluado">
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
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_retiro" class="control-label">Fecha de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_retiro" id="fch_retiro" placeholder="Fecha de Retiro de Empresa">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tmp_total_laborado" class="control-label">Tiempo total laborado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="tmp_total_laborado" id="tmp_total_laborado" placeholder="Tiempo total laborado">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL TIPO DE CONTRATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_contrato" class="control-label">Tipo de Contrato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="tipo_contrato" name="tipo_contrato" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL TIPO DE MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_retiro" class="control-label">Tipo de Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="tipo_retiro" name="tipo_retiro" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA MOTIVO DE RETIRO -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="motivo_retiro" class="control-label">Motivo Retiro: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="motivo_retiro" id="motivo_retiro" placeholder="Motivo Retiro" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL HORARIO DE TRABAJO (JORNADA) -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="horario_trabajo" class="control-label">Horario de trabajo (jornada): *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="horario_trabajo" name="horario_trabajo" required>
                                </select>
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
                    <div class="col-xs-12 col-sm-12 center-block">
                        <h3><strong>Verificación por parte del jefe</strong></h3>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE DEL JEFE QUE CONFIRMA LA INFORMACIÓN -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="nom_jefe_valida" class="control-label">Nombre del jefe que valida la información:*</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nom_jefe_valida" id="nom_jefe_valida" placeholder="Nombre del Jefe">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CARGO DEL JEFE -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="cargo_jefe_valida" class="control-label">Cargo del jefe que valida la información:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_jefe_valida" id="cargo_jefe_valida" placeholder="Cargo del Jefe">
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="numero_jefe" class="control-label">Número Jefe Inmediato:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="numero_jefe" id="numero_jefe" placeholder="Número del Jefe">
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

                    <div class="col-xs-12 col-sm-12 center-block">
                        <h3><strong>Concepto desempeño laboral</strong></h3>
                        <h4><strong>Criterios evaluados:</strong><br><br>
                            1.	Principales aspectos que destaca del evaluado<br>
                            2.	Manejo de información de información confidencial <br>
                            3.	Nivel de confiabilidad del evaluado (valores, cumplimiento de las normas, ética profesional) <br>
                            4.	Capacidad de aprendizaje<br>
                            5.	Capacidad de adaptación al cargo<br>
                            6.	Relaciones con jefes y pares <br>
                            7.	Aspectos a mejorar y observaciones<br>

                        </h4>
                    </div>

                    <!-- ENTRADA PARA FUNCIONES DESARROLLADAS -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="concepto" class="control-label">Concepto:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <textarea class="form-control input" id="concepto" name="concepto" placeholder="CONCEPTO: El concepto debe integrar todos los aspectos mencionados anteriormente. Dos o tres párrafos" required></textarea>
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
                                <th>Telefono Empresa</th>
                                <th>Nombre del funcionario</th>
                                <th>Cargo / Área</th>
                                <th>Estado actual de la empresa</th>
                                <th>Cargo inicial desempeñado / Área</th>
                                <th>Último cargo desempeñado / Área</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Retiro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.laboral_ec_sin_cifin.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ec_sin_cifin/laboral_ec_sin_cifin.js"></script>
