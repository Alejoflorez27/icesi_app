// ============================================================================
// GESTIÓN CURRICULAR - JavaScript Principal
// ============================================================================

let chartObjetivos = null;
let chartCompetencias = null;

// Cargar datos al inicializar
document.addEventListener('DOMContentLoaded', function() {
    console.log('✓ DOM cargado, iniciando Gestión Curricular...');
    cargarDashboard();
    cargarCursos();
    cargarCompetencias();
    cargarObjetivos();
    cargarProgramas();
    cargarAnalisis();
    console.log('✓ Todas las funciones de carga iniciadas');
});

// ============================================================================
// FUNCIONES DE CARGA
// ============================================================================

function cargarDashboard() {
    fetch('api/curriculoAnalisis?action=dashboard')
        .then(response => response.json())
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
    fetch('api/cursos?action=listar')
        .then(response => response.json())
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarCursos(data.data);
            }
        })
        .catch(error => console.error('Error cargando cursos:', error));
}

function cargarCompetencias() {
    fetch('api/competencias?action=listar')
        .then(response => response.json())
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarCompetencias(data.data);
                llenarSelectCompetencias(data.data);
            }
        })
        .catch(error => console.error('Error cargando competencias:', error));
}

function cargarObjetivos() {
    fetch('api/objetivos?action=listar')
        .then(response => response.json())
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarObjetivos(data.data);
            }
        })
        .catch(error => console.error('Error cargando objetivos:', error));
}

function cargarProgramas() {
    console.log('→ Cargando programas...');
    fetch('api/programas?action=listar')
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
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
    fetch('api/curriculoAnalisis?action=analisisCobertura')
        .then(response => response.json())
        .then(data => {
            if (data.code === 200 && data.data) {
                renderizarGraficos(data.data);
            }
        })
        .catch(error => console.error('Error cargando análisis:', error));
}

// ============================================================================
// FUNCIONES DE RENDERIZADO
// ============================================================================

