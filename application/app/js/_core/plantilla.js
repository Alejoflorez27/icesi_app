$(document).ready(function() {

    var idInterval = setInterval(isLogged, 600000);

    var menu = sessionStorage.getItem('menu-activo');
    if (menu != null && menu != "")
        menuActivo(menu);


    function isLogged() {
        $.ajax({
            type: "GET",
            url: url_site(`api/usuario/is-logged/`),
            dataType: "json",
            success: function(r) {
                if (!r.logged) {
                    removeSession();
                    clearInterval(idInterval);
                    alertSwalR("warning", "Su sesión ha finalizado", "Excedió el tiempo de inactividad.", "inicio");
                }
            }
        });
    }

    $('.a-notificacion').on('click', '.btn-notificacion-leido', (e) => {
        e.preventDefault(e);
        let notif = $(this).attr('notificacion')
        console.log("notificacion", notif)
        console.log("id", $(this).attr('id'))
    })

    $.ajax({
        headers: { 'access-token': getToken() },
        type: "GET",
        url: url_site('api/usuario/expired-password/'),
        dataType: "json",
        success: function(r) {
            if (r.expired) {
                alertSwal('warning', 'Contraseña', r.mensaje);
                $('#btn-cerrar-password').addClass('hide')
                $('#btn-salir-password').addClass('hide')
                $('#modalPassword').modal({
                    backdrop: 'static',
                    keyboard: false
                })
            }
        }
    });
});


/*=============================================
 Data Table
 =============================================*/
$(".tablas").DataTable({

    "language": languageDataTable()
    //,iDisplayLength: 25

});

/*=============================================
 //iCheck for checkbox and radio inputs
 =============================================*/

$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue'
})

/*=============================================
 //input Mask
 =============================================*/

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
$('[data-mask]').inputmask()

$('.formato-moneda').on("blur", function() {
    $(this).val(number_format($(this).val()))
});

//Initialize Select2 Elements
$('.select2').select2()

/*=============================================
 CORRECCIÓN BOTONERAS OCULTAS BACKEND	
 =============================================*/
/*
 * if (window.matchMedia("(max-width:767px)").matches) {
 $("body").removeClass('sidebar-collapse');
 } else {
 $("body").addClass('sidebar-collapse');
 }
 */

function printMenu() {
    $.ajax({

        url: "api/menu/",
        method: "GET",
        //data: datos,
        cache: false,
        contentType: false,
        processData: false,
        //dataType: "json",
        success: function(respuesta) {
            //console.log("OK:" + respuesta);
            $(".me-menu").append(respuesta);
            $('.sidebar-menu').tree();

        },
        error: function(respuesta) {

            console.log("FAIL");
        }


    });
}

//printMenu();

/*=============================================
 SideBar Menu
 =============================================*/
$('.sidebar-menu').tree();

function iconLink() {
    $('.a-me').append(' <i class="fa fa-external-link" aria-hidden="true"></i>'); //{ fa-question-circle | fa-external-link | fa-external-link-square }
}

/**
 * Actividad para el formulario cambio de password
 */
$("#formPassword").submit(function(e) {

    var expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#password_new').val() != $('#password_new_confirma').val()) {
        alertSwal('error', 'Password', 'Las contraseñas no son iguales');
    } else if (!(expreg.test($('#password_new').val()))) {
        alertSwal('warning', 'Password', 'La contraseña debe contener minimo 8 caracteres, usar al menos una Mayuscula un Número y un Simbolo.');
        $("#password").focus();
        return false;
    } else {
        $.ajax({
            headers: { 'access-token': getToken() },
            method: 'POST',
            url: url_site() + "api/usuario/cambiar-password/",
            data: $("#formPassword").serialize(),
            dataType: "json",
            success: function(r) {
                if (r.success) {
                    alertSwalR('success', 'Password', 'Contraseña actualizada correctamente.', '');
                } else {
                    alertSwalR('error', 'Password', 'Falló al actualizar contraseña: ' + r.code, '');
                }
            }
        });
    }

    e.preventDefault(e);
});


function cambiarSkin(skin) {
    $.ajax({
        headers: { 'access-token': getToken() },
        method: 'POST',
        url: url_site(`api/usuario/skin/${skin}/`),
        dataType: "json",
        success: function(r) {
            if (r.success) {
                alertSwalR('success', 'Skin', 'Skin actualizada correctamente.', '');
            } else {
                alertSwalR('error', 'Skin', 'Falló al actualizar skin: ' + r.code, '');
            }
        }
    });
}

function notificacionLeida(id) {
    // showModalLoading()
    $.ajax({
        method: 'POST',
        url: url_site(`api/notificacion/leido/`),
        data: {
            id
        },
        dataType: "json",
        success: function(r) {
            if (r.success) {
                let total = parseInt($('#total_notificaciones').val(), 10)
                total = total - 1;
                $('#total_notificaciones').val(total)
                $('#total_notificaciones_label').html(total);
                $('#total_notificaciones_desc').html(`Tiene ${total} mensajes nuevos`);

                $(`#li-notificacion-${id}`).remove()

                // alertSwal('success', 'Notificación', 'Marcada como leída');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Notificación',
                    text: 'Marcada como leída',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                alertSwal('error', 'Notificación', 'Falló al actualizar notificacion: ' + r.code);
            }
        }
    }).done(function() {
        // hideModalLoading();
    });
}

function cambiarPerfil() {
    sessionStorage.removeItem('menu-activo');
    $.ajax({
        method: 'POST',
        url: url_site("api/usuario/unset-role/"),
        dataType: "json",
        success: function(r) {
            if (r.success) {
                window.location = 'inicio';
            } else {
                alertSwalR('error', 'Skin', 'Falló al cambiar rol: ' + r.code, '');
            }
        }
    });
}


$(".me-menu-li").on("click", function() {
    sessionStorage.setItem('menu-activo', $(this).attr('id'));
});

$(".cerrarSesion").on("click", function() {
    removeSession();
});


function menuActivo(menu) {

    menuObj = $(`#${menu}`);
    menuObj.addClass('active');

    if (!(menuObj.parent().hasClass('sidebar-menu'))) {

        menuPadre = menuObj.parent().parent();

        menuPadre.addClass('menu-open');
        menuPadre.children('ul').css('display', 'block');
        menuPadre.addClass('active');

        if (!(menuPadre.parent().hasClass('sidebar-menu')))
            menuActivo(menuPadre.attr('id'));
    }
}


function showModalLoading(texto = "Cargando datos ...") {

    $('body').loadingModal({
        position: 'auto',
        text: texto,
        color: '#fff',
        opacity: '0.7',
        backgroundColor: 'rgb(0,0,0)',
        animation: 'wave'
    });
}

function hideModalLoading() {
    $('body').loadingModal('hide');
    $('body').loadingModal('destroy');
}

function removeSession() {
    sessionStorage.removeItem('menu-activo');
}

function languageDataTable(){
    return {

        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }
}