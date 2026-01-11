$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    loadSelectOption({
        url: url_site(`api/empresa/lista?estado=1`),
        input: [{
            id: 'filter_cliente',
            clearOptions: true,
            emptyText: 'Seleccione un Cliente',
            selectedValue: ''
        },],
        columnKey: 'id_empresa',
        columnDescription: 'razon_social',
        responsePath: 'data'
    })

    $('#btnBuscar').on('click', function () {
        cargarTablaServiciosPorFacturar();
    });

    cargarTablaServiciosPorFacturar();

    $('#tbl-srvXFacturar').on('click', '.btnPrefacturar', function () {
        let cliente = $(this).attr('empresa');
        window.location = url_site(`prefactura/liquidacion?id_empresa=${cliente}`)
    });

    $('#check-all').change(function () {
        let all = $(this).prop('checked');
        $('.item-solicitud').prop('checked', all).change();
    });

    $('.item-solicitud').change(function () {
        solicitudId = $(this).attr('solicitudId');
        comboId = $(this).attr('comboId');

        totalSolicitud = total_solicitud(solicitudId);
        $(`#total-solicitud-${solicitudId}`).text("$ " + number_format(totalSolicitud));

        totalFactura = total_factura();
        $('#total-factura').text("$ " + number_format(totalFactura.valor));
        $('#resumen-total-valor').text("$ " + number_format(totalFactura.valor));
        $('#resumen-total-solicitudes').text(totalFactura.cant_solicitudes);
        $('#check-all').prop('checked', totalFactura.all);
    });

    $('#btnPreFacturarR').on('click', function () {
        let params = new URLSearchParams(location.search);
        let cliente = params.get('id_empresa');
        let method = 'POST';
        let datosFactura = total_factura();
        let data = {
            cliente: cliente,
            valor_neto: datosFactura.valor,
            solicitudes: datosFactura.solicitudes
        }
        showModalLoading();
        $.ajax({
            method: method,
            headers: { "access-token": getToken() },
            url: url_site(`api/facturacion`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwalR('success', `Prefactura #${r.data?.id ?? ''}`, 'Prefactura guardada satisfactoriamente', url_site(`prefactura/`));
                } else {
                    alertSwalR('error', 'Prefactura', r.code.code, '');
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al procesar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });

    })

    // $('#tbl-facturas').on('click', '.btnVerDetalle', function () {
    $('#btnVerDetalleR').on('click', function () {
        accionFormEditar($(this));
        $('#modalVerfactura').modal();
    });

    $('#btnEnviarClienteR').on('click', function () {
        let params = new URLSearchParams(location.search);
        let id_factura = params.get('id_factura');
        let datosFactura = total_factura();
        let data = {
            id_factura: id_factura,
        }
        showModalLoading();
        $.ajax({
            method: 'GET',
            headers: { "access-token": getToken() },
            url: url_site(`api/facturacion/enviar-cliente?id_factura=${id_factura}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwalR('success', 'Prefactura', 'Prefactura enviada al cliente satisfactoriamente', url_site(`prefactura/cliente`));
                } else {
                    alertSwalR('error', 'Prefactura', r.code.code, '');
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al procesar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });

    })

    //Aprobar la prefactura
    $('#btnAprobar').on('click', function () {
        let params = new URLSearchParams(location.search);
        let id_factura = params.get('id_factura');
        let datosFactura = total_factura();
        let data = {
            id_factura: id_factura,
            solicitudes: datosFactura.solicitudes,
            motivo: null
        }
        showModalLoading();
        $.ajax({
            method: 'PUT',
            headers: { "access-token": getToken() },
            url: url_site(`api/facturacion/aprobar?id_factura=${id_factura}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwalR('success', 'Prefactura', 'Prefactura aprobada satisfactoriamente', url_site(`prefactura/cliente`));
                } else {
                    alertSwalR('error', 'Prefactura', r.code.code, '');
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al procesar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });

    })


    $('#btnRechazar').on('click', function () {
        let params = new URLSearchParams(location.search);
        let id_factura = params.get('id_factura');


        Swal.fire({
            type: 'question',
            title: `Rechazar Prefactura`,
            text: `¿Está seguro de Rechazar esta PreFactura?`,
            input: 'text',
            inputAttributes: {
                id: 'motivo_rechazo',
                name: 'motivo_rechazo',
                required: 'true',
                autocapitalize: 'off',
                placeholder: 'Motivo Rechazo'
            },
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let motivo_rechazo = $('#motivo_rechazo').val();
                let data = {
                    id_factura: id_factura,
                    motivo_rechazo: motivo_rechazo,
                }
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/facturacion/rechazar-factura?id_factura=${id_factura}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'PreFactura', 'La prefactura se rechazó satisfactoriamente');
                            window.location = url_site(`prefactura/facturas/`)
                            // window.location.reload();
                        } else {
                            alertSwal('error', 'PreFactura', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });

    })

    $('#btnAprobarFacturador').on('click', function () {

        let params = new URLSearchParams(location.search);
        let id_factura = params.get('id_factura');
        let datosFactura = total_factura();


        Swal.fire({
            type: 'question',
            title: `Aprobar Prefactura`,
            text: `¿Está seguro de Aprobar esta PreFactura?`,
            input: 'text',
            inputAttributes: {
                id: 'motivo_aprobacion',
                name: 'motivo_aprobacion',
                required: 'true',
                autocapitalize: 'off',
                placeholder: 'Motivo Aprobación'
            },
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let motivo_aprobacion = $('#motivo_aprobacion').val();
                let data = {
                    id_factura: id_factura,
                    motivo: motivo_aprobacion,
                    solicitudes: datosFactura.solicitudes,
                }
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/facturacion/aprobar?id_factura=${id_factura}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'PreFactura', 'La prefactura se aprobó satisfactoriamente');
                            window.location.reload();
                        } else {
                            alertSwal('error', 'PreFactura', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });

    })


    $('#btnFacturar').on('click', function () {

        let params = new URLSearchParams(location.search);
        let id_factura = params.get('id_factura');
        let datosFactura = total_factura();

        Swal.fire({
            type: 'question',
            title: `Facturar Prefactura`,
            text: `¿Está seguro de Facturar esta Prefactura?`,
            confirmButtonText: 'Si',
            showCancelButton: true,
            cancelButtonText: 'No',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {

                let data = {
                    id_factura: id_factura,
                    valor_neto: datosFactura.valor,
                    solicitudes: datosFactura.solicitudes,
                }

                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/facturacion/facturar?id_factura=${id_factura}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Factura', 'La prefactura se facturtó satisfactoriamente');
                            window.location.reload();
                        } else {
                            alertSwal('error', 'PreFactura', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });

    })

    $('#tbl-solicitudesP').on('click', '#btnCambiarValor', function () {
        factura = $(this).attr('idFactura');
        solicitud = $(this).attr('idSolicitud');
        $('#modalUpdFact').modal();

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/facturacion/factura-detalle-info?factura=${factura}&solicitud=${solicitud}`),
            dataType: "json",
            success: function (resp) {
                $('#id_solicitud').val(resp.data.id_solicitud);
                $('#factura').val(resp.data.factura);
                $('#candidato').val(resp.data.candidato);
                $('#nro_doc').val(resp.data.nro_doc);
                $('#valor').val(resp.data.valor);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalUpdFact').modal();

    })


    $('#btn-submit-updfact').on('click', function (e) {
        e.preventDefault(e);
        let id_solicitud = $('#id_solicitud').val();
        let method = 'PUT';
        let data = {
            factura: $('#factura').val(),
            id_solicitud: $('#id_solicitud').val(),
            valor: $('#valor_nuevo').val(),
            observacion: $('#observacion_edit').val(),
        }

        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/facturacion/actualizar-valor?factura=${factura}&id_solicitud=${id_solicitud}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Factura', 'Factura actualizada satisfactoriamente');
                    $('#formUpdFact')[0].reset();
                    window.location.reload();
                } else {
                    alertSwal('error', 'Factura', r.code.code);
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

});


function cargarTablaServiciosPorFacturar() {

    let cliente = $('#filter_cliente').val();

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/lista?cliente=${cliente}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-srvXFacturar').DataTable().clear();
            $('#tbl-srvXFacturar').DataTable().destroy();

            let t = $('#tbl-srvXFacturar').DataTable({
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
                    title: 'REPORTE: Listado de Servicios por Facturar',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((spf) => {

                    t.row.add([
                        spf.id_empresa,
                        spf.descripcion,
                        spf.numero_doc,
                        spf.razon_social,
                        (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-warning btnEstadoProducto" cliente=${spf.id_empresa}>
                            ${spf.cantidad_pendiente}    
                        </button>` : ``,
                        (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-info btnEstadoProducto" cliente=${spf.id_empresa}>
                         ${"$ " + new Intl.NumberFormat('es-ES', { maximumSignificantDigits: 10 }).format(spf.valor)}    
                        </button>` : ``,
                        (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-success btnPrefacturar" empresa="${spf.id_empresa}"><i class="fa fa-usd"  aria-hidden="true"></i> Prefacturar</button> ` : ``
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



function total_solicitud(solicitudId) {
    let items = $(`.item-solicitud-${solicitudId}`);
    let total = 0;
    items.each(function (index, item) {
        total += $(item).prop("checked") ? (parseFloat($(item).attr('solicitudValor')) != 0) ? parseFloat($(item).attr('solicitudValor')) : parseFloat($(item).attr('solicitudValorUnCheck')) : 0;
    });
    return total;
}

function total_factura() {
    let items = $('.item-solicitud');
    let total = 0;
    let solicitudes = [];
    let all = true;
    items.each(function (index, item) {
        if ($(item).prop("checked")) {
            total += (parseFloat($(item).attr('solicitudValor')) != 0) ? parseFloat($(item).attr('solicitudValor')) : parseFloat($(item).attr('solicitudValorUnCheck'));
            solicitudes.push($(item).attr('solicitudId'));
        } else {
            all = false;
        }
    });
    return {
        valor: total,
        cant_servicios: solicitudes.length,
        cant_solicitudes: solicitudes.filter((v, i, a) => a.indexOf(v) === i).length,
        solicitudes: solicitudes,
        all: all
    };
}


function accionFormEditar(input) {

    let params = new URLSearchParams(location.search);
    let factura = params.get('id_factura');

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion?factura=${factura}`),
        dataType: "json",
        success: function (resp) {
            if (resp.data.id != null) {
                $('#id').val(resp.data.id);
                $('#cliente').val(resp.data.razon_social);
                $('#fecha_facturacion').val(resp.data.fecha_facturacion);
                $('#valor_neto').val(resp.data.valor_neto);
                $('#numero_factura_contable').val(resp.data.numero_factura_contable);
            }
        }
    });
    cargarTablaFacturaDetalle(factura);
}


function cargarTablaFacturaDetalle(factura) {

    showModalLoading()
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/factura-detalle?factura=${factura}`),
        success: function (r) {

            $('#tbl-detalle-factura').DataTable().clear();
            $('#tbl-detalle-factura').DataTable().destroy();

            let t = $('#tbl-detalle-factura').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "desc"],
                ],
            });

            if (r.status == "success") {
                r.data.forEach((fac) => {

                    t.row.add([
                        fac.id_solicitud,
                        fac.nom_combo,
                        fac.candidato,
                        fac.nro_doc,
                        fac.observacion,
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