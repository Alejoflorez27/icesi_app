$(document).ready(function () {

    $("body").addClass("sidebar-collapse");
    
    $('.link-resumen-dashboard').on('click', function (e) {
        e.preventDefault(e);
        let estado = $(this).attr('estado');
        console.log(estado);
        window.location.href = `solicitud?estado=${estado}`;
    });
})