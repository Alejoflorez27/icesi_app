$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_elementos_electrodomestico`),
        input: [{
            id: 'tipo_elemento',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de elementos',
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
            id: 'estado_electrodomestico',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de estado',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de tenencia mobiliario
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tenencia_dotacion`),
        input: [{
            id: 'tenencia_electrodomestico',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione la tenencia',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_elementos_electrodomestico`),
        input: [{
            id: 'tipo_elementoelectro_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de elementos',
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
            id: 'estado_electrodomestico_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de estado',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de tenencia mobiliario
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tenencia_dotacion`),
        input: [{
            id: 'tenencia_electrodomestico_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione la tenencia',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //Cargar la tabla de los electrodomesticos de la vivienda
    cargarTablaVivElectrodomesticos();

    //envio de Accion POST
   $('.btnAddVivElectrodomestico').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditElectrodomestico').on('click', function () {
        $('#formVivElectrodomestico')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    //let id_servicioC = "3";
       
    // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
        //sectorVivienda_visita_ingreso
        checkDistribucion(id_solicitudC, id_servicioC);
        //window.location = url_site(`sectorVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    async function checkDistribucion(id_solicitudC, id_servicioC) {
        try {
            const response = await fetch(url_site(`api/vivdistribucion/lista?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`), {
                headers: {
                    "access-token": getToken()
                },
                method: "GET",
                dataType: "json"
            });
    
            const data = await response.json();
    
            if (response.status === 200 && data.status === "success") {
                const distribucionesSinEspacio = [];
    
                for (const sol of data.data) {
                    const mobiliarioResponse = await fetch(url_site(`api/vivmobiliario/lista?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_distribucion=${sol.id_distribucion}`), {
                        headers: {
                            "access-token": getToken()
                        },
                        method: "GET",
                        dataType: "json"
                    });
    
                    const mobiliarioData = await mobiliarioResponse.json();
    
                    let contar1 = 0;
    
                    if (mobiliarioResponse.status === 200 && mobiliarioData.status === "success") {
                        contar1 = mobiliarioData.data.length;
    
                        if (contar1 === 0) {
                            distribucionesSinEspacio.push(sol.id_distribucion);
                        }
                    }
                }
    
                if (distribucionesSinEspacio.length > 0) {
                    $.ajax({
                        headers: {
                            "access-token": getToken()
                        },
                        type: "GET",
                        url: url_site(`api/vivdistribucion?id_distribucion=${distribucionesSinEspacio}`),
                        dataType: "json",
                        success: function (resp) {

                            Swal.fire(
                                'Falta agregar el mobiliario del siguiente espacio de '+resp.data.descripcion_tipo_distribucion,
                                ' dar Clic en el boton de Mobiliario',
                                'error'
                              ).then((result) => {
                                if (result.isConfirmed) {
                                }
            
                            }) 
                            //console.log("Falta agregar espacio en las siguientes distribuciones:", resp.data.descripcion_tipo_distribucion);
                        }
                    })
                    //console.log("Falta agregar espacio en las siguientes distribuciones:", distribucionesSinEspacio);
                } else {
                    // Realiza la acción deseada cuando todos los espacios están completos
                    window.location = url_site(`sectorVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                }
            }
        } catch (error) {
            //alertSwal('error', 'Error al cargar los datos.', error);
        } finally {
            hideModalLoading();
        }
    }

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`caracteristicaVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
    
    // Crear Electrodomesticos de la vivienda
    $('#btn-submit-vivElectrodomestico').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivElectrodomestico()) {

            let method = $('#accion').val();
            let data = {
                id_electrodomestico: $('#id_electrodomestico').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                tipo_elemento: $('#tipo_elemento').val(),
                cantidad: $('#cantidad').val(),
                estado_electrodomestico: $('#estado_electrodomestico').val(),
                tenencia_electrodomestico: $('#tenencia_electrodomestico').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivelectrodomesticos?id_electrodomestico=${data.id_electrodomestico}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Electrodomestico', 'vivienda guardado satisfactoriamente');
                        cargarTablaVivElectrodomesticos();
                        $('#formVivElectrodomestico')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                        //loadSelectOption para cargar la lista de los Tipos de elementos electrodomestico
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_elementos_electrodomestico`),
                            input: [{
                                id: 'tipo_elemento',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione un tipo de elementos',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        })

                        //loadSelectOption para cargar la lista de los Tipos de estado electrodomestico
                        loadSelectOption({
                            url: url_site(`api/configuracion/estado_dotacion`),
                            input: [{
                                id: 'estado_electrodomestico',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione un tipo de estado',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        })

                        //loadSelectOption para cargar la lista de los Tipos de tenencia electrodomestico
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_tenencia_dotacion`),
                            input: [{
                                id: 'tenencia_electrodomestico',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione la tenencia',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        })
                    } else {
                        //alertSwal('error', 'Electrodomestico de la vivienda', r.code.code);
                        cargarTablaVivElectrodomesticos();
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
    });// Fin de Crear Electrodomesticos de la vivienda


    //editar Electrodomesticos de la vivienda
    $('#tbl-vivElectrodomestico').on('click', '.btnEditVivElectrodomestico', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_electrodomestico = $(this).attr('id_electrodomestico');
        //console.log(id_electrodomestico);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivelectrodomesticos?id_electrodomestico=${id_electrodomestico}`),
            dataType: "json",
            success: function (resp) {
                $('#id_electrodomestico').val(resp.data.id_electrodomestico);
                $('#tipo_elementoelectro_edit').val(resp.data.tipo_elemento);
                $('#cantidadelectro_edit').val(resp.data.cantidad);
                $('#estado_electrodomestico_edit').val(resp.data.estado_electrodomestico);
                $('#tenencia_electrodomestico_edit').val(resp.data.tenencia_electrodomestico);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivElectrodomestico').modal();
    })
    //fin de editar Electrodomesticos de la vivienda 
    
   $('#btn-submit-vivEditElectrodomestico').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivElectrodomesticoEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
                        
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_electrodomestico: $('#id_electrodomestico').val(),
                tipo_elemento: $('#tipo_elementoelectro_edit').val(),
                cantidad: $('#cantidadelectro_edit').val(),
                estado_electrodomestico: $('#estado_electrodomestico_edit').val(),
                tenencia_electrodomestico: $('#tenencia_electrodomestico_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivelectrodomesticos/update_electrodomestico?id_electrodomestico=${data.id_electrodomestico}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Electrodomesticos',
                        'La Electrodomesticos de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaVivElectrodomesticos();
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
    $("#tbl-vivElectrodomestico").on("click", ".btnEliminarVivElectrodomestico", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivElectrodomestico").on("click", ".btnEliminarVivElectrodomestico", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_electrodomesticoC = $(this).attr('id_electrodomestico');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_electrodomestico: id_electrodomesticoC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivelectrodomesticos/delete_electrodomestico?id_electrodomestico=${data.id_electrodomestico}`), //Se le da el id_electrodomestico de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Electrodomestico',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        cargarTablaVivElectrodomesticos();
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

//Funcion de Validar los campos de Crear los electrodomesticos
function validateFormVivElectrodomestico() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_elemento').val() == "" || $('#tipo_elemento').val() == null) {
        alertSwal('error', 'Tipo de Elemento', 'Este campo es obligatorio');
        $("#tipo_elemento").focus();
        return false;
    }
    if ($('#cantidad').val() == "" || $('#cantidad').val() == null) {
        alertSwal('error', 'Cantidad', 'Este campo es obligatorio');
        $("#cantidad").focus();
        return false;
    }
    if ($('#estado_electrodomestico').val() == "" || $('#estado_electrodomestico').val() == null) {
        alertSwal('error', 'Estado del Mobiliario', 'Este campo es obligatorio');
        $("#estado_electrodomestico").focus();
        return false;
    }
    if ($('#tenencia_electrodomestico').val() == "" || $('#tenencia_electrodomestico').val() == null) {
        alertSwal('error', 'Tenencia', 'Este campo es obligatorio');
        $("#tenencia_electrodomestico").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la electrodomesticos de la vivienda

//Funcion de Validar los campos de Editar los electrodomesticos de la vivienda
function validateFormVivElectrodomesticoEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_elementoelectro_edit').val() == "" || $('#tipo_elementoelectro_edit').val() == null) {
        alertSwal('error', 'Tipo de Elemento', 'Este campo es obligatorio');
        $("#tipo_elementoelectro_edit").focus();
        return false;
    }
    if ($('#cantidadelectro_edit').val() == "" || $('#cantidadelectro_edit').val() == null) {
        alertSwal('error', 'Cantidad', 'Este campo es obligatorio');
        $("#cantidadelectro_edit").focus();
        return false;
    }
    if ($('#estado_electrodomestico_edit').val() == "" || $('#estado_electrodomestico_edit').val() == null) {
        alertSwal('error', 'Estado del Mobiliario', 'Este campo es obligatorio');
        $("#estado_electrodomestico_edit").focus();
        return false;
    }
    if ($('#tenencia_electrodomestico_edit').val() == "" || $('#tenencia_electrodomestico_edit').val() == null) {
        alertSwal('error', 'Tenencia', 'Este campo es obligatorio');
        $("#tenencia_electrodomestico_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Editar la electrodomesticos


//Cargar datos de electrodomesticos de vivienda
function cargarTablaVivElectrodomesticos() {
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivelectrodomesticos/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivElectrodomestico').DataTable().clear();
            $('#tbl-vivElectrodomestico').DataTable().destroy();

            let t = $('#tbl-vivElectrodomestico').DataTable({
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
                        //sol.id_electrodomestico,
                        contador++,
                        sol.descripcion_tipo_elemento,
                        sol.cantidad,
                        sol.descripcion_estado_electrodomestico,
                        sol.descripcion_tenencia_electrodomestico,
                        `<button class="btn btn-xs btn-warning btnEditVivElectrodomestico" id_electrodomestico="${sol.id_electrodomestico}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <br><br><button class="btn btn-xs btn-danger btnEliminarVivElectrodomestico" id_electrodomestico=${sol.id_electrodomestico}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de los electrodomesticos de la vivienda

