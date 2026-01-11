$(document).ready(function () {

    $("body").addClass("sidebar-collapse");


    cargarTablaFacturas();


    $('#filter_tipo_factura').on('change', function () {
        let tipo_factura = $('#filter_tipo_factura').val();

        if (tipo_factura == 'C') {
            loadSelectOption({
                url: url_site(`api/empresa/todas`),
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
        }else{
            loadSelectOption({
                url: url_site(`api/usuario/proveedores-lista`),
                input: [{
                    id: 'filter_cliente',
                    clearOptions: true,
                    emptyText: 'Seleccione un Proveedor',
                    selectedValue: ''
                },],
                columnKey: 'username',
                columnDescription: 'nombre_completo',
                responsePath: 'data'
            })
        }
    })

    $('#btnBuscar').on('click', function () {
        cargarTablaFacturas();
    });

    $('#tbl-facturas').on('click', '.btnFacturar', function () {
        let cliente = $(this).attr('empresa');
        let factura = $(this).attr('factura');
        window.location = url_site(`prefactura/liquidacion?id_empresa=${cliente}&id_factura=${factura}`)
    });


    $('#tbl-facturas').on('click', '.btnVerDetalle', function () {
        accionFormEditar($(this));
        $('#modalVerfactura').modal();
    });

    // Editar Factura
    $('#tbl-facturas').on('click', '.btnEditFactura', function () {

        $('#accion').val("PUT");
        let factura = $(this).attr('factura');
        $('#factura').val(factura);

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/facturacion/factura-info?id=${factura}`),
            dataType: "json",
            success: function (resp) {
                $('#clienteFC').val(resp.data.razon_social);
                $('#numero_factura_contable').val(resp.data.numero_factura_contable);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalfactura').modal();
    })

    $('#btn-submit-factura').on('click', function (e) {
        e.preventDefault(e);

        let id_fac = $('#factura').val();
        let num_fac = $('#numero_factura_contableFC').val();
        let data = {
            id: id_fac,
            numero_factura_contable: num_fac,
        }

        $.ajax({
            method: 'PUT',
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/facturacion/actualiza-factura?id=${id_fac}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Producto', 'Producto guardado satisfactoriamente');
                    cargarTablaFacturas();
                    $('#formFactura')[0].reset();
                    $('#modalfactura').modal('hide')
                } else {
                    alertSwal('error', 'Producto', r.code.code);
                    cargarTablaFacturas();
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


function cargarTablaFacturas() {

    let cliente_proveedor = $('#filter_cliente').val();

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/facturas?cliente=${cliente_proveedor}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-facturas').DataTable().clear();
            $('#tbl-facturas').DataTable().destroy();

            let t = $('#tbl-facturas').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "desc"],
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Facturas',
                }],
            });

            let empresa = 0;
            if (r.status == "success") {
                r.data.forEach((fac) => {
                    empresa = fac.empresa_usr_connect;
                    t.row.add([
                        fac.id,
                        fac.razon_social,
                        fac.fecha_facturacion,
                        fac.fecha_vencimiento,
                        '$ ' + number_format(fac.valor_neto),
                        fac.motivo_aprobacion,
                        fac.numero_factura_contable,
                        fac.desc_destino_factura,
                        fac.desc_estado,
                        `<button class="btn btn-xs btn-primary btnVerDetalle" factura="${fac.id}" destinoFact="${fac.destino_factura}"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button> `,
                        (fac.empresa_usr_connect == -1) ?
                            (fac.estado == 1) ? `<button class="btn btn-xs btn-warning btnFacturar" empresa="${fac.id_empresa}" factura="${fac.id}"><i class="fa fa-usd" aria-hidden="true"></i> Facturar</button> ` :
                                (fac.estado == 3) ? `<button class="btn btn-xs btn-success btnEditFactura" factura="${fac.id}"><i class="fa fa-pencil" aria-hidden="true"></i> Nro Factura</button> ` : `` : ``
                    ]);
                });

            };

            if (empresa != -1)
                ocultarColumnaDataTable(t, 9);
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

    var factura = input.attr("factura");
    var destino = input.attr("destinoFact");

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
    cargarTablaFacturaDetalle(factura, destino);
}

function cargarTablaFacturaDetalle(factura, destino) {

    showModalLoading()
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/factura-detalle?factura=${factura}&destino=${destino}`),
        success: function (r) {
            if (destino == 'C') {

                $('#tbl-detalle-facturaC').DataTable().clear();
                $('#tbl-detalle-facturaC').DataTable().destroy();

                let t = $('#tbl-detalle-facturaC').DataTable({
                    paging: true,
                    ordering: true,
                    info: false,
                    searching: true,
                    order: [
                        [0, "desc"],
                    ],
                });


                $('.div-cliente').removeClass('hide');
                $('.div-proveedor').addClass('hide');

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
                    t.draw();
                };
            } else {

                $('#tbl-detalle-facturaP').DataTable().clear();
                $('#tbl-detalle-facturaP').DataTable().destroy();

                let t = $('#tbl-detalle-facturaP').DataTable({
                    paging: true,
                    ordering: true,
                    info: false,
                    searching: true,
                    order: [
                        [0, "desc"],
                    ],
                });

                $('.div-cliente').addClass('hide');
                $('.div-proveedor').removeClass('hide');
                if (r.status == "success") {
                    r.data.forEach((fac) => {

                        t.row.add([
                            fac.id_solicitud,
                            fac.nom_servicio,
                            fac.valor,
                            fac.observacion,
                        ]);
                    });
                };
                t.draw();
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
}