<section class="content-header">
    <h1>Evaluado <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../formacion"><i class="active"></i>Formacion</a></li>
        <li class="active">Familiar</li>
    </ol>
</section>

<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">Información Familiar</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
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
								<!--<select class="form-control input" id="parentesco" name="parentesco" placeholder="Parentesco Evaluado" required>
                                </select>-->
                                <input type="text" class="form-control input" name="parentesco" id="parentesco" placeholder="Parentesco con el Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombres del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Nombre del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA APELLIDO FAMILIAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellidos del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="apellido" id="apellido" placeholder="Apellido del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EDAD FAMILIAR -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="edad" class="control-label">Edad del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="edad" id="edad" placeholder="Edad del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL CONTACTO DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Número Contacto Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="telefono" id="telefono" placeholder="Número del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD DEL FAMILIAR --> 
                    <div class="col-xs-12 col-sm-3 center-block">
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
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="ocupacion" class="control-label">Ocupación del Familiar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input" name="ocupacion" id="ocupacion" placeholder="Ocupacion del Familiar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NOMBRE EMPRESA DEL FAMILIAR -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="empresa" class="control-label">Nombre de la Empresa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="empresa" id="empresa" placeholder="Nombre de la Empresa" required>
                            </div>
                        </div>
                    </div>
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
                    <!-- ENTRADA PARA RECIDENCIA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="residencia" class="control-label">Dirección: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="residencia" id="residencia" placeholder="Lugar de la Residencia" required>
                            </div>
                        </div>
                    </div>
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
                            <label for="departamento" class="control-label">Departamento Residencia:</label>
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
                    <div class="col-xs-12 col-sm-3 center-block">
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
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="depende_candidato" class="control-label">Depende económicamente del Evaluado:*</label>
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
                        <button id="btn-submit-familia" type="submit" class="btn btn-primary btnAddFamilia">Guardar</button>
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
                                <th>Empresa</th>
                                <th>Vive Evaluado</th>
                                <th>Depende Evaluado</th>
                                <th>Télefono</th>
                                <th>Ciudad Residencia</th>
                                <th>Residencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.familia.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/candidato/familia.js"></script>
