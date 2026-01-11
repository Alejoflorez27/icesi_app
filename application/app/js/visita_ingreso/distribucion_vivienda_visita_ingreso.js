$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_espacios`),
        input: [{
            id: 'tipo_espacio',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Tipo de espacio',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de estado de los espacios de vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_estado_espacios`),
        input: [{
            id: 'estado_espacio',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Estado de los espacios',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de estado de los espacios de vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_dotacion_mobiliaria`),
        input: [{
            id: 'dotacion_mobiliaria',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Dotación mobiliara',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_espacios`),
        input: [{
            id: 'tipo_espacio_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de espacio',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de estado de los espacios de vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_estado_espacios`),
        input: [{
            id: 'estado_espacio_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione el estado de los espacios',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de estado de los espacios de vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_dotacion_mobiliaria`),
        input: [{
            id: 'dotacion_mobiliaria_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Dotación mobiliara',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    // Cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_elementos_mobiliario`),
        input: [{
            id: 'tipo_elemento_edit',
            clearOptions: true,
            emptyText: 'Tipo de Mobiliario',
            selectedValue: ''
        }],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    });

    //loadSelectOption para cargar la lista de los Tipos de tenencia mobiliario
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tenencia_dotacion`),
        input: [{
            id: 'tenencia_mobiliario_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'La tenencia',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de estado mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/estado_dotacion`),
        input: [{
            id: 'estado_mobiliario_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de estado',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //Cargar la tabla de la distribucion de la vivienda
    cargarTablaVivDistribucion();

    //envio de Accion POST
   $('.btnAddVivDistribucion').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditDristribucion').on('click', function () {
        $('#formVivDistribucion')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');

    /* Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`mobiliarioVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`caracteristicaVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })*/
    
    // Crear Distribucion de la vivienda
    $('#btn-submit-vivDristribucion').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivDistribucion()) {

            let method = $('#accion').val();
            let data = {
                id_distribucion: $('#id_distribucion').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                tipo_espacio: $('#tipo_espacio').val(),
                numero_espacio: $('#numero_espacio').val(),
                estado_espacio: $('#estado_espacio').val(),
                dotacion_mobiliaria: $('#dotacion_mobiliaria').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivdistribucion?id_distribucion=${data.id_distribucion}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Distribución', 'Espacio de vivienda guardado satisfactoriamente');
                        cargarTablaVivDistribucion();
                        $('#formVivDistribucion')[0].reset();
                      //  $('#tipo_espacio').empty();
                        //$('#modalAddServicio').modal('hide')
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_espacios`),
                            input: [{
                                id: 'tipo_espacio',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Tipo de espacio',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        });

                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_estado_espacios`),
                            input: [{
                                id: 'estado_espacio',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Estado de los espacios',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        });
                    
                        //loadSelectOption para cargar la lista de los Tipos de estado de los espacios de vivienda
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_dotacion_mobiliaria`),
                            input: [{
                                id: 'dotacion_mobiliaria',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Dotación mobiliara',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        })
                    } else {
                        //alertSwal('error', 'Distribucion de la vivienda', r.code.code);
                        cargarTablaVivDistribucion();
                    }
                },
                error: function (xhr, status, error) {
                    //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }
    });// Fin de Crear Distribucion de la vivienda




// ##################################### Modal de Mobiliario ###############################################

    $('#tbl-vivDistribucion').on('click', '.btnMobiliario', function () {
        $('#formVivDistribucion')[0].reset();
        $('#accion').val("POST");
		
        let id_distribucion = $(this).attr('id_distribucion');
        let tipo_elemento = $(this).attr('tipo_elemento');
        console.log(tipo_elemento);

        switch (tipo_elemento) {
            case 'BAÑOS':
                $('#tipo_elemento_edit').val('BAT');
                break;
            case 'BALCÓN':
                $('#tipo_elemento_edit').val('MB');
                break;
            case 'COCINA':
                $('#tipo_elemento_edit').val('MC');
                break;
            case 'COMEDOR':
                $('#tipo_elemento_edit').val('MT');
                break;
            case 'DEPOSITO':
                $('#tipo_elemento_edit').val('MD');
                break;
            case 'ESTAR DE TELEVISIÓN':
                $('#tipo_elemento_edit').val('ME');
                break;
            case 'GARAJE':
                $('#tipo_elemento_edit').val('MG');
                break;
            case 'HABITACIONES':
                $('#tipo_elemento_edit').val('MH');
                break;
            case 'SALA':
                $('#tipo_elemento_edit').val('MS');
                break;
            case 'TERRAZA':
                $('#tipo_elemento_edit').val('MTE');
                break;
            case 'ZONA DE LAVANDERIA':
                $('#tipo_elemento_edit').val('ML');
                break;
            case 'ESTUDIO':
                $('#tipo_elemento_edit').val('MESTU');
                break;
            default:
                break;
        }
        //cargarTablaVivMobiliario(id_distribucion);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivdistribucion?id_distribucion=${id_distribucion}`),
            dataType: "json",
            success: function (resp) {
                $('#id_distribucion').val(resp.data.id_distribucion);

            }
        }).done(function () {
            hideModalLoading();
        });

        // Función para traer la verificación de cada estudio
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivmobiliario/lista?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_distribucion=${id_distribucion}`),
            dataType: "json",
            cache: false, // Evitar el almacenamiento en caché de la respuesta
            success: function (resp) {
                

                if (resp.data != "") {
                    //muestra si existe el registro
                    $('#id_mobiliario').val(resp.data[0].id_mobiliario);
                    $('#id_distribucion').val(resp.data[0].id_distribucion);
                    $('#tipo_elemento_edit').val(resp.data[0].codigo);
                    $('#cantidad_edit').val(resp.data[0].cantidad);
                    $('#estado_mobiliario_edit').val(resp.data[0].estado_mobiliario);
                    $('#tenencia_mobiliario_edit').val(resp.data[0].tenencia_mobiliario);
                    // Otras asignaciones de valores aquí
                    //console.log(resp.data[0].id_mobiliario);
                    // Configurar evento para actualizar la verificación existente
                    $('#btn-submit-vivEditMobiliario').off('click').on('click', function (e) {
                        e.preventDefault();
                        updateVerification();
                    });
                } else {
                    // Si no existe el registro, configurar evento para crear uno nuevo
                    $('#btn-submit-vivEditMobiliario').off('click').on('click', function (e) {
                        e.preventDefault();
                        createVerification();
                    });
                }
            }
        });
            $('#modalEditVivMobiliario').modal({backdrop: 'static', keyboard: false});
    });

    $('#modalEditVivMobiliario').on('hidden.bs.modal', function (e) {
        window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
    });
// ##################################### Modal de Mobiliario ###############################################

function updateVerification() {
    let data = {
        id_mobiliario: $('#id_mobiliario').val(),
        tipo_elemento: $('#tipo_elemento_edit').val(),
        cantidad: $('#cantidad_edit').val(),
        estado_mobiliario: $('#estado_mobiliario_edit').val(),
        tenencia_mobiliario: $('#tenencia_mobiliario_edit').val(),
    }
    //console.log(data);
    //let id_verificacion = $('#id_verificacion').val();

    $.ajax({
        method: "PUT",
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/vivmobiliario/update_mobiliario?id_mobiliario=${data.id_mobiliario}`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (resp) {
            alertSwal('success', 'Mobiliario', 'Actualizado satisfactoriamente')
            window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
        },
        error: function (xhr, status, error) {
            //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    });
}

function createVerification() {
    let data = {
        id_mobiliario: $('#id_mobiliario').val(),
        id_solicitud: id_solicitudC,
        id_servicio: id_servicioC,
        id_distribucion: $('#id_distribucion').val(),
        tipo_elemento: $('#tipo_elemento_edit').val(),
        cantidad: $('#cantidad_edit').val(),
        estado_mobiliario: $('#estado_mobiliario_edit').val(),
        tenencia_mobiliario: $('#tenencia_mobiliario_edit').val(),
    }

    $.ajax({
        method: "POST",
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/vivmobiliario?id_mobiliario=${data.id_mobiliario}`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (resp) {
            alertSwal('success', 'Mobiliario', 'Guardado satisfactoriamente');
            //$('#formFormacion')[0].reset();
            window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
        },
        error: function (xhr, status, error) {
            //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    });
}

// ################################## Modal de Mobiliario ##################################################

/*
    // Crear los mobiliarios por los espacios de distribucion
    $('#btn-submit-vivEditMobiliario').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivMobiliarioEdit()) {

            let method = $('#accion').val();
            let data = {
                id_mobiliario: $('#id_mobiliario_edit').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
				id_distribucion: $('#id_distribucion').val(),
                tipo_elemento: $('#tipo_elemento_edit').val(),
                cantidad: $('#cantidad_edit').val(),
                estado_mobiliario: $('#estado_mobiliario_edit').val(),
                tenencia_mobiliario: $('#tenencia_mobiliario_edit').val(),
                //mobiliario_electro: $('#mobiliario_electro').val(),
            }
            //console.log(data);

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivmobiliario?id_mobiliario=${data.id_mobiliario}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {

                        Swal.fire(
                            'Mobiliario',
                            'Espacio de vivienda guardado satisfactoriamente',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                $('#formVivDistribucion')[0].reset();
                                window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                cargarTablaVivMobiliario(id_distribucion);
                            }
                            
                        })


                    }
                },
                error: function (xhr, status, error) {
                    //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
                
            });
        }
    });




//######################################################################################


    //editar mobiliario de la vivienda
    $('#tbl-vivMobiliario').on('click', '.btnEditVivMobiliario', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_mobiliario = $(this).attr('id_mobiliario');
        //console.log(id_mobiliario);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivmobiliario?id_mobiliario=${id_mobiliario}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp);
                $('#id_mobiliario').val(resp.data.id_mobiliario);
                $('#mobiliario_electro_edit').val(resp.data.mobiliario_electro);
                $('#tipo_elemento_edit').val(resp.data.tipo_elemento);
                $('#cantidad_edit').val(resp.data.cantidad);
                $('#estado_mobiliario_edit').val(resp.data.estado_mobiliario);
                $('#tenencia_mobiliario_edit').val(resp.data.tenencia_mobiliario);

                var mobiliario_electro = resp.data.mobiliario_electro;
                
                if (mobiliario_electro === 'A') {
                    //console.log(mobiliario_electro);
                    // Cargar la lista de los Tipos de elementos mobiliarios
                    loadSelectOption({
                        url: url_site(`api/configuracion/tipo_elementos_mobiliario`),
                        input: [{
                            id: 'tipo_elemento_edit',
                            clearOptions: true,
                            emptyText: 'Tipo de Mobiliario',
                            selectedValue: resp.data.tipo_elemento
                        }],
                        columnKey: 'codigo',
                        columnDescription: 'descripcion',  
                        responsePath: ''
                    });
                } else if (mobiliario_electro === 'B') {
                    //console.log(mobiliario_electro);
                    // Cargar la lista de los Tipos de elementos electrodomesticos
                    loadSelectOption({
                        url: url_site(`api/configuracion/tipo_elementos_electrodomestico`),
                        input: [{
                            id: 'tipo_elemento_edit',
                            clearOptions: true,
                            emptyText: 'Tipo de Electrodoméstico',
                            selectedValue: resp.data.tipo_elemento
                        }],
                        columnKey: 'codigo',
                        columnDescription: 'descripcion',  
                        responsePath: ''
                    });
                }
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivMobiliario').modal();
    })
    //fin de editar mobiliario de la vivienda 
    
   $('#btn-submit-vivEditMobiliario').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivMobiliarioEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
                        
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_mobiliario: $('#id_mobiliario').val(),
                tipo_elemento: $('#tipo_elemento_edit').val(),
                cantidad: $('#cantidad_edit').val(),
                estado_mobiliario: $('#estado_mobiliario_edit').val(),
                tenencia_mobiliario: $('#tenencia_mobiliario_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivmobiliario/update_mobiliario?id_mobiliario=${data.id_mobiliario}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Mobiliario',
                        'La Mobiliario de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        //cargarTablaVivMobiliario();
                        window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                    })

                },
                error: function (xhr, status, error) {
                    //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }   
    })

    //accion delete
    $("#tbl-vivMobiliario").on("click", ".btnEliminarVivDistribucion", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivMobiliario").on("click", ".btnEliminarVivDistribucion", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_mobiliarioC = $(this).attr('id_mobiliario');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_mobiliario: id_mobiliarioC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivmobiliario/delete_mobiliario?id_mobiliario=${data.id_mobiliario}`), //Se le da el id_mobiliario de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Mobiliario',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        //cargarTablaVivMobiliario();
                        window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                    }

                }) 
                
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });

    })//Fin Funcion de eliminar

