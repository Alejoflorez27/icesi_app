$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");
    cargarTabla();
   // cboLoad('perfil', url_site(`api/perfil/lista-perfiles?tipo=I`), '', true, 'Seleccione un perfil');
    cboLoad('tipo_identificacion', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');
    

    //carga la lista de perfiles INTERNOS
    loadSelectOption({
        url: url_site(`api/perfil/lista-perfiles?tipo=I`), 
        input: [{  
            id: 'perfil',
            clearOptions: true,
            emptyText: 'Seleccione un perfil',
            selectedValue: ''
        },],
        columnKey: 'id',
        columnDescription: 'descripcion',
        responsePath: 'data'
    })

    loadSelectOption({
        url: url_site(`api/empresa/lista?estado=1`),
        input: [{ 
            id: 'id_empresa',
            clearOptions: true,
            emptyText: 'Seleccione un Cliente',
            selectedValue: ''
        },],
        columnKey: 'id_empresa',
        columnDescription: 'razon_social',
        responsePath: 'data'
    })


     //carga el nombre del archivo seleccionado en firma
     $('#archivo').on('change', function (e) {
        var archivo = document.getElementById('archivo').files[0];
        $('#info').html(`<strong>${archivo.name}</strong> <small> (${descripcionTamanoArchivo(archivo.size)})</small>`);
        $('#lbl-archivo').html(`Cambiar Archivo`);
    });

    //esconder el boton editar firma
    $('#btn-edit-empresa').hide();
    $('#infoEdit').hide();
    $('#idArchivo').hide();
    $('#idArchivo2').hide();
    $('#infoImage').hide();
    $('#registroinput').hide();

    $('#perfil').on("change", function () {
        let perfil_lista = $('#perfil').val(); 
        //$("#username").val('');

        if (['10', '13', '11', '15', '16'].includes(perfil_lista)) {
            $('#infoEdit').hide();
            $('#idArchivo').show();
            $('#idArchivo2').show();
            $('#infoImage').show();
            $('#registroinput').show();
            $('#registro').attr('required', true); // 👈 Añadir validación obligatoria
        } else {
            $('#infoEdit').hide();
            $('#idArchivo').hide();
            $('#idArchivo2').hide();
            $('#infoImage').hide();
            $('#registroinput').hide();
            $('#registro').removeAttr('required'); // 👈 Quitar validación obligatoria
        }
    });

    


    $(".btnAgregarUsuario").on("click", function () {
        $('#accion').val("agregar");
        accionFormAgregar($(this));
        $('.me-password').show();
        $('#div-perfil').show();
        $('#nota-contrasena').removeClass('hide');
        $('#perfil').val($('#perfil > option:first').val());

        $('#btn-edit-empresa').hide();
        $('#infoEdit').hide();
        $('#idArchivo').hide();
        $('#idArchivo2').hide();
        $('#infoImage').hide();

    });


    $(".tablas").on("click", ".btnEditarUsuario", function () {
        $('#accion').val("editar");
        accionFormEditar($(this));
        $('#modalAgregarUsuario').modal();
        $('.me-password').hide();
        $('#div-perfil').show();
        $('#nota-contrasena').addClass('hide');

    })


    $(".tablas").on("click", ".btnEliminarUsuario", function () {
        $('#accion').val("eliminar");
        accionFormEditar($(this));

        Swal.fire({
            icon: 'question',
            title: 'Eliminar usuario',
            text: '¿Está seguro de borrar este usuario?',
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                $("#formUsuario").submit();
            }
        });
    });

    $(".tablas").on("click", ".btnEstadoUsuario", function () {
        var nuevoEstado = ($(this).attr("estado") == "ACT") ? "INA" : "ACT";
        var nuevoEstadoDesc = (nuevoEstado == "ACT") ? "activar" : "inactivar";

        $('#accion').val(nuevoEstadoDesc);
        accionFormEditar($(this));

        Swal.fire({
            icon: 'question',
            title: `${nuevoEstadoDesc} usuario`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este usuario?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                $("#formUsuario").submit();
            }
        });

    });

    $('.tablas').on('click', '.btnDetalleLogin', function (e) {
        e.preventDefault();
        let username = $(this).attr('username')
        $('#span-username').html(username)
        cargarTablaAccessLog(username);
        $('#modalAccessLogUsuario').modal()
    })

    $("#password").change(function () {
        $("#password_confirma").val('');
    });

    $("#username").change(function () {
        var isReadonly = $("#username").prop("readonly");
    
        if (!isReadonly && $('#username').is(":visible")) { // evitar validación cuando el navegador autocompleta el campo
            var username = $(this).val();
    
            // Validar que el username no contenga Ñ, ñ o tildes
            if (/[^a-zA-Z0-9\s]/.test(username)) {
                $("#username").val('').focus();
                alertSwal('error', 'Usuario', 'El nombre de usuario no puede contener caracteres especiales');
                return; // Detener la ejecución si la validación falla
            }
    
            $.ajax({
                headers: { 'access-token': getToken() },
                type: "GET",
                url: url_site() + `api/usuario/existe/?username=${username}`,
                dataType: "json",
                success: function (r) {
                    if (r.existe == true && username != "") {
                        alertSwal('warning', `Usuario ${username} ya Existe`, 'Indique un usuario diferente.');
                        $("#username").val('').focus();
                    }
                }
            });
        }
    });
    


    //envio de formulario
    $("#formUsuario").submit(function (e) {
        
        e.preventDefault(e);

        var accion = $('#accion').val();
        let action_method = {
            'agregar': 'POST',
            'editar': 'POST',
            'eliminar': 'POST',
            'activar': 'POST',
            'inactivar': 'POST'
        }

        var form = document.getElementById('formUsuario');
        var formData = new FormData(form);

        let username = $('#username').val();
        

        //console.log(formData);
        if (!['activar', 'inactivar'].includes(accion)) {
            if (validarCamposUsuario()) {
            
                $.ajax({
                    headers: { 'access-token': getToken() },
                    method: action_method[accion],
                    url: url_site() + "api/usuario/" + accion,
                // data: $("#formUsuario").serialize(),
                processData: false,
                cache: false,
                contentType: false,
                data: formData,
                dataType: "json",
                    success: function (r) {
                        console.log(r);
                        if (r.status == "success" || r.success) {
                            alertSwal('success', 'Usuario', 'Acción ' + accion + ' terminó correctamente.', '');
                            //cargarTabla();
                            location.reload();
                        } else {
                            alertSwal('error', 'Usuario', r.code.code,'');
                        }
                    }
                });
            } 
            
        } else {
            $.ajax({
                headers: { 'access-token': getToken() },
                method: action_method[accion],
                url: url_site() + "api/usuario/" + accion,
               // data: $("#formUsuario").serialize(),
               processData: false,
               cache: false,
               contentType: false,
               data: formData,
               dataType: "json",
                success: function (r) {
                    console.log(r);
                    if (r.status == "success" || r.success) {
                        alertSwal('success', 'Usuario', 'Acción ' + accion + ' terminó correctamente.', '');
                        //cargarTabla();
                        location.reload();
                    } else {
                        alertSwal('error', 'Usuario', r.code.code,'');
                    }
                }
            });
        }
        


       
    });
});



