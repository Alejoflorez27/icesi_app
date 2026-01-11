$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    loadSelectOption({
        url: url_site(`api/configuracion/tipo_motivo_retiro`),
        input: [{
            id: 'tipo_retiro',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Tipo de motivo',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    loadSelectOption({
        url: url_site(`api/configuracion/tipo_motivo_retiro`),
        input: [{
            id: 'tipo_retiro_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Tipo de motivo',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })


    //loadSelectOption para cargar la lista de los Tipos de Parentescos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_contrato`),
        input: [{
            id: 'tipo_contrato',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de contrato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    //loadSelectOption para cargar la lista de los Tipos de Parentescos modal
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_contrato`),
        input: [{
            id: 'tipo_contrato_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de contrato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })


    //Cargar la tabla laboral
    cargarTablaLaboral();

    //envio de Accion POST
   $('.btnAddLaboral').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-laborall').on('click', function () {
        $('#formLaboral')[0].reset();
        $('#accion').val("PUT");
    });




    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Familiar
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');

    // Enviar id_solicitud a adjuntos
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`adjuntos?id_solicitud=${id_solicitudC}`)
    })

    // Enviar id_solicitud a formacion
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`familia?id_solicitud=${id_solicitudC}`)
    })
    
    // Crear laboral
    $('#btn-submit-laboral').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormlaboral()) {

            let method = $('#accion').val();
            let data = {
                id_laboral: $('#id_laboral').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                nombre_empresa: $('#nombre_empresa').val(),
                telefono_empresa: $('#telefono_empresa').val(),
                fch_ingreso: $('#fch_ingreso').val(),
                fch_retiro: $('#fch_retiro').val(),
                cargo_ingreso: $('#cargo_ingreso').val(),
                cargo_finalizo: $('#cargo_finalizo').val(),
                tipo_contrato: $('#tipo_contrato').val(),
                jefe_inmediato: $('#jefe_inmediato').val(),
                cargo_jefe: $('#cargo_jefe').val(),
                numero_jefe: $('#numero_jefe').val(),
                funciones_desarrolladas: $('#funciones_desarrolladas').val(),
                tipo_retiro: $('#tipo_retiro').val(),
                motivo_retiro: $('#motivo_retiro').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/laboral?id_laboral=${data.id_laboral}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Laboral', 'Laboral guardado satisfactoriamente');
                        cargarTablaLaboral();
                        $('#formLaboral')[0].reset();
                    } else {
                        alertSwal('error', 'Laboral', r.code.code);
                        cargarTablaLaboral();
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
    });// Fin de Crear Laboral


    //editar familiar
    $('#tbl-laboral').on('click', '.btnEditLaboral', function () {

        $('#accion').val("PUT");
        let id_laboral = $(this).attr('id_laboral');
        
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/laboral?id_laboral=${id_laboral}`),
            dataType: "json",
            success: function (resp) {
            
                $('#id_laboral').val(resp.data.id_laboral);
                $('#nombre_empresa_edit').val(resp.data.nombre_empresa);
                $('#telefono_empresa_edit').val(resp.data.telefono_empresa);
                $('#fch_ingreso_edit').val(resp.data.fch_ingreso);
                $('#fch_retiro_edit').val(resp.data.fch_retiro);
                $('#cargo_ingreso_edit').val(resp.data.cargo_ingreso);
                $('#cargo_finalizo_edit').val(resp.data.cargo_finalizo);
                $('#tipo_contrato_edit').val(resp.data.tipo_contrato);
                $('#jefe_inmediato_edit').val(resp.data.jefe_inmediato);
                $('#cargo_jefe_edit').val(resp.data.cargo_jefe);
                $('#numero_jefe_edit').val(resp.data.numero_jefe);
                $('#funciones_desarrolladas_edit').val(resp.data.funciones_desarrolladas);
                $('#motivo_retiro_edit').val(resp.data.motivo_retiro);
                $('#tipo_retiro_edit').val(resp.data.tipo_retiro);

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddLaboral').modal();
    })
    //fin editar laboral  
    
    $('#btn-submit-laborall').on('click', function (e) {
        e.preventDefault();
        if(validateFormLaboralEdit()){
            
            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
     
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                
                id_laboral: $('#id_laboral').val(),
                id_solicitud: id_solicitudC,
                nombre_empresa: $('#nombre_empresa_edit').val(),
                telefono_empresa: $('#telefono_empresa_edit').val(),
                fch_ingreso: $('#fch_ingreso_edit').val(),
                fch_retiro: $('#fch_retiro_edit').val(),
                cargo_ingreso: $('#cargo_ingreso_edit').val(),
                cargo_finalizo: $('#cargo_finalizo_edit').val(),
                tipo_contrato: $('#tipo_contrato_edit').val(),
                jefe_inmediato: $('#jefe_inmediato_edit').val(),
                cargo_jefe: $('#cargo_jefe_edit').val(),
                numero_jefe: $('#numero_jefe_edit').val(),
                funciones_desarrolladas: $('#funciones_desarrolladas_edit').val(),
                tipo_retiro: $('#tipo_retiro_edit').val(),

            }
            console.log(method);
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/laboral/update_laboral?id_laboral=${data.id_laboral}`), //Se le da el id_candidato de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Laboral',
                        'La Laboral ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaLaboral();
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
    $("#tbl-laboral").on("click", ".btnEliminarLaboral", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    // Función de eliminar
    $("#tbl-laboral").on("click", ".btnEliminarLaboral", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_laboral = $(this).attr('id_laboral');   // Se obtiene el id a eliminar

        let data = { id_laboral: id_laboral };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el registro laboral de forma permanente.",
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
                    url: url_site(`api/laboral/delete_laboral?id_laboral=${data.id_laboral}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'El registro laboral ha sido eliminado correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaLaboral();
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar el registro laboral.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
            }
        });
    });

}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear la laboral
function validateFormlaboral() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nombre_empresa').val() == "" || $('#nombre_empresa').val() == null) {
        alertSwal('error', 'Nombre Empresa', 'Este campo es obligatorio');
        $("#nombre_empresa").focus();
        return false;
    }
    if ($('#telefono_empresa').val() == "" || $('#telefono_empresa').val() == null) {
        alertSwal('error', 'Telefono Empresa', 'Este campo es obligatorio');
        $("#telefono_empresa").focus();
        return false;
    }
    if ($('#fch_ingreso').val() == "" || $('#fch_ingreso').val() == null) {
        alertSwal('error', 'Fecha Ingreso', 'Este campo es obligatorio');
        $("#fch_ingreso").focus();
        return false;
    }
    /*if ($('#fch_retiro').val() == "" || $('#fch_retiro').val() == null) {
        alertSwal('error', 'Fecha Retiro', 'Este campo es obligatorio');
        $("#fch_retiro").focus();
        return false;
    }*/
    if ($('#cargo_ingreso').val() == "" || $('#cargo_ingreso').val() == null) {
        alertSwal('error', 'Cargo Ingreso', 'Este campo es obligatorio');
        $("#cargo_ingreso").focus();
        return false;
    }
    if ($('#cargo_finalizo').val() == "" || $('#cargo_finalizo').val() == null) {
        alertSwal('error', 'Cargo Finalizo', 'Este campo es obligatorio');
        $("#cargo_finalizo").focus();
        return false;
    }
    if ($('#tipo_contrato').val() == "" || $('#tipo_contrato').val() == null) {
        alertSwal('error', 'Tipo Contrato', 'Este campo es obligatorio');
        $("#tipo_contrato").focus();
        return false;
    }
    if ($('#jefe_inmediato').val() == "" || $('#jefe_inmediato').val() == null) {
        alertSwal('error', 'Jefe Inmediato', 'Este campo es obligatorio');
        $("#jefe_inmediato").focus();
        return false;
    }
    if ($('#cargo_jefe').val() == "" || $('#cargo_jefe').val() == null) {
        alertSwal('error', 'Cargo Jefe', 'Este campo es obligatorio');
        $("#cargo_jefe").focus();
        return false;
    }
    if ($('#numero_jefe').val() == "" || $('#numero_jefe').val() == null) {
        alertSwal('error', 'Número Jefe', 'Este campo es obligatorio');
        $("#numero_jefe").focus();
        return false;
    }
    if ($('#funciones_desarrolladas').val() == "" || $('#funciones_desarrolladas').val() == null) {
        alertSwal('error', 'Funciones Desarrolladas', 'Este campo es obligatorio');
        $("#funciones_desarrolladas").focus();
        return false;
    }
    if ($('#tipo_retiro').val() == "" || $('#tipo_retiro').val() == null) {
        alertSwal('error', 'Motivo Retiro', 'Este campo es obligatorio');
        $("#tipo_retiro").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la laboral

//Funcion de Validar los campos de Editar la laboral
function validateFormLaboralEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nombre_empresa_edit').val() == "" || $('#nombre_empresa_edit').val() == null) {
        alertSwal('error', 'Nombre Empresa', 'Este campo es obligatorio');
        $("#nombre_empresa_edit").focus();
        return false;
    }
    if ($('#telefono_empresa_edit').val() == "" || $('#telefono_empresa_edit').val() == null) {
        alertSwal('error', 'Telefono Empresa', 'Este campo es obligatorio');
        $("#telefono_empresa_edit").focus();
        return false;
    }
    if ($('#fch_ingreso_edit').val() == "" || $('#fch_ingreso_edit').val() == null) {
        alertSwal('error', 'Fecha Ingreso', 'Este campo es obligatorio');
        $("#fch_ingreso_edit").focus();
        return false;
    }
    /*if ($('#fch_retiro_edit').val() == "" || $('#fch_retiro_edit').val() == null) {
        alertSwal('error', 'Fecha Retiro', 'Este campo es obligatorio');
        $("#fch_retiro_edit").focus();
        return false;
    }*/
    if ($('#cargo_ingreso_edit').val() == "" || $('#cargo_ingreso_edit').val() == null) {
        alertSwal('error', 'Cargo Ingreso', 'Este campo es obligatorio');
        $("#cargo_ingreso_edit").focus();
        return false;
    }
    if ($('#cargo_finalizo_edit').val() == "" || $('#cargo_finalizo_edit').val() == null) {
        alertSwal('error', 'Cargo Finalizo', 'Este campo es obligatorio');
        $("#cargo_finalizo_edit").focus();
        return false;
    }
    if ($('#tipo_contrato_edit').val() == "" || $('#tipo_contrato_edit').val() == null) {
        alertSwal('error', 'Tipo Contrato', 'Este campo es obligatorio');
        $("#tipo_contrato_edit").focus();
        return false;
    }
    if ($('#jefe_inmediato_edit').val() == "" || $('#jefe_inmediato_edit').val() == null) {
        alertSwal('error', 'Jefe Inmediato', 'Este campo es obligatorio');
        $("#jefe_inmediato_edit").focus();
        return false;
    }
    if ($('#cargo_jefe_edit').val() == "" || $('#cargo_jefe_edit').val() == null) {
        alertSwal('error', 'Cargo Jefe', 'Este campo es obligatorio');
        $("#cargo_jefe_edit").focus();
        return false;
    }
    if ($('#numero_jefe_edit').val() == "" || $('#numero_jefe_edit').val() == null) {
        alertSwal('error', 'Número Jefe', 'Este campo es obligatorio');
        $("#numero_jefe_edit").focus();
        return false;
    }
    if ($('#funciones_desarrolladas_edit').val() == "" || $('#funciones_desarrolladas_edit').val() == null) {
        alertSwal('error', 'Funciones Desarrolladas', 'Este campo es obligatorio');
        $("#funciones_desarrolladas_edit").focus();
        return false;
    }
    if ($('#tipo_retiro_edit').val() == "" || $('#tipo_retiro_edit').val() == null) {
        alertSwal('error', 'Motivo Retiro', 'Este campo es obligatorio');
        $("#tipo_retiro_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de editar la laboral


//Cargar datos de Laboral de la parte laboral
function cargarTablaLaboral() {
        //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
        let params = new URLSearchParams(location.search);
        let id_solicitudl = params.get('id_solicitud');

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/laboral/descripcion?id_solicitud=${id_solicitudl}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-laboral').DataTable().clear();
            $('#tbl-laboral').DataTable().destroy();

            let t = $('#tbl-laboral').DataTable({
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
                r.data.forEach((sol) => {

                    t.row.add([
                        sol.id_laboral,
                        sol.nombre_empresa,
                        sol.telefono_empresa,
                        sol.fch_ingreso,
                        sol.fch_retiro,
                        sol.cargo_ingreso,
                        sol.cargo_finalizo,
                        sol.tipo_contrato,
                        sol.jefe_inmediato,
                        sol.cargo_jefe,
                        sol.numero_jefe,
                        sol.funciones_desarrolladas,
                        sol.tipo_retiro,
                        `<button class="btn btn-xs btn-warning btnEditLaboral" id_laboral="${sol.id_laboral}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarLaboral" id_laboral=${sol.id_laboral}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de laboral

