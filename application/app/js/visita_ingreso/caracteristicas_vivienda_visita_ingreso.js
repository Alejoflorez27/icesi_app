$(document).ready(function () {

    $("body").addClass("sidebar-collapse");
    $('.div-Afisicos').addClass('hide');
    $('.div-Alimpieza').addClass('hide');

    cargarTablacaracteristica();

    //loadSelectOption para cargar la lista de los Tipos de vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_vivienda`),
        input: [{
            id: 'tipo_vivienda',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El Tipo de Vivienda',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de tenencia
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tenencia`),
        input: [{
            id: 'tipo_tenencia',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El Tipo de Tenencia',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de tamano vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tamano_vivienda`),
        input: [{
            id: 'tipo_tamano_vivienda',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El Tamaño de la Vivienda',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de tamano vivienda
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_vivienda_estado`),
        input: [{
            id: 'tipo_vivienda_estado',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El Estado de la Vivienda',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    //let id_servicioC = "3";

    // Enviar id_solicitud a candidato_visita_ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`dimensionFamilia_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
/*       
    // Enviar id_solicitud a laboral
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`distribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })
*/
// Enviar id_solicitud a adjuntos
$('#btn-submit-Siguiente').on('click', function () {
    // Obtener los parámetros de la URL
    const params = new URLSearchParams(location.search);
    const id_solicitud = params.get('id_solicitud');
    const id_servicio = params.get('id_servicio');
    
    // Definir los encabezados
    const headers = {
        "access-token": getToken()
    };
    
    // URL para la solicitud AJAX
    const urlList = url_site(`api/vivCaracteristica/lista?id_solicitud=${id_solicitud}&id_servicio=${id_servicio}`);
    
    // Hacer la primera solicitud AJAX
    $.ajax({
        headers: headers,
        type: "GET",
        url: urlList,
        dataType: "json",
        success: function (resp) {
            if (resp.status == "success" && resp.data.length > 0) {
                // Asumir que estamos utilizando el primer elemento de los datos
                const id_caracteristica = resp.data[0].id_caracteristica;
                
                // URL para la segunda solicitud AJAX
                const urlValidation = url_site(`api/vivCaracteristica/validacion_viv?id_caracteristica=${id_caracteristica}&id_solicitud=${id_solicitud}&id_servicio=${id_servicio}`);
                
                // Hacer la segunda solicitud AJAX
                $.ajax({
                    headers: headers,
                    type: "GET",
                    url: urlValidation,
                    dataType: "json",
                    success: function (r) {
                        //console.log(r);
                        var countFisico = 0;
                        var countLimpieza = 0;
                        var countPublicos = 0;
                        var countAdicionales = 0;
                        r.data.forEach(p => {
                            //console.log(p.categoria);
                            switch (p.categoria) {
                                case 'tipo_aspecto_fisico':
                                    countFisico++;
                                    break;
                                case 'tipo_aspecto_limpieza':
                                    countLimpieza++;
                                    break;
                                case 'tipo_aspecto_servicios':
                                    countPublicos++;
                                    break;
                                case 'tipo_aspecto_adicionales':
                                    countAdicionales++;
                                    break;
                            
                                default:
                                    break;
                            }
                        })
                        if (countFisico > 0 && countLimpieza > 0 && countPublicos > 0 && countAdicionales > 0) {
                            alertSwal('success', 'Finalizo las Caracteristicas de la Vivienda', 'Siguiente');
                            window.location = url_site(`newdistribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    
                            
                        } else if (countFisico == 0) {
                            alertSwal('error', 'Aspecto Fisico', 'Falta diligenciar');
                        } else if (countLimpieza == 0) {
                            alertSwal('error', 'Organización Limpieza', 'Falta diligenciar');
                        } else if (countPublicos == 0) {
                            alertSwal('error', 'Servicios Publicos', 'Falta diligenciar');
                        } else if (countAdicionales == 0) {
                            alertSwal('error', 'Servicios Adicionales', 'Falta diligenciar');
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', '1Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                }).done(function () {
                    hideModalLoading();
                });
            }
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    });
});


    $('.btnAddCaracterisiticaViv').on('click', function () {
        $('#formCaracteristicaViv')[0].reset();
        $('#accion').val("POST");
    });


    // Crear Caracteristicas de vivienda
    $('#btn-submit-caracteristicaViv').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormCaracteristicaVivienda()) {
            $(this).prop('disabled', true);

            let method = $('#accion').val();
            let data = {
                id_caracteristica: $('#id_caracteristica').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                tipo_vivienda: $('#tipo_vivienda').val(),
                tipo_tenencia: $('#tipo_tenencia').val(),
                tipo_tamano_vivienda: $('#tipo_tamano_vivienda').val(),
                tipo_vivienda_estado: $('#tipo_vivienda_estado').val(),
                aclaracion_viv: $('#aclaracion_viv').val(),
            }
            //console.log(data);

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivCaracteristica?id_caracteristica=${data.id_caracteristica}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Caracteristica Vivienda', 'Caracteristica Vivienda guardado satisfactoriamente');
                        cargarTablacaracteristica();
                        $('#submitButton').prop('disabled', false);
                        $('#formCaracteristicaViv')[0].reset();
                        $('#modalAddVivCaracteristica').modal('hide')
                    } else {
                        alertSwal('error', 'Caracteristica Vivienda', r.code.code);
                        cargarTablacaracteristica();
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


    // Editar Caracteristicas de la vivienda
    $('#tbl-vivCaracteristica').on('click', '.btnEditVivCaracteristica', function () {
        $('#btn-submit-caracteristicaViv').prop('disabled', false);

        $('#accion').val("PUT");
        let id_caracteristica = $(this).attr('id_caracteristica');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivCaracteristica?id_caracteristica=${id_caracteristica}`),
            dataType: "json",
            success: function (resp) {
                $('#id_caracteristica').val(resp.data.id_caracteristica);
                $('#tipo_vivienda').val(resp.data.tipo_vivienda);
                $('#tipo_tenencia').val(resp.data.tipo_tenencia);
                $('#tipo_tamano_vivienda').val(resp.data.tipo_tamano_vivienda);
                $('#tipo_vivienda_estado').val(resp.data.tipo_vivienda_estado);
                $('#aclaracion_viv').val(resp.data.aclaracion_viv);

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddVivCaracteristica').modal();
    })
    
    //========================================  ASPECTOS  ==================================================================
    let aspectoviv = '';
    //Se pinta las caracteristicas de la vivienda y los lista
    $('#tbl-vivCaracteristica').on('click', '.opciones-btn', function (e) {
        e.preventDefault();
        
        //Se obtiene los valores de las etiquetas de los botones de aspectos
        let id_opcion = $(this).attr('id_opcion');
        let Titulo = $(this).attr('Titulo');
        aspectoviv = $(this).attr('aspectoviv');
        let id_caracteristica = $(this).attr('id_caracteristica');

        $('.div-Afisicos').removeClass('hide');         //Se muestra la tabla que estaba oculta
        $('#idCaracteristica').val(id_caracteristica);

       // var aspectoFisico = "tipo_aspecto_fisico";

        var aspectos = document.getElementById("aspectos");
        aspectos.textContent = Titulo;

        //Se inicializa en vacio la tabla de Aspectos fisicos
        let registros_tabla_aspectoFisico = '';
        //ajax para ver todos los apectos fisicos
        
        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/configuracion/${aspectoviv}`),
            dataType: "json",
            success: function(resp) {
                //console.log(resp);

                resp.forEach(p => {
                    //console.log(p.categoria);
                    if(p.categoria == aspectoviv){
                        
                        registros_tabla_aspectoFisico += `
                        <tr>
                            <td style="width: 5%;">
                                <input type="checkbox" class="checkbox-servicio" id_caracteristica_tipo="${p.codigo}">
                            </td>
                            <td style="width: 95%">
                                    ${p.descripcion}
                            </td>
                        </tr>`
                    }
                })

                $('#tbl-Afisicos-combo').html(registros_tabla_aspectoFisico);
                showModalLoading();
                $.ajax({
                    type: "GET",
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/vivCaracteristica/listacomboservicio?id_caracteristica=${id_caracteristica}&categoria=${aspectoviv}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
                    dataType: "json",
                    success: function(resp) {
                        //console.log(resp);
                        resp.data?.forEach(p => {
                            $(`.checkbox-servicio[id_caracteristica_tipo="${p.codigo}"]`).prop((p.activo == 1 ) ?'checked' : 'unchecked', true);
                        })
                    }
                })
            }
        }).done(function() {
            hideModalLoading();
        });
    })

    //========================================  FIN DE ASPECTOS =============================================================

 
    //========================================== FUNCION PARA AGREGAR POR ASPECTO DINAMICO ===========================================

    //se le agregan a la caracterisficas  de aspecto fisico
    $('#tbl-Afisicos-combo').on('click', '.checkbox-servicio', async function() {

        let id_caracteristica_tipo = $(this).attr('id_caracteristica_tipo');
        let id_caracteristica = $('#idCaracteristica').val();
        let categoriaC = aspectoviv;
        let isSelected = $(this).is(':checked');


        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivCaracteristica/id_aspecto?id_caracteristica=${id_caracteristica}&categoria=${categoriaC}&codigo=${id_caracteristica_tipo}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
            dataType: "json",
            success: function(resp) {
                //console.log(resp.data);
                if (resp.data[0] == null) {
                    data = {
                        id_solicitud : id_solicitudC,
                        id_servicio : id_servicioC,
                        id_caracteristica_tipo : id_caracteristica_tipo,
                        id_caracteristica: id_caracteristica,
                        categoria : categoriaC
                    }
                    //console.log(data);
                    //showModalLoading();
                    $.ajax({
                        method: 'POST',
                        headers: {
                            "access-token": getToken()
                        },
                        url: url_site(`api/vivCaracteristica/aspectos-${isSelected ? 'agregar' : 'eliminar'}`),
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function(r) {
                            if (r.status == "success") {
                                alertSwal('success', 'Aspectos vivienda', 'Aspectos '+ (isSelected ? 'Agregado' : 'Eliminado') +' el Aspecto satisfactoriamente');
                            } else {
                                alertSwal('error', 'Aspectos vivienda', r.code.code);
                            }
                        },
                        error: function(xhr, status, error) {
                            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                        },
                        complete: function() {
                            hideModalLoading();
                        }
                    });
                }else{
                    //console.log("existe");
                    data = {
                        id_caracteristica_variable : resp.data[0].id_caracteristica_variable
                    }

                    $.ajax({
                        method: 'DELETE',
                        headers: {
                            "access-token": getToken()
                        },
                        url: url_site(`api/vivCaracteristica/deleteaspectofisico?id_caracteristica_variable=${data.id_caracteristica_variable}`),
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function(r) {
                            if (r.status == "success") {
                                alertSwal('success', 'Aspectos vivienda', 'Aspecto Fisico eliminado satisfactoriamente');
                            }
                        },
                        error: function(xhr, status, error) {
                            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                        },
                        complete: function() {
                            hideModalLoading();
                        }
                    });
                }

            }
        })

    })


});//fin del document ready


function cargarTablacaracteristica() {

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    //let id_servicioC = "3";

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivCaracteristica/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r.data);
            // Selecciona el botón por su clase
            var boton = document.querySelector('.btnAddCaracterisiticaViv');

            if (r.data != '') {                
                // Oculta el botón cambiando su estilo
                boton.style.display = "none";
            } else {
                boton.style.display = "block";
            }
            $('#tbl-vivCaracteristica').DataTable().clear();
            $('#tbl-vivCaracteristica').DataTable().destroy();

            let t = $('#tbl-vivCaracteristica').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "asc"],
                ],
                //dom: 'Bfrtip',
                /*buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Combos y Servicios',
                }],*/
            });

            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((caracteristicaViv) => {

                    t.row.add([
                        //caracteristicaViv.id_caracteristica,
                        contador++,
                        caracteristicaViv.descripcion_tipo_viv,
                        caracteristicaViv.descripcion_tenencia,
                        caracteristicaViv.descripcion_tamano,
                        caracteristicaViv.descripcion_estado,
                        caracteristicaViv.aclaracion_viv,
                        `<button class="btn btn-xs btn-warning btnEditVivCaracteristica" id_caracteristica="${caracteristicaViv.id_caracteristica}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="opciones-btn btn btn-xs btn-success btnAspectoFisico" id_opcion="1" Titulo = "Aspectos Fisicos" aspectoviv ="tipo_aspecto_fisico" id_caracteristica ="${caracteristicaViv.id_caracteristica}"><i class="fa fa-cogs"></i> Aspecto Fisico</button>
                        <button class="opciones-btn btn btn-xs btn-danger btnAspectoLimpieza" id_opcion="2" Titulo = "Aspectos Limpieza" aspectoviv ="tipo_aspecto_limpieza" id_caracteristica="${caracteristicaViv.id_caracteristica}"><i class="fa fa-cogs"></i> Organización limpieza</button>
                        <button class="opciones-btn btn btn-xs btn-primary btnServiciosPublicos" id_opcion="3" Titulo = "Aspectos Servicios Publicos" aspectoviv ="tipo_aspecto_servicios" id_caracteristica="${caracteristicaViv.id_caracteristica}"><i class="fa fa-cogs"></i> Servicios Publicos</button>
                        <button class="opciones-btn btn btn-xs btn-info btnServiciosAdicionales" id_opcion="4" Titulo = "Aspectos Servicios Adicionales" aspectoviv ="tipo_aspecto_adicionales" id_caracteristica="${caracteristicaViv.id_caracteristica}"><i class="fa fa-cogs"></i> Servicios Adicionales</button>
                        `
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

function validateFormCaracteristicaVivienda() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#tipo_vivienda').val() == "" || $('#tipo_vivienda').val() == null) {
        alertSwal('error', 'Tipo de Vivienda', 'Este campo es obligatorio');
        $("#tipo_vivienda").focus();
        return false;
    }
    
    if ($('#tipo_tenencia').val() == "" || $('#tipo_tenencia').val() == null) {
        alertSwal('error', 'Tipo de Tenencia', 'Este campo es obligatorio');
        $("#tipo_tenencia").focus();
        return false;
    }

    if ($('#tipo_tamano_vivienda').val() == "" || $('#tipo_tamano_vivienda').val() == null) {
        alertSwal('error', 'Tamaño de la Vivienda', 'Este campo es obligatorio');
        $("#tipo_tamano_vivienda").focus();
        return false;
    }

    if ($('#tipo_vivienda_estado').val() == "" || $('#tipo_vivienda_estado').val() == null) {
        alertSwal('error', 'Estado de la Vivienda', 'Este campo es obligatorio');
        $("#tipo_vivienda_estado").focus();
        return false;
    }

    return true;

}