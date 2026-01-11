<section class="content-header">
    <h1>Servicios Pendientes por Facturar a Proveedores</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Pendiente Facturar</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Filtros:</h4>
                </div>
                <div class="box-body">
                    <div class="form-group col-md-3">
                        <label for="filter_cliente">Proveedor:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                            <select name="filter_proveedor" id="filter_proveedor" class="form-control select2">
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
        </div>
        <div class="col-md-12" id="div-box-srvXFacturarP">
            <div class="box">
                <div class="box-body">
                    <table id="tbl-srvXFacturarP" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Tipo Documento </th>
                                <th>Número Documento</th>
                                <th>Nombre</th>
                                <th>Cantidad por Facturar</th>
                                <th>Valor por Facturar</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= constant('APP_URL') ?>app/js/ftcprv/facturacionp.js"></script>