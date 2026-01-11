<section class="content-header">
    <h1>Facturas Realizadas</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Pendiente Aprobar</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" >
        <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Filtros:</h4>
                </div>
                <div class="box-body">

                    <!-- <br> -->
                    <div class="form-group col-md-3">
                        <label for="filter_cliente">Tipo Factura:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-filter"></i></span>
                            <select name="filter_tipo_factura" id="filter_tipo_factura" class="form-control select2">
                                <option value="">Todos</option>
                                <option value="C">Cliente</option>
                                <option value="P">Proveedor</option>
                            </select>
                        </div>
                    </div>
                    <!-- <br> -->

                    <div class="form-group col-md-3">
                        <label for="filter_cliente">Cliente:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <select name="filter_cliente" id="filter_cliente" class="form-control select2">
                                <option value="">Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group col-md-1">
                        <label>Buscar:</label>
                        <div class="input-group">
                            <button id="btnBuscar" type="button" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <table id="tbl-facturas" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cliente</th>
                                <th>Fecha Facturación </th>
                                <th>Fecha Vencimiento</th>
                                <th>Valor Neto</th>
                                <th>Motivo Aprobación</th>
                                <th>Número Contable</th>
                                <th>Destino Factura</th>
                                <th>Estado</th>
                                <th>Ver Detalle</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.factura.detalle.modal.php' ?>
<?php include 'vw.factura.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/ftc/facturas.js"></script>