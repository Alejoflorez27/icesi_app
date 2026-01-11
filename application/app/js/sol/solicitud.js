$(document).ready(function () {

    $("body").addClass("sidebar-collapse");

    $('#modalAddSolicitud').on('shown.bs.modal', function() {
        const dropdownParent = $('#modalAddSolicitud');
        setTimeout(function() {
            $('#cliente').each(function() {
                $(this).select2('destroy').select2({ 
                    dropdownParent: dropdownParent,
                    width: '100%',
                    dropdownAutoWidth: true,
                    placeholder: 'Seleccione un Cliente',
                    allowClear: true
                });
            });
        }, 100);
    });


    // Inicializa DataTables
    var table = $('#resumen-servicios-evaluado').DataTable({
        paging: false,
        searching: false,
        info: true
    });

    // Evento blur para #numero_doc
    $('#numero_doc').blur(function() {
        var doc_candidato = $(this).val().trim();
        //console.log(doc_candidato);
        var token = getToken();
        var urlApi = url_site(`api/solicitud/consulta-srv_evaluado?doc_candidato=${doc_candidato}`);

        // Llama a la función para actualizar la tabla
        actualizarTablaConDatos('#resumen-servicios-evaluado', urlApi, token);
    });

    function actualizarTablaConDatos(idTabla, urlApi, token) {
        // Inicializa DataTables si no está ya inicializado
        var table = $(idTabla).DataTable();
    
        // Limpia la tabla antes de agregar nuevos datos
        table.clear().draw();
    
        $.ajax({
            method: 'GET',
            headers: {
                "access-token": token
            },
            url: urlApi,
            dataType: "json",
            success: function(resp) {
                console.log(resp);
                resp.data.forEach(srv => {
                    table.row.add([
                        srv.id_solicitud,
                        srv.nom_servicio,
                        srv.estado+" - "+srv.estado_proceso ?? '',
                        srv.fch_create
                    ]).draw(false);
                });
                if (resp.data.length > 0) {
                    $('#modalListResumenEvaluado').modal('show');
                    //$('#modalListResumen').modal('show');
                }
            },
            error: function() {
                console.error("Error al consultar los datos");
            },
            complete: function() {
                hideModalLoading();
            }
        });
    }

    //loadSelectOption para cargar los conceptos
    loadSelectOption({
        url: url_site(`api/configuracion/tipo_concepto_profesional`),
        input: [{
            id: 'concepto_final',                      //Nombre del campo en HTML
            clearOptions: true,
            emptyText: 'Seleccione Concepto',
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',  
        responsePath: ''
    })

    $(function () {
        // Ocultar filtros dependiendo del perfil
    
        var perfil_campo = document.getElementById('perfil_campo');
        var username = document.getElementById('username');
        //console.log(username);
    
        // Verificar la existencia de los elementos antes de manipularlos
        if (perfil_campo) {
            perfil_campo = perfil_campo.value;
            //console.log("perfil "+perfil_campo);
    
            // Filtro de combos para que no lo vea el proveedor
            var filterCombo = $('#filter_combo');
            if (filterCombo.length > 0 && (perfil_campo == 10 || perfil_campo == 11 || perfil_campo == 15 || perfil_campo == 16)) {
                filterCombo.parent().parent().hide();
            }

            if (perfil_campo == 13) {
                loadSelectOption({
                    url: url_site(`api/configuracion/destinatario_mensaje_calidad`),
                    input: [
                        {
                            id: 'para',
                            clearOptions: true,
                            selectedValue: ''
                        },
                    ],
                    columnKey: 'codigo',
                    columnDescription: 'descripcion',
                    responsePath: ''
                })
            }else if(perfil_campo == 10 || perfil_campo == 11 || perfil_campo == 15 || perfil_campo == 16){
                loadSelectOption({
                    url: url_site(`api/configuracion/destinatario_mensaje_proveedor`),
                    input: [
                        {
                            id: 'para',
                            clearOptions: true,
                            selectedValue: ''
                        },
                    ],
                    columnKey: 'codigo',
                    columnDescription: 'descripcion',
                    responsePath: ''
                })
            }else{
                loadSelectOption({
                    url: url_site(`api/configuracion/destinatario_mensaje`),
                    input: [
                        {
                            id: 'para',
                            clearOptions: true,
                            selectedValue: ''
                        },
                    ],
                    columnKey: 'codigo',
                    columnDescription: 'descripcion',
                    responsePath: ''
                })
            }
    
            // Filtro de canal de recepción para que no lo vea el cliente
            if (/*perfil_campo == 7 ||*/ perfil_campo == 8 || perfil_campo == 9) {
                //var campoOculto = document.getElementById("canal_recepcion");
                $('#canal_rep').hide();
                $('#filter_cliente').parent().parent().hide();
                $('#filter_subempresa').parent().parent().hide();

                //en este caso trae las subempresas y la tabla de los productos en caso de que corresponda a esa empresa
                //idEmpresa = $('#id_empresa_campo').val();
                var idEmpresa = document.getElementById('id_empresa_campo');
                idEmpresa = idEmpresa.value;
                //console.log(idEmpresa);
                // Crear un elemento de tipo select
                /*var selectElement = document.getElementById("cliente");
                // Establecer como solo lectura
                selectElement.disabled = true;*/

                //para revisar si es una subempresa
                $.ajax({
                    headers: {
                        "access-token": getToken()
                    },
                    type: "GET",
                    url: url_site(`api/solicitud/consultar-subempresa?id_empresa=${idEmpresa}`),
                    dataType: "json",
                    success: function (resp) {
                        //console.log(resp.data.id_empresa_padre);
                        if (resp.data.id_empresa_padre != null) {
                            //console.log(resp);
                            var padre = resp.data.id_empresa_padre;
                            /*// Crear un elemento de tipo select
                            var selectElement1 = document.getElementById("subEmpresa");
                            var selectElement2 = document.getElementById("responsable");
                            // Establecer como solo lectura
                            selectElement1.disabled = true;
                            selectElement2.disabled = true;*/
                            $.ajax({
                                type: "GET",
                                headers: { "access-token": getToken() },
                                url: url_site(`api/solicitud/consultar-subempresa?id_empresa=${idEmpresa}`),
                                dataType: "json",
                                async: false,
                                success: function (resp) {
                                    //console.log(resp.data.razon_social);
                                    // Obtén el elemento en JavaScript
                                    var mensajeElemento = document.getElementById('cliente_descripcion');
    
                                    // Define el texto que deseas establecer
                                    var texto = 'Cliente: '+resp.data.razon_social;
    
                                    // Establece el texto en el elemento usando innerHTML o textContent
                                    //mensajeElemento.innerHTML = texto; // Opción 1: innerHTML
                                    // O
                                    mensajeElemento.textContent = texto; // Opción 2: textContent
                                },
                            });
    
                            var divCliente = document.getElementById('ocultar');
                            divCliente.style.display = 'block';
    
                            var divCliente1 = document.getElementById('ocultar_empresa');
                            divCliente1.style.display = 'none';
                            
                            var divResponsable = document.getElementById('ocultar_responsable');
                            divResponsable.style.display = 'none';
    
    
                            var div1 = document.getElementById('ocultar_sub_empresa');
                            div1.style.display = 'none';

                            loadSelectOption({
                                url: url_site('api/empresa/empresa-padre-lista?estado=1'),
                                input: [{
                                    id: 'cliente',
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Cliente',
                                    selectedValue: resp.data.id_empresa_padre
                                },],
                                columnKey: 'id_empresa',
                                columnDescription: 'razon_social',
                                responsePath: 'data'
                            })
                            $('.div-subempresa').removeClass('hide');
                            loadSelectOption({
                                url: url_site(`api/empresa/subempresa?subEempresa=${resp.data.id_empresa_padre}`),
                                input: [{
                                    id: 'subEmpresa',
                                    clearOptions: true,
                                    emptyText: 'Seleccione una Sub-Empresa',
                                    selectedValue: idEmpresa
                                },],
                                columnKey: 'id_empresa',
                                columnDescription: 'razon_social',
                                responsePath: 'data'
                            })
                            loadSelectOption({
                                url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
                                input: [{
                                    id: 'responsable',
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Responsable',
                                    selectedValue: username.value
                                },],
                                columnKey: 'username',
                                columnDescription: 'responsable',
                                responsePath: 'data'
                            })

                            // Cargar tabla de productos cuando se levanta el modal
                            $('#modalAddSolicitud').on('shown.bs.modal', function () {
                                //cargarTablaProductos();
                                showModalLoading();
                                //En esta parte se carga la tabla de los productos que usa la empresa
                                let registros_tabla_productos = '<table>';
                                //hideModalLoading();
                            
                                $.ajax({
                                    type: "GET",
                                    headers: { "access-token": getToken() },
                                    url: url_site(`api/producto/productos-cliente?cliente=${padre}`),
                                    dataType: "json",
                                    success: function (resp) {
                                        resp.data?.forEach(p => {
                                            let registros_tabla_servicios = '';
                                            $.ajax({
                                                type: "GET",
                                                headers: { "access-token": getToken() },
                                                url: url_site(`api/servicio/producto-servicios?cliente=${padre}&producto=${p.id_producto}`),
                                                dataType: "json",
                                                async: false,
                                                success: function (resp) {
                                                    //console.log('hola',resp);
                                                    resp.data?.forEach(s => {
                                                        registros_tabla_servicios +=
                                                            `<tr>
                                                                <td><input type="checkbox" class="servicio"  name="servicio_sel[]"  servicio=${s.id_servicio} value="${s.id_servicio}"></td>
                                                                <td>&nbsp;${s.nom_servicio}</td>
                                                            </tr>`;
                                                    });
                                                },
                                            });

                                            registros_tabla_productos +=
                                                `<tr>
                                                    <td></td>
                                                    <td>${p.nom_prod}</td>
                                                    <td>
                                                        <table>${registros_tabla_servicios}</table>
                                                    </td>
                                                </tr>`;
                                        });

                                        registros_tabla_productos += '</table>';
                                        $('#productos').html(registros_tabla_productos);
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
                            });

                        } else {

                            $.ajax({
                                type: "GET",
                                headers: { "access-token": getToken() },
                                url: url_site(`api/solicitud/consultar-subempresa?id_empresa=${idEmpresa}`),
                                dataType: "json",
                                async: false,
                                success: function (resp) {
                                    //console.log(resp.data.razon_social);
                                    // Obtén el elemento en JavaScript
                                    var mensajeElemento = document.getElementById('cliente_descripcion');
    
                                    // Define el texto que deseas establecer subempresa
                                    var texto = 'Cliente: '+resp.data.razon_social;
    
                                    // Establece el texto en el elemento usando innerHTML o textContent
                                    //mensajeElemento.innerHTML = texto; // Opción 1: innerHTML
                                    // O
                                    mensajeElemento.textContent = texto; // Opción 2: textContent
                                },
                            });
    
                            var divCliente = document.getElementById('ocultar');
                            divCliente.style.display = 'block';
    
                            var divCliente1 = document.getElementById('ocultar_empresa');
                            divCliente1.style.display = 'none';
                            
                            var divResponsable = document.getElementById('ocultar_responsable');
                            //divResponsable.style.display = 'none';
    
    
                            var div1 = document.getElementById('ocultar_sub_empresa');
                            //div1.style.display = 'none';

                            /*// Crear un elemento de tipo select
                            var selectElement2 = document.getElementById("responsable");
                            // Establecer como solo lectura
                            selectElement2.disabled = true;*/

                            var div1 = document.getElementById('ocultar_sub_empresa');
                            //div1.style.display = 'none';

                            //console.log('hola empresa');
                            //console.log(resp.data.id_empresa_padre);
                            //let cliente = $('#cliente').val(idEmpresa);
                            loadSelectOption({
                                url: url_site('api/empresa/empresa-padre-lista?estado=1'),
                                input: [{
                                    id: 'cliente',
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Cliente',
                                    selectedValue: idEmpresa
                                },],
                                columnKey: 'id_empresa',
                                columnDescription: 'razon_social',
                                responsePath: 'data'
                            })

                            loadSelectOption({
                                url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
                                input: [{
                                    id: 'responsable',
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Responsable',
                                    selectedValue: username.value
                                },],
                                columnKey: 'username',
                                columnDescription: 'responsable',
                                responsePath: 'data'
                            })

                            loadSelectOption({
                                url: url_site(`api/combo/combo-cliente?id_empresa=${idEmpresa}`),
                                input: [{
                                    id: 'combo',
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Combo',
                                    selectedValue: ''
                                },],
                                columnKey: 'id_combo',
                                columnDescription: 'nom_combo',
                                responsePath: 'data'
                            })

                            $('#subEmpresa').on('change', function () {
                                let subEmpresa = $('#subEmpresa').val();
                                if (subEmpresa == "" || subEmpresa == null) {
                                    idEmpresa = $('#cliente').val();
                                } else {
                                    idEmpresa = $('#subEmpresa').val();
                                }

                                loadSelectOption({
                                    url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
                                    input: [{
                                        id: 'responsable',
                                        clearOptions: true,
                                        emptyText: 'Seleccione un Responsable',
                                        selectedValue: ''
                                    },],
                                    columnKey: 'username',
                                    columnDescription: 'responsable',
                                    responsePath: 'data'
                                })
                            })


                            //showModalLoading();
                            $.ajax({
                                method: 'GET',
                                headers: {
                                    "access-token": getToken()
                                },
                                type: "GET",
                                url: url_site(`api/empresa?id_empresa=${idEmpresa}`),
                                dataType: "json",
                                success: function (resp) {
                                    if (resp.data.flag_subemp == 1) {
                                        $('.div-subempresa').removeClass('hide');
                                        loadSelectOption({
                                            url: url_site(`api/empresa/subempresa?subEempresa=${resp.data.id_empresa}`),
                                            input: [{
                                                id: 'subEmpresa',
                                                clearOptions: true,
                                                emptyText: 'Seleccione una Sub-Empresa',
                                                selectedValue: ''
                                            },],
                                            columnKey: 'id_empresa',
                                            columnDescription: 'razon_social',
                                            responsePath: 'data'
                                        })
                                    } else {
                                        if (resp.data.flag_grup == 1) {
                                            $('.div-tercero').removeClass('hide');
                                            loadSelectOption({
                                                url: url_site(`api/empresa/tercero?empresa=${resp.data.id_empresa}`),
                                                input: [{
                                                    id: 'tercero',
                                                    clearOptions: true,
                                                    emptyText: 'Seleccione una Sub-Empresa',
                                                    selectedValue: ''
                                                },],
                                                columnKey: 'id_tercero',
                                                columnDescription: 'nom_tercero',
                                                responsePath: 'data'
                                            })
                                        }
                                    }
                                }

                            }).done(function () {
                                hideModalLoading();
                            });

                            // Cargar tabla de productos cuando se levanta el modal
                            $('#modalAddSolicitud').on('shown.bs.modal', function () {
 
                                //cargarTablaProductos();
                                showModalLoading();
                                //En esta parte se carga la tabla de los productos que usa la empresa
                                let registros_tabla_productos = '<table>';
                                //hideModalLoading();
                            
                                $.ajax({
                                    type: "GET",
                                    headers: { "access-token": getToken() },
                                    url: url_site(`api/producto/productos-cliente?cliente=${idEmpresa}`),
                                    dataType: "json",
                                    success: function (resp) {
                                        resp.data?.forEach(p => {
                                            let registros_tabla_servicios = '';
                                            $.ajax({
                                                type: "GET",
                                                headers: { "access-token": getToken() },
                                                url: url_site(`api/servicio/producto-servicios?cliente=${idEmpresa}&producto=${p.id_producto}`),
                                                dataType: "json",
                                                async: false,
                                                success: function (resp) {
                                                    //console.log('hola',resp);
                                                    resp.data?.forEach(s => {
                                                        registros_tabla_servicios +=
                                                            `<tr>
                                                                <td><input type="checkbox" class="servicio"  name="servicio_sel[]"  servicio=${s.id_servicio} value="${s.id_servicio}"></td>
                                                                <td>&nbsp;${s.nom_servicio}</td>
                                                            </tr>`;
                                                    });
                                                },
                                            });

                                            registros_tabla_productos +=
                                                `<tr>
                                                    <td></td>
                                                    <td>${p.nom_prod}</td>
                                                    <td>
                                                        <table>${registros_tabla_servicios}</table>
                                                    </td>
                                                </tr>`;
                                        });

                                        registros_tabla_productos += '</table>';
                                        $('#productos').html(registros_tabla_productos);
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
                            });
                            
                        }
                    }
                }).done(function () {
                    hideModalLoading();
                });


                } else {
                    // Si la condición no se cumple, muestra el campo de cliente
                    $('#filter_cliente').parent().parent().show();

                    $('#filter_subempresa').parent().parent().hide();



                    if(perfil_campo == 7){
                        var idEmpresa = document.getElementById('id_empresa_campo');
                        idEmpresa = idEmpresa.value;
                        //$('#filter_subempresa').parent().parent().hide();
                        
                        $.ajax({
                            headers: {
                                "access-token": getToken()
                            },
                            type: "GET",
                            url: url_site(`api/solicitud/consultar-subempresa?id_empresa=${idEmpresa}`),
                            dataType: "json",
                            success: function (resp) {
                                console.log(resp.data);
                                if (resp.data.id_empresa_padre != null) {
                                    $('#filter_subempresa').parent().parent().hide();
                                } else if ((resp.data.id_empresa_padre == null) && resp.data.flag_subemp == 1) {
                                    $('#filter_subempresa').parent().parent().show();
                                }                                 
                            },
                        });
                        
                        $('#canal_rep').hide();

                        $('.btnAddSolicitud').on('click', function () {

                            var idEmpresa = document.getElementById('id_empresa_campo');
                            idEmpresa = idEmpresa.value;

                            //console.log(idEmpresa);

                            //para revisar si es una subempresa
                            $.ajax({
                                headers: {
                                    "access-token": getToken()
                                },
                                type: "GET",
                                url: url_site(`api/solicitud/consultar-subempresa?id_empresa=${idEmpresa}`),
                                dataType: "json",
                                success: function (resp) {
                                    //console.log(resp.data.id_empresa_padre);
                                    if (resp.data.id_empresa_padre != null) {
                                        //console.log(resp);
                                        //console.log(1);
                                        var padre = resp.data.id_empresa_padre;
                                        loadSelectOption({
                                            url: url_site(`api/empresa/empresa-padre-lista-by?estado=1&id_empresa=${padre}`),
                                            input: [{
                                                id: 'cliente',
                                                clearOptions: false,
                                                emptyText: 'Seleccione un Cliente',
                                                selectedValue: padre
                                            },],
                                            columnKey: 'id_empresa',
                                            columnDescription: 'razon_social',
                                            responsePath: 'data'
                                        })

                                    } else if ((resp.data.id_empresa_padre == null)) {
                                        //console.log(2);

                                        loadSelectOption({
                                            url: url_site(`api/empresa/empresa-padre-lista-by?estado=1&id_empresa=${idEmpresa}`),
                                            input: [{
                                                id: 'cliente',
                                                clearOptions: false,
                                                emptyText: 'Seleccione un Cliente',
                                                selectedValue: idEmpresa
                                            },],
                                            columnKey: 'id_empresa',
                                            columnDescription: 'razon_social',
                                            responsePath: 'data'
                                        })

                                    }                                 
                                },
                            });

                        });



                    } else{
                        loadSelectOption({
                            url: url_site('api/empresa/empresa-padre-lista?estado=1'),
                            input: [{
                                id: 'cliente',
                                clearOptions: true,
                                emptyText: 'Seleccione un Cliente',
                                selectedValue: ''
                            },],
                            columnKey: 'id_empresa',
                            columnDescription: 'razon_social',
                            responsePath: 'data'
                        })
                    }

                    $('#cliente').on('change', function () {
                        $('.div-subempresa').addClass('hide');
                        $('.div-tercero').addClass('hide');
                
                        idEmpresa = $('#cliente').val();
                
                        loadSelectOption({
                            url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
                            input: [{
                                id: 'responsable',
                                clearOptions: true,
                                emptyText: 'Seleccione un Responsable',
                                selectedValue: ''
                            },],
                            columnKey: 'username',
                            columnDescription: 'responsable',
                            responsePath: 'data'
                        })
                
                        loadSelectOption({
                            url: url_site(`api/combo/combo-cliente?id_empresa=${idEmpresa}`),
                            input: [{
                                id: 'combo',
                                clearOptions: true,
                                emptyText: 'Seleccione un Combo',
                                selectedValue: ''
                            },],
                            columnKey: 'id_combo',
                            columnDescription: 'nom_combo',
                            responsePath: 'data'
                        })
                
                        $('#subEmpresa').on('change', function () {
                            let subEmpresa = $('#subEmpresa').val();
                            if (subEmpresa == "" || subEmpresa == null) {
                                idEmpresa = $('#cliente').val();
                            } else {
                                idEmpresa = $('#subEmpresa').val();
                            }
                
                            loadSelectOption({
                                url: url_site(`api/empresa/responsable?empresa=${idEmpresa}`),
                                input: [{
                                    id: 'responsable',
                                    clearOptions: true,
                                    emptyText: 'Seleccione un Responsable',
                                    selectedValue: ''
                                },],
                                columnKey: 'username',
                                columnDescription: 'responsable',
                                responsePath: 'data'
                            })
                        })
                
                
                        //showModalLoading();
                        $.ajax({
                            method: 'GET',
                            headers: {
                                "access-token": getToken()
                            },
                            type: "GET",
                            url: url_site(`api/empresa?id_empresa=${idEmpresa}`),
                            dataType: "json",
                            success: function (resp) {
                                if (resp.data.flag_subemp == 1) {
                                    $('.div-subempresa').removeClass('hide');
                
                                    //alejo paso
                                    loadSelectOption({
                                        url: url_site(`api/empresa/subempresa?subEempresa=${resp.data.id_empresa}`),
                                        input: [{
                                            id: 'subEmpresa',
                                            clearOptions: true,
                                            emptyText: 'Seleccione una Sub-Empresa',
                                            selectedValue: ''
                                        },],
                                        columnKey: 'id_empresa',
                                        columnDescription: 'razon_social',
                                        responsePath: 'data'
                                    })
                                } else {
                                    if (resp.data.flag_grup == 1) {
                                        $('.div-tercero').removeClass('hide');
                                        loadSelectOption({
                                            url: url_site(`api/empresa/tercero?empresa=${resp.data.id_empresa}`),
                                            input: [{
                                                id: 'tercero',
                                                clearOptions: true,
                                                emptyText: 'Seleccione una Sub-Empresa',
                                                selectedValue: ''
                                            },],
                                            columnKey: 'id_tercero',
                                            columnDescription: 'nom_tercero',
                                            responsePath: 'data'
                                        })
                                    }
                                }
                            }
                
                        }).done(function () {
                            hideModalLoading();
                        });
                    });
                
                
                    $('#cliente').on('change', function () {
                        let cliente = $('#cliente').val();
                        let registros_tabla_productos = '<table>';
                
                        $.ajax({
                            type: "GET",
                            headers: { "access-token": getToken() },
                            url: url_site(`api/producto/productos-cliente?cliente=${cliente}`),
                            dataType: "json",
                            success: function (resp) {
                                resp.data?.forEach(p => {
                                    let registros_tabla_servicios = '';
                                    $.ajax({
                                        type: "GET",
                                        headers: { "access-token": getToken() },
                                        url: url_site(`api/servicio/producto-servicios?cliente=${cliente}&producto=${p.id_producto}`),
                                        dataType: "json",
                                        async: false,
                                        success: function (resp) {
                                            resp.data?.forEach(s => {
                                                registros_tabla_servicios +=
                                                    `<tr>
                                                        <td><input type="checkbox" class="servicio"  name="servicio_sel[]"  servicio=${s.id_servicio} value="${s.id_servicio}"></td>
                                                        <td>&nbsp;${s.nom_servicio}</td>
                                                    </tr>`;
                                            });
                                        },
                                    });
                
                                    registros_tabla_productos +=
                                        `<tr>
                                            <td></td>
                                            <td>${p.nom_prod}</td>
                                            <td>
                                                <table>${registros_tabla_servicios}</table>
                                            </td>
                                        </tr>`;
                                });
                
                                registros_tabla_productos += '</table>';
                                $('#productos').html(registros_tabla_productos);
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
                    });
                }
            }
    });

    let filtro = new URLSearchParams(location.search);
    let estado = filtro.get('estado') || '';
    $('#estado-filtro-solicitud').html((estado == '') ? 'Todas' : estado.initCap());
    if (estado != '') {
        $('#filter_estado').val(estado).change();
    }

    cargarTablaSolicitudes();
    cboLoad('canal_recepcion', url_site(`api/configuracion/canal_recepcion`), '', true, 'Seleccione un canal de recepción');

    loadSelectOption({
        url: url_site(`api/configuracion/tipo_identificacion`),
        input: [{
            id: 'tipo_id',
            clearOptions: true,
            emptyText: 'Seleccione un tipo de documento',
            selectedValue: ''
        },
        {
            id: 'tipo_id_edit',
            clearOptions: true,
            selectedValue: ''
        },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',
        responsePath: ''
    })

    //Perfil que trae el usuario
    //perfil_campo
    //console.log(perfil_campo.value);
/*
    var id_empresa_campo = document.getElementById('id_empresa_campo');
    //console.log(id_empresa_campo.value);
    
    if (id_empresa_campo.value != "") {
        
    } else {
        loadSelectOption({
            url: url_site('api/empresa/empresa-padre-lista?estado=1'),
            input: [{
                id: 'cliente',
                clearOptions: true,
                emptyText: 'Seleccione un Cliente',
                selectedValue: ''
            },],
            columnKey: 'id_empresa',
            columnDescription: 'razon_social',
            responsePath: 'data'
        })
    }
*/

    loadSelectOption({
        url: url_site(`api/ubicacion/pais`),
        input: [{
            id: 'pais',
            clearOptions: true,
            emptyText: 'Seleccione País',
            selectedValue: ''
        },
        {
            id: 'pais_edit',
            clearOptions: true,
            selectedValue: ''
        },
        ],
        columnKey: 'id_pais',
        columnDescription: 'nombre',
        responsePath: 'data'
    })

    $('#pais').on('change', function () {
        let pais = $('#pais').val();

        loadSelectOption({
            url: url_site(`api/ubicacion/dto?idPais=${pais}`),
            input: [{
                id: 'departamento',
                clearOptions: true,
                emptyText: 'Seleccione Dpto',
                selectedValue: ''
            },],
            columnKey: 'id_dpto',
            columnDescription: 'nombre',
            responsePath: 'data'
        })
    })
/*
    loadSelectOption({
        url: url_site(`api/configuracion/destinatario_mensaje`),
        input: [
            {
                id: 'para',
                clearOptions: true,
                selectedValue: ''
            },
        ],
        columnKey: 'codigo',
        columnDescription: 'descripcion',
        responsePath: ''
    })
*/

    $('#departamento').on('change', function () {
        let dpto = $('#departamento').val();

        loadSelectOption({
            url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),
            input: [{
                id: 'id_ciudad_act',
                clearOptions: true,
                emptyText: 'Seleccione Ciudad',
                selectedValue: ''
            },],
            columnKey: 'id_ciudad',
            columnDescription: 'nombre',
            responsePath: 'data'
        })
    })

    $('#id_ciudad_act').on('change', function () {
        let ciudad = $('#id_ciudad_act').val();
        // Si la ciudad es BOGOTÁ muestra el campo Localidad, de lo contrario lo oculta
        if (ciudad == 149) {
            $('.div-localidad').removeClass('hide');
        } else {
            $('.div-localidad').addClass('hide');
        }

    })

    //Inicio lógica filtros
    //Inicio lógica filtros
    $('#filter_fecha_rango').daterangepicker({
        timePicker: true,
        timePickerIncrement: 1,
        timePicker24Hour: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm',
            "separator": " ... ",
            "daysOfWeek": ["D", "L", "M", "X", "J", "V", "S"]
        },
        startDate: moment().subtract(6, 'months'), // Hace 6 meses desde hoy
        endDate: moment(), // Hoy
        maxDate: moment(), // No permitir fechas futuras
    });

    $('#filter_fecha_rango').change(function () {
        leerFechaRango();
    });

    $('#tbl-solicitudes').on('click', '.btnDetalleSolicitud', function () {
        ver_solicitud($(this))
    })

    $('.btnDetalleSolicitud').on('click', function () {
        ver_solicitud($(this))
    })

    $('#btnBuscar').on('click', function () {
        cargarTablaSolicitudes();
    });
    // Fin Lógica filtros


    $(".btnAsignarServicio").on("click", function () {
        /**
         * ASIGNAR SERVICIO
         */

        $('#accion').val("ASIGNAR");
        accionFormEditar($(this));

        $('#modalAddServicio').modal();
        $('.div-asignar').removeClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');
        $('.div-asistio').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');
    })

    $(".btnProgramarServicio").on("click", function () {
        /**
         * PROGRAMAR SERVICIO
         */
        $('#accion').val("PROGRAMAR");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-programar').removeClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-asistio').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');
    })


    $(".btnAsistioServicio").on("click", function () {
        /**
         * ASISTIÓ SERVICIO
         */
        $('#accion').val("ASISTIO");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-asistio').removeClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');
    })


    $(".btnContinuarProceso").on("click", function () {
        /**
         * CONT PROCESO
         */
        $('#accion').val("PROCESO");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-proceso').removeClass('hide');
        $('.div-asistio').addClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');
    })




    $(".btnObservacionServicio").on("click", function () {
        /**
         * OBSERVACION / NOVEDAD SERVICIO
         */
        $('#accion').val("OBSERVACION");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-observacion').removeClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');

        $('.div-asistio').addClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');
    })

    $(".btnMensaje").on("click", function () {
        /**
         * MENSAJE
         */
        $('#accion').val("MENSAJE");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-mensaje').removeClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');

        // $('.div-valor-adicional').removeClass('hide');

        $('.div-asistio').addClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');

    })

    $(".btnValorAdicional").on("click", function () {
        $('#formServicioSolicitud')[0].reset();
        /**
         * VALOR ADICIONAL
         */

        //Aqui se va a validar si existe si si lo trae editar sino crear
        let id_solicitudC = $(this).attr('idsolicitud');
        let id_servicioC = $(this).attr('idservicio');

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/solicitud/consultar-val-adicional?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`),
            dataType: "json",
            
            success: function (resp) {
                //console.log(resp.data.id);
                if (resp.data != null) {
                    $('#idServicioAdicional').val(resp.data.id);
                    $('#valor_adicional_s').val(resp.data.valor);
                    $('#observacion_adicional_s').val(resp.data.observacion);
                    //console.log(resp.data.id);
                }
                
                /*if (resp.data != null) { //if para actualizar la pregunta de alcohol
                    
                    $('#id_admision').val(resp.data.id_admision);
                    $('#resumen').val(resp.data.resumen);
        
        
                    opcion = resp.data.id_admision
                    
                        //envio de Accion PUT
                        $('.btnAddObservacion').on('click', function () {
                            $('#accion').val("PUT");
                        });
        
                        // Editar Observacion 
                        $('#btn-submit-observacion').on('click', function (e) {
                            e.preventDefault();
        
                        //if (validateFormVivProtocoloSeguridad()) {
        
                            let method = $('#accion').val(); //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
        
                            let data = {
                                id_admision: $('#id_admision').val(),
                                resumen: $('#resumen').val(),
                            }
        
                            //console.log(data);
        
                            $.ajax({
                                method: method,
                                headers: {
                                "access-token": getToken()
                                },
                                url: url_site(`api/admisionesPolPre/update_admision_pol_pre?id_tecnica=${opcion}`),
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                dataType: "json",
                                success: function (cand) {
                        
                                    alertSwal('success', 'Admisiones', 'Actualizado satisfactoriamente')
                                    //window.location = url_site(`admisiones_pol_pre?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                        
                                },
                                error: function (xhr, status, error) {
                                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                                },
                                complete: function () {
                                    hideModalLoading();
                                }
                            });
                            //}
                        });
                } else{
                    //console.log(3000);
                        //envio de Accion POST
                        $('.btnAddObservacion').on('click', function () {
                        $('#accion').val("POST");
                        });
                
                        // Crear protocolo de seguridad de la vivienda
                        $('#btn-submit-observacion').on('click', function (e) {
                        e.preventDefault(e);
                
                        //if (validateFormVivProtocoloSeguridad()) {
                
                        let method = $('#accion').val();
                        let data = {
                            id_admision: $('#id_admision').val(),
                            id_solicitud: id_solicitudC,
                            id_servicio: id_servicioC,
                            resumen: $('#resumen').val(),
                        }
                        //console.log(data);
                        $.ajax({
                            method: method,
                            headers: {
                                "access-token": getToken()
                            },
                            url: url_site(`api/admisionesPolPre/crear_admision_pol_pre?id_admision=${data.id_admision}`),
                            contentType: 'application/json',
                            data: JSON.stringify(data),
                            dataType: "json",
                            success: function (r) {
                                if (r.status == "success") {
                                    alertSwal('success', 'Resultado', 'guardado satisfactoriamente');
                                    $('#formObservacion')[0].reset();
                                    window.location = url_site(`admisiones_pol_pre?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
                                } else {
                                        alertSwal('error', 'Admisiones', r.code.code);
                                    
                                }
                            },
                            error: function (xhr, status, error) {
                                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                            },
                            complete: function () {
                                hideModalLoading();
                            }
                        });//ajax
                    //}
                    });// Fin de Crear Preguntas de produccion de Drogas
                }*/
            }
        });

        // Aqui se va a validar si existe si si lo trae editar sino crear fin


        $('#accion').val("VALOR-ADICIONAL");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-valor-adicional').removeClass('hide');

        $('.div-mensaje').addClass('hide');
        $('.div-guardar').addClass('hide');
        $('.div-agregar-servicio').addClass('hide');
        $('.div-asistio').addClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-finalizar').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-calificacion').addClass('hide');

    })

    $(".btnCalificarServicio").on("click", function () {
        /**
         * CALIFICAR
         */
        $('#accion').val("CALIFICAR");
        accionFormEditar($(this));

        $('#modalAddServicio').modal();
        $('.div-calificacion').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');
        $('#titulo-modal-servicio').html('Calificar Servicio');

        $('.div-finalizar').addClass('hide');

        $('.div-asistio').addClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
    })


    $(".btnFinalizarServicio").on("click", function () {
        /**
         * FINALIZAR
         */
        $('#accion').val("FINALIZAR");
        accionFormEditar($(this));
        $('#modalAddServicio').modal();
        $('.div-finalizar').removeClass('hide');
        $('.div-guardar').removeClass('hide');
        $('.div-agregar-servicio').removeClass('hide');

        $('.div-asistio').addClass('hide');
        $('.div-programar').addClass('hide');
        $('.div-asignar').addClass('hide');
        $('.div-concepto').addClass('hide');
        $('.div-agregar').addClass('hide');
        $('.div-nivel').addClass('hide');
        $('.div-mensaje').addClass('hide');
        $('.div-observacion').addClass('hide');
        $('.div-valor-adicional').addClass('hide');
        $('.div-calificacion').addClass('hide');
    })

    // CANCELAR SERVICIO
    $(".btnCancelarServicio").on("click", function () {
        let params = new URLSearchParams(location.search);
        let IdSolicitud = params.get('solicitud');
        idServicio = $(this).attr('idServicio');

        Swal.fire({
            type: 'question',
            title: `Cancelar Servicio`,
            text: `¿Está seguro de Cancelar este Servicio?`,
            input: 'text',
            inputAttributes: {
                id: 'motivo_cancelado',
                name: 'motivo_cancelado',
                required: 'true',
                autocapitalize: 'off',
                placeholder: 'Motivo Cancelación'
            },
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = 'PATCH'
                let motivo_cancelado = $('#motivo_cancelado').val();
                let data = {
                    id: IdSolicitud,
                    motivo_cancelado: motivo_cancelado,
                }
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/cancelar-servicio?solicitud=${IdSolicitud}&servicio=${idServicio}&motivo=${motivo_cancelado}`),
                    contentType: 'application/json',
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwalR('success', 'Servicio', 'Servicio Cancelado satisfactoriamente', '');
                        } else {
                            alertSwal('error', 'Servicio', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });

    })


    // CANCELAR ASIGNACION
    $(".btnCancelarAsignacion").on("click", function () {
        let params = new URLSearchParams(location.search);
        let IdSolicitud = params.get('solicitud');
        idServicio = $(this).attr('idServicio');

        Swal.fire({
            icon: 'question',
            title: `Cancelar Asignación`,
            text: `¿Está seguro de Cancelar la asignación?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/cancelar-asignacion?solicitud=${IdSolicitud}&servicio=${idServicio}`),
                    contentType: 'application/json',
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwalR('success', 'Servicio', 'Asignación Cancelada satisfactoriamente', '');
                        } else {
                            alertSwal('error', 'Servicio', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });
    });



    // Finalizar Solicitud
    $('#tbl-det-solicitud').on('click', '.btnFinalizarSolicitud', function () {
        $('#accion').val("PATCH");
        let params = new URLSearchParams(location.search);
        let IdSolicitud = params.get('solicitud');
        let IdCliente = params.get('cliente');

        Swal.fire({
            type: 'question',
            title: `Finalizar Solicitud`,
            text: `¿Esta seguro de finalizar esta solicitud?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = 'PATCH'
                let data = {
                    id: IdSolicitud,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/finalizar?solicitud=${IdSolicitud}&cliente=${IdCliente}`),
                    contentType: 'application/json',
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwalR('success', 'Solicitud', 'Solicitud finalizada satisfactoriamente', '');
                            window.location = url_site(`solicitud/detalle?solicitud=${IdSolicitud}&cliente=${IdCliente}`)
                        } else {
                            alertSwal('error', 'Solicitud', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });
    })

    // Cancelar Solicitud
    $('#tbl-det-solicitud').on('click', '.btnCancelarSolicitud', function () {
        $('#accion').val("PUT");
        let id_solicitud = $(this).attr('solicitud');

        Swal.fire({
            type: 'question',
            title: `Cancelar Solicitud`,
            text: `¿Está seguro de Cancelar  esta solicitud?`,
            input: 'text',
            inputAttributes: {
                id: 'motivo_cancelacion',
                name: 'motivo_cancelacion',
                required: 'true',
                autocapitalize: 'off',
                placeholder: 'Motivo Cancelación'
            },
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let motivo_cancelacion = $('#motivo_cancelacion').val();
                let data = {
                    id_solicitud: id_solicitud,
                    motivo_cancelacion: motivo_cancelacion,
                }
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/cancelar-solicitud?id_solicitud=${id_solicitud}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Solicitud', 'La Solicitud se canceló satisfactoriamente');
                            $('#formSolicitud')[0].reset();
                            window.location.reload();
                        } else {
                            alertSwal('error', 'Solicitud', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });
    })

    // Reenviar Correo
    $('#tbl-det-solicitud').on('click', '.btnReenviarCorreo', function () {
        $('#accion').val("PUT");
        let id_solicitud = $(this).attr('solicitud');

        Swal.fire({
            type: 'question',
            title: `Reenviar Correo`,
            text: `¿Está seguro de Reenviale el correo al Candidato?`,
            confirmButtonText: 'Sí',
            showCancelButton: true,
            cancelButtonText: 'No',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_solicitud: id_solicitud,
                }
                $.ajax({
                    method: 'PUT',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/reenviar-correo?id_solicitud=${id_solicitud}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Reenviar Correo', 'El correo se envió satisfactoriamente');
                        } else {
                            alertSwal('error', 'Reenviar Correo', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });
    })

    // Cargar Archivo Solicitud
    $('#tbl-det-solicitud').on('click', '.btnAgregarArchivoSolicitud', function () {
        $('#frmCargarArchivo')[0].reset();
        var idSolicitud = $(this).attr("solicitud");
        $('#solicitud-archivo').val(idSolicitud);
        $('#api-recurso').val('solicitud');
        $('#modalCargarArchivo').modal();
        $('#info').html("");
    })

    // Cargar Archivo Servivio
    $(".btnAgregarArchivoServicio").on("click", function () {
        $('#frmCargarArchivo')[0].reset();
        var idServicio = $(this).attr("idServicio");
        $('#servicio_archivo').val(idServicio);
        $('#api-recurso').val('solicitud-servicio');
        $('#modalCargarArchivo').modal();
        $('#info').html("");
    });

    // IR A FORMATO
    $(".btnIrAFormato").on("click", function () {

        let params = new URLSearchParams(location.search);
        let solicitudId = params.get('solicitud');
        var idServicio = $(this).attr("idServicio");
        var ruta = $(this).attr("ruta");
        window.location = url_site(ruta + `?id_solicitud=${solicitudId}&id_servicio=${idServicio}`);

    });

    // IR A PDF A NIVEL DE SERVICIO

    $(".btnIrPdf").on("click", function () {

        let params = new URLSearchParams(location.search);
        let id_solicitud = params.get('solicitud');
        var idServicio = $(this).attr("idservicio");
        var idcombo = null;
        var rutaInforme = 'InformeMain';
        window.open('../api/solicitud/imprimir-pdf' + `?id_sl=${id_solicitud}&id_sv=${idServicio}&id_combo=${idcombo}&rI=${rutaInforme}`+ "#zoom=125", '_blank');
    });

    // IR A PDF solicitud combo

    $(".btnIrPdfSolCombo").on("click", function () {

        //se obtiene por URL
        let params = new URLSearchParams(location.search);
        //let id_solicitud = params.get('solicitud');
        var idServicio = $(this).attr("idservicio");
        //console.log(id_solicitud);

        // Seleccionar el botón por su clase
        var btnIrPdfSolCombo = document.querySelector('.btnIrPdfSolCombo');

        // Obtener los atributos personalizados
        var solicitudId = btnIrPdfSolCombo.getAttribute('solicitud');
        var comboId = btnIrPdfSolCombo.getAttribute('combo');
        var rutaInforme = btnIrPdfSolCombo.getAttribute('rutaInforme');

        // Puedes usar estos valores como necesites, por ejemplo, imprimirlos en la consola
        console.log('ID de solicitud:', solicitudId);
        console.log('ID de combo:', comboId);
        console.log('Ruta del informe:', rutaInforme);

        //var rutaInforme = $(this).attr("rutaInforme");
        var rutaInforme = 'InformeMain';
        window.open('../api/solicitud/imprimir-pdf' + `?id_sl=${solicitudId}&id_sv=${idServicio}&id_combo=${comboId}&rI=${rutaInforme}`+ "#zoom=125", '_blank');
        //window.open('../api/solicitud/imprimir-pdf' + `?id_sl=${solicitudId}&id_sv=${comboId}&rI=${rutaInforme}`, '_blank');
        

    });

    // Ir a la imagen seleccionada

    $(".btnVisualizar").on("click", function () {
        // Obtener el valor de data-file-digital del botón clicado
        let fileDigital = $(this).data("file-digital");
    
        // Resto de tu lógica aquí...
        //console.log(fileDigital);
    
        // Puedes usar fileDigital en tu lógica, por ejemplo:
        window.open('../api/solicitud/mostrar_adjuntos' + `?imagen=${fileDigital}`, '_blank');
    });


    $('#archivo').on('change', function () {
        var archivo = document.getElementById('archivo').files[0];
        $('#info').html(`<h5> <strong>${archivo.name}</strong> <small> (${descripcionTamanoArchivo(archivo.size)})</small> </h5>`);
    });

    $('#btnCargarArchivo').click(function () {
        $("#frmCargarArchivo").submit();
        let params = new URLSearchParams(location.search);
        let solicitudId = params.get('solicitud');
        $('#id_solicitud').val(solicitudId);

    });

    $("#frmCargarArchivo").on('submit', function (e) {

        let params = new URLSearchParams(location.search);
        let solicitudId = params.get('solicitud');
        let id_servicio = $('#servicio_archivo').val();

        $('#id_solicitud').val(solicitudId);

        e.preventDefault();


        if (validarCamposCargue()) {
            showModalLoading()
            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                method: 'POST',
                url: url_site(`api/adjuntos/archivo`),
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Cargue', 'Cargue de archivo terminó correctamente.');
                        $('#frmCargarArchivo')[0].reset();
                        $('#modalCargarArchivo').modal('hide')
                        window.location.reload();
                    } else {
                        alertSwal('error', 'Cargue', r.code.code);
                    }
                }
            }).done(function () {
                hideModalLoading();
            });
        }

    });

    // Editar solicitud en el detalle
    $('#tbl-det-solicitud').on('click', '.btnEditSolicitud', function () {

        $('.div-editar').removeClass('hide');
        $('.div-add-srvadicionales').addClass('hide');
        $('.div-add-servicios').addClass('hide');

        $('#modalEditSolicitud').modal();
        $('#formEditSolicitud').removeClass('hide');

        $('#formAddServicio').addClass('hide');

        let params = new URLSearchParams(location.search);
        let solicitudId = params.get('solicitud');
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/solicitud/solicitud-editar?id_solicitud=${solicitudId}`),
            dataType: "json",
            success: function (resp) {
                $('#idSolicitud').val(resp.data.id_solicitud);
                $('#idCandidato').val(resp.data.id_candidato);
                $('#fecha_edit').val(resp.data.fch_solicitud);
                $('#responsable_edit').val(resp.data.nom_responsable);
                $('#cliente_edit').val(resp.data.razon_social);
                $('#combo_edit').val(resp.data.nom_combo);
                $('#tipo_id_edit').val(resp.data.tipo_id).change();
                $('#documento_edit').val(resp.data.numero_doc);
                $('#nombre_edit').val(resp.data.nombre);
                $('#apellido_edit').val(resp.data.apellido);
                $('#telefono_edit').val(resp.data.telefono);
                $('#correo_edit').val(resp.data.email);
                $('#direccion_edit').val(resp.data.direccion);
                $('#cargo_edit').val(resp.data.cargo_desempeno);
                $('#observacion_edit').val(resp.data.observacion);
                $('#localidad_edit').val(resp.data.localidad);
                //$('#departamento_edit').val(resp.data.id_dpto);

                //console.log(resp.data.id_dpto)

                /*loadSelectOption({
                    url: url_site(`api/ubicacion/pais?$idPais=${resp.data.id_pais}`),
                    input: [
                        {
                            id: 'pais_edit',
                            clearOptions: true,
                            selectedValue: ''
                        },
                    ],
                    columnKey: 'cod_pais',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })*/
                //alejo
                loadSelectOption({
                    //Consulta a la Api de ubicacion esto de Tipo GET
                    url: url_site(`api/ubicacion/pais?$idPais=${resp.data.id_pais}`),
                    input: [{
                        id: 'pais_edit',                         //Nombre del campo en HTML
                        clearOptions: true,
                        emptyText: 'Seleccione País',
                        selectedValue: resp.data.id_pais
                    },],
                    columnKey: 'id_pais',                   //Nombre de la PK del Pais de la tabla de conf_pais
                    columnDescription: 'nombre',            //Nombre del Campo de Descripcion de Pais
                    responsePath: 'data'                    //Respuesta de la data 
                });

                loadSelectOption({
                    //url: url_site(`api/ubicacion/dto?idPais=${resp.data.id_pais}&id_dpto=${resp.data.id_dpto}`),
                    url: url_site(`api/ubicacion/dto?idPais=${resp.data.id_pais}`),
                    input: [{
                        id: 'departamento_edit',
                        clearOptions: true,
                        selectedValue: ''
                    },],
                    columnKey: 'id_dpto',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })

                loadSelectOption({
                    url: url_site(`api/ubicacion/ciudad-id?idCiudad=${resp.data.id_ciudad_act}`),
                    input: [{
                        id: 'id_ciudad_act_edit',
                        clearOptions: true,
                        selectedValue: ''
                    },],
                    columnKey: 'id_ciudad',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })
                
                //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
                $('#pais_edit').on('change', function () {
                    let pais = $('#pais_edit').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                    console.log (pais);
                    $('#id_ciudad_act_edit').empty();

                    loadSelectOption({
                        url: url_site(`api/ubicacion/dto?idPais=${pais}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
                        input: [{
                            id: 'departamento_edit',
                            clearOptions: true,
                            emptyText: 'Seleccione Dpto',
                            selectedValue: resp.data.id_dpto 
                        },],
                        columnKey: 'id_dpto',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                        
                    })
                }); 

                $('#departamento_edit').on('change', function () {
                    let dpto = $('#departamento_edit').val();

                    loadSelectOption({
                        url: url_site(`api/ubicacion/ciudad?idDpto=${dpto}`),
                        input: [{
                            id: 'id_ciudad_act_edit',
                            clearOptions: true,
                            emptyText: 'Seleccione Ciudad',
                            selectedValue: resp.data.id_ciudad_act
                        },],
                        columnKey: 'id_ciudad',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                    })
                })
                $('#id_ciudad_act_edit').on('change', function () {
                    let idCiudad = $('#id_ciudad_act_edit').val();
                    if (idCiudad == 149) {
                        $('.div-localidad').removeClass('hide');
                    } else {
                        $('.div-localidad').addClass('hide');
                    }
                })
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalEditSolicitud').modal();
    })



    $('#tbl-det-solicitud').on('click', '.btnUpdCombo', function () {
        $('.div-editar').addClass('hide');
        $('.div-srvadicionales').addClass('hide');
        $('.div-add-srvadicionales').addClass('hide');

        $('#modalEditSolicitud').modal();
        $('#formEditSolicitud')[0].reset();
        $('#formEditSolicitud').removeClass('hide');

    })

    // Servicios Adicionales
    $('#tbl-det-solicitud').on('click', '.btnServiciosAdicionales', function () {
        $('#titulo-modal-edit-solicitud').html('Valor Servicios Adicionales');
        $('.div-add-srvadicionales').removeClass('hide');
        $('.div-editar').addClass('hide');


        $('#modalEditSolicitud').modal();
        $('#formEditSolicitud')[0].reset();
        $('#formEditSolicitud').removeClass('hide');

        let params = new URLSearchParams(location.search);
        let cliente = params.get('cliente');

        loadSelectOption({
            url: url_site(`api/combo/combo-cliente?id_empresa=${cliente}`),
            input: [{
                id: 'combo_upd',
                clearOptions: true,
                emptyText: 'Seleccione un Combo',
                selectedValue: ''
            },],
            columnKey: 'id_combo',
            columnDescription: 'nom_combo',
            responsePath: 'data'
        })
    })

    // Agregar Servicios
    $('#tbl-det-solicitud').on('click', '.btnAgregarServicios', function () {
        $('#titulo-modal-edit-solicitud').html('Agregar Servicios');
        $('.div-add-servicios').removeClass('hide');
        $('.div-add-srvadicionales').addClass('hide');
        $('.div-editar').addClass('hide');


        $('#modalEditSolicitud').modal();
        $('#formEditSolicitud')[0].reset();
        $('#formEditSolicitud').removeClass('hide');

        let params = new URLSearchParams(location.search);
        let cliente = params.get('cliente');
        let solicitud = params.get('solicitud');
        $('#idSolicitud').val(solicitud);
        

        let registros_tabla_productos = '<table>';
        $.ajax({
            type: "GET",
            headers: { "access-token": getToken() },
            url: url_site(`api/producto/productos-cliente-add?cliente=${cliente}&solicitud=${solicitud}`),
            dataType: "json",
            success: function (resp) {
                resp.data?.forEach(p => {
                    let registros_tabla_servicios = '';
                    $.ajax({
                        type: "GET",
                        headers: { "access-token": getToken() },
                        url: url_site(`api/servicio/producto-servicios?cliente=${cliente}&producto=${p.id_producto}`),
                        dataType: "json",
                        async: false,
                        success: function (resp) {
                            resp.data?.forEach(s => {
                                registros_tabla_servicios +=
                                    `<tr>
                                        <td><input type="checkbox" class="servicio"  name="servicio_sel[]"  servicio=${s.id_servicio} value="${s.id_servicio}"></td>
                                        <td>${s.nom_servicio}</td>
                                    </tr>`;
                            });
                        },
                    });

                    registros_tabla_productos +=
                        `<tr>
                            <td></td>
                            <td>${p.nom_prod}</td>
                            <td>
                                <table>${registros_tabla_servicios}</table>
                            </td>
                        </tr>`;
                });

                registros_tabla_productos += '</table>';
                $('#productos-edt').html(registros_tabla_productos);
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
    })

    // Guarda Agregar Servicios  ECQ
    $('#btn-add-srv').on('click', function (e) {
        $('.div-editar').addClass('hide');
        $('.div-srvadicionales').addClass('hide');
        $('.div-add-servicios').removeClass('hide');

        var solicitud = $('#idSolicitud').val();
        var form = document.getElementById('formEditSolicitud');
        var formData = new FormData(form);
        // let id_solicitud = $('#id_solicitud').val()
        
        e.preventDefault(e);

        $.ajax({
            method: 'POST',
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/solicitud/agregar-servicios`),
            processData: false,
            cache: false,
            contentType: false,
            data: formData,
            dataType: "json",
            success: function (sol) {
                if (sol.status == "success") {
                    alertSwal('success', 'Solicitud', 'Solicitud guardada satisfactoriamente');
                    window.location.reload();
                    $('#formEditSolicitud')[0].reset();
                    $('#modalEditSolicitud').modal('hide')
                } else {
                    alertSwal('error', 'Solicitud', sol.code.code);
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
        // }
    });

    // Preliminar
    $('#tbl-det-solicitud').on('click', '.btnPreliminar', function () {
        let id_solicitud = $(this).attr('solicitud');
        Swal.fire({
            type: 'question',
            title: `Solicitud Preliminar`,
            text: `¿Está seguro de Marcar esta Solicitud como Preliminar?`,
            confirmButtonText: 'Sí',
            showCancelButton: true,
            cancelButtonText: 'No',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_solicitud: id_solicitud,
                }
                $.ajax({
                    method: 'POST',
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/preliminar?id_solicitud=${id_solicitud}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Solicitud Preliminar', 'La solicitud se marcó como Preliminar satisfactoriamente');
                        } else {
                            alertSwal('error', 'Solicitud Preliminar', r.code.code);
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });
    })

// ##################################### Modal de Observación de Calidad ###############################################

$('#tbl-det-solicitud').on('click', '.btnObsCalidad', function () {
    $('#formEditObsCalidad')[0].reset();
    //$('#tbl-Afisicos-combo tbody').empty();
    let id_solicitud = $(this).attr('solicitud');
    //console.log(id_solicitud);

    $.ajax({
        method: "GET",
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/solicitud/solicitud-editar?id_solicitud=${id_solicitud}`), //Se le da el id_solicitud de la data
        contentType: 'application/json',
        dataType: "json",
        cache: false, // Evitar el almacenamiento en caché de la respuesta
        success: function (cand) {
            console.log(cand.data.id_solicitud);
            
            $('#id_solicitud').val(cand.data.id_solicitud);
            $('#obs_calidad').val(cand.data.obs_calidad);
            $('#concepto_final').val(cand.data.concepto_final);

            id_solicitudC = cand.data.id_solicitud;

                //muestra si existe el registro
                //$('#id_verificacion').val(resp.data[0].id_verificacion);

                // Configurar evento para actualizar la verificación existente
                $('#btn-submit-calidad').off('click').on('click', function (e) {
                    e.preventDefault();
                    updateVerification(id_solicitudC);
                });
            
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            //hideModalLoading();
        }
    });

    $('#modalEditObsCalidad').modal();
});

function updateVerification(id_solicitudC) {
    let concepto = $('#concepto_final').val();
    let observacion = $('#obs_calidad').val().trim();

    // Validación de campos
    if (!concepto || concepto === "") {
        alertSwal('warning', 'Campo Requerido', 'Debe seleccionar un concepto final.');
        return;
    }

    if (!observacion || observacion === "") {
        alertSwal('warning', 'Campo Requerido', 'Debe ingresar una observación.');
        return;
    }

    let data = {
        obs_calidad: observacion,
        concepto_final: concepto
    };

    $.ajax({
        method: "PUT",
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/solicitud/actualizar_obs_calidad?id_solicitud=${id_solicitudC}`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (resp) {
            alertSwal('success', 'Observación de Calidad', 'Actualizado satisfactoriamente');
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    });
}


// ################################## Modal de Modal de Observación de Calidad ##################################################



// ##################################### Modal de Modal de Centro de Costos ###############################################

$('#tbl-det-solicitud').on('click', '.btnCentroCosto', function () {
    $('#formEditCentroCosto')[0].reset();
    //$('#tbl-Afisicos-combo tbody').empty();
    let id_solicitud = $(this).attr('solicitud');
    //console.log(id_solicitud);

    $.ajax({
        method: "GET",
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/solicitud/solicitud-editar?id_solicitud=${id_solicitud}`), //Se le da el id_solicitud de la data
        contentType: 'application/json',
        dataType: "json",
        cache: false, // Evitar el almacenamiento en caché de la respuesta
        success: function (cand) {
            //console.log(cand.data.id_solicitud);
            
            $('#id_solicitud').val(cand.data.id_solicitud);
            $('#centro_costo').val(cand.data.centro_costo);

            id_solicitudC = cand.data.id_solicitud;

                //muestra si existe el registro
                //$('#id_verificacion').val(resp.data[0].id_verificacion);

                // Configurar evento para actualizar la verificación existente
                $('#btn-submit-costo').off('click').on('click', function (e) {
                    e.preventDefault();
                    updateVerificationCosto(id_solicitudC);
                });
            
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            //hideModalLoading();
        }
    });

    $('#modalEditCentroCosto').modal();
});

function updateVerificationCosto(id_solicitudC) {
    let data = {
        centro_costo: $('#centro_costo').val(),
    }
    //console.log(data);
    //let id_verificacion = $('#id_verificacion').val();

    $.ajax({
        method: "PUT",
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/solicitud/actualizar_centro_costo?id_solicitud=${id_solicitudC}`),
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: "json",
        success: function (resp) {
            alertSwal('success', 'Centro de Costos', 'Actualizado satisfactoriamente')
            //window.location = url_site(`familia_vip?id_solicitud=${id_solicitudC}&id_servicio=${id_servicioC}`);
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
            hideModalLoading();
        }
    });
}

// ################################## Modal de Modal de Centro de Costos ##################################################


    // Editar Solicitud
    $('#btn-edt-solicitud').on('click', function (e) {
        $('.div-editar').removeClass('hide');
        $('.div-srvadicionales').addClass('hide');
        $('.div-add-servicios').removeClass('hide');

        e.preventDefault(e);

        var idSolicitud = $('#idSolicitud').val();
        var idCandidato = $('#idCandidato').val();

        let data = {
            id_solicitud: idSolicitud,
            doc_candidato: $('#documento_edit').val(),
            observacion: $('#observacion_edit').val(),
            pais_edit: $('#pais_edit').val(),
            departamento_edit: $('#departamento_edit').val(),
            id_ciudad_act: $('#id_ciudad_act_edit').val(),
            localidad: $('#localidad_edit').val(),
        }

        $.ajax({
            method: 'POST',
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/solicitud/actualizar?id_solicitud=${idSolicitud}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (sol) {
                if (sol.status == "success") {
                    let dataCandidato = {
                        id_candidato: idCandidato,
                        tipo_id: $('#tipo_id_edit').val(),
                        numero_doc: $('#documento_edit').val(),
                        nombre: $('#nombre_edit').val(),
                        apellido: $('#apellido_edit').val(),
                        pais_edit: $('#pais_edit').val(),
                        departamento_edit: $('#departamento_edit').val(),
                        id_ciudad_act: $('#id_ciudad_act_edit').val(),
                        localidad: $('#localidad_edit').val(),
                        email: $('#correo_edit').val(),
                        telefono: $('#telefono_edit').val(),
                        direccion: $('#direccion_edit ').val(),
                        cargo: $('#cargo_edit ').val(),

                        //id_ciudad_act: $('#id_ciudad_act_edit').val(),
                    }
                    $.ajax({
                        method: 'POST',
                        headers: {
                            "access-token": getToken()
                        },
                        url: url_site(`api/solicitud/actualizar-candidato?id_candidato=${idCandidato}`),
                        contentType: 'application/json',
                        data: JSON.stringify(dataCandidato),
                        dataType: "json",
                        success: function (cand) {
                            if (sol.status == "success") {
                                alertSwal('success', 'Candidato', 'Actualizado satisfactoriamente');
                            } else {
                                alertSwal('error', 'Candidato', cand.code.code);
                            }
                        },
                        complete: function () {
                            hideModalLoading();
                        }
                    });
                    alertSwal('success', 'Solicitud', 'Solicitud guardada satisfactoriamente');
                    window.location.reload();
                    $('#formEditSolicitud')[0].reset();
                    $('#modalEditSolicitud').modal('hide')
                } else {
                    alertSwal('error', 'Solicitud', sol.code.code);
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
        // }
    });


    $('.btnAddSolicitud').on('click', function () {
        $('.div-editar').removeClass('hide');
        $('#formSolicitud')[0].reset();
        $('#info').html("");
        $('#accion').val("POST");
        $('#productos').html(' ');
        $('#btn-submit-solicitud').prop('disabled', false);
    });

    // Crear Solicitud
    $('#btn-submit-solicitud').on('click', function (e) {
        e.preventDefault(e);
        
        if (validateFormSolicitud()) {
            $('#btn-submit-solicitud').prop('disabled', true);

            let method = $('#accion').val();
            var form = document.getElementById('formSolicitud');
            var formData = new FormData(form);
            let id_solicitud = $('#id_solicitud').val()

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/solicitud?id_solicitud=${id_solicitud}`),
                processData: false,
                cache: false,
                contentType: false,
                data: formData,
                dataType: "json",
                success: function (sol) {
                    if (sol.status == "success") {
                        alertSwal('success', 'Solicitud', 'Solicitud guardada satisfactoriamente');
                        cargarTablaSolicitudes();
                        $('#formSolicitud')[0].reset();
                        $('#info').html("");
                        $('#modalAddSolicitud').modal('hide')
                        $('#btn-submit-solicitud').prop('disabled', false);
                    } else {
                        $('#btn-submit-solicitud').prop('disabled', false);
                        alertSwal('error', 'Solicitud', sol.code+".  Por favor no cargar archivos que superen las 8 Megas");
                        cargarTablaSolicitudes();
                    }
                },
                error: function (xhr, status, error) {
                    $('#btn-submit-solicitud').prop('disabled', false);

                    // Intenta convertir la respuesta JSON a un objeto JavaScript
                    try {
                        var responseObj = JSON.parse(xhr.responseText);

                        // Verifica si la propiedad 'code' existe y es una cadena
                        if (responseObj && responseObj.code && typeof responseObj.code === 'object') {
                            var errorMessage = responseObj.code.code;

                            // Ahora tienes el mensaje de error
                            alertSwal('error', 'Error al cargar los datos.', errorMessage);
                        } else {
                            // Si no se puede extraer el mensaje de error, muestra un mensaje genérico
                            alertSwal('error', 'Error al cargar los datos. Mensaje de error no válido.');
                        }
                    } catch (e) {
                        // Si hay un error al analizar JSON, muestra un mensaje de error genérico
                        alertSwal('error', 'Error al cargar los datos. Respuesta no válida.');
                    }

                },
                complete: function () {
                    hideModalLoading();
                    
                }
            });
        }
    });



    // Activa e Inactiva un Solicitud
    $('#tbl-solicitudes').on('click', '.btnEstadoSolicitud', function () {
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var estadoNuevo = ($(this).attr("estado") == 1) ? 1 : 0;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_solicitud = $(this).attr('solicitud');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Solicitud`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  esta solicitud?`,
            input: 'text',
            inputAttributes: {
                id: 'motivo_inactivo',
                name: 'motivo_inactivo',
                required: 'true',
                autocapitalize: 'off',
                placeholder: 'Motivo Inactivación'
            },
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let motivo_inactivo = $('#motivo_inactivo').val();
                let data = {
                    id_solicitud: id_solicitud,
                    estado: estadoNuevo,
                    motivo_inactivo: motivo_inactivo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/solicitud/cambio-estado?id_solicitud=${id_solicitud}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Solicitud', 'La Solicitud se ' + nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaSolicitudes();
                            $('#formSolicitud')[0].reset();
                        } else {
                            alertSwal('error', 'Solicitud', r.code.code);
                            cargarTablaSolicitudes();
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () { }
                });
            }
        });
    })

    $('#tbl-solicitudes').on('click', '.btnResumenServiciosSolicitud', function () {
        let solicitud = $(this).attr('solicitud');
        let cliente = $(this).attr('cliente');
        var perfil_campo = document.getElementById('perfil_campo').value;
        showModalLoading();
    
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/solicitud/?id_solicitud=${solicitud}`),
            dataType: "json",
            success: function (r) {
                $('#resumen-servicios tbody').html('');
                $('#btn-resumen-ir-solicitud')
                    .attr('solicitud', solicitud)
                    .attr('cliente', cliente);
                $('#resumen-solicitud').html(r.data?.id_solicitud ?? '');
                $('#resumen-fecha').html(r.data?.fch_solicitud ?? '');
                $('#resumen-cliente').html(r.data?.razon_social ?? '');
                $('#resumen-candidato').html(r.data?.candidato ?? '');
                $('#idclienteM').html(cliente);
    
                let t = $('#resumen-servicios').DataTable();
                if (!t || !$.fn.DataTable.isDataTable('#resumen-servicios')) {
                    t = $('#resumen-servicios').DataTable({
                        paging: false, // Oculta los controles de paginación
                        ordering: false, // Deshabilita la ordenación de columnas
                        info: false, // Oculta la información de la tabla
                        searching: false, // Deshabilita la función de búsqueda
                        dom: 'Bfrtip',
                    });
                } else {
                    t.clear().draw();
                }
    
                r.data?.servicios?.forEach(srv => {
                    if (perfil_campo != 13) {
                        t.row.add([
                            srv.id,
                            srv.nom_servicio,
                            srv.estado,
                            srv.observacion ?? '',
                            srv.prioridad ?? ''
                        ]).draw(false);
                        ocultarColumnaDataTable(t, 4);
                    }else{
                        t.row.add([
                            srv.id,
                            srv.nom_servicio,
                            srv.estado,
                            srv.observacion ?? '',
                            srv.prioridad ?? ''
                        ]).draw(false);
                    }
                });
    
                $('#modalListResumen').modal('show');
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
    });
    
    
    


    $('#tbl-solicitudes').on('click', '.btnServiciosAnteriores', function () {

        let candidato = $(this).attr('candidato');
        let cliente = $(this).attr('cliente');

        console.log(candidato);
        showModalLoading()

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/solicitud/servicios-anteriores/?candidato=${candidato}&cliente=${cliente}`),
            dataType: "json",
            success: function (r) {
                $('#resumen-servicios-ant').DataTable().clear();
                $('#resumen-servicios-ant').DataTable().destroy();

                let t = $('#resumen-servicios-ant').DataTable({
                    paging: true,
                    ordering: true,
                    info: false,
                    searching: true,
                    order: [
                        [0, "asc"],
                    ],
                });
                if (r.status == "success") {

                    r.data.forEach((solant) => {
                        t.row.add([
                            solant.id_solicitud,
                            solant.nom_combo,
                            solant.id_estado_solicitud,
                            solant.observacion,
                            solant.fch_solicitud
                        ]);
                    });
                };
                $('#resumen-cliente').html(candidato ?? '');
                $('#resumen-candidato').html(cliente ?? '');
                t.draw();

                $('#modalServiciosAnteriores').modal('show');
            }
        }).done(function () {
            hideModalLoading();
        });
    })

    // Eliminar Archivos Solicitud - Servicio
    $(".btn-eliminar-archivo-servicio, .btn-eliminar-archivo-solicitud").on("click", function () {

        api_recurso = "";
        if ($(this).hasClass("btn-eliminar-archivo-solicitud")) {
            api_recurso = "delete_adjunto";
        } else if ($(this).hasClass("btn-eliminar-archivo-servicio")) {
            api_recurso = "delete_adjunto";
        }

        if (api_recurso == "" || api_recurso == null) {
            alertSwal('error', 'Borrar Archivo', "Internal Error: recurso no identificado");
            return;
        }

        $('#accion').val("DELETE");
        let archivo = $(this).attr('archivoid');

        Swal.fire({
            type: 'question',
            title: `Borrar Archivo`,
            text: `¿Esta seguro de eliminar este archivo?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id: archivo,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/adjuntos/${api_recurso}?id_adjunto=${archivo}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwalR('success', 'Archivo', 'Archivo eliminado satisfactoriamente', '');
                        } else {
                            alertSwal('error', 'Archivo', r.code.code);
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
    });

    // Botón Guardar del modal de Servicios
    $("#formServicioSolicitud").submit(function (e) {
        e.preventDefault(e);
        $('#btn-submit-servicio').prop('disabled', true);
        var perfil_campo = document.getElementById('perfil_campo').value;
        var origen = document.getElementById('username').value;
        //console.log(perfil_campo,origen);
        let params = new URLSearchParams(location.search);
        let solicitud = params.get('solicitud');
        let accion = $('#accion').val();
        let servicio = $('#idServicio').val();
        let asignado = $('#asignado').val();
        let fecha = $('#fecha_programacion').val();
        let asistio = $('#asistio').val();
        let cont_proceso = $('#cont_proceso').val();
        let observacion_asistio = $('#observacion_asistio').val();
        //observacion_asistio = observacion_asistio.replaceAll('\n', '%0A');
        observacion_asistio = encodeURIComponent(observacion_asistio);
        let observacion = $('#observacion_modal').val();
        observacion = encodeURIComponent(observacion);
        //observacion = observacion.replaceAll('\n', '%0A');
        let para = $('#para').val();
        let mensaje = $('#mensaje_modal').val();
        //mensaje = mensaje.replaceAll('\n', '%0A');
        mensaje = encodeURIComponent(mensaje);
        let estado_calidad = $('#estado_calidad').val();
        let mensaje_calidad = $('#mensaje_calidad').val();
        //mensaje_calidad = mensaje_calidad.replaceAll('\n', '%0A');
        mensaje_calidad = encodeURIComponent(mensaje_calidad);
        let idServicioAdicional = $('#idServicioAdicional').val();
        let valor_adicional = $('#valor_adicional_s').val();
        let observacion_adicional = $('#observacion_adicional_s').val();
        //observacion_adicional = observacion_adicional.replaceAll('\n', '%0A');
        observacion_adicional = encodeURIComponent(observacion_adicional);

        var method = ''
        switch (accion) {
            case 'ASIGNAR':
                method = 'PUT';
                url = `api/solicitud/asignar?id_solicitud=${solicitud}&id_servicio=${servicio}&prestador=${asignado}`
                break;
            case 'PROGRAMAR':
                method = 'PUT';
                url = `api/solicitud/programar?id_solicitud=${solicitud}&id_servicio=${servicio}&fecha_programacion=${fecha}`
                break;
            case 'ASISTIO':
                method = 'PUT';
                url = `api/solicitud/asistencia?id_solicitud=${solicitud}&id_servicio=${servicio}&asistio=${asistio}&observacion_asistio=${observacion_asistio}`
                break;
            case 'PROCESO':
                method = 'PUT';
                url = `api/solicitud/proceso?id_solicitud=${solicitud}&id_servicio=${servicio}&cont_proceso=${cont_proceso}`
                break;
            case 'OBSERVACION':
                method = 'PUT';
                url = `api/solicitud/observacion?id_solicitud=${solicitud}&id_servicio=${servicio}&observacion=${observacion}`
                break;
            case 'MENSAJE':
                method = 'PUT';
                url = `api/solicitud/mensaje?id_solicitud=${solicitud}&id_servicio=${servicio}&para=${para}&mensaje=${mensaje}&perfil_campo=${perfil_campo}&origen=${origen}`
                break;
            case 'FINALIZAR':
                method = 'PUT';
                url = `api/solicitud/finalizar-servicio?id_solicitud=${solicitud}&id_servicio=${servicio}&estado=${estado_calidad}&mensaje=${mensaje_calidad}`
                break;
            case 'VALOR-ADICIONAL':
                method = 'PUT';
                url = `api/solicitud/valor-adicional?id=${idServicioAdicional}&solicitud=${solicitud}&servicio=${servicio}&valor_adicional=${valor_adicional}&observacion=${observacion_adicional}`
                break;
            case 'CALIFICAR':
                method = 'PUT';
                url = `api/solicitud/calificar?solicitud=${solicitud}&servicio=${servicio}`
                break;

        }
        if (validateForm()) {
            let data = {
                id_solicitud: solicitud,
                id_servicio: servicio,
                1: $('#1').val(),
                2: $('#2').val(),
                3: $('#3').val(),
                4: $('#4').val(),
            }

            showModalLoading();
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(url),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    console.log(r)
                    if (r.status == "success") {
                        alertSwal('success', 'Servicio', 'Servicio guardado satisfactoriamente');
                        window.location.reload();
                    } else {
                        $('#btn-submit-servicio').prop('disabled', false);
                        if (r.action == "finalizar") {
                            alertSwal('error', 'Servicio', r.message || 'Ocurrió un error');
                        } else {
                            alertSwal('error', 'Servicio', r.code.code);
                        }
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
});


function cargarTablaSolicitudes() {

    let fecha_desde = $('#filter_fecha_desde').val();
    let fecha_hasta = $('#filter_fecha_hasta').val();
    let cliente = $('#filter_cliente').val();
    let subEempresa = $('#filter_subempresa').val();
    let estado = $('#filter_estado').val();
    let combo = $('#filter_combo').val();

    showModalLoading();
    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/solicitud/lista?fecha_desde=${fecha_desde}&fecha_hasta=${fecha_hasta}&cliente=${cliente}&estado=${estado}&combo=${combo}&subempresa=${subEempresa}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-solicitudes').DataTable().clear();
            $('#tbl-solicitudes').DataTable().destroy();

            let t = $('#tbl-solicitudes').DataTable({
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                order: [
                    [12, "desc"],
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    title: 'REPORTE: Listado de Solicitudes',
                }],
            });

            if (r.status == "success") {
                let contador = 1;
                r.data.forEach((sol) => {
            
                let candidato = sol.candidato;

                // Paso 1: Quitar "# *" del principio
                let limpio = candidato.replace(/^# \*/, '');

                // Paso 2: Separar por " - *"
                let partes = limpio.split(' - *');

                // Paso 3: Asegurar que cada parte no tenga espacios adicionales
                partes = partes.map(p => p.trim());

                // Asignar a variables
                let cedula = partes[0] || '';
                let nombre = partes[1] || '';
                let apellido = partes[2] || '';
                let cargo = partes[3] || '';

                // Mostrar o usar
                /*
                console.log("Cédula:", cedula);
                console.log("Nombre:", nombre);
                console.log("Apellido:", apellido);
                console.log("Cargo:", cargo);
                */

                    //console.log(sol.candidato);
                    t.row.add([
                    `<button class="btn btn-xs btn-primary btnDetalleSolicitud" 
                            solicitud="${sol.id_solicitud}" 
                            cliente="${sol.id_empresa}">
                        <!--${contador++}--> Ver Detalle
                    </button>
                    <br>
                    <button class="btn btn-xs btn-warning btnResumenServiciosSolicitud" 
                            solicitud="${sol.id_solicitud}" 
                            cliente="${sol.id_empresa}">
                        Servicios (${sol.servicios})
                    </button>
                    ${(sol.servicios_anteriores > 0) ? `
                        <br>
                        <button class="btn btn-xs btn-info btnServiciosAnteriores" 
                                solicitud="${sol.id_solicitud}" 
                                candidato="${sol.doc_candidato}" 
                                cliente="${sol.id_empresa}">
                           Srv Ant (${sol.servicios_anteriores})
                        </button>
                    ` : ''}`
                    ,
                        sol.razon_social,
                        sol.responsable,
                        nombre+" "+apellido,
                        //sol.candidato,
                        sol.doc_candidato,
                        cargo,
                        sol.ciudad_nombre,
                        sol.nom_combo,
                        /*`<button class="btn btn-xs btn-warning btnResumenServiciosSolicitud" 
                        solicitud="${sol.id_solicitud}"cliente="${sol.id_empresa}">${sol.servicios}
                        </button>`,*/
                        sol.id_estado_solicitud,
                        sol.fch_solicitud,
                        sol.fch_estimada_sol_nueva || sol.fch_estimada_sol,
                        sol.fch_preliminar,
                        sol.fch_fin_solicitud,
                        sol.fch_create,
                        /*(sol.servicios_anteriores > 0) ? `<button class="btn btn-xs btn-info btnServiciosAnteriores" 
                                                        solicitud="${sol.id_solicitud}"candidato="${sol.doc_candidato} "cliente="${sol.id_empresa}" >${sol.servicios_anteriores}
                                                        </button>` : ``,*/
                        /*boton de activar o inactivar
                        (sol.id_estado_solicitud == 'ingresado') ? `<button class="btn btn-xs btn-${(sol.estado == 1) ? 'success' : 'danger'} btnEstadoSolicitud"
                            solicitud=${sol.id_solicitud} estado=${sol.estado}>
                            ${(sol.estado == 1) ? 'Activo' : 'Inactivo'} 
                        </button>` : (sol.estado == 1) ? 'Activo' : 'Inactivo'*/
                    ]);
                });
            };

            t.draw();
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'La Sesión a caducado, por favor Salir y ingresar Nuevamente'/*, xhr.responseText*/);
        },
        complete: function () {
            hideModalLoading();
        }
    }).done(function () {
        hideModalLoading();
    });



}



function validateFormSolicitud() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    let valmail = /^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;

    if ($('#cliente').val() == "" || $('#cliente').val() == null) {
        alertSwal('error', 'Cliente', 'Este campo es obligatorio');
        $("#cliente").focus();
        return false;
    }

    if ($('#responsable').val() == "" || $('#responsable').val() == null) {
        alertSwal('error', 'Responsable', 'Este campo es obligatorio');
        $("#responsable").focus();
        return false;
    }
    if ($('#id_ciudad_act').val() == "" || $('#id_ciudad_act').val() == null) {
        alertSwal('error', 'Ciudad', 'Este campo es obligatorio');
        $("#id_ciudad_act").focus();
        return false;
    }

    if ($('#tipo_id').val() == "" || $('#tipo_id').val() == null) {
        alertSwal('error', 'Tipo Doc', 'Este campo es obligatorio');
        $("#tipo_id").focus();
        return false;
    }

    if ($('#numero_doc').val() == "" || $('#numero_doc').val() == null) {
        alertSwal('error', 'Número Doc', 'Este campo es obligatorio');
        $("#numero_doc").focus();
        return false;
    }

    if ($('#nombre').val() == "" || $('#nombre').val() == null) {
        alertSwal('error', 'Nombre', 'Este campo es obligatorio');
        $("#nombre").focus();
        return false;
    }

    if ($('#apellido').val() == "" || $('#apellido').val() == null) {
        alertSwal('error', 'Apellido', 'Este campo es obligatorio');
        $("#apellido").focus();
        return false;
    }

    if ($('#telefono').val() == "" || $('#telefono').val() == null) {
        alertSwal('error', 'Teléfono', 'Este campo es obligatorio');
        $("#telefono").focus();
        return false;
    }

    if ($('#direccion').val() == "" || $('#direccion').val() == null) {
        alertSwal('error', 'Dirección', 'Este campo es obligatorio');
        $("#direccion").focus();
        return false;
    }

    if ($('#email').val() == "" || $('#email').val() == null) {
        alertSwal('error', 'E-mail', 'Este campo es obligatorio');
        $("#email").focus();
        return false;
    }

    if (!(valmail.test($('#email').val()))) {
        alertSwal('error', 'E-mail', 'Debe ingresar una dirección de correo válida');
        $("#email").focus();
        return false;
    }

    return true;
}

function leerFechaRango() {
    let fechas = $('#filter_fecha_rango').val().split(' ... ')
    $('#filter_fecha_desde').val(fechas[0]);
    $('#filter_fecha_hasta').val(fechas[1]);
}

function ver_solicitud(input) {
    let solicitud = input.attr('solicitud');
    let cliente = input.attr('cliente');
    window.location = url_site(`solicitud/detalle?solicitud=${solicitud}&cliente=${cliente}`)
}

//Validar adjuntos
function validarCamposCargue() {
    return true;
}

function accionFormEditar(input) {
    let idServicio = input.attr("idServicio");
    $('#idServicio').val(idServicio);

    loadSelectOption({
        url: url_site(`api/perfilServicio/usuarios-servicios?id_servicio=${idServicio}`),
        input: [{
            id: 'asignado',
            clearOptions: true,
            emptyText: 'Seleccione un Prestador',
            selectedValue: ''
        },
        ],
        columnKey: 'username',
        columnDescription: 'nombre_completo',
        responsePath: 'data'

    })
}

function validateForm() {

    return true;
}
