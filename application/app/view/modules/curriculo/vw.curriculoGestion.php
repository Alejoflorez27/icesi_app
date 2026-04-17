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
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-cursos">0</h3>
                    <p>Cursos</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
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
                    <i class="fa fa-star"></i>
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
                    <i class="fa fa-target"></i>
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
                    <i class="fa fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_cursos" data-toggle="tab">Cursos</a></li>
            <li><a href="#tab_competencias" data-toggle="tab">Competencias</a></li>
            <li><a href="#tab_objetivos" data-toggle="tab">Objetivos</a></li>
            <li><a href="#tab_analisis" data-toggle="tab">Análisis</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="tab_cursos">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gestión de Cursos</h3>
                        <button class="btn btn-primary pull-right btnAddCurso" type="button">
                            <i class="fa fa-plus"></i> Agregar Curso
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Programa:</label>
                                <select id="filtro-programa" class="form-control">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Competencia:</label>
                                <select id="filtro-competencia" class="form-control">
                                    <option value="">Todas</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Objetivo:</label>
                                <select id="filtro-objetivo" class="form-control">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Nivel:</label>
                                <select id="filtro-nivel" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="I">I</option>
                                    <option value="F">F</option>
                                    <option value="V">V</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <button class="btn btn-default form-control" id="btn-limpiar-filtros" type="button">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                        <br>

                        <table id="tbl-cursos" class="table table-striped dt-responsive tablas table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Programa</th>
                                    <th>Créditos</th>
                                    <th>Competencias</th>
                                    <th>Objetivos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-cursos"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tab_competencias">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gestión de Competencias</h3>
                        <button class="btn btn-primary pull-right btnAddCompetencia" type="button">
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

            <div class="tab-pane" id="tab_objetivos">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gestión de Objetivos</h3>
                        <button class="btn btn-primary pull-right btnAddObjetivo" type="button">
                            <i class="fa fa-plus"></i> Agregar Objetivo
                        </button>
                    </div>
                    <div class="box-body">
                        <table id="tbl-objetivos" class="table table-striped dt-responsive tablas table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Competencia</th>
                                    <th>Descripción</th>
                                    <th>Cursos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-objetivos"></tbody>
                        </table>
                    </div>
                </div>
            </div>

<div class="tab-pane" id="tab_analisis">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Análisis de Cobertura Curricular</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <h4>Objetivos sin asignar</h4>

                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-4">
                            <div class="small-box bg-aqua" style="margin-bottom: 0;">
                                <div class="inner">
                                    <h4 id="total-objetivos-analisis">0</h4>
                                    <p>Total</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="small-box bg-yellow" style="margin-bottom: 0;">
                                <div class="inner">
                                    <h4 id="objetivos-sin-asignar-analisis">0</h4>
                                    <p>Sin asignar</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="small-box bg-orange" style="margin-bottom: 0;">
                                <div class="inner">
                                    <h4 id="porcentaje-objetivos-sin">0%</h4>
                                    <p>Porcentaje</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="max-width: 280px; margin: 0 auto;">
                        <canvas id="grafico-objetivos" height="200"></canvas>
                    </div>
                </div>

                <div class="col-md-6 text-center">
                    <h4>Competencias sin objetivos</h4>

                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-4">
                            <div class="small-box bg-blue" style="margin-bottom: 0;">
                                <div class="inner">
                                    <h4 id="total-competencias-analisis">0</h4>
                                    <p>Total</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="small-box bg-red" style="margin-bottom: 0;">
                                <div class="inner">
                                    <h4 id="competencias-sin-objetivos-analisis">0</h4>
                                    <p>Sin objetivos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="small-box bg-maroon" style="margin-bottom: 0;">
                                <div class="inner">
                                    <h4 id="porcentaje-competencias-sin">0%</h4>
                                    <p>Porcentaje</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="max-width: 280px; margin: 0 auto;">
                        <canvas id="grafico-competencias" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</section>

<div class="modal fade" id="modalCurso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title" id="modalCursoTitle">Agregar Curso</h4>
            </div>
            <form id="formCurso">
                <input type="hidden" id="curso-id">
                <input type="hidden" id="accionCurso" value="crear">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Programa:</label>
                        <select id="curso-programa" class="form-control" required>
                            <option value="">Selecciona un programa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre del Curso:</label>
                        <input type="text" id="curso-nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Código:</label>
                        <input type="text" id="curso-codigo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Créditos:</label>
                        <input type="number" id="curso-creditos" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea id="curso-descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-curso">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCompetencia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title" id="modalCompetenciaTitle">Agregar Competencia</h4>
            </div>
            <form id="formCompetencia">
                <input type="hidden" id="competencia-id">
                <input type="hidden" id="accionCompetencia" value="crear">

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
                    <button type="button" class="btn btn-primary" id="btn-submit-competencia">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalObjetivo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title" id="modalObjetivoTitle">Agregar Objetivo</h4>
            </div>
            <form id="formObjetivo">
                <input type="hidden" id="objetivo-id">
                <input type="hidden" id="accionObjetivo" value="crear">

                <div class="modal-body">
                    <div class="form-group">
                        <label>Competencia:</label>
                        <select id="objetivo-competencia" class="form-control" required>
                            <option value="">Seleccione una competencia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" id="objetivo-nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea id="objetivo-descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-submit-objetivo">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCursoObjetivo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title">Objetivos del Curso</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="curso-objetivo-id-curso">

                <div class="row">
                    <div class="col-md-6">
                        <label>Objetivo:</label>
                        <select id="curso-objetivo-id-objetivo" class="form-control"></select>
                    </div>
                    <div class="col-md-3">
                        <label>Nivel:</label>
                        <select id="curso-objetivo-nivel" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="I">I</option>
                            <option value="F">F</option>
                            <option value="V">V</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-primary form-control" id="btn-agregar-objetivo-curso">
                            Agregar
                        </button>
                    </div>
                </div>

                <br>

                <table id="tbl-curso-objetivo" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Objetivo</th>
                            <th>Competencia</th>
                            <th>Nivel</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="<?= constant('APP_URL') ?>app/js/curriculoGestion.js"></script>
