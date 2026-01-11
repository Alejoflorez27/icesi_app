//Cuando Inicie la pantalla que la muestre con el menu cerrado
$("body").addClass("sidebar-collapse");
/**
 * @usos:   vw.referencia.list.php
 */

$(".tablas").on("click", ".btnAgregarParametro", function () {
    /**
     *AGREGAR PARAMETRO
     */
    $('#accion').val("AGREGAR");
    accionFormAgregar($(this));

})


$(".tablas").on("click", ".btnEditarParametro", function () {
    /**
     *EDITAR PARAMETRO
     */
    $('#accion').val("EDITAR");
    accionFormEditar($(this));
})

$(".tablas").on("click", ".btnEliminarParametro", function () {
    /**
     *ELIMINAR PARÁMETRO
     */
    $('#accion').val("ELIMINAR");
    accionFormEditar($(this));

    Swal.fire({
        type: 'question',
        title: 'Eliminar referencia',
        text: '¿Está seguro de borrar ésta referencia?',
        confirmButtonText: 'OK',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        focusCancel: true
    }).then((result) => {
		if (result.value) {
            $('#btn-submit-referencia').click();
        }
    });

})



$('#btn-submit-referencia').click(function () {
    /**
     * ENVIAR FOMRULARIO
     */
    var accion = $('#accion').val();
    let methods = {"AGREGAR": "POST", "EDITAR": "PUT", "ELIMINAR": "DELETE"};
    $.ajax({
        method: methods[accion],
        headers: {'access-token': getToken()},
        url: url_site() + "api/configuracion/" + accion,
        data: $("#formReferencia").serialize(),
        dataType: "json",
        success: function (r) {
            if (r.success) {
                alertSwalR('success', 'Referencia', 'Acción ' + accion + ' terminó correctamente.', '');
            } else {
                alertSwalR('error', 'Referencia', r.code, '');
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


function accionFormAgregar(input) {

    $('#formReferencia')[0].reset();

    $('#categoria').find('option').remove();

    var categoria = input.attr("codigo");
    $('#categoria').append(new Option(categoria, categoria, true, true));

    $('#categoria').prop('readonly', true);
    $("#codigo").prop('readonly', false);

    $("#estado").attr('checked', true);

    $('input:radio[name=estado]')[0].checked = true; // 0=ACT 1=INA
}


function accionFormEditar(input) {

    $('#formReferencia')[0].reset();

    var categoria = input.attr("categoria");
    var codigo = input.attr("codigo");
    var descripcion = input.attr("descripcion");
    var observacion = input.attr("observacion");
    var estado = input.attr("estado");

    var estadoVal = 0;

    if (estado === "INA") {
        estadoVal = 1;
    }

    $('#categoria').find('option').remove();

    $('#categoria').append(new Option(categoria, categoria, true, true));
    $('#codigo').val(codigo);
    $('#descripcion').val(descripcion);
    $('#observacion').val(observacion);

    $('#categoria').prop('readonly', true);
    $("#codigo").prop('readonly', true);

    $('input:radio[name=estado]')[estadoVal].checked = true; // 0=ACT 1=INA
}