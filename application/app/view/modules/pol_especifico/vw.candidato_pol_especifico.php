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
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Evaluado</li>
        <li class="active">Lista</li>
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
    <!--<form id="formCandidato" role="form" method="post" enctype="multipart/form-data" autocomplete="off">-->
    <form id="formPoligrafiaPre" role="form" method="post" enctype="multipart/form-data" autocomplete="off">

                <input type="hidden" id="accion" name="accion" value="POST">
                <input type="hidden" id="id_candidato" name="id_candidato" value="">
                <input type="hidden" id="nomFoto" name="nomFoto" value=""> 
                <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?=  $_GET['id_solicitud'] ?>">
                <input type="hidden" name="id_servicio" id="id_servicio" value="<?=  $_GET['id_servicio'] ?>">
                <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['numero_identificacion']?>">
                
                <div class="box-header" id="div-crear">
                    <h3 class="box-title">Datos Generales Poligrafía Especifico</h3>
                </div>

            <div class="box-body">

                    <!-- ENTRADA PARA NOMBRE -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombres del Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="nombre" id="nombre" placeholder="Ingrese el Nombre del Evaluado" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA APELLIDO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellidos del Evaluado: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="apellido" id="apellido" placeholder="Ingrese el Apellido del Evaluado" required>
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
                                <select class="form-control input" id="pais_nacimiento" name="pais_nacimiento" required>
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
                                <select class="form-control input" id="departamento_nacimiento" name="departamento_nacimiento" required>
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
                                <select class="form-control input" id="id_ciudad_nac" name="id_ciudad_nac" required>
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

                    <!-- ENTRADA PARA PAIS -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País donde Vive: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <select class="form-control input" id="pais" name="pais" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA DEPARTAMENTO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="departamento" class="control-label">Departamento donde vive: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                <select class="form-control input" id="departamento" name="departamento" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CIUDAD -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="id_ciudad_act" class="control-label">Ciudad donde vive: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input" id="id_ciudad_act" name="id_ciudad_act" required>
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
                    <!-- ENTRADA PARA CORREO UNO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="email1" class="control-label">Correo 1: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="email1" id="email1" placeholder="Ingrese el Correo del Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA CORREO DOS-->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="email2" class="control-label">Correo 2: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="email2" id="email2" placeholder="Ingrese el Correo del Evaluado" required>
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
                                <input type="text" class="form-control input solo-mayuscula" name="barrio" id="barrio" placeholder="Ingrese el Barrio del Evaluado" required>
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

                    <!-- ENTRADA PARA NIVEL DE ESCOLARIDAD -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="nivel_escolar" class="control-label">Nivel de Escolaridad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <select class="form-control input select2" id="nivel_escolar" name="nivel_escolar" placeholder="Nivel de Escolaridad" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CARGO QUE DESEMPEÑO -->
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="cargo_desempeno" class="control-label">Cargo a desempeñar: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input solo-mayuscula" name="cargo_desempeno" id="cargo_desempeno" placeholder="Cargo al que Ingreso el Evaluado" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL ALIAS 
                    <div class="col-xs-12 col-sm-4 center-block">
                        <div class="form-group">
                            <label for="alias" class="control-label">Alias: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="alias" id="alias" placeholder="El alias del Evaluado" required>
                            </div>
                        </div>
                    </div> -->
                    <!-- ENTRADA PARA FOTO -->
                    <div class="col-xs-12 col-sm-12 center-block div-archivo" id="infoEdit">
                        <label class="control-label">Foto:</label>

                        <span id="contenedor-foto">
                            <a id="enlaceDirectorio" href="#" target="_blank">
                                <span id="info-edit"></span>
                            </a>
                            <a href="#" 
                            id="btnEliminarFoto" 
                            class="btn-eliminar-foto-solicitud" 
                            style="margin-left:8px; display:none;">
                                <i class="fa fa-trash text-danger" aria-hidden="true" title="Eliminar Foto"></i>
                            </a>
                        </span>
                    </div>
                     <div class="col-xs-12 col-sm-12 center-block div-archivo">
                            <label class="control-label">Foto del Evaluado: </label>
                            <span id="info"></span>
                        </div>
                    <div class="col-xs-12 col-sm-12  center-block div-archivo">
                        <label for="archivo" class="lbl-subir">
                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                            <span id="lbl-archivo">Seleccionar Archivo</span>
                        </label>
                        <input id="archivo" name="archivo" class="archivo" type="file" style="display: none;" accept=".jpg, .png" />
                    </div>
                    <div class="col-xs-12 col-sm-12  center-block">
                    <strong><br>PROPOSITO DEL EXAMEN:<br></strong> 
                    La empresa <?= $solicitud['cliente_desc'] ?> solicita evaluación poligráfica con el propósito de determinar si <?= $solicitud['nombre_candidato'] ?> cumple con el perfil de confiabilidad para desempeñarse en el cargo de: <?= $solicitud['cargo'] ?>
                        <br>
                        <br>
                    </div>

                    <div class="col-xs-12 col-sm-12  center-block" style="color:red;">
                        Campos señalados con * son obligatorios
                    </div>                    

                    <div class=" col-xs-12 col-sm-12  center-block modal-footer">
                        <button id="btn-submit-candidato" type="submit" class="btn btn-primary btnEditCandidato">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<?php include 'vw.especificacion.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/pol_especifico/candidato_pol_especifico.js"></script>