*/





    //editar Distribucion de la vivienda
    $('#tbl-vivDistribucion').on('click', '.btnEditVivDistribucion', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_distribucion = $(this).attr('id_distribucion');
        //console.log(id_distribucion);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivdistribucion?id_distribucion=${id_distribucion}`),
            dataType: "json",
            success: function (resp) {
                $('#id_distribucion').val(resp.data.id_distribucion);
                $('#tipo_espacio_edit').val(resp.data.tipo_espacio);
                $('#numero_espacio_edit').val(resp.data.numero_espacio);
                $('#estado_espacio_edit').val(resp.data.estado_espacio);
                $('#dotacion_mobiliaria_edit').val(resp.data.dotacion_mobiliaria);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivDistribucion').modal();
    })
    //fin de editar Distribucion de la vivienda 
    
   $('#btn-submit-vivEditDristribucion').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivDistribucionEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
                        
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_distribucion: $('#id_distribucion').val(),
                tipo_espacio: $('#tipo_espacio_edit').val(),
                numero_espacio: $('#numero_espacio_edit').val(),
                estado_espacio: $('#estado_espacio_edit').val(),
                dotacion_mobiliaria: $('#dotacion_mobiliaria_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivdistribucion/update_distribucion?id_distribucion=${data.id_distribucion}`), //Se le da el id_distribucion de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Distribucion',
                        'La Distribución de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaVivDistribucion();
                    })
  
                },
                error: function (xhr, status, error) {
                    //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                    hideModalLoading();
                }
            });
        }   
    })

    //accion delete
    $("#tbl-vivDistribucion").on("click", ".btnEliminarVivDistribucion", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivDistribucion").on("click", ".btnEliminarVivDistribucion", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_distribucionC = $(this).attr('id_distribucion');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_distribucion: id_distribucionC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivdistribucion/delete_distribucion?id_distribucion=${data.id_distribucion}`), //Se le da el id_distribucion de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Distribucion',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        cargarTablaVivDistribucion();
                    }

                }) 
                
            },
            error: function (xhr, status, error) {
                //alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });

    })//Fin Funcion de eliminar

}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear la formacion
function validateFormVivDistribucion() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_espacio').val() == "" || $('#tipo_espacio').val() == null) {
        alertSwal('error', 'Tipo de Espacio', 'Este campo es obligatorio');
        $("#tipo_espacio").focus();
        return false;
    }
    if ($('#numero_espacio').val() == "" || $('#numero_espacio').val() == null) {
        alertSwal('error', 'Número de espacios', 'Este campo es obligatorio');
        $("#numero_espacio").focus();
        return false;
    }
    if ($('#estado_espacio').val() == "" || $('#estado_espacio').val() == null) {
        alertSwal('error', 'Estado del Espacio', 'Este campo es obligatorio');
        $("#estado_espacio").focus();
        return false;
    }
    if ($('#dotacion_mobiliaria').val() == "" || $('#dotacion_mobiliaria').val() == null) {
        alertSwal('error', 'Dotación mobiliaria', 'Este campo es obligatorio');
        $("#dotacion_mobiliaria").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la distribucion de la vivienda

//Funcion de Validar los campos de Editar la distribucion de la vivienda
function validateFormVivDistribucionEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_espacio_edit').val() == "" || $('#tipo_espacio_edit').val() == null) {
        alertSwal('error', 'Tipo de Espacio', 'Este campo es obligatorio');
        $("#tipo_espacio_edit").focus();
        return false;
    }
    if ($('#numero_espacio_edit').val() == "" || $('#numero_espacio_edit').val() == null) {
        alertSwal('error', 'Número de espacios', 'Este campo es obligatorio');
        $("#numero_espacio_edit").focus();
        return false;
    }
    if ($('#estado_espacio_edit').val() == "" || $('#estado_espacio_edit').val() == null) {
        alertSwal('error', 'Estado del Espacio', 'Este campo es obligatorio');
        $("#estado_espacio_edit").focus();
        return false;
    }
    if ($('#dotacion_mobiliaria_edit').val() == "" || $('#dotacion_mobiliaria_edit').val() == null) {
        alertSwal('error', 'Dotación mobiliaria', 'Este campo es obligatorio');
        $("#dotacion_mobiliaria_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Editar la formacion

//Funcion de Validar los campos de Editar la mobiliaria de la vivienda
function validateFormVivMobiliarioEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_elemento_edit').val() == "" || $('#tipo_elemento_edit').val() == null) {
        alertSwal('error', 'Tipo de Elemento', 'Este campo es obligatorio');
        $("#tipo_elemento_edit").focus();
        return false;
    }
    if ($('#cantidad_edit').val() == "" || $('#cantidad_edit').val() == null) {
        alertSwal('error', 'Cantidad', 'Este campo es obligatorio');
        $("#cantidad_edit").focus();
        return false;
    }
    if ($('#estado_mobiliario_edit').val() == "" || $('#estado_mobiliario_edit').val() == null) {
        alertSwal('error', 'Estado del Mobiliario', 'Este campo es obligatorio');
        $("#estado_mobiliario_edit").focus();
        return false;
    }
    if ($('#tenencia_mobiliario_edit').val() == "" || $('#tenencia_mobiliario_edit').val() == null) {
        alertSwal('error', 'Tenencia', 'Este campo es obligatorio');
        $("#tenencia_mobiliario_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Editar la formacion

//Cargar datos de Distribucion de vivienda
function cargarTablaVivDistribucion() {
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    //let id_servicioC = "3";
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivdistribucion/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivDistribucion').DataTable().clear();
            $('#tbl-vivDistribucion').DataTable().destroy();

            let t = $('#tbl-vivDistribucion').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: false,
                order: [
                    [0, "asc"],
                ],
                //dom: 'Bfrtip',
                /*buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Estudios Academicos',
                }],*/
            });

            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {

                    t.row.add([
                        //sol.id_distribucion,
                        contador++,
                        sol.descripcion_tipo_espacios,
                        sol.numero_espacio,
                        sol.descripcion_estado_espacios,
                        sol.descripcion_dotacion_mob,
                        `<button class="btn btn-lg btn-primary btnMobiliario" id_distribucion="${sol.id_distribucion}" tipo_elemento="${sol.descripcion_tipo_espacios}"><i class="fa fa-pencil"  aria-hidden="true"></i> Mobiliario</button>`,
                        `<button class="btn btn-xs btn-warning btnEditVivDistribucion" id_distribucion="${sol.id_distribucion}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <br><br> <button class="btn btn-xs btn-danger btnEliminarVivDistribucion" id_distribucion=${sol.id_distribucion}><i class="fa fa-trash"></i> Eliminar</button>`,
                        sol.usr_create,
                        sol.fch_create
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
//Fin de la tabla de la distribucion de vivienda


//Cargar datos de Mobiliario de vivienda
function cargarTablaVivMobiliario(id_distribucion) {
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    //let id_servicioC = "4";

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivmobiliario/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}&id_distribucion=${id_distribucion}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivMobiliario').DataTable().clear();
            $('#tbl-vivMobiliario').DataTable().destroy();

            let t = $('#tbl-vivMobiliario').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: false,
                order: [
                    [0, "asc"],
                ],
                //dom: 'Bfrtip',
                /*buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Estudios Academicos',
                }],*/
            });

            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {

                    t.row.add([
                        //sol.id_mobiliario,
                        contador++,
                        sol.tipo_elemento,
                        sol.cantidad,
                        sol.des_estado_mobiliario,
                        sol.des_tipo_tenencia_dotacion,
                        `<button class="btn btn-xs btn-warning btnEditVivMobiliario" id_mobiliario="${sol.id_mobiliario}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivDistribucion" id_mobiliario=${sol.id_mobiliario}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de la Mobiliario de vivienda


