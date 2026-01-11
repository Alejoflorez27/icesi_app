$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    cargarTablaFacturasPorAprobar();    

    $('#tbl-preFacturas').on('click', '.btnVerPrefactura', function () {
        let cliente = $(this).attr('empresa');
        let id_factura = $(this).attr('id_factura');
        window.location = url_site(`prefactura/liquidacion?id_empresa=${cliente}&id_factura=${id_factura}`)
    });

    

});


function cargarTablaFacturasPorAprobar() {


    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/pendiente-cliente`),
        dataType: "json",
        success: function (r) {

            $('#tbl-preFacturas').DataTable().clear();
            $('#tbl-preFacturas').DataTable().destroy();

            let t = $('#tbl-preFacturas').DataTable({
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
                    title: 'REPORTE: Listado de Prefacturas',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((fac) => {

                    t.row.add([
                        fac.id,
                        fac.razon_social,
                        fac.fecha_facturacion,
                        fac.fecha_vencimiento,
                        `<button class="btn btn-xs btn-info btnEstadoProducto" cliente=${fac.id_empresa}>
                         ${"$ " + new Intl.NumberFormat('es-ES', { maximumSignificantDigits: 10 }).format(fac.valor_neto)}    
                        </button>`,
                        fac.estado_desc,
                        fac.dias_transcurridos,
                        ` <button class="btn btn-xs btn-primary btnVerPrefactura" id_factura="${fac.id}" empresa="${fac.id_empresa}"><i class="fa fa-eye"  aria-hidden="true"></i> Visualizar</button>`
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
        total += $(item).prop("checked") ? parseFloat($(item).attr('solicitudValor')) : 0;
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
            total += parseFloat($(item).attr('solicitudValor'));
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
