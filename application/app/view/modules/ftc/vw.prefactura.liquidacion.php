<?php
// Se agrega validación para cuando se conecten los usuarios de las empresas y con esto validar los botones a mostrar
$usuario = CtrUsuario::getUsuarioApp();
$respuesta_usr = CtrUsuario::consultar($usuario);
$empresa = $respuesta_usr['id_empresa'];

$cliente = Result::getData(CtrTrcEmpresa::findById($router->param('id_empresa')));
$liquidacion = Result::getData(CtrFtFacturacion::findAllPendingByClient($router->param('id_empresa'), $router->param('id_factura')));

$total = array_reduce($liquidacion, function ($total, $item) {
    return $total + $item['valor'];
}, 0);

$cant_solicitudes = array_reduce($liquidacion, function ($total, $item) {
    return $total + sizeof($item['id_solicitud']);
}, 0);

$factura = Result::getData(CtrFtFacturacion::infoFactura($router->param('id_factura')));
$facturaArray = json_decode(json_encode($factura), true);
$estado = $facturaArray[0]['estado'];
$idFactura = $facturaArray[0]['id'];


$facturaDetalle = Result::getData(CtrFtFacturacionDetalle::findAllByFactura($router->param('id_factura')));

for ($i = 0; $i <= count($facturaDetalle); ++$i) {
    if ($facturaDetalle[$i]['estado'] == 1) {
        $solicitudesAprobadas = +$solicitudesAprobadas + 1;
    }
}

?>

<style>
    .btnLiquidar {
        cursor: pointer;
    }

    .li-servicio {
        list-style: none;
        margin-left: 0px;
    }

    .lu-servicio {
        list-style: none;
        padding-inline-start: 0px;
    }
</style>

<section class="content-header">
    <h1><?= $cliente['razon_social'] ?><small>Facturación Pendiente</small> </h1>
    <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Facturacion</li>
        <li class="active">Pendiente</li>
    </ol>
</section>

