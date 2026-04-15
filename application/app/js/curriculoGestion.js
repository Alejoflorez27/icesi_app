let chartObjetivos = null;
let chartCompetencias = null;
const API_BASE = '/api';
<<<<<<< ours
=======

function mostrarNotificacion(tipo, mensaje) {
    if (window.alertify && typeof window.alertify[tipo] === 'function') {
        window.alertify[tipo](mensaje);
        return;
    }

    if (window.Swal && typeof window.Swal.fire === 'function') {
        const icono = tipo === 'success' ? 'success' : 'error';
        window.Swal.fire({
            icon: icono,
            title: tipo === 'success' ? 'Éxito' : 'Error',
            text: mensaje
        });
        return;
    }

    console[tipo === 'success' ? 'log' : 'error'](mensaje);
}

function obtenerElementoPorIds(ids) {
    for (const id of ids) {
        const elemento = document.getElementById(id);
        if (elemento) return elemento;
    }
    return null;
}

async function fetchJson(url) {
    const response = await fetch(url);
    if (!response.ok) throw new Error(`HTTP ${response.status}`);

    const contentType = response.headers.get('content-type') || '';
    if (!contentType.includes('application/json')) {
        const body = await response.text();
        throw new Error(`Respuesta no JSON (${contentType || 'sin content-type'}): ${body.slice(0, 120)}`);
    }

    return response.json();
}
>>>>>>> theirs

function mostrarNotificacion(tipo, mensaje) {
    if (window.alertify && typeof window.alertify[tipo] === 'function') {
        window.alertify[tipo](mensaje);
        return;
    }

    if (window.Swal && typeof window.Swal.fire === 'function') {
        const icono = tipo === 'success' ? 'success' : 'error';
        window.Swal.fire({
            icon: icono,
            title: tipo === 'success' ? 'Éxito' : 'Error',
            text: mensaje
        });
        return;
    }

    console[tipo === 'success' ? 'log' : 'error'](mensaje);
}

function obtenerElementoPorIds(ids) {
    for (const id of ids) {
        const elemento = document.getElementById(id);
        if (elemento) return elemento;
    }
    return null;
}

async function fetchJson(url) {
    const response = await fetch(url);
    if (!response.ok) throw new Error(`HTTP ${response.status}`);

    const contentType = response.headers.get('content-type') || '';
    if (!contentType.includes('application/json')) {
        const body = await response.text();
        throw new Error(`Respuesta no JSON (${contentType || 'sin content-type'}): ${body.slice(0, 120)}`);
    }

    return response.json();
}

const estado = {
    cursos: [],
    programas: [],
    competencias: [],
    objetivos: []
};

document.addEventListener('DOMContentLoaded', () => {
    inicializar();
});

<<<<<<< ours
async function inicializar() {
    await Promise.all([
        cargarProgramas(),
        cargarCompetencias(),
        cargarObjetivos()
    ]);

    await Promise.all([
        cargarDashboard(),
        cargarCursos(),
        cargarAnalisis()
    ]);
}

function parseResponse(data) {
    if (Array.isArray(data)) return data;
    return data?.data ?? [];
}

async function fetchJson(url, options = {}) {
    const response = await fetch(url, options);
    const data = await response.json();
    return data;
}

function showSuccess(msg) {
    if (window.alertify) alertify.success(msg);
    else alert(msg);
}

function showError(msg) {
    if (window.alertify) alertify.error(msg);
    else alert(msg);
=======
// ============================================================================
// FUNCIONES DE CARGA
// ============================================================================

function cargarDashboard() {
    fetchJson(`${API_BASE}/curriculoAnalisis?action=dashboard`)
        .then(data => {
            if (data.code === 200 && data.data) {
                const d = data.data;
                document.getElementById('total-cursos').textContent = d.cursos ? d.cursos.length : 0;
                document.getElementById('total-competencias').textContent = d.competencias ? d.competencias.length : 0;
                document.getElementById('total-objetivos').textContent = d.objetivos ? d.objetivos.length : 0;
                document.getElementById('total-programas').textContent = d.programas ? d.programas.length : 0;
            }
        })
        .catch(error => console.error('Error en dashboard:', error));
}

function cargarCursos() {
    fetchJson(`${API_BASE}/cursos?action=listar`)
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarCursos(data.data);
            }
        })
        .catch(error => console.error('Error cargando cursos:', error));
}

