$(document).ready(function () {
    $("body").addClass("sidebar-collapse");

    cargarTablaSolicitudesCalidadAgrupadas();

    loadSelectOption({
        url: url_site(`api/servicio/usuarios-calidad`),
        input: [{
            id: 'id_usuario_calidad',
            clearOptions: true,
            emptyText: 'Seleccione un Usuario',
            selectedValue: ''
        }],
        columnKey: 'username',
        columnDescription: 'nombre',
        responsePath: 'data'
    })

    let elementosSeleccionados = {};
    let arrayElementos = [];

    // Manejador para el botón de ver servicios
    $('#tbl-servicios-calidad').on('click', '.btn-ver-servicios', function() {
        const idSolicitud = $(this).data('solicitud');
        const serviciosInfo = $(this).data('servicios');
        
        cargarModalServicios(idSolicitud, serviciosInfo);
        $('#modalServicios').modal('show');
    });

    // Manejador para checkboxes dentro del modal
    $('#modalServicios').on('click', '.checkbox-servicio-modal', function() {
        let id_servicio = $(this).val();
        let isChecked = $(this).is(':checked');

        if (isChecked) {
            elementosSeleccionados[id_servicio] = id_servicio;
        } else {
            delete elementosSeleccionados[id_servicio];
        }

        arrayElementos = [];
        for (let id in elementosSeleccionados) {
            arrayElementos.push({ id: id });
        }

        console.log('Servicios seleccionados:', arrayElementos);
        
        // Actualizar contador en el modal
        $('#contador-servicios').text(arrayElementos.length);
        
        // Actualizar estado del checkbox "Seleccionar todos"
        actualizarCheckboxSeleccionarTodos();
    });

    // Manejador cuando se ABRE el modal de servicios
    $('#modalServicios').on('show.bs.modal', function () {
        // Limpiar el array cuando se entra al modal
        elementosSeleccionados = {};
        arrayElementos = [];
        $('#contador-servicios').text('0');
        $('#select-all-servicios').prop('checked', false);
        
        console.log('Modal abierto - Selecciones limpiadas');
    });

    // Manejador cuando se CIERRA el modal de servicios
    $('#modalServicios').on('hidden.bs.modal', function () {
        console.log('Modal cerrado, selecciones actuales:', arrayElementos.length);
    });

    // Manejador para seleccionar todos en el modal
    $('#select-all-servicios').on('click', function() {
        const isChecked = $(this).is(':checked');
        $('.checkbox-servicio-modal').prop('checked', isChecked);
        
        if (isChecked) {
            $('.checkbox-servicio-modal').each(function() {
                const id_servicio = $(this).val();
                elementosSeleccionados[id_servicio] = id_servicio;
            });
        } else {
            elementosSeleccionados = {};
        }
        
        arrayElementos = [];
        for (let id in elementosSeleccionados) {
            arrayElementos.push({ id: id });
        }
        
        $('#contador-servicios').text(arrayElementos.length);
    });

    // Manejador del botón de asignar desde el modal
    $('#btnAsignarDesdeModal').on('click', function() {
        if (arrayElementos.length === 0) {
            alertSwal('warning', 'Asignación', 'Seleccione al menos un servicio');
            return;
        }
        
        $('#modalServicios').modal('hide');
        $('#modalAsigSrv').modal('show');
    });

    // Manejador del botón de asignación masiva
    $('#btn-submit-asignar').on('click', function (e) {
        e.preventDefault();

        if (arrayElementos.length === 0) {
            alertSwal('warning', 'Asignación', 'Seleccione al menos un servicio');
            return;
        }

        if (!$('#id_usuario_calidad').val()) {
            alertSwal('warning', 'Asignación', 'Seleccione un usuario de calidad');
            return;
        }

        if (!$('#prioridad').val()) {
            alertSwal('warning', 'Asignación', 'Seleccione una prioridad');
            return;
        }

        let data = {
            array: arrayElementos,
            id_usuario_calidad: $('#id_usuario_calidad').val(),
            prioridad: $('#prioridad').val(),
        }

        console.log('Datos a enviar:', data);

        showModalLoading();
        
        $.ajax({
            method: "PUT",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/servicio/asig-usrcalidad-masivo`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Servicio', 'Servicios asignados satisfactoriamente');
                    cargarTablaSolicitudesCalidadAgrupadas();
                    $('#formAsigSrv')[0].reset();
                    $('#modalAsigSrv').modal('hide');
                    elementosSeleccionados = {};
                    arrayElementos = [];
                } else {
                    alertSwal('error', 'Servicio', r.message || 'Error al asignar servicios');
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al asignar servicios.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
    });

});

function cargarTablaSolicitudesCalidadAgrupadas() {
    showModalLoading();
    
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/servicio/calidad-lista-agrupada`),
        dataType: "json",
        success: function (r) {
            $('#tbl-servicios-calidad').DataTable().clear();
            $('#tbl-servicios-calidad').DataTable().destroy();

            let t = $('#tbl-servicios-calidad').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                order: [[0, "desc"]],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Solicitudes en Calidad',
                }],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });

            if (r.status == "success") {
                r.data.forEach((solicitud) => {
                    // Verificar si todos los servicios están listos para calidad
                    const todosListos = solicitud.servicios_listos_calidad === solicitud.total_servicios;
                    
                    // Aplicar clase CSS condicional - COMPLETOS en AZUL
                    const badgeClass = todosListos ? 'badge bg-blue' : 'badge bg-orange';
                    const badgeText = `<center><span class="${badgeClass}">${solicitud.servicios_listos_calidad}<!--/${solicitud.total_servicios}--></span></center>`;

                    t.row.add([
                        solicitud.id_solicitud,
                        '<div style="text-align:center;">' + (solicitud.nombre_combo || 'N/A') + '</div>',
                        solicitud.cliente || 'N/A',
                        solicitud.candidato || 'N/A',
                        solicitud.doc_candidato || 'N/A',
                        solicitud.id_usuario_calidad,
                        badgeText, // Completos en AZUL, incompletos en NARANJA
                        `<center>
                            <button class="btn btn-primary btn-sm btn-ver-servicios" 
                                    data-solicitud="${solicitud.id_solicitud}"
                                    data-servicios="${solicitud.servicios_info || ''}">
                                <i class="fa fa-list"></i> Ver Servicios
                            </button>
                        </center>`
                    ]);
                });
            } else {
                console.error('Error al cargar datos:', r.message);
            }

            t.draw();
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    });
}

