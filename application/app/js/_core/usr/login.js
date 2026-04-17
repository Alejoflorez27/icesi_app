$(document).ready(function() {


    $('#btn-reset-password').click(function() {

        var username = $("#usuario_reset").val();

        $('#btn-reset-password').addClass("hide");
        $('#modalResetPassword').modal("hide");

        $.ajax({
            type: "POST",
            url: url_site() + `api/usuario/reset-password/`,
            data: { username: username },
            dataType: "json",
            success: function(r) {
                $('#btn-reset-password').removeClass("hide");
                if (r.success) {
                    alertSwal('success', `Cambio de contraseña`, r.code);
                    $("#usuario_reset").val("");
                    $('#modalResetPassword').modal("hide");
                } else {
                    $("#usuario_reset").val("");
                    alertSwal('error', `Falló cambio de contraseña`, r.code);
                }
            }
        });
    });

    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Familiar
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('solicitud');
    //console.log(id_solicitudC);
    $('#btn-ingresar').click(function() {
        $.ajax({
            type: "POST",
            url: url_site() + "api/usuario/login/",
            data: $("#formLogin").serialize(),
            dataType: "json",
            success: function(r) {
                //console.log(r);
                if (r.success) {
                    setToken(r.token);
                    /*console.log(r.auto_bash.data.total)
                    console.log(r.perfil)
                    console.log(r.bandera_bash)*/
                    //9 cadidato alejo 
                    //14 candidato guille
                    /*if(r.perfil == 14){
                        window.location = url_site(`candidato?id_solicitud=${id_solicitudC}`);
                    }else if((r.perfil == 7) && (r.bandera_bash == 'S') && (r.auto_bash.data.total == '0')){
                        window.location = url_site(`auto_bash`);
                        
                    } 
                    else {*/
                        window.location = url_site(`curriculoGestion`);
                    //}
                    
                } else {
                    $('#username, #password').val('');
                    alertSwal('error', 'Autenticación', r.code);
                    $('#mensaje-login').children().remove();
                    $('#mensaje-login').append('<span><strong>' + r.code + '</strong></span>');
                    $('#mensaje-login').css('color', 'red');
                }
            }
        });

    });

});