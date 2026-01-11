$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    cargarTablaPerfiles();

    $(".btnAgregarPerfil").on("click", function () {
        $('#accion').val("AGREGAR");
        accionFormAgregar($(this));
        $('.me-password').show();
        $('#div-perfil').show();

    });


    $(".tablas").on("click", ".btnEditarPerfil", function () {
        $('#accion').val("EDITAR");
        accionFormEditar($(this));
        $('#modalAgregarPerfil').modal();
        $('.me-password').hide();
        $('#div-perfil').show();

    })


    $(".tablas").on("click", ".btnEliminarPerfil", function () {
        $('#accion').val("ELIMINAR");
        accionFormEditar($(this));
        $('#tercero').attr('required', false);

        Swal.fire({
            type: 'question',
            title: 'Eliminar Perfil',
            text: '¿Está seguro de borrar este perfil?',
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                $("#formPerfil").submit();
            }
        });
    });

    $(".tablas").on("click", ".btnEstadoPerfil", function () {

        var nuevoEstado = ($(this).attr("estado") == "A") ? "I" : "A";
        var nuevoEstadoDesc = (nuevoEstado == "A") ? "Activar" : "Inactivar";

        $('#accion').val(nuevoEstadoDesc.toUpperCase());
        accionFormEditar($(this));

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} perfil`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este perfil?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                $("#formPerfil").submit();
            }
        });

    });


    $("#formPerfil").submit(function (e) {

        var accion = $('#accion').val().toLowerCase();
        var method = ''
        switch (accion) {
            case 'agregar':
                method = 'POST';
                break;
            case 'editar':
                method = 'PUT';
                break;
            case 'eliminar':
                method = 'DELETE';
                break;
            case 'activar':
                method = 'POST';
                break;
            case 'inactivar':
                method = 'POST';
                break;
        }

        if (validarCamposPerfil()) {

            $.ajax({
                headers: { "access-token": getToken() },
                method: method,
                url: url_site(`api/perfil/${accion}/`),
                data: $("#formPerfil").serialize(),
                dataType: "json",
                success: function (r) {
                    if (r.success) {
                        alertSwal('success', 'Perfil', 'Acción ' + accion + ' terminó correctamente.');
                        cargarTablaPerfiles();
                        $('#formPerfil')[0].reset();
                        $('#modalAgregarPerfil').modal('hide');
                    } else {
                        alertSwal('error', 'Perfil', r.code);
                        cargarTablaPerfiles();
                    }
                }
            });
        }

        e.preventDefault(e);
    });

});

function cargarTablaPerfiles() {
    showModalLoading()
    $.ajax({
        headers: { "access-token": getToken() },
        type: "GET",
        url: url_site() + "api/perfil/lista/",
        dataType: "json",
        success: function (r) {

            $('#tbl-perfiles').DataTable().clear();
            $('#tbl-perfiles').DataTable().destroy();

            var t = $('#tbl-perfiles').DataTable();

            r.forEach(perfiles);

            function perfiles(perfil, index) {
                t.row.add([
                    perfil.id,
                    perfil.descripcion,
                    `<button class="btn btn-xs btn-${(perfil.estado == 'A') ? 'success' : 'danger'} btnEstadoPerfil"
                        perfil=${perfil.id} estado=${perfil.estado}>
                        ${(perfil.estado == 'A') ? 'Activo' : 'Inactivo'}    
                    </button>`,
                    perfil.usuario_sistema,
                    perfil.fecha_sistema,
                    `<button class="btn btn-xs btn-warning btnEditarPerfil" perfil=${perfil.id}><i class="fa fa-pencil"></i> Editar</button>
                    <button class="btn btn-xs btn-danger btnEliminarPerfil" perfil=${perfil.id}><i class="fa fa-trash"></i> Eliminar</button>`
                ]);
            }
            t.draw();
        }
    }).done(function () {
        hideModalLoading();
    });
}

function accionFormAgregar(input) {
    $('#formPerfil')[0].reset();
}


function accionFormEditar(input) {

    var perfil = input.attr("perfil");

    $.ajax({
        headers: { "access-token": getToken() },
        method: 'GET',
        url: url_site(`api/perfil/info/${perfil}`),
        dataType: "json",
        success: function (r) {
            $('#id').val(r.id);
            $('#descripcion').val(r.descripcion);
            $('#estado').val(r.estado);
        }
    });

    $('#id').prop('readonly', true);
}

function validarCamposPerfil() {

    /*var accion = $('#accion').val();
    var expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nombre').val() == "" || $('#nombre').val() == null) {
        alertSwal('error', 'Nombre', 'Este campo es obligatorio');
        $("#password_confirma").focus();
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
        alertSwal('error', 'Perfil de Perfil', 'Este campo es obligatorio');
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
    }*/

    return true;

}