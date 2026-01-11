$(document).ready(function () {

    cboLoad('tipo_id', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');
    cboLoad('sube_tipo_id', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');

    cboLoad('perfil', url_site(`api/perfil/lista`), '', true, 'Seleccione un perfil');
    cboLoad('tipo_identificacion', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');

    //carga el nombre del archivo seleccionado en empresa
    $('#archivo').on('change', function (e) {
        var archivo = document.getElementById('archivo').files[0];
        $('#info').html(`<strong>${archivo.name}</strong> <small> (${descripcionTamanoArchivo(archivo.size)})</small>`);
        $('#lbl-archivo').html(`Cambiar Archivo`);
    });

    //carga el nombre del archivo seleccionado en sub-empresa
    $('#archivoSub').on('change', function (e) {
        var archivo = document.getElementById('archivoSub').files[0];
        $('#infoSub').html(`<strong>${archivo.name}</strong> <small> (${descripcionTamanoArchivo(archivo.size)})</small>`);
        $('#lbl-archivoSub').html(`Cambiar Archivo`);
    });


    // como modal add empresas
    loadSelectOption({
        url: url_site(`api/ubicacion/dto`),
        input: [{
            id: 'id_dpto',
            clearOptions: true,
            emptyText: 'Seleccione un Departamento',
            selectedValue: 'id_dpto'
        },],
        columnKey: 'id_dpto',
        columnDescription: 'nombre',
        responsePath: 'data'
    });

    $('#id_dpto').on('change', function () {
        let id_dpto = $('#id_dpto').val();

        if (!id_dpto) {
            $('#id_ciudad').empty();
        } else {
            loadSelectOption({
                url: url_site(`api/ubicacion/ciudad?idDpto=${id_dpto}`),
                input: [{
                    id: 'id_ciudad',
                    clearOptions: true,
                    emptyText: 'Seleccione una Ciudad',
                    selectedValue: ''
                },],
                columnKey: 'id_ciudad',
                columnDescription: 'nombre',
                responsePath: 'data'
            })

        } //fin lista departamento

    });


    //Combo Modal Subempresas
    loadSelectOption({
        url: url_site(`api/ubicacion/dto`),
        input: [{
            id: 'sube_id_dpto',
            clearOptions: true,
            emptyText: 'Seleccione un Departamento',
            selectedValue: 'id_dpto'
        },],
        columnKey: 'id_dpto',
        columnDescription: 'nombre',
        responsePath: 'data'
    });

    $('#sube_id_dpto').on('change', function () {
        let sube_id_dpto = $('#sube_id_dpto').val();

        if (!sube_id_dpto) {
            //$('#id_ciudad').val("0")
            $('#sube_id_ciudad').empty();
        } else {
            loadSelectOption({
                url: url_site(`api/ubicacion/ciudad?idDpto=${sube_id_dpto}`),
                input: [{
                    id: 'sube_id_ciudad',
                    clearOptions: true,
                    emptyText: 'Seleccione una Ciudad',
                    selectedValue: ''
                },],
                columnKey: 'id_ciudad',
                columnDescription: 'nombre',
                responsePath: 'data'
            })
        }

    });

    $("body").addClass("sidebar-collapse");

    //carga Listado Empresas
    cargarTablaEmpresas();

    //boton agregar empresa
    $('.btnAddEmpresa').on('click', function () {
        $('#formEmpresa')[0].reset();
        $('#accion').val("POST");
        $('#titulo-modal-empresa').html('Datos Empresa');

        //esconder el boton editar empresa
        $('#btn-edit-empresa').hide();
        $('#btn-submit-empresa').show();

        $('#info-edit').html("");
        $('#infoEdit').hide();
    });


    var checkboxEmp = document.getElementById('flag_subemp');
    checkboxEmp.addEventListener("change", validaCheckGroup, false);

    var checkboxGrp = document.getElementById('flag_grup');
    checkboxGrp.addEventListener("change", validaCheckEmp, false);

    function validaCheckGroup() {
        var checked = checkboxEmp.checked;
        if (checked) {
            document.getElementById('flag_grup').disabled = true;
            document.getElementById('flag_subemp').value = 1;
            document.getElementById('flag_grup').value = 0;
        } else {
            document.getElementById('flag_grup').disabled = false;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 0;
        }
    }

    function validaCheckEmp() {
        var checked = checkboxGrp.checked;
        if (checked) {
            document.getElementById('flag_subemp').disabled = true;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 1;
        } else {
            document.getElementById('flag_subemp').disabled = false;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 0;
        }
    }

    // Adicionar Terceros
    $('#tbl-empresas').on('click', '.btnAddTerceros', function () {
        const empresa = $(this).attr('empresa');
        $('#titulo-modal-terceros').html('Adicionar Tercero');
        $('#formTerceros')[0].reset();
        $('#modalAddTerceros').modal();
        $('#id_empresaTercero').val(empresa);

    })

    // Adicionar Subempresa
    $('#tbl-empresas').on('click', '.btnAddSubemp', function () {
        const empresa = $(this).attr('empresa');
        $('#titulo-modal-subemp').html('Adicionar Subempresa');
        $('#formSubemp')[0].reset();
        $('#modalAddSubemp').modal();
        $('#id_empresaSubemp').val(empresa);
        $('#accion').val('POST');
        $('#info').html("");
        $('#info-editSub').html("");
        $('#infoEditSub').hide();
    })


    // Visualizar Terceros
    $('#tbl-empresas').on('click', '.btnViewTerceros', function () {
        const empresa = $(this).attr('empresa');
        $('#titulo-modal-vwterceros').html('Visualizar Terceros');
        $('#formVwTerceros')[0].reset();

        $('#modalVwTerceros').modal();
        $('#id_empresa_vw_tercero').val(empresa);
        cargarTablaTerceros();
    })

    // Visualizar Subempresas
    $('#tbl-empresas').on('click', '.btnViewSubemp', function () {
        const empresa = $(this).attr('empresa');
        $('#titulo-modal-vwsubemp').html('Visualizar Subempresas');
        $('#formVwSubemp')[0].reset();

        $('#modalVwSubemp').modal();
        $('#id_empresa_vw_subemp').val(empresa);
        cargarTablaSubemp();
    })

    //esconder el boton editar empresa
    $('#btn-edit-empresa').hide();
    $('#infoEdit').hide();



    // Crear Empresa
    $('#btn-submit-empresa').on('click', function (e) {
        e.preventDefault();

        if (validateFormEmpresa()) {

            var form = document.getElementById('formEmpresa');
            var formData = new FormData(form);

            let method = $('#accion').val();
            let id_empresa = $('#id_empresa').val()

            showModalLoading();
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa?id_empresa=${id_empresa}`),
                //contentType: 'application/json',
                processData: false,
                cache: false,
                contentType: false,
                data: formData,
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                        cargarTablaEmpresas();
                        $('#formEmpresa')[0].reset();
                        $('#info').html("");
                        $('#lbl-archivo').html(`Seleccionar Archivo`);
                        document.getElementById('archivo').value = "";
                        $('#modalAddEmpresa').modal('hide')
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaEmpresas();
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


    // Trae los datos para Editar empresa
    $('#tbl-empresas').on('click', '.btnEditEmpresa', function () {
        $('#titulo-modal-empresa').html('Editar Empresa');

        $('#btn-edit-empresa').show();
        $('#btn-submit-empresa').hide();
        $('#info').html("");
        $('#infoEdit').show();

        $('#accion').val("POST");
        let id_empresa = $(this).attr('empresa');

        //showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/empresa?id_empresa=${id_empresa}`),
            dataType: "json",
            success: function (resp) {
                $('#id_empresa').val(resp.data.id_empresa);
                $('#razon_social').val(resp.data.razon_social);
                $('#rep_legal').val(resp.data.rep_legal);
                $('#tipo_id').val(resp.data.tipo_id);
                $('#numero_doc').val(resp.data.numero_doc);
                $('#id_dpto').val(resp.data.id_dpto);
                $('#email_emp').val(resp.data.email_emp);
                $('#celular').val(resp.data.celular);
                $('#direccion').val(resp.data.direccion);
                $('#flag_subemp').val(resp.data.flag_subemp);
                $('#flag_grup').val(resp.data.flag_grup);
                $('#info-edit').html(resp.data.nombre_logo);
                $('#nomLogo').html(resp.data.nombre_logo);

                resp.data.flag_grup == 1 ? $('#flag_grup').attr('checked', true) : $('#flag_grup').attr('checked', false);
                resp.data.flag_subemp == 1 ? $('#flag_subemp').attr('checked', true) : $('#flag_subemp').attr('checked', false);
                validaChecks();
                let departamento_id = resp.data.id_dpto;
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/ubicacion/ciudad?idDpto=${departamento_id}`),
                    dataType: "json",

                    success: function (resp_dpt) {
                        $('#id_ciudad').val(resp.data.id_ciudad);
                    }
                })

            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddEmpresa').modal();
    });


    // Guardar la edicion de la Empresa
    $('#btn-edit-empresa').on('click', function (e) {
        e.preventDefault();

        if (validateFormEmpresa()) {

            var form = document.getElementById('formEmpresa');
            var formData = new FormData(form);

            let method = $('#accion').val();
            let id_empresa = $('#id_empresa').val()

            showModalLoading();
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa/editar?id_empresa=${id_empresa}`),
                //contentType: 'application/json',
                processData: false,
                cache: false,
                contentType: false,
                data: formData,
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                        cargarTablaEmpresas();
                        $('#formEmpresa')[0].reset();
                        $('#info').html("");
                        $('#lbl-archivo').html(`Seleccionar Archivo`);
                        document.getElementById('archivo').value = "";
                        $('#modalAddEmpresa').modal('hide')
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaEmpresas();
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




    // Visualizar Usuarios
    $('#tbl-empresas').on('click', '.btnViewUsuarios', function () {
        const empresa = $(this).attr('empresa');
        $('#titulo-modal-vwusuarios').html('Visualizar Usuarios');
        //  $('#formVwUsuarios')[0].reset();

        $('#modalVwUsuarios').modal();
        $('#id_empresa_vw_usuarios').val(empresa);
        cargarTablaUsuarios();
    })



    // Crear SubEmpresa
    $('#btn-submit-subempresas').on('click', function (e) {
        e.preventDefault();

        $('#info').html("");
        $('#info-edit').html("");
        $('#infoEdit').hide();

        $('#accionSub').val('POST');

        var form = document.getElementById('formSubemp');
        var formData = new FormData(form);

        let method = $('#accionSub').val();

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/empresa/sub-empresa`),
            //contentType: 'application/json',
            processData: false,
            cache: false,
            contentType: false,
            data: formData,
            dataType: "json",
            method: 'POST',
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                    cargarTablaEmpresas();
                    $('#formSubemp')[0].reset();
                    $('#modalAddSubemp').modal('hide');
                    $('#infoSub').html("");
                    $('#lbl-archivo').html(`Seleccionar Archivo`);
                    document.getElementById('archivo').value = "";
                } else {
                    alertSwal('error', 'Empresa', r.code.code);
                    cargarTablaEmpresas();
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
        // }; 
    });


    // Crear Terceros
    $('#btn-submit-terceros').on('click', function (e) {
        e.preventDefault(e);

        $('#accion').val("POST");
        let method = $('#accion').val();

        let data = {
            id_empresa: $('#id_empresaTercero').val(),
            nom_tercero: $('#nom_tercero').val(),
        }
        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/terceros?id_tercero=${data.id_tercero}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Tercero', 'Tercero guardado satisfactoriamente');
                    cargarTablaEmpresas();
                    //  $('#formEmpresa')[0].reset();
                    $('#modalAddTerceros').modal('hide')
                } else {
                    alertSwal('error', 'Terceros', r.code.code);
                    cargarTablaEmpresas();
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

    //funcionalidad para guardar usuarios
    $('#btn-submit-usuario').on('click', function (e) {
        e.preventDefault(e);

        let method = $('#accion').val();
        let data = {
            username: $('#username').val(),
            id_empresa: $('#usr_empresas').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            nombres: $('#nombres').val(),
            apellidos: $('#apellidos').val(),
            tipo_identificacion: $('#tipo_identificacion').val(),
            numero_identificacion: $('#numero_identificacion').val(),
            perfil: $('#perfil').val()

        }
        let empresasub = $('#usr_empresas').val();
        $('#id_empresa_usuario').val(empresasub);
        if (validarCamposUsuario()) {

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa/usrxemp?id_empresa=${data.id_empresa}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {

                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'Usuario guardado satisfactoriamente');
                        cargarTablaEmpresas();
                        $('#formUsuario')[0].reset();
                        $('#modalAgregarUsuario').modal('hide')
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaEmpresas();
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

        e.preventDefault(e);
    });
});

// Activa e Inactiva un empresa
$('#tbl-empresas').on('click', '.btnEstadoEmpresa', function () {
    $('#accion').val("PUT");
    var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
    var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
    var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
    var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
    let id_empresa = $(this).attr('empresa');
    //alert(id_empresa);


    Swal.fire({
        type: 'question',
        title: `${nuevoEstadoDesc} empresa`,
        text: `¿Está seguro de ${nuevoEstadoDesc}  esta empresa?`,
        confirmButtonText: 'OK',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        focusCancel: true
    }).then(function (result) {
        if (result.value) {
            let method = $('#accion').val();
            let data = {
                id_empresa: id_empresa,
                estado: estadoNuevo,
            }
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa/cambio-estado?id_empresa=${id_empresa}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'La empresa se ' + nuevoEstadoMsj + ' satisfactoriamente');
                        cargarTablaEmpresas();
                        //                    $('#formEmpresa')[0].reset();
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaEmpresas();
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


// // Activa e Inactiva un usuario
$('#tbl-usuarios').on('click', '.btnEstadoUsuario', function () {
    $('#accion').val("PUT");
    var nuevoEstado = ($(this).attr("estado_usr") == 'ACT') ? 'INA' : 'ACT';
    var estadoNuevo = ($(this).attr("estado_usr") == 'ACT') ? 'ACT' : 'INA';
    var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
    let username = $(this).attr('username');
    let method = $('#accion').val();
    let data = {
        username: username,
        estado_usr: estadoNuevo,
    }
    $.ajax({
        method: method,
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/empresa/cambio-estado-usuario?username=${username}`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (r_ter) {
            if (r_ter.status == "success") {
                alertSwal('success', 'Empresa', 'El Usuario se ' + nuevoEstadoMsj + ' satisfactoriamente');
                cargarTablaUsuarios();
            } else {
                alertSwal('error', 'Empresa', r.code.code);
                cargarTablaUsuarios();
            }
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
        }
    });
});


// Activa e Inactiva un subempresa
$('#tbl-subemp').on('click', '.btnEstadoSubempresa', function () {
    $('#accion').val("PUT");
    var nuevoEstado = ($(this).attr("estado_sube") == 1) ? 0 : 1;
    var estadoNuevo = ($(this).attr("estado_sube") == 1) ? 1 : 0;
    var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
    var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
    let id_subempresa = $(this).attr('id_empresa_vw_subemp');
    let method = $('#accion').val();
    let data = {
        id_empresa: id_subempresa,
        estado: estadoNuevo,
    }
    $.ajax({
        method: method,
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/empresa/cambio-estado?id_empresa=${id_subempresa}`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (r_sub) {
            if (r_sub.status == "success") {
                null;
            } else {
            }
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
        }
    });
    // }
    // });
});


//carga el listado de empresas
function cargarTablaEmpresas() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/empresa/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-empresas').DataTable().clear();
            $('#tbl-empresas').DataTable().destroy();

            let t = $('#tbl-empresas').DataTable({
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
                    title: 'REPORTE: Listado de Empresas',
                }],
            });
            if (r.status == "success") {
                r.data.forEach((emp) => {
                    t.row.add([
                        (emp.estado == '1') ? `<button class="btn btn-xs btn-warning btnEditEmpresa"    empresa="${emp.id_empresa}"><i class="fa fa-pencil"  aria-hidden="true"></i> ${emp.id_empresa}</button> ` : `${emp.id_empresa}`,
                        emp.razon_social,
                        emp.numero_doc,
                        emp.nom_ciudad,
                        emp.rep_legal,
                        emp.email_emp,
                        `<button class="btn btn-xs btn-${(emp.estado == '1') ? 'success' : 'danger'} btnEstadoEmpresa"
                            empresa=${emp.id_empresa} estado=${emp.estado}>
                            ${(emp.estado == '1') ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        (emp.estado == '1' && emp.flag_grup == '1') ? `<button class="btn btn-xs btn-primary btnAddTerceros"    empresa="${emp.id_empresa}"><i class="fa fa-plus"  aria-hidden="true"></i></button> 
                        <button class="btn btn-xs btn-success btnViewTerceros"    empresa="${emp.id_empresa}"><i class="fa fa-list"  aria-hidden="true"></i></button>` : (emp.flag_grup == '1') ? `<button class="btn btn-xs btn-success btnViewTerceros"    empresa="${emp.id_empresa}"><i class="fa fa-list"  aria-hidden="true"></i></button>` : ``,
                        (emp.estado == '1' && emp.flag_subemp == '1') ? `<button class="btn btn-xs btn-primary btnAddSubemp" empresa="${emp.id_empresa}"><i class="fa fa-plus"  aria-hidden="true"></i></button>
                        <button class="btn btn-xs btn-success btnViewSubemp" empresa="${emp.id_empresa}"><i class="fa fa-list"  aria-hidden="true"></i></button>` : (emp.flag_subemp == '1') ? ` <button class="btn btn-xs btn-success btnViewSubemp empresa="${emp.id_empresa}"><i class="fa fa-list"  aria-hidden="true"></i></button>` : ``,
                        (emp.estado == '1') ? `<button class="btn btn-xs btn-primary btnAddUsuarios"    empresa="${emp.id_empresa}"><i class="fa fa-user-plus"  aria-hidden="true"></i> </button>  <button class="btn btn-xs btn-success btnViewUsuarios" empresa="${emp.id_empresa}"><i class="fa fa-list"  aria-hidden="true"></i></button>` : ``
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

function cargarTablaTerceros() {

}

function cargarTablaUsuarios() {

    showModalLoading();
    let id_empresa = $('#id_empresa_vw_usuarios').val()

    showModalLoading();
    $.ajax({
        headers: { 'access-token': getToken() },
        type: "GET",
        url: url_site(`api/usuario/empresas?id_empresa=${id_empresa}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-usuarios').DataTable().clear();
            $('#tbl-usuarios').DataTable().destroy();

            var t = $('#tbl-usuarios').DataTable({
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
                    title: 'REPORTE: Listado de Usuarios',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((user, index) => {
                    t.row.add([
                        user.username,
                        user.perfil_desc,
                        `${user.nombres ?? ''} ${user.apellidos ?? ''}`,
                        user.tipo_identificacion,
                        user.numero_identificacion,
                        user.correo,
                        user.empresa,
                        `<button class="btn btn-xs btn-${(user.estado == 'ACT') ? 'success' : 'danger'} btnEstadoUsuario"
                        username=${user.username} estado_usr=${user.estado}>
                        ${(user.estado == 'ACT') ? 'Activo' : 'Inactivo'}    
                         </button>`,
                    ]);
                });
            };

            ocultarColumnaDataTable(t, 3);
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


function cargarTablaSubemp() {

    showModalLoading();
    let id_empresa = $('#id_empresa_vw_subemp').val()

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/terceros/listasub?id_empresa=${id_empresa}`),
        dataType: "json",
        success: function (r) {
            $('#tbl-subemp').DataTable().clear();
            $('#tbl-subemp').DataTable().destroy();

            let t = $('#tbl-subemp').DataTable({
                paging: true,
                ordering: true,
                info: false,
                order: [
                    [0, "asc"],
                ],

            });

            if (r.status == "success") {
                r.data.forEach((sube) => {

                    t.row.add([
                        sube.razon_social,
                        sube.numero_doc,
                        sube.rep_legal,
                        sube.email_emp,
                        sube.nombre,
                        `<button class="btn btn-xs btn-${(sube.estado_sube == '1') ? 'success' : 'danger'} btnEstadoSubempresa"
                        id_empresa_vw_subemp=${sube.id_empresa} estado_sube=${sube.estado_sube}>
                        ${(sube.estado_sube == '1') ? 'Activo' : 'Inactivo'}    
                         </button>`
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


function validateFormEmpresa() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#razon_social').val() == "" || $('#razon_social').val() == null) {
        alertSwal('error', 'Nombre Empresa', 'Este campo es obligatorio');
        $("#razon_social").focus();
        return false;
    }

    return true;

}


function validaChecks() {

    var checkboxEmp = document.getElementById('flag_subemp');
    checkboxEmp.addEventListener("change", validaCheckGroup, false);

    var checkboxGrp = document.getElementById('flag_grup');
    checkboxGrp.addEventListener("change", validaCheckEmp, false);

    function validaCheckGroup() {
        var checked = checkboxEmp.checked;
        if (checked) {
            document.getElementById('flag_grup').disabled = true;
            document.getElementById('flag_subemp').value = 1;
            document.getElementById('flag_grup').value = 0;
        } else {
            document.getElementById('flag_grup').disabled = false;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 0;
        }
    }

    function validaCheckEmp() {
        var checked = checkboxGrp.checked;
        if (checked) {
            document.getElementById('flag_subemp').disabled = true;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 1;
        } else {
            document.getElementById('flag_subemp').disabled = false;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 0;
        }
    }

}

function validarCamposUsuario() {

    var accion = $('#accion').val();
    var expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nombres').val() == "" || $('#nombres').val() == null) {
        alertSwal('error', 'Nombres', 'Este campo es obligatorio');
        $("#nombres").focus();
        return false;
    } else if ($('#email').val() == "" || $('#email').val() == null) {
        alertSwal('error', 'E-mail', 'Este campo es obligatorio');
        $("#email").focus();
        return false;
    } else if ($('#password').val() == "" || $('#password').val() == null) {
        alertSwal('error', 'Password', 'Este campo es obligatorio');
        $("#password").focus();
        return false;
    } else if ($('#perfil').val() == "" || $('#perfil').val() == null) {
        alertSwal('error', 'Perfil de Usuario', 'Este campo es obligatorio');
        $("#perfil").focus();
        return false;
    } else if ($('#password').val() != $('#password_confirma').val()) {
        alertSwal('error', 'Password', 'Las contraseñas no son iguales');
        $("#password_confirma").focus();
        return false;
    } else if (accion == "AGREGAR" && !(expreg.test($('#password').val()))) {
        alertSwal('warning', 'Password', 'La contraseña debe contener minimo 8 caracteres, usar al menos una Mayuscula un Número y un Simbolo.');
        $("#password").focus();
        return false;
    }

    return true;

}
document.getElementById('archivo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['jpg', 'png'].includes(ext)) {
            //alert('Solo se permiten archivos .jpg o .png');
            alertSwal('error', 'Solo se permiten archivos .jpg o .png');
            e.target.value = ''; // Limpia el input
        }
    }
});