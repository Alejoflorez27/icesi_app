<section class="content-header">
    <h1>Servicios Finalizados</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Indicadores</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <input type="hidden" id="accion" name="accion" value="">
                    <input type="hidden" id="username" name="username" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']?>">
                    <input type="hidden" id="perfil" name="perfil" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil']?>">
                    <table id="tbl-srvfin" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Id Serv</th>
                                <th>Solicitud</th>
                                <th>Cliente</th>
                                <th>Candidato</th>
                                <th>Nro. documento</th>
                                <th>Servicio</th>
                                <th>Responsable</th>
                                <th>Asesor</th>
                                <th>Calidad</th>
                                <th>observación</th>
                                <th>Fch Asig</th>
                                <th>Fch Fin</th>
                                <th>Días atención</th>
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
<script src="<?= constant('APP_URL') ?>app/js/srv/servicios.finalizados.js"></script>