function cargarTabla() {

    showModalLoading();
    $.ajax({
        headers: { 'access-token': getToken() },
        type: "GET",
        url: url_site(`api/usuario/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-usuarios').DataTable().clear();
            $('#tbl-usuarios').DataTable().destroy();

            var t = $('#tbl-usuarios').DataTable({
                paging: true,
                ordering: true,
                info: true,
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
                        index + 1,
                        `${user.nombres ?? ''} ${user.apellidos ?? ''}`,
                       // user.empresa,
                        user.username,
                        user.email,
                        `<button class="btn btn-xs btn-${(user.estado == 'ACT') ? 'success' : 'danger'} btnEstadoUsuario"
                            username=${user.username} estado=${user.estado}>
                            ${(user.estado == 'ACT') ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        user.perfil_desc,
                        user.last_login,
                        `<button class="btn btn-xs btn-warning btnEditarUsuario" username=${user.username}><i class="fa fa-pencil"></i> Editar</button>
                        <button class="btn btn-xs btn-danger btnEliminarUsuario" username=${user.username}><i class="fa fa-trash"></i> Eliminar</button>
                        <button class="btn btn-xs btn-primary btnDetalleLogin" username=${user.username}><i class="fa fa-history"></i> Ver Detalle</button> `
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

function cargarTablaAccessLog(username) {
    showModalLoading();
    $.ajax({
        headers: { 'access-token': getToken() },
        type: "GET",
        url: url_site(`api/usuario/access-log/${username}/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-access-log').DataTable().clear();
            $('#tbl-access-log').DataTable().destroy();
            var t = $('#tbl-access-log').DataTable({
                paging: true,
                ordering: true,
                info: false,
                searching: true,
                order: [
                    [0, "desc"]
                ]
            });

            r.forEach((log) => {
                t.row.add([
                    log.fecha_acceso,
                    log.ip_acceso,
                    log.resultado
                ]);
            });

            t.draw();
        }
    }).done(function () {
        hideModalLoading();
    });
}

function accionFormAgregar(input) {
    $('#formUsuario')[0].reset();
    $('#username').prop('readonly', false);
    $(".div-username").show();

    $('#perfil').attr('required', true);
    let perfil = $('#perfil').val();
    let registro = $('#registro').val().trim();

    const perfilesConRegistro = ['10', '11', '13', '15', '16'];
    if (perfilesConRegistro.includes(perfil) && !registro) {
        alertSwal('warning', 'Campo obligatorio', 'El campo "registro" es requerido para este perfil.');
        $('#registro').focus();
        return;
    }
    
}


function accionFormEditar(input) {

    var username = input.attr("username");

    let perfil = $('#perfil').val();
    let registro = $('#registro').val().trim();

    const perfilesConRegistro = ['10', '11', '13', '15', '16'];
    if (perfilesConRegistro.includes(perfil) && !registro) {
        alertSwal('warning', 'Campo obligatorio', 'El campo "registro" es requerido para este perfil.');
        $('#registro').focus();
        return;
    }


    $.ajax({
        headers: { 'access-token': getToken() },
        method: 'GET',
        url: url_site(`api/usuario/info/${username}`),
        dataType: "json",
        success: function (r) {
            if (r.password != null) {
                $('#nombres').val(r.nombres);
                $('#apellidos').val(r.apellidos);
                $('#id_empresa').val(r.id_empresa);
                $('#tipo_identificacion').val(r.tipo_identificacion);
                $('#numero_identificacion').val(r.numero_identificacion);
                $('#username').val(r.username);
                $('#registro').val(r.registro);//nuevo
                //cboLoad('perfil', url_site(`api/perfil/lista`), r.perfil, true, 'Seleccione un perfil');
                loadSelectOption({
                    url: url_site(`api/perfil/lista-perfiles?tipo=I`),
                    input: [{
                        id: 'perfil',
                        clearOptions: true,
                        emptyText: 'Seleccione un perfil',
                        selectedValue: r.perfil
                    },],
                    columnKey: 'id',
                    columnDescription: 'descripcion',
                    responsePath: 'data'
                });
                $('#email').val(r.email);
                $('#password').val(r.password);
                $('#password_confirma').val(r.password);
                $('#password_confirma').val(r.password);
                $('#nomLogo').html(r.nom_firma);

                $('.div-username').show();

                $("#mi_imagen").attr("src",'/'+r.directorio+r.nombre_encr);

                if (['10', '11', '13', '15', '16'].includes(r.perfil)) {
                    $('#infoEdit').hide();
                    $('#idArchivo, #idArchivo2, #infoImage, #registroinput').show();
                    
                } else {
                    $('#infoEdit, #idArchivo, #idArchivo2, #infoImage , #registroinput').hide();
                }
                
                
            }
        }
    });

    $('#username').prop('readonly', true);
    $('#perfil').attr('required', false);
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
    } else if (accion == "AGREGAR" && /[^a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]/.test($('#username').val())) {
        alertSwal('warning', 'Usuario', 'El usuario no puede tener caracteres especiales');
        $("#username").focus();
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