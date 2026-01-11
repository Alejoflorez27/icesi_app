$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_persona_evaluada`),
        input: [{
            id: 'persona_evaluada',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Persona a Evaluar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })

    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_persona_evaluada`),
        input: [{
            id: 'persona_evaluada_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Persona a Evaluar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })

    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_riesgo_financiero_vi`),
        input: [{
            id: 'concepto_financiero',                      //Nombre del campo en HTML
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
    cargarTablaVivFinanciero();

    loadSelectOption({
        url: url_site(`api/configuracion/tipo_riesgo_financiero_vi`),
        input: [{
            id: 'concepto_financiero_edit',                      //Nombre del campo en HTML
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
    $('#btn-submit-vivEditFinanciero').on('click', function () {
        $('#formVivFinanciero')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
       
    // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`dimensionFinanciero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`pasivos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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

    //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
    $('#concepto_financiero').on('change', function () {
        let concepto_financiero = $('#concepto_financiero').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto_financiero);
        
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivfinanciero/concepto_completo?concepto_financiero=${concepto_financiero}`),
            dataType: "json",
            success: function (resp) {
                //console.log (resp);
                $('#concepto_financiero_completo').val(resp.data[0].observacion);
            }
        }).done(function () {
            hideModalLoading();
        });
        
    })

    $('#estado').on('change', function () {
        let estado = $('#estado').val();
        let aspecto = $('#concepto_financiero').val();
    
        if (estado === 'Si') {
            if (aspecto === 'A') {
                $('#descripcion_financiero').val('');
                document.getElementById('descripcion_financiero').placeholder = 'Colocar el producto financiero por el cual está reportado, la entidad financiera, saldo en mora y edad de la mora';
                $("#descripcion_financiero").prop("disabled", false);
            } else if (aspecto === 'B') {
                $('#descripcion_financiero').val('');
                document.getElementById('descripcion_financiero').placeholder = 'Monto del acuerdo de pago, hace cuanto se realizó y plazo para cancelarlo.';
                $("#descripcion_financiero").prop("disabled", false);
            } else if (aspecto === 'C') {
                $('#descripcion_financiero').val('');
                document.getElementById('descripcion_financiero').placeholder = 'Producto o productos por los cuales fue reportado, valor y hace cuanto canceló la o las moras.';
                $("#descripcion_financiero").prop("disabled", false);
            } else if (aspecto === 'D') {
                $('#descripcion_financiero').val('');
                document.getElementById('descripcion_financiero').placeholder = 'Parentesco del familiar, producto financiero por el cual está reportado, la entidad financiera, saldo en mora y edad de la mora.';
                $("#descripcion_financiero").prop("disabled", false);
            } else {
                document.getElementById('descripcion_financiero').placeholder = ''; // Deja la descripción vacía
                $("#descripcion_financiero").prop("disabled", false);
            }
        } else if (estado === 'No') {

            if (aspecto === 'A') {
                //$('#descripcion_financiero').val('El candidato (a), afirma que no cuenta con reportes negativos en centrales de riesgo financiero.');
                document.getElementById('descripcion_financiero').placeholder = 'El candidato (a), afirma que no cuenta con reportes negativos en centrales de riesgo financiero.';
                $("#descripcion_financiero").prop("disabled", false);
            } else if (aspecto === 'B') {
                //$('#descripcion_financiero').val('El candidato(a), no relaciona acuerdos de pago, ya que asegura que no tiene obligaciones financieras, o las deudas relacionadas se encuentran al día y vigentes, o no los ha realizado ya que no ha tenido el dinero para hacerlo.');
                document.getElementById('descripcion_financiero').placeholder = 'El candidato(a), no relaciona acuerdos de pago, ya que asegura que no tiene obligaciones financieras, o las deudas relacionadas se encuentran al día y vigentes, o no los ha realizado ya que no ha tenido el dinero para hacerlo.';
                $("#descripcion_financiero").prop("disabled", false);
            } else if (aspecto === 'C') {
                //$('#descripcion_financiero').val('El candidato (a) manifiesta que en su vida crediticia no ha presentado con anterioridad, reportes negativos anteriores en centrales de riesgo.');
                document.getElementById('descripcion_financiero').placeholder = 'El candidato (a) manifiesta que en su vida crediticia no ha presentado con anterioridad, reportes negativos anteriores en centrales de riesgo.';
                $("#descripcion_financiero").prop("disabled", false);
            } else if (aspecto === 'D') {
                //$('#descripcion_financiero').val('El candidato (a), es soltero o si vive en unión libre y es casado (a), el evaluado (a), afirma que su pareja no cuenta con reportes negativos en centrales de riesgo financiero.');
                document.getElementById('descripcion_financiero').placeholder = 'El candidato (a), es soltero o si vive en unión libre y es casado (a), el evaluado (a), afirma que su pareja no cuenta con reportes negativos en centrales de riesgo financiero.';
                $("#descripcion_financiero").prop("disabled", false);
            }
        } else {
            document.getElementById('descripcion_financiero').placeholder = ''; // Deja la descripción vacía
            $("#descripcion_financiero").prop("disabled", false);
        }
    });
    
    
    
    // Crear pasivos de la vivienda
    $('#btn-submit-vivFinanciero').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivFinanciero()) {

            let method = $('#accion').val();
            let data = {
                id_financiero: $('#id_financiero').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                persona_evaluada: $('#persona_evaluada').val(),
                concepto_financiero: $('#concepto_financiero').val(),
                estado: $('#estado').val(),
                descripcion_financiero: $('#descripcion_financiero').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivfinanciero?id_financiero=${data.id_financiero}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Activos', 'vivienda guardado satisfactoriamente');
                        window.location = url_site(`financiero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivFinanciero();
                        $('#formVivFinanciero')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Activos de la vivienda', r.code.code);
                        cargarTablaVivFinanciero();
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

    //var concepto =  resp.data.concepto_financiero;
    //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
    $('#concepto_financiero_edit').on('change', function () {
        let concepto_financiero = $('#concepto_financiero_edit').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto_financiero);
        
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivfinanciero/concepto_completo?concepto_financiero=${concepto_financiero}`),
            dataType: "json",
            success: function (resp) {
                //console.log (resp);
                $('#concepto_financiero_completo_edit').val(resp.data[0].observacion);
            }
        });
        
    })

    //editar pasivos de la vivienda
    $('#tbl-vivFinanciero').on('click', '.btnEditVivFinanciero', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_financiero = $(this).attr('id_financiero');
        //console.log(id_financiero);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivfinanciero?id_financiero=${id_financiero}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp.data.descripcion_tipo_concepto);
                $('#id_financiero').val(resp.data.id_financiero);
                $('#persona_evaluada_edit').val(resp.data.persona_evaluada);
                $('#concepto_financiero_edit').val(resp.data.concepto_financiero);
                $('#estado_edit').val(resp.data.estado);
                $('#descripcion_financiero_edit').val(resp.data.descripcion_financiero);
                $('#concepto_financiero_completo_edit').val(resp.data.observacion)

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivFinanciero').modal();

    })
    //fin de editar financiero de la vivienda 

    $('#estado_edit').on('change', function () {
        let estado_edit = $('#estado_edit').val();
        let aspecto_edit = $('#concepto_financiero_edit').val();
    
        if (estado_edit === 'Si') {
            if (aspecto_edit === 'A') {
                $('#descripcion_financiero_edit').val('');
                document.getElementById('descripcion_financiero_edit').placeholder = 'Colocar el producto financiero por el cual está reportado, la entidad financiera, saldo en mora y edad de la mora';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else if (aspecto_edit === 'B') {
                $('#descripcion_financiero_edit').val('');
                document.getElementById('descripcion_financiero_edit').placeholder = 'Monto del acuerdo de pago, hace cuanto se realizó y plazo para cancelarlo.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else if (aspecto_edit === 'C') {
                $('#descripcion_financiero_edit').val('');
                document.getElementById('descripcion_financiero_edit').placeholder = 'Producto o productos por los cuales fue reportado, valor y hace cuanto canceló la o las moras.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else if (aspecto_edit === 'D') {
                $('#descripcion_financiero_edit').val('');
                document.getElementById('descripcion_financiero_edit').placeholder = 'Parentesco del familiar, producto financiero por el cual está reportado, la entidad financiera, saldo en mora y edad de la mora.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else {
                document.getElementById('descripcion_financiero_edit').placeholder = ''; // Deja la descripción vacía
                $("#descripcion_financiero_edit").prop("disabled", false);
            }
        } else if (estado_edit === 'No') {
            if (aspecto_edit === 'A') {
                //$('#descripcion_financiero_edit').val('El candidato (a), afirma que no cuenta con reportes negativos en centrales de riesgo financiero.');
                document.getElementById('descripcion_financiero_edit').placeholder = 'El candidato (a), afirma que no cuenta con reportes negativos en centrales de riesgo financiero.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else if (aspecto_edit === 'B') {
                //$('#descripcion_financiero_edit').val('El candidato(a), no relaciona acuerdos de pago, ya que asegura que no tiene obligaciones financieras, o las deudas relacionadas se encuentran al día y vigentes, o no los ha realizado ya que no ha tenido el dinero para hacerlo.');
                document.getElementById('descripcion_financiero_edit').placeholder = 'El candidato(a), no relaciona acuerdos de pago, ya que asegura que no tiene obligaciones financieras, o las deudas relacionadas se encuentran al día y vigentes, o no los ha realizado ya que no ha tenido el dinero para hacerlo.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else if (aspecto_edit === 'C') {
                //$('#descripcion_financiero_edit').val('El candidato (a) manifiesta que en su vida crediticia no ha presentado con anterioridad, reportes negativos anteriores en centrales de riesgo.');
                document.getElementById('descripcion_financiero_edit').placeholder = 'El candidato (a) manifiesta que en su vida crediticia no ha presentado con anterioridad, reportes negativos anteriores en centrales de riesgo.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            } else if (aspecto_edit === 'D') {
                //$('#descripcion_financiero_edit').val('El candidato (a), es soltero o si vive en unión libre y es casado (a), el evaluado (a), afirma que su pareja no cuenta con reportes negativos en centrales de riesgo financiero.');
                document.getElementById('descripcion_financiero_edit').placeholder = 'El candidato (a), es soltero o si vive en unión libre y es casado (a), el evaluado (a), afirma que su pareja no cuenta con reportes negativos en centrales de riesgo financiero.';
                $("#descripcion_financiero_edit").prop("disabled", false);
            }
        } else {
            document.getElementById('descripcion_financiero_edit').placeholder = ''; // Deja la descripción vacía
            $("#descripcion_financiero_edit").prop("disabled", false);
        }
    });

   $('#btn-submit-vivEditFinanciero').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivFinancieroEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {
                id_financiero: $('#id_financiero').val(),
                id_solicitud: id_solicitudC,
                persona_evaluada: $('#persona_evaluada_edit').val(),
                concepto_financiero: $('#concepto_financiero_edit').val(),
                estado: $('#estado_edit').val(),
                descripcion_financiero: $('#descripcion_financiero_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivfinanciero/update_financiero?id_financiero=${data.id_financiero}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Financiero',
                        'Lo Financiero de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        window.location = url_site(`financiero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivFinanciero();
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
    $("#tbl-vivFinanciero").on("click", ".btnEliminarVivFinanciero", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    // Función de eliminar financiero
    $("#tbl-vivFinanciero").on("click", ".btnEliminarVivFinanciero", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_financieroC = $(this).attr('id_financiero');   // Se obtiene el id a eliminar

        let data = { id_financiero: id_financieroC };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el registro financiero de forma permanente.",
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
                    url: url_site(`api/vivfinanciero/delete_financiero?id_financiero=${data.id_financiero}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'El registro financiero ha sido eliminado correctamente.',
                            'success'
                        ).then(() => {
                            // Redirecciona y recarga la tabla
                            window.location = url_site(`financiero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                            cargarTablaVivFinanciero();
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar el registro financiero.', xhr.responseText);
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
 $('#concepto_financiero').on('change', function() {
        
    // $('#formDimensionFinanciero')[0].reset();
     var id_pregunta = $('#concepto_financiero').val();
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
         url: url_site(`api/vivfinanciero/validar_variable_pol_pre?id_pregunta=${id_pregunta}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
         dataType: "json",
         
         success: function (resp) {
             if (resp.data.length == 1) {

                alertSwal('error', 'Variable', 'Esta variable ya ha sido guardada.');
                $("#descripcion_financiero").prop("disabled", true);
                $("#estado").prop("disabled", true);
                $("#variableFamilia").focus();
                return false; 
             }
             else{
               $("#estado").prop("disabled", false);
               $("#descripcion_financiero").prop("disabled", false);
             }
         }
     })
 });

//Funcion de Validar los campos de Crear los pasivos
function validateFormVivFinanciero() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

/*    if ($('#persona_evaluada').val() == "" || $('#persona_evaluada').val() == null) {
        alertSwal('error', 'Persona Evaluada', 'Este campo es obligatorio');
        $("#persona_evaluada").focus();
        return false;
    }
*/    
    if (($('#concepto_financiero').val() == "" || $('#concepto_financiero').val() == null) && $('#estado').val() != 'No') {
        alertSwal('error', 'concepto Financiero', 'Este campo es obligatorio');
        $("#concepto_financiero").focus();
        return false;
    }
    if ($('#estado').val() == "" || $('#estado').val() == null) {
        alertSwal('error', 'estado Pasivo', 'Este campo es obligatorio');
        $("#estado").focus();
        return false;
    }
    if ($('#descripcion_financiero').val() == "" || $('#descripcion_financiero').val() == null) {
        alertSwal('error', 'Observación', 'Este campo es obligatorio');
        $("#descripcion_financiero").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Crear la pasivos de la vivienda

//Funcion de Validar los campos de Editar los pasivos de la vivienda
function validateFormVivFinancieroEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

/*    if ($('#persona_evaluada_edit').val() == "" || $('#persona_evaluada_edit').val() == null) {
        alertSwal('error', 'Persona Evaluada', 'Este campo es obligatorio');
        $("#persona_evaluada_edit").focus();
        return false;
    }
*/
    if (($('#concepto_financiero_edit').val() == "" || $('#concepto_financiero_edit').val() == null) && $('#estado_edit').val() != 'No') {
        alertSwal('error', 'concepto Financiero', 'Este campo es obligatorio');
        $("#concepto_financiero_edit").focus();
        return false;
    }
    if ($('#estado_edit').val() == "" || $('#estado_edit').val() == null) {
        alertSwal('error', 'estado Pasivo', 'Este campo es obligatorio');
        $("#estado_edit").focus();
        return false;
    }
    if ($('#descripcion_financiero_edit').val() == "" || $('#descripcion_financiero_edit').val() == null) {
        alertSwal('error', 'Observación', 'Este campo es obligatorio');
        $("#descripcion_financiero_edit").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Editar los egresos


//Cargar datos de financiero de vivienda
function cargarTablaVivFinanciero() {
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
        url: url_site(`api/vivfinanciero/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivFinanciero').DataTable().clear();
            $('#tbl-vivFinanciero').DataTable().destroy();

            let t = $('#tbl-vivFinanciero').DataTable({
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
                        //sol.id_financiero,
                        contador++,
                        //sol.descripcion_persona_evaluda,
                        sol.descripcion_tipo_financiero,
                        sol.estado,
                        sol.descripcion_financiero,
                        `<button class="btn btn-xs btn-warning btnEditVivFinanciero" id_financiero="${sol.id_financiero}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivFinanciero" id_financiero=${sol.id_financiero}><i class="fa fa-trash"></i> Eliminar</button>`,
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

