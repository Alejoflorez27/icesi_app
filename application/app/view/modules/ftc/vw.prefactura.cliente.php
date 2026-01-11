<section class="content-header">
    <h1>Prefacturas Pendientes por Aprobar</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Pendiente Aprobar</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" id="div-box-clientes">
            <div class="box">
                <div class="box-body">
                    <table id="tbl-preFacturas" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id Factura</th>
                                <th>Cliente</th>
                                <th>Fecha Facturación </th>
                                <th>Fecha Vencimiento</th>
                                <th>Valor Neto</th>
                                <th>Estado</th>
                                <th>Días sin Aprobación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/ftc/facturacion.cliente.js"></script>