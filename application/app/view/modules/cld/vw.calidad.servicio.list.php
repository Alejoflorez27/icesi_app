<section class="content-header">
    <h1>Servicios por Asignar a Calidad</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Servicios en Calidad</li>
        <li class="active">Lista</li>
    </ol>
</section>



<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Solicitudes con Servicios en Calidad</h3>
                </div>
                <div class="box-body">
                    <table id="tbl-servicios-calidad" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>ID Solicitud</th>
                                <th>Combo</th>
                                <th>Cliente</th>
                                <th>Candidato</th>
                                <th>Documento</th>
                                <th>Calidad</th>
                                <th>Total Servicios en Calidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'vw.calidad.servicio.modal.php' ?>
<?php include 'vw.calidad.servicios.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/srv/servicios_calidad.js"></script>