$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tiempo_estadia`),
        input: [{
            id: 'Tiempo_estadia',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione el tiempo que reside en la vivienda',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tiempo_estadia`),
        input: [{
            id: 'Tiempo_estadia_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione el tiempo que reside en la vivienda',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    //Cargar la tabla de la formacion academica
    cargarTablaVivAnteriores();

    //envio de Accion POST
   $('.btnAddFormacion').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-formacionn').on('click', function () {
        $('#formVivAnterior')[0].reset();
        $('#accion').val("PUT");
    });




    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');       
    // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`dimensionSocial_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`sectorVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    $('#btn-submit-solicitud').on('click',function () {
    //  e.preventDefault();
    //  alert("1");
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            method: 'GET',
            url: url_site(`api/adjuntos/cliente_solicitud?id_solicitud=${id_solicitudC}`),
            dataType: "json",
            success: function (r) {

                if (r.status == "success") {

                    window.location = url_site(`solicitud/detalle?solicitud=${id_solicitudC}&cliente=${r.data[0].id_empresa}`)
                } 
            }
        })

    });
    
    // Crear Viviendas Anteriores
    $('#btn-submit-formacion').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivAnteriores()) {

            let method = $('#accion').val();
            let data = {
                id_viv_anterior: $('#id_viv_anterior').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                ubicacion: $('#ubicacion').val(),
                Tiempo_estadia: $('#Tiempo_estadia').val(),
                motivo_cambio: $('#motivo_cambio').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivAnteriores?id_viv_anterior=${data.id_viv_anterior}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Formación', 'Formación guardado satisfactoriamente');
                        cargarTablaVivAnteriores();
                        $('#formVivAnterior')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                            //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
                            loadSelectOption({
                                url: url_site(`api/configuracion/tipo_tiempo_estadia`),
                                input: [{
                                    id: 'Tiempo_estadia',                      //Nombre del campo en HTML
                                    clearOptions: true,
                                    emptyText: 'Seleccione el tiempo que reside en la vivienda',
                                    selectedValue: ''
                                },
                                ],
                                columnKey: 'codigo',
                                columnDescription: 'descripcion',  
                                responsePath: ''
                            })
                    } else {
                        alertSwal('error', 'Formación', r.code.code);
                        cargarTablaVivAnteriores();
                    }
                },
                error: function (xhr, status, error) {
                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }
    });// Fin de Viviendas Anteriores


    //editar viviendas anteriores
    $('#tbl-vivAnteriores').on('click', '.btnEditVivAnteriores', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_viv_anterior = $(this).attr('id_viv_anterior');
        //console.log(id_viv_anterior);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivAnteriores?id_viv_anterior=${id_viv_anterior}`),
            dataType: "json",
            success: function (resp) {
                $('#id_viv_anterior').val(resp.data.id_viv_anterior);
                $('#ubicacion_edit').val(resp.data.ubicacion);
                $('#Tiempo_estadia_edit').val(resp.data.Tiempo_estadia);
                $('#motivo_cambio_edit').val(resp.data.motivo_cambio);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivAnterior').modal();
    })
    //fin editar viviendas anteriores
    
    $('#btn-submit-vivEditVivAnteriores').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivAnterioresEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
                        
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_viv_anterior: $('#id_viv_anterior').val(),
                ubicacion: $('#ubicacion_edit').val(),
                Tiempo_estadia: $('#Tiempo_estadia_edit').val(),
                motivo_cambio: $('#motivo_cambio_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivAnteriores/update_viv_anteriores?id_viv_anterior=${data.id_viv_anterior}`), //Se le da el id_candidato de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Vivienda Anterior',
                        'La Vivienda Anterior ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaVivAnteriores();
                    })
  
                },
                error: function (xhr, status, error) {
                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }   
    })

    //accion delete para las viviendas anteriores
    $("#tbl-vivAnteriores").on("click", ".btnEliminarVivAnteriores", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    // Función de eliminar viviendas anteriores
    $("#tbl-vivAnteriores").on("click", ".btnEliminarVivAnteriores", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_viv_anteriorC = $(this).attr('id_viv_anterior');   // Se obtiene el id a eliminar

        let data = { id_viv_anterior: id_viv_anteriorC };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la vivienda anterior de forma permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Solo si confirma, se realiza la eliminación
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/vivAnteriores/delete_viv_anteriores?id_viv_anterior=${data.id_viv_anterior}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'La vivienda anterior ha sido eliminada correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaVivAnteriores();
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar la vivienda anterior.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
            }
        });
    });


}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear las viviendas anteriores
function validateFormVivAnteriores() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#ubicacion').val() == "" || $('#ubicacion').val() == null) {
        alertSwal('error', 'ubicacion', 'Este campo es obligatorio');
        $("#ubicacion").focus();
        return false;
    }
    if ($('#Tiempo_estadia').val() == "" || $('#Tiempo_estadia').val() == null) {
        alertSwal('error', 'Tiempo Estadia', 'Este campo es obligatorio');
        $("#Tiempo_estadia").focus();
        return false;
    }
    if ($('#motivo_cambio').val() == "" || $('#motivo_cambio').val() == null) {
        alertSwal('error', 'Motivo Cambio', 'Este campo es obligatorio');
        $("#motivo_cambio").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear las viviendas anteriores

//Funcion de Validar los campos de Editar las viviendas anteriores
function validateFormVivAnterioresEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#ubicacion_edit').val() == "" || $('#ubicacion_edit').val() == null) {
        alertSwal('error', 'ubicacion_edit', 'Este campo es obligatorio');
        $("#ubicacion_edit").focus();
        return false;
    }
    if ($('#Tiempo_estadia_edit').val() == "" || $('#Tiempo_estadia_edit').val() == null) {
        alertSwal('error', 'Tiempo Estadia', 'Este campo es obligatorio');
        $("#Tiempo_estadia_edit").focus();
        return false;
    }
    if ($('#motivo_cambio_edit').val() == "" || $('#motivo_cambio_edit').val() == null) {
        alertSwal('error', 'Motivo Cambio', 'Este campo es obligatorio');
        $("#motivo_cambio_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Editar las viviendas anteriores


//Cargar datos de las viviendas anteriores
function cargarTablaVivAnteriores() {
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivAnteriores/lista_visitas?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivAnteriores').DataTable().clear();
            $('#tbl-vivAnteriores').DataTable().destroy();

            let t = $('#tbl-vivAnteriores').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "asc"],
                ],
                //dom: 'Bfrtip',
                /*buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Viviendas anteriores',
                }],*/
            });

            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {

                    t.row.add([
                        //sol.id_viv_anterior,
                        contador++,
                        sol.ubicacion,
                        sol.descripcion_tiempo_reside,
                        sol.motivo_cambio,
                        `<button class="btn btn-xs btn-warning btnEditVivAnteriores" id_viv_anterior="${sol.id_viv_anterior}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivAnteriores" id_viv_anterior=${sol.id_viv_anterior}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de los datos de las viviendas anteriores

