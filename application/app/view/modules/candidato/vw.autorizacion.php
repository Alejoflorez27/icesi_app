<?php
$solicitudId = $router->param('id_solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);

$servicioId = $router->param('id_servicio');
$resp_menu = CtrMenuFormatos::findAll($servicioId);

//$servicioIdSol = $router->param('id_servicio');
$resp_sol_srv = CtrSolSolicitud::qry_solicitud($solicitudId,$servicioId);
//print_r($resp_menu);

$servicioSol = null;
if (Result::isSuccess($resp_sol_srv))
    $servicioSol = Result::getData($resp_sol_srv);
    //print_r($resp_sol_srv);

$servicio = null;
if (Result::isSuccess($resp_menu))
    $servicio = Result::getData($resp_menu);
//print_r($servicio);

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
//print_r($solicitud);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        /*font-size: 14px;*/
        line-height: 1.6;
        /*margin: 30px;*/
        color: #333;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .fecha {
        font-weight: bold;
        margin-bottom: 15px;
    }
    .contenido {
        text-align: justify;
    }
    .firma {
        margin-top: 40px;
        text-align: left;
    }
    .firma-linea {
        display: block;
        margin-top: 50px;
        border-top: 1px solid #000;
        width: 300px;
    }
    .resaltado {
        font-weight: bold;
    }

        .lbl-subir {
        padding: 8px 15px;
        background: #f39c12;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        margin-bottom: 10px;
        text-align: center;
    }

    .lbl-subir:hover {
        background: #00a65a;
        color: #fff;
    }

    #info {
        display: block;
        margin-top: 5px;
        font-size: 14px;
        color: #555;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <div class="modal-header">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 center-block">
                                <h4 class="box-title">AUTORIZACIÓN</h4>
                            </div>
                            <!--<div class="col-xs-12 col-sm-4 center-block">
                                <button id="btn-submit-Siguiente" type="submit" class="btn btn-success btnSiguiente pull-right">Siguiente</button>
                                <button id="btn-submit-Anterior" type="submit" class="btn btn-danger btnAnterior pull-right">Anterior</button>
                            </div>-->

                            <form id="formObservacion" role="form" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="accion" name="accion" value="">
                                <input type="hidden" id="id_auto" name="id_auto" value="">
                                <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?=  $_GET['id_solicitud'] ?>">
                                <input type="hidden" id="usuario" name="usuario" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']?>">
                                <input type="hidden" id="fch_candidato_auto" name="fch_candidato_auto" value="<?php echo date('Y-m-d H:i:s'); ?>">

                                <p id="fecha_actual" class="fecha">
                                    <br>
                                    Fecha: <?php echo date("d-m-Y"); ?>
                                </p>



                                <div class="contenido">
                                    <p>
                                        Yo <?= $solicitud['nombre_candidato'] ?> Identificado(a) con Cédula de Ciudadanía No. <?= $solicitud['numero_documento'] ?> expedida en <?= $solicitud['ciudad_exp']." " ?>                                <?php
                                        $fecha_formateada = '';if (!empty($solicitud['fch_expedicion'])) {$fecha_formateada ="el ". date("d-m-Y", strtotime($solicitud['fch_expedicion']));}echo $fecha_formateada;?>,
                                        dando conformidad con la Ley 1581 de 2012, el decreto reglamentario 1377 de 2013 y la Ley 1266 de 2008 modificada por la Ley 2157 de 2021, autorizo a la empresa
                                        <span class="resaltado">PROHUMANOS ALIADOS ESTRATEGICOS LTDA.</span>, para que le dé el tratamiento respectivo a mis datos personales y demás información suministrada o requerida para realizar el estudio de confiabilidad de ingreso a la empresa
                                        <?= $solicitud['cliente_desc'] ?>, así como durante la vigencia de la relación laboral en caso de ser contrato o la vinculación laboral ya existente.
                                    </p>
                                    <p>
                                        La compañía puede solicitar, recolectar, recaudar, almacenar, usar, circular, suprimir, procesar, compilar, intercambiar, dar tratamiento, actualizar, conservar, remitir a la Entidad y disponer de los datos que han sido suministrados y los asociados en distintas bases o bancos de datos tales como son Administradores del Sistema de Seguridad Social, Centrales de Riesgo Financiero (si es el caso), autoridades judiciales de Policía, la Procuraduría General de la República, la Contraloría General de la Nación o cualquier otra fuente de información legalmente constituida.
                                    </p>
                                    <p>
                                        De igual forma, autorizo a la empresa para que adelante los procesos de verificación de información de la hoja de vida (experiencia laboral y formación académica), realización de visita domiciliaria e indagación con mi círculo social y/o aquellas personas que puedan dar fe que me conocen, con el fin de confirmar la información suministrada durante el proceso, para corroborar el objeto de la presente autorización.
                                    </p>
                                    <p>
                                        Confirmo y acepto por medio del presente escrito, que he tenido acceso, he leído y he comprendido las políticas para el tratamiento de datos personales de la empresa <span class="resaltado">PROHUMANOS ALIADOS ESTRATEGICOS LTDA.</span>; así mismo confirmo que para el caso de la visita domiciliaria el profesional presenta carta de presentación o carné que lo acredita como funcionario de la empresa <span class="resaltado">PROHUMANOS ALIADOS ESTRATEGICOS LTDA.</span>
                                    </p>
                                    <p>
                                        Igualmente declaro que conozco mis derechos de poder solicitar, actualizar, corregir, completar y precisar mis datos personales, a <span class="resaltado">PROHUMANOS ALIADOS ESTRATEGICOS LTDA.</span>, así como revocar la presente autorización antes de iniciar el proceso, enviando una petición o solicitud al correo <a href="mailto:gerencia@prohumanos.com">gerencia@prohumanos.com</a>
                                    </p>
                                    <p>
                                        Por lo cual autorizo a <span class="resaltado">PROHUMANOS ALIADOS ESTRATEGICOS LTDA.</span> a:
                                    </p>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group" style="white-space: nowrap;">
                                        <p style="display:inline-block; margin:0; margin-right:10px;">
                                            Contactar a mi actual empleador (Área de recursos humanos y jefe inmediato),
                                        </p>
                                        <select class="form-control input" id="contactar_empleador" name="contactar_empleador" style="display:inline-block; width:auto;" required>
                                            <option value="">Seleccione</option>
                                            <option value="S">Sí</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>


                                    <p>
                                        &nbsp;&nbsp;&nbsp;•	Si no marca la anterior opción, damos por entendido que se verificarán todas las experiencias laborales de los últimos 5 años.
                                    </p>   
                                    <p>
                                        &nbsp;&nbsp;&nbsp;•	A realizar la validación académica en las siguientes instituciones:
                                    </p>   

                                <div class="col-xs-12 col-sm-12 center-block">
                                    <div class="form-group">
                                        <textarea class="form-control input" id="instituciones" name="instituciones"required></textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group" style="white-space: nowrap;">
                                        <p style="display:inline-block; margin:0; margin-right:10px;">
                                            •	Se realice grabación de la visita domiciliaria 
                                        </p>
                                        <select class="form-control input" id="grabacion" name="grabacion" style="display:inline-block; width:auto;" required>
                                            <option value="">Seleccione</option>
                                            <option value="S">Sí</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group" style="white-space: nowrap;">
                                        <p style="display:inline-block; margin:0; margin-right:10px;">
                                            •	Registro fotográfico del interior y exterior de la vivienda, durante la visita 
                                        </p>
                                        <select class="form-control input" id="registro_foto" name="registro_foto" style="display:inline-block; width:auto;" required>
                                            <option value="">Seleccione</option>
                                            <option value="S">Sí</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Subida de archivo -->
                                <div class="row" style="margin-top: 15px;">
                                    <div class="col-sm-6">
                                    <label for="archivo" class="lbl-subir">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir Firma
                                    </label>
                                    <input id="archivo" name="archivo" type="file" style="display:none;" accept=".jpg, .png, .pdf">
                                    <span id="info"></span>
                                    </div>
                                </div>

                                    <p>
                                        Dar clic en el cuadro de acepto y comprendo la información anteriormente relacionada, autorizo a la empresa PROHUMANOS ALIADOS ESTRATEGICOS LTDA., en el uso de mis datos personales y documentos proporcionados para el desarrollo del estudio de confiabilidad.
                                    </p>

                                <div class="col-xs-12 col-sm-12">
                                    <div class="form-group" style="white-space: nowrap;">

                                        <select class="form-control input" id="acepto" name="acepto" style="display:inline-block; width:auto;" required>
                                            <option value="">Seleccione</option>
                                            <option value="S">Sí</option>
                                            <option value="N">No</option>
                                        </select>
                                        <p style="display:inline-block; margin:0; margin-right:10px;">
                                            Acepto y comprendo 
                                        </p>
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
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/candidato/autorizacion.js"></script> 