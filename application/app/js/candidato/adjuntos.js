$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //Cargar la tabla adjuntos
    cargarTablaAdjuntos();
    
    lista = 'tipo_adjuntos';
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

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Familiar
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');

    // Enviar id_solicitud a adjuntos
    $('#btn-submit-Siguiente').on('click',function () {
        alertSwal('success', 'Finalizo', 'Se ha finalizado el formato');

        Swal.fire({
            title: '¿Desea Finalizar Documento?',
            text: "Una Ves Finalizado No Podra Volver a ingresar",
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
                    // Capturar el elemento HTML que contiene la variable oculta
                    var hiddenInput = document.getElementById('accion_candidato');

                    // Obtener el valor de la variable oculta
                    var username = hiddenInput.value;
                    $.ajax({
                        headers: {
                            "access-token": getToken()
                        },
                        method: 'PUT',
                        url: url_site(`api/usuario/inactivar-candidato?username=${username}`),
                        dataType: "json",
                        contentType: 'application/json',
                        success: function (r) {
                            //console.log(r);
                            window.location = url_site(`salir`)
                            /*$.ajax({
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
                            })*/

                        }
                    })
                    
                }
              })
              
            }
          })
    })

    // Enviar id_solicitud a formacion
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`laboral?id_solicitud=${id_solicitudC}`)
    })
    

    $("#frmCargarArchivo").on('submit', function (e) {

            e.preventDefault();
            
            if (validarCamposCargue()) {
               // $('#modalCargarArchivo').modal("hide");
               showModalLoading()
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    method: 'POST',
                    url: url_site(`api/adjuntos/archivo`),
                    data: new FormData(this),
                    processData: false,
                    cache: false,
                    contentType: false,
                    dataType: "json",
                    success: function (r) {

                    //console.log(r);
                    if (r.status == "success") {
                            alertSwal('success', 'Cargue', 'Cargue de archivo terminó correctamente.');
                            $('#frmCargarArchivo')[0].reset();
                            $('#info').html("");
                            window.location = url_site(`adjuntos?id_solicitud=${id_solicitudC}`)
                            cargarTablaAdjuntos();
                        } else {
                            alertSwal('error', 'Cargue', r.code.code);
                            cargarTablaAdjuntos();
                        } 
                    }
                }).done(function () {
                    hideModalLoading();
                });
            }
    });

    //accion delete
    $("#tbl-adjuntos").on("click", ".btnEliminarAdjunto", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-adjuntos").on("click", ".btnEliminarAdjunto", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_adjunto = $(this).attr('id_adjunto');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_adjunto: id_adjunto,
        }


        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/adjuntos/delete_adjunto?id_adjunto=${data.id_adjunto}`), //Se le da el id_candidato de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {
                
                Swal.fire(
                    'Adjuntos',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        cargarTablaAdjuntos();
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

//Validar adjuntos
function validarCamposCargue() {
    return true;
}

//Cargar datos de Laboral de la parte laboral
function cargarTablaAdjuntos() {
    let params = new URLSearchParams(location.search);
    let id_solicitudl = params.get('id_solicitud');
    var id_servicio = $('#id_servicio').val(); 
    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/adjuntos/descripcion_adjuntos?id_solicitud=${id_solicitudl}&id_servicio=${id_servicio}`),
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
            var contador = 0
            if (r.status == "success") {
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