function cargarCompetencias() {
    fetchJson(`${API_BASE}/competencias?action=listar`)
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarCompetencias(data.data);
                llenarSelectCompetencias(data.data);
            }
        })
        .catch(error => console.error('Error cargando competencias:', error));
}

function cargarObjetivos() {
    fetchJson(`${API_BASE}/objetivos?action=listar`)
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarObjetivos(data.data);
            }
        })
        .catch(error => console.error('Error cargando objetivos:', error));
}

function cargarProgramas() {
    console.log('→ Cargando programas...');
    fetchJson(`${API_BASE}/programas?action=listar`)
        .then(data => {
            console.log('✓ Respuesta API programas:', data);
            
            // La estructura puede ser {success/code, data} según cómo responda Result::message
            const programas = data.data || data.resultado || data;
            
            if (Array.isArray(programas) && programas.length > 0) {
                console.log('✓ Programas recibidos:', programas);
                llenarSelectProgramas(programas);
            } else {
                console.warn('⚠ Sin programas en respuesta');
                llenarSelectProgramas([]);
            }
        })
        .catch(error => {
            console.error('✗ Error cargando programas:', error);
            llenarSelectProgramas([]);
        });
}

function cargarAnalisis() {
    fetchJson(`${API_BASE}/curriculoAnalisis?action=analisisCobertura`)
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarGraficos(data.data);
            }
        })
        .catch(error => console.error('Error cargando análisis:', error));
>>>>>>> theirs
}

async function cargarDashboard() {
    try {
        const data = await fetchJson('api/curriculoAnalisis?action=dashboard');
        const d = data?.data;
        if (!d) return;

        document.getElementById('total-cursos').textContent = d.cursos?.length || 0;
        document.getElementById('total-competencias').textContent = d.competencias?.length || 0;
        document.getElementById('total-objetivos').textContent = d.objetivos?.length || 0;
        document.getElementById('total-programas').textContent = d.programas?.length || 0;
    } catch (error) {
        console.error(error);
    }
}

async function cargarCursos() {
    try {
        const data = await fetchJson('api/curriculoAnalisis?action=listarCursos');
        estado.cursos = parseResponse(data);
        renderizarCursos(estado.cursos);
    } catch (error) {
        console.error(error);
    }
}

async function cargarProgramas() {
    try {
        const data = await fetchJson('api/programas?action=listar');
        estado.programas = parseResponse(data);
        llenarSelectProgramas(estado.programas);
    } catch (error) {
        estado.programas = [];
        llenarSelectProgramas([]);
        console.error(error);
    }
}

async function cargarCompetencias() {
    try {
        const data = await fetchJson('api/curriculoAnalisis?action=dashboard');
        estado.competencias = data?.data?.competencias || [];
        renderizarCompetencias(estado.competencias);
        llenarSelectCompetencias(estado.competencias);
    } catch (error) {
        console.error(error);
    }
}

async function cargarObjetivos() {
    try {
        const data = await fetchJson('api/curriculoAnalisis?action=dashboard');
        estado.objetivos = data?.data?.objetivos || [];
        renderizarObjetivos(estado.objetivos);
        llenarSelectObjetivos(estado.objetivos);
    } catch (error) {
        console.error(error);
    }
}

async function cargarAnalisis() {
    try {
        const data = await fetchJson('api/curriculoAnalisis?action=analisisCobertura');
        if (data?.data) {
            renderizarGraficos(data.data);
        }
    } catch (error) {
        console.error(error);
    }
}

