$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    $('.div-Asector').addClass('hide');

    var id_dimension = $('#id_dimension').val(); //Dimension de social y habitacional
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde la url
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');

    //loadSelectOption para cargar la lista de las variables
    loadSelectOption({
        url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension Salud
        input: [{
            id: 'variableSalud',                      //Nombre del campo en HTML
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
        url: url_site(`api/dimensiones/variables_dimensiones?id_servicio=${id_servicioC}&id_dimension=${id_dimension}`),//Dimension Salud
        input: [{
            id: 'variableSaludEdit',                      //Nombre del campo en HTML
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

    // Enviar id_solicitud a sectorVivienda_visita_ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`dimensionFinanciero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
                let countE = 0;

                response.data.forEach((sol) => {
                    //console.log('sol:', sol.nombre_pregunta); // Verificar el valor de sol
                    switch (sol.id_pregunta) {
                        case '18':
                            countA++;
                            break;
                        case '19':
                            countB++;
                            break;
                        case '20':
                            countC++;
                            break;
                        case '21':
                            countD++;
                            break;
                        case '22':
                            countE++;
                            break;
                        default:
                            break;
                    }
                });

                if (countA > 0 && countB > 0 && countC > 0 && countD > 0 && countE > 0) {
                    window.location = url_site(`dimensionCompromiso_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                } else if (countA == 0) {
                    alertSwal('error', 'Falta la variable', 'UNO');
                }else if  (countB === 0) {
                    alertSwal('error', 'Falta la variable', 'DOS');
                }else if  (countC === 0) {
                    alertSwal('error', 'Falta la variable', 'TRES');
                }else if  (countD === 0) {
                    alertSwal('error', 'Falta la variable', 'CUATRO');
                }else if  (countE === 0) {
                    alertSwal('error', 'Falta la variable', 'CINCO');
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
    
   
    
    var id_respuestaC = "";
    //Se pinta los campos de Nivel Riesgo y Informe por variable
    $('#variableSalud').on('change', function() {
        
       // $('#formDimensionFinanciero')[0].reset();
        var id_preguntaC = $('#variableSalud').val();
        //console.log(id_preguntaC)
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            //api/dimensiones/variables_familia_vm
            url: url_site(`api/dimensiones/v_mantenimiento_familia?id_pregunta=${id_preguntaC}`),
            contentType: 'application/json',
            dataType: "json",
            success: function (resp) {
                //console.log (resp);
                $('#descripcion').val(resp.data[0].descripcion);
            }
        })

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivsalud/variable_justificacion?id_solicitud=${id_solicitudC}&id_pregunta=${id_preguntaC}`),
            dataType: "json",
            
            success: function (resp) {
                //console.log(resp);
                if (resp.data != null) {
    
                    id_respuestaC = resp.data.id_respuesta;

                    if (resp.data.nivel_riesgo == 'A') {
                        $('.div-Asector').addClass('hide');
                    }
                    
                    $('#nivel_riesgo').val(resp.data.nivel_riesgo);
                    $('#respuesta').val(resp.data.respuesta);
                    $('#accion').val("PUT");
                }else{
                    $('#nivel_riesgo').val("");
                    $('#respuesta').val("");
                    $('#accion').val("POST");
                } 
            }
        })
    });

    //funcion de poner en N/A para cuando el riesgo es inexistente
    $('#nivel_riesgo').on('change', function () {
        let nivel_riesgo = $('#nivel_riesgo').val();    //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        let variables_salud = $('#variableSalud').val();
        //console.log (variables_salud);
        //console.log (nivel_riesgo);

        if (nivel_riesgo == 'A' && variables_salud == 18) {
            $('#respuesta').val('Actualmente No reporta antecedentes en su estado de salud física y mental. No requiere tratamientos médicos, ni consumo de medicamentos.'); 
            $("#respuesta").prop("disabled", true);
            $('.div-Asector').addClass('hide');
        }else if(nivel_riesgo == 'A' && variables_salud == 19){
            $('#respuesta').val('Durante su trayectoria laboral no ha presentado incapacidades importantes, diagnóstico de enfermedades ocupacionales, ni ha tenido accidentes de trabajo.'); 
            $("#respuesta").prop("disabled", true);
            $('.div-Asector').addClass('hide');
            //$("#respuesta").prop("disabled", false);
        }else if(nivel_riesgo == 'A' && variables_salud == 20){
            $('#respuesta').val('Manifiesta que su familia, no ha presentado antecedentes de salud mental y física.'); 
            $("#respuesta").prop("disabled", true);
            $('.div-Asector').addClass('hide');
        }else if(nivel_riesgo == 'A' && variables_salud == 21){
            $('#respuesta').val('El candidato (a), asegura que no ha requerido tratamientos por consumo de drogas o alcohol, al igual que su familiar.'); 
            $("#respuesta").prop("disabled", true);
            $('.div-Asector').addClass('hide');
        }else if(nivel_riesgo == 'A' && variables_salud == 22){
            $('#respuesta').val('El candidato (a), refiere que cuentan con hábitos de alimentación saludables y realizan actividad física regularmente.'); 
            $("#respuesta").prop("disabled", true);
            $('.div-Asector').addClass('hide');
        }else{
            //$("#respuesta").prop("disabled", false);
            $("#respuesta").val("");
			$('.div-Asector').removeClass('hide');
            //$("#respuesta").prop("disabled", false);
            //$("#respuesta").prop("disabled", true);
        }
    });

    //Evento del boton guardar
    $('#btn-submit-dimensionSalud').on('click', function (e) {
        e.preventDefault();

        if(validateFormFamiliaDimension()){

            let id_pregunta = $('#variableSalud').val(); 
            let nivel_riesgo = $('#nivel_riesgo').val();
            let respuesta = $('#respuesta').val();
            let method =  $('#accion').val(); 
            let id_solicitud = id_solicitudC;
            let id_servicio = id_servicioC;
            let id_respuesta = id_respuestaC;

            let data = "";           
            switch (method) {
                case 'POST':
                   // method = 'POST';
                    data = {
                        id_pregunta: id_pregunta,
                        id_solicitud: id_solicitud,
                        id_servicio: id_servicioC,
                        nivel_riesgo: nivel_riesgo,
                        respuesta: respuesta
                    }
                    url = `api/dimensiones`;
                    $(this).prop('disabled', true);
                    //console.log(data); 
                    break;
                case 'PUT':
                   // method = 'PUT';
                    data = {                                //Se Prepara la Data que va a ser modificada en la BD
                        id_respuesta: id_respuesta,
                        id_pregunta: id_pregunta,
                        nivel_riesgo: nivel_riesgo,
                        respuesta: respuesta
                    }
                    url = `api/dimensiones/update_dimensiones_familia?id_respuesta=${data.id_respuesta}`;
                    console.log(data);    
                    break;
            } 

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(url),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Dimension Salud', 'Variable Actualizada satisfactoriamente');
                        $('#btn-submit-dimensionSalud').prop('disabled', false);
                        $('#accion').val("PUT");

                        $.ajax({
                            headers: {
                                "access-token": getToken()
                            },
                            type: "GET",
                            url: url_site(`api/vivsalud/variable_justificacion?id_solicitud=${id_solicitudC}&id_pregunta=${id_pregunta}`),
                            dataType: "json",
                            
                            success: function (resp) {
                                //console.log(resp);
                                if (resp.data != null) {
                                    id_respuestaC = resp.data.id_respuesta;
                                } 
                            }
                        })        
                        //window.location = url_site(`dimensionSalud_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Salud', r.code.code);
                        //cargarTablaFinancieroDimension();
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
     });    


    //======================================== PREGUNTAS POR ASPECTO DE VALIABLE SALUD  ==================================================================

    //Se pinta las caracteristicas de salud y los lista
    $('#variableSalud').on('change', async function() {
        //$('#tbl-Asector').DataTable().clear();
        $('.div-Asector').removeClass('hide');
        
        
        let id_salud = $(this).attr('id_salud');
        $('#id_salud').val(id_salud);
        var id_preguntaC = $('#variableSalud').val();
        //console.log(id_preguntaC)

        cargarVariables(); 
    })





    //========================================== Funcion para agregar por aspecto ===========================================
    //se le agregan a la caracterisficas  de variables de salud
    $('#tbl-variablesSalud').on('click', '.checkbox-servicio', async function() {

        let id_var_respuesta_salud = $(this).attr('id_variable_salud');
        //console.log(id_var_respuesta_salud);
      
        //toma el valor del check, si esta chequeado o no
        let isSelected = $(this).is(':checked');

       //  console.log(isSelected);

       //se guarda la seleccion sea 1 ó 0
        let activo = '1';
        if(isSelected){
            activo = 1;
        }else{
            activo = 0;
        }    


        showModalLoading();
        $.ajax({
            method: 'PUT',
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivsalud?id_var_respuesta_salud=${id_var_respuesta_salud}&activo=${activo}`),
            contentType: 'application/json',
           // data: JSON.stringify(data),
            dataType: "json",
            success: function(r) {

                if (r.status == "success") {
                    alertSwal('success', 'Preguntas por Variable', 'Variable '+ (isSelected ? 'Agregada' : 'Eliminada') +' correctamente');
                    cargarVariables();

                } else {
                    alertSwal('error', 'Preguntas por Variable', r.code.code);
                }
            },
            error: function(xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function() {
                hideModalLoading();
            }
        }); 

    })




    //funcion refresh, recarga las variables
    function cargarVariables()
    {
        let id_salud = $(this).attr('id_salud');
        $('#id_salud').val(id_salud);
        var id_preguntaC = $('#variableSalud').val();

        //Se inicializa en vacio la tabla de Aspectos fisicos
        let registros_tabla_sector = '';
        //ajax para ver todos los apectos fisicos
        //showModalLoading();

        let actObservacion = 0;
        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            //Se listan las opciones que estan en la base de datos por medio de la api
            url: url_site(`api/vivsalud/dim_validar_existe?id_solicitud=${id_solicitudC}&id_pregunta=${id_preguntaC}`),
            dataType: "json",
            success: function(resp) {
                //console.log(resp);
                $('#tbl-variablesSalud').DataTable().clear();
                $('#tbl-variablesSalud').DataTable().destroy();

                var t = $('#tbl-variablesSalud').DataTable({
                    paging: false,
                    ordering: false,
                    info: false,
                    searching: false,
                });
            
                //pinta las preguntas si existen
              //  resp.data.forEach(p => {
            if (resp.data.length > 1){ 
                resp.data.forEach((p, index) => {
                        t.row.add([
                            ` <input type="checkbox" class="checkbox-servicio" id_variable_salud="${p.id_var_respuesta_salud}" ${(p.activo == 1 ) ?'checked' : 'unchecked'}>`,
                            p.nombre_pregunta
                   /*    registros_tabla_sector += `
                        <tr>
                            <td style="width: 5%;">
                                <input type="checkbox" class="checkbox-servicio" id_variable_salud="${p.id_var_respuesta_salud}" ${(p.activo == 1 ) ?'checked' : 'unchecked'}>
                            </td>
                            <td style="width: 95%">
                                    ${p.nombre_pregunta}
                            </td>
                        </tr>`  */
                    ]);
                });
            }else{
                t.row.add([
                    ` <input type="checkbox" class="checkbox-servicio" id_variable_salud="${resp.data.id_var_respuesta_salud}" ${(resp.data.activo == 1 ) ?'checked' : 'unchecked'}>`,
                    resp.data.nombre_pregunta
                ]);

                if(resp.data.activo == 1)  actObservacion ++;
            }
            //pinta la tabla
            t.draw();    


                for (let index = 0; index < resp.data.length; index++) {
                    const element = resp.data[index].activo;
                  //  console.log(element); 
                  
                    if(element == 1) actObservacion ++;

                }
                //console.log(actObservacion);

                if (actObservacion > 0) {
                    var campo = document.getElementById("respuesta");
                    campo.disabled = false;
                }else{
                    //console.log(12);
                    var campo = document.getElementById("respuesta");
                    campo.disabled = true;
                }

               // $('#tbl-Asector-combo').html(registros_tabla_sector);
            } 
        });

    }//fin carga variables



    
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
            text: "Esta acción eliminará la variable Salud de forma permanente.",
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

//Funcion de Validar los campos de Crear de la dimension familiar
function validateFormFamiliaDimension() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#variableSalud').val() == "" || $('#variableSalud').val() == null) {
        alertSwal('error', 'variable Salud', 'Este campo es obligatorio');
        $("#variableSalud").focus();
        return false;
    }
    if ($('#nivel_riesgo').val() == "" || $('#nivel_riesgo').val() == null) {
        alertSwal('error', 'nivel riesgo', 'Este campo es obligatorio');
        $("#nivel_riesgo").focus();
        return false;
    }
    /*if ($('#respuesta').val() == "" || $('#respuesta').val() == null) {
        alertSwal('error', 'justificacion', 'Este campo es obligatorio');
        $("#respuesta").focus();
        return false;
    }*/
    return true;

}//Fin Funcion de Validar los campos de Crear la dimension familiar


