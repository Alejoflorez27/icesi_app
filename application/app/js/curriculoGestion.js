let chartObjetivos = null;
let chartCompetencias = null;

$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    cargarDashboard();
    cargarFiltrosCurriculo();
    cargarTablaCursos();
    cargarTablaCompetencias();
    cargarTablaObjetivos();
    cargarAnalisis();

    $('#filtro-programa, #filtro-competencia, #filtro-objetivo, #filtro-nivel').on('change', function () {
        cargarTablaCursos();
    });

    $('#btn-limpiar-filtros').on('click', function () {
        $('#filtro-programa').val('');
        $('#filtro-competencia').val('');
        $('#filtro-objetivo').val('');
        $('#filtro-nivel').val('');
        cargarTablaCursos();
    });

    $('.btnAddCurso').on('click', function () {
        $('#formCurso')[0].reset();
        $('#curso-id').val('');
        $('#accionCurso').val('crear');
        $('#modalCurso').modal();
    });

    $('.btnAddCompetencia').on('click', function () {
        $('#formCompetencia')[0].reset();
        $('#competencia-id').val('');
        $('#accionCompetencia').val('crear');
        $('#modalCompetencia').modal();
    });

    $('.btnAddObjetivo').on('click', function () {
        $('#formObjetivo')[0].reset();
        $('#objetivo-id').val('');
        $('#accionObjetivo').val('crear');
        $('#modalObjetivo').modal();
    });

    $('#btn-submit-curso').on('click', function (e) {
        e.preventDefault();

        if (validateFormCurso()) {
            let accion = $('#accionCurso').val();
            let data = {
                id_curso: $('#curso-id').val(),
                id_programa: $('#curso-programa').val(),
                nombre: $('#curso-nombre').val(),
                codigo: $('#curso-codigo').val(),
                descripcion: $('#curso-descripcion').val(),
                creditos: $('#curso-creditos').val()
            };

            $.ajax({
                method: 'POST',
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/cursos/${accion}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Curso', 'Curso guardado satisfactoriamente');
                        $('#formCurso')[0].reset();
                        $('#curso-id').val('');
                        $('#accionCurso').val('crear');
                        $('#modalCurso').modal('hide');
                        cargarDashboard();
                        cargarTablaCursos();
                    } else {
                        alertSwal('error', 'Curso', r.code.code);
                    }
                },
                error: function (xhr) {
                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }
    });

    $('#btn-submit-competencia').on('click', function (e) {
        e.preventDefault();

        if (validateFormCompetencia()) {
            let accion = $('#accionCompetencia').val();
            let data = {
                id_competencia: $('#competencia-id').val(),
                nombre: $('#competencia-nombre').val(),
                descripcion: $('#competencia-descripcion').val()
            };

            $.ajax({
                method: 'POST',
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/competencias/${accion}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Competencia', 'Competencia guardada satisfactoriamente');
                        $('#formCompetencia')[0].reset();
                        $('#competencia-id').val('');
                        $('#accionCompetencia').val('crear');
                        $('#modalCompetencia').modal('hide');
                        cargarDashboard();
                        cargarFiltrosCurriculo();
                        cargarTablaCompetencias();
                        cargarTablaObjetivos();
                        cargarTablaCursos();
                        cargarAnalisis();
                    } else {
                        alertSwal('error', 'Competencia', r.code.code);
                    }
                },
                error: function (xhr) {
                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }
    });

    $('#btn-submit-objetivo').on('click', function (e) {
        e.preventDefault();

        if (validateFormObjetivo()) {
            let accion = $('#accionObjetivo').val();
            let data = {
                id_objetivo: $('#objetivo-id').val(),
                id_competencia: $('#objetivo-competencia').val(),
                nombre: $('#objetivo-nombre').val(),
                descripcion: $('#objetivo-descripcion').val()
            };

            $.ajax({
                method: 'POST',
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/objetivos/${accion}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Objetivo', 'Objetivo guardado satisfactoriamente');
                        $('#formObjetivo')[0].reset();
                        $('#objetivo-id').val('');
                        $('#accionObjetivo').val('crear');
                        $('#modalObjetivo').modal('hide');
                        cargarDashboard();
                        cargarFiltrosCurriculo();
                        cargarTablaCompetencias();
                        cargarTablaObjetivos();
                        cargarTablaCursos();
                        cargarAnalisis();
                    } else {
                        alertSwal('error', 'Objetivo', r.code.code);
                    }
                },
                error: function (xhr) {
                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }
    });

    $('#tbl-cursos').on('click', '.btnEditCurso', function () {
        let id_curso = $(this).attr('curso');

        $('#accionCurso').val('actualizar');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "POST",
            url: url_site(`api/cursos/obtener`),
            contentType: 'application/json',
            data: JSON.stringify({
                id_curso: id_curso
            }),
            dataType: "json",
            success: function (resp) {
                if (resp.status == "success") {
                    $('#curso-id').val(resp.data.id_curso);
                    $('#curso-programa').val(resp.data.id_programa).change();
                    $('#curso-nombre').val(resp.data.nombre);
                    $('#curso-codigo').val(resp.data.codigo);
                    $('#curso-descripcion').val(resp.data.descripcion);
                    $('#curso-creditos').val(resp.data.creditos);
                    $('#modalCurso').modal();
                } else {
                    alertSwal('error', 'Curso', resp.code.code);
                }
            },
            error: function (xhr) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            }
        }).done(function () {
            hideModalLoading();
        });
    });

    $('#tbl-competencias').on('click', '.btnEditCompetencia', function () {
        let id_competencia = $(this).attr('competencia');

        $('#accionCompetencia').val('actualizar');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "POST",
            url: url_site(`api/competencias/obtener`),
            contentType: 'application/json',
            data: JSON.stringify({
                id_competencia: id_competencia
            }),
            dataType: "json",
            success: function (resp) {
                if (resp.status == "success") {
                    $('#competencia-id').val(resp.data.id_competencia);
                    $('#competencia-nombre').val(resp.data.nombre);
                    $('#competencia-descripcion').val(resp.data.descripcion);
                    $('#modalCompetencia').modal();
                } else {
                    alertSwal('error', 'Competencia', resp.code.code);
                }
            },
            error: function (xhr) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            }
        }).done(function () {
            hideModalLoading();
        });
    });

    $('#tbl-objetivos').on('click', '.btnEditObjetivo', function () {
        let id_objetivo = $(this).attr('objetivo');

        $('#accionObjetivo').val('actualizar');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "POST",
            url: url_site(`api/objetivos/obtener`),
            contentType: 'application/json',
            data: JSON.stringify({
                id_objetivo: id_objetivo
            }),
            dataType: "json",
            success: function (resp) {
                if (resp.status == "success") {
                    $('#objetivo-id').val(resp.data.id_objetivo);
                    $('#objetivo-competencia').val(resp.data.id_competencia).change();
                    $('#objetivo-nombre').val(resp.data.nombre);
                    $('#objetivo-descripcion').val(resp.data.descripcion);
                    $('#modalObjetivo').modal();
                } else {
                    alertSwal('error', 'Objetivo', resp.code.code);
                }
            },
            error: function (xhr) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            }
        }).done(function () {
            hideModalLoading();
        });
    });

    $('#tbl-cursos').on('click', '.btnDeleteCurso', function () {
        let id_curso = $(this).attr('curso');

        Swal.fire({
            type: 'question',
            title: 'Eliminar Curso',
            text: '¿Está seguro de eliminar este curso?',
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    method: 'POST',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/cursos/eliminar`),
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id_curso: id_curso
                    }),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Curso', 'Curso eliminado satisfactoriamente');
                            cargarDashboard();
                            cargarTablaCursos();
                        } else {
                            alertSwal('error', 'Curso', r.code.code);
                        }
                    },
                    error: function (xhr) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    }
                });
            }
        });
    });

    $('#tbl-competencias').on('click', '.btnDeleteCompetencia', function () {
        let id_competencia = $(this).attr('competencia');

        Swal.fire({
            type: 'question',
            title: 'Eliminar Competencia',
            text: '¿Está seguro de eliminar esta competencia?',
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    method: 'POST',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/competencias/eliminar`),
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id_competencia: id_competencia
                    }),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Competencia', 'Competencia eliminada satisfactoriamente');
                            cargarDashboard();
                            cargarFiltrosCurriculo();
                            cargarTablaCompetencias();
                            cargarTablaObjetivos();
                            cargarTablaCursos();
                            cargarAnalisis();
                        } else {
                            alertSwal('error', 'Competencia', r.code.code);
                        }
                    },
                    error: function (xhr) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    }
                });
            }
        });
    });

    $('#tbl-objetivos').on('click', '.btnDeleteObjetivo', function () {
        let id_objetivo = $(this).attr('objetivo');

        Swal.fire({
            type: 'question',
            title: 'Eliminar Objetivo',
            text: '¿Está seguro de eliminar este objetivo?',
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    method: 'POST',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/objetivos/eliminar`),
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id_objetivo: id_objetivo
                    }),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Objetivo', 'Objetivo eliminado satisfactoriamente');
                            cargarDashboard();
                            cargarFiltrosCurriculo();
                            cargarTablaCompetencias();
                            cargarTablaObjetivos();
                            cargarTablaCursos();
                            cargarAnalisis();
                        } else {
                            alertSwal('error', 'Objetivo', r.code.code);
                        }
                    },
                    error: function (xhr) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    }
                });
            }
        });
    });

$('#tbl-cursos').on('click', '.btnObjetivosCurso', function () {
    let id_curso = $(this).attr('curso');

    $('#curso-objetivo-id-curso').val(id_curso);

    loadSelectOption({
        url: url_site(`api/curriculoAnalisis/listar-objetivos`),
        input: [{
            id: 'curso-objetivo-id-objetivo',
            clearOptions: true,
            emptyText: 'Seleccione un Objetivo',
            selectedValue: ''
        }],
        columnKey: 'id_objetivo',
        columnDescription: 'nombre',
        responsePath: 'data'
    });

    cargarTablaCursoObjetivo(id_curso);
    $('#modalCursoObjetivo').modal();
});

$('#btn-agregar-objetivo-curso').on('click', function () {
    let data = {
        id_curso: $('#curso-objetivo-id-curso').val(),
        id_objetivo: $('#curso-objetivo-id-objetivo').val(),
        nivel: $('#curso-objetivo-nivel').val()
    };

    if (data.id_objetivo == "" || data.nivel == "") {
        alertSwal('error', 'Curso Objetivo', 'Debe seleccionar objetivo y nivel');
        return;
    }

    $.ajax({
        method: 'POST',
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/cursoObjetivo/crear`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (r) {
            if (r.status == "success") {
                alertSwal('success', 'Curso Objetivo', 'Relación guardada satisfactoriamente');
                cargarTablaCursoObjetivo(data.id_curso);
            } else {
                alertSwal('error', 'Curso Objetivo', r.code.code);
            }
        },
        error: function (xhr) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        }
    });
});

