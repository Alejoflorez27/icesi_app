<section class="content-header">
    <h1>Evaluado <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../familiar"><i class="active"></i>Familiar</a></li>
        <li class="active">Laboral</li>
    </ol>
</section>

<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">Información Laboral</h4>
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

                    <!-- ENTRADA PARA NOMBRE EMPRESA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre_empresa" class="control-label">Nombre de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="nombre_empresa" id="nombre_empresa" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TELÉFONO EMPRESA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono_empresa" class="control-label">Teléfono de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="telefono_empresa" id="telefono_empresa" placeholder="Ingrese el Teléfono de la Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE INGRESO --> 
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_ingreso" class="control-label">Fecha de Ingreso a la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_ingreso" id="fch_ingreso" placeholder="Ingrese Fecha de Ingreso de Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_retiro" class="control-label">Fecha de Retiro de Empresa:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_retiro" id="fch_retiro" placeholder="Ingrese Fecha de Retiro de Empresa" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO AL QUE INGRESO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_ingreso" class="control-label">Cargo al que Ingreso: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_ingreso" id="cargo_ingreso" placeholder="Cargo al que Ingreso el Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CARGO EL QUE FINALIZÓ -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_finalizo" class="control-label">Cargo en el que Finalizó: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_finalizo" id="cargo_finalizo" placeholder="Cargo en el que Finalizó el Evaluado" required>
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
                    <!-- ENTRADA PARA EL NOMBRE DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="jefe_inmediato" class="control-label">Jefe Inmediato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="jefe_inmediato" id="jefe_inmediato" placeholder="Ingrese el Nombre del Jefe Inmediato" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CARGO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_jefe" class="control-label">Cargo Jefe Inmediato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_jefe" id="cargo_jefe" placeholder="Ingrese el Cargo del Jefe Inmediato" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL JEFE INMEDIATO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="numero_jefe" class="control-label">Número Jefe Inmediato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="numero_jefe" id="numero_jefe" placeholder="Ingrese el Número del Jefe Inmediato" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FUNCIONES DESARROLLADAS -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="funciones_desarrolladas" class="control-label">Funciones Desarrolladas: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="funciones_desarrolladas" id="funciones_desarrolladas" placeholder="Ingrese las Funciones Desarrolladas" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO DE RETIRO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_retiro" class="control-label">Motivo Retiro: *</label>
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
                                <input type="text" class="form-control input solo-mayuscula" name="motivo_retiro" id="motivo_retiro" placeholder="Ingrese el Motivo Retiro" required>
                            </div>
                        </div>
                    </div>-->

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
                                <th>Fecha Ingreso</th>
                                <th>Fecha Retiro</th>
                                <th>Cargo Ingreso</th>
                                <th>Cargo Final</th>
                                <th>Tipo Contrato</th>
                                <th>Jefe Inmediato</th>
                                <th>Cargo Jefe</th>
                                <th>Numero Jefe</th>
                                <th>Funciones Desarrolladas</th>
                                <th>tipo Retiro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.laboral.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/candidato/laboral.js"></script>