function cargarModalServicios(idSolicitud, serviciosInfo) {
    // Limpiar selecciones anteriores
    elementosSeleccionados = {};
    arrayElementos = [];
    $('#contador-servicios').text('0');
    $('#select-all-servicios').prop('checked', false);
    
    // Parsear la información de servicios
    let tablaBody = $('#tabla-servicios-modal tbody');
    tablaBody.empty();
    
    if (!serviciosInfo || serviciosInfo.trim() === '') {
        tablaBody.append(`
            <tr>
                <td colspan="5" class="text-center">No hay servicios disponibles</td>
            </tr>
        `);
        return;
    }
    
    const serviciosArray = serviciosInfo.split(';');
    
    serviciosArray.forEach(servicioStr => {
        const partes = servicioStr.split('|');
        if (partes.length >= 7) {
            const [id, nombre, estado, usuarioId, usuarioNombreProv, usuarioCalId, usuarioNombre, prioridad] = partes;
            
            const estadoProcesoDesc = obtenerDescripcionEstado(estado);
            const estadoBadge = obtenerBadgeEstado(estado);
            
            const fila = `
                <tr>
                    <td width="5%">
                        <input type="checkbox" class="checkbox-servicio-modal" value="${id}">
                    </td>
                    <td>${nombre || 'N/A'}</td>
                    <td><span class="badge ${estadoBadge}">${estadoProcesoDesc}</span></td>
                    <td>${usuarioNombreProv || 'No asignado'}</td>
                    <td>${usuarioNombre || 'No asignado'}</td>
                    <td>${prioridad || 'No definida'}</td>
                </tr>
            `;
            tablaBody.append(fila);
        }
    });
    
    $('#modal-titulo-solicitud').text(`Servicios - Solicitud: ${idSolicitud}`);
    console.log('Modal cargado para solicitud:', idSolicitud, 'Selecciones limpiadas');
}

function obtenerDescripcionEstado(estado) {
    const estados = {
        '1': 'Pendiente',
        '2': 'Asignado',
        '3': 'En Proceso',
        '4': 'Completado',
        '6': 'Rechazado',
        '7': 'En Pausa'
    };
    return estados[estado] || 'Desconocido';
}

function obtenerBadgeEstado(estado) {
    const badges = {
        '1': 'bg-yellow',
        '2': 'bg-blue',
        '3': 'bg-primary',
        '4': 'bg-green',
        '6': 'bg-red',
        '7': 'bg-orange'
    };
    return badges[estado] || 'bg-gray';
}

function actualizarCheckboxSeleccionarTodos() {
    const totalCheckboxes = $('.checkbox-servicio-modal').length;
    const checkedCheckboxes = $('.checkbox-servicio-modal:checked').length;
    
    if (checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0) {
        $('#select-all-servicios').prop('checked', true);
    } else {
        $('#select-all-servicios').prop('checked', false);
    }
}