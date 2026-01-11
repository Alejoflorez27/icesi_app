<?php

$proveedor = CtrUsuario::consultar($router->param('proveedor'));
$liquidacion = Result::getData(CtrFtFacturacion::findAllPendingByProveedor($router->param('proveedor'), $router->param('factura')));

$total = array_reduce($liquidacion, function ($total, $item) {
    return $total + $item['valor_total'];
}, 0);

$cant_servicios = array_reduce($liquidacion, function ($total, $item) {
    return $total + sizeof($item['id']);
}, 0);

$factura = Result::getData(CtrFtFacturacion::infoFactura($router->param('factura')));
$facturaArray = json_decode(json_encode($factura), true);
$estado = $facturaArray[0]['estado'];
$idFactura = $facturaArray[0]['id'];

$facturaDetalle = Result::getData(CtrFtFacturacionDetalle::findAllByFactura($router->param('factura')));

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
    <h1><?= $proveedor['nombres'] ?> <?= $proveedor['apellidos'] ?><small>Facturación Pendiente Proveedor</small> </h1>
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
                                <th>Fecha Servicio</th>
                                <th>Solicitud</th>
                                <th>Identificación</th>
                                <th>Servicio</th>
                                <th>Vlr Servicio</th>
                                <th>Vlr Adicional</th>
                                <th>Observación</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($liquidacion as $l) : ?>
                                <tr>
                                    <td>
                                        <?php if (count($facturaDetalle) == 0) { ?>
                                            <ul class="lu-servicio">
                                                <li class="li-servicio">
                                                    <input type="checkbox" class="item-servicio item-servicio-<?= $l['id'] ?>" id="<?= $l['id'] ?>" servicioValor="<?= $l['valor_total'] ?>" servicioValorUnCheck="<?= $l['valor_combo_ckeck'] ?>" checked>
                                                </li>
                                            </ul>
                                        <?php } else { ?>
                                            <?php foreach ($facturaDetalle as $d) : ?>
                                                <?php if ($l['id_solicitud'] == $d['id_solicitud']   && $l['id_servicio'] == $d['id_servicio'] ) { ?>
                                                    <?php if (($d['estado'] == 0)) { ?>
                                                        <ul class="lu-solicitud">
                                                            <li class="li-servicio">
                                                                <input type="checkbox" class="item-servicio item-servicio-<?= $l['id'] ?>" id="<?= $l['id'] ?>" servicioValor="<?= $l['valor_total'] ?>" solicitudValor="<?= $l['valor_combo'] ?>" solicitudValorUnCheck="<?= $l['valor_combo_ckeck'] ?>" checked>
                                                            </li>
                                                        </ul>
                                    <td>
                                        <div class="input-group-btn">
                                            <button id="btnCambiarValor" name="btnCambiarValor" btn-xstype="button" class="btn btn-warning pull-left btn-xs ?>" idFactura="<?= $d['factura'] ?>" idServicio="<?= $d['id_servicio'] ?>" idSolicitud="<?= $d['id_solicitud'] ?>">Actualizar</button>
                                        </div>
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        <?php endforeach; ?>
                    <?php } ?>
                    </td>
                    <?php if (count($facturaDetalle) == 0) { ?>
                        <td>
                            <div class="input-group-btn">
                                <button id="btnCambiarValor" name="btnCambiarValor" btn-xstype="button" class="btn btn-warning pull-left btn-xs ?>" id="<?= $l['id'] ?>" idFactura="<?= $d['factura'] ?>" disabled>Actualizar</button>
                            </div>
                        </td>
                    <?php } ?>
                    <td><?= $l['fecha_servicio'] ?></td>
                    <td><?= "# " . $l['id_solicitud'] ?></td>
                    <td><?= $l['doc_candidato'] ?></td>
                    <td><?= $l['nom_servicio'] ?></td>
                    <td><?= "$ " . number_format($l['valor_servicio']) ?></td>
                    <td><?= "$ " . number_format($l['valor_serv_adicional']) ?></td>
                    <td><?= $l['observacion'] ?></td>
                    <td id="total-solicitud-<?= $l['id_servicio'] ?>" style="text-align: right;">
                        <?= "$ " . number_format($l['valor_total']) ?> </td>
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
                                <th>Proveedor</th>
                                <td><?= $proveedor['nombres'] . " " . $proveedor['apellidos'] ?></td>
                            </tr>
                            <tr>
                                <th>No Identificación</th>
                                <td><?= $proveedor['tipo_identificacion'] . ". " . $proveedor['numero_identificacion'] ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $proveedor['email']  ?></td>
                            </tr>
                            <tr>
                                <th>Cant. Servicios</th>
                                <td id="resumen-total-servicios"><?= $cant_servicios ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th id="resumen-total-valor"> <?= "$" . number_format($total) ?> </th>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <!-- Usurio Facturardor Prohumanos -->
                    <?php if (isset($estado) == '' || $estado == "") { ?>
                        <div class="input-group-btn">
                            <button id="btnPreFacturarP" type="button" class="btn btn-warning pull-left">Prefacturar</button>
                        </div>
                    <?php } else { ?>
                        <?php if ($estado == 0) { ?>
                            <div class="input-group-btn">
                                <button id="btnFacturarP" type="button" class="btn btn-success pull-left">Facturar</button>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.facturap.actualizar.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ftcprv/facturacionp.js"></script>