<section class="content">

    <div class="row">

        <div class="col-md-9">
            <div class="box">

                <div class="box-body">
                    <table id="tbl-solicitudesP" class="table table-bordered table-striped dt-responsive " width="100%">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" id="check-all" checked> Id</th>
                                <th>Cambiar Vlr</th>
                                <th>Fecha Solicitud</th>
                                <th>Nombre Candidato</th>
                                <th>Nro Identificación</th>
                                <th>Cargo</th>
                                <th>Vlr Solicitud</th>
                                <th>Vlr Adicional</th>
                                <th>Estado</th>
                                <th>Total</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($liquidacion as $l) : ?>
                                <tr>
                                    <td>
                                        <?php if (count($facturaDetalle) == 0) { ?>
                                            <ul class="lu-solicitud">
                                                <li class="li-servicio">
                                                    <input type="checkbox" class="item-solicitud item-solicitud-<?= $l['id_solicitud'] ?>" comboId="<?= $l['id_combo'] ?>" solicitudId="<?= $l['id_solicitud'] ?>" solicitudValor="<?= $l['valor_combo'] ?>" solicitudValorUnCheck="<?= $l['valor_combo_ckeck'] ?>" checked>
                                                </li>
                                            </ul>
                                        <?php } else { ?>
                                            <?php foreach ($facturaDetalle as $d) : ?>
                                                <?php if ($l['id_solicitud'] == $d['id_solicitud']) { ?>
                                                    <?php if (($d['estado'] == 1)) { ?>
                                                        <ul class="lu-solicitud">
                                                            <li class="li-servicio">
                                                                <input type="checkbox" class="item-solicitud item-solicitud-<?= $l['id_solicitud'] ?>" comboId="<?= $l['id_combo'] ?>" solicitudId="<?= $l['id_solicitud'] ?>" solicitudValor="<?= $l['valor_combo'] ?>" solicitudValorUnCheck="<?= $l['valor_combo_ckeck'] ?>" checked>
                                                            </li>
                                                        </ul>
                                    <td>
                                        <div class="input-group-btn">
                                            <button id="btnCambiarValor" name="btnCambiarValor" btn-xstype="button" class="btn btn-warning pull-left btn-xs ?>" idFactura="<?= $d['factura'] ?>" idSolicitud="<?= $d['id_solicitud'] ?> " disabled>Actualizar</button>
                                        </div>
                                    </td>
                                <?php } else { ?>
                                    <?php if (($d['estado'] == 0) || ($d['estado'] == 2)) { ?>
                                        <ul class="lu-solicitud">
                                            <li class="li-servicio">
                                                <input type="checkbox" class="item-solicitud item-solicitud-<?= $l['id_solicitud'] ?>" comboId="<?= $l['id_combo'] ?>" solicitudId="<?= $l['id_solicitud'] ?>" solicitudValor="<?= $l['valor_combo'] ?>" solicitudValorUnCheck="<?= $l['valor_combo_ckeck'] ?>" checked>
                                            </li>
                                        </ul>
                                        <td>
                                            <div class="input-group-btn">
                                                <button id="btnCambiarValor" name="btnCambiarValor" btn-xstype="button" class="btn btn-warning pull-left btn-xs ?>" idFactura="<?= $d['factura'] ?>" idSolicitud="<?= $d['id_solicitud'] ?> ">Actualizar</button>
                                            </div>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <div class="input-group-btn">
                                                <button id="btnCambiarValor" name="btnCambiarValor" btn-xstype="button" class="btn btn-warning pull-left btn-xs ?>" idFactura="<?= $d['factura'] ?>" idSolicitud="<?= $d['id_solicitud'] ?> " disabled>Actualizar</button>
                                            </div>
                                        </td>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php endforeach; ?>
                    <?php } ?>
                    </td>
                    <?php if (count($facturaDetalle) == 0) { ?>
                        <td>
                            <div class="input-group-btn">
                                <button id="btnCambiarValor" name="btnCambiarValor" btn-xstype="button" class="btn btn-warning pull-left btn-xs ?>" idFactura="<?= $d['factura'] ?>" idSolicitud="<?= $d['id_solicitud'] ?> " disabled>Actualizar</button>
                            </div>
                        </td>
                    <?php } ?>
                    <td><?= $l['fch_solicitud'] ?></td>
                    <td><?= $l['nombre_candidato'] ?></td>
                    <td><?= $l['numero_doc'] ?></td>
                    <td><?= $l['cargo_desempeno'] ?></td>
                    <td><?= "$ " . number_format($l['valor_solicitud']) ?></td>
                    <td><?= "$ " . number_format($l['valor_adicional']) ?></td>
                    <?php if ($estado != 0 || !isset($estado) == '' || $estado != "") { ?>
                        <?php foreach ($facturaDetalle as $d) : ?>
                            <?php if ($l['id_solicitud'] == $d['id_solicitud']) { ?>
                                <td><?= $d['des_estado'] ?></td>
                            <?php } ?>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <td><?= $l['desc_estado'] ?></td>
                    <?php } ?>
                    <td id="total-solicitud-<?= $l['id_solicitud'] ?>" style="text-align: right;">
                        <?= "$ " . number_format($l['valor_combo']) ?>
                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th colspan="9" style="text-align: right;">TOTAL</th>
                                <th id="total-factura" style="text-align: right;"><?= "$ " . number_format($total) ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Resumen de Facturación:</h3>
                </div>
                <div class="box-body">

                    <table class="table table-bordered dt-responsive" width="100%">
                        <tbody>
                            <tr>
                                <th>Cliente</th>
                                <td><?= $cliente['razon_social'] ?></td>
                            </tr>
                            <tr>
                                <th>No Identificación</th>
                                <td><?= $cliente['tipo_id'] . ". " . $cliente['numero_doc'] ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $cliente['email_emp']  ?></td>
                            </tr>
                            <?php if ($estado == -1 || $estado == 0 || isset($estado) == '' || $estado == "") { ?>
                                <tr>
                                    <th>Cant. Solicitudes</th>
                                    <td id="resumen-total-solicitudes"><?= $cant_solicitudes ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <th>Cant. Solicitudes</th>
                                    <td id="resumen-total-solicitudes"><?= $solicitudesAprobadas ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th>Total</th>
                                <th id="resumen-total-valor"> <?= "$" . number_format($total) ?> </th>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <!-- Usurio del Cliente -->
                    <?php if (isset($empresa) != '' || $empresa != "") { ?>
                        <?php if (($estado == 0)) { ?>
                            <div class="input-group-btn">
                                <button id="btnAprobar" type="button" class="btn btn-success pull-left">Aprobar</button>
                            </div>
                            <div class="input-group-btn">
                                <button id="btnRechazar" type="button" class="btn btn-danger pull-right">Rechazar</button>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <!-- Usurio Facturardor Prohumanos -->
                        <?php if ((isset($estado) == '' || $estado == "" || $estado == 0) && isset($idFactura) == '' || $idFactura == "" || $idFactura == 0) { ?>
                            <div class="input-group-btn">
                                <button id="btnPreFacturarR" type="button" class="btn btn-warning pull-left">Prefacturar</button>
                            </div>
                        <?php } ?>
                        <?php if (($estado == -1) ||  ($estado == 0)) { ?>
                            <!-- El botón es visible sólo cuando se está consultando una factura -->
                            <?php if ($idFactura != 0) { ?>
                                <?php if (isset($empresa) == '' || $empresa == "") { ?>
                                    <div class="input-group-btn">
                                        <button id="btnEnviarClienteR" type="button" class="btn btn-primary pull-left btn-sm">Enviar</button>
                                    </div>
                                <?php } ?>
                                <div class="input-group-btn">
                                    <button id="btnAprobarFacturador" type="button" class="btn btn-success pull-right btn-sm">Aprobar</button>
                                </div>

                                <div class="input-group-btn">
                                    <button id="btnRechazar" type="button" class="btn btn-danger pull-right btn-sm">Rechazar</button>
                                </div>

                                <div class="input-group-btn">
                                    <button id="btnVerDetalleR" type="button" class="btn btn-info pull-right btn-sm">Ver Detalle</button>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($estado == 1) { ?>
                                <div class="input-group-btn">
                                    <button id="btnFacturar" type="button" class="btn btn-success pull-left">Facturar</button>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.factura.detalle.modal.php' ?>
<?php include 'vw.factura.actualizar.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ftc/facturacion.js"></script>