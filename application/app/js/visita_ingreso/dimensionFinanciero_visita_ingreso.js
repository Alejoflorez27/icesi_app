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
        url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension Financiero
        input: [{
            id: 'variableFinanciero',                      //Nombre del campo en HTML
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
        url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension Financiero
        input: [{
            id: 'variableFinancieroEdit',                      //Nombre del campo en HTML
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
    cargarTablaFinancieroDimension();

    //envio de Accion POST
   $('.btnAddDimensionFinanciero').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-dimensionEditFinanciero').on('click', function () {
        //$('#formDimensionFinancieroedit')[0].reset();
        $('#accion').val("PUT");
    });

    // Enviar id_solicitud a sectorVivienda_visita_ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`financiero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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

                response.data.forEach((sol) => {
                    //console.log('sol:', sol.nombre_pregunta); // Verificar el valor de sol
                    switch (sol.id_pregunta) {
                        case '14':
                            countA++;
                            break;
                        case '15':
                            countB++;
                            break;
                        case '16':
                            countC++;
                            break;
                        default:
                            break;
                    }
                });

                if (countA > 0 && countB > 0 && countC > 0) {
                    window.location = url_site(`dimensionSalud_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                } else if (countA == 0) {
                    alertSwal('error', 'Falta la variable', 'UNO');
                }else if  (countB === 0) {
                    alertSwal('error', 'Falta la variable', 'DOS');
                }else if  (countC === 0) {
                    alertSwal('error', 'Falta la variable', 'TRES');
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
    //loadSelectOption para cargar la descripcion de la variable
    $('#variableFinanciero').on('change', function () {
        let id_pregunta = $('#variableFinanciero').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (variableFinanciero);
        
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
    /*funcion de poner en N/A para cuando el riesgo es inexistente
    $('#nivel_riesgo').on('change', function () {
        let nivel_riesgo = $('#nivel_riesgo').val();    //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        console.log (nivel_riesgo);

        if (nivel_riesgo == 'A') {
            $('#respuesta').val('N/A'); 
            $("#respuesta").prop("disabled", true);
        }else{
            $("#respuesta").prop("disabled", false);
        }
    });*/
    // Crear Dimension de Familiar
    $('#btn-submit-dimensionFinanciero').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormFamiliaDimension()) {
            $(this).prop('disabled', true);
            let method = $('#accion').val();
            let data = {
                id_pregunta: $('#variableFinanciero').val(),
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
                        alertSwal('success', 'Dimension Financiero', 'Variable guardada satisfactoriamente');
                        $('#btn-submit-dimensionFinanciero').prop('disabled', false);
                        cargarTablaFinancieroDimension();
                        $('#formDimensionFinanciero')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                        //loadSelectOption para cargar la lista de las variables
                        loadSelectOption({
                            url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension Financiero
                            input: [{
                                id: 'variableFinanciero',                      //Nombre del campo en HTML
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
                        cargarTablaFinancieroDimension();
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
        let id_pregunta = $('#variableFinanciero').val();
        //console.log(id_pregunta);
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
                    modalContent.innerText = resp.data[0].plantilla;
                }
            }).done(function () {
            hideModalLoading();
        });
        //$('#modalPlantilla').modal();
    })
    //fin visualizacion de plantilla

    //editar dimension familiar
    $('#tbl-financieroDimension').on('click', '.btnEditDimensionFinanciero', function () {
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
                $('#variableFinancieroEdit').val(resp.data.id_pregunta);
                $('#nivel_riesgoEdit').val(resp.data.nivel_riesgo);
                $('#respuestaEdit').val(resp.data.respuesta);
                $('#variableFinancieroEdit').prop("disabled", true);

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
    
    /*funcion de poner en N/A para cuando el riesgo es inexistente
    $('#nivel_riesgoEdit').on('change', function () {
        let nivel_riesgoEdit = $('#nivel_riesgoEdit').val();       //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (nivel_riesgoEdit);

        if (nivel_riesgoEdit == 'A') {
            $('#respuestaEdit').val('N/A'); 
            $("#respuestaEdit").prop("disabled", true);
        }else{
            $("#respuestaEdit").prop("disabled", false);
        }
    });*/

    $('#btn-submit-dimensionEditFinanciero').on('click', function (e) {
        e.preventDefault();
        if(validateFormSocialEditDimension()){
            
            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_respuesta: $('#id_respuesta').val(),
                id_pregunta: $('#variableFinancieroEdit').val(),
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
                        'Dimensión Financiero',
                        'La Variable ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaFinancieroDimension();
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
    $("#tbl-financieroDimension").on("click", ".btnEliminarDimensionFinanciero", function () {
        $('#accion').val("DELETE");
    })//Fin accion delete

    // Función de eliminar variable familiar (dimensión financiera)
    $("#tbl-financieroDimension").on("click", ".btnEliminarDimensionFinanciero", function (e) {
        e.preventDefault();

        let method = $('#accion').val(); // Se obtiene el método (DELETE, POST, etc.)
        let id_respuesta = $(this).attr('id_respuesta'); // Se obtiene el ID a eliminar

        let data = { id_respuesta: id_respuesta };

        // Confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la variable financiero de forma permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Solo si el usuario confirma, se realiza la eliminación
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
                            'La variable familiar ha sido eliminada correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaFinancieroDimension(); // Recarga la tabla actualizada
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar la variable familiar.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
            }
        });
    });


}); //fin de funcion Ready()



 //*********************************************************************** */
 //Se valida la lista de las variables para que no se repita si ya existe
 //*********************************************************************** */
 $('#variableFinanciero').on('change', function() {
        
    // $('#formDimensionFinanciero')[0].reset();
     var id_pregunta = $('#variableFinanciero').val();
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
                $("#variableFinanciero").focus();
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





//Funcion de Validar los campos de Crear de la dimension familiar
function validateFormFamiliaDimension() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#variableFinanciero').val() == "" || $('#variableFinanciero').val() == null) {
        alertSwal('error', 'variable Financiero', 'Este campo es obligatorio');
        $("#variableFinanciero").focus();
        return false;
    }
    if ($('#nivel_riesgo').val() == "" || $('#nivel_riesgo').val() == null) {
        alertSwal('error', 'nivel riesgo', 'Este campo es obligatorio');
        $("#nivel_riesgo").focus();
        return false;
    }
    if ($('#respuesta').val() == "" || $('#respuesta').val() == null) {
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

    if ($('#variableFinancieroEdit').val() == "" || $('#variableFinancieroEdit').val() == null) {
        alertSwal('error', 'variable Financiero', 'Este campo es obligatorio');
        $("#variableFinancieroEdit").focus();
        return false;
    }
    if ($('#nivel_riesgoEdit').val() == "" || $('#nivel_riesgoEdit').val() == null) {
        alertSwal('error', 'nivel riesgo', 'Este campo es obligatorio');
        $("#nivel_riesgoEdit").focus();
        return false;
    }
    if ($('#respuestaEdit').val() == "" || $('#respuestaEdit').val() == null) {
        alertSwal('error', 'justificación', 'Este campo es obligatorio');
        $("#respuestaEdit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de editar la dimension familiar

//Cargar datos de dimension familiar
function cargarTablaFinancieroDimension() {
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
        url: url_site(`api/dimensiones/descripcion?id_solicitud=${id_solicitudl}&id_dimension=${id_dimension}&id_servicio=${id_servicioC}`),//Dimension Financiero
        dataType: "json",
        success: function (r) {

            $('#tbl-financieroDimension').DataTable().clear();
            $('#tbl-financieroDimension').DataTable().destroy();

            let t = $('#tbl-financieroDimension').DataTable({
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
                        `<button class="btn btn-xs btn-warning btnEditDimensionFinanciero" id_respuesta="${sol.id_respuesta}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarDimensionFinanciero" id_respuesta=${sol.id_respuesta}><i class="fa fa-trash"></i> Eliminar</button>`,
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

