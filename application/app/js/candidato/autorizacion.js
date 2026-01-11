$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    // Enviar id_solicitud a candidato_visita_ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`como_hoja_vida_pol_pre?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
    
    // Enviar id_solicitud a laboral
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`preguntas_relevantes_pol_pre?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

      $('#archivo').on('change', function (e) {
        var archivo = this.files[0]; // alternativa más segura
        if (archivo) {
            $('#info').html(`<h5><strong>${archivo.name}</strong> <small>(${descripcionTamanoArchivo(archivo.size)})</small></h5>`);
            $('#lbl-archivo').html('Cambiar Archivo');
        } else {
            $('#info').html('<h5>No se seleccionó ningún archivo</h5>');
        }
    });

    //Función para traer la observación general del núcleo familiar
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/solauto/sol_auto?id_solicitud=${id_solicitudC}`),
        dataType: "json",
        
        success: function (resp) {

            console.log(resp.data[0]);

        if (resp.data && resp.data[0]) { //get
            
            $('#id_auto').val(resp.data.id_auto);
            $('#contactar_empleador').val(resp.data.contactar_empleador);
            $('#instituciones').val(resp.data.instituciones);
            $('#grabacion').val(resp.data.grabacion);
            $('#registro_foto').val(resp.data.registro_foto);
            $('#acepto').val(resp.data.acepto);
            $('#fch_candidato_auto').val(resp.data.fch_candidato_auto);

/*
            opcion = resp.data.id_auto
            
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
                        id_auto: $('#id_auto').val(),
                    }

                    //console.log(data);

                    $.ajax({
                        method: method,
                        headers: {
                        "access-token": getToken()
                        },
                        url: url_site(`api/tecnicaPolPre/update_tecnica_pol_pre?id_auto=${opcion}`),
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function (cand) {
                
                            alertSwal('success', 'tecnica y equipo', 'Actualizado satisfactoriamente')
                            //window.location = url_site(`tecnica_pol_pre?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                
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
*/
                } else {
                    //console.log(3000);
                        //envio de Accion POST
                        $('.btnAddObservacion').on('click', function () {
                        $('#accion').val("POST");
                        });
                
                        // Crear protocolo de seguridad de la vivienda
                        $('#btn-submit-observacion').on('click', function (e) {
                        e.preventDefault(e);
                        $(this).prop('disabled', true);
                
                        if (validateForm()) {
                
                        let method = $('#accion').val();
                        //console.log(data);
                        $.ajax({
                            headers: {
                                "access-token": getToken()
                            },
                            method: method,
                            url: url_site(`api/adjuntos/archivos_sol_auto?id_solicitud=${id_solicitudC}`),
                            data: new FormData(document.getElementById('formObservacion')),
                            processData: false,
                            cache: false,
                            contentType: false,
                            dataType: "json",
                            success: function (r) {
                                if (r.status == "success") {
                                    alertSwal('success', 'Autorización', 'guardado satisfactoriamente');
                                    $('#formObservacion')[0].reset();
                                    $('#submitButton').prop('disabled', false);
                                    window.location = url_site(`formacion?id_solicitud=${id_solicitudC}`)
                                } else {
                                        alertSwal('error', 'Autorización', r.code.code);
                                    
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
                    });// Fin de Crear Preguntas de produccion de Drogas
            }

        }
    });

});//fin del document ready

function validateForm() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#contactar_empleador').val() == "" || $('#contactar_empleador').val() == null) {
        alertSwal('error', 'Contactar a mi actual empleador', 'Este campo es obligatorio');
        $("#contactar_empleador").focus();
        return false;
    }
    if ($('#instituciones').val() == "" || $('#instituciones').val() == null) {
        alertSwal('error', 'Nombre Apellido', 'Este campo es obligatorio');
        $("#instituciones").focus();
        return false;
    }
    if ($('#grabacion').val() == "" || $('#grabacion').val() == null) {
        alertSwal('error', 'Se realice grabación de la visita domiciliaria', 'Este campo es obligatorio');
        $("#grabacion").focus();
        return false;
    }
    if ($('#registro_foto').val() == "" || $('#registro_foto').val() == null) {
        alertSwal('error', 'Registro fotográfico ', 'Este campo es obligatorio');
        $("#registro_foto").focus();
        return false;
    }
    if ($('#acepto').val() == "" || $('#acepto').val() == null) {
        alertSwal('error', 'Acepto y comprendo', 'Este campo es obligatorio');
        $("#acepto").focus();
        return false;
    }

    return true;
}