function renderizarCursos(cursos) {
<<<<<<< ours
<<<<<<< ours
    const tbody = document.getElementById('tabla-cursos');
=======
=======
>>>>>>> theirs
    const tbody = obtenerElementoPorIds(['tbody-cursos', 'tabla-cursos']);
    if (!tbody) return;
>>>>>>> theirs
    tbody.innerHTML = '';

    if (!cursos.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay cursos para los filtros seleccionados</td></tr>';
        return;
    }

    cursos.forEach(curso => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${curso.codigo || ''}</td>
            <td>${curso.nombre || ''}</td>
            <td>${curso.programa || 'N/A'}</td>
            <td>${curso.competencias || 'Sin asignar'}</td>
            <td>${curso.objetivos || 'Sin asignar'}</td>
            <td>${curso.niveles || '-'}</td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editarCurso(${curso.id_curso})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger" onclick="eliminarCurso(${curso.id_curso})"><i class="fas fa-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function renderizarCompetencias(competencias) {
<<<<<<< ours
<<<<<<< ours
    const tbody = document.getElementById('tabla-competencias');
=======
=======
>>>>>>> theirs
    const tbody = obtenerElementoPorIds(['tbody-competencias', 'tabla-competencias']);
    if (!tbody) return;
>>>>>>> theirs
    tbody.innerHTML = '';

    if (!competencias.length) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay competencias registradas</td></tr>';
        return;
    }

    competencias.forEach(c => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${c.nombre}</td>
            <td>${c.descripcion || ''}</td>
            <td><span class="badge badge-primary">${c.total_objetivos || 0}</span></td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editarCompetencia(${c.id_competencia})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger" onclick="eliminarCompetencia(${c.id_competencia})"><i class="fas fa-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function renderizarObjetivos(objetivos) {
<<<<<<< ours
<<<<<<< ours
    const tbody = document.getElementById('tabla-objetivos');
=======
=======
>>>>>>> theirs
    const tbody = obtenerElementoPorIds(['tbody-objetivos', 'tabla-objetivos']);
    if (!tbody) return;
>>>>>>> theirs
    tbody.innerHTML = '';

    if (!objetivos.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay objetivos registrados</td></tr>';
        return;
    }

    objetivos.forEach(o => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${o.nombre}</td>
            <td>${o.competencia || 'N/A'}</td>
            <td>${o.descripcion || ''}</td>
            <td><span class="badge badge-success">${o.total_cursos || 0}</span></td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editarObjetivo(${o.id_objetivo})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger" onclick="eliminarObjetivo(${o.id_objetivo})"><i class="fas fa-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function llenarSelectProgramas(programas) {
    const selectCurso = document.getElementById('curso-programa');
    const selectFiltro = document.getElementById('filtro-programa');

    selectCurso.innerHTML = '<option value="">Seleccionar programa</option>';
    selectFiltro.innerHTML = '<option value="">Todos</option>';

    programas.forEach(p => {
        selectCurso.innerHTML += `<option value="${p.id_programa}">${p.nombre}</option>`;
        selectFiltro.innerHTML += `<option value="${p.id_programa}">${p.nombre}</option>`;
    });
}

function llenarSelectCompetencias(competencias) {
    const selectObjetivo = document.getElementById('objetivo-competencia');
    const selectFiltro = document.getElementById('filtro-competencia');

    selectObjetivo.innerHTML = '<option value="">Seleccionar competencia</option>';
    selectFiltro.innerHTML = '<option value="">Todas</option>';

    competencias.forEach(c => {
        selectObjetivo.innerHTML += `<option value="${c.id_competencia}">${c.nombre}</option>`;
        selectFiltro.innerHTML += `<option value="${c.id_competencia}">${c.nombre}</option>`;
    });
}

function llenarSelectObjetivos(objetivos) {
    const selectFiltro = document.getElementById('filtro-objetivo');
    selectFiltro.innerHTML = '<option value="">Todos</option>';
    objetivos.forEach(o => {
        selectFiltro.innerHTML += `<option value="${o.id_objetivo}">${o.nombre}</option>`;
    });
}

function renderizarGraficos(analisis) {
    const ctxObjetivos = document.getElementById('grafico-objetivos');
    const ctxCompetencias = document.getElementById('grafico-competencias');

    if (!ctxObjetivos || !ctxCompetencias) return;
    if (chartObjetivos) chartObjetivos.destroy();
    if (chartCompetencias) chartCompetencias.destroy();

    chartObjetivos = new Chart(ctxObjetivos, {
        type: 'doughnut',
        data: {
            labels: ['Sin asignar', 'Asignados'],
            datasets: [{
                data: [analisis.objetivosSinAsignar, analisis.totalObjetivos - analisis.objetivosSinAsignar],
                backgroundColor: ['#dc3545', '#28a745']
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: `${analisis.porcentajeObjetivosSin}% sin asignar`
                }
            }
        }
    });

    chartCompetencias = new Chart(ctxCompetencias, {
        type: 'doughnut',
        data: {
            labels: ['Sin objetivos', 'Con objetivos'],
            datasets: [{
                data: [analisis.competenciasSinObjetivos, analisis.totalCompetencias - analisis.competenciasSinObjetivos],
                backgroundColor: ['#ffc107', '#007bff']
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: `${analisis.porcentajeCompetenciasSin}% sin objetivos`
                }
            }
        }
    });
}

<<<<<<< ours
async function filtrarCursos() {
    const programa = document.getElementById('filtro-programa').value;
    const competencia = document.getElementById('filtro-competencia').value;
    const objetivo = document.getElementById('filtro-objetivo').value;
    const nivel = document.getElementById('filtro-nivel').value;

    const params = new URLSearchParams({ action: 'listarCursos', programa, competencia, objetivo, nivel });
=======
// ============================================================================
// FUNCIONES AUXILIARES
// ============================================================================

function llenarSelectProgramas(programas) {
    console.log('→ Rellenando select de programas con:', programas);
    const select = obtenerElementoPorIds(['curso-programa']);
    const selectFiltroPrograma = obtenerElementoPorIds(['filtro-programa', 'filtro-programa-cursos']);
    console.log('→ Select encontrado:', select);
    
    if (!select) {
        console.error('✗ Select curso-programa NO encontrado. Reintentando...');
        setTimeout(() => llenarSelectProgramas(programas), 500);
        return;
    }
    
    select.innerHTML = '<option value="">Selecciona un programa</option>';
    if (selectFiltroPrograma) {
        selectFiltroPrograma.innerHTML = '<option value="">Todos los Programas</option>';
    }
    console.log('✓ Select limpiado');
    
    if (programas && Array.isArray(programas)) {
        programas.forEach((prog, idx) => {
            console.log(`  → Agregando programa ${idx + 1}:`, prog.id_programa, prog.nombre);
            const option = document.createElement('option');
            option.value = prog.id_programa || '';
            option.textContent = prog.nombre || '';
            select.appendChild(option);
            if (selectFiltroPrograma) {
                const optionFiltro = document.createElement('option');
                optionFiltro.value = prog.id_programa || '';
                optionFiltro.textContent = prog.nombre || '';
                selectFiltroPrograma.appendChild(optionFiltro);
            }
        });
        console.log(`✓ ${programas.length} programas agregados al select`);
    } else {
        console.error('✗ Programas no es un array:', programas);
    }
}

function llenarSelectCompetencias(competencias) {
    const select = obtenerElementoPorIds(['objetivo-competencia']);
    const selectFiltro = obtenerElementoPorIds(['filtro-competencia', 'filtro-competencia-cursos']);
    if (select) select.innerHTML = '<option value="">Seleccionar Competencia</option>';
    if (selectFiltro) selectFiltro.innerHTML = '<option value="">Todas las Competencias</option>';
    
    competencias.forEach(comp => {
        const option = document.createElement('option');
        option.value = comp.id_competencia || comp.id;
        option.textContent = comp.nombre;
        if (select) select.appendChild(option);
        
        const optionFiltro = document.createElement('option');
        optionFiltro.value = comp.id_competencia || comp.id;
        optionFiltro.textContent = comp.nombre;
        if (selectFiltro) selectFiltro.appendChild(optionFiltro);
    });
}
>>>>>>> theirs

    try {
        const data = await fetchJson(`api/curriculoAnalisis?${params.toString()}`);
        renderizarCursos(data?.data || []);
    } catch (error) {
        console.error(error);
    }
}

function limpiarFiltros() {
    document.getElementById('filtro-programa').value = '';
    document.getElementById('filtro-competencia').value = '';
    document.getElementById('filtro-objetivo').value = '';
    document.getElementById('filtro-nivel').value = '';
    filtrarCursos();
}

function mostrarModalCurso() {
    document.getElementById('titulo-modal-curso').textContent = 'Nuevo Curso';
    document.getElementById('formCurso').reset();
    document.getElementById('curso-id').value = '';
    $('#modalCurso').modal('show');
}

function mostrarModalCompetencia() {
    document.getElementById('titulo-modal-competencia').textContent = 'Nueva Competencia';
    document.getElementById('formCompetencia').reset();
    document.getElementById('competencia-id').value = '';
    $('#modalCompetencia').modal('show');
}

function mostrarModalObjetivo() {
    document.getElementById('titulo-modal-objetivo').textContent = 'Nuevo Objetivo';
    document.getElementById('formObjetivo').reset();
    document.getElementById('objetivo-id').value = '';
    $('#modalObjetivo').modal('show');
}

async function guardarCurso() {
    const id = document.getElementById('curso-id').value;
    const payload = {
        id_curso: id,
        id_programa: document.getElementById('curso-programa').value,
        nombre: document.getElementById('curso-nombre').value,
        codigo: document.getElementById('curso-codigo').value,
        descripcion: document.getElementById('curso-descripcion').value,
        creditos: document.getElementById('curso-creditos').value
    };

<<<<<<< ours
    const action = id ? 'actualizar' : 'crear';
    const data = await fetchJson(`api/cursos?action=${action}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(payload)
=======
    const url = id ? 
        `${API_BASE}/cursos?action=actualizar` :
        `${API_BASE}/cursos?action=crear`;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.code === 200 || data.code === 201) {
            $('#modalCurso').modal('hide');
            cargarCursos();
            mostrarNotificacion('success', data.msg);
        } else {
            mostrarNotificacion('error', data.msg);
        }
>>>>>>> theirs
    });

    if (data.code === 200 || data.code === 201) {
        showSuccess(data.msg || 'Curso guardado');
        $('#modalCurso').modal('hide');
        await cargarCursos();
        await cargarDashboard();
    } else {
        showError(data.msg || 'No se pudo guardar el curso');
    }
}

async function guardarCompetencia() {
    const id = document.getElementById('competencia-id').value;
    const payload = {
        id_competencia: id,
        nombre: document.getElementById('competencia-nombre').value,
        descripcion: document.getElementById('competencia-descripcion').value
    };

<<<<<<< ours
    const action = id ? 'actualizar' : 'crear';
    const data = await fetchJson(`api/competencias?action=${action}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(payload)
=======
    const url = id ? 
        `${API_BASE}/competencias?action=actualizar` :
        `${API_BASE}/competencias?action=crear`;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.code === 200 || data.code === 201) {
            $('#modalCompetencia').modal('hide');
            cargarCompetencias();
            mostrarNotificacion('success', data.msg);
        } else {
            mostrarNotificacion('error', data.msg);
        }
>>>>>>> theirs
    });

    if (data.code === 200 || data.code === 201) {
        showSuccess(data.msg || 'Competencia guardada');
        $('#modalCompetencia').modal('hide');
        await cargarCompetencias();
        await cargarObjetivos();
        await cargarDashboard();
        await cargarAnalisis();
    } else {
        showError(data.msg || 'No se pudo guardar la competencia');
    }
}

async function guardarObjetivo() {
    const id = document.getElementById('objetivo-id').value;
    const payload = {
        id_objetivo: id,
        id_competencia: document.getElementById('objetivo-competencia').value,
        nombre: document.getElementById('objetivo-nombre').value,
        descripcion: document.getElementById('objetivo-descripcion').value
    };

<<<<<<< ours
    const action = id ? 'actualizar' : 'crear';
    const data = await fetchJson(`api/objetivos?action=${action}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(payload)
=======
    const url = id ? 
        `${API_BASE}/objetivos?action=actualizar` :
        `${API_BASE}/objetivos?action=crear`;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.code === 200 || data.code === 201) {
            $('#modalObjetivo').modal('hide');
            cargarObjetivos();
            cargarCompetencias();
            mostrarNotificacion('success', data.msg);
        } else {
            mostrarNotificacion('error', data.msg);
        }
>>>>>>> theirs
    });

    if (data.code === 200 || data.code === 201) {
        showSuccess(data.msg || 'Objetivo guardado');
        $('#modalObjetivo').modal('hide');
        await cargarObjetivos();
        await cargarCursos();
        await cargarDashboard();
        await cargarAnalisis();
    } else {
        showError(data.msg || 'No se pudo guardar el objetivo');
    }
}

function editarCurso(id) {
    const curso = estado.cursos.find(c => Number(c.id_curso) === Number(id));
    if (!curso) return;

    document.getElementById('titulo-modal-curso').textContent = 'Editar Curso';
    document.getElementById('curso-id').value = curso.id_curso;
    document.getElementById('curso-programa').value = curso.id_programa;
    document.getElementById('curso-nombre').value = curso.nombre || '';
    document.getElementById('curso-codigo').value = curso.codigo || '';
    document.getElementById('curso-descripcion').value = curso.descripcion || '';
    document.getElementById('curso-creditos').value = curso.creditos || 0;
    $('#modalCurso').modal('show');
}

function editarCompetencia(id) {
    const competencia = estado.competencias.find(c => Number(c.id_competencia) === Number(id));
    if (!competencia) return;

    document.getElementById('titulo-modal-competencia').textContent = 'Editar Competencia';
    document.getElementById('competencia-id').value = competencia.id_competencia;
    document.getElementById('competencia-nombre').value = competencia.nombre || '';
    document.getElementById('competencia-descripcion').value = competencia.descripcion || '';
    $('#modalCompetencia').modal('show');
}

function editarObjetivo(id) {
<<<<<<< ours
    const objetivo = estado.objetivos.find(o => Number(o.id_objetivo) === Number(id));
    if (!objetivo) return;

    document.getElementById('titulo-modal-objetivo').textContent = 'Editar Objetivo';
    document.getElementById('objetivo-id').value = objetivo.id_objetivo;
    document.getElementById('objetivo-competencia').value = objetivo.id_competencia;
    document.getElementById('objetivo-nombre').value = objetivo.nombre || '';
    document.getElementById('objetivo-descripcion').value = objetivo.descripcion || '';
    $('#modalObjetivo').modal('show');
}

async function eliminarCurso(id) {
    if (!confirm('¿Seguro que deseas eliminar este curso?')) return;

    const data = await fetchJson('api/cursos?action=eliminar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id_curso: id })
    });

    if (data.code === 200) {
        showSuccess(data.msg || 'Curso eliminado');
        await cargarCursos();
        await cargarDashboard();
        await cargarAnalisis();
    } else {
        showError(data.msg || 'No se pudo eliminar el curso');
    }
}

async function eliminarCompetencia(id) {
    if (!confirm('¿Seguro que deseas eliminar esta competencia?')) return;

    const data = await fetchJson('api/competencias?action=eliminar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id_competencia: id })
    });

    if (data.code === 200) {
        showSuccess(data.msg || 'Competencia eliminada');
        await cargarCompetencias();
        await cargarObjetivos();
        await cargarCursos();
        await cargarDashboard();
        await cargarAnalisis();
    } else {
        showError(data.msg || 'No se pudo eliminar la competencia');
    }
}

async function eliminarObjetivo(id) {
    if (!confirm('¿Seguro que deseas eliminar este objetivo?')) return;

    const data = await fetchJson('api/objetivos?action=eliminar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id_objetivo: id })
    });

    if (data.code === 200) {
        showSuccess(data.msg || 'Objetivo eliminado');
        await cargarObjetivos();
        await cargarCursos();
        await cargarDashboard();
        await cargarAnalisis();
    } else {
        showError(data.msg || 'No se pudo eliminar el objetivo');
=======
    // Implementar carga de datos para editar
    mostrarModalObjetivo();
}

function eliminarCurso(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este curso?')) {
        fetch(`${API_BASE}/cursos?action=eliminar&id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.code === 200) {
                    cargarCursos();
                    mostrarNotificacion('success', data.msg);
                } else {
                    mostrarNotificacion('error', data.msg);
                }
            });
    }
}

function eliminarCompetencia(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta competencia?')) {
        fetch(`${API_BASE}/competencias?action=eliminar&id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.code === 200) {
                    cargarCompetencias();
                    mostrarNotificacion('success', data.msg);
                } else {
                    mostrarNotificacion('error', data.msg);
                }
            });
    }
}

function eliminarObjetivo(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este objetivo?')) {
        fetch(`${API_BASE}/objetivos?action=eliminar&id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.code === 200) {
                    cargarObjetivos();
                    cargarCompetencias();
                    mostrarNotificacion('success', data.msg);
                } else {
                    mostrarNotificacion('error', data.msg);
                }
            });
>>>>>>> theirs
    }
}
