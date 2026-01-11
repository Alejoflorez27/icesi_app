<div class="row">
    <div class="col-xs-6 col-sm-12 center-block">
        <!-- Distribución de la vivienda-->
        <section class="content-header">
        <div class="box box-primary">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 center-block">
                        <h4 class="box-title">Configuración de Festivos</h4>
                    </div>
                </div>
            </div>
            <form id="formOperativo" role="form" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" id="accion" name="accion" value="">
                        <input type="hidden" id="id_dias" name="id_dias" value="">
                        <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

                    <div class="box-body">

                            <!-- ENTRADA PARA REQUISITO -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="fecha" class="control-label">Fecha: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <input type="date" class="form-control input" id="fecha" name="fecha" required></input>
                                    </div>
                                </div>
                            </div>

                            <!-- ENTRADA PARA ESTADOS DE LOS ESPACIOS -->
                            <div class="col-xs-12 col-sm-6 center-block">
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción: *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                        <textarea class="form-control input" id="descripcion" name="descripcion" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div style="color:red;">
                                Campos señalados con * son obligatorios
                            </div>                    

                            <div class="modal-footer">
                                <button id="btn-submit-operativo" type="submit" class="btn btn-primary btnAddOperativo">Guardar</button>
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

                            <table id="tbl-operativo" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fin de Distribución de la vivienda-->
    </div>
</div>

<?php include 'vw.festivos.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/sol/festivos.js"></script>
