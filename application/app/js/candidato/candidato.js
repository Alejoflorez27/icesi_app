$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    $('#fch_nacimiento').daterangepicker({ 
        singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            $('#edad').val(years);
     });

    $('#fch_expedicion').daterangepicker({ 
        singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {

     });

    //Se trae la Identificacion de un Usuario por medio de un hidden
    let accion_candidato =  $('#accion_candidato').val();

    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    //Consulta de los datos del candidato..
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/candidato/candidato?id_solicitud=${id_solicitudC}`),
        dataType: "json",
        
        success: function (resp) {
        //console.log(resp);
        var identificacion = resp.data.numero_doc;      //Se le asigna el valor a identificacion que estraido de la consulta del CTR
        nombre = resp.data[0].nombre;
        id_solicitud = resp.data[0].id_solicitud;
                
                $('#id_candidato').val(resp.data[0].id_candidato);
              //  $('#pais_nacimiento').val(resp.data[0].pais_nac);
              //  $('#pais').val(resp.data[0].id_pais);
                $('#nombre').val(nombre);
                $('#apellido').val(resp.data[0].apellido);
                $('#numero_doc').val(resp.data[0].numero_doc);
                cboLoad('tipo_id', url_site(`api/configuracion/tipo_identificacion`), resp.data[0].tipo_id, true, '-Seleccione-');
                $('#fch_nacimiento').val(resp.data[0].fch_nacimiento);
                $('#edad').val(resp.data[0].edad);
                $('#libreta').val(resp.data[0].libreta);
                $('#fch_expedicion').val(resp.data[0].fch_expedicion);
           //     $('#estado_civil').val(resp.data[0].estado_civil);
                cboLoad('estado_civil', url_site(`api/configuracion/tipo_estado_civil`), resp.data[0].estado_civil, true, '-Seleccione-');

                $('#telefono').val(resp.data[0].telefono);
                $('#direccion').val(resp.data[0].direccion);
                $('#barrio').val(resp.data[0].barrio);
                $('#estracto').val(resp.data[0].estracto);

                $('#pais_ac').val(resp.data[0].id_pais);
                $('#pais_nac').val(resp.data[0].pais_nac);
                $('#pais_expedicion').val(resp.data[0].pais_expe);

                $('#dep_ac').val(resp.data[0].id_dpto);
                $('#dep_nac').val(resp.data[0].dpto_nac);
                $('#departamento_expedicion').val(resp.data[0].dpto_expe);

                $('#ciu_ac').val(resp.data[0].ciudad_id);
                $('#ciu_nac').val(resp.data[0].id_ciudad_nac);
                $('#id_ciudad_expe').val(resp.data[0].id_ciudad_expe);

                $('#departamento').val(resp.data[0].id_dpto);
            
                pais_id = resp.data[0].id_pais;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
                pais_id_nac = resp.data[0].pais_nac;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
                pais_expedicion = resp.data[0].pais_expe;

                dpto_id = resp.data[0].id_dpto;
                dpto_id_nac = resp.data[0].dpto_nac;
                departamento_expedicion = resp.data[0].dpto_expe;

                ciudad_id = resp.data[0].id_ciudad_act;   //se le da el valor a los campos en el HTML
                ciudad_id_nac = resp.data[0].id_ciudad_nac;
                ciudad_id_expe = resp.data[0].id_ciudad_expe;
                //console.log(pais_id+" "+pais_id_nac+" -"+dpto_id+" "+dpto_id_nac+" -"+ciudad_id+" "+ciudad_id_nac);

                
             /*   $("#pais_nacimiento option[value='"+pais_id_nac+"']").attr("selected", true); 
                $("#pais option[value='"+pais_id+"']").attr("selected", true); 
               
                $("#departamento_nacimiento option[value='"+dpto_id_nac+"']").attr("selected", true); 
                $("#departamento option[value='"+dpto_id+"']").attr("selected", true); 
 */
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

                loadSelectOption({
                    url: url_site(`api/ubicacion/pais?$idPais=${pais_expedicion}`),
                    input: [{
                        id: 'pais_expedicion',
                        clearOptions: true,
                        emptyText: 'Seleccione País',
                        selectedValue: pais_expedicion
                    },],
                    columnKey: 'id_pais',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                   
                });
        
            
                //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
            $('#pais').on('change', function () {
                let pais = $('#pais').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                console.log (pais);
                
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
                
            }); 

             //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
             $('#pais_expedicion').on('change', function () {
                let pais_id_expedicion = $('#pais_nacimiento').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                //console.log (pais);
                
                loadSelectOption({
                    url: url_site(`api/ubicacion/dto?idPais=${pais_id_expedicion}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
                    input: [{
                        id: 'departamento_expedicion',
                        clearOptions: true,
                        emptyText: 'Seleccione Dpto',
                        selectedValue: departamento_expedicion
                    },],
                    columnKey: 'id_dpto',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                    
                })
                
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


            $('#departamento_expedicion').on('change', function () {
                let dpto = $('#departamento_expedicion').val();            //Se Crea una variable para guardar lo que pinto en el campo departamento para mandarlo por parametro
        
                loadSelectOption({
                    url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
                    input: [{
                        id: 'id_ciudad_expe',
                        clearOptions: true,
                        emptyText: 'Seleccione Ciudad',
                        selectedValue: ciudad_id_expe
                    },],
                    columnKey: 'id_ciudad',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })
            }); 
        }
    }); //Fin ajax

    
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
                direccion: $('#direccion').val(),
                barrio: $('#barrio').val(),
                estracto: $('#estracto').val(),
                id_solicitud : id_solicitudC,
                id_ciudad_expe: $('#id_ciudad_expe').val(),
                fch_expedicion: $('#fch_expedicion').val(),
            }
            //console.log(data)

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/candidato/update_candidato?id_candidato=${data.id_candidato}`), //Se le da el id_candidato de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    alertSwal('success', 'Candidato', 'Candidato guardado satisfactoriamente')


                    $.ajax({
                        headers: {
                            "access-token": getToken()
                        },
                        type: 'GET',
                        url: url_site(`api/solauto/sol_auto_servicio?id_solicitud=${id_solicitudC}`),
                        dataType: "json",
                        success: function (cand) {

                            console.log(cand.data[0])

                            if ((cand.data[0].id_auto == null) && (cand.data[0].resultado != 'no_aplica')) {
                               //console.log(1)
                               window.location = url_site(`autorizacion?id_solicitud=${id_solicitudC}`)
                                //window.location = url_site(`formacion?id_solicitud=${id_solicitudC}`)
                            } else {
                                window.location = url_site(`formacion?id_solicitud=${id_solicitudC}`)
                            }

                                

                        },
                        error: function (xhr, status, error) {
                            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                        },
                        complete: function () {
                            hideModalLoading();
                        }
                    });

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
}

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
        alertSwal('error', 'Libreta Militar', 'Este campo es obligatorio');
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
    return true;

}//Fin de Funcion para validar los campos del formulario
