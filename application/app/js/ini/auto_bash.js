$(document).ready(function () {
    $("body").addClass("sidebar-collapse");

    $('#btn-submit-adjuntos').prop('disabled', true);

    const perfilUsuario = $('#perfil_usuario').val();
    const banderaBash = $('#bandera').val();
    const usuario = $('#usuario').val();
    const id_empresa = $('#id_empresa').val();
    const primerSesion = $('#primer_acceso').val();
    const id_auto = '';

    //abrirPDF(id_empresa);

/*$(".btnIrPdf").on("click", function () {
    var idcombo = null;
    var rutaInforme = 'InformeMain';
    //window.open('../api/solicitud/imprimir-pdf' + `?id_sl=${id_solicitud}&id_sv=${idServicio}&id_combo=${idcombo}&rI=${rutaInforme}`, '_blank');
    window.open('../api/empresa/imprimir-pdf-bash' + `?id_empresa=${id_empresa}&rI=${rutaInforme}`, '_blank');
});
*/
$(".btnIrPdf").on("click", function () {
    var rutaInforme = 'InformeMain';
    var token = getToken();
    var prueba= $('#id_auto').val();
    var url = `../api/empresa/imprimir-pdf-bash?id_empresa=${id_empresa}&id_auto=${prueba}&rI=${rutaInforme}`;

    fetch(url, {
        method: "GET",
        headers: {
            "access-token": token
        }
    })
    .then(response => response.blob())
    .then(blob => {
        var fileURL = URL.createObjectURL(blob);
        window.open(fileURL, '_blank'); // Abre el PDF en una nueva pestaña
    })
    .catch(error => console.error('Error al generar PDF:', error));
});



    if (perfilUsuario === '7' && banderaBash === 'S' && primerSesion === 'S') {
        // Carga el contenido vía AJAX
        $.ajax({
            headers: {
            "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/empresa/list_auto_bash?id_empresa=${id_empresa}`),
            dataType: "json",
            success: function (resp) {
                //console.log(resp)
            if (resp && resp.data && (resp.data.total == '0')) {
                abrirModalLectura();
            } 
            },
            error: function () {
            }
        }).done(function () {
            hideModalLoading();
        });
    }

    //envio de Accion POST
    $('.btnCargarArchivo').on('click', function () {
          $('#accion').val("POST");
      });

    $('#archivo').on('change', function () {
        if (this.files.length > 0) {
            archivosCargadosSimple = true;
            $('#btn-submit-adjuntos').prop('disabled', false);
            $('#info').html(this.files[0].name);
        }
    });
    $("#frmCargarArchivo").on('submit', function (e) {
        e.preventDefault();

        showModalLoading();

        const formData = new FormData(this);
        const url =  url_site(`api/adjuntos/archivos_adjuntos_auto`);

        $.ajax({
            headers: { "access-token": getToken() },
            method: 'POST',
            url,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            success: function (r) {
                $('#id_auto').val(r.data);
                console.log(r.data)
                hideModalLoading();

                if (r.status === "success") {
                    alertSwal('success', 'Cargue', 'Cargue de archivo terminó correctamente.');

                    archivosCargadosSimple = false;
                    $('#archivo').val('');
                    $('#lbl-archivo').text('Seleccionar Archivo');

                } else {
                    alertSwal('error', 'Cargue', 'Error en la carga de archivos.');
                }
            },
            error: function () {
                hideModalLoading();
                //alertSwal('error', 'Cargue', 'Error en la comunicación con el servidor.');
            },
            complete: function () {
            }
        });
    });
});


function abrirModalLectura() {
  $('#checkLeidoLectura').prop('checked', false);
  $('#btn-submit-adjuntos').prop('disabled', true);
  //$('#contenidoLectura').html('Cargando contenido...');

  // Capturar el valor del hidden
  const perfilUsuario = $('#perfil_usuario').val();
  //console.log('Perfil del usuario:', perfilUsuario);


  // Mostrar el modal y bloquear salida hasta que se acepte
  $('#modalLecturaObligatoria').modal({
    backdrop: 'static',  // No se cierra clickeando fuera
    keyboard: false       // No se cierra con ESC
  });
}


$('#checkLeidoLectura').on('change', function () {
  $('#btn-submit-adjuntos').prop('disabled', !$(this).is(':checked'));
});
