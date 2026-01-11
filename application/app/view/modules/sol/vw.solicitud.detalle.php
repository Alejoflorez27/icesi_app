<?php
$solicitudId = $router->param('solicitud');
$resp = CtrSolSolicitud::findById($solicitudId);
//print_r($resp);

$usuario = CtrUsuario::getUsuarioApp();
$respuesta_usr = CtrUsuario::consultar($usuario);
$empresa = $respuesta_usr['id_empresa'];

$solicitud = null;
if (Result::isSuccess($resp))
    $solicitud = Result::getData($resp);
    //print_r($solicitud['id_combo']);

    $manual = CtrSrvCombos::findAllByComboManual($solicitud['id_combo']);

    //print_r($manual);

    $condicion_manual = ($manual['data'][0]['tiene_manual'] == "1");


require_once 'cnf.solicitud.button.php';
?>

<section class="content-header">
    <h1>Detalle de la solicitud</h1>
    <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Solicitud</li>
        <li class="active">Detalle</li>
    </ol>
</section>


<section class="content">

    <div class="row">

        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title"> Solicitud </h4>
                </div>
                <div class="box-body">
                    <table id="tbl-det-solicitud" class="table table-bordered table-hover table-striped solicitud">

                        <?php 
                        $perfiles_clientes = ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 7 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 8 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 9);
                        $perfiles_proveedor = ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 10 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 11 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 13 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 15 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 16);
                        $perfiles_sin_calidad_proveedor = ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 10 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 11 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 15 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 16);
                        ?>

                        <tr>
                            <td>Solicitud:</td>
                            <th><?= $solicitud['id_solicitud'] ?></th>
                        </tr>
                        <tr>
                            <td>Combo:</td>
                            <th><?= $solicitud['nom_combo']?></th>
                        </tr>
                        <tr>
                            <td>Fecha Solicitud:</td>
                            <td><?= $solicitud['fch_solicitud'] ?></td>
                        </tr>
                        <!--<?php //if (!$perfiles_proveedor) : ?>-->
                            <tr>
                                <td>Cliente:</td>
                                <th><?= $solicitud['cliente_desc'] ?></th>
                            </tr>
                            <tr>
                                <td>Responsable:</td>
                                <th><?= $solicitud['resposable'] ?></th>
                            </tr>
                            <tr>
                                <td>Correo Responsable:</td>
                                <th><?= $solicitud['correo_resposable'] ?></th>
                            </tr>
                        <!--<?php //endif; ?>-->
                        <tr>
                            <td>Canal Recepcion:</td>
                            <td><?= $solicitud['desc_recepcion'] ?></td>
                        </tr>
                        <tr>
                            <td>Candidato:</td>
                            <td><?= $solicitud['nombre_candidato'] ?></td>
                        </tr>
                        <tr>
                            <td>Núm. Documento:</td>
                            <td><?= $solicitud['numero_documento']." - ". $solicitud['des_documento']?></td>
                        </tr>
                        <tr>
                            <td>Cargo:</td>
                            <td><?= $solicitud['cargo'] ?></td>
                        </tr>
                        <tr>
                            <td>Celular:</td>
                            <td><?= $solicitud['telefono'] ?></td>
                        </tr>
                        <tr>
                            <td>Correo:</td>
                            <td><?= $solicitud['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Direccion:</td>
                            <td><?= $solicitud['direccion'] ?></td>
                        </tr>
                        <tr>
                            <td>Ciudad:</td>
                            <td><?= $solicitud['des_ciudad'] ?></td>
                        </tr>
                        <tr>
                            <td>Est. Solicitud:</td>
                            <th><?= $solicitud['estado_desc'] ?></th>
                        </tr>
                        <tr>
                            <td>Observación:</td>
                            <td><?= $solicitud['observacion'] ?></td>
                        </tr>
                        <?php if (!empty($solicitud['archivos'])) : ?>
                            <tr>
                                <td>Archivos:</td>
                                <td>
                                    <ul>
                                        <?php foreach ($solicitud['archivos'] as $file) : ?>
                                            <?php
                                            $fileName = ($file['nombre'] ?? $file['observacion']);
                                            $fileDigital =   '/' . $file['directorio'] . '/' . $file['nombre_encr'];
                                            $fileId = $file['id_adjunto'];

                                            ?>
                                            <li style="margin-left:0px;">
                                                <a href="<?= $fileDigital ?>" target="_blank"><?= $fileName ?></a>
                                                <a href="#" class="btn-eliminar-archivo-solicitud pull-right" archivoId="<?= $fileId ?>" archivoDigital="<?= $fileDigital ?>">
                                                    <?php if (!$perfiles_clientes) :?>
                                                        <i class="fa fa-trash" aria-hidden="true" title="Eliminar Archivo <?= $fileName ?>"></i>
                                                    <?php endif; ?>
                                                    
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Acciones:</td>
                            <th>
                                <?php $estado_finalizado_sol =  ($solicitud['id_estado_solicitud'] == 'finalizada' && ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 1 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 12|| $_SESSION[constant('APP_NAME')]['user']['perfil'] == 13));
                                    $estado_finalizado__cal_vlo_adi =  ($solicitud['id_estado_solicitud'] == 'finalizada' && ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 1 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 12));
                                    $estado_finalizado_sol_cli =  (($solicitud['id_estado_solicitud'] == 'finalizada' || $solicitud['preliminar'] == 'S') && ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 7 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 8 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 9));
                                    $perfiles_internos = ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 1 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 10 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 11 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 12 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 13 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 15 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 16);
                                ?>
                                <?php if (($show_btn_finalizar && (($solicitud['concepto_final'] != "" || $solicitud['concepto_final'] != null) && ($solicitud['obs_calidad'] != null || $solicitud['obs_calidad'] != ''))) || ($show_btn_finalizar && $condicion_manual)) : ?>
                                    <button class="btn btn-success btn-xs btnFinalizarSolicitud" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-check" aria-hidden="true"></i> Finalizar</button>
                                <?php endif; ?>
                                <?php if ($show_btn_cancelar_solicitud) : ?>
                                    <button class="btn btn-danger  btn-xs btnCancelarSolicitud" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                                <?php endif; ?>
                                <?php if ($show_btn_editar) : ?>
                                    <button class="btn btn-warning btn-xs btnEditSolicitud" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                                <?php endif; ?>
                                <?php if ($show_btn_archivo_solicitud || $estado_finalizado_sol) : ?>
                                    <button class="btn btn-success btn-xs btnAgregarArchivoSolicitud" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Cargar Archivo</button>
                                <?php endif; ?>
                                <?php if ($show_btn_reenviar) : ?>
                                    <button class="btn btn-outline-danger btn-xs btnReenviarCorreo" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i> Reenviar Correo</button>
                                <?php endif; ?>
                                <?php if ($show_btn_servicios_adicionales) : ?>
                                    <button class="btn btn-warning btn-xs btnServiciosAdicionales" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-usd" aria-hidden="true"></i> Srv Adicionales</button>
                                <?php endif; ?>
                                <?php if ($show_btn_preliminar) : ?>
                                    <button class="btn btn-info btn-xs btnPreliminar" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-eye" aria-hidden="true"></i> Preliminar</button>
                                <?php endif; ?>
                                <?php if ($show_btn_agregar_servicio) : ?>
                                    <button class="btn btn-warning btn-xs btnAgregarServicios" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Servicio</button>
                                <?php endif; ?>
                                <?php if ($show_btn_pdf_combo && $estado_finalizado_sol_cli) : ?>
                                    <!-- <button class="btn btn-danger btn-xs btnAgregarServicios" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-plus" aria-hidden="true"></i> Ir a PDF</button> -->
                                    <button class="btn btn-xs btn-danger btnIrPdfSolCombo" solicitud="<?= $solicitud['id_solicitud'] ?>" combo="<?= $solicitud['id_combo'] ?>" rutaInforme="<?= $srv['reporte'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a PDF Estado (<?= $solicitud['estado_desc'] ?>)  </button>
                                <?php endif; ?>

                                <?php if ($show_btn_pdf_combo && $perfiles_internos) : ?>
                                    <!-- <button class="btn btn-danger btn-xs btnAgregarServicios" solicitud="<?= $solicitud['id_solicitud'] ?>"><i class="fa fa-plus" aria-hidden="true"></i> Ir a PDF</button> -->
                                    <button class="btn btn-xs btn-danger btnIrPdfSolCombo" solicitud="<?= $solicitud['id_solicitud'] ?>" combo="<?= $solicitud['id_combo'] ?>" rutaInforme="<?= $srv['reporte'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a PDF Estado (<?= $solicitud['estado_desc'] ?>)  </button>
                                <?php endif; ?>

                                <?php if ($show_btn_obs_calidad) : ?>
                                    <button class="btn btn-xs btn-primary btnObsCalidad" solicitud="<?= $solicitud['id_solicitud'] ?>" combo="<?= $solicitud['id_combo'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Concepto Consolidado Del Estudio</button>
                                <?php endif; ?>

                                <?php if ($show_btn_centro_costo) : ?>
                                    <button class="btn btn-xs btn-warning btnCentroCosto" solicitud="<?= $solicitud['id_solicitud'] ?>" combo="<?= $solicitud['id_combo'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Centro de Costos</button>
                                <?php endif; ?>
                            </th>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title"> Servicios </h4>
                </div>
                <div class="box-body">

                    <div class="panel-group" id="accordion">

                        <?php foreach ($solicitud['servicios'] as $idxsrv => $srv) : ?>
                            <?php $namePanel = strtolower(str_replace(' ', '-', $srv['nom_servicio']));  ?>

                            <div class="panel panel-primary">

                                <div class="panel-heading panel-primary">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $namePanel ?>">
                                            <strong> <?= $srv['nom_servicio']  ?></strong></a>
                                    </h4>
                                </div>
                                <!-- clase vieja para que el primero inicie abrierto -->
                                <!--<div id="collapse-<?= $namePanel ?>" class="panel-collapse collapse <?= ($idxsrv == 0) ? 'in' : '' ?>">-->
                                <!-- clase para que el primero inicie cerrado -->
                                <div id="collapse-<?= $namePanel ?>" class="panel-collapse collapse">

                                    <div class="panel-body">
                                        <div class="col-xs-12 col-md-7">
                                            <table class="table table-bordered table-hover table-striped">
                                                <?php if (isset($srv['id_usuario_asig'])) : ?>
                                                    <tr>
                                                        <th style="width: 35%;">Proveedor:</th>
                                                        <td><?= $srv['nom_usr_asig'] ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (isset($srv['id_usuario_calidad'])) : ?>
                                                    <tr>
                                                        <th style="width: 35%;">Asignado Calidad:</th>
                                                        <td><?= $srv['nom_usr_asig_calidad'] ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if (isset($srv['fecha_programacion'])) : ?>
                                                    <tr>
                                                        <th>Programado:</th>
                                                        <td><?= $srv['fecha_programacion'] ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if (isset($srv['asistio'])) : ?>
                                                    <tr>
                                                        <th>Asistió:</th>
                                                        <td><?= ($srv['asistio'] == '1') ? 'Sí' : 'No' ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (isset($srv['observacion'])) : ?>
                                                    <tr>
                                                        <th>Observación:</th>
                                                        <td><?= str_replace("\n", '<br>', $srv['observacion']) ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (isset($srv['observacion_asistio'])) : ?>
                                                    <tr>
                                                        <th>Observación Asistencia:</th>
                                                        <td><?= str_replace("\n", '<br>', $srv['observacion_asistio']) ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if (isset($srv['valor_adicional_srv'])) : ?>
                                                    <tr>
                                                        <th>Valor Adicional:</th>
                                                        <td><?= $srv['valor_adicional_srv'] ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if ($srv['calificado'] == 'S') : ?>
                                                    <tr>
                                                        <th>Calificado:</th>
                                                        <td><?= $srv['desc_calificado'] ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if (!isset($empresa)) : ?>
                                                    <?php if (isset($srv['observacion_finalizacion'])) : ?>
                                                        <tr>
                                                            <th>Observación Finalizado:</th>
                                                            <td><?= $srv['observacion_finalizacion'] ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if (!empty($srv['archivos'])) : ?>
                                                    <tr>
                                                        <th>Archivos:</th>
                                                        <td>
                                                            <ul>
                                                            <?php foreach ($srv['archivos'] as $file) : ?>
                                                            <?php
                                                            $fileName = ($file['nombre'] ?? $file['observacion']);
                                                            $fileDigital = '/' . $file['directorio'] . '/' . $file['nombre_encr'];
                                                            $fileId = $file['id_adjunto'];
                                                            //print_r($fileDigital);
                                                            ?>

                                                            <li style="margin-left:0px;">
                                                                <!-- Enlace para visualizar el archivo -->

                                                                <a href="<?= $fileDigital ?>" target="_blank"><?= $fileName ?></a>
                                                                
                                                                <!--<button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-danger btnVisualizar" data-file-digital="<?= $fileDigital ?>">
                                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?= $fileName ?>
                                                                </button>-->


                                                                <!-- Enlace para eliminar el archivo -->
                                                                <a href="#" class="btn-eliminar-archivo-servicio pull-right" archivoId="<?= $fileId ?>" archivoDigital="<?= $fileDigital ?>">
                                                                    <?php if (!$perfiles_clientes) :?>
                                                                        <i class="fa fa-trash" aria-hidden="true" title="Eliminar Archivo <?= $fileName ?>"></i>
                                                                    <?php endif; ?>
                                                                </a>
                                                            </li>

                                                        <?php endforeach; ?>

                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if (isset($srv['id_servicio'])): ?>
                                                    <?php
                                                        // Asignar los valores a las variables
                                                        $id_solicitud = $solicitud['id_solicitud'];
                                                        $id_servicio = $srv['id_servicio'];

                                                        // Llamar a la función para obtener el resultado
                                                        $resultado = CtrVivConceptoProfesional::findByIdConcepto($id_solicitud, $id_servicio);

                                                        // Verificar si hay datos
                                                        if (isset($resultado['data']) && isset($resultado['data'][0])):
                                                            $concepto = $resultado['data'][0];
                                                            $observacion = isset($concepto['observacion']) ? $concepto['observacion'] : '';

                                                            // Condición especial para los servicios 1, 6, 7, 11
                                                            if (in_array($id_servicio, [1,6,7,11])) {
                                                                // Solo mostrar si NO tiene la observación "(faltan servicios por calificar)"
                                                                if ($observacion): ?>
                                                                    <tr>
                                                                        <th style="width: 35%;">Concepto Final:</th>
                                                                        <td><h4><strong style="color: #337ab7;">
                                                                            <?= htmlspecialchars($concepto['des_concepto'], ENT_QUOTES, 'UTF-8') ?>
                                                                        </strong></h4></td>
                                                                    </tr>
                                                                <?php else: ?>
                                                                    <tr>
                                                                        <th style="width: 35%;">Concepto Final:</th>
                                                                        <td><h4><strong style="color: #337ab7;">No disponible</strong></h4></td>
                                                                    </tr>
                                                                <?php endif;
                                                            } else {
                                                                // Comportamiento normal para los demás servicios
                                                                ?>
                                                                <tr>
                                                                    <th style="width: 35%;">Concepto Final:</th>
                                                                    <td><h4><strong style="color: #337ab7;">
                                                                        <?= htmlspecialchars($concepto['des_concepto'], ENT_QUOTES, 'UTF-8') ?>
                                                                    </strong></h4></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <th style="width: 35%;">Concepto Final:</th>
                                                                <td><h4><strong style="color: #337ab7;">No disponible</strong></h4></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                <?php endif; ?>




                                                <tr>
                                                    <td colspan="2">

                                                        <?php if ($srv['estado_id'] != 0) : ?>
                                                            
                                                            <?php $estado_finalizado =  ($srv['estado_id'] != 8 && ($srv['estado_proceso'] != 7 || $srv['estado_proceso'] != 6 || $srv['estado_proceso'] != 9))?>
                                                            <?php $estado_finalizado_srv =  ($srv['estado_id'] == 5 && ($srv['estado_proceso'] == 1 || $srv['estado_proceso'] == 2))?>
                                                            <?php $estado_calidad_sin_provedor =  ($srv['estado_id'] == 5 && ($srv['estado_proceso'] == 1 || $srv['estado_proceso'] == 2)) && ($perfiles_sin_calidad_proveedor)?>
                                                            <?php $calificar_servicio =  ($srv['id_usuario_calidad'] != null || $srv['id_usuario_calidad'] != '')?>
                                                            <?php $estado_finalizado_srv_alcance_externo =  $srv['estado_id'] == 8 && $srv['estado_proceso'] == 6?>
                                                                <?php if ($show_btn_asignar && $estado_finalizado) : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-warning btnAsignarServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>"><i class="fa fa-user"></i> Asignar</button>
                                                                <?php endif; ?>
                                                                <?php if (($show_btn_programar && $estado_finalizado)||$estado_finalizado__cal_vlo_adi) : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-primary btnProgramarServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Programar</button>
                                                                <?php endif; ?>
                                                                <?php if ($show_btn_asistio && $estado_finalizado) : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-success btnAsistioServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i> Asistió</button>
                                                                <?php endif; ?>
                                                                <?php if ($show_btn_observacion && $estado_finalizado) : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-primary btnObservacionServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>"><i class="fa fa-commenting" aria-hidden="true"></i> Observaciones</button>
                                                                <?php endif; ?>
                                                                <?php if ($srv['tipo_servicio'] == 'M') : ?>
                                                                    <?php if ($show_btn_archivo && $estado_finalizado) : ?>
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-primary btnAgregarArchivoServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Subir Archivo</button>
                                                                    <?php endif; ?>
                                                                <?php endif;  ?>
                                                                <?php if ($srv['tipo_servicio'] == 'F' && !$estado_calidad_sin_provedor) : ?>
                                                                    <?php if (($show_btn_formato && ($estado_finalizado || ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 1 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 12 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 13))) || $estado_finalizado_sol || ($perfiles_sin_calidad_proveedor && $estado_finalizado_srv_alcance_externo)) : ?>
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-success btnIrAFormato" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" ruta="<?= $srv['ruta_reporte'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a Formato</button>
                                                                    <?php endif; ?>
                                                                <?php endif;  ?>
                                                                <?php if ($srv['tipo_servicio'] == 'F') : ?>
                                                                    <?php if ($show_btn_pdf || $estado_finalizado_sol) : ?>
                                                                        <!-- <a style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-danger btnIrPdf" href="../api/solicitud/imprimir-pdf?id_solicitud=<?= $solicitud['id_solicitud'] ?>&id_servicio=<?= $srv['id_servicio'] ?>" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a PDF</a>  -->
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-danger btnIrPdf" idServicio="<?= $srv['id_servicio'] ?>" rutaInforme="<?= $srv['reporte'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a PDF </button>
                                                                    <?php endif; ?>
                                                                <?php endif;  ?>
                                                                <?php if ($show_btn_notificacion && $estado_finalizado) : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-primary btnMensaje" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" concepto="<?= $srv['tipo_concepto'] ?>"><i class="fa fa-commenting-o" aria-hidden="true" title="Mensaje"></i> Mensaje</button>
                                                                <?php endif;  ?>

                                                                <?php if (($show_btn_valor_adicional && $estado_finalizado) || $estado_finalizado__cal_vlo_adi) : 
                                                                    if ($srv['valor_adicional'] == 'S') : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-warning btnValorAdicional" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" idSolicitud="<?= $srv['id_solicitud'] ?>" concepto="<?= $srv['tipo_concepto'] ?>"><i class="fa fa-usd" aria-hidden="true"></i> Valor Adicional</button>
                                                                    <?php endif;  ?>
                                                                <?php endif;  ?>

                                                                <?php if (((($show_btn_calificar)  && ($srv['calificado'] == 'N') && $estado_finalizado)) && $calificar_servicio) : ?>
                                                                    <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-warning btnCalificarServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" concepto="<?= $srv['tipo_concepto'] ?>"><i class="fa fa-check" aria-hidden="true"></i> Calificar</button>
                                                                <?php endif;  ?>

                                                                <?php if ($srv['calificado'] == 'S' || $condicion_manual) : ?>
                                                                    <?php if (($show_btn_finalizar && $estado_finalizado) || ($estado_finalizado_srv_alcance_externo && ($_SESSION[constant('APP_NAME')]['user']['perfil'] == 13 || $_SESSION[constant('APP_NAME')]['user']['perfil'] == 12))) : ?>
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-success btnFinalizarServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" concepto="<?= $srv['tipo_concepto'] ?>"><i class="fa fa-check" aria-hidden="true"></i> Finalizar</button>
                                                                    <?php endif;  ?>
                                                                <?php endif;  ?>
                                                                <?php if (($srv['estado_proceso'] == '1' || $srv['estado_proceso'] == '2' || $srv['estado_proceso'] == '3') && (!isset($srv['id_usuario_calidad'])|| $srv['id_usuario_calidad'] == "" )) : ?>
                                                                    <?php if ($show_btn_cancelar) : ?>
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-danger btnCancelarServicio" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" concepto="<?= $srv['tipo_concepto'] ?>"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                                                                    <?php endif;  ?>
                                                                <?php endif;  ?>
                                                                <?php if (($srv['estado_proceso'] == '2' || $srv['estado_proceso'] == '3' || $srv['estado_proceso'] == '4') && (!isset($srv['id_usuario_calidad'])|| $srv['id_usuario_calidad'] == "" )) : ?>
                                                                    <?php if ($show_btn_cancelar_asignacion) : ?>
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-primary btnCancelarAsignacion" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" concepto="<?= $srv['tipo_concepto'] ?>"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar Asignación</button>
                                                                    <?php endif;  ?>
                                                                <?php endif;  ?>

                                                                <?php if ($srv['tipo_servicio'] == 'F') : ?>
                                                                    <?php if ($show_btn_continuar_proceso && $estado_finalizado_srv && $srv['id_servicio'] == 1) : ?>
                                                                        <button style="margin-right: 10px; margin-top: 10px" class="btn btn-xs btn-success btnContinuarProceso" servicio="<?= $srv['nom_servicio'] ?>" idServicio="<?= $srv['id_servicio'] ?>" ruta="<?= $srv['ruta_reporte'] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Continuar Proceso</button>
                                                                    <?php endif; ?>
                                                                <?php endif;  ?>

                                                        <?php endif;  ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-xs-12 col-md-5">
                                            <h4>Historial de cambios</h4>
                                            <ul class="timeline">
                                                <?php foreach ($srv['timeline'] as $event) : ?>
                                                    <?php
                                                    // Check if the action is "Reasignación servicio" and profile is equal to 1
                                                    // Esto se hace para ocultar el item de reasignar para los perfiles de proveedor 10,11,15,16
                                                    $reasignar_oculto = $_SESSION[constant('APP_NAME')]['user']['perfil'];

                                                    $hideTimelineItem = ($event['accion'] === 'Reasignación servicio' && ($reasignar_oculto == 10 || $reasignar_oculto == 11 || $reasignar_oculto == 15 || $reasignar_oculto == 16 || $reasignar_oculto == 7 || $reasignar_oculto == 8 || $reasignar_oculto == 9));
                                                    ?>
                                                    <?php if (!$hideTimelineItem) : ?>
                                                        <li style="margin-bottom: 30px;">
                                                            <i class="fa fa-envelope bg-blue"></i>
                                                            <div class="timeline-item">
                                                                <span class="time"><i class="fa fa-user"></i> <?= $event['usuario'] ?></span>
                                                                <span class="time"><i class="fa fa-clock-o"></i> <?= $event['fch_create'] ?></span>
                                                                
                                                                <h3 class="timeline-header">
                                                                    <a href="#">
                                                                        <?php if ($event['accion'] === 'Cambio de Estado'): ?>
                                                                            <span style="font-size: 1.3em;">Cambio de Estado</span>
                                                                        <?php else: ?>
                                                                            <?= $event['accion'] ?>
                                                                        <?php endif; ?>
                                                                    </a>
                                                                </h3>

                                                                <?php if (isset($event['descripcion']) && $event['descripcion'] != '') : ?>
                                                                    <div class="timeline-body">
                                                                        <?php if ($event['accion'] === 'Asignación servicio' && ($reasignar_oculto == 10 || $reasignar_oculto == 11 || $reasignar_oculto == 15 || $reasignar_oculto == 16 || $reasignar_oculto == 7 || $reasignar_oculto == 8 || $reasignar_oculto == 9)): ?>
                                                                            Asignado: Asesor
                                                                        <?php else: ?>
                                                                            <?= str_replace("\n", '<br>', $event['descripcion']) ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <?php if (isset($event['observacion']) && $event['observacion'] != '' && $event['accion'] === 'Cambio de Estado') : ?>
                                                                    <div style="color: #337ab7; font-size: 1.3em; font-weight: bold;" class="timeline-body">
                                                                        <?= str_replace("\n", '<br>', $event['observacion']) ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <?php if ($show_btn_user_info) : ?>
                                                                    <div class="timeline-footer pull-right" style="color:gray; font-size: 10px;">
                                                                        <?= 'Id timeline: ' . $event['id_timeline'] . '; usuario: ' . $event['usr_create'] ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <li>
                                                    <i class="fa fa-clock-o bg-gray"></i>
                                                </li>
                                            </ul>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

<script src="<?= constant('APP_URL') ?>app/js/sol/solicitud.js?v=<?= time() ?>"></script>
<?php include 'vw.solicitud.edit.modal.php' ?>
<?php include 'vw.solicitud.archivos.modal.php' ?>
<?php include 'vw.solicitud.servicio.modal.php' ?>
<?php include 'vw.obs.calidad.edit.modal.php' ?>
<?php include 'vw.centro.costo.edit.modal.php' ?>
