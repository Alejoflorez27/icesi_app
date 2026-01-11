$(document).ready(function () {

    $("body").addClass("sidebar-collapse");
    $('.div-servicios').addClass('hide');

    cargarTablaCombos();

    loadSelectOption({
        url: url_site(`api/cuentas/lista?estado=1`),
        input: [{
            id: 'cuenta',
            clearOptions: true,
            emptyText: 'Seleccione una Cuenta',
            selectedValue: ''
        },],
        columnKey: 'id_cuenta',
        columnDescription: 'concepto',
        responsePath: 'data'
    })

    loadSelectOption({
        url: url_site(`api/ubicacion/ciudad`),
        input: [{
            id: 'ciudad',
            clearOptions: true,
            emptyText: 'Seleccione una Ciudad',
            selectedValue: ''
        },],
        columnKey: 'id_ciudad',
        columnDescription: 'nombre',
        responsePath: 'data'
    })

    $('.btnAddCombo').on('click', function () {
        $('#formCombo')[0].reset();
        $('#accion').val("POST");
    });


    // Crear Combo
    $('#btn-submit-combo').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormCombo()) {

            let method = $('#accion').val();
            let data = {
                id_combo: $('#id_combo').val(),
                nom_combo: $('#nom_combo').val(),
                valor_bogota: $('#valor_bogota').val(),
                sla_bogota: $('#sla_bogota').val(),
                valor_externo: $('#valor_externo').val(),
                sla_externo: $('#sla_externo').val(),
                env_correo: $('#env_correo').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/combo?id_combo=${data.id_combo}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Combo', 'Combo guardado satisfactoriamente');
                        cargarTablaCombos();
                        $('#formCombo')[0].reset();
                        $('#modalAddCombo').modal('hide')
                    } else {
                        alertSwal('error', 'Combo', r.code.code);
                        cargarTablaCombos();
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


    // Editar Combo
    $('#tbl-combos').on('click', '.btnEditCombo', function () {

        $('#accion').val("PUT");
        let id_combo = $(this).attr('combo');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/combo?id_combo=${id_combo}`),
            dataType: "json",
            success: function (resp) {
                $('#id_combo').val(resp.data.id_combo);
                $('#nom_combo').val(resp.data.nom_combo);
                $('#valor_bogota').val(resp.data.valor_bogota);
                $('#sla_bogota').val(resp.data.sla_bogota);
                $('#valor_externo').val(resp.data.valor_externo);
                $('#sla_externo').val(resp.data.sla_externo);
                $('#env_correo').val(resp.data.env_correo).change();
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddCombo').modal();
    })

    // Activa e Inactiva un Combo
    $('#tbl-combos').on('click', '.btnEstadoCombo', function () {
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_combo = $(this).attr('combo');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Combo`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este combo?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_combo: id_combo,
                    estado: estadoNuevo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/combo/cambio-estado?id_combo=${id_combo}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Combos', 'El Combo se '+ nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaCombos();
                            $('#formCombo')[0].reset();
                        } else {
                            alertSwal('error', 'Combos', r.code.code);
                            cargarTablaCombos();
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

    $('#tbl-combos').on('click', '.btnDetalleCombo', async function() {
        
        $('#div-box-combos').removeClass('col-md-12');
        $('#div-box-combos').addClass('col-md-10');

        $('.div-servicios').removeClass('hide');
        let id_combo = $(this).attr('combo');
        $('#idCombo').val(id_combo);

        let registros_tabla_servicios = '';
        //ajax para ver todos los servicios
        showModalLoading();
        await $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/servicio/listas`),
            dataType: "json",
            success: function(resp) {
                resp.forEach(p => {
                    if (p.estado > 0) {
                        registros_tabla_servicios += `
                        <tr>
                            <td style="width: 5%;">
                                <input type="checkbox" class="checkbox-servicio" servicio="${p.id_servicio}">
                            </td>
                            <td style="width: 95%">
                                ${p.nom_servicio}
                            </td>
                        </tr>`
                    }
                })

                $('#tbl-servicios-combo').html(registros_tabla_servicios);
            }
        }).done(function() {
            hideModalLoading();
        });

        showModalLoading();
        $.ajax({
            type: "GET",
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/combo/listacomboservicio?id_combo=${id_combo}`),
            dataType: "json",
            success: function(resp) {
                resp.data?.forEach(p => {
                    $(`.checkbox-servicio[servicio="${p.id_servicio}"]`).prop((p.activo == 1 ) ?'checked' : 'unchecked', true);
                })
            }
        }).done(function() {
            hideModalLoading();
        });
    })

    $('#tbl-servicios-combo').on('click', '.checkbox-servicio', async function() {

        let id_servicio = $(this).attr('servicio');
        let id_combo = $('#idCombo').val();

        let isSelected = $(this).is(':checked');

        data = {
            id_servicio : id_servicio,
            id_combo: id_combo
        }
        showModalLoading();
        $.ajax({
            method: 'POST',
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/combo/servicio-${isSelected ? 'agregar' : 'eliminar'}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function(r) {
                if (r.status == "success") {
                    alertSwal('success', 'Combos Servicios', 'Servicio '+ (isSelected ? 'Agregado' : 'Eliminado') +' al combo satisfactoriamente');
                } else {
                    alertSwal('error', 'Combos Servicios', r.code.code);
                }
            },
            error: function(xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function() {
                hideModalLoading();
            }
        });

    })

});


function cargarTablaCombos() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/combo/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-combos').DataTable().clear();
            $('#tbl-combos').DataTable().destroy();

            let t = $('#tbl-combos').DataTable({
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
                    title: 'REPORTE: Listado de Combos y Servicios',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((cmb) => {

                    t.row.add([
                        cmb.id_combo,
                        cmb.nom_combo,
                        '$ '+ cmb.valor_bogota,
                        cmb.sla_bogota,
                        '$ '+ cmb.valor_externo,
                        cmb.sla_externo,
                        (cmb.env_correo == "1") ? 'Si' : 'No',
                        `<button class="btn btn-xs btn-${(cmb.estado == 1) ? 'success' : 'danger'} btnEstadoCombo"
                            combo=${cmb.id_combo} estado=${cmb.estado}>
                            ${(cmb.estado == 1) ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        cmb.usr_create,
                        cmb.fch_create,
                        `<button class="btn btn-xs btn-warning btnEditCombo" combo="${cmb.id_combo}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>
                        ${(cmb.estado == 1) ? `<button class="btn btn-xs btn-info btnDetalleCombo" combo="${cmb.id_combo}"><i class="fa fa-cogs"></i> Ver Servicios</button>` : ``}
                        
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

function validateFormCombo() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nom_combo').val() == "" || $('#nom_combo').val() == null) {
        alertSwal('error', 'Nombre Combo', 'Este campo es obligatorio');
        $("#nom_combo").focus();
        return false;
    }
    
    if ($('#valor_bogota').val() == "" || $('#valor_bogota').val() == null) {
        alertSwal('error', 'Valor Combo Bogotá', 'Este campo es obligatorio');
        $("#valor_bogota").focus();
        return false;
    }

    if ($('#sla_bogota').val() == "" || $('#sla_bogota').val() == null) {
        alertSwal('error', 'SLA Combo Bogotá', 'Este campo es obligatorio');
        $("#sla_bogota").focus();
        return false;
    }

    if ($('#valor_externo').val() == "" || $('#valor_externo').val() == null) {
        alertSwal('error', 'Valor Combo Fuera Bogotá', 'Este campo es obligatorio');
        $("#valor_externo").focus();
        return false;
    }

    if ($('#sla_externo').val() == "" || $('#sla_externo').val() == null) {
        alertSwal('error', 'SLA Combo Fuera Bogotá', 'Este campo es obligatorio');
        $("#sla_externo").focus();
        return false;
    }

    if ($('#env_correo').val() == "" || $('#env_correo').val() == null) {
        alertSwal('error', 'Envía Correo', 'Este campo es obligatorio');
        $("#env_correo").focus();
        return false;
    }

    return true;

}