$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    cargarTablaExportacion();    
});


function cargarTablaExportacion() {


    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/facturacion/export`),
        dataType: "json",
        success: function (r) {

            $('#tbl-export').DataTable().clear();
            $('#tbl-export').DataTable().destroy();

            let t = $('#tbl-export').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                order: [
                    [0, "desc"],
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Servicios Facturados',
                }],
                pageLength: 20,
            });

            if (r.status == "success") {
                r.data.forEach((exp) => {

                    t.row.add([
                        exp.empresa,
                        exp.id_empresa,
                        exp.numero_doc,
                        exp.candidato,
                        exp.cargo_desempeno,
                        exp.item,
                        exp.nom_combo,
                        exp.ciudad,
                        exp.valor,
                        exp.valor_adicional,
                        
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