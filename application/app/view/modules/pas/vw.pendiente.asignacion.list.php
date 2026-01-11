<section class="content-header">
    <h1>Servicios Pendientes por Asignar</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Servicios Pendientes</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box">
                    <div class="box-header with-border">
                        <button class="btn btn-success btnAsignarServicio" data-toggle="modal" data-target="#modalAsigSrv"><i class="fa fa-check"  aria-hidden="true"></i>
                            Asignar
                        </button>
                    </div>
                <div class="box-body">
                    <table id="tbl-servicios-calidad" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cliente</th>
                                <th>Candidato</th>
                                <th>Documento</th>
                                <th>Nom Servicio</th>
                                <th>Estado</th>
                                <th>Estado Proceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.pendiente.asignacion.modal.php' ?>
<script src="<?= constant('APP_URL') ?>app/js/srv/servicios_asignacion.js"></script>