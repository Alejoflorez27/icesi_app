$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //loadSelectOption para cargar la lista de los Tipos de Parentescos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_parentesco`),
        input: [{
            id: 'parentesco',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de parentesco',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    //loadSelectOption para cargar la lista de los Tipos de Parentescos modal
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_parentesco`),
        input: [{
            id: 'parentesco_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de parentesco',
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
            id: 'nivel_escolar',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de nivel escolar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

        //loadSelectOption para cargar la lista de los Tipos de estados civil
        loadSelectOption({
            url: url_site(`api/configuracion/tipo_estado_civil`),
            input: [{
                id: 'estado_civil',                      //Nombre del campo en HTML
                clearOptions: true,
                emptyText: 'Seleccione un tipo de documento',
                selectedValue: ''
            },
            ],
            columnKey: 'codigo',
            columnDescription: 'descripcion',  
            responsePath: ''
        })

        //loadSelectOption para cargar la lista de los Tipos de estados civil
        loadSelectOption({
            url: url_site(`api/configuracion/tipo_estado_civil`),
            input: [{
                id: 'estado_civil_edit',                      //Nombre del campo en HTML
                clearOptions: true,
                emptyText: 'Seleccione un tipo de documento',
                selectedValue: ''
            },
            ],
            columnKey: 'codigo',
            columnDescription: 'descripcion',  
            responsePath: ''
        })

    //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares modal
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_nivel_escolar`),
        input: [{
            id: 'nivel_escolar_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de escolar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Paises
    loadSelectOption({
        //Consulta a la Api de ubicacion esto de Tipo GET
        url: url_site(`api/ubicacion/pais`),
        input: [{
            id: 'pais',                         //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione País',
            selectedValue: ''
        },],
        columnKey: 'id_pais',                   //Nombre de la PK del Pais de la tabla de conf_pais
        columnDescription: 'nombre',            //Nombre del Campo de Descripcion de Pais
        responsePath: 'data'                    //Respuesta de la data 
    })

    //pais-departamento-ciudad (Ubicacion Actual)
    //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
    $('#pais').on('change', function () {
        let pais = $('#pais').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        loadSelectOption({
            url: url_site(`api/ubicacion/dto?idPais=${pais}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
            input: [{
                id: 'departamento',
                clearOptions: true,
                emptyText: 'Seleccione Dpto',
                selectedValue: ''
            },],
            columnKey: 'id_dpto',
            columnDescription: 'nombre',
            responsePath: 'data'
            
        })
        
    })

    $('#departamento').on('change', function () {
        let dpto = $('#departamento').val();            //Se Crea una variable para guardar lo que pinto en el campo departamento para mandarlo por parametro

        loadSelectOption({
            url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
            input: [{
                id: 'id_ciudad_act',
                clearOptions: true,
                emptyText: 'Seleccione Ciudad',
                selectedValue: ''
            },],
            columnKey: 'id_ciudad',
            columnDescription: 'nombre',
            responsePath: 'data'
        })
    })

    $('#id_ciudad_act').on('change', function () {
        let ciudad = $('#id_ciudad_act').val();
        // Si la ciudad es BOGOTÁ muestra el campo Localidad, de lo contrario lo oculta
        if (ciudad == 149) {
            $('.div-localidad').removeClass('hide');
        } else {
            $('.div-localidad').addClass('hide');
        }

    })
    //loadSelectOption para cargar la lista de los Paises
    loadSelectOption({
        //Consulta a la Api de ubicacion esto de Tipo GET
        url: url_site(`api/ubicacion/pais`),
        input: [{
            id: 'pais_edit',                         //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione País',
            selectedValue: ''
        },],
        columnKey: 'id_pais',                   //Nombre de la PK del Pais de la tabla de conf_pais
        columnDescription: 'nombre',            //Nombre del Campo de Descripcion de Pais
        responsePath: 'data'                    //Respuesta de la data 
    })

    //pais-departamento-ciudad (modal editar)
    //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
    $('#pais_edit').on('change', function () {
        let pais = $('#pais_edit').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        loadSelectOption({
            url: url_site(`api/ubicacion/dto?idPais=${pais}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
            input: [{
                id: 'departamento_edit',
                clearOptions: true,
                emptyText: 'Seleccione Dpto',
                selectedValue: ''
            },],
            columnKey: 'id_dpto',
            columnDescription: 'nombre',
            responsePath: 'data'
            
        })
        
    })

    $('#departamento_edit').on('change', function () {
        let dpto = $('#departamento_edit').val();            //Se Crea una variable para guardar lo que pinto en el campo departamento para mandarlo por parametro

        loadSelectOption({
            url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
            input: [{
                id: 'id_ciudad_act_edit',
                clearOptions: true,
                emptyText: 'Seleccione Ciudad',
                selectedValue: ''
            },],
            columnKey: 'id_ciudad',
            columnDescription: 'nombre',
            responsePath: 'data'
        })
    })

    $('#id_ciudad_act_edit').on('change', function () {
        let ciudad = $('#id_ciudad_act_edit').val();
        // Si la ciudad es BOGOTÁ muestra el campo Localidad, de lo contrario lo oculta
        if (ciudad == 149) {
            $('.div-localidad').removeClass('hide');
        } else {
            $('.div-localidad').addClass('hide');
        }

    })
    //loadSelectOption para cargar la lista de los Tipos de vive o depende del candidato
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_vive_depende_candidato`),
        input: [{
            id: 'viv_candidato',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de vive o depende del candidato
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_vive_depende_candidato`),
        input: [{
            id: 'depende_candidato',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //Cargar la tabla de la formacion academica
    cargarTablaFamilia();

    //loadSelectOption para cargar la lista de los Tipos de vive o depende del candidato
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_vive_depende_candidato`),
        input: [{
            id: 'viv_candidato_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de vive o depende del candidato
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_vive_depende_candidato`),
        input: [{
            id: 'depende_candidato_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })



    //envio de Accion POST
   $('.btnAddFamilia').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-familiaa').on('click', function () {
        $('#formFamilia')[0].reset();
        $('#accion').val("PUT");
    });




    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');


    // Enviar id_solicitud a formacion
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`formacion?id_solicitud=${id_solicitudC}`)
    })
       
    // Enviar id_solicitud a laboral
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`laboral?id_solicitud=${id_solicitudC}`)
    })
    
    // Crear Familiar
    $('#btn-submit-familia').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormFamilia()) {

            let method = $('#accion').val();
            let data = {
                id_familia: $('#id_familia').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                id_ciudad_act: $('#id_ciudad_act').val(),
                parentesco: $('#parentesco').val(),
                nombre: $('#nombre').val(),
                apellido: $('#apellido').val(),
                edad: $('#edad').val(),
                estado_civil: $('#estado_civil').val(),
                nivel_escolar: $('#nivel_escolar').val(),
                ocupacion: $('#ocupacion').val(),
                empresa: $('#empresa').val(),
                viv_candidato: $('#viv_candidato').val(),
                depende_candidato: $('#depende_candidato').val(),
                telefono: $('#telefono').val(),
                residencia: $('#residencia').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/familia?id_familia=${data.id_familia}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Familia', 'Familia guardado satisfactoriamente');
                        cargarTablaFamilia();
                        $('#formFamilia')[0].reset();
                        //$('#modalAddServicio').modal('hide')
                        //loadSelectOption para cargar la lista de los Tipos de Niveles Escolares
                        window.location = url_site(`familia?id_solicitud=${id_solicitudC}`);
                    } else {
                        alertSwal('error', 'Familia', r.code.code);
                        cargarTablaFamilia();
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
    });// Fin de Crear Familiar


    //editar familiar
    $('#tbl-familia').on('click', '.btnEditfamilia', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_familia = $(this).attr('id_familia');
        
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/familia?id_familia=${id_familia}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp);
                $('#id_familia').val(resp.data.id_familia);
                $('#pais_edit').val(resp.data.id_pais);
                $('#parentesco_edit').val(resp.data.parentesco);
                $('#nombre_edit').val(resp.data.nombre);
                $('#apellido_edit').val(resp.data.apellido);
                $('#edad_edit').val(resp.data.edad);
                $('#estado_civil_edit').val(resp.data.estado_civil);
                $('#nivel_escolar_edit').val(resp.data.nivel_escolar);
                $('#ocupacion_edit').val(resp.data.ocupacion);
                $('#empresa_edit').val(resp.data.empresa);
                $('#viv_candidato_edit').val(resp.data.viv_candidato);
                $('#depende_candidato_edit').val(resp.data.depende_candidato);
                $('#telefono_edit').val(resp.data.telefono);
                $('#residencia_edit').val(resp.data.residencia);

                pais_id = resp.data.id_pais;
                departamento_id = resp.data.id_dpto;

                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/ubicacion/dto?idPais=${pais_id}`),  //Se le manda por parametro la variable global de Pais
                    dataType: "json",
                    
                    success: function (resp_ciu) {

                        $('#departamento_edit').val(resp.data.id_dpto);  //se le da el valor a los campos en el HTML

                        $.ajax({
                            headers: {
                                "access-token": getToken()
                            },
                            type: "GET",
                            url: url_site(`api/ubicacion/ciudad?idDpto=${departamento_id}`), //Se le manda por parametro la variable global de Departamento
                            dataType: "json",
                            
                            success: function (resp_dpt) {

                                $('#id_ciudad_act_edit').val(resp.data.id_ciudad_act);   //se le da el valor a los campos en el HTML
                            }
                        })
                    }
                })

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddFamilia').modal();
    })
    //fin editar familia  
    
    $('#btn-submit-familiaa').on('click', function (e) {
        e.preventDefault();
        if(validateFormFamiliaEdit()){
            
            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
     
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_familia: $('#id_familia').val(),
                id_ciudad_act:$('#id_ciudad_act_edit').val(),
                parentesco:$('#parentesco_edit').val(),
                nombre:$('#nombre_edit').val(),
                apellido:$('#apellido_edit').val(),
                edad:$('#edad_edit').val(),
                estado_civil:$('#estado_civil_edit').val(),
                nivel_escolar:$('#nivel_escolar_edit').val(),
                ocupacion:$('#ocupacion_edit').val(),
                empresa:$('#empresa_edit').val(),
                viv_candidato:$('#viv_candidato_edit').val(),
                depende_candidato:$('#depende_candidato_edit').val(),
                telefono:$('#telefono_edit').val(),
                residencia:$('#residencia_edit').val(),
            }
            console.log(data);
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/familia/update_familia?id_familia=${data.id_familia}`), //Se le da el id_candidato de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Familia',
                        'La Familia ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaFamilia();
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
    $("#tbl-familia").on("click", ".btnEliminarFamilia", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    // Función de eliminar
    $("#tbl-familia").on("click", ".btnEliminarFamilia", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_familia = $(this).attr('id_familia');   // Se obtiene el id a eliminar

        let data = { id_familia: id_familia };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el familiar de manera permanente.",
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
                    url: url_site(`api/familia/delete_familia?id_familia=${data.id_familia}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'La formación ha sido eliminada correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaFamilia();
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

//Funcion de Validar los campos de Crear la familiar
function validateFormFamilia() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#parentesco').val() == "" || $('#parentesco').val() == null) {
        alertSwal('error', 'parentesco', 'Este campo es obligatorio');
        $("#parentesco").focus();
        return false;
    }
    if ($('#nombre').val() == "" || $('#nombre').val() == null) {
        alertSwal('error', 'Nombre', 'Este campo es obligatorio');
        $("#nombre").focus();
        return false;
    }
    if ($('#apellido').val() == "" || $('#apellido').val() == null) {
        alertSwal('error', 'Apellido', 'Este campo es obligatorio');
        $("#apellido").focus();
        return false;
    }
    if ($('#edad').val() == "" || $('#edad').val() == null) {
        alertSwal('error', 'Edad', 'Este campo es obligatorio');
        $("#edad").focus();
        return false;
    }
    if ($('#telefono').val() == "" || $('#telefono').val() == null) {
        alertSwal('error', 'Número Familiar', 'Este campo es obligatorio');
        $("#telefono").focus();
        return false;
    }
    if ($('#nivel_escolar').val() == "" || $('#nivel_escolar').val() == null) {
        alertSwal('error', 'Nivel Escolar', 'Este campo es obligatorio');
        $("#nivel_escolar").focus();
        return false;
    }
    if ($('#ocupacion').val() == "" || $('#ocupacion').val() == null) {
        alertSwal('error', 'Ocupacion', 'Este campo es obligatorio');
        $("#ocupacion").focus();
        return false;
    }
    if ($('#empresa').val() == "" || $('#empresa').val() == null) {
        alertSwal('error', 'Empresa', 'Este campo es obligatorio');
        $("#empresa").focus();
        return false;
    }
    if ($('#estado_civil').val() == "" || $('#estado_civil').val() == null) {
        alertSwal('error', 'Estado Civil', 'Este campo es obligatorio');
        $("#estado_civil").focus();
        return false;
    }
    if ($('#residencia').val() == "" || $('#residencia').val() == null) {
        alertSwal('error', 'Residencia', 'Este campo es obligatorio');
        $("#residencia").focus();
        return false;
    }
    if ($('#pais').val() == "" || $('#pais').val() == null) {
        alertSwal('error', 'Pais de Residencia', 'Este campo es obligatorio');
        $("#pais").focus();
        return false;
    }
    if ($('#departamento').val() == "" || $('#departamento').val() == null) {
        alertSwal('error', 'Departamento de Residencia', 'Este campo es obligatorio');
        $("#departamento").focus();
        return false;
    }
    if ($('#id_ciudad_act').val() == "" || $('#id_ciudad_act').val() == null) {
        alertSwal('error', 'Ciudad de Recidencia', 'Este campo es obligatorio');
        $("#id_ciudad_act").focus();
        return false;
    }
    if ($('#viv_candidato').val() == "" || $('#viv_candidato').val() == null) {
        alertSwal('error', 'Vive Candidato', 'Este campo es obligatorio');
        $("#viv_candidato").focus();
        return false;
    }
    if ($('#depende_candidato').val() == "" || $('#depende_candidato').val() == null) {
        alertSwal('error', 'Depende Candidato', 'Este campo es obligatorio');
        $("#depende_candidato").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la familiar

//Funcion de Validar los campos de Editar la familiar
function validateFormFamiliaEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#parentesco_edit').val() == "" || $('#parentesco_edit').val() == null) {
        alertSwal('error', 'parentesco', 'Este campo es obligatorio');
        $("#parentesco_edit").focus();
        return false;
    }
    if ($('#nombre_edit').val() == "" || $('#nombre_edit').val() == null) {
        alertSwal('error', 'Nombre', 'Este campo es obligatorio');
        $("#nombre_edit").focus();
        return false;
    }
    if ($('#apellido_edit').val() == "" || $('#apellido_edit').val() == null) {
        alertSwal('error', 'Apellido', 'Este campo es obligatorio');
        $("#apellido_edit").focus();
        return false;
    }
    if ($('#edad_edit').val() == "" || $('#edad_edit').val() == null) {
        alertSwal('error', 'Edad', 'Este campo es obligatorio');
        $("#edad_edit").focus();
        return false;
    }
    if ($('#telefono_edit').val() == "" || $('#telefono_edit').val() == null) {
        alertSwal('error', 'Número del Candidato', 'Este campo es obligatorio');
        $("#telefono_edit").focus();
        return false;
    }
    if ($('#nivel_escolar_edit').val() == "" || $('#nivel_escolar_edit').val() == null) {
        alertSwal('error', 'Nivel Escolar', 'Este campo es obligatorio');
        $("#nivel_escolar_edit").focus();
        return false;
    }
    if ($('#ocupacion_edit').val() == "" || $('#ocupacion_edit').val() == null) {
        alertSwal('error', 'Ocupacion', 'Este campo es obligatorio');
        $("#ocupacion_edit").focus();
        return false;
    }
    if ($('#empresa_edit').val() == "" || $('#empresa_edit').val() == null) {
        alertSwal('error', 'Empresa', 'Este campo es obligatorio');
        $("#empresa_edit").focus();
        return false;
    }
    if ($('#estado_civil_edit').val() == "" || $('#estado_civil_edit').val() == null) {
        alertSwal('error', 'Estado Civil', 'Este campo es obligatorio');
        $("#estado_civil_edit").focus();
        return false;
    }
    if ($('#residencia_edit').val() == "" || $('#residencia_edit').val() == null) {
        alertSwal('error', 'Residencia', 'Este campo es obligatorio');
        $("#residencia_edit").focus();
        return false;
    }
    if ($('#pais_edit').val() == "" || $('#pais_edit').val() == null) {
        alertSwal('error', 'Pais de Residencia', 'Este campo es obligatorio');
        $("#pais_edit").focus();
        return false;
    }
    if ($('#departamento_edit').val() == "" || $('#departamento_edit').val() == null) {
        alertSwal('error', 'Departamento de Residencia', 'Este campo es obligatorio');
        $("#departamento_edit").focus();
        return false;
    }
    if ($('#id_ciudad_act_edit').val() == "" || $('#id_ciudad_act_edit').val() == null) {
        alertSwal('error', 'Ciudad de Residencia', 'Este campo es obligatorio');
        $("#id_ciudad_act_edit").focus();
        return false;
    }
    if ($('#viv_candidato_edit').val() == "" || $('#viv_candidato_edit').val() == null) {
        alertSwal('error', 'Vive Candidato', 'Este campo es obligatorio');
        $("#viv_candidato_edit").focus();
        return false;
    }
    if ($('#depende_candidato_edit').val() == "" || $('#depende_candidato_edit').val() == null) {
        alertSwal('error', 'Depende Candidato', 'Este campo es obligatorio');
        $("#depende_candidato_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de editar la familiar


//Cargar datos de Familiar de la parte academica
function cargarTablaFamilia() {
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/familia/descripcion?id_solicitud=${id_solicitudl}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-familia').DataTable().clear();
            $('#tbl-familia').DataTable().destroy();

            let t = $('#tbl-familia').DataTable({
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
                        sol.id_familia,
                        sol.descripcion_parentesco,
                        sol.nombre,
                        sol.apellido,
                        sol.edad,
                        sol.descripcion_estado_civil,
                        sol.descripcion_niv_escol,
                        sol.ocupacion,
                        sol.empresa,
                        sol.viv_candidato,
                        sol.depende_candidato,
                        sol.telefono,
                        sol.id_ciudad_act,
                        sol.residencia,
                        `<button class="btn btn-xs btn-warning btnEditfamilia" id_familia="${sol.id_familia}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarFamilia" id_familia=${sol.id_familia}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de familiar

