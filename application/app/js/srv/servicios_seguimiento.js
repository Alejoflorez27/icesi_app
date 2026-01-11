/*$(function () {
    // Ocultar filtros dependiendo del perfil

    var perfil_campo = document.getElementById('accion_perfil');
    var username = document.getElementById('username');
    console.log(perfil_campo.value);
})*/

$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado

    $("body").addClass("sidebar-collapse");
        var username = document.getElementById('accion_candidato');
        
    var perfil_campo = document.getElementById('accion_perfil');

    //var estado_servicio = document.getElementById('estado_servicio');
    
    console.log(perfil_campo);
    console.log(username.value);
    //console.log(estado_servicio);

    var id_usuario_calidad = '';
    var perfil = '';
    var estado_servicio = '';

    if (perfil_campo.value == 10 || perfil_campo.value == 11 || perfil_campo.value == 15 || perfil_campo.value == 16 || perfil_campo.value == 13) {
        //carga la lista de perfiles INTERNOS
        loadSelectOption({
            url: url_site(`api/perfil/asig-perfiles-servicios`), 
            input: [{  
                id: 'perfil',
                clearOptions: false,
                emptyText: '--Seleccione uno --',
                selectedValue: perfil_campo.value
            },],
            columnKey: 'id',
            columnDescription: 'descripcion',
            responsePath: 'data'
        })
        $('#perfil').change(function() {
            //var perfil = $('#perfil').val();
            //console.log(perfil);
            loadSelectOption({
                url: url_site(`api/servicio/usuarios-asignacion?perfil=${perfil_campo.value}`),
                input: [{
                    id: 'id_usuario_calidad',
                    clearOptions: true,
                    emptyText: 'Todos',
                    selectedValue: username.value
                },],
                columnKey: 'username',
                columnDescription: 'nombre',
                responsePath: 'data'
            })
        });

        //carga la lista de estados servicios
        loadSelectOption({
            url: url_site(`api/configuracion/estado_proceso?categoria=${'estado_servicios'}`), 
            input: [{  
                id: 'estado_servicio',
                clearOptions: true,
                emptyText: '--Seleccione uno --',
                selectedValue: ''
            },],
            columnKey: 'codigo',
            columnDescription: 'descripcion',
            responsePath: 'data'
        })

        cargarTablaSolicitudesCalidad(username.value, perfil_campo.value, estado_servicio);
        $("#ocultar").hide();
        $("#provider-count-container").hide();


    } else {
            //carga la lista de perfiles INTERNOS
            loadSelectOption({
                url: url_site(`api/perfil/asig-perfiles-servicios`), 
                input: [{  
                    id: 'perfil',
                    clearOptions: true,
                    emptyText: '--Seleccione uno --',
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
                        emptyText: '--Seleccione uno --',
                        selectedValue: ''
                    },],
                    columnKey: 'username',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })
            });

            //carga la lista de estados servicios
            loadSelectOption({
                url: url_site(`api/configuracion/estado_proceso?categoria=${'estado_servicios'}`), 
                input: [{  
                    id: 'estado_servicio',
                    clearOptions: true,
                    emptyText: '--Seleccione uno --',
                    selectedValue: ''
                },],
                columnKey: 'codigo',
                columnDescription: 'descripcion',
                responsePath: 'data'
            })

        cargarTablaSolicitudesCalidad(id_usuario_calidad, perfil, estado_servicio);
        $("#ocultar").show();
    }



    // Manejador de eventos para el botón de asignar servicio
    $('.btnBuscar').on('click', function () {
        var id_usuario_calidad= $('#id_usuario_calidad').val();
        var perfil= $('#perfil').val();
        var estado_servicio= $('#estado_servicio').val();
        console.log(id_usuario_calidad);
        cargarTablaSolicitudesCalidad(id_usuario_calidad, perfil, estado_servicio);
    });


});//Document Ready

function toggleProviderCount() {
    const providerList = document.getElementById("provider-count");
    const toggleButton = document.getElementById("toggle-button");

    if (providerList.style.display === "none") {
        providerList.style.display = "block";
        toggleButton.textContent = "Contador de Proveedores: Ocultar";
    } else {
        providerList.style.display = "none";
        toggleButton.textContent = "Contador de Proveedores: Dar click";
    }
}

// Inicia el contador como colapsado
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("provider-count").style.display = "none";
});



function cargarTablaSolicitudesCalidad(username_asig, perfil, estado_servicio) {
    showModalLoading();
        if (estado_servicio == null) {
        estado_servicio = '';
    }
    if (username_asig == null) {
        username_asig = '';
    }
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/servicio/seguimiento-lista?username_asig=${username_asig}&perfil=${perfil}&estado_servicio=${estado_servicio}`),
        dataType: "json",
        success: function (r) {
            $('#tbl-servicios-calidad').DataTable().clear();
            $('#tbl-servicios-calidad').DataTable().destroy();

            let t = $('#tbl-servicios-calidad').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                stateSave: true, // ← esto guarda el estado del datatable (paginación, búsqueda, número de registros, etc.)
                order: [
                    [0, "desc"],
                ],
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Servicios en Seguimiento',
                }],
            });


            if (r.status == "success") {
                let providerCount = {};

                r.data.forEach((ser) => {
                    //console.log(ser)
                    // Incrementa el contador por proveedor
                    const provider = ser.usuario_asig.trim() === "" ? "Servicios sin asignar" : ser.usuario_asig;
                    providerCount[provider] = (providerCount[provider] || 0) + 1;

                    // Agrega la fila a la tabla
                    t.row.add([
                        ser.id,
                        ser.usuario_asig,
                        ser.prioridad,
                        ser.cliente,
                        ser.candidato,
                        ser.doc_candidato,
                        ser.nom_servicio,
                        ser.observacion_finalizacion,
                        ser.estado_desc,
                        ser.estado_proceso_desc,
                        ser.fch_solicitud,
                        ser.fch_estimada_sol,
                        `<a href="/solicitud/detalle?solicitud=${ser.id_solicitud}&cliente=${ser.id_empresa}" 
                            target="_blank" 
                            style="display: inline-block; padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none;">
                            Ver Detalle
                        </a>`
                    ]);
                    
                });

                // Muestra el contador en el HTML de forma legible para el usuario
                let providerList = $('#provider-count');
                providerList.empty(); // Vacía la lista si hay datos previos

                // Añade cada proveedor y su contador a la lista con colores y estilos mejorados
                for (let provider in providerCount) {
                    let colorClass = provider === "Servicios sin asignar" ? "no-provider" : "provider";
                    providerList.append(`<li class="${colorClass}"><strong>${provider}:</strong> ${providerCount[provider]} servicios</li>`);
                }
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
// Delegar evento de clic a los botones generados dinámicamente
$(document).on("click", ".btn-redirigir", function() {
    let id = $(this).data("id");
    window.location = url_site(`solicitud/detalle?solicitud=${id}&cliente=`)
});

