$(document).ready(function () {
    //Cuando Inicie la pantalla que la muestre con el menu cerrado
    $("body").addClass("sidebar-collapse");

    var perfil_campo = document.getElementById('accion_perfil');
    var username = document.getElementById('accion_candidato');
    //console.log('hola');
    //console.log(username.value);

    if (perfil_campo.value == 10 || perfil_campo.value == 11 || perfil_campo.value == 15 || perfil_campo.value == 16) {
        //let proveedor = $('#filter_proveedor').val();
        loadSelectOption({
            url: url_site(`api/usuario/proveedores-lista/`),
            input: [{
                id: 'filter_proveedor',
                clearOptions: true,
                emptyText: 'Seleccione un Proveedor',
                selectedValue: username.value
            },],
            columnKey: 'username',
            columnDescription: 'nombre_completo',
            responsePath: 'data'
        })
    } else {
        //let proveedor = $('#filter_proveedor').val();
        loadSelectOption({
            url: url_site(`api/usuario/proveedores-lista/`),
            input: [{
                id: 'filter_proveedor',
                clearOptions: true,
                emptyText: 'Seleccione un Proveedor',
                selectedValue: ''
            },],
            columnKey: 'username',
            columnDescription: 'nombre_completo',
            responsePath: 'data'
        })
        $("#filter_proveedor").prop("disabled", false);

    }

    //Inicio lógica filtros
    $('#filter_fecha_rango').daterangepicker({
        timePicker: false,
        timePickerIncrement: 1,
        timePicker24Hour: false,
        locale: {
            format: 'YYYY-MM-DD',
            "separator": " ... ",
            "daysOfWeek": ["D", "L", "M", "X", "J", "V", "S"]
        },
        startDate: moment().startOf('year'),
        endDate: moment(),
        maxDate: moment(),
    });

    $('#filter_fecha_rango').change(function () {
        leerFechaRango();
    });

    $('#btnBuscar').on('click', function () {
        cargarTabla();
    });


    $('#tbl-servicios-calificados').on('click', '.btnVer', function () {
        $('#accion').val("PUT");
        let id = $(this).attr('id');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/servicio/sol-servicio-calificado?id=${id}`),
            dataType: "json",
            success: function (resp) {
                $('#observacion_finalizacion').val(resp.data.observacion_finalizacion);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalCalServicio').modal();
    })
});

// Variable global para almacenar la instancia del gráfico
var myChart;

var myChartPiePregunta1;
var myChartPiePregunta2;
var myChartPiePregunta3;
var myChartPiePregunta4;

// Función para cargar la tabla y actualizar los gráficos
function cargarTabla() {

    let proveedor = $('#filter_proveedor').val();
    let fecha_desde = $('#filter_fecha_desde').val();
    let fecha_hasta = $('#filter_fecha_hasta').val();
    
    // Declaración inicial de variables
    let datosPregunta1 = []; // Almacenará la cantidad de servicios de la pregunta uno por mes
    let datosPregunta2 = []; // Almacenará la cantidad de servicios de la pregunta dos por mes
    let datosPregunta3 = []; // Almacenará la cantidad de servicios de la pregunta tres por mes
    let datosPregunta4 = []; // Almacenará la cantidad de servicios de la pregunta cuatro por mes
    let labels = []; // Almacenará los nombres de los meses

    // Resto del código...
	// Verificar si las fechas están vacías
	if (fecha_desde === '' && fecha_hasta === '') {
		// Si las fechas están vacías, establecer un rango desde el primer día del año actual hasta hoy
		let fechaActual = new Date();
		let añoActual = fechaActual.getFullYear();
		let mesActual = fechaActual.getMonth() + 1; // Nota: los meses en JavaScript son de 0 a 11
		let diaActual = fechaActual.getDate();

		fecha_desde = añoActual + '-01-01';
		fecha_hasta = añoActual + '-' + (mesActual < 10 ? '0' + mesActual : mesActual) + '-' + (diaActual < 10 ? '0' + diaActual : diaActual);
	}
    
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/servicio/servicios-calificados?proveedor=${proveedor}&fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}`),
        dataType: "json",
        success: function (r) {
            $('#tbl-servicios-calificados').DataTable().clear();
            $('#tbl-servicios-calificados').DataTable().destroy();

            let t = $('#tbl-servicios-calificados').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                order: [
                    [1, "desc"],
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Servicios Calificados',
                }],
            });
            
            // Procesar los datos obtenidos y actualizar fechas
            r.data.forEach((ser, index) => {
                // Verificar si es el último registro y no tiene fecha
                if (index === r.data.length - 1 && !ser.fecha_termina_proveedor) {
                    return; // Saltar este registro
                }
                
                // Obtener el mes y año de la fecha de terminación del proveedor
                let fechaTerminaProveedor = new Date(ser.fecha_termina_proveedor);
                let mes = fechaTerminaProveedor.getMonth(); // Mes (0-11)
                let año = fechaTerminaProveedor.getFullYear();
                
                // Verificar si el mes y año ya están en labels
                let indiceMes = labels.findIndex(item => item.mes === mes && item.año === año);
                if (indiceMes === -1) {
                    // Si no está, agregar el mes y año a labels y establecer los datos de cada pregunta en 0
                    labels.push({ mes: mes, año: año });
                    datosPregunta1.push({alto: 0, medio: 0, bajo: 0});
                    datosPregunta2.push({alto: 0, medio: 0, bajo: 0});
                    datosPregunta3.push({alto: 0, medio: 0, bajo: 0});
                    datosPregunta4.push({alto: 0, medio: 0, bajo: 0});
                    indiceMes = labels.length - 1;
                }
                
                // Incrementar el contador de servicios por pregunta
                var descripcion1 = "";
                switch (ser.pregunta1) {
                    case '3':
                        datosPregunta1[indiceMes].alto++;
                        descripcion1 = "Alto"
                        break;
                    case '2':
                        datosPregunta1[indiceMes].medio++;
                        descripcion1 = "Medio"
                        break;
                    case '1':
                        datosPregunta1[indiceMes].bajo++;
                        descripcion1 = "Bajo"
                        break;
                }
                var descripcion2 = "";
                switch (ser.pregunta2) {
                    case '3':
                        datosPregunta2[indiceMes].alto++;
                        descripcion2 = "Alto"
                        break;
                    case '2':
                        datosPregunta2[indiceMes].medio++;
                        descripcion2 = "Medio"
                        break;
                    case '1':
                        datosPregunta2[indiceMes].bajo++;
                        descripcion2 = "Bajo"
                        break;
                }
                var descripcion3 = "";
                switch (ser.pregunta3) {
                    case '3':
                        datosPregunta3[indiceMes].alto++;
                        descripcion3 = "Alto"
                        break;
                    case '2':
                        datosPregunta3[indiceMes].medio++;
                        descripcion3 = "Medio"
                        break;
                    case '1':
                        datosPregunta3[indiceMes].bajo++;
                        descripcion3 = "Bajo"
                        break;
                }
                var descripcion4 = "";
                switch (ser.pregunta4) {
                    case '3':
                        datosPregunta4[indiceMes].alto++;
                        descripcion4 = "Alto"
                        break;
                    case '2':
                        datosPregunta4[indiceMes].medio++;
                        descripcion3 = "Medio"
                        break;
                    case '1':
                        datosPregunta4[indiceMes].bajo++;
                        descripcion4 = "Bajo"
                        break;
                }

                // Resto del código para procesar los datos...
                t.row.add([
                    ser.fecha_termina_proveedor,
                    ser.nom_servicio,
                    ser.razon_social,
                    ser.candidato,
                    ser.numero_doc,
                    ser.estado,
                    descripcion1,
                    descripcion2,
                    descripcion3,
                    descripcion4,
                    (ser.observacion_finalizacion != null && ser.observacion_finalizacion != 'union all') ? `<button class="btn btn-xs btn-success btnVer" id="${ser.id}" ><i class="fa fa-search"  aria-hidden="true"></i></button> ` : ``
                ]);
                
            });
            t.draw();
            
            // Actualizar la gráfica con los datos obtenidos
            actualizarGrafico(labels, datosPregunta1, datosPregunta2, datosPregunta3, datosPregunta4);
            // Actualizar los gráficos de pastel con los datos totales para cada pregunta
            actualizarGraficoPastelTotal(datosPregunta1, 'Pregunta1');
            actualizarGraficoPastelTotal(datosPregunta2, 'Pregunta2');
            actualizarGraficoPastelTotal(datosPregunta3, 'Pregunta3');
            actualizarGraficoPastelTotal(datosPregunta4, 'Pregunta4');
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
function actualizarGraficoPastelTotal(datos, pregunta) {
    // Eliminar el gráfico de pastel existente si existe
    switch(pregunta){
        case 'Pregunta1':
            if (myChartPiePregunta1) {
                myChartPiePregunta1.destroy();
            }
            break;
        case 'Pregunta2':
            if (myChartPiePregunta2) {
                myChartPiePregunta2.destroy();
            }
            break;
        case 'Pregunta3':
            if (myChartPiePregunta3) {
                myChartPiePregunta3.destroy();
            }
            break;
        case 'Pregunta4':
            if (myChartPiePregunta4) {
                myChartPiePregunta4.destroy();
            }
            break;
    }

    // Filtrar los datos para obtener el total de cada respuesta (alto, medio, bajo)
    let altoTotal = datos.reduce((total, item) => total + item.alto, 0);
    let medioTotal = datos.reduce((total, item) => total + item.medio, 0);
    let bajoTotal = datos.reduce((total, item) => total + item.bajo, 0);

    // Contexto del canvas para el gráfico de pastel
    var ctx = document.getElementById(`grafico${pregunta}Pastel`).getContext('2d');

    // Crear el nuevo gráfico de pastel
    switch(pregunta){
        case 'Pregunta1':
            myChartPiePregunta1 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Alto', 'Medio', 'Bajo'],
                    datasets: [{
                        label: pregunta,
                        data: [altoTotal, medioTotal, bajoTotal],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: false
                        }],
                        xAxes: [{
                            display: false
                        }]
                    }
                }
            });
            break;
        case 'Pregunta2':
            myChartPiePregunta2 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Alto', 'Medio', 'Bajo'],
                    datasets: [{
                        label: pregunta,
                        data: [altoTotal, medioTotal, bajoTotal],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: false
                        }],
                        xAxes: [{
                            display: false
                        }]
                    }
                }
            });
            break;
        case 'Pregunta3':
            myChartPiePregunta3 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Alto', 'Medio', 'Bajo'],
                    datasets: [{
                        label: pregunta,
                        data: [altoTotal, medioTotal, bajoTotal],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: false
                        }],
                        xAxes: [{
                            display: false
                        }]
                    }
                }
            });
            break;
        case 'Pregunta4':
            myChartPiePregunta4 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Alto', 'Medio', 'Bajo'],
                    datasets: [{
                        label: pregunta,
                        data: [altoTotal, medioTotal, bajoTotal],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: false
                        }],
                        xAxes: [{
                            display: false
                        }]
                    }
                }
            });
            break;
    }
}

