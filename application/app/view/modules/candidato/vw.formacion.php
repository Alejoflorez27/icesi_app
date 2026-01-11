<section class="content-header">
    <h1>Evaluado <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../candidato"><i class="active"></i>Evaluado</a></li>
        <li class="active">Formacion</li>
    </ol> 
</section>

<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">Información Académica</h4>
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
                                <input type="text" class="form-control input" name="nombre_institucion" id="nombre_institucion" placeholder="Ingrese el Nombre de la Institucion del Evaluado" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PROGRAMA ACADEMICO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="programa_academico" class="control-label">Programa Academico: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="programa_academico" id="programa_academico" placeholder="Ingrese el Programa Academico del Evaluado" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE GRADUACIÓN -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="fch_grado" class="control-label">Fecha de Graduacion: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="date" class="form-control" name="fch_grado" id="fch_grado" placeholder="Ingrese Fecha de Graduación" >
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ACTA Y FOLIO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="acta_folio" class="control-label">Acta y Folio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="acta_folio" id="acta_folio" placeholder="Ingrese Acta y Folio" >
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.formacion.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/candidato/formacion.js"></script>