$('#tbl-curso-objetivo').on('click', '.btnDeleteCursoObjetivo', function () {
    let id_curso_objetivo = $(this).attr('cursoobjetivo');
    let id_curso = $('#curso-objetivo-id-curso').val();

    $.ajax({
        method: 'POST',
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/cursoObjetivo/eliminar`),
        contentType: 'application/json',
        data: JSON.stringify({
            id_curso_objetivo: id_curso_objetivo
        }),
        dataType: "json",
        success: function (r) {
            if (r.status == "success") {
                alertSwal('success', 'Curso Objetivo', 'Relación eliminada satisfactoriamente');
                cargarTablaCursoObjetivo(id_curso);
            } else {
                alertSwal('error', 'Curso Objetivo', r.code.code);
            }
        },
        error: function (xhr) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        }
    });
});


});

function cargarDashboard() {
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/curriculoAnalisis/dashboard`),
        dataType: "json",
        success: function (r) {
            if (r.status == "success") {
                $('#total-cursos').html(r.data.cursos.length);
                $('#total-competencias').html(r.data.competencias.length);
                $('#total-objetivos').html(r.data.objetivos.length);
                $('#total-programas').html(r.data.programas.length);
            }
        }
    });
}

function cargarFiltrosCurriculo() {
    loadSelectOption({
        url: url_site(`api/curriculoAnalisis/listar-programas`),
        input: [
            {
                id: 'filtro-programa',
                clearOptions: true,
                emptyText: 'Todos los Programas',
                selectedValue: ''
            },
            {
                id: 'curso-programa',
                clearOptions: true,
                emptyText: 'Seleccione un Programa',
                selectedValue: ''
            }
        ],
        columnKey: 'id_programa',
        columnDescription: 'nombre',
        responsePath: 'data'
    });

    loadSelectOption({
        url: url_site(`api/curriculoAnalisis/listar-competencias`),
        input: [
            {
                id: 'filtro-competencia',
                clearOptions: true,
                emptyText: 'Todas las Competencias',
                selectedValue: ''
            },
            {
                id: 'objetivo-competencia',
                clearOptions: true,
                emptyText: 'Seleccione una Competencia',
                selectedValue: ''
            }
        ],
        columnKey: 'id_competencia',
        columnDescription: 'nombre',
        responsePath: 'data'
    });

    loadSelectOption({
        url: url_site(`api/curriculoAnalisis/listar-objetivos`),
        input: [
            {
                id: 'filtro-objetivo',
                clearOptions: true,
                emptyText: 'Todos los Objetivos',
                selectedValue: ''
            }
        ],
        columnKey: 'id_objetivo',
        columnDescription: 'nombre',
        responsePath: 'data'
    });
}

