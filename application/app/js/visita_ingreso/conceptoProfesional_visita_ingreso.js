$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    
    //loadSelectOption para cargar la lista de los Tipos de Documentos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_concepto_profesional`),
        input: [{
            id: 'concepto_final',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    
/*    // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {

        window.location = url_site(`adjuntos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })
*/
    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {

        window.location = url_site(`protocoloSeguridad_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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


    $('#btn-submit-Siguiente').on('click', function () {
        // Obtener los parámetros de la URL
        const params = new URLSearchParams(location.search);
        const id_solicitud = params.get('id_solicitud');
        const id_servicio = params.get('id_servicio');
        
        // Definir los encabezados
        const headers = {
            "access-token": getToken()
        };
        // URL para la segunda solicitud AJAX
        //url: url_site(`api/dimensiones/validacion_dim_concepto?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
        const urlValidation = url_site(`api/dimensiones/validacion_dim_concepto?id_solicitud=${id_solicitud}&id_servicio=${id_servicio}`);
        
        // Hacer la segunda solicitud AJAX
        $.ajax({
            headers: headers,
            type: "GET",
            url: urlValidation,
            dataType: "json",
            success: function (r) {
                //console.log(r);
                var count1 = 0;
                var count2 = 0;
                var count3 = 0;
                var count4 = 0;
                var count5 = 0;
                if (r.data != null) {
                    r.data.forEach(p => {
                        console.log(p.id_dimension);
                        switch (p.id_dimension) {
                            case '1':
                                count1++;
                                break;
                            case '2':
                                count2++;
                                break;
                            case '3':
                                count3++;
                                break;   
                            case '4':
                                count4++;
                                break;  
                            case '5':
                                count5++;
                                break;  
                            default:
                                break;
                        }
                    })
                    if (count1 > 0 && count2 > 0 && count3 > 0 && count4 > 0 && count5 > 0) {
                        alertSwal('success', 'Finalizo el Concepto Profesional', 'Siguiente');
                        window.location = url_site(`adjuntos_visita_ingreso?id_solicitud=${id_solicitud}&id_servicio=${id_servicio}`)
    
                        
                    } else if (count1 == 0) {
                        alertSwal('error', 'Matriz Familiar', 'Falta diligenciar');
                    } else if (count2 == 0) {
                        alertSwal('error', 'Matriz Social y Habitacional', 'Falta diligenciar');
                    } else if (count3 == 0) {
                        alertSwal('error', 'Matriz Financiera y Economica', 'Falta diligenciar');
                    } else if (count4 == 0) {
                        alertSwal('error', 'Matriz Salud', 'Falta diligenciar');
                    } else if (count5 == 0) {
                        alertSwal('error', 'Matriz Actitud y Compromiso', 'Falta diligenciar');
                    }
                    
                } else{
                    alertSwal('error', 'Diligenciar Matriz de cada Dimensión', 'Falta diligenciar');
                }

            },
            error: function (xhr, status, error) {
                alertSwal('error', '1Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        }).done(function () {
            hideModalLoading();
        });
    });


    // Evento de clic en los enlaces con clase "small-box-footer"
    $('.small-box-footer').click(function() {
        // Obtener el valor del atributo "data-id"
        var id = $(this).data('id');
        
        // Aquí puedes realizar una acción específica según el id seleccionado
        // Por ejemplo, mostrar información diferente en el modal
        switch (id) {
        case 1:
            
            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                type: "GET",
                url: url_site(`api/dimensiones/trae_dim_concepto?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'1'}`),
                dataType: "json",
                
                success: function (resp) {
                //console.log(resp);
                $('#titulo-modal-dimension').html('MATRIZ FAMILIAR');
                    if (resp.data != null) {
            
                        $('#id_dim_concepto').val(resp.data.id_dim_concepto);
                        $('#dimObservacion').val(resp.data.observacion);
                        opcion = resp.data.id_dim_concepto
                        
                            //envio de Accion PUT
                            $('.btnAddConceptoDim').on('click', function () {
                                $('#accion').val("PUT");
                            });
        
                            // Editar Observacion de la dimension
                            $('#btn-submit-dimconcepto').on('click', function (e) {
                                e.preventDefault();
        
                            //if (validateFormVivProtocoloSeguridad()) {
        
                                let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        
                                let data = {
                                    id_dim_concepto: $('#id_dim_concepto').val(),
                                    observacion: $('#dimObservacion').val(),
                                }
        
                                $.ajax({
                                    method: method,
                                    headers: {
                                    "access-token": getToken()
                                    },
                                    url: url_site(`api/dimensiones/update_dimconceptofinal?id_dim_concepto=${opcion}`), //Se le da el id_candidato de la data
                                    contentType: 'application/json',
                                    data: JSON.stringify(data),
                                    dataType: "json",
                                    success: function (cand) {
                            
                                        alertSwal('success', 'concepto final', 'Candidato guardado satisfactoriamente')
                                        window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                            
                                    },
                                    error: function (xhr, status, error) {
                                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                    },
                                    complete: function () {
                                        hideModalLoading();
                                    }
                                });
                                //}
                            });
                    } else
                    {
                                //console.log(3000);
                                    //envio de Accion POST
                                    $('.btnAddConceptoDim').on('click', function () {
                                    $('#accion').val("POST");
                                    });
                            
                                    // Crear protocolo de seguridad de la vivienda
                                    $('#btn-submit-dimconcepto').on('click', function (e) {
                                    e.preventDefault(e);
                                    $(this).prop('disabled', true);
                            
                                    //if (validateFormVivProtocoloSeguridad()) {
                            
                                    let method = $('#accion').val();
                                    let data = {
                                        id_dim_concepto: $('#id_dim_concepto').val(),
                                        id_solicitud: id_solicitudC,
                                        id_servicio: id_servicioC,
                                        id_dimension: 1,
                                        observacion: $('#dimObservacion').val(),
                                    } 
                                    $.ajax({
                                        method: method,
                                        headers: {
                                            "access-token": getToken()
                                        },
                                        url: url_site(`api/dimensiones/dimconceptofinal?id_concepto=${data.id_concepto}`),
                                        contentType: 'application/json',
                                        data: JSON.stringify(data),
                                        dataType: "json",
                                        success: function (r) {
                                            if (r.status == "success") {
                                                alertSwal('success', 'Concepto', 'Profesional guardado satisfactoriamente');
                                                //$('#formVivConceptoProfesional')[0].reset();
                                                $('#submitButton').prop('disabled', false);
                                                window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                            } else {
                                                    alertSwal('error', 'Concepto Profesional', r.code.code);
                                                
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                        },
                                        complete: function () {
                                            hideModalLoading();
                                        }
                                    });//ajax
                                //}
                                });// Fin de Crear pasivos de la vivienda
                    }
        
                }
            });


            // trae la el porcentaje de dimension familia
            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                type: "GET",
                url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'1'}`),
                dataType: "json",
                
                success: function (resp) {

                    var riesgo =resp.data[0].porcentaje;

                    if (riesgo < 1) {
                        $('#dimObservacion').val('N/A'); 
                        $("#dimObservacion").prop("disabled", true);
                    }else{
                        //$('#dimObservacion').val(''); 
                        $("#dimObservacion").prop("disabled", false);
                    }

                }
            });
            break;
        case 2:

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/dimensiones/trae_dim_concepto?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'2'}`),
            dataType: "json",
            
            success: function (resp) {
            //console.log(resp);
            $('#titulo-modal-dimension').html('MATRIZ SOCIAL Y HABITACIONAL');
                if (resp.data != null) {
        
                    $('#id_dim_concepto').val(resp.data.id_dim_concepto);
                    $('#dimObservacion').val(resp.data.observacion);
                    opcion = resp.data.id_dim_concepto
                    
                        //envio de Accion PUT
                        $('.btnAddConceptoDim').on('click', function () {
                            $('#accion').val("PUT");
                        });
    
                        // Editar Observacion de la dimension
                        $('#btn-submit-dimconcepto').on('click', function (e) {
                            e.preventDefault();
    
                        //if (validateFormVivProtocoloSeguridad()) {
    
                            let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
    
                            let data = {
                                id_dim_concepto: $('#id_dim_concepto').val(),
                                observacion: $('#dimObservacion').val(),
                            }
    
                            $.ajax({
                                method: method,
                                headers: {
                                "access-token": getToken()
                                },
                                url: url_site(`api/dimensiones/update_dimconceptofinal?id_dim_concepto=${opcion}`), //Se le da el id_candidato de la data
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (cand) {
                        
                                    alertSwal('success', 'concepto final', 'Candidato guardado satisfactoriamente')
                                    window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });
                            //}
                        });
                } else
                {
                            //console.log(3000);
                                //envio de Accion POST
                                $('.btnAddConceptoDim').on('click', function () {
                                $('#accion').val("POST");
                                });
                        
                                // Crear protocolo de seguridad de la vivienda
                                $('#btn-submit-dimconcepto').on('click', function (e) {
                                e.preventDefault(e);
                                $(this).prop('disabled', true);
                        
                                //if (validateFormVivProtocoloSeguridad()) {
                        
                                let method = $('#accion').val();
                                let data = {
                                    id_dim_concepto: $('#id_dim_concepto').val(),
                                    id_solicitud: id_solicitudC,
                                    id_servicio: id_servicioC,
                                    id_dimension: 2,
                                    observacion: $('#dimObservacion').val(),
                                } 
                                $.ajax({
                                    method: method,
                                    headers: {
                                        "access-token": getToken()
                                    },
                                    url: url_site(`api/dimensiones/dimconceptofinal?id_concepto=${data.id_concepto}`),
                                    contentType: 'application/json',
                                    data: JSON.stringify(data),
                                    dataType: "json",
                                    success: function (r) {
                                        if (r.status == "success") {
                                            alertSwal('success', 'Concepto', 'Profesional guardado satisfactoriamente');
                                            //$('#formVivConceptoProfesional')[0].reset();
                                            $('#submitButton').prop('disabled', false);
                                            window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                        } else {
                                                alertSwal('error', 'Concepto Profesional', r.code.code);
                                            
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                    },
                                    complete: function () {
                                        hideModalLoading();
                                    }
                                });//ajax
                            //}
                            });// Fin de Crear pasivos de la vivienda
                }
    
            }
        });




            // trae la el porcentaje de dimension social y habitacionales
            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                type: "GET",
                url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'2'}`),
                dataType: "json",
                
                success: function (resp) {
                
                    var riesgo =resp.data[0].porcentaje;

                    if (riesgo < 1) {
                        $('#dimObservacion').val('N/A'); 
                        $("#dimObservacion").prop("disabled", true);
                    }else{
                        //$('#dimObservacion').val(''); 
                        $("#dimObservacion").prop("disabled", false);
                    }

                }
            });
            break;

        case 3:

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/dimensiones/trae_dim_concepto?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'3'}`),
            dataType: "json",
            
            success: function (resp) {
            //console.log(resp);
            $('#titulo-modal-dimension').html('MATRIZ FINANCIERA Y ECONOMICA');
                if (resp.data != null) {
        
                    $('#id_dim_concepto').val(resp.data.id_dim_concepto);
                    $('#dimObservacion').val(resp.data.observacion);
                    opcion = resp.data.id_dim_concepto
                    
                        //envio de Accion PUT
                        $('.btnAddConceptoDim').on('click', function () {
                            $('#accion').val("PUT");
                        });
    
                        // Editar Observacion de la dimension
                        $('#btn-submit-dimconcepto').on('click', function (e) {
                            e.preventDefault();
    
                        //if (validateFormVivProtocoloSeguridad()) {
    
                            let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
    
                            let data = {
                                id_dim_concepto: $('#id_dim_concepto').val(),
                                observacion: $('#dimObservacion').val(),
                            }
    
                            $.ajax({
                                method: method,
                                headers: {
                                "access-token": getToken()
                                },
                                url: url_site(`api/dimensiones/update_dimconceptofinal?id_dim_concepto=${opcion}`), //Se le da el id_candidato de la data
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (cand) {
                        
                                    alertSwal('success', 'concepto final', 'Candidato guardado satisfactoriamente')
                                    window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });
                            //}
                        });
                } else
                {
                            //console.log(3000);
                                //envio de Accion POST
                                $('.btnAddConceptoDim').on('click', function () {
                                $('#accion').val("POST");
                                });
                        
                                // Crear protocolo de seguridad de la vivienda
                                $('#btn-submit-dimconcepto').on('click', function (e) {
                                e.preventDefault(e);
                                $(this).prop('disabled', true);
                        
                                //if (validateFormVivProtocoloSeguridad()) {
                        
                                let method = $('#accion').val();
                                let data = {
                                    id_dim_concepto: $('#id_dim_concepto').val(),
                                    id_solicitud: id_solicitudC,
                                    id_servicio: id_servicioC,
                                    id_dimension: 3,
                                    observacion: $('#dimObservacion').val(),
                                } 
                                $.ajax({
                                    method: method,
                                    headers: {
                                        "access-token": getToken()
                                    },
                                    url: url_site(`api/dimensiones/dimconceptofinal?id_concepto=${data.id_concepto}`),
                                    contentType: 'application/json',
                                    data: JSON.stringify(data),
                                    dataType: "json",
                                    success: function (r) {
                                        if (r.status == "success") {
                                            alertSwal('success', 'Concepto', 'Profesional guardado satisfactoriamente');
                                            //$('#formVivConceptoProfesional')[0].reset();
                                            $('#submitButton').prop('disabled', false);
                                            window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                        } else {
                                                alertSwal('error', 'Concepto Profesional', r.code.code);
                                            
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                    },
                                    complete: function () {
                                        hideModalLoading();
                                    }
                                });//ajax
                            //}
                            });// Fin de Crear pasivos de la vivienda
                }
    
            }
        });

                // trae la el porcentaje de dimension financiera y economica
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'3'}`),
                    dataType: "json",
                    
                    success: function (resp) {

                        var riesgo =resp.data[0].porcentaje;

                        if (riesgo < 1) {
                            $('#dimObservacion').val('N/A'); 
                            $("#dimObservacion").prop("disabled", true);
                        }else{
                            //$('#dimObservacion').val(''); 
                            $("#dimObservacion").prop("disabled", false);
                        }

                    }
                });
            break;
        case 4:

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/dimensiones/trae_dim_concepto?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'4'}`),
            dataType: "json",
            
            success: function (resp) {
            //console.log(resp);
            $('#titulo-modal-dimension').html('MATRIZ SALUD');
                if (resp.data != null) {
        
                    $('#id_dim_concepto').val(resp.data.id_dim_concepto);
                    $('#dimObservacion').val(resp.data.observacion);
                    opcion = resp.data.id_dim_concepto
                    
                        //envio de Accion PUT
                        $('.btnAddConceptoDim').on('click', function () {
                            $('#accion').val("PUT");
                        });
    
                        // Editar Observacion de la dimension
                        $('#btn-submit-dimconcepto').on('click', function (e) {
                            e.preventDefault();
    
                        //if (validateFormVivProtocoloSeguridad()) {
    
                            let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
    
                            let data = {
                                id_dim_concepto: $('#id_dim_concepto').val(),
                                observacion: $('#dimObservacion').val(),
                            }
    
                            $.ajax({
                                method: method,
                                headers: {
                                "access-token": getToken()
                                },
                                url: url_site(`api/dimensiones/update_dimconceptofinal?id_dim_concepto=${opcion}`), //Se le da el id_candidato de la data
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (cand) {
                        
                                    alertSwal('success', 'concepto final', 'Candidato guardado satisfactoriamente')
                                    window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });
                            //}
                        });
                } else
                {
                            //console.log(3000);
                                //envio de Accion POST
                                $('.btnAddConceptoDim').on('click', function () {
                                $('#accion').val("POST");
                                });
                        
                                // Crear protocolo de seguridad de la vivienda
                                $('#btn-submit-dimconcepto').on('click', function (e) {
                                e.preventDefault(e);
                                $(this).prop('disabled', true);
                        
                                //if (validateFormVivProtocoloSeguridad()) {
                        
                                let method = $('#accion').val();
                                let data = {
                                    id_dim_concepto: $('#id_dim_concepto').val(),
                                    id_solicitud: id_solicitudC,
                                    id_servicio: id_servicioC,
                                    id_dimension: 4,
                                    observacion: $('#dimObservacion').val(),
                                } 
                                $.ajax({
                                    method: method,
                                    headers: {
                                        "access-token": getToken()
                                    },
                                    url: url_site(`api/dimensiones/dimconceptofinal?id_concepto=${data.id_concepto}`),
                                    contentType: 'application/json',
                                    data: JSON.stringify(data),
                                    dataType: "json",
                                    success: function (r) {
                                        if (r.status == "success") {
                                            alertSwal('success', 'Concepto', 'Profesional guardado satisfactoriamente');
                                            //$('#formVivConceptoProfesional')[0].reset();
                                            $('#submitButton').prop('disabled', false);
                                            window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                        } else {
                                                alertSwal('error', 'Concepto Profesional', r.code.code);
                                            
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                    },
                                    complete: function () {
                                        hideModalLoading();
                                    }
                                });//ajax
                            //}
                            });// Fin de Crear pasivos de la vivienda
                }
    
            }
        });


                // trae la el porcentaje de dimension salud
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'4'}`),
                    dataType: "json",
                    
                    success: function (resp) {

                        var riesgo =resp.data[0].porcentaje;

                        if (riesgo < 1) {
                            $('#dimObservacion').val('N/A'); 
                            $("#dimObservacion").prop("disabled", true);
                        }else{
                            //$('#dimObservacion').val(''); 
                            $("#dimObservacion").prop("disabled", false);
                        }

                    }
                });
            break;
        case 5:

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/dimensiones/trae_dim_concepto?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'5'}`),
            dataType: "json",
            
            success: function (resp) {
            //console.log(resp);
            $('#titulo-modal-dimension').html('MATRIZ ACTITUD Y COMPROMISO');
                if (resp.data != null) {
        
                    $('#id_dim_concepto').val(resp.data.id_dim_concepto);
                    $('#dimObservacion').val(resp.data.observacion);
                    opcion = resp.data.id_dim_concepto
                    
                        //envio de Accion PUT
                        $('.btnAddConceptoDim').on('click', function () {
                            $('#accion').val("PUT");
                        });
    
                        // Editar Observacion de la dimension
                        $('#btn-submit-dimconcepto').on('click', function (e) {
                            e.preventDefault();
    
                        //if (validateFormVivProtocoloSeguridad()) {
    
                            let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
    
                            let data = {
                                id_dim_concepto: $('#id_dim_concepto').val(),
                                observacion: $('#dimObservacion').val(),
                            }
    
                            $.ajax({
                                method: method,
                                headers: {
                                "access-token": getToken()
                                },
                                url: url_site(`api/dimensiones/update_dimconceptofinal?id_dim_concepto=${opcion}`), //Se le da el id_candidato de la data
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (cand) {
                        
                                    alertSwal('success', 'concepto final', 'Candidato guardado satisfactoriamente')
                                    window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });
                            //}
                        });
                } else
                    {
                        //console.log(3000);
                        //envio de Accion POST
                        $('.btnAddConceptoDim').on('click', function () {
                            $('#accion').val("POST");
                            });
                    
                            // Crear protocolo de seguridad de la vivienda
                            $('#btn-submit-dimconcepto').on('click', function (e) {
                            e.preventDefault(e);
                            $(this).prop('disabled', true);
                    
                            //if (validateFormVivProtocoloSeguridad()) {
                    
                            let method = $('#accion').val();
                            let data = {
                                id_dim_concepto: $('#id_dim_concepto').val(),
                                id_solicitud: id_solicitudC,
                                id_servicio: id_servicioC,
                                id_dimension: 5,
                                observacion: $('#dimObservacion').val(),
                            } 
                            $.ajax({
                                method: method,
                                headers: {
                                    "access-token": getToken()
                                },
                                url: url_site(`api/dimensiones/dimconceptofinal?id_concepto=${data.id_concepto}`),
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (r) {
                                    if (r.status == "success") {
                                        alertSwal('success', 'Concepto', 'Profesional guardado satisfactoriamente');
                                        //$('#formVivConceptoProfesional')[0].reset();
                                        $('#submitButton').prop('disabled', false);
                                        window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                    } else {
                                            alertSwal('error', 'Concepto Profesional', r.code.code);
                                        
                                    }
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });//ajax
                        //}
                        });// Fin de Crear pasivos de la vivienda
                }
    
            }
        });

                // trae la el porcentaje de dimension compromiso
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'5'}`),
                    dataType: "json",
                    
                    success: function (resp) {

                        var riesgo =resp.data[0].porcentaje;

                        if (riesgo < 1) {
                            $('#dimObservacion').val('N/A'); 
                            $("#dimObservacion").prop("disabled", true);
                        }else{
                            //$('#dimObservacion').val(''); 
                            $("#dimObservacion").prop("disabled", false);
                        }

                    }
                });
            break;
        // Y así para los demás casos
        default:
            $('#modalContent').html('<p>Información no disponible.</p>');
            break;
        }
        
        // Mostrar el modal
        //$('#modalAddDimConcepto').modal('show');
        $('#modalAddDimConcepto').modal({backdrop: 'static', keyboard: false});
    });

    $('#modalAddDimConcepto').on('hidden.bs.modal', function (e) {
        window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
    });



    // trae la el porcentaje de dimension familia
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'1'}`),
        dataType: "json",
        
        success: function (resp) {

            // Seleccionar el enlace mediante su ID
            const enlace = document.getElementById("dimfamilia");

            // Modificar el texto del enlace
            enlace.innerHTML = resp.data[0].porcentaje+'%<br>Clic&ensp;<i class="fa fa-hand-pointer-o"></i>';

        }
    });

    // trae la el porcentaje de dimension social y habitacionales
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'2'}`),
        dataType: "json",
        
        success: function (resp) {

            // Seleccionar el enlace mediante su ID
            const enlace = document.getElementById("dimSocial");

            // Modificar el texto del enlace
            enlace.innerHTML = resp.data[0].porcentaje+'%<br>Clic&ensp;<i class="fa fa-hand-pointer-o"></i>';
        }
    });

    // trae la el porcentaje de dimension financiera y economica
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'3'}`),
        dataType: "json",
        
        success: function (resp) {
            //console.log(resp);

            // Seleccionar el enlace mediante su ID
            const enlace = document.getElementById("dimFinanciera");

            // Modificar el texto del enlace
            enlace.innerHTML = resp.data[0].porcentaje+'%<br>Clic&ensp;<i class="fa fa-hand-pointer-o"></i>';

        }
    });
    
    // trae la el porcentaje de dimension salud
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'4'}`),
        dataType: "json",
        
        success: function (resp) {
            // Seleccionar el enlace mediante su ID
            const enlace = document.getElementById("dimSalud");

            // Modificar el texto del enlace
            enlace.innerHTML = resp.data[0].porcentaje+'%<br>Clic&ensp;<i class="fa fa-hand-pointer-o"></i>';
        }
    });

    // trae la el porcentaje de dimension compromiso
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/dimensiones/evaluacion_dimension?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&id_dimension=${'5'}`),
        dataType: "json",
        
        success: function (resp) {

            // Seleccionar el enlace mediante su ID
            const enlace = document.getElementById("dimCompromiso");

            // Modificar el texto del enlace
            enlace.innerHTML = resp.data[0].porcentaje+'%<br>Clic&ensp;<i class="fa fa-hand-pointer-o"></i>';

        }
    });

    //Se trae la Identificacion de un Usuario por medio de un hidden
    //let accion_candidato =  $('#accion_candidato').val();

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivConceptoProfesional/concepto_final?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
        dataType: "json",
        
        success: function (resp) {
        //console.log(resp);
        /*if (resp.data == null) {
            console.log(1000);
        }else{
            console.log(2000);
        }*/
        if (resp.data != '') {
            //console.log(2000);
                $('#id_concepto').val(resp.data[0].id_concepto);
                $('#expectativas').val(resp.data[0].expectativas);
                $('#metas').val(resp.data[0].metas);
                $('#medio_hv').val(resp.data[0].medio_hv);
                $('#condicion_laboral').val(resp.data[0].condicion_laboral);
                cboLoad('concepto_final', url_site(`api/configuracion/tipo_concepto_profesional`), resp.data[0].concepto_final, true, '-Seleccione-');
                $('#observacion').val(resp.data[0].observacion);
                $('#referencia').val(resp.data[0].referencia);
                opcion = resp.data[0].id_concepto
                
                    //envio de Accion PUT
                    $('.btnAddConceptoProfecional').on('click', function () {
                        $('#accion').val("PUT");
                    });

                    // Editar Candidato prueba
                    $('#btn-submit-vivConceptoProfesional').on('click', function (e) {
                        e.preventDefault();

                    if (validateFormVivProtocoloSeguridad()) {

                        let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

                        let data = {
                            id_concepto: $('#id_concepto').val(),
                            expectativas: $('#expectativas').val(),
                            metas: $('#metas').val(),
                            medio_hv: $('#medio_hv').val(),
                            condicion_laboral: $('#condicion_laboral').val(),
                            concepto_final: $('#concepto_final').val(),
                            observacion: $('#observacion').val(),
                            referencia: $('#referencia').val(),
                        }

                        $.ajax({
                            method: method,
                            headers: {
                            "access-token": getToken()
                            },
                            url: url_site(`api/vivConceptoProfesional/update_concepto?id_concepto=${opcion}`), //Se le da el id_candidato de la data
                            contentType: 'application/json',
                            data: JSON.stringify(data),
                            dataType: "json",
                            success: function (cand) {
                    
                                alertSwal('success', 'concepto final', 'Candidato guardado satisfactoriamente')
                                window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                    
                            },
                            error: function (xhr, status, error) {
                                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                            },
                            complete: function () {
                                hideModalLoading();
                            }
                        });
                        }
                    });
                    } else{
                        //console.log(3000);
                            //envio de Accion POST
                            $('.btnAddConceptoProfecional').on('click', function () {
                            $('#accion').val("POST");
                            });
                    
                            // Crear protocolo de seguridad de la vivienda
                            $('#btn-submit-vivConceptoProfesional').on('click', function (e) {
                            e.preventDefault(e);
                            $(this).prop('disabled', true);
                    
                            if (validateFormVivProtocoloSeguridad()) {
                    
                            let method = $('#accion').val();
                            let data = {
                                id_concepto: $('#id_concepto').val(),
                                id_solicitud: id_solicitudC,
                                id_servicio: id_servicioC,
                                expectativas: $('#expectativas').val(),
                                metas: $('#metas').val(),
                                medio_hv: $('#medio_hv').val(),
                                condicion_laboral: $('#condicion_laboral').val(),
                                concepto_final: $('#concepto_final').val(),
                                observacion: $('#observacion').val(),
                                referencia: $('#referencia').val(),
                            } 
                            $.ajax({
                                method: method,
                                headers: {
                                    "access-token": getToken()
                                },
                                url: url_site(`api/vivConceptoProfesional?id_concepto=${data.id_concepto}`),
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (r) {
                                    if (r.status == "success") {
                                        alertSwal('success', 'Concepto', 'Profesional guardado satisfactoriamente');
                                        //$('#formVivConceptoProfesional')[0].reset();
                                        $('#submitButton').prop('disabled', false);
                                        window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                                    } else {
                                            alertSwal('error', 'Concepto Profesional', r.code.code);
                                        
                                    }
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });//ajax
                        }
                        });// Fin de Crear pasivos de la vivienda
                }
            }
    });
    

}); //fin de funcion Ready()


