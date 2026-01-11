$(document).ready(function () {

    $("body").addClass("sidebar-collapse");
    $('.div-Asector').addClass('hide');

    cargarTablaSector();

    //informacion del modal de ayuda
    // Datos para la publicación
    const tituloPublicacion = "Ayuda Principales Vías de Acceso y Estado de las Vías";
    const contenidoPublicacion = "Principales Vías de Acceso y Estado de las vías (Asfaltada en buen estado<br>Asfaltada en mal estado<br>Cemento en buen estado.<br>Cemento en mal estado<br>Adoquín buen estado<br>Adoquín mal estado<br>Gravilla buen estado<br>Gravilla mal estado<br>Tierra buen estado<br>Tierra mal estado<br>Escaleras buen estado<br>Escaleras mal estado<br>Otro  Cual?)";

    // Obtener los elementos del modal
    const tituloModalElemento = document.getElementById("titulo-modal-distribucion");
    const contenidoModalElemento = document.querySelector("#modalAyuda .modal-body h4");

    // Actualizar el título y el contenido del modal
    tituloModalElemento.innerHTML = `<strong><span style="color: red;">${tituloPublicacion}</span></strong>`;
    contenidoModalElemento.innerHTML = contenidoPublicacion;

    //loadSelectOption para cargar la lista de los Tipos de sector
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_sector`),
        input: [{
            id: 'sector',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El Tipo de Sector',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

/*    //loadSelectOption para cargar la lista de los Tipos de estado del sector
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_estado_sector`),
        input: [{
            id: 'estado_sector',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione la Seguridad del Sector',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
*/
    //loadSelectOption para cargar la lista de los Tipos de ubicacion del sector
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_ubicacion_sector`),
        input: [{
            id: 'ubicacion_sector',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El Tipo de Ubicación del Sector',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //loadSelectOption para cargar la lista de los Tipos de desplazamiento al trabajo
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_tmp_ida_trabajo`),
        input: [{
            id: 'tmp_ida_trabajo',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione El tiempo de desplazamiento al trabajo',
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

    // Enviar id_solicitud a distribucionVivienda_visita_ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`newelectrodomesticos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
       
    // Enviar id_solicitud a dimension social
/*    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`viviendaAnteriores_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
    const urlList = url_site(`api/vivSector/lista?id_solicitud=${id_solicitud}&id_servicio=${id_servicio}`);
    
    // Hacer la primera solicitud AJAX
    $.ajax({
        headers: headers,
        type: "GET",
        url: urlList,
        dataType: "json",
        success: function (resp) {
            if (resp.status == "success" && resp.data.length > 0) {
                // Asumir que estamos utilizando el primer elemento de los datos
                const id_sector = resp.data[0].id_sector;
                
                // URL para la segunda solicitud AJAX
                const urlValidation = url_site(`api/vivSector/validacion_viv?id_sector=${id_sector}&id_solicitud=${id_solicitud}&id_servicio=${id_servicio}`);
                
                // Hacer la segunda solicitud AJAX
                $.ajax({
                    headers: headers,
                    type: "GET",
                    url: urlValidation,
                    dataType: "json",
                    success: function (r) {
                        //console.log(r);
                        var countTransporte = 0;
                        var countSector = 0;
                        r.data.forEach(p => {
                            //console.log(p.categoria);
                            switch (p.categoria) {
                                case 'tipo_aspecto_transporte':
                                    countTransporte++;
                                    break;
                                case 'tipo_aspecto_sector_servicio':
                                    countSector++;
                                    break;                            
                                default:
                                    break;
                            }
                        })
                        if (countTransporte > 0 && countSector > 0) {
                            alertSwal('success', 'Finalizo las Caracteristicas del Sector', 'Siguiente');
                            window.location = url_site(`viviendaAnteriores_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    
                            
                        } else if (countTransporte == 0) {
                            alertSwal('error', 'Medios de Transporte', 'Falta diligenciar');
                        } else if (countSector == 0) {
                            alertSwal('error', 'Servicios Candidato Sector', 'Falta diligenciar');
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
    $('.btnAddSectorViv').on('click', function () {
        $('#formSectorViv')[0].reset();
        $('#accion').val("POST");
    });


    // Crear Sector de vivienda
    $('#btn-submit-sectorViv').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormSectorVivienda()) {
            $(this).prop('disabled', true);

            let method = $('#accion').val();
            let data = {
                id_sector: $('#id_sector').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                sector: $('#sector').val(),
                estracto: $('#estracto').val(),
                estado_sector: $('#estado_sector').val(),
                ubicacion_sector: $('#ubicacion_sector').val(),
                tmp_ida_trabajo: $('#tmp_ida_trabajo').val(),
                tmp_en_vivienda: $('#tmp_en_vivienda').val(),
                zonas_verdes: $('#zonas_verdes').val(),
                vias_principales: $('#vias_principales').val(),
                concepto_vecino: $('#concepto_vecino').val(),
            }
            //console.log(data);

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivSector?id_sector=${data.id_sector}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Sector Vivienda', 'Sector Vivienda guardado satisfactoriamente');
                        cargarTablaSector();
                        $('#submitButton').prop('disabled', false);
                        $('#formSectorViv')[0].reset();
                        $('#modalAddVivSector').modal('hide')
                    } else {
                        alertSwal('error', 'Sector Vivienda', r.code.code);
                        cargarTablaSector();
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


    // Editar Sector de la vivienda
    $('#tbl-vivSector').on('click', '.btnEditVivSector', function () {
        $('#btn-submit-sectorViv').prop('disabled', false);
        

        $('#accion').val("PUT");
        let id_sector = $(this).attr('id_sector');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/vivSector?id_sector=${id_sector}`),
            dataType: "json",
            success: function (resp) {
                $('#id_sector').val(resp.data.id_sector);
                $('#sector').val(resp.data.sector);
                $('#estracto').val(resp.data.estracto);
                $('#estado_sector').val(resp.data.estado_sector);
                $('#ubicacion_sector').val(resp.data.ubicacion_sector);
                $('#tmp_ida_trabajo').val(resp.data.tmp_ida_trabajo);
                $('#tmp_en_vivienda').val(resp.data.tmp_en_vivienda);
                $('#zonas_verdes').val(resp.data.zonas_verdes);
                $('#vias_principales').val(resp.data.vias_principales);
                $('#concepto_vecino').val(resp.data.concepto_vecino);

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddVivSector').modal();
    })
    //========================================  ASPECTOS DEL SECTOR ==================================================================
    let aspectoviv = '';
    //Se pinta las caracteristicas deL SECTOR y los lista
    $('#tbl-vivSector').on('click', '.opciones-btn', function(e) {
        e.preventDefault();

        //Se obtiene los valores de las etiquetas de los botones de aspectos
        let id_opcion = $(this).attr('id_opcion');
        let Titulo = $(this).attr('Titulo');
        aspectoviv = $(this).attr('aspectoviv');
        let id_sector = $(this).attr('id_sector');

        $('.div-Asector').removeClass('hide');
        $('#id_sector').val(id_sector);

        //var mediosTransporte = "Medio Trasporte";

        var aspectos = document.getElementById("aspectos");
        aspectos.textContent = Titulo;

        //Se inicializa en vacio latabla de Aspectos fisicos
        let registros_tabla_sector = '';
        //ajax para ver todos los apectos fisicos
        //showModalLoading();
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
                    if(p.categoria == aspectoviv){
                        registros_tabla_sector += `
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

                $('#tbl-Asector-combo').html(registros_tabla_sector);
                showModalLoading();
                $.ajax({
                    type: "GET",
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/vivSector/listacomboservicio?id_sector=${id_sector}&categoria=${aspectoviv}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
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

    //========================================  ASPECTOS DEL SECTOR =============================================================

    
    //========================================== Funcion para agregar por aspecto ===========================================
    //se le agregan a la caracterisficas  de aspecto fisico
    $('#tbl-Asector-combo').on('click', '.checkbox-servicio', async function() {

        let id_caracteristica_tipo = $(this).attr('id_caracteristica_tipo');
        let id_sector = $('#id_sector').val();
        let categoriaC = aspectoviv;
        let isSelected = $(this).is(':checked');

        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivSector/id_aspecto?id_sector=${id_sector}&categoria=${categoriaC}&codigo=${id_caracteristica_tipo}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
            dataType: "json",
            success: function(resp) {
                //console.log(resp.data);
                if (resp.data[0] == null) {
                    data = {
                        id_solicitud : id_solicitudC,
                        id_servicio : id_servicioC,
                        id_caracteristica_tipo : id_caracteristica_tipo,
                        id_sector: id_sector,
                        categoria : categoriaC
                    }
                    //console.log(data);
                    //showModalLoading();
                    $.ajax({
                        method: 'POST',
                        headers: {
                            "access-token": getToken()
                        },
                        url: url_site(`api/vivSector/aspectos-${isSelected ? 'agregar' : 'eliminar'}`),
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function(r) {
                            if (r.status == "success") {
                                alertSwal('success', 'Caracteristica del sector', 'Aspectos '+ (isSelected ? 'Agregado' : 'Eliminado') +' el Aspecto satisfactoriamente');
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
                        id_sector_variable : resp.data[0].id_sector_variable
                    }

                    $.ajax({
                        method: 'DELETE',
                        headers: {
                            "access-token": getToken()
                        },
                        url: url_site(`api/vivSector/deleteaspecto?id_sector_variable=${data.id_sector_variable}`),
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        dataType: "json",
                        success: function(r) {
                            if (r.status == "success") {
                                alertSwal('success', 'Caracteristica del sector', 'Caracteristica eliminado satisfactoriamente');
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


function cargarTablaSector() {

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
        url: url_site(`api/vivSector/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            // Selecciona el botón por su clase
            var boton = document.querySelector('.btnAddSectorViv');

            if (r.data != '') {                
                // Oculta el botón cambiando su estilo
                boton.style.display = "none";
            } else {
                boton.style.display = "block";
            }
            $('#tbl-vivSector').DataTable().clear();
            $('#tbl-vivSector').DataTable().destroy();

            let t = $('#tbl-vivSector').DataTable({
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
                r.data.forEach((sectorViv) => {

                    t.row.add([
                        //sectorViv.id_sector,
                        contador++,
                        sectorViv.descripcion_tipo_sector,
                        sectorViv.estracto,
                        sectorViv.descripcion_ubicacion_sector,
                        sectorViv.descripcion_tmp_ida_trabajo,
                        sectorViv.tmp_en_vivienda,
                        sectorViv.zonas_verdes,
                        sectorViv.vias_principales,
                        sectorViv.estado_sector,
                        sectorViv.concepto_vecino,
                        `<button class="btn btn-xs btn-warning btnEditVivSector" id_sector="${sectorViv.id_sector}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        <button class="opciones-btn btn btn-xs btn-success btnMediosTrasporte" id_opcion="1" Titulo = "Medios de Transporte" aspectoviv ="tipo_aspecto_transporte" id_sector ="${sectorViv.id_sector}"><i class="fa fa-cogs"></i> Medios de transporte</button>
                        <button class="opciones-btn btn btn-xs btn-danger btnServicioSector" id_opcion="1" Titulo = "Servicios del Candidato en Entorno Habitacional" aspectoviv ="tipo_aspecto_sector_servicio" id_sector="${sectorViv.id_sector}"><i class="fa fa-cogs"></i> Servicios Candidato Sector</button>
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

function validateFormSectorVivienda() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#sector').val() == "" || $('#sector').val() == null) {
        alertSwal('error', 'Tipo de Sector', 'Este campo es obligatorio');
        $("#sector").focus();
        return false;
    }
    
    if ($('#estracto').val() == "" || $('#estracto').val() == null) {
        alertSwal('error', 'estracto', 'Este campo es obligatorio');
        $("#estracto").focus();
        return false;
    }

    if ($('#estado_sector').val() == "" || $('#estado_sector').val() == null) {
        alertSwal('error', 'Estado del Sector', 'Este campo es obligatorio');
        $("#estado_sector").focus();
        return false;
    }

    if ($('#ubicacion_sector').val() == "" || $('#ubicacion_sector').val() == null) {
        alertSwal('error', 'Ubicación', 'Este campo es obligatorio');
        $("#ubicacion_sector").focus();
        return false;
    }

    if ($('#tmp_ida_trabajo').val() == "" || $('#tmp_ida_trabajo').val() == null) {
        alertSwal('error', 'Tiempo de ida al Trabajo', 'Este campo es obligatorio');
        $("#tmp_ida_trabajo").focus();
        return false;
    }

    if ($('#tmp_en_vivienda').val() == "" || $('#tmp_en_vivienda').val() == null) {
        alertSwal('error', 'Tiempo en la Vivienda', 'Este campo es obligatorio');
        $("#tmp_en_vivienda").focus();
        return false;
    }

    if ($('#zonas_verdes').val() == "" || $('#zonas_verdes').val() == null) {
        alertSwal('error', 'Zonas Verdes', 'Este campo es obligatorio');
        $("#zonas_verdes").focus();
        return false;
    }

    if ($('#vias_principales').val() == "" || $('#vias_principales').val() == null) {
        alertSwal('error', 'Vías Principales', 'Este campo es obligatorio');
        $("#vias_principales").focus();
        return false;
    }

    if ($('#concepto_vecino').val() == "" || $('#concepto_vecino').val() == null) {
        alertSwal('error', 'Concepto Vecino', 'Este campo es obligatorio');
        $("#concepto_vecino").focus();
        return false;
    }

    return true;

}