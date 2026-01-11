<section class="content-header">
    <h1>Combos Clientes</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Combos</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddComboCliente" data-toggle="modal" data-target="#modalAddComboCliente">
                        Agregar Combo Cliente
                    </button>
                </div>
                <div class="box-body">
                    <table id="tbl-combosCli" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th style="width:10px">Id</th>
                                <th>Empresa</th>
                                <th>Combo Servicio</th>
                                <th>Valor Bogotá</th>
                                <th>Valor Externo</th>
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
<?php include 'vw.comboCliente.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/cmbcli/trc.combo.cli.js?v=<?= time() ?>"></script>