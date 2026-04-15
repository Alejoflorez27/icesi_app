<?php
/**
 * Vista Principal: Gestión Curricular
 * Ubicación: application/app/view/modules/curriculo/vw.curriculoGestion.php
 */
?>

<section class="content-header">
    <h1>Gestión Curricular</h1>
    <ol class="breadcrumb">
        <li><a href="../inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Gestión Curricular</li>
    </ol>
</section>

<section class="content">
    <!-- Tarjetas de Estadísticas -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-cursos">0</h3>
                    <p>Cursos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="total-competencias">0</h3>
                    <p>Competencias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="total-objetivos">0</h3>
                    <p>Objetivos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-target"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="total-programas">0</h3>
                    <p>Programas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs de Gestión -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_cursos" data-toggle="tab">Cursos</a></li>
            <li><a href="#tab_competencias" data-toggle="tab">Competencias</a></li>
            <li><a href="#tab_objetivos" data-toggle="tab">Objetivos</a></li>
            <li><a href="#tab_analisis" data-toggle="tab">Análisis</a></li>
        </ul>

        <div class="tab-content">
            <!-- TAB: CURSOS -->
            <div class="tab-pane active" id="tab_cursos">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gestión de Cursos</h3>
                        <button class="btn btn-primary pull-right" id="btnAddCurso" data-toggle="modal" data-target="#modalCurso">
                            <i class="fa fa-plus"></i> Agregar Curso
                        </button>
                    </div>
                    <div class="box-body">
                        <!-- Filtros -->
                        <div class="row">
                            <div class="col-md-3">
                                <label>Programa:</label>
                                <select id="filtro-programa-cursos" class="form-control">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Competencia:</label>
                                <select id="filtro-competencia-cursos" class="form-control">
                                    <option value="">Todas</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button class="btn btn-default form-control" id="btnLimpiarFiltros">
                                    <i class="fa fa-refresh"></i> Limpiar
                                </button>
                            </div>
                        </div>
                        <br>
                        <!-- Tabla de cursos -->
                        <table id="tbl-cursos" class="table table-striped dt-responsive tablas table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Programa</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-cursos"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB: COMPETENCIAS -->
            <div class="tab-pane" id="tab_competencias">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gestión de Competencias</h3>
                        <button class="btn btn-primary pull-right" id="btnAddCompetencia" data-toggle="modal" data-target="#modalCompetencia">
                            <i class="fa fa-plus"></i> Agregar Competencia
                        </button>
                    </div>
                    <div class="box-body">
                        <table id="tbl-competencias" class="table table-striped dt-responsive tablas table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Objetivos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-competencias"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB: OBJETIVOS -->
            <div class="tab-pane" id="tab_objetivos">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gestión de Objetivos</h3>
                        <button class="btn btn-primary pull-right" id="btnAddObjetivo" data-toggle="modal" data-target="#modalObjetivo">
                            <i class="fa fa-plus"></i> Agregar Objetivo
                        </button>
                    </div>
                    <div class="box-body">
                        <table id="tbl-objetivos" class="table table-striped dt-responsive tablas table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Nivel</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-objetivos"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB: ANÁLISIS -->
            <div class="tab-pane" id="tab_analisis">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Análisis de Cobertura Curricular</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Distribución de Cursos por Programa</h4>
                                <canvas id="chart-cursos"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h4>Cobertura de Objetivos</h4>
                                <canvas id="chart-objetivos"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODALES -->
<!-- Modal: Agregar/Editar Curso -->
<div class="modal fade" id="modalCurso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title" id="modalCursoTitle">Agregar Curso</h4>
            </div>
            <form id="formCurso">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Curso:</label>
                        <input type="text" id="curso-nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Programa:</label>
                        <select id="curso-programa" class="form-control" required>
                            <option value="">Selecciona un programa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea id="curso-descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Agregar/Editar Competencia -->
<div class="modal fade" id="modalCompetencia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title" id="modalCompetenciaTitle">Agregar Competencia</h4>
            </div>
            <form id="formCompetencia">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" id="competencia-nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea id="competencia-descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Agregar/Editar Objetivo -->
<div class="modal fade" id="modalObjetivo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title" id="modalObjetivoTitle">Agregar Objetivo</h4>
            </div>
            <form id="formObjetivo">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" id="objetivo-nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nivel (I/F/V):</label>
                        <select id="objetivo-nivel" class="form-control" required>
                            <option value="">Selecciona nivel</option>
                            <option value="I">I - Introducción</option>
                            <option value="F">F - Fundamentación</option>
                            <option value="V">V - Profundización</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea id="objetivo-descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LibrerÍas -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="<?= constant('APP_URL') ?>app/js/curriculoGestion.js"></script>
