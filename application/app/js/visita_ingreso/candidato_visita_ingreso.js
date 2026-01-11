$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    abrirModalLectura()
    
    $('#fch_nacimiento').daterangepicker({ 
        singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            $('#edad').val(years);
    });

    //loadSelectOption para cargar la lista de los Tipos de Documentos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_identificacion`),
        input: [{
            id: 'tipo_id',                      //Nombre del campo en HTML
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
            id: 'estado_civil',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Estado Civil',
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
            emptyText: 'Seleccione un tipo de nivel Escolar',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
/*    //loadSelectOption para cargar la lista de los Tipos de Parentescos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_parentesco`),
        input: [{
            id: 'parentesco_visita',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de parentesco',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
*/
    //Se trae la Identificacion de un Usuario por medio de un hidden
    //let accion_candidato =  $('#accion_candidato').val();

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Familiar
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    //Se Crean las Variables Globales en Null para ir Guardando internamente lo que se trajo de las URLs por medio del AJAX
    /*var pais_id = null;
    var departamento_id = null;
    var pais_id_nac = null;
    var departamento_id_nac = null;
    var id_solicitud = null;*/

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/candidato/candidato_visitas?id_candidato=${id_solicitudC}`),
        dataType: "json",
        
        success: function (resp) {
        //console.log(resp);
        var identificacion = resp.data.numero_doc;      //Se le asigna el valor a identificacion que estraido de la consulta del CTR
        nombre = resp.data[0].nombre;
        id_solicitud = resp.data[0].id_solicitud;
                
                $('#id_candidato').val(resp.data[0].id_candidato);
                //$('#pais_nacimiento').val(resp.data[0].pais_nac);
                //$('#pais').val(resp.data[0].id_pais);
                $('#nombre').val(nombre);
                $('#apellido').val(resp.data[0].apellido);
                $('#numero_doc').val(resp.data[0].numero_doc);
                cboLoad('tipo_id', url_site(`api/configuracion/tipo_identificacion`), resp.data[0].tipo_id, true, '-Seleccione-');
                $('#fch_nacimiento').val(resp.data[0].fch_nacimiento);
                $('#edad').val(resp.data[0].edad);
                $('#libreta').val(resp.data[0].libreta);
                //$('#estado_civil').val(resp.data[0].estado_civil);
                $('#telefono').val(resp.data[0].telefono);
                $('#emali1').val(resp.data[0].email);
                $('#salario_dev').val(resp.data[0].salario_dev);
                $('#direccion').val(resp.data[0].direccion);
                $('#barrio').val(resp.data[0].barrio);
                $('#estracto').val(resp.data[0].estracto);
                //$('#nivel_escolar').val(resp.data[0].nivel_escolar);
                $('#cargo_desempeno').val(resp.data[0].cargo_desempeno);
                $('#persona_visita').val(resp.data[0].persona_visita);
                $('#parantesco_visita').val(resp.data[0].parantesco_visita);
                cboLoad('estado_civil', url_site(`api/configuracion/tipo_estado_civil`), resp.data[0].estado_civil, true, '-Seleccione-');
                cboLoad('nivel_escolar', url_site(`api/configuracion/tipo_nivel_escolar`), resp.data[0].nivel_escolar, true, '-Seleccione-');
                //cboLoad('parantesco_visita', url_site(`api/configuracion/tipo_parentesco`), resp.data[0].parantesco_visita, true, '-Seleccione-');

                $('#pais_ac').val(resp.data[0].id_pais);
                $('#pais_nac').val(resp.data[0].pais_nac);
                $('#dep_ac').val(resp.data[0].id_dpto);
                $('#dep_nac').val(resp.data[0].dpto_nac);
                $('#ciu_ac').val(resp.data[0].ciudad_id);
                $('#ciu_nac').val(resp.data[0].id_ciudad_nac);

                $('#departamento').val(resp.data[0].id_dpto);
            
                pais_id = resp.data[0].id_pais;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
                pais_id_nac = resp.data[0].pais_nac;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
                dpto_id = resp.data[0].id_dpto;
                dpto_id_nac = resp.data[0].dpto_nac;
                ciudad_id = resp.data[0].id_ciudad_act;   //se le da el valor a los campos en el HTML
                ciudad_id_nac = resp.data[0].id_ciudad_nac;
               // console.log(pais_id+" "+pais_id_nac+" -"+dpto_id+" "+dpto_id_nac+" -"+ciudad_id+" "+ciudad_id_nac);

               /* pais_id = resp.data[0].id_pais;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
                pais_id_nac = resp.data[0].pais_nac; */           //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta

                /*$.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/ubicacion/dto?idPais=${pais_id}`),  //Se le manda por parametro la variable global de Pais
                    dataType: "json",
                    
                    success: function (resp_ciu) {

                        $('#departamento').val(resp.data[0].id_dpto);  //se le da el valor a los campos en el HTML
                        $('#departamento_nacimiento').val(resp.data[0].dpto_nac);

                        departamento_id = resp.data[0].id_dpto;
                        departamento_id_nac = resp.data[0].dpto_nac;

                        $.ajax({
                            headers: {
                                "access-token": getToken()
                            },
                            type: "GET",
                            url: url_site(`api/ubicacion/ciudad?idDpto=${departamento_id}`), //Se le manda por parametro la variable global de Departamento
                            dataType: "json",
                            
                            success: function (resp_dpt) {

                                $('#id_ciudad_act').val(resp.data[0].id_ciudad_act);   //se le da el valor a los campos en el HTML
                                $('#id_ciudad_nac').val(resp.data[0].id_ciudad_nac);
                            }
                        })
                    }
                })*/

                loadSelectOption({
                    //Consulta a la Api de ubicacion esto de Tipo GET
                    url: url_site(`api/ubicacion/pais?$idPais=${pais_id}`),
                    input: [{
                        id: 'pais',                         //Nombre del campo en HTML
                        clearOptions: true,
                        emptyText: 'Seleccione País',
                        selectedValue: pais_id
                    },],
                    columnKey: 'id_pais',                   //Nombre de la PK del Pais de la tabla de conf_pais
                    columnDescription: 'nombre',            //Nombre del Campo de Descripcion de Pais
                    responsePath: 'data'                    //Respuesta de la data 
                });
              
                loadSelectOption({
                    url: url_site(`api/ubicacion/pais?$idPais=${pais_id_nac}`),
                    input: [{
                        id: 'pais_nacimiento',
                        clearOptions: true,
                        emptyText: 'Seleccione País',
                        selectedValue: pais_id_nac
                    },],
                    columnKey: 'id_pais',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                   
                });
                
                //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
                $('#pais').on('change', function () {
                    let pais = $('#pais').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                    console.log (pais);
                    $('#ciu_ac').empty();

                    loadSelectOption({
                        url: url_site(`api/ubicacion/dto?idPais=${pais}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
                        input: [{
                            id: 'departamento',
                            clearOptions: true,
                            emptyText: 'Seleccione Dpto',
                            selectedValue: dpto_id 
                        },],
                        columnKey: 'id_dpto',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                        
                    })
                    
                    
                    
                }); 
                
                 //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
                 $('#pais_nacimiento').on('change', function () {
                    let pais_id_nac = $('#pais_nacimiento').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                    console.log (pais);
                    
                    loadSelectOption({
                        url: url_site(`api/ubicacion/dto?idPais=${pais_id_nac}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
                        input: [{
                            id: 'departamento_nacimiento',
                            clearOptions: true,
                            emptyText: 'Seleccione Dpto',
                            selectedValue: dpto_id_nac
                        },],
                        columnKey: 'id_dpto',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                        
                    })

                    $('#ciu_nac').empty();
                });  
                
                $('#departamento').on('change', function () {
                    let dpto = $('#departamento').val();            //Se Crea una variable para guardar lo que pinto en el campo departamento para mandarlo por parametro
            
                    loadSelectOption({
                        url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
                        input: [{
                            id: 'id_ciudad_act',
                            clearOptions: true,
                            emptyText: 'Seleccione Ciudad',
                            selectedValue: ciudad_id
                        },],
                        columnKey: 'id_ciudad',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                    })
                });
    
    
                $('#departamento_nacimiento').on('change', function () {
                    let dpto = $('#departamento_nacimiento').val();            //Se Crea una variable para guardar lo que pinto en el campo departamento para mandarlo por parametro
            
                    loadSelectOption({
                        url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
                        input: [{
                            id: 'id_ciudad_nac',
                            clearOptions: true,
                            emptyText: 'Seleccione Ciudad',
                            selectedValue: ciudad_id_nac
                        },],
                        columnKey: 'id_ciudad',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                    })
                }); 
            }
    });

    $('#id_ciudad_act').on('change', function () {
        let ciudad = $('#id_ciudad_act').val();
        // Si la ciudad es BOGOTÁ muestra el campo Localidad, de lo contrario lo oculta
        if (ciudad == 149) {
            $('.div-localidad').removeClass('hide');
        } else {
            $('.div-localidad').addClass('hide');
        }

    });

    // Editar Candidato prueba
    $('#btn-submit-candidato').on('click', function (e) {
        e.preventDefault();

                if (validateFormCandidato()) {

                    let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
                    
                    let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                        id_candidato: $('#id_candidato').val(),
                        nombre: $('#nombre').val(),
                        apellido: $('#apellido').val(),
                        tipo_id: $('#tipo_id').val(),
                        numero_doc: $('#numero_doc').val(),
                        id_ciudad_act: $('#id_ciudad_act').val(),
                        id_ciudad_nac: $('#id_ciudad_nac').val(),
                        fch_nacimiento: $('#fch_nacimiento').val(),
                        edad: $('#edad').val(),
                        libreta: $('#libreta').val(),
                        estado_civil: $('#estado_civil').val(),
                        telefono: $('#telefono').val(),
                        email: $('#emali1').val(),
                        salario_dev: $('#salario_dev').val(),
                        direccion: $('#direccion').val(),
                        barrio: $('#barrio').val(),
                        estracto: $('#estracto').val(),
                        nivel_escolar: $('#nivel_escolar').val(),
                        cargo_desempeno: $('#cargo_desempeno').val(),
                        persona_visita: $('#persona_visita').val(),
                        parantesco_visita: $('#parantesco_visita').val(),
                        id_solicitud: id_solicitudC,
                    }
        
                    $.ajax({
                        method: method,
                        headers: {
                            "access-token": getToken()
                        },
                        url: url_site(`api/candidato/update_candidato_visita_ingreso?id_candidato=${data.id_candidato}`), //Se le da el id_candidato de la data
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function (cand) {
                            
                            alertSwal('success', 'Candidato', 'Candidato guardado satisfactoriamente')
                            let params = new URLSearchParams(location.search);
                            let id_servicioC = params.get('id_servicio');
                            $.ajax({
                                method: 'PUT',
                                headers: {
                                    "access-token": getToken()
                                },
                                url: url_site(`api/solicitud/estado_proceso_asesor?id_solicitud=${id_solicitud}&id_servicio=${id_servicioC}&estado=${'2'}&estado_proceso=${'4'}`),
                                contentType: 'application/json',
                                success: function () {
                                    
                                    window.location = url_site(`familia_visita_ingreso?id_solicitud=${id_solicitud}&id_servicio=${id_servicioC}`)
        
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
                }

    })


}); //fin de funcion Ready()

    //*****cargar la pantalla de la derecha "Usuarios"
    $('.btnMenu').on('click',function () {

        //    console.log($(this).attr('empresa'));
        //    console.log($(this).attr('nombre_empresa'));
    
            const empresa = $(this).attr('empresa');
            $('#id_empresa_vw_usuarios').val(empresa);
            $('#id_empresa_usuario').val(empresa);
        // $('#formVwUser')[0].reset();
    
            $('#span-cliente-usuarios').text($(this).attr('nombre_empresa'));
    
            $('#div-box-usuarios').removeClass('hide');
    
            //esconde la tabla terceros en caso q este abierto
            $('#div-box-subempresas').addClass('hide');
            $('#div-box-terceros').addClass('hide');
            $('#div-box-servicios').addClass('hide');
    
            //oculto una columna de la tabla empresas
            ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);
    
            $('#div-box-clientes').removeClass('col-md-12');
            $('#div-box-clientes').addClass('col-md-10');
            $('#empresaUsu').val(empresa);
         // $('#id_empresa_vw_subemp').val($(this).attr('empresa'));
    
    
            cargarTablaUsuarios();
    
    });

    //Ocultar la pantalla de la derecha terceros
    $('#btnCollapseUsuarios').on('click', function () {
        $('#div-box-usuarios').addClass('hide');
        $('#div-box-clientes').addClass('col-md-12');
        $('#div-box-clientes').removeClass('col-md-10');
    });
    /*************************
     * carga la tabla de usuarios
     * ************/
    function cargarTablaUsuarios() { 

        showModalLoading();
        let id_empresa = $('#id_empresa_vw_usuarios').val();
    
        ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);
    
        $.ajax({
            headers: { 'access-token': getToken() },
            type: "GET",
            url: url_site(`api/usuario/empresas?id_empresa=${id_empresa}`),
            dataType: "json",
            success: function (r) {
    
                $('#tbl-usuarios2').DataTable().clear();
                $('#tbl-usuarios2').DataTable().destroy();
    
                var t = $('#tbl-usuarios2').DataTable({
                    paging: true,
                    ordering: true,
                    info: false,
                    searching: true,
                    order: [
                        [0, "asc"],
                    ],
                    dom: '',
                    buttons: [{
                        extend: 'excel',
                        title: 'REPORTE: Listado de Usuarios',
                    }],
                });
    
                if (r.status == "success") {
                    r.data.forEach((user, index) => {
                        t.row.add([
                            user.username,
                            user.perfil_desc,
                            `${user.nombres ?? ''} ${user.apellidos ?? ''}`,
                            user.tipo_identificacion,
                            user.numero_identificacion,
                           // user.correo,
                            user.empresa,
                            `<button class="btn btn-xs btn-${(user.estado == 'ACT') ? 'success' : 'danger'} btnEstadoUsuario"
                            username=${user.username} estado_usr=${user.estado}>
                            ${(user.estado == 'ACT') ? 'Activo' : 'Inactivo'}    
                             </button>`,
                        ]);
                    });
                };
               
                ocultarColumnaDataTable(t, 3);
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

/*
function cambiarpaisActual(pais, depto){
    //console.log(pais.depto);
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
        
    }); 
} */

//Funcion para validar los campos del formulario
function validateFormCandidato() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nombre').val() == "" || $('#nombre').val() == null) {
        alertSwal('error', 'Nombre Candidato', 'Este campo es obligatorio');
        $("#nombre").focus();
        return false;
    }
    if ($('#apellido').val() == "" || $('#apellido').val() == null) {
        alertSwal('error', 'Nombre Apellido', 'Este campo es obligatorio');
        $("#apellido").focus();
        return false;
    }
    if ($('#tipo_id').val() == "" || $('#tipo_id').val() == null) {
        alertSwal('error', 'Tipo de Documento', 'Este campo es obligatorio');
        $("#tipo_id").focus();
        return false;
    }
    if ($('#numero_doc').val() == "" || $('#numero_doc').val() == null) {
        alertSwal('error', 'Numero de Documento', 'Este campo es obligatorio');
        $("#numero_doc").focus();
        return false;
    }
    if ($('#pais_nacimiento').val() == "" || $('#pais_nacimiento').val() == null) {
        alertSwal('error', 'País de Nacimiento', 'Este campo es obligatorio');
        $("#pais_nacimiento").focus();
        return false;
    }
    if ($('#departamento_nacimiento').val() == "" || $('#departamento_nacimiento').val() == null) {
        alertSwal('error', 'Departamento de Nacimiento', 'Este campo es obligatorio');
        $("#departamento_nacimiento").focus();
        return false;
    }
    if ($('#id_ciudad_nac').val() == "" || $('#id_ciudad_nac').val() == null) {
        alertSwal('error', 'Ciudad de Nacimiento', 'Este campo es obligatorio');
        $("#id_ciudad_nac").focus();
        return false;
    }
    if ($('#fch_nacimiento').val() == "" || $('#fch_nacimiento').val() == null) {
        alertSwal('error', 'Fecha Nacimiento', 'Este campo es obligatorio');
        $("#fch_nacimiento").focus();
        return false;
    }
/////
    if ($('#pais').val() == "" || $('#pais').val() == null) {
        alertSwal('error', 'País de Nacimiento', 'Este campo es obligatorio');
        $("#pais").focus();
        return false;
    }
    if ($('#departamento').val() == "" || $('#departamento').val() == null) {
        alertSwal('error', 'Departamento Actual', 'Este campo es obligatorio');
        $("#departamento").focus();
        return false;
    }

    if ($('#id_ciudad_act').val() == "" || $('#id_ciudad_act').val() == null) {
        alertSwal('error', 'Ciudad Actual', 'Este campo es obligatorio');
        $("#id_ciudad_act").focus();
        return false;
    }

    if ($('#edad').val() == "" || $('#edad').val() == null) {
        alertSwal('error', 'Edad', 'Este campo es obligatorio');
        $("#edad").focus();
        return false;
    }
    /*if ($('#libreta').val() == "" || $('#libreta').val() == null) {
        alertSwal('error', 'Libreta', 'Este campo es obligatorio');
        $("#libreta").focus();
        return false;
    }*/
    if ($('#estado_civil').val() == "" || $('#estado_civil').val() == null) {
        alertSwal('error', 'Estado Civil', 'Este campo es obligatorio');
        $("#estado_civil").focus();
        return false;
    }
    if ($('#telefono').val() == "" || $('#telefono').val() == null) {
        alertSwal('error', 'Teléfono', 'Este campo es obligatorio');
        $("#telefono").focus();
        return false;
    }
    if ($('#direccion').val() == "" || $('#direccion').val() == null) {
        alertSwal('error', 'Dirección', 'Este campo es obligatorio');
        $("#direccion").focus();
        return false;
    }
    if ($('#barrio').val() == "" || $('#barrio').val() == null) {
        alertSwal('error', 'Barrio', 'Este campo es obligatorio');
        $("#barrio").focus();
        return false;
    }
    if ($('#estracto').val() == "" || $('#estracto').val() == null) {
        alertSwal('error', 'Estracto', 'Este campo es obligatorio');
        $("#estracto").focus();
        return false;
    }
    if ($('#nivel_escolar').val() == "" || $('#nivel_escolar').val() == null) {
        alertSwal('error', 'Nivel Escolar', 'Este campo es obligatorio');
        $("#nivel_escolar").focus();
        return false;
    }
    if ($('#cargo_desempeno').val() == "" || $('#cargo_desempeno').val() == null) {
        alertSwal('error', 'Cargo', 'Este campo es obligatorio');
        $("#cargo_desempeno").focus();
        return false;
    }
    if ($('#persona_visita').val() == "" || $('#persona_visita').val() == null) {
        alertSwal('error', 'Nombre de quien atiende la visita', 'Este campo es obligatorio');
        $("#persona_visita").focus();
        return false;
    }
    if ($('#salario_dev').val() == "" || $('#salario_dev').val() == null) {
        alertSwal('error', 'Salario a devengar', 'Este campo es obligatorio');
        $("#salario_dev").focus();
        return false;
    }
    if ($('#parantesco_visita').val() == "" || $('#parantesco_visita').val() == null) {
        alertSwal('error', ' Parentesco de quien atiende la visita', 'Este campo es obligatorio');
        $("#parantesco_visita").focus();
        return false;
    }

    return true;




}//Fin de Funcion para validar los campos del formulario

function abrirModalLectura() {
  $('#checkLeidoLectura').prop('checked', false);
  $('#btnCerrarLectura').prop('disabled', true);
  $('#contenidoLectura').html('Cargando contenido...');
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

  // Carga el contenido vía AJAX
  $.ajax({
    headers: {
      "access-token": getToken()
    },
    type: "GET",
    url: url_site(`api/empresa/especificacion_sol?id_solicitud=${id_solicitudC}`),
    dataType: "json",
    success: function (resp) {
      if (resp && resp.data && resp.data.especificacion) {
        $('#contenidoLectura').html(resp.data.especificacion);
      } else {
        $('#contenidoLectura').html('<p>No hay especificación disponible.</p>');
      }
    },
    error: function () {
      $('#contenidoLectura').html('<p>Error al cargar el contenido.</p>');
    }
  }).done(function () {
    hideModalLoading();
  });

  // Mostrar el modal y bloquear salida hasta que se acepte
  $('#modalLecturaObligatoria').modal({
    backdrop: 'static',  // No se cierra clickeando fuera
    keyboard: false       // No se cierra con ESC
  });
}

$('#checkLeidoLectura').on('change', function () {
  $('#btnCerrarLectura').prop('disabled', !$(this).is(':checked'));
});
