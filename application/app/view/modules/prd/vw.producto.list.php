<section class="content-header">
    <h1>Productos</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Indicadores</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" id="div-box-clientes">

            <div class="box">

                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddProducto" data-toggle="modal" data-target="#modalAddProducto">
                        Agregar Producto
                    </button>
                </div>
                <div class="box-body">
                    <table id="tbl-productos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre Producto </th>
                                <th>Estado</th>
                                <th>Usuario Crea</th>
                                <th>Fecha Crea</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.producto.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/prd/producto.js"></script>