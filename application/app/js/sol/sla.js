$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    $('#fin_verde').on('change', function () {
        let id_pregunta = $('#fin_verde').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (id_pregunta);
        $('#inicio_amarillo').val(id_pregunta);
    });

    $('#fin_amarillo').on('change', function () {
        let id_pregunta = $('#fin_amarillo').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (id_pregunta);
        $('#inicio_rojo').val(id_pregunta);
    });

    //Función para traer la observación general del núcleo familiar
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/sla/lista`),
        dataType: "json",
        
        success: function (resp) {
            //console.log(resp.data)

        if (resp.data != null) { //if para actualizar la pregunta de alcohol
            
            $('#id_sla').val(resp.data.id_sla);
            $('#inicio_verde').val(resp.data.inicio_verde);
            $('#fin_verde').val(resp.data.fin_verde);
            $('#inicio_amarillo').val(resp.data.inicio_amarillo);
            $('#fin_amarillo').val(resp.data.fin_amarillo);
            $('#inicio_rojo').val(resp.data.inicio_rojo);
            $('#fin_rojo').val(resp.data.fin_rojo);

            opcion = resp.data.id_sla
            
                //envio de Accion PUT
                $('.btnAddObservacion').on('click', function () {
                    $('#accion').val("PUT");
                });

                // Editar Observacion 
                $('#btn-submit-observacion').on('click', function (e) {
                    e.preventDefault();

                //if (validateFormVivProtocoloSeguridad()) {

                    let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

                    let data = {
                        id_sla : opcion,
                        inicio_verde : $('#inicio_verde').val(),
                        fin_verde : $('#fin_verde').val(),
                        inicio_amarillo : $('#inicio_amarillo').val(),
                        fin_amarillo : $('#fin_amarillo').val(),
                        inicio_rojo : $('#inicio_rojo').val(),
                        fin_rojo : $('#fin_rojo').val(),
                    }

                    //console.log(data);

                    $.ajax({
                        method: method,
                        headers: {
                        "access-token": getToken()
                        },
                        url: url_site(`api/sla/update`),
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function (cand) {
                
                            alertSwal('success', 'SLA', 'Actualizado satisfactoriamente')
                
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
                } else{
                    //console.log(3000);
                        //envio de Accion POST
                        $('.btnAddObservacion').on('click', function () {
                        $('#accion').val("POST");
                        });
                
                        // Crear protocolo de seguridad de la vivienda
                        $('#btn-submit-observacion').on('click', function (e) {
                        e.preventDefault(e);
                
                        //if (validateFormVivProtocoloSeguridad()) {
                
                        let method = $('#accion').val();
                        let data = {
                            id_sla : $('#id_sla').val(),
                            inicio_verde : $('#inicio_verde').val(),
                            fin_verde : $('#fin_verde').val(),
                            inicio_amarillo : $('#inicio_amarillo').val(),
                            fin_amarillo : $('#fin_amarillo').val(),
                            inicio_rojo : $('#inicio_rojo').val(),
                            fin_rojo : $('#fin_rojo').val(),
                        }
                        //console.log(data);
                        $.ajax({
                            method: method,
                            headers: {
                                "access-token": getToken()
                            },
                            url: url_site(`api/sla/crear?id_sla =${data.id_sla}`),
                            contentType: 'application/json',
                            data: JSON.stringify(data),
                            dataType: "json",
                            success: function (r) {
                                if (r.status == "success") {
                                    alertSwal('success', 'SLA', 'guardado satisfactoriamente');
                                    $('#formObservacion')[0].reset();
                                    window.location = url_site(`sla`);
                                } else {
                                        alertSwal('error', 'tecnica y equipo', r.code.code);
                                    
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
                    });// Fin de Crear Preguntas de produccion de Drogas
            }

        }
    });

});//fin del document ready