function cargarTablaCursos() {
    let programa = $('#filtro-programa').val();
    let competencia = $('#filtro-competencia').val();
    let objetivo = $('#filtro-objetivo').val();
    let nivel = $('#filtro-nivel').val();

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/curriculoAnalisis/listar-cursos?programa=${programa}&competencia=${competencia}&objetivo=${objetivo}&nivel=${nivel}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-cursos').DataTable().clear();
            $('#tbl-cursos').DataTable().destroy();

            let t = $('#tbl-cursos').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [[1, "asc"]],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Cursos'
                }]
            });

            if (r.status == "success") {
                r.data.forEach((curso) => {
                    t.row.add([
                        curso.codigo,
                        curso.nombre,
                        curso.programa,
                        curso.creditos || 0,
                        (curso.competencias || '').split('||').join('<br>'),
                        (curso.objetivos_nivel || '').split('||').join('<br>'),
                        `<button class="btn btn-xs btn-info btnObjetivosCurso" curso="${curso.id_curso}" nombre="${curso.nombre}">
                            <i class="fa fa-list" aria-hidden="true"></i> Objetivos
                        </button>
                        <button class="btn btn-xs btn-warning btnEditCurso" curso="${curso.id_curso}">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                        </button>
                        <button class="btn btn-xs btn-danger btnDeleteCurso" curso="${curso.id_curso}">
                            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                        </button>`
                    ]);
                });
            }

            t.draw();
        },
        error: function (xhr) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    }).done(function () {
        hideModalLoading();
    });
}

