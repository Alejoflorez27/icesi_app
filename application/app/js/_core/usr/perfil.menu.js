$(document).ready(function() {

    $("body").addClass("sidebar-collapse");

    cboLoad('perfil', url_site('api/perfil/lista/A/'), '', true, 'Seleccione un Perfil');

    $('#perfil').change(function() {
        cargarTablaMenu();
    });

    $(".tablas").on("click", ".checkNodo", function() {
        var isChecked = $(this).prop('checked');
        var nodo = $(this).attr('nodo');
        var perfil = $('#perfil').val();
        var accion = (isChecked) ? "agregar" : "eliminar";

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
        }

        $.ajax({
            headers : { "access-token" : getToken() },
            type: method,
            url: url_site(`api/perfil/${accion}-menu/`),
            data: {
                perfil,
                nodo
            },
            dataType: "json",
            success: function(r) {
                if (r.success) {
                    alertSwal('success', 'Menu', 'Acción ' + accion + ' terminó correctamente.');
                } else {
                    alertSwal('error', 'Menu', r.code);
                }
            }
        });
    });
});


function cargarTablaMenu() {

    var perfil = $('#perfil').val();

    showModalLoading();
    $.ajax({
        headers : { "access-token" : getToken() },
        type: "GET",
        url: url_site(`api/perfil/menu/${perfil}/`),
        dataType: "json",
        success: function(r) {

            $('#tbl-menu').DataTable().clear();
            $('#tbl-menu').DataTable().destroy()

            var t = $('#tbl-menu').DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                columns: [{
                        "width": "5%"
                    },
                    {
                        "width": "95%"
                    },
                ]
            });

            r.forEach(menu);

            function menu(nodo, index) {
                t.row.add([
                    (`<input type="checkbox" class="checkNodo" 
                        nodo=${nodo.nodo} 
                        ${(nodo.acceso=="S")?"checked":""} />`),
                    (nodo.nivel == 1) ? `<strong>${nodo.etiqueta}</strong>` : nodo.etiqueta,
                ]);
            }
            t.draw();
        }
    }).done(function() {
        hideModalLoading();
    });
}