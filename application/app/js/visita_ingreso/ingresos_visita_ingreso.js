$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

/*    //loadSelectOption para cargar la lista de los Tipos de parantesco
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_parentesco`),
        input: [{
            id: 'tipo_familiar',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
*/
    //Cargar la tabla de los electrodomesticos de la vivienda
    cargarTablaVivIngresos();

    //informacion del modal de ayuda para el integrante
    // Datos para la publicación
    const tituloPublicacion = "Ayuda Integrante";
    const contenidoPublicacion = "Ayuda: Si son solteros que viven con su padres o cualquier otro familiar, solo colocar lo del candidato (a).";

    // Obtén una referencia al elemento del título del modal
    var tituloModalElemento = document.querySelector("#modalAyuda .modal-title");
    const contenidoModalElemento = document.querySelector("#modalAyuda .modal-body h4");

    // Actualizar el título y el contenido del modal
    tituloModalElemento.innerHTML = `<strong><span style="color: red;">${tituloPublicacion}</span></strong>`;
    contenidoModalElemento.innerHTML = contenidoPublicacion;



    //informacion del modal de ayuda1 para de donde proviene
    // Datos para la publicación
    const tituloPublicacion1 = "Ayuda de Donde Poviene";
    const contenidoPublicacion1 = "Ayuda: Describir cada uno de los conceptos de los que provienen los ingresos; Salario, Arriendos, Utilidades etc.).";

    // Obtén una referencia al elemento del título del modal
    var tituloModalElemento1 = document.querySelector("#modalAyuda1 .modal-title");
    const contenidoModalElemento1 = document.querySelector("#modalAyuda1 .modal-body h4");

    // Actualizar el título y el contenido del modal
    tituloModalElemento1.innerHTML = `<strong><span style="color: red;">${tituloPublicacion1}</span></strong>`;
    contenidoModalElemento1.innerHTML = contenidoPublicacion1;

