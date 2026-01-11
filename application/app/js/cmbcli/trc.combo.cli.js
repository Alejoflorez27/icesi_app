$(document).ready(function () {

    // $("body").addClass("sidebar-collapse");

    loadSelectOption({
       // url: url_site(`api/empresa/empresa-padre?estado=1`),  
       url: url_site('api/empresa/empresa-padre-lista?estado=1'),
       input: [{
            id: 'id_empresa',
            clearOptions: true,
            emptyText: 'Seleccione un Cliente',
            selectedValue: ''
        },],
        columnKey: 'id_empresa',
        columnDescription: 'razon_social',
        responsePath: 'data'
    })

    loadSelectOption({
        url: url_site(`api/combo/lista-combos?estado=1`),
        input: [{
            id: 'id_combo',
            clearOptions: true,
            emptyText: 'Seleccione un Combo Servicio',
            selectedValue: ''
        },],
        columnKey: 'id_combo',
        columnDescription: 'nom_combo',
        responsePath: 'data'
    })

    cargarTablaCombosClientes();

    $('.btnAddComboCliente').on('click', function () {
        $('.div-crear').removeClass('hide');
        $('.div-editar').addClass('hide');
        $('#formComboCliente')[0].reset();
        $('#accion').val("POST");
        $('#metodo').val("AGREGAR");
    });

    $('#id_combo').on('change', function () {
        let id_combo = $('#id_combo').val();
        let id_combo_cli = $('#id_combo_cli').val();

        if (id_combo_cli.trim().length === 0) {

            showModalLoading();
            $.ajax({
                method: 'GET',
                headers: {
                    "access-token": getToken()
                },
                type: "GET",
                url: url_site(`api/combo?id_combo=${id_combo}`),
                dataType: "json",
                success: function (resp) {
                    $('#valor_bogota').val(resp.data.valor_bogota);
                    $('#valor_externo').val(resp.data.valor_externo);
                }
            }).done(function () {
                hideModalLoading();
            });
        }

    });



    // Crear Combo Cliente
    $('#btn-submit-comboCliente').on('click', function (e) {
        e.preventDefault(e);
        let metodo = $('#metodo').val();
        let id_combo_cli = $('#id_combo_cliEdit').val();

        let method = ''
        switch (metodo) {
            case 'AGREGAR':
                method = 'POST';
                url = `api/comboCli`;
                break;
            case 'EDITAR':
                metodo = 'PUT';
                url = `api/comboCli?id_combo_cli=${id_combo_cli}`
                break;
        }

        if (validateFormComboCli()) {

            let method = $('#accion').val();
            let data = {
                id_combo_cli: $('#id_combo_cliEdit').val(),
                id_combo: $('#id_combo').val(),
                id_empresa: $('#id_empresa').val(),
                valor_bogota: $('#valor_bogota').val(),
                valor_externo: $('#valor_externo').val(),
                estado: $('#estado').val(),
            }


            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url,
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Combo Clientes', 'Combo Cliente guardado satisfactoriamente');
                        cargarTablaCombosClientes();
                        $('#formComboCliente')[0].reset();
                        $('#modalAddComboCliente').modal('hide')
                    } else {
                        alertSwal('error', 'Combo Clientes', r.code.code);
                        cargarTablaCombosClientes();
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

    // Editar Combo Cliente
    $('#tbl-combosCli').on('click', '.btnEditComboCliente', function () {
        accionFormEditar();
        $('.div-crear').addClass('hide');
        $('.div-editar').removeClass('hide');
        $('#metodo').val("EDITAR");

        $('#accion').val("PUT");
        let id_combo_cli = $(this).attr('comboCliente');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/comboCli?id_combo_cli=${id_combo_cli}`),
            dataType: "json",
            success: function (resp) {
                $('#id_combo_cliEdit').val(resp.data.id_combo_cli);
                $('#combo').val(resp.data.nom_combo);
                $('#empresa2').val(resp.data.razon_social);
                $('#valor_bogota').val(resp.data.valor_bogota);
                $('#valor_externo').val(resp.data.valor_externo);
                $('#id_empresa').val(resp.data.id_empresa);
            }
        }).done(function () {
            hideModalLoading();
        });
//        $('#modalAddComboCliente').modal();

    })


    // Activa e Inactiva una Combo Cliente
    $('#tbl-combosCli').on('click', '.btnEstadoComboCliente', function () {
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_combo_cliente = $(this).attr('comboCliente');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Combo Cliente`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este combo cliente?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_combo_cliente: id_combo_cliente,
                    estado: estadoNuevo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/comboCli/cambio-estado?id_combo_cli=${id_combo_cliente}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Producto', 'El Combo Cliente se ' + nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaCombosClientes();
                            $('#formComboCliente')[0].reset();
                        } else {
                            alertSwal('error', 'Producto', r.code.code);
                            cargarTablaCombosClientes();
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


function cargarTablaCombosClientes() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/comboCli/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-combosCli').DataTable().clear();
            $('#tbl-combosCli').DataTable().destroy();

            let t = $('#tbl-combosCli').DataTable({
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
                    title: 'REPORTE: Listado de Combos Clientes',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((cmbcli) => {

                    t.row.add([
                        cmbcli.id_combo_cli,
                        cmbcli.razon_social,
                        cmbcli.nom_combo,
                        '$ ' + number_format(cmbcli.valor_bogota),
                        '$ ' + number_format(cmbcli.valor_externo),
                        `<button class="btn btn-xs btn-${(cmbcli.estado == 1) ? 'success' : 'danger'} btnEstadoComboCliente"
                            comboCliente=${cmbcli.id_combo_cli} estado=${cmbcli.estado}>
                            ${(cmbcli.estado == 1) ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        cmbcli.usr_create,
                        cmbcli.fch_create,
                        // Si está inactivo no se puede editar
                        ((cmbcli.estado == 1) ? `<button class="btn btn-xs btn-warning btnEditComboCliente" comboCliente="${cmbcli.id_combo_cli}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>`
                            : ``)
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


function validateFormComboCli() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#id_combo_cliEdit') == null) {
        if ($('#id_empresa').val() == "" || $('#id_empresa').val() == null) {
            alertSwal('error', 'Empresa', 'Este campo es obligatorio');
            $("#id_empresa").focus();
            return false;
        }
    } else {
        return true;
    }

    return true;

}

function accionFormEditar() {
    $('#empresa2').attr('readonly', true);
    $('#combo').attr('readonly', true);
    $('#formComboCliente')[0].reset();

}