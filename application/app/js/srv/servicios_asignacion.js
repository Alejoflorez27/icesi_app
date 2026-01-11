$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    cargarTablaSolicitudesCalidad();



    //carga la lista de perfiles INTERNOS
    loadSelectOption({
        url: url_site(`api/perfil/asig-perfiles-servicios`), 
        input: [{  
            id: 'perfil',
            clearOptions: true,
            emptyText: 'Seleccione un perfil',
            selectedValue: ''
        },],
        columnKey: 'id',
        columnDescription: 'descripcion',
        responsePath: 'data'
    })

    $('#perfil').change(function() {
        var perfil = $('#perfil').val();
        //console.log(perfil);
        loadSelectOption({
            url: url_site(`api/servicio/usuarios-asignacion?perfil=${perfil}`),
            input: [{
                id: 'id_usuario_calidad',
                clearOptions: true,
                emptyText: 'Seleccione un Usuario',
                selectedValue: ''
            },],
            columnKey: 'username',
            columnDescription: 'nombre',
            responsePath: 'data'
        })
    });


    // Objeto para almacenar los elementos seleccionados y sus estados
    let elementosSeleccionados = {};

    // Array para almacenar los elementos seleccionados
    let arrayElementos = [];

// Manejador de eventos para los checkboxes
$('#tbl-servicios-calidad').on('click', '.checkbox-servicio', function() {
    let id_caracteristica_tipo = $(this).attr('servicio');
    let id_solicitud = $(this).attr('id_solicitud');
    let id_servicio = $(this).attr('id_servicio');
    let isChecked = $(this).is(':checked');

    if (isChecked) {
        // Agregar el elemento al objeto de elementos seleccionados con la clave "id_caracteristica_tipo" 
        // y un objeto con "id_solicitud" y "id_servicio" como valores
        elementosSeleccionados[id_caracteristica_tipo] = {
            id_solicitud: id_solicitud,
            id_servicio: id_servicio
        };
    } else {
        // Eliminar la entrada del objeto de elementos seleccionados basándose en el valor de id_caracteristica_tipo
        delete elementosSeleccionados[id_caracteristica_tipo];
    }

    // Convertir el objeto a un array de objetos con la estructura deseada
    arrayElementos = [];
    for (let id in elementosSeleccionados) {
        arrayElementos.push({
            id_solicitud: elementosSeleccionados[id].id_solicitud,
            id_servicio: elementosSeleccionados[id].id_servicio
        });
    }

    // Imprimir el array de elementos en la consola para verificar
    console.log(arrayElementos);
});


    // Manejador de eventos para el botón de asignar servicio
    $('#btnAsignarServicio').on('click', function () {
        // Muestra el modal de asignación de servicio
        $('#modalAsigSrv').modal();
    });

    // Manejador de eventos para el botón de envío del formulario de asignación
    $('#btn-submit-asignar').on('click', function (e) {
        e.preventDefault(e);

        // Crea el objeto de datos a enviar
        let data = {
            array: arrayElementos,
            id_usuario_calidad: $('#id_usuario_calidad').val(),
            //prioridad: $('#prioridad').val(),
        }

        console.log(data);

        $.ajax({
            method: "PUT",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/servicio/asig-usr-masivo`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Servicio', 'Servicio asignado satisfactoriamente');
                    cargarTablaSolicitudesCalidad();
                    $('#formAsigSrv')[0].reset();
                    $('#modalAsigSrv').modal('hide')
                    elementosSeleccionados = {};
                    arrayElementos = [];
                } else {
                    alertSwal('error', 'Servicio', r.code.code);
                    cargarTablaSolicitudesCalidad();
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
    });


});//Document Ready


function cargarTablaSolicitudesCalidad() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/servicio/asignar-lista`),
        dataType: "json",
        success: function (r) {

            $('#tbl-servicios-calidad').DataTable().clear();
            $('#tbl-servicios-calidad').DataTable().destroy();

            let t = $('#tbl-servicios-calidad').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "desc"],
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Servicios en Calidad',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((ser) => {

                    t.row.add([
                        ser.id,
                        ser.cliente,
                        ser.candidato,
                        ser.doc_candidato,
                        ser.nom_servicio,
                        ser.estado_desc,
                        ser.estado_proceso_desc,
                        `<center><input type="checkbox" class="checkbox-servicio" servicio="${ser.id}" id_solicitud="${ser.id_solicitud}" id_servicio="${ser.id_servicio}"></center>`

                    ]);
                });
            };

            t.draw();
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    }).done(function () {
        hideModalLoading();
    });

}
