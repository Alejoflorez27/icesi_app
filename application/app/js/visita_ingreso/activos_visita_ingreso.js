$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //informacion del modal de ayuda para los activos
    // Datos para la publicación
    const tituloPublicacion = "Ayuda Activos";
    const contenidoPublicacion = "Ayuda: Preguntar todas las propiedades, incluidas las que no estén a nombre de ellos y que ellos hayan adquirido y se reciben un usufructo.";

    // Obtén una referencia al elemento del título del modal
    var tituloModalElemento = document.querySelector("#modalAyuda .modal-title");
    const contenidoModalElemento = document.querySelector("#modalAyuda .modal-body h4");

    // Actualizar el título y el contenido del modal
    tituloModalElemento.innerHTML = `<strong><span style="color: red;">${tituloPublicacion}</span></strong>`;
    contenidoModalElemento.innerHTML = contenidoPublicacion;

    // Obtener el elemento que deseas ocultar el de otro concepto de activo
    const campoParaOcultar = document.getElementById("ocultarAct");
    // Ocultar el elemento cambiando su propiedad de estilo
    campoParaOcultar.style.display = "none";

    // Obtener el elemento que deseas ocultar propietario de activo
    const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioAct");
    // Ocultar el elemento cambiando su propiedad de estilo
    campoParaOcultarPropietario.style.display = "none";


    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_activo_vi`),
        input: [{
            id: 'concepto_activo',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })



    //loadSelectOption para cargar la lista de los Tipos de pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_activo_vi`),
        input: [{
            id: 'concepto_activo_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
    

    //loadSelectOption para cargar la lista de los Tipos de plazo pasivo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
        input: [{
            id: 'tipo_familiar_act',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    

    //loadSelectOption para cargar la lista de los Tipos de responsable 
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
        input: [{
            id: 'tipo_familiar_act_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //Cargar la tabla de los activos de la vivienda
    cargarTablaVivActivos();

    //envio de Accion POST
   $('.btnAddVivActivos').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditActivos').on('click', function () {
        $('#formVivActivos')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
       
    // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`financiero_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
    
    $('#concepto_activo').on('change', function () {
        let concepto = $('#concepto_activo').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (concepto == 'J') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultarAct");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultarAct");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });

    $('#tipo_familiar_act').on('change', function () {
        let propietario = $('#tipo_familiar_act').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (propietario);
        if (propietario == 'OTR') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioAct");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioAct");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "none";
        }
    });
    // Crear pasivos de la vivienda
    $('#btn-submit-vivActivos').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivActivos()) {

            let method = $('#accion').val();
            let data = {
                id_activo: $('#id_activo').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                concepto_activo: $('#concepto_activo').val(),
                otros: $('#otrosAct').val(),
                tipo_familiar: $('#tipo_familiar_act').val(),
                otro_propietario: $('#otro_propietario_act').val(),
                descripcion_general_viv: $('#descripcion_general_viv').val(),
                valor_activo: $('#valor_activo').val(),
                valor_activo_catastral: $('#valor_activo_catastral').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivactivos?id_activo=${data.id_activo}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Activos', 'vivienda guardado satisfactoriamente');
                        //window.location = url_site(`activos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivActivos();
                        cargarTablaTotales();
                        $('#formVivActivos')[0].reset();
                            //loadSelectOption para cargar la lista de los Tipos de pasivo
                            loadSelectOption({
                                url: url_site(`api/configuracion/tipo_activo_vi`),
                                input: [{
                                    id: 'concepto_activo',                      //Nombre del campo en HTML
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Concepto',
                                    selectedValue: ''
                                },
                                ],
                                columnKey: 'codigo',
                                columnDescription: 'descripcion',  
                                responsePath: '',
                            })

                            //loadSelectOption para cargar la lista de los Tipos de plazo pasivo
                            loadSelectOption({
                                url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
                                input: [{
                                    id: 'tipo_familiar_act',                      //Nombre del campo en HTML
                                    clearOptions: true,
                                    emptyText: 'Seleccione un familiar o candidato',
                                    selectedValue: ''
                                },
                                ],
                                columnKey: 'codigo',
                                columnDescription: 'descripcion',  
                                responsePath: ''
                            })

                            // Obtener el elemento que deseas ocultar el de otro concepto de activo
                            const campoParaOcultar = document.getElementById("ocultarAct");
                            // Ocultar el elemento cambiando su propiedad de estilo
                            campoParaOcultar.style.display = "none";

                            // Obtener el elemento que deseas ocultar propietario de activo
                            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioAct");
                            // Ocultar el elemento cambiando su propiedad de estilo
                            campoParaOcultarPropietario.style.display = "none";
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Activos de la vivienda', r.code.code);
                        cargarTablaVivActivos();
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


    //editar pasivos de la vivienda
    $('#tbl-vivActivos').on('click', '.btnEditVivActivos', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_activo = $(this).attr('id_activo');
        //console.log(id_activo);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivactivos?id_activo=${id_activo}`),
            dataType: "json",
            success: function (resp) {

                //console.log(resp.data.concepto_activo);
                var otros = resp.data.concepto_activo;
                if (otros != 'J') {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultar = document.getElementById("ocultarActEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultar.style.display = "none";
                }else{
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultar = document.getElementById("ocultarActEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultar.style.display = "block";
                }

                
                var concepto = resp.data.tipo_familiar      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                //console.log (concepto);
                if (concepto != 'OTR') {
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioActEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultarPropietario.style.display = "none";
                }else{
                    // Obtener el elemento que deseas ocultar
                    const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioActEdit");
                    // Ocultar el elemento cambiando su propiedad de estilo
                    campoParaOcultarPropietario.style.display = "block";
                }

                $('#id_activo').val(resp.data.id_activo);
                $('#concepto_activo_edit').val(resp.data.concepto_activo);
                $('#otrosActEdit').val(resp.data.otros);
                $('#tipo_familiar_act_edit').val(resp.data.tipo_familiar);
                $('#otro_propietario_actEdit').val(resp.data.otro_propietario);
                $('#descripcion_general_viv_edit').val(resp.data.descripcion_general_viv);
                $('#valor_activo_edit').val(resp.data.valor_activo);
                $('#valor_activo_catastral_edit').val(resp.data.valor_activo_catastral);

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditVivActivos').modal();
    })
    //fin de editar pasivos de la vivienda 

    $('#concepto_activo_edit').on('change', function () {
        let conceptoEdit = $('#concepto_activo_edit').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (conceptoEdit == 'J') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultarActEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultarActEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });

    $('#tipo_familiar_act_edit').on('change', function () {
        let otro_propietarioEdit = $('#tipo_familiar_act_edit').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (otro_propietarioEdit == 'OTR') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioActEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultarPropietario = document.getElementById("ocultarPropietarioActEdit");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultarPropietario.style.display = "none";
        }
    });
    
   $('#btn-submit-vivEditActivos').on('click', function (e) {
        e.preventDefault();
        if(validateFormVivActivosEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            let data = {
                id_activo: $('#id_activo').val(),
                id_solicitud: id_solicitudC,
                concepto_activo: $('#concepto_activo_edit').val(),
                otros: $('#otrosActEdit').val(),
                tipo_familiar: $('#tipo_familiar_act_edit').val(),
                otro_propietario: $('#otro_propietario_actEdit').val(),
                descripcion_general_viv: $('#descripcion_general_viv_edit').val(),
                valor_activo: $('#valor_activo_edit').val(),
                valor_activo_catastral : $('#valor_activo_catastral_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivactivos/update_activos?id_activo=${data.id_activo}`), //Se le da el id_mobiliario de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Activos',
                        'La Activos de la Vivienda ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        //window.location = url_site(`activos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivActivos();
                        cargarTablaTotales();
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
    $("#tbl-vivActivos").on("click", ".btnEliminarVivActivos", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-vivActivos").on("click", ".btnEliminarVivActivos", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_activoC = $(this).attr('id_activo');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_activo: id_activoC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivactivos/delete_activos?id_activo=${data.id_activo}`), //Se le da el id_ingreso de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Activos',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        //window.location = url_site(`activos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivActivos();
                        cargarTablaTotales();
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

//Funcion de Validar los campos de Crear los pasivos
function validateFormVivActivos() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_activo').val() == "" || $('#concepto_activo').val() == null) {
        alertSwal('error', 'concepto Activo', 'Este campo es obligatorio');
        $("#concepto_activo").focus();
        return false;
    }
    if ($('#tipo_familiar_act').val() == "" || $('#tipo_familiar_act').val() == null) {
        alertSwal('error', 'Responsable Pasivo', 'Este campo es obligatorio');
        $("#tipo_familiar_act").focus();
        return false;
    }
    if ($('#descripcion_general_viv').val() == "" || $('#descripcion_general_viv').val() == null) {
        alertSwal('error', 'Descripcion General', 'Este campo es obligatorio');
        $("#descripcion_general_viv").focus();
        return false;
    }
    if ($('#valor_activo').val() == "" || $('#valor_activo').val() == null) {
        alertSwal('error', 'Valor Activo', 'Este campo es obligatorio');
        $("#valor_activo").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Crear la pasivos de la vivienda

//Funcion de Validar los campos de Editar los pasivos de la vivienda
function validateFormVivActivosEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_activo_edit').val() == "" || $('#concepto_activo_edit').val() == null) {
        alertSwal('error', 'concepto Activo', 'Este campo es obligatorio');
        $("#concepto_activo_edit").focus();
        return false;
    }
    if ($('#tipo_familiar_act_edit').val() == "" || $('#tipo_familiar_act_edit').val() == null) {
        alertSwal('error', 'Responsable Pasivo', 'Este campo es obligatorio');
        $("#tipo_familiar_act_edit").focus();
        return false;
    }
    if ($('#descripcion_general_viv_edit').val() == "" || $('#descripcion_general_viv_edit').val() == null) {
        alertSwal('error', 'Discripcion General de la Vivienda', 'Este campo es obligatorio');
        $("#descripcion_general_viv_edit").focus();
        return false;
    }
    if ($('#valor_activo_edit').val() == "" || $('#valor_activo_edit').val() == null) {
        alertSwal('error', 'Valor Activo', 'Este campo es obligatorio');
        $("#valor_activo_edit").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Editar los egresos


//Cargar datos de pasivos de vivienda
function cargarTablaVivActivos() {
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
        url: url_site(`api/vivactivos/lista_vi?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivActivos').DataTable().clear();
            $('#tbl-vivActivos').DataTable().destroy();

            let t = $('#tbl-vivActivos').DataTable({
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
            var total_activos = 0;
            if (r.status == "success") {

                let contador = 1;

                r.data.forEach((sol) => {
                    total_activos += parseInt(sol.valor_activo);
                    t.row.add([
                        //sol.id_activo,
                        contador++,
                        sol.descripcion_tipo_activo,
                        sol.otros,
                        sol.descripcion_tipo_responsable,
                        sol.otro_propietario,
                        sol.descripcion_general_viv,
                        '$ '+ (sol.valor_activo ? sol.valor_activo : '0'),
                        '$ '+ (sol.valor_activo_catastral ? sol.valor_activo_catastral : '0'),
                        `<button class="btn btn-xs btn-warning btnEditVivActivos" id_activo="${sol.id_activo}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarVivActivos" id_activo=${sol.id_activo}><i class="fa fa-trash"></i> Eliminar</button>`,
                        sol.usr_create,
                        sol.fch_create
                    ]);
                });
                let h1Element = document.getElementById("total_activos"); // Obtener la referencia al elemento <h2>
                // Redondear a 0 decimales utilizando Math.floor
                let total_activos_sin_decimales = Math.floor(total_activos);
                
                // Formatear como moneda colombiana (COP) sin ceros adicionales después de la coma
                let total_activos_formateado = new Intl.NumberFormat("es-CO", {
                  style: "currency",
                  currency: "COP",
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0
                }).format(total_activos_sin_decimales);
                
                // Asignar el número truncado y formateado como contenido del elemento <h2>
                h1Element.innerHTML = total_activos_formateado;
                $('#totalactivos').val(total_activos_formateado);
                
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
//Fin de la tabla de los egresos de la vivienda