function renderizarCursos(cursos) {
    const tbody = document.getElementById('tbody-cursos');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (cursos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay cursos registrados</td></tr>';
        return;
    }

    cursos.forEach(curso => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${curso.codigo}</td>
            <td>${curso.nombre}</td>
            <td>${curso.programa || 'N/A'}</td>
            <td>${curso.creditos || 0}</td>
            <td><span class="badge badge-info">0</span></td>
            <td><span class="badge badge-warning">0</span></td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editarCurso(${curso.id_curso})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarCurso(${curso.id_curso})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarCompetencias(competencias) {
    const tbody = document.getElementById('tbody-competencias');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (competencias.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay competencias registradas</td></tr>';
        return;
    }

    competencias.forEach(comp => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${comp.nombre}</td>
            <td>${comp.descripcion || ''}</td>
            <td><span class="badge badge-primary">0</span></td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editarCompetencia(${comp.id_competencia || comp.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarCompetencia(${comp.id_competencia || comp.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarObjetivos(objetivos) {
    const tbody = document.getElementById('tbody-objetivos');
    if (!tbody) return;
    tbody.innerHTML = '';

    if (objetivos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay objetivos registrados</td></tr>';
        return;
    }

    objetivos.forEach(obj => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${obj.nombre}</td>
            <td>${obj.competencia || 'N/A'}</td>
            <td>${obj.descripcion || ''}</td>
            <td><span class="badge badge-success">0</span></td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editarObjetivo(${obj.id_objetivo || obj.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarObjetivo(${obj.id_objetivo || obj.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderizarGraficos(analisis) {
    const ctx1 = document.getElementById('grafico-objetivos');
    const ctx2 = document.getElementById('grafico-competencias');

    if (!ctx1 || !ctx2) return;

    // Destruir gráficos anteriores
    if (chartObjetivos) chartObjetivos.destroy();
    if (chartCompetencias) chartCompetencias.destroy();

    // Gráfico de Objetivos
    chartObjetivos = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Sin Asignar', 'Asignados'],
            datasets: [{
                data: [
                    analisis.objetivosSinAsignar,
                    analisis.totalObjetivos - analisis.objetivosSinAsignar
                ],
                backgroundColor: ['#ff6b6b', '#51cf66']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Gráfico de Competencias
    chartCompetencias = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Sin Objetivos', 'Con Objetivos'],
            datasets: [{
                data: [
                    analisis.competenciasSinObjetivos,
                    analisis.totalCompetencias - analisis.competenciasSinObjetivos
                ],
                backgroundColor: ['#ffa94d', '#4c6ef5']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

// ============================================================================
// FUNCIONES AUXILIARES
// ============================================================================

function llenarSelectProgramas(programas) {
    console.log('→ Rellenando select de programas con:', programas);
    const select = document.getElementById('curso-programa');
    console.log('→ Select encontrado:', select);
    
    if (!select) {
        console.error('✗ Select curso-programa NO encontrado. Reintentando...');
        setTimeout(() => llenarSelectProgramas(programas), 500);
        return;
    }
    
    select.innerHTML = '<option value="">Selecciona un programa</option>';
    console.log('✓ Select limpiado');
    
    if (programas && Array.isArray(programas)) {
        programas.forEach((prog, idx) => {
            console.log(`  → Agregando programa ${idx + 1}:`, prog.id_programa, prog.nombre);
            const option = document.createElement('option');
            option.value = prog.id_programa || '';
            option.textContent = prog.nombre || '';
            select.appendChild(option);
        });
        console.log(`✓ ${programas.length} programas agregados al select`);
    } else {
        console.error('✗ Programas no es un array:', programas);
    }
}

function llenarSelectCompetencias(competencias) {
    const select = document.getElementById('objetivo-competencia');
    select.innerHTML = '<option value="">Seleccionar Competencia</option>';
    const selectFiltro = document.getElementById('filtro-competencia');
    selectFiltro.innerHTML = '<option value="">Todas las Competencias</option>';
    
    competencias.forEach(comp => {
        const option = document.createElement('option');
        option.value = comp.id_competencia || comp.id;
        option.textContent = comp.nombre;
        select.appendChild(option);
        
        const optionFiltro = document.createElement('option');
        optionFiltro.value = comp.id_competencia || comp.id;
        optionFiltro.textContent = comp.nombre;
        selectFiltro.appendChild(optionFiltro);
    });
}

function filtrarCursos() {
    // Implementar lógica de filtrado
    console.log('Filtrar cursos');
}

function limpiarFiltros() {
    document.getElementById('filtro-programa').value = '';
    document.getElementById('filtro-competencia').value = '';
    cargarCursos();
}

// ============================================================================
// MODALES Y CRUD
// ============================================================================

function mostrarModalCurso() {
    document.getElementById('curso-id').value = '';
    document.getElementById('formCurso').reset();
    $('#modalCurso').modal('show');
}

function mostrarModalCompetencia() {
    document.getElementById('competencia-id').value = '';
    document.getElementById('formCompetencia').reset();
    $('#modalCompetencia').modal('show');
}

function mostrarModalObjetivo() {
    document.getElementById('objetivo-id').value = '';
    document.getElementById('formObjetivo').reset();
    $('#modalObjetivo').modal('show');
}

function guardarCurso() {
    const id = document.getElementById('curso-id').value;
    const datos = {
        id_programa: document.getElementById('curso-programa').value,
        nombre: document.getElementById('curso-nombre').value,
        codigo: document.getElementById('curso-codigo').value,
        descripcion: document.getElementById('curso-descripcion').value,
        creditos: document.getElementById('curso-creditos').value
    };

    const url = id ? 
        `api/cursos?action=actualizar` :
        'api/cursos?action=crear';

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
            alertify.success(data.msg);
        } else {
            alertify.error(data.msg);
        }
    });
}

function guardarCompetencia() {
    const id = document.getElementById('competencia-id').value;
    const datos = {
        nombre: document.getElementById('competencia-nombre').value,
        descripcion: document.getElementById('competencia-descripcion').value
    };

    const url = id ? 
        `api/competencias?action=actualizar` :
        'api/competencias?action=crear';

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
            alertify.success(data.msg);
        } else {
            alertify.error(data.msg);
        }
    });
}

function guardarObjetivo() {
    const id = document.getElementById('objetivo-id').value;
    const datos = {
        id_competencia: document.getElementById('objetivo-competencia').value,
        nombre: document.getElementById('objetivo-nombre').value,
        descripcion: document.getElementById('objetivo-descripcion').value
    };

    const url = id ? 
        `api/objetivos?action=actualizar` :
        'api/objetivos?action=crear';

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
            alertify.success(data.msg);
        } else {
            alertify.error(data.msg);
        }
    });
}

function editarCurso(id) {
    // Implementar carga de datos para editar
    mostrarModalCurso();
}

function editarCompetencia(id) {
    // Implementar carga de datos para editar
    mostrarModalCompetencia();
}

function editarObjetivo(id) {
    // Implementar carga de datos para editar
    mostrarModalObjetivo();
}

function eliminarCurso(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este curso?')) {
        fetch(`api/cursos?action=eliminar&id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.code === 200) {
                    cargarCursos();
                    alertify.success(data.msg);
                } else {
                    alertify.error(data.msg);
                }
            });
    }
}

function eliminarCompetencia(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta competencia?')) {
        fetch(`api/competencias?action=eliminar&id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.code === 200) {
                    cargarCompetencias();
                    alertify.success(data.msg);
                } else {
                    alertify.error(data.msg);
                }
            });
    }
}

function eliminarObjetivo(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este objetivo?')) {
        fetch(`api/objetivos?action=eliminar&id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.code === 200) {
                    cargarObjetivos();
                    cargarCompetencias();
                    alertify.success(data.msg);
                } else {
                    alertify.error(data.msg);
                }
            });
    }
}
