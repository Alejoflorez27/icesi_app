$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    // Obtener el elemento que deseas ocultar
    const campoParaOcultar = document.getElementById("ocultar");
    // Ocultar el elemento cambiando su propiedad de estilo
    campoParaOcultar.style.display = "none";

    //loadSelectOption para cargar la lista de los Tipos de concepto
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_concepto_egreso`),
        input: [{
            id: 'concepto_ingreso',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
    //loadSelectOption para cargar la lista de periodicidad
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_periocidad`),
        input: [{
            id: 'periocidad',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
    
    //loadSelectOption para cargar la lista de los Tipos de concepto
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_concepto_egreso`),
        input: [{
            id: 'concepto_ingreso_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })
    //loadSelectOption para cargar la lista de periodicidad
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_periocidad`),
        input: [{
            id: 'periocidad_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: '',
    })


    //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
        input: [{
            id: 'tipo_familiar_egre',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })
    

    //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
        input: [{
            id: 'tipo_familiar_egre_edit',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un familiar o candidato',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    //Cargar la tabla de los egresos de la vivienda
    cargarTablaVivEgresos();

    //envio de Accion POST
   $('.btnAddVivEgresos').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-vivEditEgresos').on('click', function () {
        $('#formVivEgresos')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
       
    // Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`pasivos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`dimensionSocial_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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

    $('#concepto_ingreso').on('change', function () {
        let concepto = $('#concepto_ingreso').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
        //console.log (concepto);
        if (concepto == 'L') {
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "block";
        }else{
            // Obtener el elemento que deseas ocultar
            const campoParaOcultar = document.getElementById("ocultar");
            // Ocultar el elemento cambiando su propiedad de estilo
            campoParaOcultar.style.display = "none";
        }
    });
    
    // Crear ingresos de la vivienda
    $('#btn-submit-vivEgresos').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormVivEgresos()) {

            let method = $('#accion').val();
            let data = {
                id_egreso: $('#id_egreso').val(),
                id_solicitud: id_solicitudC,
                id_servicio: id_servicioC,
                concepto_ingreso: $('#concepto_ingreso').val(),
                otros: $('#otros').val(),
                periocidad: $('#periocidad').val(),
                tipo_familiar: $('#tipo_familiar_egre').val(),
                valor_egreso: $('#valor_egreso').val(),
                total_egreso: $('#total_egresoVI').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/vivegresos?id_egreso=${data.id_egreso}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Egresos', 'vivienda guardado satisfactoriamente');
                        //window.location = url_site(`ingresos_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                        cargarTablaVivEgresos();
                        $('#formVivEgresos')[0].reset();
                            //loadSelectOption para cargar la lista de los Tipos de concepto
                            loadSelectOption({
                                url: url_site(`api/configuracion/tipo_concepto_egreso`),
                                input: [{
                                    id: 'concepto_ingreso',                      //Nombre del campo en HTML
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Concepto',
                                    selectedValue: ''
                                },
                                ],
                                columnKey: 'codigo',
                                columnDescription: 'descripcion',  
                                responsePath: '',
                            })
                            //loadSelectOption para cargar la lista de periodicidad
                            loadSelectOption({
                                url: url_site(`api/configuracion/tipo_periocidad`),
                                input: [{
                                    id: 'periocidad',                      //Nombre del campo en HTML
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Concepto',
                                    selectedValue: ''
                                },
                                ],
                                columnKey: 'codigo',
                                columnDescription: 'descripcion',  
                                responsePath: '',
                            })

                            //loadSelectOption para cargar la lista de los Tipos de elementos mobiliarios
                            loadSelectOption({
                                url: url_site(`api/configuracion/tipo_responsable_egreso_vi`),
                                input: [{
                                    id: 'tipo_familiar_egre',                      //Nombre del campo en HTML
                                    clearOptions: true,
                                    emptyText: 'Seleccione un familiar o candidato',
                                    selectedValue: ''
                                },
                                ],
                                columnKey: 'codigo',
                                columnDescription: 'descripcion',  
                                responsePath: ''
                            })
                                        
                            // Obtener el elemento que deseas ocultar
                            const campoParaOcultar = document.getElementById("ocultar");
                            // Ocultar el elemento cambiando su propiedad de estilo
                            campoParaOcultar.style.display = "none";
                        //$('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Egresos de la vivienda', r.code.code);
                        cargarTablaVivEgresos();
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
    });// Fin de Crear egresos de la vivienda


   // Manejar el clic en el botón de edición en ambas tablas
   $('#tbl-vivEgresos, #tbl-vivEgresosAdicional').on('click', '.btnEditVivEgresos', function () {
    let id_egreso = $(this).attr('id_egreso');
    editarEgreso(id_egreso);
});

// Función para manejar la edición de egresos de vivienda
function editarEgreso(id_egreso) {
    $('#accion').val("PUT");
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/vivegresos?id_egreso=${id_egreso}`),
        dataType: "json",
        success: function (resp) {
            var otros = resp.data.concepto_ingreso;
            const campoParaOcultar = document.getElementById("ocultarEdit");
            if (otros != 'L') {
                campoParaOcultar.style.display = "none";
            } else {
                campoParaOcultar.style.display = "block";
            }

            $('#id_egreso').val(resp.data.id_egreso);
            $('#concepto_ingreso_edit').val(resp.data.concepto_ingreso);
            $('#otrosEdit').val(resp.data.otros);
            $('#periocidad_edit').val(resp.data.periocidad),
            $('#tipo_familiar_egre_edit').val(resp.data.tipo_familiar);
            $('#valor_egreso_edit').val(resp.data.valor_egreso);
            $('#total_egresoVI_edit').val(resp.data.total_egreso);
        }
    }).done(function () {
        hideModalLoading();
    });
    $('#modalEditVivEgresos').modal();
}

$('#concepto_ingreso_edit').on('change', function () {
    let conceptoEdit = $('#concepto_ingreso_edit').val();      //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
    //console.log (concepto);
    if (conceptoEdit == 'L') {
        // Obtener el elemento que deseas ocultar
        const campoParaOcultar = document.getElementById("ocultarEdit");
        // Ocultar el elemento cambiando su propiedad de estilo
        campoParaOcultar.style.display = "block";
    }else{
        // Obtener el elemento que deseas ocultar
        const campoParaOcultar = document.getElementById("ocultarEdit");
        // Ocultar el elemento cambiando su propiedad de estilo
        campoParaOcultar.style.display = "none";
    }
});
    
$('#btn-submit-vivEditEgresos').on('click', function (e) {
    e.preventDefault();
    if(validateFormVivEgresosEdit()){

        let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

        let data = {
            id_egreso: $('#id_egreso').val(),
            id_solicitud: id_solicitudC,
            concepto_ingreso: $('#concepto_ingreso_edit').val(),
            otros: $('#otrosEdit').val(),
            periocidad: $('#periocidad_edit').val(),
            tipo_familiar: $('#tipo_familiar_egre_edit').val(),
            valor_egreso: $('#valor_egreso_edit').val(),
            total_egreso: $('#total_egresoVI_edit').val()
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/vivegresos/update_egresos?id_egreso=${data.id_egreso}`), //Se le da el id_mobiliario de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Egreso',
                    'La Egreso de la Vivienda ha sido Actualizado',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {

                    }
                    //window.location = url_site(`egresos_visita_mantenimiento?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
                    cargarTablaVivEgresos();
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


// Manejar el clic en el botón de eliminación en ambas tablas
$('#tbl-vivEgresos, #tbl-vivEgresosAdicional').on('click', '.btnEliminarVivEgresos, .btnEliminarVivEgresosAdicional', function (e) {
    e.preventDefault();
    $('#accion').val("DELETE");
    let id_egreso = $(this).attr('id_egreso');
    eliminarEgreso(id_egreso);
});

// Función para manejar la eliminación de egresos de vivienda
function eliminarEgreso(id_egreso) {
    let method = $('#accion').val(); // Se Obtiene el tipo de Método para hacer la acción en la base de datos
    let data = { // Se Prepara la Data que va a ser modificada en la BD
        id_egreso: id_egreso,
    }

    $.ajax({
        method: method,
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/vivegresos/delete_egresos?id_egreso=${data.id_egreso}`), // Se le da el id_ingreso de la data
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (cand) {
            Swal.fire(
                'Egreso',
                'Ha Sido Eliminado Correctamente',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    cargarTablaVivEgresos();
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

}); //fin de funcion Ready()

//Funcion de Validar los campos de Crear los egresos
function validateFormVivEgresos() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_ingreso').val() == "" || $('#concepto_ingreso').val() == null) {
        alertSwal('error', 'concepto Egreso', 'Este campo es obligatorio');
        $("#concepto_ingreso").focus();
        return false;
    }
    if ($('#periocidad').val() == "" || $('#periocidad').val() == null) {
        alertSwal('error', 'Periodicidad', 'Este campo es obligatorio');
        $("#periocidad").focus();
        return false;
    }
    if ($('#tipo_familiar_egre').val() == "" || $('#tipo_familiar_egre').val() == null) {
        alertSwal('error', 'Responsable Egreso', 'Este campo es obligatorio');
        $("#tipo_familiar_egre").focus();
        return false;
    }
    if ($('#valor_egreso').val() == "" || $('#valor_egreso').val() == null) {
        alertSwal('error', 'Valor Egreso', 'Este campo es obligatorio');
        $("#valor_egreso").focus();
        return false;
    }
    if ($('#total_egresoVI').val() == "" || $('#total_egresoVI').val() == null) {
        alertSwal('error', 'Total del Egreso', 'Este campo es obligatorio');
        $("#total_egresoVI").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Crear la egresos de la vivienda

//Funcion de Validar los campos de Editar los egresos de la vivienda
function validateFormVivEgresosEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#concepto_ingreso_edit').val() == "" || $('#concepto_ingreso_edit').val() == null) {
        alertSwal('error', 'concepto Egreso', 'Este campo es obligatorio');
        $("#concepto_ingreso_edit").focus();
        return false;
    }
    if ($('#periocidad_edit').val() == "" || $('#periocidad_edit').val() == null) {
        alertSwal('error', 'Periodicidad', 'Este campo es obligatorio');
        $("#periocidad_edit").focus();
        return false;
    }
    if ($('#tipo_familiar_egre_edit').val() == "" || $('#tipo_familiar_egre_edit').val() == null) {
        alertSwal('error', 'Responsable Egreso', 'Este campo es obligatorio');
        $("#tipo_familiar_egre_edit").focus();
        return false;
    }
    if ($('#valor_egreso_edit').val() == "" || $('#valor_egreso_edit').val() == null) {
        alertSwal('error', 'Valor Egreso', 'Este campo es obligatorio');
        $("#valor_egreso_edit").focus();
        return false;
    }
    if ($('#total_egresoVI_edit').val() == "" || $('#total_egresoVI_edit').val() == null) {
        alertSwal('error', 'Total del Egreso', 'Este campo es obligatorio');
        $("#total_egresoVI_edit").focus();
        return false;
    }

    return true;

}//Fin Funcion de Validar los campos de Editar los egresos


//Cargar datos de egresos de vivienda
function cargarTablaVivEgresos() {
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
        url: url_site(`api/vivegresos/lista?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-vivEgresos').DataTable().clear();
            $('#tbl-vivEgresos').DataTable().destroy();

            $('#tbl-vivEgresosAdicional').DataTable().clear();
            $('#tbl-vivEgresosAdicional').DataTable().destroy();


            let t = $('#tbl-vivEgresos').DataTable({
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

            let ta = $('#tbl-vivEgresosAdicional').DataTable({
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

            var total_egreso_mesual = 0;
            var total_egreso_adicional = 0;
            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {
                    if (sol.periocidad == 'A') {
                        var mensual = sol.valor_egreso;
                        total_egreso_mesual += parseInt(mensual);
                        t.row.add([
                            //sol.id_egreso,
                            contador++,
                            sol.descripcion_tipo_concepto,
                            sol.otros,
                            sol.descripcion_tipo_periocidad,
                            sol.descripcion_tipo_integrante,
                            '$ '+ sol.valor_egreso,
                            '$ '+ (sol.total_egreso ? sol.total_egreso : '0'),
                            `<button class="btn btn-xs btn-warning btnEditVivEgresos" id_egreso="${sol.id_egreso}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                            <button class="btn btn-xs btn-danger btnEliminarVivEgresos" id_egreso=${sol.id_egreso}><i class="fa fa-trash"></i> Eliminar</button>`,
                            sol.usr_create,
                            sol.fch_create
                        ]);
                    }
                    
                    if(sol.periocidad != 'A'){
                        var adicional = sol.valor_egreso;
                        total_egreso_adicional += parseInt(adicional);
                        ta.row.add([
                            //sol.id_egreso,
                            contador++,
                            sol.descripcion_tipo_concepto,
                            sol.otros,
                            sol.descripcion_tipo_periocidad,
                            sol.descripcion_tipo_integrante,
                            '$ '+ sol.valor_egreso,
                            '$ '+ (sol.total_egreso ? sol.total_egreso : '0'),
                            `<button class="btn btn-xs btn-warning btnEditVivEgresos" id_egreso="${sol.id_egreso}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                            <button class="btn btn-xs btn-danger btnEliminarVivEgresosAdicional" id_egreso=${sol.id_egreso}><i class="fa fa-trash"></i> Eliminar</button>`,
                            sol.usr_create,
                            sol.fch_create
                        ]);
                    }
 
                });
                let h1Element = document.getElementById("total_egreso"); // Obtener la referencia al elemento <h2>
                // Redondear a 0 decimales utilizando Math.floor
                let total_egreso_sin_decimales = Math.floor(total_egreso_mesual);
                
                // Formatear como moneda colombiana (COP) sin ceros adicionales después de la coma
                let total_egreso_formateado = new Intl.NumberFormat("es-CO", {
                  style: "currency",
                  currency: "COP",
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0
                }).format(total_egreso_sin_decimales);
                
                // Asignar el número truncado y formateado como contenido del elemento <h2>
                h1Element.innerHTML = total_egreso_formateado;
                
                h1Element.style.color = "red";


                //para egresos adicionales
                let h1Element_adicional = document.getElementById("total_egreso_adicional"); // Obtener la referencia al elemento <h2>
                // Redondear a 0 decimales utilizando Math.floor
                let total_egreso_sin_decimales_adicional = Math.floor(total_egreso_adicional);
                
                // Formatear como moneda colombiana (COP) sin ceros adicionales después de la coma
                let total_egreso_formateado_adicional = new Intl.NumberFormat("es-CO", {
                  style: "currency",
                  currency: "COP",
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0
                }).format(total_egreso_sin_decimales_adicional);
                
                // Asignar el número truncado y formateado como contenido del elemento <h2>
                h1Element_adicional.innerHTML = total_egreso_formateado_adicional;
                
                h1Element_adicional.style.color = "red";
            };

            t.draw();
            ta.draw();
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

