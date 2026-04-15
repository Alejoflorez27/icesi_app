<?php
/**
 * Vista: Gestión Curricular
 */
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión Curricular</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión Curricular</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner"><h3 id="total-cursos">0</h3><p>Cursos</p></div>
                    <div class="icon"><i class="fa fa-book"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner"><h3 id="total-competencias">0</h3><p>Competencias</p></div>
                    <div class="icon"><i class="fa fa-star"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner"><h3 id="total-objetivos">0</h3><p>Objetivos</p></div>
                    <div class="icon"><i class="fa fa-target"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner"><h3 id="total-programas">0</h3><p>Programas</p></div>
                    <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#tab-cursos" data-toggle="pill">Cursos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab-competencias" data-toggle="pill">Competencias</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab-objetivos" data-toggle="pill">Objetivos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab-analisis" data-toggle="pill">Análisis</a></li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-cursos">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Listado de cursos y su mapeo curricular</h3>
                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" onclick="mostrarModalCurso()"><i class="fa fa-plus"></i> Nuevo Curso</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Programa</label>
                                        <select id="filtro-programa" class="form-control" onchange="filtrarCursos()">
                                            <option value="">Todos</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Competencia</label>
                                        <select id="filtro-competencia" class="form-control" onchange="filtrarCursos()">
                                            <option value="">Todas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Objetivo</label>
                                        <select id="filtro-objetivo" class="form-control" onchange="filtrarCursos()">
                                            <option value="">Todos</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Nivel</label>
                                        <select id="filtro-nivel" class="form-control" onchange="filtrarCursos()">
                                            <option value="">Todos</option>
                                            <option value="I">I - Introduce</option>
                                            <option value="F">F - Fortalece</option>
                                            <option value="V">V - Valora</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button class="btn btn-secondary" onclick="limpiarFiltros()">Limpiar</button>
                                    </div>
                                </div>

                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Curso</th>
                                            <th>Programa</th>
                                            <th>Competencias</th>
                                            <th>Objetivos</th>
                                            <th>Nivel (I/F/V)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-cursos"><tr><td colspan="7" class="text-center">Cargando...</td></tr></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-competencias">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Gestión de Competencias</h3>
                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" onclick="mostrarModalCompetencia()"><i class="fa fa-plus"></i> Nueva Competencia</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead><tr><th>Nombre</th><th>Descripción</th><th>Total objetivos</th><th>Acciones</th></tr></thead>
                                    <tbody id="tabla-competencias"><tr><td colspan="4" class="text-center">Cargando...</td></tr></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-objetivos">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Gestión de Objetivos</h3>
                                <div class="card-tools">
                                    <button class="btn btn-primary btn-sm" onclick="mostrarModalObjetivo()"><i class="fa fa-plus"></i> Nuevo Objetivo</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead><tr><th>Nombre</th><th>Competencia</th><th>Descripción</th><th>Total cursos</th><th>Acciones</th></tr></thead>
                                    <tbody id="tabla-objetivos"><tr><td colspan="5" class="text-center">Cargando...</td></tr></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-analisis">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header"><h3 class="card-title">% Objetivos sin asignar</h3></div>
                                    <div class="card-body"><canvas id="grafico-objetivos"></canvas></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header"><h3 class="card-title">% Competencias sin objetivos</h3></div>
                                    <div class="card-body"><canvas id="grafico-competencias"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalCurso" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-curso">Nuevo Curso</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formCurso">
                    <input type="hidden" id="curso-id" />
                    <div class="form-group"><label>Programa</label><select id="curso-programa" class="form-control" required></select></div>
                    <div class="form-group"><label>Nombre</label><input type="text" id="curso-nombre" class="form-control" required /></div>
                    <div class="form-group"><label>Código</label><input type="text" id="curso-codigo" class="form-control" required /></div>
                    <div class="form-group"><label>Descripción</label><textarea id="curso-descripcion" class="form-control" rows="3"></textarea></div>
                    <div class="form-group"><label>Créditos</label><input type="number" id="curso-creditos" class="form-control" min="0" /></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCurso()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCompetencia" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-competencia">Nueva Competencia</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formCompetencia">
                    <input type="hidden" id="competencia-id" />
                    <div class="form-group"><label>Nombre</label><input type="text" id="competencia-nombre" class="form-control" required /></div>
                    <div class="form-group"><label>Descripción</label><textarea id="competencia-descripcion" class="form-control" rows="4"></textarea></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCompetencia()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalObjetivo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-objetivo">Nuevo Objetivo</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formObjetivo">
                    <input type="hidden" id="objetivo-id" />
                    <div class="form-group"><label>Competencia</label><select id="objetivo-competencia" class="form-control" required></select></div>
                    <div class="form-group"><label>Nombre</label><input type="text" id="objetivo-nombre" class="form-control" required /></div>
                    <div class="form-group"><label>Descripción</label><textarea id="objetivo-descripcion" class="form-control" rows="4"></textarea></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarObjetivo()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?=constant('APP_URL')?>/app/js/curriculoGestion.js"></script>