// Función para actualizar el gráfico
function actualizarGrafico(labels, datosPregunta1, datosPregunta2, datosPregunta3, datosPregunta4) {
    // Eliminar el gráfico existente si existe
    if (myChart) {
        myChart.destroy();
    }

    var ctx = document.getElementById('graficoServiciosCalificadosApilado').getContext('2d');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(item => obtenerNombreMes(item.mes) + ' ' + item.año), // Convertir a nombres de meses y años
            datasets: [
                {
                    label: 'Pregunta 1 - Alto',
                    data: datosPregunta1.map(item => item.alto),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    stack: 'pregunta1'
                },
                {
                    label: 'Pregunta 1 - Medio',
                    data: datosPregunta1.map(item => item.medio),
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    stack: 'pregunta1'
                },
                {
                    label: 'Pregunta 1 - Bajo',
                    data: datosPregunta1.map(item => item.bajo),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    stack: 'pregunta1'
                },
                {
                    label: 'Pregunta 2 - Alto',
                    data: datosPregunta2.map(item => item.alto),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    stack: 'pregunta2'
                },
                {
                    label: 'Pregunta 2 - Medio',
                    data: datosPregunta2.map(item => item.medio),
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    stack: 'pregunta2'
                },
                {
                    label: 'Pregunta 2 - Bajo',
                    data: datosPregunta2.map(item => item.bajo),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    stack: 'pregunta2'
                },
                {
                    label: 'Pregunta 3 - Alto',
                    data: datosPregunta3.map(item => item.alto),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    stack: 'pregunta3'
                },
                {
                    label: 'Pregunta 3 - Medio',
                    data: datosPregunta3.map(item => item.medio),
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    stack: 'pregunta3'
                },
                {
                    label: 'Pregunta 3 - Bajo',
                    data: datosPregunta3.map(item => item.bajo),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    stack: 'pregunta3'
                },
                {
                    label: 'Pregunta 4 - Alto',
                    data: datosPregunta4.map(item => item.alto),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    stack: 'pregunta4'
                },
                {
                    label: 'Pregunta 4 - Medio',
                    data: datosPregunta4.map(item => item.medio),
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    stack: 'pregunta4'
                },
                {
                    label: 'Pregunta 4 - Bajo',
                    data: datosPregunta4.map(item => item.bajo),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    stack: 'pregunta4'
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    stacked: true,
                    ticks: {
                        autoSkip: true // Evita que las etiquetas se omitan automáticamente
                    }
                }]
            }
        }
    });
}


