$(document).ready(function () {

    $("body").addClass("sidebar-collapse");
    

    cargarTablaCuentasContables();

    loadSelectOption({
        url: url_site(`api/combo/lista?estado=1`),
        input: [{
            id: 'combo',
            clearOptions: true,
            emptyText: 'Seleccione un Combo',
            selectedValue: ''
        },],
        columnKey: 'id_combo',
        columnDescription: 'nom_combo',
        responsePath: 'data'
    })

    $('.btnAddCuenta').on('click', function () {
        $('.div-editar').removeClass('hide');
        $('#formCuenta')[0].reset();
        $('#accion').val("POST");
    });

    // Crear Cuenta Contable
    $('#btn-submit-cuenta').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormCuentaContable()) {

            let method = $('#accion').val();
            let data = {
                id_cuenta: $('#id_cuenta').val(),
                item: $('#item').val(),
                concepto: $('#concepto').val(),
                combo: $('#combo').val(),
                ubicacion_cuenta: $('#ubicacion_cuenta').val(),
                estado: $('#estado').val(),
                destino_cuenta: $('#destino_cuenta').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/cuentas?id_cuenta=${data.id_cuenta}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Cuentas Contables', 'Cuenta Contable guardado satisfactoriamente');
                        cargarTablaCuentasContables();
                        $('#formCuenta')[0].reset();
                        $('#modalAddCuenta').modal('hide')
                    } else {
                        alertSwal('error', 'Cuentas Contables', r.code.code);
                        cargarTablaCuentasContables();
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

    // Editar Cuenta Contable
    $('#tbl-cuentas').on('click', '.btnEditCuenta', function () {
        $('.div-editar').addClass('hide');

        $('#accion').val("PUT");
        let id_cuenta = $(this).attr('cuenta');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/cuentas?id_cuenta=${id_cuenta}`),
            dataType: "json",
            success: function (resp) {
                $('#id_cuenta').val(resp.data.id_cuenta);
                $('#item').val(resp.data.item);
                $('#concepto').val(resp.data.concepto);
                $('#combo').val(resp.data.combo);
                $('#ubicacion_cuenta').val(resp.data.ubicacion_cuenta);
                $('#estado').val(resp.data.estado).change();
                $('#destino_cuenta').val(resp.data.destino_cuenta).change();
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddCuenta').modal();
    })


    // Activa e Inactiva una Cuenta Contable
    $('#tbl-cuentas').on('click', '.btnEstadoCuenta', function () {
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_cuenta = $(this).attr('cuenta');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Producto`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este producto?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_cuenta: id_cuenta,
                    estado: estadoNuevo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/cuentas/cambio-estado?id_cuenta=${id_cuenta}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Producto', 'El Producto se '+ nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaCuentasContables();
                            $('#formCuenta')[0].reset();
                        } else {
                            alertSwal('error', 'Producto', r.code.code);
                            cargarTablaCuentasContables();
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
});


function cargarTablaCuentasContables() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/cuentas/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-cuentas').DataTable().clear();
            $('#tbl-cuentas').DataTable().destroy();

            let t = $('#tbl-cuentas').DataTable({
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
                    title: 'REPORTE: Listado de Cuentas Contables',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((cta) => {

                    t.row.add([
                        cta.id_cuenta,
                        cta.item,
                        cta.concepto,
                        cta.nom_combo,
                        (cta.ubicacion_cuenta == 'B') ? 'Bogotá' : 'Fuera Bogotá',
                        `<button class="btn btn-xs btn-${(cta.estado == 1) ? 'success' : 'danger'} btnEstadoCuenta"
                            cuenta=${cta.id_cuenta} estado=${cta.estado}>
                            ${(cta.estado == 1) ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        cta.destino_cuenta,
                        cta.usr_create,
                        cta.fch_create,
                        `<button class="btn btn-xs btn-warning btnEditCuenta" cuenta="${cta.id_cuenta}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>`
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


function validateFormCuentaContable() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#item').val() == "" || $('#item').val() == null) {
        alertSwal('error', 'Item', 'Este campo es obligatorio');
        $("#item").focus();
        return false;
    }

    if ($('#concepto').val() == "" || $('#concepto').val() == null) {
        alertSwal('error', 'Concepto', 'Este campo es obligatorio');
        $("#concepto").focus();
        return false;
    }

    return true;

}