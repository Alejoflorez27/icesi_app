$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    cargarTablaServicios();
    $('.div-tipo-servicio').addClass('hide');

    $('#tipo_servicio').on('change', function () {
        if ($('#tipo_servicio').val() == 'F') {
            $('.div-tipo-servicio').removeClass('hide');
        } else {
            $('.div-tipo-servicio').addClass('hide');
        }
    });

    loadSelectOption({
        url: url_site(`api/producto/lista?estado=1`),
        input: [{
            id: 'producto',
            clearOptions: true,
            emptyText: 'Seleccione un Producto',
            selectedValue: ''
        },],
        columnKey: 'id_producto',
        columnDescription: 'nom_prod',
        responsePath: 'data'
    })

    $('.btnAddServicio').on('click', function () {
        $('.div-editar').removeClass('hide');
        $('#formServicio')[0].reset();
        $('#accion').val("POST");
    });

    // Crear Servicio
    $('#btn-submit-servicio').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormServicio()) {

            let method = $('#accion').val();
            let data = {
                id_servicio: $('#id_servicio').val(),
                id_producto: $('#producto').val(),
                nom_servicio: $('#nom_servicio').val(),
                tipo_servicio: $('#tipo_servicio').val(),
                estado: $('#estado').val(),
                reporte: $('#reporte').val(),
                ruta_reporte: $('#ruta_reporte').val(),
                valor_bogota: $('#valor_bogota').val(),
                valor_fuera_bogota: $('#valor_fuera_bogota').val(),
                valor_adicional: $('#valor_adicional').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/servicio?id_servicio=${data.id_servicio}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Servicio', 'Servicio guardado satisfactoriamente');
                        cargarTablaServicios();
                        $('#formServicio')[0].reset();
                        $('#modalAddServicio').modal('hide')
                    } else {
                        alertSwal('error', 'Servicio', r.code.code);
                        cargarTablaServicios();
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


    // Editar Poducto
    $('#tbl-servicios').on('click', '.btnEditServicio', function () {
        $('#titulo-modal-servicio').html('Editar Servicio');
        $('.div-editar').addClass('hide');

        $('#accion').val("PUT");
        let id_servicio = $(this).attr('servicio');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/servicio?id_servicio=${id_servicio}`),
            dataType: "json",
            success: function (resp) {
                $('#id_servicio').val(resp.data.id_servicio);
                $('#producto').val(resp.data.id_producto);
                $('#nom_servicio').val(resp.data.nom_servicio);
                $('#tipo_servicio').val(resp.data.tipo_servicio);
                $('#estado').val(resp.data.estado).change();
                $('#reporte').val(resp.data.reporte).change();
                $('#ruta_reporte').val(resp.data.ruta_reporte).change();
                $('#valor_bogota').val(resp.data.valor_bogota).change();
                $('#valor_fuera_bogota').val(resp.data.valor_fuera_bogota).change();
                $('#valor_adicional').val(resp.data.valor_adicional).change();
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddServicio').modal();
    })

    // Activa e Inactiva un Servicio
    $('#tbl-servicios').on('click', '.btnEstadoServicio', function () {
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_servicio = $(this).attr('servicio');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Servicio`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este servicio?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_servicio: id_servicio,
                    estado: estadoNuevo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/servicio/cambio-estado?id_servicio=${id_servicio}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Servicio', 'El Servicio se ' + nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaServicios();
                            $('#formServicio')[0].reset();
                        } else {
                            alertSwal('error', 'Servicio', r.code.code);
                            cargarTablaServicios();
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () {
                    }
                });
            }
        });
    })

    $('#tbl-servicios').on('click', '.btnDetallePerfil', async function () {
        
        $('#div-box-servicios').removeClass('col-md-12');
        $('#div-box-servicios').addClass('col-md-9');

        $('.div-perfiles').removeClass('hide');
        let id = $(this).attr('servicio');
        $('#idServcio').val(id);

        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/tipo-servicio?id=${id}`),
            dataType: "json",
            success: function (resp) {
                $('#servicio-desc').text(resp.data.descripcion);
            }
        }).done(function () {
            hideModalLoading();
        });

        let registros_tabla_perfil = '';
        //ajax para ver todos los perfiles
        showModalLoading();
        await $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/perfil/perfiles-servicios`),
            dataType: "json",

            success: function (resp) {
                if (resp.status == "success") {
                    resp.data.forEach(p => {
                        // if (p.id > 2) {
                        registros_tabla_perfil += `
                        <tr>
                            <td style="width: 5%;">
                                <input type="checkbox" class="checkbox-perfil" perfil="${p.id}">
                            </td>
                            <td style="width: 95%">
                                ${p.descripcion}
                            </td>
                        </tr>`
                        // }
                    })
                    $('#tbl-perfiles').html(registros_tabla_perfil);
                };
            }
        }).done(function () {
            hideModalLoading();
        });

        // showModalLoading();
        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/perfilServicio/perfiles?id=${id}`),
            dataType: "json",
            success: function (resp) {
                resp.data?.forEach(p => {
                    $(`.checkbox-perfil[perfil="${p.perfil}"]`).prop('checked', true);
                })
            }
        }).done(function () {
            hideModalLoading();
        });
    })

    $('#tbl-servicio-perfil').on('click', '.checkbox-perfil', async function () {

        let id_servicio = $('#idServcio').val();
        let id_perfil = $(this).attr('perfil');

        let isSelected = $(this).is(':checked');

        data = {
            perfil: id_perfil,
            servicio: id_servicio
        }
        showModalLoading();
        $.ajax({
            method: 'POST',
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/perfilServicio/perfil-${isSelected ? 'agregar' : 'eliminar'}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Perfil Servicio', 'Servicio ' + (isSelected ? 'Agregado' : 'Eliminado') + ' al combo satisfactoriamente');
                } else {
                    alertSwal('error', 'Perfil Servicio', r.code.code);
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });

    })

});


function cargarTablaServicios() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/servicio/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-servicios').DataTable().clear();
            $('#tbl-servicios').DataTable().destroy();

            let t = $('#tbl-servicios').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "asc"],
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Servicios',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((srv) => {

                    t.row.add([
                        srv.id_servicio,
                        srv.nom_prod,
                        srv.nom_servicio,
                        (srv.tipo_servicio == 'M') ? 'Manual' : 'Formulario',
                        srv.reporte,
                        srv.ruta_reporte,
                        (srv.valor_adicional == 'S') ? 'Sí' : 'No',
                        '$ ' + number_format(srv.valor_bogota),
                        '$ ' + number_format(srv.valor_fuera_bogota),
                        `<button class="btn btn-xs btn-${(srv.estado == 1) ? 'success' : 'danger'} btnEstadoServicio"
                            servicio=${srv.id_servicio} estado=${srv.estado}>
                            ${(srv.estado == 1) ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        srv.usr_create,
                        srv.fch_create,
                        `<button class="btn btn-xs btn-warning btnEditServicio" servicio="${srv.id_servicio}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button> 
                        <button class="btn btn-xs btn-info btnDetallePerfil" servicio="${srv.id_servicio}"><i class="fa fa-user"></i> Ver Perfil</button>
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


function validateFormServicio() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nom_servicio').val() == "" || $('#nom_servicio').val() == null) {
        alertSwal('error', 'Nombre Servicio', 'Este campo es obligatorio');
        $("#nom_servicio").focus();
        return false;
    }

    if ($('#producto').val() == "" || $('#producto').val() == null) {
        alertSwal('error', 'Nombre Producto', 'Este campo es obligatorio');
        $("#producto").focus();
        return false;
    }

    return true;

}