
<section class="content-header">
    <h1>Evaluado <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="../laboral"><i class="active"></i>Laboral</a></li>
        <li class="active">Adjuntos</li>
    </ol>
</section>

<style>
    .lbl-subir {
        padding: 5px 10px;
        background: #f39c12;
        color: #fff;
        border: 0px solid #fff;
    }

    .lbl-subir:hover {
        color: #fff;
        background: #00a65a;
    }
</style>

<section class="content-header">
<div class="box box-primary">
<div class="modal-header">
        <div class="row">
            <div class="col-xs-12 col-sm-8 center-block">
                <h4 class="box-title">Cargue Adjuntos</h4>
            </div>
            <div class="col-xs-12 col-sm-4 center-block">
                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
            </div>
        </div>
    </div>
    <form id="frmCargarArchivo" role="form" method="post" enctype="multipart/form-data">

                <input type="hidden" id="accion" name="accion" value="">
                <input type="hidden" id="id_adjunto" name="id_adjunto" value="">
                <input type="hidden" id="observacion" name="observacion" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']?>">
                <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?=  $_GET['id_solicitud'] ?>">
                <input type="hidden" name="id_servicio" id="id_servicio" value="">
                <input type="hidden" name="lista" id="lista" value="">

                <div class="box-body">


                    <!-- ENTRADA PARA EL TIPO DE CONTRATO -->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="tipo_doc" class="control-label">Tipo de Adjunto: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input" id="tipo_doc" name="tipo_doc" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 center-block div-archivo">
                            <label class="control-label">Archivo : </label>
                            <span id="info"></span>
                        </div>
                    <div class="col-xs-12 col-sm-12  center-block div-archivo">
                            <label for="archivo" class="lbl-subir">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <span id="lbl-archivo">Seleccionar Archivo</span>
                            </label>
                            <input id="archivo" name="archivo" class="archivo" type="file" style='display: none;' accept=".jpg, .jpeg, .png, .pdf" />
                        </div>

                    <div class="modal-footer">
                        <button id="btn-submit-adjuntos" type="submit" class="btn btn-primary btnCargarArchivo">Guardar</button>
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

                    <table id="tbl-adjuntos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tipo Documento</th>
                                <th>Archivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php //include 'vw.adjuntos.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/candidato/adjuntos.js"></script>