function cargarTablaCompetencias() {
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/curriculoAnalisis/listar-competencias`),
        dataType: "json",
        success: function (r) {

            $('#tbl-competencias').DataTable().clear();
            $('#tbl-competencias').DataTable().destroy();

            let t = $('#tbl-competencias').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [[1, "asc"]]
            });

            if (r.status == "success") {
                r.data.forEach((comp) => {
                    t.row.add([
                        comp.id_competencia,
                        comp.nombre,
                        comp.descripcion || '',
                        comp.total_objetivos || 0,
                        `<button class="btn btn-xs btn-warning btnEditCompetencia" competencia="${comp.id_competencia}">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                        </button>
                        <button class="btn btn-xs btn-danger btnDeleteCompetencia" competencia="${comp.id_competencia}">
                            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                        </button>`
                    ]);
                });
            }

            t.draw();
        },
        error: function (xhr) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    }).done(function () {
        hideModalLoading();
    });
}

function cargarTablaObjetivos() {
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/curriculoAnalisis/listar-objetivos`),
        dataType: "json",
        success: function (r) {

            $('#tbl-objetivos').DataTable().clear();
            $('#tbl-objetivos').DataTable().destroy();

            let t = $('#tbl-objetivos').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [[1, "asc"]]
            });

            if (r.status == "success") {
                r.data.forEach((obj) => {
                    t.row.add([
                        obj.id_objetivo,
                        obj.nombre,
                        obj.competencia || '',
                        obj.descripcion || '',
                        obj.total_cursos || 0,
                        `<button class="btn btn-xs btn-warning btnEditObjetivo" objetivo="${obj.id_objetivo}">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                        </button>
                        <button class="btn btn-xs btn-danger btnDeleteObjetivo" objetivo="${obj.id_objetivo}">
                            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                        </button>`
                    ]);
                });
            }

            t.draw();
        },
        error: function (xhr) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    }).done(function () {
        hideModalLoading();
    });
}

