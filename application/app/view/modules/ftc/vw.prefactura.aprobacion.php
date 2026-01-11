<?php
$cliente = Result::getData(CtrTrcEmpresa::findById($router->param('id_empresa')));
$liquidacion = Result::getData(CtrFtFacturacion::findAllPendingByClient($router->param('id_empresa')));
$total = array_reduce($liquidacion, function ($total, $item) {
    return $total + $item['valor'];
}, 0);
$cant_solicitudes = array_reduce($liquidacion, function ($total, $item) {
    return $total + sizeof($item['id_solicitud']);
}, 0);
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
    <h1><?= $cliente['nombre_completo'] ?><small>Facturación Pendiente</small> </h1>
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
                    <table id="tbl-solicitudes" class="table table-bordered table-striped dt-responsive " width="100%">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" id="check-all" checked> Id</th>
                                <th>Fecha Solicitud</th>
                                <th>Nombre Candidato</th>
                                <th>Número Identificación</th>
                                <th>Cargo</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($liquidacion as $l) : ?>
                                <tr>
                                    <td>
                                        <ul class="lu-solicitud">
                                            <li class="li-servicio">
                                                <input type="checkbox" class="item-solicitud item-solicitud-<?= $l['id_solicitud'] ?>" comboId="<?= $l['id_combo'] ?>" 
                                                solicitudId="<?= $l['id_solicitud'] ?>" solicitudValor="<?= $l['valor_combo'] ?>" checked >
                                            </li>
                                        </ul>
                                    </td>
                                    <td><?= $l['fch_solicitud'] ?></td>
                                    <td><?= $l['nombre_candidato'] ?></td>
                                    <td><?= $l['numero_doc'] ?></td>
                                    <td><?= $l['cargo_desempeno'] ?></td>

                                    <td id="total-solicitud-<?= $l['id_solicitud'] ?>" style="text-align: right;">
                                        <?= "$ " . number_format($l['valor_combo']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th colspan="5" style="text-align: right;">TOTAL</th>
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
                            <tr>
                                <th>Cant. Solicitudes</th>
                                <td id="resumen-total-solicitudes"><?= $cant_solicitudes ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th id="resumen-total-valor"> <?= "$" . number_format($total) ?> </th>
                            </tr>
                        </tbody>
                    </table>


                    <div class="input-group-btn">
                        <button id="btnFacturar" type="button" class="btn btn-primary pull-right">Prefacturar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= constant('APP_URL') ?>app/js/ftc/facturacion.js"></script>