// Función para obtener el nombre del mes
function obtenerNombreMes(mes) {
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    return meses[mes];
}


/*// Función para obtener la fecha formateada en formato 'YYYY-MM-DD'
function obtenerFechaFormateada(fecha) {
    let año = fecha.getFullYear();
    let mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Agregar ceros a la izquierda si es necesario
    let dia = fecha.getDate().toString().padStart(2, '0'); // Agregar ceros a la izquierda si es necesario
    return `${año}-${mes}-${dia}`;
}*/


function leerFechaRango() {
    let fechas = $('#filter_fecha_rango').val().split(' ... ')
    $('#filter_fecha_desde').val(fechas[0]);
    $('#filter_fecha_hasta').val(fechas[1]);
}

$(function () {
    // Inicializar el gráfico al cargar la página
    inicializarGrafico();

    // Manejar el evento de colapsar/expandir el card
    $('.box').on('shown.bs.collapse', function () {
        inicializarGrafico();
    }).on('hidden.bs.collapse', function () {
        destruirGrafico();
    });
});

// Función para inicializar el gráfico
function inicializarGrafico() {
    var ctx = document.getElementById('graficoServiciosCalificadosApilado').getContext('2d');
    // Aquí va tu código para inicializar el gráfico
}

// Función para destruir el gráfico
function destruirGrafico() {
    if (myChart) {
        myChart.destroy();
    }
}
