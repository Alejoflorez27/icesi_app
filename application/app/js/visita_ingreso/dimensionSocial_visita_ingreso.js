$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    var id_dimension = $('#id_dimension').val(); //Dimension de social y habitacional
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde la url
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');

    //loadSelectOption para cargar la lista de las variables
    loadSelectOption({
        url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension de social y habitacional
        input: [{
            id: 'variableSocial',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione la variable',
            selectedValue: ''
        },
        ],
        columnKey: 'id_pregunta',
        columnDescription: 'nombre_pregunta',  
        responsePath: 'data'
    })

    //loadSelectOption para cargar la lista de los Tipos de Nivel de Riesgo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_nivel_riesgo`),
        input: [{
            id: 'nivel_riesgo',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione nivel de riesgo',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de las variables edit
    loadSelectOption({
        url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension de social y habitacional
        input: [{
            id: 'variableSocialEdit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione la variable',
            selectedValue: ''
        },
        ],
        columnKey: 'id_pregunta',
        columnDescription: 'nombre_pregunta',  
        responsePath: 'data'
    })

    //loadSelectOption para cargar la lista de los Tipos de Nivel de Riesgo edit
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_nivel_riesgo`),
        input: [{
            id: 'nivel_riesgoEdit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione nivel de riesgo',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })


    //Cargar la tabla de las dimensiones
    cargarTablaSocialDimension();

    //envio de Accion POST
   $('.btnAddDimensionSocial').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-dimensionEditSocial').on('click', function () {
        //$('#formDimensionSocialedit')[0].reset();
        $('#accion').val("PUT");
    });

    // Enviar id_solicitud a sectorVivienda_visita_ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`viviendaAnteriores_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
    const params = new URLSearchParams(location.search);
    const id_solicitud = params.get('id_solicitud');
    const id_servicio = params.get('id_servicio');

    const headers = {
        "access-token": getToken()
    };

    const urlValidation = url_site(`api/dimensiones/descripcion?id_solicitud=${id_solicitud}&id_dimension=${id_dimension}&id_servicio=${id_servicio}`);

    $.ajax({
        headers: headers,
        type: "GET",
        url: urlValidation,
        dataType: "json",
        success: function (response) {
            let countA = 0;
            let countB = 0;
            let countC = 0;
            let countD = 0;

            response.data.forEach((sol) => {
                //console.log('sol:', sol.nombre_pregunta); // Verificar el valor de sol
                switch (sol.id_pregunta) {
                    case '8':
                        countA++;
                        break;
                    case '9':
                        countB++;
                        break;
                    case '10':
                        countC++;
                        break;
                    case '11':
                        countD++;
                        break;
                    default:
                        break;
                }
            });

            if (countA > 0 && countB > 0 && countC > 0 && countD > 0) {
                window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
            } else if (countA == 0) {
                alertSwal('error', 'Falta la variable', 'UNO');
            }else if  (countB === 0) {
                alertSwal('error', 'Falta la variable', 'DOS');
            }else if  (countC === 0) {
                alertSwal('error', 'Falta la variable', 'TRES');
            }else if  (countD == 0) {
                alertSwal('error', 'Falta la variable', 'CUATRO');
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

    //*********************************************************************** */
    //Se valida la lista de las variables para que no se repita si ya existe
    //*********************************************************************** */
    $('#variableSocial').on('change', function() {
            
        // $('#formDimensionFinanciero')[0].reset();
        var id_pregunta = $('#variableSocial').val();
        let params = new URLSearchParams(location.search);
        let id_solicitudC = params.get('id_solicitud');
        //console.log(id_preguntaC)
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/dimensiones/validar_variable?id_pregunta=${id_pregunta}&id_solicitud=${id_solicitudC}`),
            dataType: "json",
            
            success: function (resp) {
            // console.log(resp.data);
                if (resp.data.length == 1) {

                    alertSwal('error', 'Variable', 'Esta variable ya ha sido guardada.');
                    $("#nivel_riesgo").prop("disabled", true);
                    $("#respuesta").prop("disabled", true);
                    $("#variableSocial").focus();
                    return false; 
                //   console.log(resp.data[0].existe);

                }
                else{
                // console.log(resp.data);
                $("#nivel_riesgo").prop("disabled", false);
                $("#respuesta").prop("disabled", false);
                }
            }
        })
    });

    //loadSelectOption para cargar la descripcion de la variable
    $('#variableSocial').on('change', function () {
        let id_pregunta = $('#variableSocial').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (variableSocial);
        
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            //api/dimensiones/variables_familia_vm
            url: url_site(`api/dimensiones/v_mantenimiento_familia?id_pregunta=${id_pregunta}`),
            contentType: 'application/json',
            dataType: "json",
            success: function (resp) {
                //console.log (resp);
                $('#descripcion').val(resp.data[0].descripcion);
            }
        }).done(function () {
            hideModalLoading();
        }); 
    });
    //funcion de poner en N/A para cuando el riesgo es inexistente
    $('#nivel_riesgo').on('change', function () {
        let nivel_riesgo = $('#nivel_riesgo').val();    //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (nivel_riesgo);

            $("#respuesta").prop("disabled", false);
            $('#respuesta').val('');
            document.getElementById('respuesta').placeholder='Se deben anotar las Señales de Alerta o Riesgos.';
        
    });
    // Crear Dimension social
    $('#btn-submit-dimensionSocial').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormSocialDimension()) {

            $(this).prop('disabled', true);

            let method = $('#accion').val();
            let data = {
                id_pregunta: $('#variableSocial').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                nivel_riesgo: $('#nivel_riesgo').val(),
                respuesta: $('#respuesta').val(),
            }
            //console.log(data);

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/dimensiones?id_respuesta=${data.id_respuesta}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    //console.log(r);
                    if (r.status == "success") {
                        alertSwal('success', 'Dimension Social', 'Variable guardada satisfactoriamente');
                        $('#btn-submit-dimensionSocial').prop('disabled', false);
                        cargarTablaSocialDimension();
                        $('#formDimensionSocial')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                        //loadSelectOption para cargar la lista de las variables
                        loadSelectOption({
                            url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension de social y habitacional
                            input: [{
                                id: 'variableSocial',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione la variable',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'id_pregunta',
                            columnDescription: 'nombre_pregunta',  
                            responsePath: 'data'
                        })

                        //loadSelectOption para cargar la lista de los Tipos de Nivel de Riesgo
                        loadSelectOption({
                            url: url_site(`api/configuracion/tipo_nivel_riesgo`),
                            input: [{
                                id: 'nivel_riesgo',                      //Nombre del campo en HTML
                                clearOptions: true,
                                emptyText: 'Seleccione nivel de riesgo',
                                selectedValue: ''
                            },
                            ],
                            columnKey: 'codigo',
                            columnDescription: 'descripcion',  
                            responsePath: ''
                        })
                    } else {
                        alertSwal('error', 'Social', r.code.code);
                        cargarTablaSocialDimension();
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
    });// Fin de Crear Dimension Familiar

    //inicio de visualizacion de plantilla
    $('.btnPlantilla').on('click', function (e) {
        e.preventDefault(e);
        let id_pregunta = $('#variableSocial').val();
        console.log(id_pregunta);
            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                type: "GET",
                url: url_site(`api/dimensiones/v_mantenimiento_familia?id_pregunta=${id_pregunta}`),
                contentType: 'application/json',
                dataType: "json",
                success: function (resp) {

                    var modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = resp.data[0].plantilla;
                }
            }).done(function () {
            hideModalLoading();
        });
        //$('#modalPlantilla').modal();
    })
    //fin visualizacion de plantilla

    //editar dimension familiar
    $('#tbl-socialDimension').on('click', '.btnEditDimensionSocial', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_respuesta = $(this).attr('id_respuesta');
        
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/dimensiones?id_respuesta=${id_respuesta}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp);
                $('#id_respuesta').val(resp.data.id_respuesta);
                $('#variableSocialEdit').val(resp.data.id_pregunta);
                $('#nivel_riesgoEdit').val(resp.data.nivel_riesgo);
                $('#respuestaEdit').val(resp.data.respuesta);
                $('#variableSocialEdit').prop("disabled", true);

                id_pregunta = resp.data.id_pregunta;
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/dimensiones/v_mantenimiento_familia?id_pregunta=${id_pregunta}`),
                    contentType: 'application/json',
                    dataType: "json",
                    success: function (resp) {
                        $('#descripcion_edit').val(resp.data[0].descripcion);
                        //$('#plantilla').val(resp.data.descripcion);
                    }
                })

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddDimensionFamilia').modal();
    })
    //fin editar dimension familia  
    //funcion de poner en N/A para cuando el riesgo es inexistente
    /*$('#nivel_riesgoEdit').on('change', function () {
        let nivel_riesgoEdit = $('#nivel_riesgoEdit').val();       //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (nivel_riesgoEdit);
        $("#respuestaEdit").prop("disabled", false);
        $('#respuestaEdit').val('');
        document.getElementById('respuestaEdit').placeholder='Se deben anotar las Señales de Alerta o Riesgos.';
    });*/
    $('#btn-submit-dimensionEditSocial').on('click', function (e) {
        e.preventDefault();
        if(validateFormSocialEditDimension()){
            
            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_respuesta: $('#id_respuesta').val(),
                id_pregunta: $('#variableSocialEdit').val(),
                nivel_riesgo: $('#nivel_riesgoEdit').val(),
                respuesta: $('#respuestaEdit').val(),
            }
            //console.log(data);
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/dimensiones/update_dimensiones_familia?id_respuesta=${data.id_respuesta}`), //Se le da el id_candidato de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Dimensión Social',
                        'La Variable ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaSocialDimension();
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
    
    //accion delete dimension familiar
    $("#tbl-socialDimension").on("click", ".btnEliminarDimensionSocial", function () {
        $('#accion').val("DELETE");
    })//Fin accion delete

    // Función de eliminar variable social
    $("#tbl-socialDimension").on("click", ".btnEliminarDimensionSocial", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_respuesta = $(this).attr('id_respuesta');   // Se obtiene el id a eliminar

        let data = { id_respuesta: id_respuesta };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la variable social de forma permanente.",
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
                    url: url_site(`api/dimensiones?id_respuesta=${data.id_respuesta}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'La variable social ha sido eliminada correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaSocialDimension();
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar la variable social.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
            }
        });
    });


}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear de la dimension familiar
function validateFormSocialDimension() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#variableSocial').val() == "" || $('#variableSocial').val() == null) {
        alertSwal('error', 'variable Familia', 'Este campo es obligatorio');
        $("#variableSocial").focus();
        return false;
    }
    if ($('#nivel_riesgo').val() == "" || $('#nivel_riesgo').val() == null) {
        alertSwal('error', 'nivel riesgo', 'Este campo es obligatorio');
        $("#nivel_riesgo").focus();
        return false;
    }
    if (($('#respuesta').val() == "" || $('#respuesta').val() == null) && $('#nivel_riesgo').val() != 'A') {
        alertSwal('error', 'justificación', 'Este campo es obligatorio');
        $("#respuesta").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la dimension familiar

//Funcion de Validar los campos de Editar la dimension familiar
function validateFormSocialEditDimension() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#variableSocialEdit').val() == "" || $('#variableSocialEdit').val() == null) {
        alertSwal('error', 'variable Familia', 'Este campo es obligatorio');
        $("#variableSocialEdit").focus();
        return false;
    }
    if ($('#nivel_riesgoEdit').val() == "" || $('#nivel_riesgoEdit').val() == null) {
        alertSwal('error', 'nivel riesgo', 'Este campo es obligatorio');
        $("#nivel_riesgoEdit").focus();
        return false;
    }
    if (($('#respuestaEdit').val() == "" || $('#respuestaEdit').val() == null) && $('#nivel_riesgoEdit').val() != 'A') {
        alertSwal('error', 'justificación', 'Este campo es obligatorio');
        $("#respuestaEdit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de editar la dimension familiar

//Cargar datos de dimension familiar
function cargarTablaSocialDimension() {
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    var id_dimension = $('#id_dimension').val();
    //console.log(id_dimension);
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/dimensiones/descripcion?id_solicitud=${id_solicitudl}&id_dimension=${id_dimension}&id_servicio=${id_servicioC}`),//Dimension de social y habitacional
        dataType: "json",
        success: function (r) {

            $('#tbl-socialDimension').DataTable().clear();
            $('#tbl-socialDimension').DataTable().destroy();

            let t = $('#tbl-socialDimension').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "asc"],
                ],
                //*dom: 'Bfrtip',
                /*buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Familiares',
                }],*/
            });

            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {

                    t.row.add([
                        //sol.id_respuesta,
                        contador++,
                        sol.nombre_pregunta,
                        sol.descripcion_niv_riesgo,
                        sol.respuesta,
                        `<button class="btn btn-xs btn-warning btnEditDimensionSocial" id_respuesta="${sol.id_respuesta}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarDimensionSocial" id_respuesta=${sol.id_respuesta}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de dimension social

