<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
?>

<section class="content-header">
    <h1>Empresa <strong><?= $solicitud['razon_social'] ?></strong></h1>
    <ol class="breadcrumb">
        <li><a href="../dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Empresa</li>
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
                    <h3 class="box-title">Datos Generales visita de Asociado al negocio</h3>
                </div>

            <div class="box-body">

                    <!-- ENTRADA PARA LA FECHA DE VISITA -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="fecha_visita" class="control-label">Fecha de visita: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="date" class="form-control input" name="fecha_visita" id="fecha_visita" placeholder="Ingrese el Nombre del Evaluado" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA RAZON SOCIAL -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="razon_social" class="control-label">Razón social: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="razon_social" id="razon_social" placeholder="Razón social" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NIT nuevo 1-->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nit" class="control-label">NIT: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="nit" id="nit" placeholder="NIT" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA DIRECCION -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="direccion" class="control-label">Dirección: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="direccion" id="direccion" placeholder="Ingrese la Dirección del Evaluado" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA TELEFONO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="telefono" class="control-label">Teléfono: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input solo-numero" name="telefono" id="telefono" placeholder="Ingrese el Teléfono del Evaluado" required>
                            </div>
                        </div>
                    </div>


                    <!-- ENTRADA PARA PAIS -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="pais" class="control-label">País: *</label>
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
                            <label for="departamento" class="control-label">Departamento: *</label>
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
                            <label for="id_ciudad_act" class="control-label">Ciudad: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-compass"></i></span>
                                <select class="form-control input" id="id_ciudad_act" name="id_ciudad_act" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CORREO UNO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="email1" class="control-label">E-mail: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input type="text" class="form-control input" name="email1" id="email1" placeholder="Ingrese el Correo" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA NOMBRE REPRESENTANTE LEGAL nuevo 2-->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre_representante" class="control-label">Nombres representante legal: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input " name="nombre_representante" id="nombre_representante" placeholder="Ingrese el Nombre" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA APELLIDO REPRESENTANTE LEGAL nuevo 3-->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="apellido_representante" class="control-label">Apellidos representante legal: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="apellido_representante" id="apellido_representante" placeholder="Ingrese el Apellido" required>
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


                    <!-- ENTRADA PARA NOMBRE -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="nombre" class="control-label">Nombres de la persona que atendio la visita: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input " name="nombre" id="nombre" placeholder="Ingrese el Nombre del Evaluado" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA APELLIDO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="apellido" class="control-label">Apellidos de la persona que atendio la visita: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control input" name="apellido" id="apellido" placeholder="Ingrese el Apellido del Evaluado" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CARGO -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="cargo_desempeno" class="control-label">Cargo: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="cargo_desempeno" id="cargo_desempeno" placeholder="Cargo del Evaluado" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA SERVICIO QUE PRESTA 
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="servicio_suministrado" class="control-label">Tipo de producto/servicio suministrado *Verificar productos restringidos.: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cc"></i></span>
                                <input type="text" class="form-control input" name="servicio_suministrado" id="servicio_suministrado" placeholder="Tipo de producto/servicio suministrado" required>
                            </div>
                        </div>
                    </div> -->

                    <!-- ENTRADA PARA CODIGO ACTIVIDAD ECONOMICA nuevo 4-->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="act_economica" class="control-label">Código de Actividad Económica: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="act_economica" id="act_economica" placeholder="actividad económica" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA CAPITAL SUSCRITO CAMARA DE COMERCIO nuevo 5 -->
                    <div class="col-xs-12 col-sm-3 center-block">
                        <div class="form-group">
                            <label for="capital_suscrito" class="control-label">Capital Suscrito en la Cámara de Comercio: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="capital_suscrito" id="capital_suscrito" placeholder="Capital Suscrito en la Cámara de Comercio" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA PAISES DE OPERACIONES DE COMERCIO EXTERIOR nuevo 6 -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="paises_exterior" class="control-label">País(es) donde realiza sus operaciones de comercio exterior: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                <input type="text" class="form-control input" name="paises_exterior" id="paises_exterior" placeholder="País(es) donde realiza sus operaciones de comercio exterior" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA FECHA DE CONSTITUCIÓN DE LA EMPRESA Y FECHA DE INICIO DE OPERACIONES nuevo 7-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="fch_constituida" class="control-label">Fecha de constitución de la empresa y fecha de inicio de operaciones: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="fch_constituida" id="fch_constituida" placeholder="Fecha de constitución de la empresa ..." required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA tmp_operacion -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="tmp_operacion" class="control-label">Hace cuanto tiempo opera en las instalaciones visitadas: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="tmp_operacion" id="tmp_operacion" placeholder="Ingrese el tiempo de operación" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA Volúmen de las operaciones mensuales nuevo 8-->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="vol_operaciones" class="control-label">Volúmen de las operaciones mensuales: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="vol_operaciones" id="vol_operaciones" placeholder="Volúmen de las operaciones mensuales" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA horario_operacion -->
                    <div class="col-xs-12 col-sm-6 center-block">
                        <div class="form-group">
                            <label for="horario_operacion" class="control-label">Horario de operación y Área Administrativa: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input type="text" class="form-control input" name="horario_operacion" id="horario_operacion" placeholder="Ingrese el horario de operación" required>
                            </div>
                        </div>
                    </div>

                    <!-- ENTRADA PARA Tiene mas instalaciones propias o de terceros nuevo 9-->
                    <div class="col-xs-12 col-sm-12 center-block">
                        <div class="form-group">
                            <label for="instalaciones" class="control-label">Tiene mas instalaciones propias o de terceros: *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <textarea class="form-control input" name="instalaciones" id="instalaciones" placeholder="Tiene mas instalaciones propias o de terceros" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA FOTO -->
                    <div class="col-xs-12 col-sm-12 center-block div-archivo" id="infoEdit">
                            <label class="control-label">Firma Guardada: </label>
                            <!-- <span id="info-edit"></span> -->
                            <a id="enlaceDirectorio" href="#" target="_blank"><span id="info-edit"></span></a>
                     </div>
                     <div class="col-xs-12 col-sm-12 center-block div-archivo">
                            <label class="control-label">Ingrese la firma: </label>
                            <span id="info"></span>
                        </div>
                    <div class="col-xs-12 col-sm-12  center-block div-archivo">
                            <label for="archivo" class="lbl-subir">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <span id="lbl-archivo">Seleccionar Archivo</span>
                            </label>
                            <input id="archivo" name="archivo" class="archivo" type="file" style="display: none;" accept=".jpg, .png" />
                        </div>

                    <div class="col-xs-12 col-sm-12"  style="color:red;">
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
<?php include 'vw.especificacion.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/visita_asociado/candidato_visita_asociado.js"></script>