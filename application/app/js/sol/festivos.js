$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    //Cargar la tabla de la distribucion de la vivienda
    cargarTablaVivDistribucion();


    //envio de Accion POST
   $('.btnAddOperativo').on('click', function () {
        $('#accion').val("POST");
    });

    //Envio de Accion PUT
    $('#btn-submit-editOperativo').on('click', function () {
        $('#formOperativo')[0].reset();
        $('#accion').val("PUT");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');

    //Enviar id_solicitud a laboral visita ingreso
    $('#btn-submit-Siguiente').on('click',function () {
   
        window.location = url_site(`conceptoProfesional_visita_asociado?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })

    // Enviar id_solicitud a dimension familiar visita ingreso
    $('#btn-submit-Anterior').on('click',function () {
   
        window.location = url_site(`seguridad_informatica_visita_asociado?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
    })
   
    // Crear Distribucion de la vivienda
    $('#btn-submit-operativo').on('click', function (e) {
        e.preventDefault(e);


        // Obtener la cadena de texto de la fecha
        var fechaStr = $('#fecha').val();

        // Convertir la cadena de texto a un objeto Date
        var fecha = new Date(fechaStr);

        // Obtener el año
        var ano = fecha.getFullYear();

        // Obtener el mes (agregamos 1 porque los meses en JavaScript van de 0 a 11)
        var mes = fecha.getMonth() + 1;

        /*console.log("Año: " + ano);
        console.log("Mes: " + mes);*/


        if (validateformOperativo()) {

            let method = $('#accion').val();
            let data = {
                ano: ano,
                mes: mes,
                fecha: fechaStr,
                descripcion: $('#descripcion').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/festivos`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Festivo', 'Guardado satisfactoriamente');
                        cargarTablaVivDistribucion();
                        $('#formOperativo')[0].reset();
                    } else {
                        alertSwal('error', 'Festivo', r.code.code);
                        cargarTablaVivDistribucion();
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
    });// Fin de Crear Distribucion de la vivienda


    //editar Distribucion de la vivienda
    $('#tbl-operativo').on('click', '.btnEditOperativo', function () {
        //$('#titulo-modal-formacion').html('Editar Formación');

        $('#accion').val("PUT");
        let id_dias = $(this).attr('id_dias');
        //console.log(id_dias);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/festivos?id_dias=${id_dias}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp.data[0].fecha);

                // Fecha en formato cadena de texto
                var fechaStr = resp.data[0].fecha;
                // Obtener solo la parte de la fecha (eliminar la parte de la hora)
                var fechaSoloFecha = fechaStr.split(" ")[0];
                
                // Asignar la fecha al campo de tipo date
                $('#fecha_edit').val(fechaSoloFecha);
                $('#id_dias').val(resp.data[0].id_dias);
                $('#descripcion_edit').val(resp.data[0].descripcion);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditOperativo').modal();
    })
    //fin de editar Distribucion de la vivienda 
    
   $('#btn-submit-editOperativo').on('click', function (e) {
        e.preventDefault();
        if(validateformOperativoEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos

            // Obtener la cadena de texto de la fecha
            var fechaStr = $('#fecha_edit').val();
            // Convertir la cadena de texto a un objeto Date
            var fecha = new Date(fechaStr);
            // Obtener el año
            var ano = fecha.getFullYear();
            // Obtener el mes (agregamos 1 porque los meses en JavaScript van de 0 a 11)
            var mes = fecha.getMonth() + 1;

            /*console.log("Año: " + ano);
            console.log("Mes: " + mes);*/
                        
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_dias: $('#id_dias').val(),
                ano: ano,
                mes: mes,
                fecha: fechaStr,
                descripcion: $('#descripcion_edit').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/festivos/update?id_dias=${data.id_dias}`), //Se le da el id_distribucion de la data
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (cand) {

                    Swal.fire(
                        'Festivo',
                        'ha sido Actualizado',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {

                        }
                        cargarTablaVivDistribucion();
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
    $("#tbl-operativo").on("click", ".btnEliminarOperativo", function () {
        
        $('#accion').val("DELETE");

    })//Fin accion delete

    //Funcion de eliminar
    $("#tbl-operativo").on("click", ".btnEliminarOperativo", function (e) {
        e.preventDefault();
        
        let method = $('#accion').val();   //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        let id_diasC = $(this).attr('id_dias');   //Se Obtiene el id a Eliminar

        let data = {                                //Se Prepara la Data que va a ser modificada en la BD
            id_dias: id_diasC,
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/festivos/delete?id_dias=${data.id_dias}`), //Se le da el id_distribucion de la data
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (cand) {

                Swal.fire(
                    'Festivo',
                    'Ha Sido Eliminado Correctamente',
                    'success'
                  ).then((result) => {
                    if (result.isConfirmed) {
                        cargarTablaVivDistribucion();
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

//Funcion de Validar los campos de Crear la formacion
function validateformOperativo() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#fecha').val() == "" || $('#fecha').val() == null) {
        alertSwal('error', 'Fecha', 'Este campo es obligatorio');
        $("#fecha").focus();
        return false;
    }
    if ($('#descripcion').val() == "" || $('#descripcion').val() == null) {
        alertSwal('error', 'Descripción', 'Este campo es obligatorio');
        $("#descripcion").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Crear la distribucion de la vivienda

//Funcion de Validar los campos de Editar la distribucion de la vivienda
function validateformOperativoEdit() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#fecha_edit').val() == "" || $('#fecha_edit').val() == null) {
        alertSwal('error', 'Fecha', 'Este campo es obligatorio');
        $("#fecha_edit").focus();
        return false;
    }
    if ($('#descripcion_edit').val() == "" || $('#descripcion_edit').val() == null) {
        alertSwal('error', 'Descripcion', 'Este campo es obligatorio');
        $("#descripcion_edit").focus();
        return false;
    }
    return true;

}//Fin Funcion de Validar los campos de Editar la formacion


//Cargar datos de Distribucion de vivienda
function cargarTablaVivDistribucion() {
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
        url: url_site(`api/festivos/lista`),
        dataType: "json",
        success: function (r) {
            //console.log(r);
            $('#tbl-operativo').DataTable().clear();
            $('#tbl-operativo').DataTable().destroy();

            let t = $('#tbl-operativo').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
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
                let contador = 1;
                r.data.forEach((sol) => {

                    t.row.add([
                        //sol.id_distribucion,
                        contador++,
                        sol.fecha,
                        sol.descripcion,
                        `<button class="btn btn-xs btn-warning btnEditOperativo" id_dias="${sol.id_dias}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                         <button class="btn btn-xs btn-danger btnEliminarOperativo" id_dias=${sol.id_dias}><i class="fa fa-trash"></i> Eliminar</button>`,
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
//Fin de la tabla de la distribucion de vivienda


