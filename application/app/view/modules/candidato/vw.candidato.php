<section class="content-header">
    <h1>Evaluado <strong><?= $_SESSION[constant('APP_NAME')]['user']['nombres'] . " " . $_SESSION[constant('APP_NAME')]['user']['apellidos'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Evaluado</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content-header">
<div class="box box-primary">
    <form id="formCandidato" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="PUT">
                <input type="hidden" id="id_candidato" name="id_candidato" value="">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">

                <input type="hidden" id="pais_ac" value="">
                <input type="hidden" id="pais_nac" value="">
                <input type="hidden" id="dep_ac" value="">
                <input type="hidden" id="dep_nac" value="">
                <input type="hidden" id="ciu_ac" value="">
                <input type="hidden" id="ciu_nac" value="">

                <div class="box-header" id="div-crear">
                    <h3 class="box-title">Datos Personales</h3>
                </div>

            <div class="box-body">

                    <!-- ENTRADA PARA NOMBRE -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombres: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nombre" id="nombre" placeholder="Ingrese el Nombre del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA APELLIDO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellidos: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="apellido" id="apellido" placeholder="Ingrese el Apellido del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA TIPO DOCUMENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="tipo_id" class="control-label">Tipo Doc.: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                                <select class="form-control input" id="tipo_id" name="tipo_id" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA NRO DUCOMENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="numero_doc" class="control-label">Nro Doc.: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="numero_doc" id="numero_doc" placeholder="Ingrese el Número del Documento" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA PAIS NACIMIENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="pais_nacimiento" class="control-label">País Nacimiento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="pais_nacimiento" name="pais_nacimiento" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DEPARTAMENTO NACIMIENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="departamento_nacimiento" class="control-label">Departamento Nacimiento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="departamento_nacimiento" name="departamento_nacimiento" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CIUDAD NACIMIENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_nac" class="control-label">Ciudad Nacimiento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="id_ciudad_nac" name="id_ciudad_nac" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE NACIMIENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_nacimiento" class="control-label">Fecha de Nacimiento: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="fch_nacimiento" id="fch_nacimiento" placeholder="Ingrese la Fecha de Nacimiento" required>
                            </div>
                        </div>
                    </div>









                    <!-- ENTRADA PARA PAIS Expedición alejo edita -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="pais_expedicion" class="control-label">País Expedición: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="pais_expedicion" name="pais_expedicion" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DEPARTAMENTO Expedición -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="departamento_expedicion" class="control-label">Departamento Expedición: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="departamento_expedicion" name="departamento_expedicion" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CIUDAD Expedición -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_expe" class="control-label">Ciudad Expedición: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="id_ciudad_expe" name="id_ciudad_expe" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FECHA DE Expedición -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fch_expedicion" class="control-label">Fecha de Expedición: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control" name="fch_expedicion" id="fch_expedicion" placeholder="Ingrese la Fecha de Expedición" required>
                            </div>
                        </div>
                    </div> 











                    <!-- ENTRADA PARA PAIS -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País Actual: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="pais" name="pais" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DEPARTAMENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="departamento" class="control-label">Departamento Actual: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="departamento" name="departamento" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CIUDAD -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Ciudad Actual: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select style="text-transform: uppercase;" class="form-control input" id="id_ciudad_act" name="id_ciudad_act" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EDAD -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="edad" class="control-label">Edad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="edad" id="edad" placeholder="Ingrese la Edad" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA LIBRETA MILITAR -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="libreta" class="control-label">Libreta Militar-indicar número: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input" name="libreta" id="libreta" placeholder="Ingrese la Libreta Militar" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ESTADO CIVIL -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="estado_civil" class="control-label">Estado Civil: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <select class="form-control input" id="estado_civil" name="estado_civil" required>
                                </select>
                            </div>
                        </div>
                    </div>                      
                    <!-- ENTRADA PARA TELEFONO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Teléfono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="telefono" id="telefono" placeholder="Ingrese el Teléfono del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA DIRECCION -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="direccion" class="control-label">Dirección: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="direccion" id="direccion" placeholder="Ingrese la Dirección del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA BARRIO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="barrio" class="control-label">Barrio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="barrio" id="barrio" placeholder="Ingrese el Barrio del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA ESTRACTO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="estracto" class="control-label">Estrato: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="number" class="form-control input solo-mayuscula" name="estracto" id="estracto" placeholder="Ingrese el Estracto del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <div style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    
                    <div class="modal-footer">
                        <button id="btn-submit-candidato" type="submit" class="btn btn-primary btnEditCandidato">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<script src="<?= constant('APP_URL') ?>app/js/candidato/candidato.js"></script>
