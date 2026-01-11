$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    cargarTablaServiciosFinalizados();

});


function cargarTablaServiciosFinalizados() {
    var username = document.getElementById('username').value;
    var perfil = document.getElementById('perfil').value;

    if (perfil == 1 || perfil == 12 || perfil == 13) {
        username = ""
    }

    //console.log('Usuario:', username);
    //console.log('Perfil:', perfil);

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/empresa/all_auto_bash`),
        dataType: "json",
        success: function (r) {
            console.log(r.data.id_auto);
            $('#tbl-srvfin').DataTable().clear();
            $('#tbl-srvfin').DataTable().destroy();

            let t = $('#tbl-srvfin').DataTable({
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
                    title: 'REPORTE: Listado de Servicios Finalizados',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((ser) => {
                    t.row.add([
                        '<div style="text-align:center;">' + ser.id_auto + '</div>',
                        ser.razon_social,
                        ser.nombres + " " + ser.apellidos,
                        ser.fch_cliente_auto,
                        `<button type="button" 
                                class="btn btn-danger btnIrPdf" 
                                data-id_empresa="${ser.id_empresa}" 
                                data-id_auto="${ser.id_auto}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ir a PDF
                        </button>`
                    ]);

                });
            }


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


$(document).on("click", ".btnIrPdf", function () {
    var rutaInforme = 'InformeMain';
    var token = getToken();
    var id_empresa = $(this).data("id_empresa");
    var id_auto = $(this).data("id_auto");

    var url = `../api/empresa/imprimir-pdf-bash?id_empresa=${id_empresa}&id_auto=${id_auto}&rI=${rutaInforme}`;

    fetch(url, {
        method: "GET",
        headers: {
            "access-token": token
        }
    })
    .then(response => response.blob())
    .then(blob => {
        var fileURL = URL.createObjectURL(blob);
        window.open(fileURL, '_blank'); // Abre el PDF en nueva pestaña
    })
    .catch(error => console.error('Error al generar PDF:', error));
});





