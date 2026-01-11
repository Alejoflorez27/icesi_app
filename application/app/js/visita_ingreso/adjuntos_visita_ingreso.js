$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //Cargar la tabla adjuntos
    cargarTablaAdjuntos();

    lista = 'tipo_adjuntos_visita_ingreso';
    var asignarList = document.getElementById("lista");
    asignarList.value = lista;

    //loadSelectOption para cargar la lista de los Tipos de Parentescos
    loadSelectOption({
        url: url_site(`api/configuracion/${lista}`),
        input: [{
            id: 'tipo_doc',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione un tipo de adjuntos',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

     $('#archivo').on('change', function (e) {
        var archivo = this.files[0]; // alternativa más segura
        if (archivo) {
            $('#info').html(`<h5><strong>${archivo.name}</strong> <small>(${descripcionTamanoArchivo(archivo.size)})</small></h5>`);
            $('#lbl-archivo').html('Cambiar Archivo');
        } else {
            $('#info').html('<h5>No se seleccionó ningún archivo</h5>');
        }
    });

    //envio de Accion POST
   $('.btnCargarArchivo').on('click', function () {
        $('#accion').val("POST");
    });

    //envio de Accion POST
   $('.btnCargarArchivoMultiple').on('click', function () {
        $('#accion').val("POST");
    });

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Familiar
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');



    // Enviar id_solicitud a adjuntos
$('#btn-submit-Siguiente').on('click',function () {

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/adjuntos/descripcion_adjuntos?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);

            if (r.status == "success") {
                var countAUTO = 0;
                var countFCAF = 0;
                var countREG = 0;
                var countREGF = 0;

                r.data.forEach((sol) => {
                    opcion = sol.tipo_doc;
                    switch (opcion) {
                        case 'AUTO':
                            countAUTO++;
                            break;
                        case 'FCAF':
                            countFCAF++;
                            break;
                        case 'REG':
                            countREG++;
                            break;
                        case 'REGF':
                            countREGF++;
                            break;
                        default:
                            break;
                    }
                });

                // Verificar sol_auto antes de tomar decisión
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    method: 'GET',
                    url: url_site(`api/solauto/sol_auto?id_solicitud=${id_solicitudC}`),
                    dataType: "json",
                    success: function (r2) {
                        if (r2.status == "success") {
                            // Si existe sol_auto con datos, countAUTO debe ser 1
                            if (r2.data && r2.data[0] != null) {
                                countAUTO = 1;  // Si sol_auto trae datos, countAUTO = 1
                            }
                            
                            console.log('countAUTO final:', countAUTO);
                            console.log('countFCAF:', countFCAF);
                            console.log('countREG:', countREG);
                            console.log('countREGF:', countREGF);
                            
                            if (countAUTO > 0 && countFCAF > 0 && countREG > 0 && countREGF > 0) {
                                alertSwal('success', 'Finalizo', 'Se ha finalizado el formato');

                                Swal.fire({
                                    title: '¿Desea Finalizar El Servicio?',
                                    text: "Finalizar Formato Visita Domiciliario Ingreso",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Enviar',
                                    cancelButtonText: 'Cancelar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire(
                                            'Finalizado',
                                            'Envio correctamente',
                                            'success'
                                        ).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    method: 'PUT',
                                                    headers: {
                                                        "access-token": getToken()
                                                    },
                                                    url: url_site(`api/solicitud/estado_proceso_asesor?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}&estado=${'5'}&estado_proceso=${'1'}`),
                                                    contentType: 'application/json',
                                                    success: function () {
                                                        $.ajax({
                                                            headers: {
                                                                "access-token": getToken()
                                                            },
                                                            method: 'GET',
                                                            url: url_site(`api/adjuntos/cliente_solicitud?id_solicitud=${id_solicitudC}`),
                                                            dataType: "json",
                                                            success: function (r3) {
                                                                if (r3.status == "success") {
                                                                    window.location = url_site(`solicitud/detalle?solicitud=${id_solicitudC}&cliente=${r3.data[0].id_empresa}`);
                                                                } 
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            } else {
                                // Mostrar mensajes de error específicos
                                if (countAUTO == 0) {
                                    alertSwal('error', 'Autorización', 'Falta el documento de Autorización');
                                } else if (countREG == 0) {
                                    alertSwal('error', 'Foto Interior de la Vivienda (Zona Social)', 'Falta el documento de Registro Fotografico');
                                } else if (countFCAF == 0) {
                                    alertSwal('error', 'Foto del candidato y su familia', 'Falta el documento de Registro Fotografico');
                                } else if (countREGF == 0) {
                                    alertSwal('error', 'Foto fachada', 'Falta el documento de Registro Fotografico');
                                }
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener sol_auto:', error);
                        alertSwal('error', 'Error', 'No se pudo verificar la autorización');
                    }
                });
            }
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
});

    // Enviar id_solicitud a formacion
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`conceptoProfesional_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
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
    
//Cambios con opcion multiple de documentos
function manejarCambioArchivos(inputId, infoId, progressContainer, progressBar, botonId) {
    const files = document.getElementById(inputId).files;
    let nombres = [];

    if (files.length > 0) {
        $('#' + progressContainer).show();
        $('#' + progressBar).css('width', '0%').text('0%');
        archivosCargados = false;
        $('#' + botonId).prop('disabled', true);

        for (let i = 0; i < files.length; i++) {
            nombres.push(files[i].name);
        }

        $('#' + infoId).html(nombres.join('<br>'));

        let percent = 0;
        const interval = setInterval(() => {
            percent += 20;
            $('#' + progressBar).css('width', percent + '%').text(percent + '%');

            if (percent >= 100) {
                clearInterval(interval);
                archivosCargados = true;
                $('#' + botonId).prop('disabled', false);
            }
        }, 150);
    } else {
        $('#' + progressContainer).hide();
        $('#' + infoId).html('');
        archivosCargados = false;
        $('#' + botonId).prop('disabled', true);
    }
}

// Escucha cambios en ambos inputs
$('#archivo').on('change', function () {
    manejarCambioArchivos('archivo', 'info', 'progress-container-simple', 'progress-bar-simple', 'btn-submit-adjuntos');
});

$('#archivoAlt').on('change', function () {
    manejarCambioArchivos('archivoAlt', 'infoAlt', 'progress-container-multiple', 'progress-bar-multiple', 'btn-submit-adjuntos-multiple');
});

// Manejo de drag & drop para archivoAlt
function handleDropAlt(event) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    document.getElementById('archivoAlt').files = files;
    manejarCambioArchivos('archivoAlt', 'infoAlt', 'progress-container-multiple', 'progress-bar-multiple', 'btn-submit-adjuntos-multiple');
}

// Envío del formulario
$('#btn-submit-adjuntos, #btn-submit-adjuntos-multiple').prop('disabled', true);

let archivosCargadosSimple = false;
let archivosCargadosMultiple = false;
let botonActivo = 'simple'; // 'simple' o 'multiple'

$('#archivo').on('change', function () {
    if (this.files.length > 0) {
        archivosCargadosSimple = true;
        $('#btn-submit-adjuntos').prop('disabled', false);
        $('#info').html(this.files[0].name);
    }
});

$('#archivoAlt').on('change', function () {
    if (this.files.length > 0) {
        archivosCargadosMultiple = true;
        $('#btn-submit-adjuntos-multiple').prop('disabled', false);
        mostrarNombresAlt(this.files);
    }
});

$("#btn-submit-adjuntos").on('click', function () {
    botonActivo = 'simple';
});

$("#btn-submit-adjuntos-multiple").on('click', function () {
    botonActivo = 'multiple';
});

$("#frmCargarArchivo").on('submit', function (e) {
    e.preventDefault();

    if (botonActivo === 'simple' && !archivosCargadosSimple) {
        alertSwal('warning', 'Espere', 'Debe esperar que los archivos se preparen antes de enviar (simple).');
        return;
    }

    if (botonActivo === 'multiple' && !archivosCargadosMultiple) {
        alertSwal('warning', 'Espere', 'Debe esperar que los archivos se preparen antes de enviar (múltiple).');
        return;
    }

    if (!validarCamposCargue()) return;

    showModalLoading();

    const formData = new FormData(this);
    const isMultiple = botonActivo === 'multiple';

    const url = isMultiple
        ? url_site(`api/adjuntos/archivos_adjuntos_multiple`)
        : url_site(`api/adjuntos/archivos_adjuntos`);

    const progressBar = isMultiple ? '#progress-bar-multiple' : '#progress-bar-simple';
    const progressContainer = isMultiple ? '#progress-container-multiple' : '#progress-container-simple';
    const infoContainer = isMultiple ? '#infoAlt' : '#info';
    const submitButton = isMultiple ? '#btn-submit-adjuntos-multiple' : '#btn-submit-adjuntos';

    $.ajax({
        xhr: function () {
            const xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    let percent = Math.round((evt.loaded / evt.total) * 100);
                    $(progressBar).css("width", percent + "%").text(percent + "%");
                }
            }, false);
            return xhr;
        },
        headers: { "access-token": getToken() },
        method: 'POST',
        url,
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        success: function (r) {
            hideModalLoading();

            if (r.status === "success") {
                alertSwal('success', 'Cargue', 'Cargue de archivo terminó correctamente.');

                if (!isMultiple) {
                    loadSelectOption({
                        url: url_site(`api/configuracion/${lista}`),
                        input: [{
                            id: 'tipo_doc',
                            clearOptions: true,
                            emptyText: 'Seleccione un tipo de adjuntos',
                            selectedValue: ''
                        }],
                        columnKey: 'codigo',
                        columnDescription: 'descripcion',
                        responsePath: ''
                    });
                    cargarTablaAdjuntos();
                }

                $(infoContainer).html('');
                $(progressBar).css('width', '0%').text('0%');
                $(submitButton).prop('disabled', true);

                if (isMultiple) {
                    archivosCargadosMultiple = false;
                    $('#archivoAlt').val('');
                } else {
                    archivosCargadosSimple = false;
                    $('#archivo').val('');
                    $('#lbl-archivo').text('Seleccionar Archivo');
                }

                cargarTablaAdjuntos();
            } else {
                alertSwal('error', 'Cargue', 'Error en la carga de archivos.');
            }
        },
        error: function () {
            hideModalLoading();
            alertSwal('error', 'Cargue', 'Error en la comunicación con el servidor.');
        },
        complete: function () {
            setTimeout(() => $(progressContainer).fadeOut(), 1500);
        }
    });
});

//Fin de cambio de adjuntos de Documentos


    //accion delete
    $("#tbl-adjuntos").on("click", ".btnEliminarAdjunto", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    // Función de eliminar
    $("#tbl-adjuntos").on("click", ".btnEliminarAdjunto", function (e) {
        e.preventDefault();

        let method = $('#accion').val();   // Se obtiene el tipo de método
        let id_adjunto = $(this).attr('id_adjunto');   // Se obtiene el id a eliminar

        let data = { id_adjunto: id_adjunto };

        // Mensaje de confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el adjunto de forma permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Solo si confirma, se hace la eliminación
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/adjuntos/delete_adjunto?id_adjunto=${data.id_adjunto}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (cand) {
                        Swal.fire(
                            'Eliminado',
                            'El adjunto ha sido eliminado correctamente.',
                            'success'
                        ).then(() => {
                            cargarTablaAdjuntos();
                        });
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al eliminar el adjunto.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
            }
        });
    });

}); //fin de funcion Ready()


//*********************************************************************** */
 //Se valida la lista de las variables para que no se repita si ya existe
 //*********************************************************************** */
 $('#tipo_doc').on('change', function() {
        
    // $('#formDimensionFinanciero')[0].reset();
     var id_pregunta = $('#tipo_doc').val();
     let params = new URLSearchParams(location.search);
     let id_solicitudC = params.get('id_solicitud');
     let id_servicioC = params.get('id_servicio');
     //console.log(id_preguntaC)
     $.ajax({
         headers: {
             "access-token": getToken()
         },
         type: "GET",
         //url: url_site(`api/dimensiones/validar_variable?id_pregunta=${id_pregunta}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
         url: url_site(`api/adjuntos/validar_variable?id_pregunta=${id_pregunta}&id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
         dataType: "json",
         
         success: function (resp) {
            //console.log(resp.data);
            const miBoton = document.getElementById('btn-submit-adjuntos');
             if (resp.data.length == 1) {

                alertSwal('error', 'Adjunto', 'Este Adjunto ya ha sido guardado.');
                
                // Para desbloquear el botón, establece la propiedad 'disabled' en false
                miBoton.disabled = true;
                /*$("#nivel_riesgo").prop("disabled", true);
                $("#respuesta").prop("disabled", true);
                $("#variableFamilia").focus();*/
                return false; 
             //   console.log(resp.data[0].existe);

             }
             else{
               // console.log(resp.data);
               miBoton.disabled = false;
               /*$("#nivel_riesgo").prop("disabled", false);
               $("#respuesta").prop("disabled", false);*/
             }
         }
     })
 });


//Validar adjuntos
function validarCamposCargue() {
    return true;
}

//Cargar datos de Laboral de la parte laboral
function cargarTablaAdjuntos() {
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    //var id_servicio = $('#id_servicio').val(); 
    //console.log(id_servicio);
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/adjuntos/descripcion_adjuntos?id_solicitud=${id_solicitudl}&id_servicio=${id_servicioC}`),
        dataType: "json",
        success: function (r) {
            //console.log(r);

            $('#tbl-adjuntos').DataTable().clear();
            $('#tbl-adjuntos').DataTable().destroy();

            let t = $('#tbl-adjuntos').DataTable({
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
                let contador = 1;
                r.data.forEach((sol) => {
                    var directorio = '/'+sol.directorio+'/'+sol.nombre_encr;
                    t.row.add([
                        //sol.id_adjunto,
                        contador++,
                        sol.descripcion,
                        `<a href="${directorio}" target="_blank">${sol.nombre}</a>`,
                        `<button class="btn btn-xs btn-danger btnEliminarAdjunto" id_adjunto=${sol.id_adjunto}><i class="fa fa-trash"></i> Eliminar</button>`,
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

document.getElementById('archivo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['jpg', 'jpeg','png', 'pdf'].includes(ext)) {
            //alert('Solo se permiten archivos .jpg o .png');
            alertSwal('error', 'Solo se permiten archivos .jpg, .jpeg, .png y .pdf');
            e.target.value = ''; // Limpia el input
        }
    }
});
