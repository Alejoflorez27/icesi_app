<section class="content-header">
    <h1>Cuentas Contables</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Cuentas Contables</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" id="div-box-clientes">

            <div class="box">

                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddCuenta" data-toggle="modal" data-target="#modalAddCuenta">
                        Agregar Cuenta Contable
                    </button>
                </div>
                <div class="box-body">
                    <table id="tbl-cuentas" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Item</th>
                                <th>Concepto</th>
                                <th>Combo</th>
                                <th>Ubicación Combo</th>
                                <th>Estado</th>
                                <th>Destino Cuenta</th>
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
<?php include 'vw.cuenta.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/cta/fac.cuentas.cont.js"></script>