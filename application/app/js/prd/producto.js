$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    cargarTablaProductos();

    $('.btnAddProducto').on('click', function () {
        $('.div-editar').removeClass('hide');
        $('#formProducto')[0].reset();
        $('#accion').val("POST");
    });

    // Crear Producto
    $('#btn-submit-producto').on('click', function (e) {
        e.preventDefault(e);

        if (validateFormProducto()) {

            let method = $('#accion').val();
            let data = {
                id_producto: $('#id_producto').val(),
                nom_prod: $('#nom_prod').val(),
                estado: $('#estado').val(),
            }

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/producto?id_producto=${data.id_producto}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Producto', 'Producto guardado satisfactoriamente');
                        cargarTablaProductos();
                        $('#formProducto')[0].reset();
                        $('#modalAddProducto').modal('hide')
                    } else {
                        alertSwal('error', 'Producto', r.code.code);
                        cargarTablaProductos();
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

    // Editar Poducto
    $('#tbl-productos').on('click', '.btnEditProducto', function () {
        $('.div-editar').addClass('hide');

        $('#accion').val("PUT");
        let id_producto = $(this).attr('producto');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/producto?id_producto=${id_producto}`),
            dataType: "json",
            success: function (resp) {
                $('#id_producto').val(resp.data.id_producto);
                $('#nom_prod').val(resp.data.nom_prod);
                $('#estado').val(resp.data.estado).change();
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddProducto').modal();
    })

    // Activa e Inactiva un Producto
    $('#tbl-productos').on('click', '.btnEstadoProducto', function () {
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_producto = $(this).attr('producto');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Producto`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este producto?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_producto: id_producto,
                    estado: estadoNuevo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/producto/cambio-estado?id_producto=${id_producto}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Producto', 'El Producto se '+ nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaProductos();
                            $('#formProducto')[0].reset();
                        } else {
                            alertSwal('error', 'Producto', r.code.code);
                            cargarTablaProductos();
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

});


function cargarTablaProductos() {

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/producto/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-productos').DataTable().clear();
            $('#tbl-productos').DataTable().destroy();

            let t = $('#tbl-productos').DataTable({
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
                    title: 'REPORTE: Listado de Productos',
                }],
            });

            if (r.status == "success") {
                r.data.forEach((prd) => {

                    t.row.add([
                        prd.id_producto,
                        prd.nom_prod,
                        `<button class="btn btn-xs btn-${(prd.estado == 1) ? 'success' : 'danger'} btnEstadoProducto"
                            producto=${prd.id_producto} estado=${prd.estado}>
                            ${(prd.estado == 1) ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        prd.usr_create,
                        prd.fch_create,
                        `<button class="btn btn-xs btn-warning btnEditProducto" producto="${prd.id_producto}"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>`
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


function validateFormProducto() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nom_prod').val() == "" || $('#nom_prod').val() == null) {
        alertSwal('error', 'Nombre Producto', 'Este campo es obligatorio');
        $("#nom_prod").focus();
        return false;
    }

    return true;

}