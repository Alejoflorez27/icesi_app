$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");


    //envio de Accion POST
   $('.btnAddVivDistribucion').on('click', function () {
        $('#accion').val("POST");
    });


    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Candidato
    let params = new URLSearchParams(location.search);
    let id_solicitudC = params.get('id_solicitud');
    //Captura de los datos de la solicitud por medio de una variable que fue mandada por url en este caso desde Formacion
    let params1 = new URLSearchParams(location.search);
    let id_servicioC = params1.get('id_servicio');
    // Llamar a la función para cargar datos al iniciar

    if (id_servicioC == 3) { //Ingreso

        // Enviar id_solicitud a laboral visita ingreso
        $('#btn-submit-Siguiente').on('click',function () {
    
            window.location = url_site(`sectorVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
        })

        // Enviar id_solicitud a dimension familiar visita ingreso
        $('#btn-submit-Anterior').on('click',function () {
    
            window.location = url_site(`newdistribucionVivienda_visita_ingreso?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
        })

    } else { //Mantenimiento

        // Enviar id_solicitud a laboral visita ingreso
        $('#btn-submit-Siguiente').on('click',function () {
    
            window.location = url_site(`sectorVivienda_visita_mantenimiento?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
        })

        // Enviar id_solicitud a dimension familiar visita ingreso
        $('#btn-submit-Anterior').on('click',function () {
    
            window.location = url_site(`newdistribucionVivienda_visita_mantenimiento?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`)
        })
        
    }




    $('#btn-submit-solicitud').on('click',function () {

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            method: 'GET',
            url: url_site(`api/adjuntos/cliente_solicitud?id_solicitud=${id_solicitudC}`),
            dataType: "json",
            success: function (r) {

                if (r.status == "success") {

                    window.location = url_site(`solicitud/detalle?solicitud=${id_solicitudC}&cliente=${r.data[0].id_empresa}`)
                } 
            }
        })

    });

    // Cargar datos existentes al iniciar
    function cargarDatosExistentes() {
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            method: 'GET',
            url: url_site(`api/vivelectrodomesticos/lista_electrodomesticos?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
            dataType: "json",
            success: function (r) {
                console.log(r);
                if (r.status == "success" && r.data.length > 0) {
                    // Limpiar tabla primero (excepto la fila inicial si existe)
                    $('#tabla-electrodomesticos tbody').empty();
                    
                    // Para cada registro, agregar una fila a la tabla
                    r.data.forEach(item => {
                        agregarFilaConDatos(item);
                    });
                }
            },
            error: function (e) {
                console.error("Error al cargar datos existentes:", e);
            }
        });
    }

    // Función para agregar fila con datos existentes
    function agregarFilaConDatos(datos) {
        const id = Date.now();
        const fila = `
        <tr>
            <td><select class="form-control form-control-sm tipo-elemento" id="tipo_elemento_${id}"></select></td>
            <td><input type="number" class="form-control form-control-sm cant-espacios" value="${datos.cantidad || 1}" min="1"></td>
            <td><select class="form-control form-control-sm estado-electrodomestico" id="estado_electrodomestico_${id}"></select></td>
            <td><select class="form-control form-control-sm tenencia-electrodomestico" id="tenencia_elecrodomestico_${id}"></select></td>
            <td class="text-center">
                <button class="btn btn-danger btn-bg btn-eliminar"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        `;
        $('#tabla-electrodomesticos tbody').append(fila);

        // Configurar los selects con los valores del registro
        const selectsConfig = [
            { id: `tipo_elemento_${id}`, url: 'api/configuracion/tipo_elementos_electrodomestico', value: datos.tipo_elemento},
            { id: `estado_electrodomestico_${id}`, url: 'api/configuracion/estado_dotacion', value: datos.estado_electrodomestico},
            { id: `tenencia_elecrodomestico_${id}`, url: 'api/configuracion/tipo_tenencia_dotacion', value: datos.tenencia_electrodomestico},
        ];

        selectsConfig.forEach(sel => {
            loadSelectOption({
                url: url_site(sel.url),
                input: [{
                    id: sel.id,
                    clearOptions: true,
                    emptyText: 'Seleccione una opción',
                    selectedValue: sel.value
                }],
                columnKey: 'codigo',
                columnDescription: 'descripcion'
            });
        });
    }
    cargarDatosExistentes();
    
    // Crear Distribucion de la vivienda
    // Cargar selects iniciales
    const selectsIniciales = [
        { id: 'tipo_elemento_inicial', url: 'api/configuracion/tipo_elementos_electrodomestico' },
        { id: 'estado_electrodomestico_inicial', url: 'api/configuracion/estado_dotacion' },
        { id: 'tenencia_elecrodomestico_inicial', url: 'api/configuracion/tipo_tenencia_dotacion' }
    ];

    selectsIniciales.forEach(sel => {
        loadSelectOption({
        url: url_site(sel.url),
        input: [{ id: sel.id, clearOptions: true, emptyText: 'Seleccione una opción', selectedValue: '' }],
        columnKey: 'codigo',
        columnDescription: 'descripcion'
        });
    });

    // Agregar fila
    $('#btn-agregar-fila').click(function () {
        const id = Date.now();
        const fila = `
        <tr>
            <td><select class="form-control form-control-sm tipo-elemento" id="tipo_elemento_${id}"></select></td>
            <td><input type="number" class="form-control form-control-sm cant-espacios" value="1" min="1"></td>
            <td><select class="form-control form-control-sm estado-electrodomestico" id="estado_electrodomestico_${id}"></select></td>
            <td><select class="form-control form-control-sm tenencia-electrodomestico" id="tenencia_elecrodomestico_${id}"></select></td>
            <td class="text-center">
            <button class="btn btn-danger btn-bg btn-eliminar"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        `;
        $('#tabla-electrodomesticos tbody').append(fila);

        const nuevosSelects = [
        { id: `tipo_elemento_${id}`, url: 'api/configuracion/tipo_elementos_electrodomestico' },
        { id: `estado_electrodomestico_${id}`, url: 'api/configuracion/estado_dotacion' },
        { id: `tenencia_elecrodomestico_${id}`, url: 'api/configuracion/tipo_tenencia_dotacion' }
        ];

        nuevosSelects.forEach(sel => {
        loadSelectOption({
            url: url_site(sel.url),
            input: [{ id: sel.id, clearOptions: true, emptyText: 'Seleccione una opción', selectedValue: '' }],
            columnKey: 'codigo',
            columnDescription: 'descripcion'
        });
        });
    });

    // Eliminar fila
    $(document).on('click', '.btn-eliminar', function () {
        $(this).closest('tr').remove();
    });

    // Guardar
    $('#btn-guardar').click(function () {
        const datos = [];
        let errores = false;

        $('#tabla-electrodomesticos tbody tr').each(function () {
        const fila = $(this);
        const tipo = fila.find('.tipo-elemento').val();
        const cantidad = fila.find('.cant-espacios').val();

        if (cantidad < 1) {
            errores = true;
            fila.find('.cant-espacios').addClass('is-invalid');
        } else {
            fila.find('.cant-espacios').removeClass('is-invalid');
        }

        datos.push({
            tipo_elemento: tipo,
            cant_electrodomesticos: cantidad,
            estado_electrodomestico: fila.find('.estado-electrodomestico').val(),
            tenencia_electrodomestico: fila.find('.tenencia-electrodomestico').val()
        });
        //console.log(datos);
        });

        if (errores) {
        alert('Corrige los campos en rojo');
        return;
        }

        $.ajax({
        url: `api/vivelectrodomesticos/crear?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`,
        method: 'POST',
        headers: {
            "access-token": getToken()
        },
        data: JSON.stringify(datos),
        contentType: 'application/json',
        success: function () {
            //alert('Datos guardados correctamente');
            alertSwal('success', 'Datos guardados correctamente', 'Siguiente');
        },
        error: function (e) {
            console.error(e);
            alert('Error al guardar');
        }
        });
    });

})