/*    //loadSelectOption para cargar la lista de los Tipos de parantesco
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_parentesco`),
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
*/
    //envio de Accion POST
   $('.btnAddVivIngresos').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditIngresos').on('click', function () {
        $('#formVivIngresos')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
       
   /* // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`egresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`dimensionSocial_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })
    */
    // Crear ingresos de la vivienda
    $('#btn-submit-vivIngresos').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivIngresos()) {

            let method = $('#accion').val();
            let data = {
                id_ingreso: $('#id_ingreso').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                tipo_familiar: $('#tipo_familiar').val(),
                valor_ingreso: $('#valor_ingreso').val(),
                //valor_aporte: $('#valor_aporte').val(),
                ingreso_proveniente: $('#ingreso_proveniente').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivingresos?id_ingreso=${data.id_ingreso}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Ingresos', 'vivienda guardado satisfactoriamente');
                        //window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivIngresos();
                        $('#formVivIngresos')[0].reset();
                        //hideModalLoading();
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Ingresos de la vivienda', r.code.code);
                        cargarTablaVivIngresos();
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

    });// Fin de Crear ingresos de la vivienda


    //editar Ingresos de la vivienda
    $('#tbl-vivIngresos').on('click', '.btnEditVivIngresos', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_ingreso = $(this).attr('id_ingreso');
        //console.log(id_ingreso);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivingresos?id_ingreso=${id_ingreso}`),
            dataType: "json",
            success: function (resp) {
                $('#id_ingreso').val(resp.data.id_ingreso);
                $('#tipo_familiar_edit').val(resp.data.tipo_familiar);
                $('#valor_ingreso_edit').val(resp.data.valor_ingreso);
                //$('#valor_aporte_edit').val(resp.data.valor_aporte);
                $('#ingreso_proveniente_edit').val(resp.data.ingreso_proveniente);
                
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivIngresos').modal();
    })
    //fin de editar ingresos de la vivienda 
    
   $('#btn-submit-vivEditIngresos').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivIngresosEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {
                id_ingreso: $('#id_ingreso').val(),
                id_solicitud: id_solicitudC,
                tipo_familiar: $('#tipo_familiar_edit').val(),
                valor_ingreso: $('#valor_ingreso_edit').val(),
                //valor_aporte: $('#valor_aporte_edit').val(),
                ingreso_proveniente: $('#ingreso_proveniente_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivingresos/update_ingresos?id_ingreso=${data.id_ingreso}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Ingreso',
                        'La Ingreso de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        //window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivIngresos();
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
    $("#tbl-vivIngresos").on("click", ".btnEliminarVivIngresos", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivIngresos").on("click", ".btnEliminarVivIngresos", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_ingresoC = $(this).attr('id_ingreso');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_ingreso: id_ingresoC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivingresos/delete_ingresos?id_ingreso=${data.id_ingreso}`), //Se le da el id_ingreso de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Ingreso',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        //window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}`)
                        cargarTablaVivIngresos();
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

//Funcion de Validar los campos de Crear los electrodomesticos
function validateFormVivIngresos() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_familiar').val() == "" || $('#tipo_familiar').val() == null) {
        alertSwal('error', 'Tipo familiar', 'Este campo es obligatorio');
        $("#tipo_familiar").focus();
        return false;
    }
    if ($('#valor_ingreso').val() == "" || $('#valor_ingreso').val() == null) {
        alertSwal('error', 'Valor Ingreso', 'Este campo es obligatorio');
        $("#valor_ingreso").focus();
        return false;
    }
    /*if ($('#valor_aporte').val() == "" || $('#valor_aporte').val() == null) {
        alertSwal('error', 'Valor Aporte', 'Este campo es obligatorio');
        $("#valor_aporte").focus();
        return false;
    }*/
    if ($('#ingreso_proveniente').val() == "" || $('#ingreso_proveniente').val() == null) {
        alertSwal('error', 'Ingreso Proveniente', 'Este campo es obligatorio');
        $("#ingreso_proveniente").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la electrodomesticos de la vivienda

//Funcion de Validar los campos de Editar los electrodomesticos de la vivienda
function validateFormVivIngresosEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_familiar_edit').val() == "" || $('#tipo_familiar_edit').val() == null) {
        alertSwal('error', 'Tipo familiar', 'Este campo es obligatorio');
        $("#tipo_familiar_edit").focus();
        return false;
    }
    if ($('#valor_ingreso_edit').val() == "" || $('#valor_ingreso_edit').val() == null) {
        alertSwal('error', 'Valor Ingreso', 'Este campo es obligatorio');
        $("#valor_ingreso_edit").focus();
        return false;
    }
    /*if ($('#valor_aporte_edit').val() == "" || $('#valor_aporte_edit').val() == null) {
        alertSwal('error', 'Valor Aporte', 'Este campo es obligatorio');
        $("#valor_aporte_edit").focus();
        return false;
    }*/
    if ($('#ingreso_proveniente_edit').val() == "" || $('#ingreso_proveniente_edit').val() == null) {
        alertSwal('error', 'Ingreso Proveniente', 'Este campo es obligatorio');
        $("#ingreso_proveniente_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Editar la electrodomesticos


//Cargar datos de ingresos de vivienda
function cargarTablaVivIngresos() {
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
        url: url_site(`api/vivingresos/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivIngresos').DataTable().clear();
            $('#tbl-vivIngresos').DataTable().destroy();

            let t = $('#tbl-vivIngresos').DataTable({
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
            var total_ingreso = 0;
            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {
                    
                    total_ingreso += parseInt(sol.valor_ingreso);
                    
                    t.row.add([
                        //sol.id_ingreso,
                        contador++,
                        sol.descripcion_tipo_integrante,
                        '$ '+ sol.valor_ingreso,
                        //'$ '+ sol.valor_aporte,
                        sol.ingreso_proveniente,
                        `<button class="btn btn-xs btn-warning btnEditVivIngresos" id_ingreso="${sol.id_ingreso}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivIngresos" id_ingreso=${sol.id_ingreso}><i class="fa fa-trash"></i> Eliminar</button>`,
                        sol.usr_create,
                        sol.fch_create
                    ]);

                });
                
                let h1Element = document.getElementById("total_ingreso"); // Obtener la referencia al elemento <h2>

                // Redondear a 0 decimales utilizando Math.floor
                let total_ingreso_sin_decimales = Math.floor(total_ingreso);
                
                // Formatear como moneda colombiana (COP) sin ceros adicionales después de la coma
                let total_ingreso_formateado = new Intl.NumberFormat("es-CO", {
                  style: "currency",
                  currency: "COP",
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0
                }).format(total_ingreso_sin_decimales);
                
                // Asignar el número truncado y formateado como contenido del elemento <h2>
                h1Element.innerHTML = total_ingreso_formateado;
                
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
//Fin de la tabla de los ingresos de la vivienda

