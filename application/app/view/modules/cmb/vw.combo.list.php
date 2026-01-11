<section class="content-header">
    <h1>Combos</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Combos</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" id="div-box-combos">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-primary btnAddCombo" data-toggle="modal" data-target="#modalAddCombo">
                        Agregar Combo
                    </button>
                </div>
                <div class="box-body">
                    <table id="tbl-combos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th style="width:10px">Id</th>
                                <th>Nombre</th>
                                <th>Valor Bogotá</th>
                                <th>SLA Bogotá</th>
                                <th>Valor Fuera Bogotá</th>
                                <th>SLA Fuera Bogotá</th>
                                <th>Envía Correo</th>
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
        <div class="div-servicios">
            <div class="col-md-2">
                <input type="hidden" id="idCombo">
                <div class="box">
                    <div class="box-body">
                        <table id="tbl-servicios" class="table table-bordered table-striped " width="100%">
                            <thead>
                                <tr>
                                    <td colspan="2">Servicios Dispobibles</td>
                                </tr>
                                <tr>
                                    <th colspan="2" id="servicio-desc"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl-servicios-combo"> </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.combo.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/cmb/combo.js"></script> 