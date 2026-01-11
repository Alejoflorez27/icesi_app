$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    cargarTablaTotales();
    // Obtener el elemento que deseas ocultar el de otros tipos de pasivo
    const campoParaOcultar = document.getElementById("ocultar");
    // Ocultar el elemento cambiando su propiedad de estilo para la descripcion de el otros
    campoParaOcultar.style.display = "none";

    // Obtener el elemento que deseas ocultar el de otros tipos de pasivo par al dia y en mora
    const campoParaOcultarValor = document.getElementById("ocultar_valor");
    // Ocultar el elemento cambiando su propiedad de estilo para la descripcion de el otros
    campoParaOcultarValor.style.display = "none";

    // Obtener el elemento que deseas ocultar propietario de activo
    const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPas");
    // Ocultar el elemento cambiando su propiedad de estilo
    campoParaOcultarPropietario.style.display = "none";

    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_pasivo_vi`),
        input: [{
            id: 'concepto_pasivo',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })

    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_pasivo_vi`),
        input: [{
            id: 'concepto_pasivo_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })

    //loadSelectOption para cargar la lista de los Tipos de plazo pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
        input: [{
            id: 'tipo_familiar',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    

    //loadSelectOption para cargar la lista de los Tipos de responsable 
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
        input: [{
            id: 'tipo_familiar_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos plazo de pasivos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_plazo_pasivo_vi`),
        input: [{
            id: 'plazo_pasivo',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Plazo del pasivo',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    

    //loadSelectOption para cargar la lista de los Tipos plazo de pasivos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_plazo_pasivo_vi`),
        input: [{
            id: 'plazo_pasivo_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Plazo del pasivo',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

   //loadSelectOption para cargar la lista de los Tipos plazo de pasivos
   loadSelectOption({
    url: url_site(`api/configuracion/tipo_estado_obligacion`),
    input: [{
        id: 'estado_obligacion',                      //Nombre del campo en HTML
        clearOptions: true,
        emptyText: 'Seleccione estado de la obligación',
        selectedValue: ''
    },
    ],
    columnKey: 'codigo',
    columnDescription: 'descripcion',
    responsePath: ''
})

//loadSelectOption para cargar la lista de los Tipos plazo de pasivos
loadSelectOption({
    url: url_site(`api/configuracion/tipo_estado_obligacion`),
    input: [{
        id: 'estado_obligacion_edit',                      //Nombre del campo en HTML
        clearOptions: true,
        emptyText: 'Seleccione estado de la obligación',
        selectedValue: ''
    },
    ],
    columnKey: 'codigo',
    columnDescription: 'descripcion',
    responsePath: ''
})

    //Cargar la tabla de los pasivos de la vivienda
    cargarTablaVivPasivos();

    //envio de Accion POST
   $('.btnAddVivPasivos').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditPasivos').on('click', function () {
        $('#formVivPasivos')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
       
   /* // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`activos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })*/

    // Este metodo va en funcón de la selección del conncepto del pasivo
    $('#concepto_pasivo').on('change', function () {
        let concepto = $('#concepto_pasivo').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (concepto == 'J') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        } else {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });

    // Este metodo va en funcón de la selección del estado de la obligación del pasivo
    $('#estado_obligacion').on('change', function () {
        let estadoObligacion = $('#estado_obligacion').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        if (estadoObligacion == 'B') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar_valor");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        } else {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar_valor");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });

    //Otro propietario pasivo
    $('#tipo_familiar').on('change', function () {
        let propietario = $('#tipo_familiar').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (propietario);
        if (propietario == 'OTR') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPas");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPas");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "none";
        }
    });
    
    // Crear pasivos de la vivienda
    $('#btn-submit-vivPasivos').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivPasivos()) {

            let method = $('#accion').val();
            let data = {
                id_pasivo: $('#id_pasivo').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                concepto_pasivo: $('#concepto_pasivo').val(),
                otros: $('#otros').val(),
                tipo_familiar: $('#tipo_familiar').val(),
                otro_propietario: $('#otro_propietario_pas').val(),
                valor_pasivo: $('#valor_pasivo').val(),
                plazo_pasivo: $('#plazo_pasivo').val(),
                couta: $('#couta').val(),
                estado_obligacion: $('#estado_obligacion').val(),
                valor_mora: $('#valor_mora').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivpasivos?id_pasivo=${data.id_pasivo}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Pasivos', 'vivienda guardado satisfactoriamente');
                        //window.location = url_site(`pasivos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivPasivos();
                        $('#formVivPasivos')[0].reset();

                           //loadSelectOption para cargar la lista de los Tipos de pasivo
                           loadSelectOption({
                            url: url_site(`api/configuracion/tipo_pasivo_vi`),
                            input: [{
                                id: 'concepto_pasivo',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione un Concepto',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',
                            responsePath: '',
                        })

                        //loadSelectOption para cargar la lista de los Tipos de plazo pasivo
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
                            input: [{
                                id: 'tipo_familiar',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione familiar o funcionario',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',
                            responsePath: ''
                        })

                        //loadSelectOption para cargar la lista de los Tipos plazo de pasivos
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_plazo_pasivo_vi`),
                            input: [{
                                id: 'plazo_pasivo',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione un plazo pasivo',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',
                            responsePath: ''
                        })

                        //loadSelectOption para cargar la lista de los Tipos plazo de pasivos
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_estado_obligacion`),
                            input: [{
                                id: 'estado_obligacion',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione estado de la obligación',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',
                            responsePath: ''
                        })

                        // Obtener el elemento que deseas ocultar
                        const campoParaOcultar = document.getElementById("ocultar");
                        // Ocultar el elemento cambiando su propiedad de estilo
                        campoParaOcultar.style.display = "none";

                        // Obtener el elemento que deseas ocultar el de otros tipos de pasivo par al dia y en mora
                        const campoParaOcultarValor = document.getElementById("ocultar_valor");
                        // Ocultar el elemento cambiando su propiedad de estilo para la descripcion de el otros
                        campoParaOcultarValor.style.display = "none";

                        // Obtener el elemento que deseas ocultar propietario de activo
                        const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPas");
                        // Ocultar el elemento cambiando su propiedad de estilo
                        campoParaOcultarPropietario.style.display = "none";
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Pasivos de la vivienda', r.code.code);
                        cargarTablaVivPasivos();
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
    });// Fin de Crear pasivos de la vivienda


    //editar pasivos de la vivienda
    $('#tbl-vivPasivos').on('click', '.btnEditVivPasivos', function () {

        $('#accion').val("PUT");
        let id_pasivo = $(this).attr('id_pasivo');
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivpasivos?id_pasivo=${id_pasivo}`),
            dataType: "json",
            success: function (resp) {

                var otros = resp.data.concepto_pasivo;
                if (otros != 'J') {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultar = document.getElementById("ocultarEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultar.style.display = "none";
                } else {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultar = document.getElementById("ocultarEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultar.style.display = "block";
                }

                //console.log(resp.data.concepto_pasivo);
                var estadoObligacion = resp.data.estado_obligacion;
                if (estadoObligacion != 'B') {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultar = document.getElementById("ocultar_valor_edit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultar.style.display = "none";
                } else {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultar = document.getElementById("ocultar_valor_edit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultar.style.display = "block";
                }

                var concepto = resp.data.tipo_familiar      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                //console.log (concepto);
                if (concepto != 'OTR') {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPasEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultarPropietario.style.display = "none";
                }else{
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPasEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultarPropietario.style.display = "block";
                }

                $('#id_pasivo').val(resp.data.id_pasivo);
                $('#concepto_pasivo_edit').val(resp.data.concepto_pasivo);
                $('#otrosEdit').val(resp.data.otros);
                $('#tipo_familiar_edit').val(resp.data.tipo_familiar);
                $('#otro_propietario_pasEdit').val(resp.data.otro_propietario);
                $('#valor_pasivo_edit').val(resp.data.valor_pasivo);
                $('#plazo_pasivo_edit').val(resp.data.plazo_pasivo);
                $('#couta_edit').val(resp.data.couta);
                $('#estado_obligacion_edit').val(resp.data.estado_obligacion);
                $('#valor_mora_edit').val(resp.data.valor_mora);

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivPasivos').modal();
    })
    //fin de editar pasivos de la vivienda 
    
    //en caso que el modal en el capo de concepto de pasivo este en otros habilita el campo de otros
    $('#concepto_pasivo_edit').on('change', function () {
        let conceptoEdit = $('#concepto_pasivo_edit').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (conceptoEdit == 'J') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultarEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        } else {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultarEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });

    //en caso que el modal en el capo de estado de obligacion este en mora habilita el campo de valor
    $('#estado_obligacion_edit').on('change', function () {
        let estadoObligacion = $('#estado_obligacion_edit').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (estadoObligacion == 'B') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar_valor_edit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        } else {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar_valor_edit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });

    $('#tipo_familiar_edit').on('change', function () {
        let otro_propietarioEdit = $('#tipo_familiar_edit').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (otro_propietarioEdit == 'OTR') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPasEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioPasEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "none";
        }
    });
    

    $('#btn-submit-vivEditPasivos').on('click', function (e) {
        e.preventDefault();
        if (validateFormVivPasivosEdit()) {

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {
                id_pasivo: $('#id_pasivo').val(),
                id_solicitud: id_solicitudC,
                concepto_pasivo: $('#concepto_pasivo_edit').val(),
                otros: $('#otrosEdit').val(),
                tipo_familiar: $('#tipo_familiar_edit').val(),
                otro_propietario: $('#otro_propietario_pasEdit').val(),
                valor_pasivo: $('#valor_pasivo_edit').val(),
                plazo_pasivo: $('#plazo_pasivo_edit').val(),
                couta: $('#couta_edit').val(),
                estado_obligacion: $('#estado_obligacion_edit').val(),
                valor_mora: $('#valor_mora_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivpasivos/update_pasivos?id_pasivo=${data.id_pasivo}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Pasivos',
                        'La Pasivos de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            cargarTablaVivPasivos();
                            cargarTablaTotales();
                        }
                        //window.location = url_site(`pasivos_visita_mantenimiento?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)

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
    $("#tbl-vivPasivos").on("click", ".btnEliminarVivPasivos", function () {

        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivPasivos").on("click", ".btnEliminarVivPasivos", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_pasivoC = $(this).attr('id_pasivo');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_pasivo: id_pasivoC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivpasivos/delete_pasivos?id_pasivo=${data.id_pasivo}`), //Se le da el id_ingreso de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Pasivo',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        //window.location = url_site(`pasivos_visita_mantenimiento?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivPasivos();
                        cargarTablaTotales();
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

//Funcion de Validar los campos de Crear los pasivos
function validateFormVivPasivos() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_pasivo').val() == "" || $('#concepto_pasivo').val() == null) {
        alertSwal('error', 'concepto Pasivo', 'Este campo es obligatorio');
        $("#concepto_pasivo").focus();
        return false;
    }
    if ($('#tipo_familiar').val() == "" || $('#tipo_familiar').val() == null) {
        alertSwal('error', 'Responsable Pasivo', 'Este campo es obligatorio');
        $("#tipo_familiar").focus();
        return false;
    }
    if ($('#valor_pasivo').val() == "" || $('#valor_pasivo').val() == null) {
        alertSwal('error', 'Valor Pasivo', 'Este campo es obligatorio');
        $("#valor_pasivo").focus();
        return false;
    }
    if ($('#plazo_pasivo').val() == "" || $('#plazo_pasivo').val() == null) {
        alertSwal('error', 'Plazo Pasivo', 'Este campo es obligatorio');
        $("#plazo_pasivo").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Crear la pasivos de la vivienda

//Funcion de Validar los campos de Editar los pasivos de la vivienda
function validateFormVivPasivosEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_pasivo_edit').val() == "" || $('#concepto_pasivo_edit').val() == null) {
        alertSwal('error', 'concepto Pasivo', 'Este campo es obligatorio');
        $("#concepto_pasivo_edit").focus();
        return false;
    }
    if ($('#tipo_familiar_edit').val() == "" || $('#tipo_familiar_edit').val() == null) {
        alertSwal('error', 'Responsable Pasivo', 'Este campo es obligatorio');
        $("#tipo_familiar_edit").focus();
        return false;
    }
    if ($('#valor_pasivo_edit').val() == "" || $('#valor_pasivo_edit').val() == null) {
        alertSwal('error', 'Valor Pasivo', 'Este campo es obligatorio');
        $("#valor_pasivo_edit").focus();
        return false;
    }
    if ($('#plazo_pasivo_edit').val() == "" || $('#plazo_pasivo_edit').val() == null) {
        alertSwal('error', 'Plazo Pasivo', 'Este campo es obligatorio');
        $("#plazo_pasivo_edit").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Editar los egresos


//Cargar datos de pasivos de vivienda
function cargarTablaVivPasivos() {
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
        url: url_site(`api/vivpasivos/lista_vi?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivPasivos').DataTable().clear();
            $('#tbl-vivPasivos').DataTable().destroy();

            let t = $('#tbl-vivPasivos').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: false,
                order: [
                    [0, "asc"],
                ],
            });
            var total_pasivos = 0;
            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {
                    total_pasivos += parseInt(sol.valor_pasivo);
                    t.row.add([
                        //sol.id_pasivo,
                        contador++,
                        sol.descripcion_tipo_pasivo,
                        sol.otros,
                        sol.descripcion_tipo_responsable,
                        sol.otro_propietario,
                        '$ ' + (sol.valor_pasivo ? sol.valor_pasivo : '0'),
                        sol.descripcion_tipo_plazo,
                        '$ ' + (sol.couta ? sol.couta : '0'),
                        sol.descripcion_tipo_estado_obigacion,
                        '$ ' + (sol.valor_mora ? sol.valor_mora : '0'),
                        `<button class="btn btn-xs btn-warning btnEditVivPasivos" id_pasivo="${sol.id_pasivo}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivPasivos" id_pasivo=${sol.id_pasivo}><i class="fa fa-trash"></i> Eliminar</button>`,
                        sol.usr_create,
                        sol.fch_create
                    ]);
                });
                let h1Element = document.getElementById("total_pasivos"); // Obtener la referencia al elemento <h2>
                // Redondear a 0 decimales utilizando Math.floor
                let total_pasivos_sin_decimales = Math.floor(total_pasivos);

                // Formatear como moneda colombiana (COP) sin ceros adicionales después de la coma
                let total_pasivos_formateado = new Intl.NumberFormat("es-CO", {
                    style: "currency",
                    currency: "COP",
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(total_pasivos_sin_decimales);

                // Asignar el número truncado y formateado como contenido del elemento <h2>
                h1Element.innerHTML = total_pasivos_formateado;

                h1Element.style.color = "red";
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
//Fin de la tabla de los egresos de la vivienda

//Cargar datos de pasivos de vivienda
function cargarTablaTotales() {
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
        url: url_site(`api/vivpasivos/totales?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivTotales').DataTable().clear();
            $('#tbl-vivTotales').DataTable().destroy();

            let t = $('#tbl-vivTotales').DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
            });

            if (r.status == "success") {

                r.data.forEach((sol) => {
                    console.log(sol);
                    var patrimonio = sol.suma_valor_activo - sol.suma_valor_pasivo;

                    // Redondear a 0 decimales utilizando Math.floor
                    let total_pasivos_sin_decimales = Math.floor(sol.suma_valor_pasivo);
                    let total_activos_sin_decimales = Math.floor(sol.suma_valor_activo);
                    let total_patrimonio_sin_decimales = Math.floor(patrimonio);

                    // Formatear como moneda colombiana (COP) sin ceros adicionales después de la coma
                    let total_pasivos_formateado = new Intl.NumberFormat("es-CO", {
                        style: "currency",
                        currency: "COP",
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(total_pasivos_sin_decimales);

                    let total_activos_formateado = new Intl.NumberFormat("es-CO", {
                        style: "currency",
                        currency: "COP",
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(total_activos_sin_decimales);

                    let total_patrimonio_formateado = new Intl.NumberFormat("es-CO", {
                        style: "currency",
                        currency: "COP",
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(total_patrimonio_sin_decimales);


                    t.row.add([
                        `<span style="font-size: 50px;">${total_pasivos_formateado}</span>`,
                        `<span style="font-size: 50px;">${total_activos_formateado}</span>`,
                        `<span style="font-size: 50px;">${total_patrimonio_formateado}</span>`,

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
//Fin de la tabla de los egresos de la vivienda

