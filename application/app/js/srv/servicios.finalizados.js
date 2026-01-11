$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    
    var username = document.getElementById('username');
    //var username = document.getElementById('username').value;
    var perfil = document.getElementById('perfil');

    cargarTablaServiciosFinalizados(username.value, perfil.value);

});


function cargarTablaServiciosFinalizados(username, perfil) {
    /*var username = document.getElementById('username');
    //var username = document.getElementById('username').value;
    var perfil = document.getElementById('perfil').value;*/
    console.log('Usuario:', username);

    if (perfil == 1 || perfil == 12 || perfil == 13) {
        username = ""
    }

    console.log('Usuario:', username);
    console.log('Perfil:', perfil);

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/servicio/servicios-finalizados?username=${username}`),
        dataType: "json",
        success: function (r) {

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
                        ser.id,
                        '<div style="text-align:center;">' + ser.id_solicitud +" - "+ ser.combo_nombre +'</div>',
                        ser.razon_social,
                        ser.candidato,
                        ser.numero_doc,
                        ser.nom_servicio,
                        ser.nombre_responsable_sol,
                        ser.nombre_responsable,
                        ser.nombre_responsable_calidad,
                        ser.observacion_finalizacion,
                        ser.fecha_asignado,
                        ser.fecha_termina_proveedor,
                        ser.diferencia,
                        ser.estado_descripcion,
                        '<button class="btn-redirigir btn-warning" data-id="' + ser.id_solicitud + '" data-cliente="' + ser.id_empresa + '" style="padding: 5px 10px; color: white; border: none; border-radius: 5px; cursor: pointer;">Ver Detalle</button><br><br><button type="button" class="btn btn-primary btnIrPdfSolCombo" idservicio="' + ser.id + '" solicitud="' + ser.id_solicitud + '" combo="' + ser.id_combo + '" rutaInforme="InformeMain">Ir a PDF</button>'
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

// IR A PDF solicitud combo
$(document).on("click", ".btnIrPdfSolCombo", function () {
    var idServicio = $(this).attr("idservicio");
    var solicitudId = $(this).attr('solicitud');
    var comboId = $(this).attr('combo');
    var rutaInforme = $(this).attr('rutaInforme');

    console.log('ID de solicitud:', solicitudId);
    console.log('ID de combo:', comboId);
    console.log('Ruta del informe:', rutaInforme);

    window.open('../api/solicitud/imprimir-pdf' + `?id_sl=${solicitudId}&id_sv=${idServicio}&id_combo=${comboId}&rI=${rutaInforme}`, '_blank');
});

// Delegar evento de clic a los botones generados dinámicamente
$(document).on("click", ".btn-redirigir", function() {
    let id = $(this).data("id");
    let cliente = $(this).data("cliente");
    window.location = url_site(`solicitud/detalle?solicitud=${id}&cliente=${cliente}`)
});



