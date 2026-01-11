$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_nivel_escolar`),
        input: [{
            id: 'nivel_escolaridad',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de nivel Escolar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_nivel_escolar`),
        input: [{
            id: 'nivel_escolaridad_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de nivel Escolar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    //Cargar la tabla de la formacion academica
    cargarTablaFormacion();

    //envio de Accion POST
   $('.btnAddFormacion').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-formacionn').on('click', function () {
        $('#formFormacion')[0].reset();
        $('#accion').val("PUT");
    });




    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC= params1.get('id_servicio');
       
    // Enviar id_solicitud a familiar
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`familia?id_solicitud=${id_solicitudC}`)
    })

    // Enviar id_solicitud a familiar
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`candidato?id_solicitud=${id_solicitudC}`)
    })
    
    // Crear Formacion
    $('#btn-submit-formacion').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormFormacion()) {

            let method = $('#accion').val();
            let data = {
                id_formacion: $('#id_formacion').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                nivel_escolaridad: $('#nivel_escolaridad').val(),
                nombre_institucion: $('#nombre_institucion').val(),
                programa_academico: $('#programa_academico').val(),
                fch_grado: $('#fch_grado').val(),
                acta_folio: $('#acta_folio').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/formacion?id_formacion=${data.id_formacion}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Formación', 'Formación guardado satisfactoriamente');
                        cargarTablaFormacion();
                        $('#formFormacion')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Formación', r.code.code);
                        cargarTablaFormacion();
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
    });// Fin de Crear Formacion


    //editar formacion academica
    $('#tbl-formacion').on('click', '.btnEditformacion', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_formacion = $(this).attr('id_formacion');
        //console.log(id_formacion);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/formacion?id_formacion=${id_formacion}`),
            dataType: "json",
            success: function (resp) {
                $('#id_formacion').val(resp.data.id_formacion);
                $('#nivel_escolaridad_edit').val(resp.data.nivel_escolaridad);
                $('#nombre_institucion_edit').val(resp.data.nombre_institucion);
                $('#programa_academico_edit').val(resp.data.programa_academico);
                $('#fch_grado_edit').val(resp.data.fch_grado);
                $('#acta_folio_edit').val(resp.data.acta_folio);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddFormacion').modal();
    })
    //fin editar formacion academica 
    
    $('#btn-submit-formacionn').on('click', function (e) {
        e.preventDefault();
        if(validateFormFormacionEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
                        
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_formacion: $('#id_formacion').val(),
                nivel_escolaridad: $('#nivel_escolaridad_edit').val(),
                nombre_institucion: $('#nombre_institucion_edit').val(),
                programa_academico: $('#programa_academico_edit').val(),
                fch_grado: $('#fch_grado_edit').val(),
                acta_folio: $('#acta_folio_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/formacion/update_formacion?id_formacion=${data.id_formacion}`), //Se le da el id_candidato de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Formación',
                        'La Formación Académica ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaFormacion();
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
    $("#tbl-formacion").on("click", ".btnEliminarFormacion", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    // Función de eliminar
    $("#tbl-formacion").on("click", ".btnEliminarFormacion", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_formacionC = $(this).attr('id_formacion');   // Se obtiene el id a eliminar

        let data = { id_formacion: id_formacionC };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la formación de manera permanente.",
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
                    url: url_site(`api/formacion/delete_formacion?id_formacion=${data.id_formacion}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'La formación ha sido eliminada correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaFormacion();
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar la formación.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
            }
        });
    });


}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear la formacion
function validateFormFormacion() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nivel_escolaridad').val() == "" || $('#nivel_escolaridad').val() == null) {
        alertSwal('error', 'Nivel Escolar', 'Este campo es obligatorio');
        $("#nivel_escolaridad").focus();
        return false;
    }
    if ($('#nombre_institucion').val() == "" || $('#nombre_institucion').val() == null) {
        alertSwal('error', 'Nombre Institucion', 'Este campo es obligatorio');
        $("#nombre_institucion").focus();
        return false;
    }
    if ($('#programa_academico').val() == "" || $('#programa_academico').val() == null) {
        alertSwal('error', 'Programa Academico', 'Este campo es obligatorio');
        $("#programa_academico").focus();
        return false;
    }
    /*if ($('#fch_grado').val() == "" || $('#fch_grado').val() == null) {
        alertSwal('error', 'Fecha Grado', 'Este campo es obligatorio');
        $("#fch_grado").focus();
        return false;
    }
    if ($('#acta_folio').val() == "" || $('#acta_folio').val() == null) {
        alertSwal('error', 'Acta Folio', 'Este campo es obligatorio');
        $("#acta_folio").focus();
        return false;
    }*/
    return true;

}//Fin Funcion de Validar los campos de Crear la formacion

//Funcion de Validar los campos de Editar la formacion
function validateFormFormacionEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nivel_escolaridad_edit').val() == "" || $('#nivel_escolaridad_edit').val() == null) {
        alertSwal('error', 'Nivel Escolar', 'Este campo es obligatorio');
        $("#nivel_escolaridad_edit").focus();
        return false;
    }
    if ($('#nombre_institucion_edit').val() == "" || $('#nombre_institucion_edit').val() == null) {
        alertSwal('error', 'Nombre Institucion', 'Este campo es obligatorio');
        $("#nombre_institucion_edit").focus();
        return false;
    }
    if ($('#programa_academico_edit').val() == "" || $('#programa_academico_edit').val() == null) {
        alertSwal('error', 'Programa Academico', 'Este campo es obligatorio');
        $("#programa_academico_edit").focus();
        return false;
    }
    /*if ($('#fch_grado_edit').val() == "" || $('#fch_grado_edit').val() == null) {
        alertSwal('error', 'Fecha Grado', 'Este campo es obligatorio');
        $("#fch_grado_edit").focus();
        return false;
    }
    if ($('#acta_folio_edit').val() == "" || $('#acta_folio_edit').val() == null) {
        alertSwal('error', 'Acta Folio', 'Este campo es obligatorio');
        $("#acta_folio_edit").focus();
        return false;
    }*/
    return true;

}//Fin Funcion de Validar los campos de Editar la formacion


//Cargar datos de Formacion de la parte academica
function cargarTablaFormacion() {
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
        url: url_site(`api/formacion/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            console.log(r);
            $('#tbl-formacion').DataTable().clear();
            $('#tbl-formacion').DataTable().destroy();

            let t = $('#tbl-formacion').DataTable({
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
                r.data.forEach((sol) => {

                    t.row.add([
                        sol.id_formacion,
                        sol.descripcion_niv_escol,
                        sol.nombre_institucion,
                        sol.programa_academico,
                        sol.fch_grado,
                        sol.acta_folio,
                        `<button class="btn btn-xs btn-warning btnEditformacion" id_formacion="${sol.id_formacion}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarFormacion" id_formacion=${sol.id_formacion}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de la formacion academica

