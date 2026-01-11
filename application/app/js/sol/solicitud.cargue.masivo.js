$(document).ready(function () {
    $('#div-subempresa').hide();
    $('#div-tercero').hide();
    $("body").addClass("sidebar-collapse");
    $('.box-title').html("Cargar Archivo");

    $('#cargue').on('change', function () {
        var cargue = document.getElementById('cargue').files[0];
        $('#info').html(`<h5> <strong>${cargue.name}</strong> <small> (${descripcionTamanoArchivo(cargue.size)})</small> </h5>`);
        $('#lbl-archivo').html(`Cambiar Archivo`);
    });

    loadSelectOption({
        url: url_site(`api/empresa/lista?estado=1`),
        input: [{
            id: 'idCliente',
            clearOptions: true,
            emptyText: 'Seleccione un Cliente',
            selectedValue: ''
        },],
        columnKey: 'id_empresa',
        columnDescription: 'razon_social',
        responsePath: 'data'
    })

    $('#btnCargarArchivoMasivo').click(function () {
        $("#frmCargarArchivoMasivo").submit();
    });

    $("#frmCargarArchivoMasivo").on('submit', function (e) {
        var cliente = $('#idCliente').val();
        var subEmpresa = $('#subEmpresa').val();
        var tercero = $('#id_tercero').val();
        var responsable = $('#responsable').val();
        e.preventDefault();
        //console.log(cliente);

        if (subEmpresa == null || subEmpresa == "") {
            cliente = cliente;
        } else {
            cliente = subEmpresa;
        }

        if (validarCamposCargue()) {
            $('#modalCargarArchivoMasivo').modal("hide");
            showModalLoading();

            $('#tbl-solicitudMasiva').DataTable().clear();
            $('#tbl-solicitudMasiva').DataTable().destroy();

            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                method: 'POST',
                url: url_site(`api/solicitud/cargue?cliente=${cliente}&subempresa=${subEmpresa}&tercero=${tercero}&responsable=${responsable}`),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Cargue', 'Cargue de archivo terminó correctamente.');

                        var tsm = $('#tbl-solicitudMasiva').DataTable();
                        $('#tbl-solicitudMasiva').removeClass('hide');
                        //$('#tbl-solicitudMasiva').languageDataTable();
                        $('#tbl-solicitudError').DataTable().clear();
                        $('#tbl-solicitudError').DataTable().destroy();
                        $('#resultado').addClass('hide');

                        console.log(r.data.solicitudes_correctas);

                        r.data.solicitudes_correctas.forEach(solicitudesM);

                        function solicitudesM(sol, index) {
                            tsm.row.add([
                                sol.id_solicitud,
                                sol.nombre+" "+sol.apellido,
                                sol.numero_doc,
                                sol.cargo_desempeno,
                                sol.email,
                                /*sol.celular,
                                sol.email,
                                sol.direccion,
                                sol.cargo, 
                                sol.usuario_sistema,
                                sol.fecha_sistema,
                                sol.estado_desc, */
                                /*`<button class="btn btn-xs btn-success btnDetalleSolicitudMasiva" solicitud="${sol.data.id}"cliente="${cliente}"><i class="fa fa-eye" aria-hidden="true" title="Ver detalle de solicitud"></i> Ver Detalle</button>
                                `*/
                            ]);
                        }

                        tsm.draw();

                        //$('#tbl-solicitudMasiva').addClass('hide');
                        $('#resultado').removeClass('hide').show();
                        $('#tbl-solicitudError').DataTable().clear();
                        $('#tbl-solicitudError').DataTable().destroy();
                        //$('#tbl-solicitudError').languageDataTable();

                        var ts = $('#tbl-solicitudError').DataTable();
                        

                        //console.log(r.data.errores);
                        r.data.errores?.forEach(solicitudesE);

                        function solicitudesE(sol, idx) {
                            if (sol.status == "error") {
                                ts.row.add([
                                    sol.fila,
                                    sol.error,
                                ]);
                            } else {
                                ts.row.add([
                                    sol.fila,
                                    sol.error,
                                ]);
                            }
                        }
                        ts.draw();
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

    $(".btnAddCargueMasivo").on("click", function () {
        $('#frmCargarArchivoMasivo')[0].reset();
        $('#modalCargarArchivoMasivo').modal();
        $('#info').html("");

    });

    $('#tbl-solicitudMasiva').on('click', '.btnDetalleSolicitudMasiva', function () {
        let solicitud = $(this).attr('solicitud');
        let cliente = $(this).attr('cliente');
        window.location = url_site(`solicitud/detalle?solicitud=${solicitud}&cliente=${cliente}`)
    })



    
    //********************************************************* */
    /* Si seleccion un cliente carga subemp - tercero - servicios
    /******************************** */
    $('#idCliente').on('change', function () {
        $('#responsable').prop( "disabled", false );

        idEmpresa = $('#idCliente').val();

        showModalLoading();
        $.ajax({
            method: 'GET',
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/empresa?id_empresa=${idEmpresa}`),
            dataType: "json",
            success: function (resp) {
                if (resp.data.flag_subemp == 1) {
                    $('#div-subempresa').show();
                    loadSelectOption({
                        url: url_site(`api/empresa/subempresa?subEempresa=${resp.data.id_empresa}`),
                        input: [{
                            id: 'subEmpresa',
                            clearOptions: true,
                            emptyText: 'Seleccione una Sub-Empresa',
                            selectedValue: ''
                        },],
                        columnKey: 'id_empresa',
                        columnDescription: 'razon_social',
                        responsePath: 'data'
                    })
                } else {
                    if (resp.data.flag_grup == 1) {
                        $('#div-tercero').show();
                        loadSelectOption({
                            url: url_site(`api/empresa/tercero?empresa=${resp.data.id_empresa}`),
                            input: [{
                                id: 'id_tercero',
                                clearOptions: true,
                                emptyText: 'Seleccione un tercero',
                                selectedValue: ''
                            },],
                            columnKey: 'id_tercero',
                            columnDescription: 'nom_tercero',
                            responsePath: 'data'
                        })
                    }
                }
            }

        }).done(function () {
            hideModalLoading();
        });


        let perfil = $('#perfil').val();
        let usuario = $('#user').val();

            loadSelectOption({
                url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
                input: [{
                    id: 'responsable',
                    clearOptions: true,
                    emptyText: 'Seleccione un Responsable',
                    selectedValue: ''
                },],
                columnKey: 'username',
                columnDescription: 'responsable',
                responsePath: 'data'
            })


        /*loadSelectOption({
            url: url_site(`api/cliente-servicio/lista?cliente=${idEmpresa}&estado=1`),
            input: [{
                id: 'serviciolista',
                clearOptions: true,
                emptyText: 'Seleccione un servicio',
                selectedValue: ''
            },],
            columnKey: 'servicio',
            columnDescription: 'nom_servicio',
            responsePath: 'data'
        })*/


    }); //fin seleccion empresa



    //******************************** */
    /* Si seleccion un subemp carga responsable
    /******************************** */
    $('#subEmpresa').on('change', function () {

        let subEmpresa = $('#subEmpresa').val();
        if (subEmpresa == "" || subEmpresa == null) {
            idEmpresa = $('#idCliente').val();
        } else {
            idEmpresa = $('#subEmpresa').val();
        }

        loadSelectOption({
            url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
            input: [{
                id: 'responsable',
                clearOptions: true,
                emptyText: 'Seleccione un Responsable',
                selectedValue: ''
            },],
            columnKey: 'username',
            columnDescription: 'responsable',
            responsePath: 'data'
        })
    })

});

function validarCamposCargue() {
    var cliente = $('#idCliente').val();
    if (cliente == "" || cliente == null) {
        alertSwal('warning', 'Cargue', 'Debe seleccionar un cliente.');
        return false;
    }
    return true;
}