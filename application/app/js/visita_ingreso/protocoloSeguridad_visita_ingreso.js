$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_protocolo_seguridad_vi`),
        input: [{
            id: 'concepto_seguridad',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
    

    //Cargar la tabla de los activos de la vivienda
    cargarTablaVivProtocoloSeguridad();

    //loadSelectOption para cargar la lista de los Tipos de Financiero
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_protocolo_seguridad_vi`),
        input: [{
            id: 'concepto_seguridad_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
    //envio de Accion POST
   $('.btnAddVivFinanciero').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditSeguridad').on('click', function () {
        $('#formVivSeguridad')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
       
    // Enviar id_solicitud a laboral visita ingreso
    /*$('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })*/

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`dimensionCompromiso_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
        let params = new URLSearchParams(location.search);
        let id_solicitudC = params.get('id_solicitud');
        let params1 = new URLSearchParams(location.search);
        let id_servicioC = params1.get('id_servicio');

        const headers = {
            "access-token": getToken()
        };

        const urlValidation = url_site(`api/vivProtocoloseguridad/lista?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);

        $.ajax({
            headers: headers,
            type: "GET",
            url: urlValidation,
            dataType: "json",
            success: function (response) {
                //console.log(response)
                let countA = 0;
                let countB = 0;
                let countC = 0;
                let countD = 0;
                let countE = 0;
                let countF = 0;
                let countG = 0;

                response.data.forEach((sol) => {
                    //console.log('sol:', sol.nombre_pregunta); // Verificar el valor de sol
                    switch (sol.concepto_seguridad) {
                        case 'A':
                            countA++;
                            break;
                        case 'B':
                            countB++;
                            break;
                        case 'C':
                            countC++;
                            break;
                        case 'D':
                            countD++;
                            break;
                        case 'E':
                            countE++;
                            break;
                        case 'F':
                            countF++;
                            break;
                        case 'G':
                            countG++;
                            break;
                        default:
                            break;
                    }
                });

                if (countA > 0 && countB > 0 && countC > 0 && countD > 0 && countE > 0 && countF > 0 && countG > 0) {
                    window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                } else if (countA == 0) {
                    alertSwal('error', 'Falta la variable', 'UNO');
                }else if  (countB === 0) {
                    alertSwal('error', 'Falta la variable', 'DOS');
                }else if  (countC === 0) {
                    alertSwal('error', 'Falta la variable', 'TRES');
                }else if (countD == 0) {
                    alertSwal('error', 'Falta la variable', 'CUATRO');
                }else if  (countE === 0) {
                    alertSwal('error', 'Falta la variable', 'CINCO');
                }else if  (countF === 0) {
                    alertSwal('error', 'Falta la variable', 'SEIS');
                }else if  (countG === 0) {
                    alertSwal('error', 'Falta la variable', 'SIETE');
                }
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
    });

    //para cargar la pregunta de aspecto protocolo de seguridad
    $('#concepto_seguridad').on('change', function () {
        let concepto_seguridad = $('#concepto_seguridad').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto_seguridad);
        
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivProtocoloseguridad/concepto_completo_vi?concepto_seguridad=${concepto_seguridad}`),
            dataType: "json",
            success: function (resp) {
                $('#concepto_seguridad_completo').val(resp.data[0].observacion);               
            }
        }).done(function () {
            hideModalLoading();
        });
        
    })

    //para cargar la respuesta de no aplica
    $('#respuesta').on('change', function () {
        let respuesta = $('#respuesta').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        let aspecto_edit = $('#concepto_seguridad').val();
        //console.log (respuesta);

        if (respuesta == 'No') {

            if (aspecto_edit === 'A') {//1
                $('#descripcion_seguridad').val('El evaluado (a), no ha presentado ninguna problemática laboral que haya incidido en presentar un despido con justa o sin justa causa.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a), no ha presentado ninguna problemática laboral que haya incidido en presentar un despido con justa o sin justa causa.';
                $("#descripcion_seguridad").prop("readonly", true);
            } else if (aspecto_edit === 'B') {//2
                $('#descripcion_seguridad').val('El evaluado (a), asegura no ha estado involucrado (a) en procesos judiciales o penales, ni como demandante, ni como demandado (a), como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a), asegura no ha estado involucrado (a) en procesos judiciales o penales, ni como demandante, ni como demandado (a), como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad").prop("readonly", true);
            } else if (aspecto_edit === 'C') {//3
                $('#descripcion_seguridad').val('El evaluado (a), informa que no ha presentado situaciones relacionadas con secuestro o extorsión, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a), informa que no ha presentado situaciones relacionadas con secuestro o extorsión, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad").prop("readonly", true);
            } else if (aspecto_edit === 'D') {//4
                $('#descripcion_seguridad').val('El evaluado (a), afirma que no porta, armas de fuego y/o salvoconducto, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a), afirma que no porta, armas de fuego y/o salvoconducto, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad").prop("readonly", true);
            } else if (aspecto_edit === 'E') {//5
                $('#descripcion_seguridad').val('El evaluado (a) manifiesta que no  pertenece o ha pertenecido a grupos armados ilegales, no se ha dedicado o se dedica a actividades ilícitas y no ha tenido, ni tiene  vínculos con personas al margen de la ley, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a) manifiesta que no  pertenece o ha pertenecido a grupos armados ilegales, no se ha dedicado o se dedica a actividades ilícitas y no ha tenido, ni tiene  vínculos con personas al margen de la ley, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad").prop("readonly", true);
            } else if (aspecto_edit === 'F') {//6
                $('#descripcion_seguridad').val('El evaluado (a) asegura que no frecuenta lugares de juego de azar, ni tiene problemas de Ludopatía, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a) asegura que no frecuenta lugares de juego de azar, ni tiene problemas de Ludopatía, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad").prop("readonly", true);
            } else if (aspecto_edit === 'G') {//7
                $('#descripcion_seguridad').val('El evaluado (a) refiere que no tiene familiares que laboren o hayan laborado en la empresa.');
                document.getElementById('descripcion_seguridad').placeholder = 'El evaluado (a) refiere que no tiene familiares que laboren o hayan laborado en la empresa.';
                $("#descripcion_seguridad").prop("readonly", true);
            }
            
        }else{
            $('#descripcion_seguridad').val('');
            document.getElementById('descripcion_seguridad').placeholder = 'Descripción';
            $("#descripcion_seguridad").prop("readonly", false);
        }
        
    })
    
    
    // Crear protocolo de seguridad de la vivienda
    $('#btn-submit-vivProtocoloSeguridad').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivProtocoloSeguridad()) {

            let method = $('#accion').val();
            let data = {
                id_seguridad: $('#id_seguridad').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                concepto_seguridad: $('#concepto_seguridad').val(),
                respuesta: $('#respuesta').val(),
                descripcion_seguridad: $('#descripcion_seguridad').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivProtocoloseguridad?id_seguridad=${data.id_seguridad}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Protocolos de Seguridad', 'vivienda guardado satisfactoriamente');
                        window.location = url_site(`protocoloSeguridad_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivProtocoloSeguridad();
                        $('#formVivSeguridad')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                                                loadSelectOption({
                            url: url_site(`api/configuracion/tipo_protocolo_seguridad_vi`),
                            input: [{
                                id: 'concepto_seguridad',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione un Concepto',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: '',
                        })
                        $('#descripcion_seguridad').val('');
                        $('#respuesta').val('');
                        document.getElementById('descripcion_seguridad').placeholder = 'Descripción';
                        $("#descripcion_seguridad").prop("readonly", false);
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Protocolo de Segurida de la vivienda', r.code.code);
                        cargarTablaVivProtocoloSeguridad();
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
    $('#tbl-vivProtocoloSeguridad').on('click', '.btnEditVivSeguridad', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_seguridad = $(this).attr('id_seguridad');
        //console.log(id_seguridad);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivProtocoloseguridad?id_seguridad=${id_seguridad}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp.data.descripcion_tipo_concepto);
                $('#id_seguridad').val(resp.data.id_seguridad);
                $('#concepto_seguridad_edit').val(resp.data.concepto_seguridad);
                $('#respuesta_edit').val(resp.data.respuesta);
                $('#descripcion_seguridad_edit').val(resp.data.descripcion_seguridad);

                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/vivProtocoloseguridad/concepto_completo_vi?concepto_seguridad=${resp.data.concepto_seguridad}`),
                    dataType: "json",
                    success: function (resp) {
                        //console.log(resp)
                        $('#concepto_seguridad_completo_edit').val(resp.data[0].observacion);               
                    }
                }).done(function () {
                    hideModalLoading();
                });
                //$('#concepto_seguridad_completo_edit').val(resp.data.descripcion_tipo_concepto);
                


                //para cargar la pregunta de aspecto protocolo de seguridad
                $('#concepto_seguridad_edit').on('change', function () {
                    let concepto_seguridad_edit = $('#concepto_seguridad_edit').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                    //console.log (concepto_seguridad);
                    
                    $.ajax({
                        headers: {
                            "access-token": getToken()
                        },
                        type: "GET",
                        url: url_site(`api/vivProtocoloseguridad/concepto_completo_vi?concepto_seguridad=${concepto_seguridad_edit}`),
                        dataType: "json",
                        success: function (resp) {
                            $('#concepto_seguridad_completo_edit').val(resp.data[0].observacion);               
                        }
                    }).done(function () {
                        hideModalLoading();
                    });
                    
                })

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivFinanciero').modal();

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivProtocoloseguridad/concepto_completo_vi?concepto_seguridad=${concepto_seguridad}`),
            dataType: "json",
            success: function (resp) {
                //console.log (resp);
                $('#concepto_seguridad_completo_edit').val(resp.data.descripcion);
            }
        }).done(function () {
            hideModalLoading();
        });
    })
    //fin de editar financiero de la vivienda 

    //para cargar la respuesta_edit de no aplica
    $('#respuesta_edit').on('change', function () {
        let respuesta_edit = $('#respuesta_edit').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        let aspecto_edit = $('#concepto_seguridad_edit').val();
        console.log (respuesta_edit);

        if (respuesta_edit == 'No') {

            if (aspecto_edit === 'A') {//1
                $('#descripcion_seguridad_edit').val('El evaluado (a), no ha presentado ninguna problemática laboral que haya incidido en presentar un despido con justa o sin justa causa.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a), no ha presentado ninguna problemática laboral que haya incidido en presentar un despido con justa o sin justa causa.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            } else if (aspecto_edit === 'B') {//2
                $('#descripcion_seguridad_edit').val('El evaluado (a), asegura no ha estado involucrado (a) en procesos judiciales o penales, ni como demandante, ni como demandado (a), como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a), asegura no ha estado involucrado (a) en procesos judiciales o penales, ni como demandante, ni como demandado (a), como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            } else if (aspecto_edit === 'C') {//3
                $('#descripcion_seguridad_edit').val('El evaluado (a), informa que no ha presentado situaciones relacionadas con secuestro o extorsión, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a), informa que no ha presentado situaciones relacionadas con secuestro o extorsión, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            } else if (aspecto_edit === 'D') {//4
                $('#descripcion_seguridad_edit').val('El evaluado (a), afirma que no porta, armas de fuego y/o salvoconducto, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a), afirma que no porta, armas de fuego y/o salvoconducto, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            } else if (aspecto_edit === 'E') {//5
                $('#descripcion_seguridad_edit').val('El evaluado (a) manifiesta que no  pertenece o ha pertenecido a grupos armados ilegales, no se ha dedicado o se dedica a actividades ilícitas y no ha tenido, ni tiene  vínculos con personas al margen de la ley, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a) manifiesta que no  pertenece o ha pertenecido a grupos armados ilegales, no se ha dedicado o se dedica a actividades ilícitas y no ha tenido, ni tiene  vínculos con personas al margen de la ley, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            } else if (aspecto_edit === 'F') {//6
                $('#descripcion_seguridad_edit').val('El evaluado (a) asegura que no frecuenta lugares de juego de azar, ni tiene problemas de Ludopatía, como tampoco ningún miembro de su familia.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a) asegura que no frecuenta lugares de juego de azar, ni tiene problemas de Ludopatía, como tampoco ningún miembro de su familia.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            } else if (aspecto_edit === 'G') {//7
                $('#descripcion_seguridad_edit').val('El evaluado (a) refiere que no tiene familiares que laboren o hayan laborado en la empresa.');
                document.getElementById('descripcion_seguridad_edit').placeholder = 'El evaluado (a) refiere que no tiene familiares que laboren o hayan laborado en la empresa.';
                $("#descripcion_seguridad_edit").prop("readonly", true);
            }
        }else{
            $('#descripcion_seguridad_edit').val('');
            document.getElementById('descripcion_seguridad_edit').placeholder = 'Descripción';
            $("#descripcion_seguridad_edit").prop("readonly", false);
        }
        
    })

   $('#btn-submit-vivEditSeguridad').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivProtocoloSeguridadEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {
                id_seguridad: $('#id_seguridad').val(),
                id_solicitud: id_solicitudC,
                concepto_seguridad: $('#concepto_seguridad_edit').val(),
                respuesta: $('#respuesta_edit').val(),
                descripcion_seguridad: $('#descripcion_seguridad_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivProtocoloseguridad/update_seguridad?id_seguridad=${data.id_seguridad}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Protocolo Seguridad',
                        'Lo Protocolo de Seguridad de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        window.location = url_site(`protocoloSeguridad_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivProtocoloSeguridad();
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
    $("#tbl-vivProtocoloSeguridad").on("click", ".btnEliminarVivSeguridad", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivProtocoloSeguridad").on("click", ".btnEliminarVivSeguridad", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_seguridadC = $(this).attr('id_seguridad');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_seguridad: id_seguridadC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivProtocoloseguridad/delete_seguridad?id_seguridad=${data.id_seguridad}`), //Se le da el id_ingreso de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'protocolo de seguridad',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        window.location = url_site(`protocoloSeguridad_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivProtocoloSeguridad();
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

//*********************************************************************** */
 //Se valida la lista de las variables para que no se repita si ya existe
 //*********************************************************************** */
 $('#concepto_seguridad').on('change', function() {
        
    // $('#formDimensionFinanciero')[0].reset();
     var id_pregunta = $('#concepto_seguridad').val();
     let params = new URLSearchParams(location.search);
     let id_solicitudC = params.get('id_solicitud');
     let params1 = new URLSearchParams(location.search);
     let id_servicioC = params1.get('id_servicio');
     //console.log(id_preguntaC)
     $.ajax({
         headers: {
             "access-token": getToken()
         },
         type: "GET",
         url: url_site(`api/vivProtocoloseguridad/validar_variable?id_pregunta=${id_pregunta}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
         dataType: "json",
         
         success: function (resp) {
             if (resp.data.length == 1) {

                alertSwal('error', 'Variable', 'Esta variable ya ha sido guardada.');
                $("#descripcion_financiero").prop("disabled", true);
                $("#respuesta").prop("disabled", true);
                $("#Descripción").focus();
                return false; 
             }
             else{
               $("#respuesta").prop("disabled", false);
               $("#Descripción").prop("disabled", false);
             }
         }
     })
 });

//Funcion de Validar los campos de Crear los pasivos
function validateFormVivProtocoloSeguridad() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_seguridad').val() == "" || $('#concepto_seguridad').val() == null) {
        alertSwal('error', 'concepto Seguridad', 'Este campo es obligatorio');
        $("#concepto_seguridad").focus();
        return false;
    }
    if ($('#respuesta').val() == "" || $('#respuesta').val() == null) {
        alertSwal('error', 'respuesta Protocolo Seguridad', 'Este campo es obligatorio');
        $("#respuesta").focus();
        return false;
    }
    if ($('#descripcion_seguridad').val() == "" || $('#descripcion_seguridad').val() == null) {
        alertSwal('error', 'Observación', 'Este campo es obligatorio');
        $("#descripcion_seguridad").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Crear la pasivos de la vivienda

//Funcion de Validar los campos de Editar los pasivos de la vivienda
function validateFormVivProtocoloSeguridadEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_seguridad_edit').val() == "" || $('#concepto_seguridad_edit').val() == null) {
        alertSwal('error', 'concepto Seguridad', 'Este campo es obligatorio');
        $("#concepto_seguridad_edit").focus();
        return false;
    }
    if ($('#respuesta_edit').val() == "" || $('#respuesta_edit').val() == null) {
        alertSwal('error', 'respuesta Protocolo Seguridad', 'Este campo es obligatorio');
        $("#respuesta_edit").focus();
        return false;
    }
    if ($('#descripcion_seguridad_edit').val() == "" || $('#descripcion_seguridad_edit').val() == null) {
        alertSwal('error', 'Observación', 'Este campo es obligatorio');
        $("#descripcion_seguridad_edit").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Editar los egresos


//Cargar datos de financiero de vivienda
function cargarTablaVivProtocoloSeguridad() {
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
        url: url_site(`api/vivProtocoloseguridad/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivProtocoloSeguridad').DataTable().clear();
            $('#tbl-vivProtocoloSeguridad').DataTable().destroy();

            let t = $('#tbl-vivProtocoloSeguridad').DataTable({
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
                        //sol.id_seguridad,
                        //contador++,
                        sol.descripcion_tipo_seguridad,
                        sol.respuesta,
                        sol.descripcion_seguridad,
                        `<button class="btn btn-xs btn-warning btnEditVivSeguridad" id_seguridad="${sol.id_seguridad}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivSeguridad" id_seguridad=${sol.id_seguridad}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de los egresos de la vivienda