function cargarAnalisis() {
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/curriculoAnalisis/analisis-cobertura`),
        dataType: "json",
        success: function (r) {
            if (r.status == "success") {
                renderizarGraficos(r.data);
            }
        },
        error: function (xhr) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        }
    });
}

function renderizarGraficos(data) {
    const ctxObjetivos = document.getElementById('grafico-objetivos');
    const ctxCompetencias = document.getElementById('grafico-competencias');

    $('#total-objetivos-analisis').html(data.totalObjetivos);
    $('#objetivos-sin-asignar-analisis').html(data.objetivosSinAsignar);
    $('#porcentaje-objetivos-sin').html(data.porcentajeObjetivosSin + '%');

    $('#total-competencias-analisis').html(data.totalCompetencias);
    $('#competencias-sin-objetivos-analisis').html(data.competenciasSinObjetivos);
    $('#porcentaje-competencias-sin').html(data.porcentajeCompetenciasSin + '%');

    if (chartObjetivos) {
        chartObjetivos.destroy();
    }

    if (chartCompetencias) {
        chartCompetencias.destroy();
    }

    if (ctxObjetivos) {
        chartObjetivos = new Chart(ctxObjetivos, {
            type: 'doughnut',
            data: {
                labels: ['Sin asignar', 'Asignados'],
                datasets: [{
                    data: [
                        data.objetivosSinAsignar,
                        (data.totalObjetivos - data.objetivosSinAsignar)
                    ],
                    backgroundColor: ['#f39c12', '#00a65a']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    if (ctxCompetencias) {
        chartCompetencias = new Chart(ctxCompetencias, {
            type: 'doughnut',
            data: {
                labels: ['Sin objetivos', 'Con objetivos'],
                datasets: [{
                    data: [
                        data.competenciasSinObjetivos,
                        (data.totalCompetencias - data.competenciasSinObjetivos)
                    ],
                    backgroundColor: ['#dd4b39', '#3c8dbc']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}


function validateFormCurso() {
    if ($('#curso-programa').val() == "" || $('#curso-programa').val() == null) {
        alertSwal('error', 'Programa', 'Este campo es obligatorio');
        $("#curso-programa").focus();
        return false;
    }

    if ($('#curso-nombre').val() == "" || $('#curso-nombre').val() == null) {
        alertSwal('error', 'Curso', 'Este campo es obligatorio');
        $("#curso-nombre").focus();
        return false;
    }

    if ($('#curso-codigo').val() == "" || $('#curso-codigo').val() == null) {
        alertSwal('error', 'Código', 'Este campo es obligatorio');
        $("#curso-codigo").focus();
        return false;
    }

    return true;
}

function validateFormCompetencia() {
    if ($('#competencia-nombre').val() == "" || $('#competencia-nombre').val() == null) {
        alertSwal('error', 'Competencia', 'Este campo es obligatorio');
        $("#competencia-nombre").focus();
        return false;
    }

    return true;
}

function validateFormObjetivo() {
    if ($('#objetivo-competencia').val() == "" || $('#objetivo-competencia').val() == null) {
        alertSwal('error', 'Competencia', 'Este campo es obligatorio');
        $("#objetivo-competencia").focus();
        return false;
    }

    if ($('#objetivo-nombre').val() == "" || $('#objetivo-nombre').val() == null) {
        alertSwal('error', 'Objetivo', 'Este campo es obligatorio');
        $("#objetivo-nombre").focus();
        return false;
    }

    return true;
}

function cargarTablaCursoObjetivo(id_curso) {
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/cursoObjetivo/por-curso?id_curso=${id_curso}`),
        dataType: "json",
        success: function (r) {
            $('#tbl-curso-objetivo').DataTable().clear();
            $('#tbl-curso-objetivo').DataTable().destroy();

            let t = $('#tbl-curso-objetivo').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [[1, "asc"]]
            });

            if (r.status == "success") {
                r.data.forEach((item) => {
                    t.row.add([
                        item.id_curso_objetivo,
                        item.objetivo,
                        item.competencia,
                        item.nivel,
                        `<button class="btn btn-xs btn-danger btnDeleteCursoObjetivo" cursoobjetivo="${item.id_curso_objetivo}">
                            <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                        </button>`
                    ]);
                });
            }

            t.draw();
        }
    });
}
