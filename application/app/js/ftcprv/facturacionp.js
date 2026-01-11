$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    loadSelectOption({
        url: url_site(`api/usuario/proveedores-lista/`),
        input: [{
            id: 'filter_proveedor',
            clearOptions: true,
            emptyText: 'Seleccione un Proveedor',
            selectedValue: ''
        },],
        columnKey: 'username',
        columnDescription: 'nombre_completo',
        responsePath: 'data'
    })
    cargarTablaServiciosPorFacturar();
    $('#btnBuscar').on('click', function () {
        cargarTablaServiciosPorFacturar();
    });

    

    $('#tbl-srvXFacturarP').on('click', '.btnPrefacturar', function () {
        let proveedor = $(this).attr('proveedor');
        let factura = $(this).attr('factura');
        if (factura != 0) {
            window.location = url_site(`prefacturap/liquidacion?proveedor=${proveedor}&factura=${factura}`)
        }else {
            window.location = url_site(`prefacturap/liquidacion?proveedor=${proveedor}`)
        }
    });

    $('#check-all').change(function () {
        let all = $(this).prop('checked');
        $('.item-solicitud').prop('checked', all).change();
    });

    $('.item-servicio').change(function () {
        servicioId = $(this).attr('id');

        totalServicio = total_solicitud(servicioId);
        $(`#total-servicio-${servicioId}`).text("$ " + number_format(totalServicio));

        totalFactura = total_factura();
        $('#total-factura').text("$ " + number_format(totalFactura.valor));
        $('#resumen-total-valor').text("$ " + number_format(totalFactura.valor));
        $('#resumen-total-servicios').text(totalFactura.cant_servicios);
        $('#check-all').prop('checked', totalFactura.all);
    });


    $('#tbl-solicitudesP').on('click', '#btnCambiarValor', function () {
        factura = $(this).attr('idFactura');
        solicitud = $(this).attr('idSolicitud');
        servicio = $(this).attr('idServicio');

        $('#modalUpdFactP').modal();

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
                $('#id_servicio').val(resp.data.id_servicio);
                $('#servicio').val(resp.data.servicio);
                $('#factura').val(resp.data.factura);
                $('#valor').val(resp.data.valor);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalUpdFactP').modal();

    })



    $('#btnPreFacturarP').on('click', function () {
        let params = new URLSearchParams(location.search);
        let proveedor = params.get('proveedor');
        let method = 'POST';
        let datosFactura = total_factura();
        let data = {
            proveedor: proveedor,
            valor_neto: datosFactura.valor,
            ids: datosFactura.id,
        }

        showModalLoading();
        $.ajax({
            method: method,
            headers: { "access-token": getToken() },
            url: url_site(`api/facturacion/proveedor`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwalR('success', `Prefactura #${r.data?.id ?? ''}`, 'Prefactura guardada satisfactoriamente', url_site(`prefacturap/liquidacion?proveedor=${proveedor}&factura=${r.data?.id}`));
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


    $('#btnFacturarP').on('click', function () {

        let params = new URLSearchParams(location.search);
        let id_factura = params.get('factura');
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
                    servicios: datosFactura.id,
                }
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/facturacion/facturar-proveedor?factura=${id_factura}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwalR('success', `Factura #${id_factura ?? ''}`, 'Factura guardada satisfactoriamente', url_site(`prefacturap/`));
                        } else {
                            alertSwal('error', 'Factura', r.code.code);
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



    $('#btn-submit-updfactP').on('click', function (e) {
        e.preventDefault(e);
        let factura = $('#factura').val();
        let id_solicitud = $('#id_solicitud').val();
        let id_servicio = $('#id_servicio').val();
        let method = 'PUT';
        let data = {
            factura: factura,
            id_solicitud: id_solicitud,
            valor: $('#valor_nuevo').val(),
            observacion: $('#observacion_edit').val(),
            id_servicio: id_servicio,
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
                    $('#formUpdFactP')[0].reset();
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

    var proveedor = $('#filter_proveedor').val();
    //console.log('hola: '+proveedor);

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/por-facturar-proveedor?proveedor=${proveedor}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-srvXFacturarP').DataTable().clear();
            $('#tbl-srvXFacturarP').DataTable().destroy();

            let t = $('#tbl-srvXFacturarP').DataTable({
                paging: true,
                ordering: false,
                info: false,
                searching: true,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Servicios por Facturar a Proveedores',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((spf) => {
                    console.log(spf.id_usuario_asig);
                    if (proveedor == spf.id_usuario_asig) {
                        t.row.add([
                            spf.tipo_identificacion,
                            spf.numero_identificacion,
                            spf.proveedor,
                            (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-danger " proveedor=${spf.id_usuario_asig}>
                                ${spf.cantidad_pendiente}    
                            </button>` : ``,
                            (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-info">
                             ${"$ " + new Intl.NumberFormat('es-ES', { maximumSignificantDigits: 10 }).format(spf.valor)}    
                            </button>` : ``,
                            spf.desc_estado,
                            (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-success btnPrefacturar" proveedor="${spf.id_usuario_asig}" factura="${spf.factura}" ><i class="fa fa-usd"  aria-hidden="true"></i> Prefacturar</button> ` : ``
                        ]);
                    } else if(proveedor == '') {
                        t.row.add([
                            spf.tipo_identificacion,
                            spf.numero_identificacion,
                            spf.proveedor,
                            (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-danger " proveedor=${spf.id_usuario_asig}>
                                ${spf.cantidad_pendiente}    
                            </button>` : ``,
                            (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-info">
                             ${"$ " + new Intl.NumberFormat('es-ES', { maximumSignificantDigits: 10 }).format(spf.valor)}    
                            </button>` : ``,
                            spf.desc_estado,
                            (spf.cantidad_pendiente != 0) ? `<button class="btn btn-xs btn-success btnPrefacturar" proveedor="${spf.id_usuario_asig}" factura="${spf.factura}" ><i class="fa fa-usd"  aria-hidden="true"></i> Prefacturar</button> ` : ``
                        ]);
                    }

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



function total_solicitud(servicioId) {
    let items = $(`.item-servicio-${servicioId}`);
    let total = 0;
    items.each(function (index, item) {
        total += $(item).prop("checked") ? (parseFloat($(item).attr('servicioValor')) != 0) ? parseFloat($(item).attr('servicioValor')) : parseFloat($(item).attr('servicioValorUnCheck')) : 0;
    });
    return total;
}

function total_factura() {
    let items = $('.item-servicio');
    let total = 0;
    let id = [];
    let all = true;
    items.each(function (index, item) {
        if ($(item).prop("checked")) {
            total += (parseFloat($(item).attr('servicioValor')) != 0) ? parseFloat($(item).attr('servicioValor')) : parseFloat($(item).attr('servicioValorUnCheck'));
            id.push($(item).attr('id'));
        } else {
            all = false;
        }
    });
    return {
        valor: total,
        cant_servicios: id.length,
        cant_servicios: id.filter((v, i, a) => a.indexOf(v) === i).length,
        id: id,
        all: all
    };
}