//Funcion para validar los campos del formulario
function validateFormVivProtocoloSeguridad() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#expectativas').val() == "" || $('#expectativas').val() == null) {
        alertSwal('error', 'Expectativa', 'Este campo es obligatorio');
        $("#expectativas").focus();
        return false;
    }
    if ($('#metas').val() == "" || $('#metas').val() == null) {
        alertSwal('error', 'Metas', 'Este campo es obligatorio');
        $("#metas").focus();
        return false;
    }
    if ($('#medio_hv').val() == "" || $('#medio_hv').val() == null) {
        alertSwal('error', 'Medio de la Hoja de Vida', 'Este campo es obligatorio');
        $("#medio_hv").focus();
        return false;
    }
    if ($('#condicion_laboral').val() == "" || $('#condicion_laboral').val() == null) {
        alertSwal('error', 'Condicion Laboral', 'Este campo es obligatorio');
        $("#condicion_laboral").focus();
        return false;
    }
    if ($('#concepto_final').val() == "" || $('#concepto_final').val() == null) {
        alertSwal('error', 'Concepto Final', 'Este campo es obligatorio');
        $("#concepto_final").focus();
        return false;
    }
/*    if ($('#observacion').val() == "" || $('#observacion').val() == null) {
        alertSwal('error', 'Observación', 'Este campo es obligatorio');
        $("#observacion").focus();
        return false;
    }
*/
    return true;

}//Fin de Funcion para validar los campos del formulario
