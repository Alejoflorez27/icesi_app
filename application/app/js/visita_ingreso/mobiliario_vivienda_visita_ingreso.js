$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_mobil_electro`),
        input: [{
            id: 'mobiliario_electro',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Tipo de elementos',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_mobil_electro`),
        input: [{
            id: 'mobiliario_electro_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Tipo de elementos',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })


    $('#mobiliario_electro').on('change', function () {
        let mobiliario_electro = $('#mobiliario_electro').val();
        
        if (mobiliario_electro === 'A') {
            console.log(mobiliario_electro);
            // Cargar la lista de los Tipos de elementos mobiliarios
            loadSelectOption({
                url: url_site(`api/configuracion/tipo_elementos_mobiliario`),
                input: [{
                    id: 'tipo_elemento',
                    clearOptions: true,
                    emptyText: 'Tipo de Mobiliario',
                    selectedValue: ''
                }],
                columnKey: 'codigo',
                columnDescription: 'descripcion',  
                responsePath: ''
            });
        } else if (mobiliario_electro === 'B') {
            console.log(mobiliario_electro);
            // Cargar la lista de los Tipos de elementos electrodomesticos
            loadSelectOption({
                url: url_site(`api/configuracion/tipo_elementos_electrodomestico`),
                input: [{
                    id: 'tipo_elemento',
                    clearOptions: true,
                    emptyText: 'Tipo de Electrodoméstico',
                    selectedValue: ''
                }],
                columnKey: 'codigo',
                columnDescription: 'descripcion',  
                responsePath: ''
            });
        }
    });
    


    //loadSelectOption para cargar la lista de los Tipos de estado mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/estado_dotacion`),
        input: [{
            id: 'estado_mobiliario',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Tipo de estado',
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
            id: 'tenencia_mobiliario',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'La tenencia',
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
    cargarTablaVivMobiliario();

    //envio de Accion POST
   $('.btnAddVivMobiliario').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditMobiliario').on('click', function () {
        $('#formVivMobiliario')[0].reset();
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
   
        window.location = url_site(`electrodomesticosVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

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
    
    // Crear Mobiliario de la vivienda
    $('#btn-submit-vivMobiliario').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivMobiliario()) {

            let method = $('#accion').val();
            let data = {
                id_mobiliario: $('#id_mobiliario').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                tipo_elemento: $('#tipo_elemento').val(),
                cantidad: $('#cantidad').val(),
                estado_mobiliario: $('#estado_mobiliario').val(),
                tenencia_mobiliario: $('#tenencia_mobiliario').val(),
                mobiliario_electro: $('#mobiliario_electro').val(),
            }


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
                        alertSwal('success', 'Mobiliario', 'Espacio de vivienda guardado satisfactoriamente');
                        cargarTablaVivMobiliario();
                        $('#formVivMobiliario')[0].reset();
                        //window.location = url_site(`sectorVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_mobil_electro`),
                            input: [{
                                id: 'mobiliario_electro',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Tipo de elementos',
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
                                id: 'estado_mobiliario',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Tipo de estado',
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
                                id: 'tenencia_mobiliario',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'La tenencia',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        })
                        
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_elementos_mobiliario`),
                            input: [{
                                id: 'tipo_elemento',
                                clearOptions: true,
                                emptyText: 'Tipo de Mobiliario',
                                selectedValue: ''
                            }],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        });
                        
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_elementos_electrodomestico`),
                            input: [{
                                id: 'tipo_elemento',
                                clearOptions: true,
                                emptyText: 'Tipo de Electrodoméstico',
                                selectedValue: ''
                            }],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        });
                    } else {
                        alertSwal('error', 'Mobiliario de la vivienda', r.code.code);
                        cargarTablaVivMobiliario();
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
    });// Fin de Crear Distribucion de la vivienda


    //editar Distribucion de la vivienda
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
    //fin de editar Distribucion de la vivienda 
    
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
                        cargarTablaVivMobiliario();
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
                        cargarTablaVivMobiliario();
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

}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear la mobiliaria
function validateFormVivMobiliario() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#mobiliario_electro').val() == "" || $('#mobiliario_electro').val() == null) {
        alertSwal('error', 'mobiliario_electro', 'Este campo es obligatorio');
        $("#mobiliario_electro").focus();
        return false;
    }
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
    if ($('#estado_mobiliario').val() == "" || $('#estado_mobiliario').val() == null) {
        alertSwal('error', 'Estado del Mobiliario', 'Este campo es obligatorio');
        $("#estado_mobiliario").focus();
        return false;
    }
    if ($('#tenencia_mobiliario').val() == "" || $('#tenencia_mobiliario').val() == null) {
        alertSwal('error', 'Tenencia', 'Este campo es obligatorio');
        $("#tenencia_mobiliario").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la distribucion de la vivienda

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
function cargarTablaVivMobiliario() {
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
        url: url_site(`api/vivmobiliario/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
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
//Fin de la tabla de la distribucion de vivienda

