<section class="content-header">
    <h1>Calificación Proveedores</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Calificación Proveedores</li>
        <li class="active">Lista</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Filtros:</h4>
                </div>
                <div class="box-body">
                    <div class="form-group div-fechas col-md-5">
                        <label for="fecha_desde">Fecha:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="me-edit-info form-control input-sm" id="filter_fecha_rango" name="filter_fecha_rango" placeholder="Fecha de solicitud" autocomplete="off" readonly>

                            <input type="hidden" name="filter_fecha_desde" id="filter_fecha_desde" class="form-control" value="">
                            <input type="hidden" name="filter_fecha_hasta" id="filter_fecha_hasta" class="form-control" value="">
                            <input type="hidden" id="accion_candidato" name="accion_candidato" value="<?= $_SESSION[constant('APP_NAME')]['user']['username']?>">
                            <input type="hidden" id="accion_perfil" name="accion_perfil" value="<?= $_SESSION[constant('APP_NAME')]['user']['perfil']?>">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="filter_cliente">Proveedor:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                            <select name="filter_proveedor" id="filter_proveedor" class="form-control select2" disabled>
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

        <div class="col-md-6" style="display: flex; justify-content: center;">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gráfica de Servicios Calificados Según Fecha</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div id="chart-container">
                        <canvas id="graficoServiciosCalificadosApilado" width="200" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" style="display: flex; justify-content: center;">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gráfica por Preguntas de Servicios Calificados Según Fecha</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <!-- Gráfico de pastel para Pregunta 1 -->
                    <div class="row">
                        <div class="col-md-6" style="display: flex; justify-content: center;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <h3>Gráfico de Pregunta 1</h3>
                                <canvas id="graficoPregunta1Pastel" width="200" height="100"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: flex; justify-content: center;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <h3>Gráfico de Pregunta 2</h3>
                                <canvas id="graficoPregunta2Pastel" width="200" height="100"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: flex; justify-content: center;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <h3>Gráfico de Pregunta 3</h3>
                                <canvas id="graficoPregunta3Pastel" width="200" height="100"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: flex; justify-content: center;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <h3>Gráfico de Pregunta 4</h3>
                                <canvas id="graficoPregunta4Pastel" width="200" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">

            <div class="box box-primary">

                <div class="box-body">
                    <table id="tbl-servicios-calificados" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                        <thead>
                            <tr>
                                <th>Fecha Entrega</th>
                                <th>Servicio</th>
                                <th>Cliente</th>
                                <th>Candidato</th>
                                <th>Documento</th>
                                <th>Estado</th>
                                <th>Oportunidad y entrega del servicio</th>
                                <th>Calidad y contenido de la información diligenciada</th>
                                <th>Calidad de la documentación anexada</th>
                                <th>Actitud y compromiso con el servicio</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'vw.calidad.calificacion.modal.php' ?>

<!-- Script para el archivo servicios_calificados.js -->
<script src="<?= constant('APP_URL') ?>app/js/srv/servicios_calificados.js"></script>
