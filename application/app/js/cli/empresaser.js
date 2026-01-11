$(document).ready(function () {


    //carga Listado Empresas
    cargarTablaEmpresas();

    cboLoad('tipo_id', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');
    cboLoad('sube_tipo_id', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');

     //carga la lista de perfiles INTERNOS
     loadSelectOption({
        url: url_site(`api/perfil/lista-perfiles?tipo=E`),
        input: [{
            id: 'perfil',
            clearOptions: true,
            emptyText: 'Seleccione un perfil',
            selectedValue: ''
        },],
        columnKey: 'id',
        columnDescription: 'descripcion',
        responsePath: 'data'
    })

   // cboLoad('perfil', url_site(`api/perfil/lista`), '', true, 'Seleccione un perfil');
    cboLoad('tipo_identificacion', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');
    cboLoad('tipo_identificacion1', url_site(`api/configuracion/tipo_identificacion`), '', true, '-Seleccione-');
    //carga el nombre del archivo seleccionado en empresa
    $('#archivo').on('change', function (e) {
        var archivo = document.getElementById('archivo').files[0];
        $('#info').html(`<strong>${archivo.name}</strong> <small> (${descripcionTamanoArchivo(archivo.size)})</small>`);
        $('#lbl-archivo').html(`Cambiar Archivo`);
    });

    //carga el nombre del archivo seleccionado en sub-empresa
    $('#archivoSub').on('change', function (e) {
        var archivo = document.getElementById('archivoSub').files[0];
        $('#infoSub').html(`<strong>${archivo.name}</strong> <small> (${descripcionTamanoArchivo(archivo.size)})</small>`);
        $('#lbl-archivoSub').html(`Cambiar Archivo`);
    });
    

    $('#newEmpresa').hide();
    $('#editEmp').hide();

    $('#bandera_bashinput').hide();

        $('#perfil').on("change", function () {
        let perfil_lista = $('#perfil').val(); 
        //$("#username").val('');

        if (['7'].includes(perfil_lista)) {

            $('#bandera_bashinput').show();
            //$('#registro').attr('required', true); // 👈 Añadir validación obligatoria
        } else {

            $('#bandera_bashinput').hide();
            //$('#registro').removeAttr('required'); // 👈 Quitar validación obligatoria
        }
    });

   
    loadSelectOption({
        url: url_site(`api/ubicacion/pais`),
        input: [{
            id: 'pais',
            clearOptions: true,
            emptyText: 'Seleccione País',
            selectedValue: ''
        },
        {
            id: 'paisEdit',
            clearOptions: true,
            emptyText: 'Seleccione País',
            selectedValue: ''
        },
        ],
    });

    loadSelectOption({
        url: url_site(`api/ubicacion/dto`),
        input: [{
            id: 'id_dpto',
            clearOptions: true,
            emptyText: 'Seleccione un Departamento',
            selectedValue: ''
        },
        {
            id: 'id_dptoEdit',
            clearOptions: true,
            emptyText: 'Seleccione un Departamento',
            selectedValue: ''
        },
        ],
    });

    loadSelectOption({
        url: url_site(`api/ubicacion/ciudad`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
        input: [{
            id: 'id_ciudad',
            clearOptions: true,
            emptyText: 'Seleccione Ciudad',
            selectedValue: ''
        },
        {
            id: 'id_ciudadEdit',
            clearOptions: true,
            emptyText: 'Seleccione Ciudad',
            selectedValue: ''
        },
        ],
    })

    

/*   // como modal add empresas
    loadSelectOption({
        url: url_site(`api/ubicacion/dto`),
        input: [{
            id: 'id_dpto',
            clearOptions: true,
            emptyText: 'Seleccione un Departamento',
            selectedValue: 'id_dpto'
        },],
        columnKey: 'id_dpto',
        columnDescription: 'nombre',
        responsePath: 'data'
    }); */

    
 //Carga paises para empresa new.
 loadSelectOption({
    url: url_site(`api/ubicacion/pais`),
    input: [{
        id: 'sube_pais',
        clearOptions: true,
        emptyText: 'Seleccione País',
        selectedValue: ''
    },],
    columnKey: 'id_pais',
    columnDescription: 'nombre',
    responsePath: 'data'
})
/* 
let pais1 = $('#pais').val();  
loadSelectOption({
    url: url_site(`api/ubicacion/dto?idPais=${pais1}`),
    input: [{
        id: 'id_dpto',
        clearOptions: true,
        emptyText: 'Seleccione Dpto',
        selectedValue: ''
    },],
    columnKey: 'id_dpto',
    columnDescription: 'nombre',
    responsePath: 'data'
})

let id_dpto1 = $('#id_dpto').val();
loadSelectOption({
    url: url_site(`api/ubicacion/ciudad?idDpto=${id_dpto1}`),
    input: [{
        id: 'id_ciudad',
        clearOptions: true,
        emptyText: 'Seleccione una Ciudad',
        selectedValue: ''
    },],
    columnKey: 'id_ciudad',
    columnDescription: 'nombre',
    responsePath: 'data'
})  
*/          

//Selecciona departamento de acuerdo al pais - Empresa new
$('#sube_pais').on('change', function () {
    let pais = $('#sube_pais').val();
    $('#sube_id_dpto').empty();

    loadSelectOption({
        url: url_site(`api/ubicacion/dto?idPais=${pais}`),
        input: [{
            id: 'sube_id_dpto',
            clearOptions: true,
            emptyText: 'Seleccione Dpto',
            selectedValue: ''
        },],
        columnKey: 'id_dpto',
        columnDescription: 'nombre',
        responsePath: 'data'
    })
})


//Selecciona ciudad de acuerdo al dpto - Empresa new    
$('#sube_id_dpto').on('change', function () {
    let id_dpto = $('#sube_id_dpto').val();
    $('#sube_id_ciudad').empty();
//    if (id_dpto){
//        $('#id_ciudad').empty();
//    }else{
        loadSelectOption({
            url: url_site(`api/ubicacion/ciudad?idDpto=${id_dpto}`),
            input: [{
                id: 'sube_id_ciudad',
                clearOptions: true,
                emptyText: 'Seleccione una Ciudad',
                selectedValue: ''
            },],
            columnKey: 'id_ciudad',
            columnDescription: 'nombre',
            responsePath: 'data'
        })   

//    } //fin lista departamento
});   



    //Combo Modal Subempresas
/*   loadSelectOption({
        url: url_site(`api/ubicacion/dto`),
        input: [{
            id: 'sube_id_dpto',
            clearOptions: true,
            emptyText: 'Seleccione un Departamento',
            selectedValue: 'id_dpto'
        },],
        columnKey: 'id_dpto',
        columnDescription: 'nombre',
        responsePath: 'data'
    });   

    $('#sube_id_dpto').on('change', function () {  
        let sube_id_dpto = $('#sube_id_dpto').val();
        
        if (!sube_id_dpto){
            $('#sube_id_ciudad').empty();
        }else{
            loadSelectOption({
                url: url_site(`api/ubicacion/ciudad?idDpto=${sube_id_dpto}`),
                input: [{
                    id: 'sube_id_ciudad',
                    clearOptions: true,
                    emptyText: 'Seleccione una Ciudad',
                    selectedValue: ''
                },],
                columnKey: 'id_ciudad',
                columnDescription: 'nombre',
                responsePath: 'data'
            })
        }    
    
    });  
*/
    $("body").addClass("sidebar-collapse");

    //esconder el boton editar empresa
    $('#btn-edit-empresa').hide();
    $('#infoEdit').hide();


/********************************** */
// // Edita los  usuarios de la empresa 
/********************************** */
    $('#tbl-usuarios2').on('click', '.btnEditarUsuariosCli', function (e) {
        // Adicionar Usuarios a empresa
        //$('#btnEditarUsuariosCli').on('click', function (e) {    
        var id_perfil = "";
        var codigoTipoIden = "";

        const user = $(this).attr('username');
        const id_emp = $(this).attr('id_empresa');
        $('#id_user_empresa').val(user); 
        $('#accion').val("POST");

        $.ajax({
            headers: { 'access-token': getToken() },
            type: "GET",
            url: url_site(`api/usuario/empresasxuser?id_empresa=${id_emp}&user=${user}`),
            dataType: "json",
            success: function (r) {
                r.data.forEach((sube) => {  
                    //console.log(sube);
                    $('#username1').val(user);
                    $('#perfil1').val(sube.perfil_desc);
                    $('#nombres1').val(sube.nombres);
                    $('#apellidos1').val(sube.apellidos);
                    $('#tipo_identificacion1').val(sube.codigoTipoIden);
                    $('#numero_identificacion1').val(sube.numero_identificacion);
                    $('#cargo1').val(sube.cargo);
                    $('#email1').val(sube.correo);
                    $('#bandera_bash1').val(sube.bandera_bash); 
                    id_perfil = sube.idperfil; 
                    codigoTipoIden = sube.codigoTipoIden;

                    //carga la lista de perfiles Externos
                    loadSelectOption({
                        url: url_site(`api/perfil/lista-perfiles?tipo=E`),
                        input: [{
                            id: 'perfil1',
                            clearOptions: true,
                            emptyText: 'Seleccione un perfil',
                            selectedValue: id_perfil
                        },],
                        columnKey: 'id',
                        columnDescription: 'descripcion',
                        responsePath: 'data'
                    });

                    if (['7'].includes(sube.idperfil)) {
                        $('#bandera_bashinput1').hide();
                        $('#bandera_bashinput1').show();
                        
                    } else {
                        $('#bandera_bashinput1').hide();
                    }
                
                })
                
            }
        }).done(function () {
            hideModalLoading();
        }); 



        loadSelectOption({
            url: url_site(`api/empresa/empresausr?IdEmpresa=${id_emp}`),
            input: [{
                id: 'usr_empresas1',
                clearOptions: true,
                emptyText: 'Seleccione una Empresa',
                selectedValue: id_emp
            },],
            columnKey: 'usr_empresas',
            columnDescription: 'razon_social_sub',
            responsePath: 'data'
        });

        // console.log(id_perfil);    

        // console.log(user+id_emp);
        e.preventDefault();
        $('#modalEditarUsuarioCli').modal();
                

    });


});// fin ready






    /**********  
        carga el listado de empresas  
    ***/
   function cargarTablaEmpresas() {

    showModalLoading();

    if ($('#div-box-clientes').hasClass('col-md-8')) {
        $('#div-box-clientes').addClass('col-md-8');
        ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);
    }
    else {
        $('#div-box-clientes').addClass('col-md-12');
    }

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/empresa/lista/`),
        dataType: "json",
        success: function (r) {

            $('#tbl-empresas').DataTable().clear();
            $('#tbl-empresas').DataTable().destroy();

            let t = $('#tbl-empresas').DataTable({
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
                    title: 'REPORTE: Listado de Empresas',
                }],
            });
            if (r.status == "success") {
                r.data.forEach((emp) => {
                    t.row.add([
                        (emp.estado == '1') ? `<button class="btn btn-xs btn-warning btnEditEmpresa"    empresa="${emp.id_empresa}"><i class="fa fa-pencil"  aria-hidden="true"></i> ${emp.id_empresa}</button> ` : `${emp.id_empresa}`,
                        emp.razon_social,
                        emp.numero_doc,
                        emp.nom_ciudad,
                        emp.rep_legal,
                        emp.email_emp, 
                        //emp.flag_subemp,
                        `<button class="btn btn-xs btn-${(emp.estado == '1') ? 'success' : 'danger'} btnEstadoEmpresa"
                            empresa=${emp.id_empresa} estado=${emp.estado}>
                            ${(emp.estado == '1') ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        `<ul style="list-style:none; padding:0; margin:0;">
                            ${(emp.estado == '1') ? `<li><button class="btn btn-xs btn-primary btnUsuarios" empresa=${emp.id_empresa} nombre_empresa=${emp.razon_social}><i class="fa fa-users"></i> Usuarios</button></li>` : ''}
                            ${(emp.estado == '1' && emp.flag_subemp == '1') ? `<li><button class="btn btn-xs btn-success btnSubEmpresas" empresa=${emp.id_empresa} nombre_empresa=${emp.razon_social}><i class="fa fa-institution"></i> Sub-Empresas</button></li>` : ''}
                            ${(emp.estado == '1' && emp.flag_grup == '1') ? `<li><button class="btn btn-xs btn-warning btnTerceros" empresa=${emp.id_empresa} nombre_empresa=${emp.razon_social}><i class="fa fa-user"></i> Terceros</button></li>` : ''}
                            ${(emp.estado == '1') ? `<li><button class="btn btn-xs btn-danger btnServicios" empresa=${emp.id_empresa} nombre_empresa=${emp.razon_social}><i class="fa fa-spinner"></i> Servicios</button></li>` : ''}
                            ${(emp.estado == '1') ? `<li><button class="btn btn-xs btn-warning btnEspecificaciones" empresa=${emp.id_empresa} nombre_empresa=${emp.razon_social}><i class="fa fa-commenting-o"></i> Especificaciones</button></li>` : ''}
                        </ul>`

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

   //*****boton agregar empresa
   $('.btnAddEmpresa').on('click', function () {
        $('#formEmpresa')[0].reset();
        $('#accion').val("POST");
        $('#titulo-modal-empresa').html('Datos Empresa');

        $('#newEmpresa').show();
        $('#editEmp').hide();
       // $('#btn-submit-empresa').show();

        //esconder el boton editar empresa
        $('#btn-edit-empresa').hide();
        $('#btn-submit-empresa').show();

        $('#info-edit').html("");
        $('#infoEdit').hide();

        //cuando crea la empresa queda en pantalla completa
        $('#div-box-terceros').addClass('hide'); 
        $('#div-box-clientes').removeClass('col-md-8');
        $('#div-box-clientes').addClass('col-md-12');    

        $('#div-box-subempresas').addClass('hide');       
        $('#div-box-clientes').removeClass('col-md-7');
        $('#div-box-clientes').addClass('col-md-12');   

        $('#id_dpto').empty();
        $('#id_ciudad').empty();
        $('#pais').empty();

           //Carga paises para empresa new.
           loadSelectOption({
                url: url_site(`api/ubicacion/pais`),
                input: [{
                    id: 'pais',
                    clearOptions: true,
                    emptyText: 'Seleccione País',
                    selectedValue: ''
                },],
                columnKey: 'id_pais',
                columnDescription: 'nombre',
                responsePath: 'data'
            })
/* 
            let pais1 = $('#pais').val();  
            loadSelectOption({
                url: url_site(`api/ubicacion/dto?idPais=${pais1}`),
                input: [{
                    id: 'id_dpto',
                    clearOptions: true,
                    emptyText: 'Seleccione Dpto',
                    selectedValue: ''
                },],
                columnKey: 'id_dpto',
                columnDescription: 'nombre',
                responsePath: 'data'
            })

            let id_dpto1 = $('#id_dpto').val();
            loadSelectOption({
                url: url_site(`api/ubicacion/ciudad?idDpto=${id_dpto1}`),
                input: [{
                    id: 'id_ciudad',
                    clearOptions: true,
                    emptyText: 'Seleccione una Ciudad',
                    selectedValue: ''
                },],
                columnKey: 'id_ciudad',
                columnDescription: 'nombre',
                responsePath: 'data'
            })  
      */          

            //Selecciona departamento de acuerdo al pais - Empresa new
            $('#pais').on('change', function () {
                let pais = $('#pais').val();
                $('#id_dpto').empty();

                loadSelectOption({
                    url: url_site(`api/ubicacion/dto?idPais=${pais}`),
                    input: [{
                        id: 'id_dpto',
                        clearOptions: true,
                        emptyText: 'Seleccione Dpto',
                        selectedValue: ''
                    },],
                    columnKey: 'id_dpto',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })
            })


            //Selecciona ciudad de acuerdo al dpto - Empresa new    
            $('#id_dpto').on('change', function () {
                let id_dpto = $('#id_dpto').val();
                $('#id_ciudad').empty();
            //    if (id_dpto){
            //        $('#id_ciudad').empty();
            //    }else{
                    loadSelectOption({
                        url: url_site(`api/ubicacion/ciudad?idDpto=${id_dpto}`),
                        input: [{
                            id: 'id_ciudad',
                            clearOptions: true,
                            emptyText: 'Seleccione una Ciudad',
                            selectedValue: ''
                        },],
                        columnKey: 'id_ciudad',
                        columnDescription: 'nombre',
                        responsePath: 'data'
                    })   

            //    } //fin lista departamento
            });   




    }); //boton nueva empresa



   //******  Crear Empresa
   $('#btn-submit-empresa').on('click', function (e) {  
    //$('#formEmpresa').on('submit', function (e) {
       e.preventDefault();

        if (validateFormEmpresa()) {

            var form = document.getElementById('formEmpresa');
            var formData = new FormData(form);

            let method = $('#accion').val();
            let id_empresa = $('#id_empresa').val()
         
            showModalLoading();
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa?id_empresa=${id_empresa}`),
                //contentType: 'application/json',
                processData: false,
                cache: false,
                contentType: false,
                data: formData,
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                        cargarTablaEmpresas();
                        $('#formEmpresa')[0].reset();
                        $('#info').html("");
                        $('#lbl-archivo').html(`Seleccionar Archivo`);
                        document.getElementById('archivo').value = "";
                        $('#modalAddEmpresa').modal('hide')
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaEmpresas();
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




  // Al hacer clic en el botón para cerrar el modal
  $("#btn-xmodal").click(function() {
    limpiarDatos();
    //$("#modalAddEmpresa").css("display", "none");
  });

  // Al hacer clic en el botón para cerrar el modal
  $("#btn-cerrar-empresa").click(function() {
    limpiarDatos();
    //$("#modalAddEmpresa").css("display", "none");
  });

  // Al hacer clic fuera del modal
  $(window).click(function(event) {
    if (event.target.id === "modalAddEmpresa") {
      limpiarDatos();
    //  $("#modalAddEmpresa").css("display", "none");
    }
  });

  // Función para limpiar los datos del formulario
  function limpiarDatos() {
    // Puedes agregar más campos según sea necesario
   // $("#modalAddEmpresa")[0].reset();
     window.location = url_site(`empresa/`);
  }


    // Trae los datos para Editar empresa
    $('#tbl-empresas').on('click', '.btnEditEmpresa', function () {
        
        $('#formEmpresa')[0].reset();
        
        $('#titulo-modal-empresa').html('Editar Empresa');
        $('#newEmpresa').hide();
        $('#editEmp').show();

        $('#btn-edit-empresa').show();
        $('#btn-submit-empresa').hide();
        $('#info').html("");
        $('#infoEdit').show();

        $('#accion').val("POST");
        let id_empresa = $(this).attr('empresa');

        $('#id_dptoEdit').empty();
        $('#id_ciudadEdit').empty();
        $('#paisEdit').empty();
        let pais_id = null;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
        let dpto_id = null;
        let ciudad_id = null;

        //showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/empresa?id_empresa=${id_empresa}`),
            dataType: "json",
            success: function (resp) {
                console.log(resp.data);
                $('#id_empresa').val(resp.data.id_empresa);
                $('#razon_social').val(resp.data.razon_social);
                $('#rep_legal').val(resp.data.rep_legal);
                $('#tipo_id').val(resp.data.tipo_id);
                $('#numero_doc').val(resp.data.numero_doc);
                //$('#id_dpto').val(resp.data.id_dpto);
                
                $('#email_emp').val(resp.data.email_emp);
                $('#celular').val(resp.data.celular);
                $('#direccion').val(resp.data.direccion);
                $('#flag_subemp').val(resp.data.flag_subemp);
                $('#flag_grup').val(resp.data.flag_grup);
                $('#info-edit').html(resp.data.nombre_logo);
                $('#nomLogo').html(resp.data.nombre_logo);

// Mostrar el nombre del logo guardado como enlace
$('#info-edit').html(resp.data.nombre_logo);

// Obtén el elemento del enlace del logo
var enlaceLogo = document.getElementById("enlaceDirectorioLogo");

// Establece la ruta completa del archivo
enlaceLogo.href = "../"+resp.data.directorio + resp.data.nombre_encr;

// Mostrar el botón eliminar solo si hay logo
if (resp.data.nombre_logo && resp.data.nombre_logo.trim() !== "") {
    $('#btnEliminarLogo').show().attr('archivo', resp.data.nombre_logo);
} else {
    $('#btnEliminarLogo').hide();
}
                //$('#pais').val(resp.data.id_pais);
                //$('#dep_ac').val(resp.data.id_dpto);
                //$('#ciu_ac').val(resp.data.id_ciudad);


               // $('#id_dpto').val(resp.data.id_dpto);

            
                pais_id = resp.data.id_pais;            //Se hace uso de las Varibles Globales y se le asigna lo que fue traido de la respuesta
                dpto_id = resp.data.id_dpto;
                ciudad_id = resp.data.id_ciudad;   //se le da el valor a los campos en el HTML

                console.log(pais_id+dpto_id+ciudad_id);
                resp.data.flag_grup == 1 ? $('#flag_grup').attr('checked', true) : $('#flag_grup').attr('checked', false);
                resp.data.flag_subemp == 1 ? $('#flag_subemp').attr('checked', true) : $('#flag_subemp').attr('checked', false);
                validaChecks();
                //let departamento_id = resp.data.id_dpto;
                //let pais_id = resp.data.id_pais;          
                //let ciudad_id = resp.data.id_ciudad;      

                loadSelectOption({
                    url: url_site(`api/ubicacion/pais-edit?$idPais=${resp.data.id_pais}`),
                    input: [
                        {
                            id: 'paisEdit',
                            clearOptions: true,
                            selectedValue: pais_id
                        },
                    ],
                    columnKey: 'id_pais',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                });

        /*        loadSelectOption({
                    url: url_site(`api/ubicacion/dto-edit?idPais=${resp.data.id_pais}`),
                    input: [{
                        id: 'id_dptoEdit',
                        clearOptions: true,
                        selectedValue: dpto_id
                    },],
                    columnKey: 'id_dpto',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                });

                loadSelectOption({
                    url: url_site(`api/ubicacion/ciudad-id?idCiudad=${resp.data.id_ciudad}`),
                    input: [{
                        id: 'id_ciudadEdit',
                        clearOptions: true,
                        selectedValue: ciudad_id
                    },],
                    columnKey: 'id_ciudad',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                });   */



            //loadSelectOption para cargar la lista de los Departamentos esto sucede si en el campo de Pais muestra el dato
            $('#paisEdit').on('change', function () {
                let paisE = $('#paisEdit').val();            //Se Crea una variable para guardar lo que pinto en el campo pais para mandarlo por parametro
                //console.log (pais);
                //$('#ciu_ac').empty();
                loadSelectOption({
                    url: url_site(`api/ubicacion/dto-edit?idPais=${paisE}`),      //Se le manda el parametro  de pais a la tabla conf_dpto
                    input: [{
                        id: 'id_dptoEdit',
                        clearOptions: true,
                        emptyText: 'Seleccione Dpto',
                        selectedValue: dpto_id
                    },],
                    columnKey: 'id_dpto',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                    
                })
            }); 


            $('#id_dptoEdit').on('change', function () {
                let dptoE = $('#id_dptoEdit').val();            //Se Crea una variable para guardar lo que pinto en el campo departamento para mandarlo por parametro

                loadSelectOption({
                    url: url_site(`api/ubicacion/ciudad-edit?idDpto=${dptoE}`),       //Se le manda el parametro  de pais a la tabla conf_ciudad
                    input: [{
                        id: 'id_ciudadEdit',
                        clearOptions: true,
                        emptyText: 'Seleccione Ciudad',
                        selectedValue: ciudad_id
                    },],
                    columnKey: 'id_ciudad',
                    columnDescription: 'nombre',
                    responsePath: 'data'
                })
            });
                        


            }
        }).done(function () {
            hideModalLoading();
        });

        $('#modalAddEmpresa').modal();
        
    });


     // Guardar la edicion de la Empresa
    $('#btn-edit-empresa').on('click', function (e) {  
        e.preventDefault();   
    
        if (validateFormEmpresa()) {
    
            var form = document.getElementById('formEmpresa');
            var formData = new FormData(form);
    
            let method = $('#accion').val();
            let id_empresa = $('#id_empresa').val()
    
               showModalLoading();
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/empresa/editar?id_empresa=${id_empresa}`),
                    //contentType: 'application/json',
                    processData: false,
                    cache: false,
                    contentType: false,
                    data: formData,
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                            cargarTablaEmpresas();
                            $('#formEmpresa')[0].reset();
                            $('#info').html("");
                            $('#lbl-archivo').html(`Seleccionar Archivo`);
                            document.getElementById('archivo').value = "";
                            $('#modalAddEmpresa').modal('hide')
                        } else {
                            alertSwal('error', 'Empresa', r.code.code);
                            cargarTablaEmpresas();
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

    // Activa e Inactiva un empresa
    $('#tbl-empresas').on('click', '.btnEstadoEmpresa', function () {
    $('#accion').val("PUT");
    var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
    var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
    var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
    let id_empresa = $(this).attr('empresa');

    Swal.fire({
        type: 'question',
        title: `${nuevoEstadoDesc} empresa`,
        text: `¿Está seguro de ${nuevoEstadoDesc}  esta empresa?`,
        confirmButtonText: 'OK',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        focusCancel: true
    }).then(function (result) {
        if (result.value) {
            let method = $('#accion').val();
            let data = {
                id_empresa: id_empresa,
                estado: nuevoEstado,
            }
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa/cambio-estado?id_empresa=${id_empresa}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'La empresa se ' + nuevoEstadoMsj + ' satisfactoriamente');
                        cargarTablaEmpresas();
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaEmpresas();
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



   /********
      Carga la tabla de Subempresas  
    *****/
   function cargarTablaSubemp() {

    ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);

    showModalLoading();
    let id_empresa = $('#id_empresa_vw_subemp').val();
    $('#id_empresaSubemp').val(id_empresa); 


    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/terceros/listasub?id_empresa=${id_empresa}`),
        dataType: "json",
        success: function (r) {
            $('#tbl-subemp').DataTable().clear();
            $('#tbl-subemp').DataTable().destroy();

            let t = $('#tbl-subemp').DataTable({
                paging: true,
                ordering: true,
                info: true, // <- asegúrate de que esté en true
                searching: false,
                order: [
                    [0, "asc"],
                ],
                dom: 'frtip', // <- esta línea es clave
                buttons: [{
                    extend: '',
                    title: 'REPORTE: Listado de SubEmpresas',
                }],

            });

            if (r.status == "success") {
                r.data.forEach((sube) => {

                    t.row.add([
                        sube.razon_social,
                        sube.numero_doc,
                        sube.rep_legal,
                       // sube.email_emp,
                        sube.nombre,
                        `<button class="btn btn-xs btn-${(sube.estado_sube == '1') ? 'success' : 'danger'} btnEstadoSubempresa"
                        id_empresa_vw_subemp=${sube.id_empresa} estado_sube=${sube.estado_sube}>
                        ${(sube.estado_sube == '1') ? 'Activo' : 'Inactivo'}    
                         </button>`
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

    // Activa e Inactiva un subempresa
   $('#tbl-subemp').on('click', '.btnEstadoSubempresa', function (e) {
    e.preventDefault();

    var nuevoEstado = ($(this).attr("estado_sube") == 1) ? 0 : 1;
    var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
    var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
    
    let id_subempresa = $(this).attr('id_empresa_vw_subemp');
    let method = "PUT";
    let data = {
        id_empresa: id_subempresa,
        estado: nuevoEstado,
    }
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa/cambio-estado?id_empresa=${id_subempresa}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r_sub) {
                    if (r_sub.status == "success") {
                        //null;
                        alertSwal('success', 'SubEmpresa', 'El subempresa se ' + nuevoEstadoMsj + ' satisfactoriamente');
                        // cargarTablaTerceros();
                        cargarTablaSubemp();
                        // $('#formTerceros')[0].reset();
                    } else {
                        alertSwal('error', 'SubEmpresa', r_sub.code.code);
                        cargarTablaSubemp();
                    }
                },
                error: function (xhr, status, error) {
                    alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                },
                complete: function () {
                }
            });
// }
// });
   });

   //*****cargar la pantalla de la derecha "SUBEMPRESAS"
   $('#tbl-empresas').on('click', '.btnSubEmpresas', function () {

    $('#empresaSub').val($(this).attr('empresa'));
    $('#id_empresa_vw_subemp').val($(this).attr('empresa'));

    $('#span-cliente-subemp').text($(this).attr('nombre_empresa'));
    $('#div-box-subempresas').removeClass('hide');
    
    //oculto una columna de la tabla empresas
    ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);
    
    $('#div-box-clientes').removeClass('col-md-12');
    $('#div-box-clientes').addClass('col-md-7');

    //esconde la tabla terceros en caso q este abierto
    $('#div-box-terceros').addClass('hide');
    $('#div-box-usuarios').addClass('hide');
    $('#div-box-servicios').addClass('hide');

 //   $('#div-box-clientes').addClass('col-md-12');
 //   $('#div-box-clientes').removeClass('col-md-7');

    cargarTablaSubemp();

   });


    //Ocultar la pantalla de la derecha subempresas
    $('#btnCollapseSubEmpresas').on('click', function () {
        $('#div-box-subempresas').addClass('hide');
        $('#div-box-clientes').addClass('col-md-12');
        $('#div-box-clientes').removeClass('col-md-7');

    })

    // Adicionar Subempresa
   $('#btnAddSubemp').on('click',  function () {
        let empresa = $(this).val('id_empresa_vw_subemp');
        
        $('#titulo-modal-subemp').html('Adicionar Subempresa');
        $('#formSubemp')[0].reset();
        $('#modalAddSubemp').modal();
        $('#id_empresaSubemp').val(empresa);
        
        $('#accionSub').val('POST');
        $('#info').html("");
        $('#info-editSub').html("");
        $('#infoEditSub').hide();
    });

   // Crear SubEmpresa
   $('#btn-submit-subempresas').on('click', function (e) {
        e.preventDefault();

        $('#info').html("");
        $('#info-edit').html("");
        $('#infoEdit').hide();
    
        $('#accionSub').val('POST');
            
            var form = document.getElementById('formSubemp');
            var formData = new FormData(form);

            let method = $('#accionSub').val();

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/empresa/sub-empresa`),
            //contentType: 'application/json',
            processData: false,
            cache: false,
            contentType: false,
            data: formData,
            dataType: "json",
            method: 'POST',
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                    
                    cargarTablaSubemp();
            
                    $('#formSubemp')[0].reset();
                    $('#modalAddSubemp').modal('hide');
                    $('#infoSub').html("");
                    $('#lbl-archivo').html(`Seleccionar Archivo`);
                    document.getElementById('archivo').value = ""; 
                    

                    $('#div-box-clientes').removeClass('col-md-12');
                    $('#div-box-clientes').addClass('col-md-8');
                } else {
                    alertSwal('error', 'Empresa', r.code.code);
                    cargarTablaEmpresas();
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
                hideModalLoading();
            }
        });
    // }; 
    });  





    /*******  
     * CARGA TERCEROS  
    *****/
    function cargarTablaTerceros() {

    ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);

    //showModalLoading();
    let id_empresa = $('#id_empresa_vw_tercero').val();
    $('#id_empresaTercero').val(id_empresa); 

    $.ajax({
        headers: {
            "access-token": getToken()
        },
        type: "GET",
        url: url_site(`api/terceros/lista?id_empresa=${id_empresa}`),
        dataType: "json",
        success: function (r) {
            $('#tbl-terceros').DataTable().clear();
            $('#tbl-terceros').DataTable().destroy();

            let t = $('#tbl-terceros').DataTable({
                paging: true,
                ordering: true,
                info: false,
                responsive: true,
                searching: false,
                dom: '',
                order: [
                    [0, "asc"],
                ]
            });
            if (r.status == "success") {
                r.data.forEach((ter) => {
                    t.row.add([
                        ter.nom_tercero,
                        `<button class="btn btn-xs btn-${(ter.estado_ter == '1') ? 'success' : 'danger'} btnEstadoTercero"
                            id_tercero=${ter.id_tercero} estado_ter=${ter.estado_ter}>
                            ${(ter.estado_ter == '1') ? 'Activo' : 'Inactivo'}    
                        </button>` 
                    ]);
                });
            };

            t.draw();
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
        },
        complete: function () {
        }
    }).done(function () {
        //hideModalLoading();
    });
    }

     //*****cargar la pantalla de la derecha "TERCEROS"
     $('#tbl-empresas').on('click', '.btnTerceros', function () {
        $('#empresa').val($(this).attr('empresa'));
        $('#id_empresa_vw_tercero').val($(this).attr('empresa'));

        $('#span-cliente-id').text($(this).attr('nombre_empresa'));
        $('#div-box-terceros').removeClass('hide');
        
        //oculto una columna de la tabla empresas
        ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);
        
        $('#div-box-clientes').removeClass('col-md-12');
        $('#div-box-clientes').addClass('col-md-8');

         //esconde la tabla terceros en caso q este abierto
         $('#div-box-subempresas').addClass('hide');
         $('#div-box-usuarios').addClass('hide');
         $('#div-box-servicios').addClass('hide');

        const empresa = $(this).attr('empresa');
        cargarTablaTerceros();
    });


    //Ocultar la pantalla de la derecha terceros
    $('#btnCollapseTercero').on('click', function () {
        $('#div-box-terceros').addClass('hide');
        $('#div-box-clientes').addClass('col-md-12');
        $('#div-box-clientes').removeClass('col-md-8');
    });

    // mostrar Adicionar Terceros
    $('#btnAdd-Terceros').on('click', function () {
        const empresa = $(this).val('id_empresa_vw_tercero');
        $('#titulo-modal-terceros').html('Adicionar Tercero');
        $('#formTerceros')[0].reset();
        $('#modalAddTerceros').modal();
        $('#id_empresaTercero').val(empresa); 
    });

    // ***Crear Terceros
    $('#btn-submit-terceros').on('click', function (e) {
        e.preventDefault(e);

        $('#accion').val("POST");
        let method = $('#accion').val();

        let data = {
            id_empresa: $('#id_empresaTercero').val(),
            nom_tercero: $('#nom_tercero').val(),
        }
        
        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/terceros?id_tercero=${data.id_tercero}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Tercero', 'Tercero guardado satisfactoriamente');
                    
                  //  cargarTablaEmpresas();
                    cargarTablaTerceros();
                    ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);
            
                    $('#formTerceros')[0].reset();
                    $('#modalAddTerceros').modal('hide')
                } else {
                    alertSwal('error', 'Terceros', r.code.code);
                    cargarTablaTerceros();
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


    // Activa e Inactiva un tercero
   $('#tbl-terceros').on('click', '.btnEstadoTercero', function (e) {  
    e.preventDefault();

    var nuevoEstado = ($(this).attr("estado_ter") == 1) ? 0 : 1;

    var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
    
    var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
    let id_tercero = $(this).attr('id_tercero');
  //  let method = "PUT";
    let data = {
        id_tercero: id_tercero,
        estado_ter: nuevoEstado,
    }

    Swal.fire({
        type: 'question',
        title: `${nuevoEstadoDesc} Tercero`,
        text: `¿Está seguro de ${nuevoEstadoDesc}  este Tercero?`,
        confirmButtonText: 'OK',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        focusCancel: true
    }).then(function (result) {
        if (result.value) {
            let method = "PUT";
            let data = {
                id_tercero: id_tercero,
                estado_ter: nuevoEstado,
            }
            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/terceros/cambio-estado?id_tercero=${id_tercero}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
                    if (r.status == "success") {
                        alertSwal('success', 'Tercero', 'El tercero se ' + nuevoEstadoMsj + ' satisfactoriamente');
                        cargarTablaTerceros();
                    } else {
                        alertSwal('error', 'Tercero', r.code.code);
                        cargarTablaTerceros();
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



  
    /*************************
     * carga la tabla de usuarios
     * ************/
    function cargarTablaUsuarios() { 

    showModalLoading();
    let id_empresa = $('#id_empresa_vw_usuarios').val();

    ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);

    $.ajax({
        headers: { 'access-token': getToken() },
        type: "GET",
        url: url_site(`api/usuario/empresas?id_empresa=${id_empresa}`),
        dataType: "json",
        success: function (r) {

            $('#tbl-usuarios2').DataTable().clear();
            $('#tbl-usuarios2').DataTable().destroy();

            var t = $('#tbl-usuarios2').DataTable({
                paging: true,
                ordering: true,
                info: true, // <- asegúrate de que esté en true
                searching: false,
                order: [
                    [0, "asc"],
                ],
                dom: 'frtip', // <- esta línea es clave
                buttons: [{
                    extend: '',
                    title: 'REPORTE: Listado de Usuarios',
                }],
            });


            if (r.status == "success") {
                t.clear().draw(); // Limpia la tabla antes de agregar datos nuevos
                r.data.forEach((user, index) => {
                    //console.log(user.bandera_bash)
                    t.row.add([
                        user.username,
                        user.perfil_desc,
                        `${user.nombres ?? ''} ${user.apellidos ?? ''}`,
                        user.tipo_identificacion,
                        //user.numero_identificacion,
                        //`<center><span title="correo" class="correo-link" data-correo="${user.correo}" style="cursor:pointer; color:blue; text-decoration:underline;"><i class="fa fa-copy"></i></span></center>`,
                        //user.empresa,
                        `<button class="btn btn-xs btn-${(user.estado == 'ACT') ? 'success' : 'danger'} btnEstadoUsuario"
                        username=${user.username} estado_usr=${user.estado}>
                        ${(user.estado == 'ACT') ? 'Activo' : 'Inactivo'}    
                        </button>`,
                        `<button title="editar" class="btn btn-xs btn-warning btnEditarUsuariosCli" username=${user.username} id_empresa=${id_empresa}><i class="fa fa-pencil"></i> Editar</button>
                        <br><br>
                        <button class="btn btn-xs btn-info btnVerDetalle" 
                        data-username="${user.username}"
                        data-perfil="${user.perfil_desc}"
                        data-nombre="${user.nombres ?? ''} ${user.apellidos ?? ''}"
                        data-tipoid="${user.tipo_identificacion}"
                        data-numid="${user.numero_identificacion}"
                        data-cargo="${user.cargo}"
                        data-correo="${user.correo}"
                        data-empresa="${user.empresa}"
                        data-bandera_bash="${(user.bandera_bash === 'S') ? 'Si' : 'No'}">
                        <i class="fa fa-eye"></i>  Ver
                    </button>`
                    ]).draw();
                });
            }
            

            

           
            ocultarColumnaDataTable(t, 3);
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
    // ✅ Escuchar el evento de click en .correo-link (Funciona incluso si la tabla se recarga)
    $(document).on('click', '.correo-link', function() {
        let correo = $(this).data('correo');
        $('#correoInput').val(correo);
        $('#correoModal').modal('show');
    });
    
    // ✅ Función para copiar el correo
    function copiarCorreo() {
        let correoInput = document.getElementById('correoInput');
        correoInput.select();
        document.execCommand('copy');
        alert('Correo copiado: ' + correoInput.value);
    }

    // ✅ Evitar que el botón "Ver Detalle" recargue la página
    $(document).on('click', '.btnVerDetalle', function(event) {
        event.preventDefault(); // 🚀 Evita la recarga de la página

        $('#detalleUsername').text($(this).data('username'));
        $('#detallePerfil').text($(this).data('perfil'));
        $('#detalleNombre').text($(this).data('nombre'));
        $('#detalleTipoId').text($(this).data('tipoid'));
        $('#detalleNumId').text($(this).data('numid'));
        $('#detalleCargo').text($(this).data('cargo'));
        $('#detalleCorreo').text($(this).data('correo'));
        $('#detalleEmpresa').text($(this).data('empresa'));
        $('#detalleBandera').text($(this).data('bandera_bash'));

        $('#detalleModal').modal('show');
    });

    //*****cargar la pantalla de la derecha "Usuarios"
   $('#tbl-empresas').on('click', '.btnUsuarios', function () {

        const empresa = $(this).attr('empresa');
        $('#id_empresa_vw_usuarios').val(empresa);
        $('#id_empresa_usuario').val(empresa);

        $('#span-cliente-usuarios').text($(this).attr('nombre_empresa'));

        $('#div-box-usuarios').removeClass('hide');

        //esconde la tabla terceros en caso q este abierto
        $('#div-box-subempresas').addClass('hide');
        $('#div-box-terceros').addClass('hide');
        $('#div-box-servicios').addClass('hide');

        //oculto una columna de la tabla empresas
        ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);

        $('#div-box-clientes').removeClass('col-md-12');
        $('#div-box-clientes').addClass('col-md-7');
        $('#empresaUsu').val(empresa);

        cargarTablaUsuarios();

    });


    //Ocultar la pantalla de la derecha terceros
    $('#btnCollapseUsuarios').on('click', function () {
        $('#div-box-usuarios').addClass('hide');
        $('#div-box-clientes').addClass('col-md-12');
        $('#div-box-clientes').removeClass('col-md-7');
    });

    // // Activa e Inactiva un usuario
    $('#tbl-usuarios2').on('click', '.btnEstadoUsuario', function (e) {

        e.preventDefault();

        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado_usr") == 'ACT') ? 'INA' : 'ACT';
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let username = $(this).attr('username');
        let method = $('#accion').val(); 
        let data = {
            username: username,
            estado_usr: nuevoEstado,
        }


        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/empresa/cambio-estado-usuario?username=${username}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r_ter) {
                if (r_ter.status == "success") {
                    alertSwal('success', 'Usuario', 'El Usuario se ' + nuevoEstadoMsj + ' satisfactoriamente');
                    cargarTablaUsuarios();
                } else {
                    alertSwal('error', 'Usuario', r.code.code);
                    cargarTablaUsuarios();
                }
            },
            error: function (xhr, status, error) {
                alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
            },
            complete: function () {
            }
        });
    });


    // Adicionar Usuarios a empresa actual empresas
    /*$('#btnAddUsuarios2').on('click', function (e) {

        $('#modalAgregarUsuarioCli').modal();
        $('#titulo-modal-usu').html('Adicionar Usuario');
        const empresa = $('#id_empresa_usuario').val();
         
         $('#id_empresa_usuario').val(empresa); 
         $('#accion').val("POST");
         
        let idEmpresaUsuario = empresa;
            
            loadSelectOption({
                url: url_site(`api/empresa/empresausr?IdEmpresa=${idEmpresaUsuario}`),
                input: [{
                    id: 'usr_empresas',
                    clearOptions: true,
                    emptyText: 'Seleccione una Empresa',
                    selectedValue: ''
                },],
                columnKey: 'usr_empresas',
                columnDescription: 'razon_social_sub',
                responsePath: 'data'
            });
    });*/



    $("#username").change(function () {
        var isReadonly = $("#username").prop("readonly");
    
        if (!isReadonly && $('#username').is(":visible")) { // evitar validación cuando el navegador autocompleta el campo
            var username = $(this).val();
    
            // Validar que el username no contenga Ñ, ñ o tildes
            if (/[^a-zA-Z0-9\s]/.test(username)) {
                $("#username").val('').focus();
                alertSwal('error', 'Usuario', 'El nombre de usuario no puede contener caracteres especiales');
                return; // Detener la ejecución si la validación falla
            }
    
            $.ajax({
                headers: { 'access-token': getToken() },
                type: "GET",
                url: url_site() + `api/usuario/existe/?username=${username}`,
                dataType: "json",
                success: function (r) {
                    if (r.existe == true && username != "") {
                        alertSwal('warning', `Usuario ${username} ya Existe`, 'Indique un usuario diferente.');
                        $("#username").val('').focus();
                    }
                }
            });
        }
    });
    //funcionalidad para guardar usuarios actual empresas
/*    $('#btn-submit-usuario2').on('click', function (e) {
        e.preventDefault(e);

        let method = $('#accion').val();
        let data = {
            username: $('#username').val(),
            id_empresa: $('#usr_empresas').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            nombres: $('#nombres').val(),
            apellidos: $('#apellidos').val(),
            tipo_identificacion: $('#tipo_identificacion').val(),
            numero_identificacion: $('#numero_identificacion').val(),
            perfil: $('#perfil').val(),
            cargo: $('#cargo').val(),
            bandera_bash: $('#bandera_bash').val()
            
        }
        let empresasub = $('#usr_empresas').val();
        $('#id_empresa_usuario').val(empresasub);
        if (validarCamposUsuario()) {

            $.ajax({
                method: method,
                headers: {
                    "access-token": getToken()
                },
                url: url_site(`api/empresa/usrxemp?id_empresa=${data.id_empresa}`),
                contentType: 'application/json',
                data: JSON.stringify(data),
                dataType: "json",
                success: function (r) {
            
                    if (r.status == "success") {
                        alertSwal('success', 'Empresa', 'Usuario guardado satisfactoriamente');
                        cargarTablaUsuarios();
                        $('#formUsuario2')[0].reset();
                        $('#modalAgregarUsuarioCli').modal('hide')
                    } else {
                        alertSwal('error', 'Empresa', r.code.code);
                        cargarTablaUsuarios();
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

        e.preventDefault(e);
    });
*/
// Adicionar Usuarios a empresa
$('#btnAddUsuarios2').on('click', function (e) {
    $('#modalAgregarUsuarioCli').modal();
    $('#titulo-modal-usu').html('Adicionar Usuario');
    const empresa = $('#id_empresa_usuario').val();
     
    $('#id_empresa_usuario').val(empresa); 
    $('#accion').val("POST");
    
    let idEmpresaUsuario = empresa;
    
    // Cargar empresas en tabla en lugar de select
    cargarEmpresasEnTabla(idEmpresaUsuario);
});

// Función para cargar empresas en tabla
function cargarEmpresasEnTabla(idEmpresaUsuario) {
    $.ajax({
        method: 'GET',
        headers: {
            "access-token": getToken()
        },
        url: url_site(`api/empresa/empresausr?IdEmpresa=${idEmpresaUsuario}`),
        success: function (r) {
            if (r.status == "success" && r.data && r.data.length > 0) {
                const tbody = $('#tbody-empresas');
                tbody.empty();
                
                r.data.forEach(empresa => {
                    const row = `
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="empresa-checkbox" 
                                       value="${empresa.usr_empresas}" 
                                       data-razonsocial="${empresa.razon_social_sub}">
                            </td>
                            <td>${empresa.razon_social_sub}</td>
                            <!--<td>${empresa.ruc || empresa.identificacion || 'N/A'}</td>-->
                        </tr>
                    `;
                    tbody.append(row);
                });
            } else {
                $('#tbody-empresas').html('<tr><td colspan="3" class="text-center">No hay empresas disponibles</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            alertSwal('error', 'Error', 'No se pudieron cargar las empresas');
            $('#tbody-empresas').html('<tr><td colspan="3" class="text-center">Error al cargar empresas</td></tr>');
        }
    });
}

// Función para obtener las empresas seleccionadas
function obtenerEmpresasSeleccionadas() {
    const empresasSeleccionadas = [];
    $('.empresa-checkbox:checked').each(function() {
        empresasSeleccionadas.push({
            id: $(this).val(),
            razon_social: $(this).data('razonsocial')
        });
    });
    return empresasSeleccionadas;
}

//funcionalidad para guardar usuarios
$('#btn-submit-usuario2').on('click', function (e) {
    e.preventDefault(e);

    let method = $('#accion').val();
    const empresasSeleccionadas = obtenerEmpresasSeleccionadas();
    
    // Validar que se haya seleccionado al menos una empresa
    if (empresasSeleccionadas.length === 0) {
        alertSwal('warning', 'Empresa', 'Debe seleccionar al menos una empresa');
        return false;
    }

    let data = {
        username: $('#username').val(),
        empresas: empresasSeleccionadas, // Array de empresas seleccionadas
        email: $('#email').val(),
        password: $('#password').val(),
        nombres: $('#nombres').val(),
        apellidos: $('#apellidos').val(),
        tipo_identificacion: $('#tipo_identificacion').val(),
        numero_identificacion: $('#numero_identificacion').val(),
        perfil: $('#perfil').val(),
        cargo: $('#cargo').val(),
        bandera_bash: $('#bandera_bash').val()
    };

    if (validarCamposUsuario()) {
        // Si tu API espera un array de empresas, puedes enviar directamente el array
        // Si necesita un solo ID, puedes tomar el primero o modificar según tu necesidad
        const primeraEmpresa = empresasSeleccionadas[0].id;
        
        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/empresa/usrxemp?id_empresa=${primeraEmpresa}`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Empresa', 'Usuario guardado satisfactoriamente');
                    cargarTablaUsuarios();
                    $('#formUsuario2')[0].reset();
                    // Limpiar checkboxes
                    $('.empresa-checkbox').prop('checked', false);
                    $('#modalAgregarUsuarioCli').modal('hide');
                } else {
                    alertSwal('error', 'Empresa', r.code.code);
                    cargarTablaUsuarios();
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

    e.preventDefault(e);
});

// Agrega este código si quieres un checkbox "Seleccionar todos"
function agregarCheckboxSeleccionarTodos() {
    const thead = $('#tabla-empresas thead tr');
    thead.prepend(`
        <th width="50px" class="text-center">
            <input type="checkbox" id="seleccionar-todos">
        </th>
    `);
    
    $('#seleccionar-todos').on('change', function() {
        $('.empresa-checkbox').prop('checked', $(this).prop('checked'));
    });
    
    // Actualizar estado de "seleccionar todos" cuando cambien checkboxes individuales
    $('#tbody-empresas').on('change', '.empresa-checkbox', function() {
        const totalCheckboxes = $('.empresa-checkbox').length;
        const checkedCheckboxes = $('.empresa-checkbox:checked').length;
        $('#seleccionar-todos').prop('checked', totalCheckboxes === checkedCheckboxes);
    });
}

// Llama a esta función después de cargar la tabla


     /****************************
     * carga la tabla de servicios CombosClientes
     * ************/
     function cargarTablaCombosClientes() {

        showModalLoading();
        let id_empresa = $('#id_empresa_vw_servicios').val();

        ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);

        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/comboCli/listaempresa?id_empresa=${id_empresa}`),
            dataType: "json",
            success: function (r) {
    
                $('#tbl-combosCli').DataTable().clear();
                $('#tbl-combosCli').DataTable().destroy();
    
                let t = $('#tbl-combosCli').DataTable({
                    paging: true,
                    ordering: true,
                    info: false,
                    searching: true,
                    order: [
                        [0, "asc"],
                    ],
                    //dom: '',
                });
    
                if (r.status == "success") {
                    r.data.forEach((cmbcli) => {
    
                        t.row.add([
                            cmbcli.nom_combo,
                            '$ ' + number_format(cmbcli.valor_bogota),
                            '$ ' + number_format(cmbcli.valor_externo),
                            `<button class="btn btn-xs btn-${(cmbcli.estado == 1) ? 'success' : 'danger'} btnEstadoComboCliente"
                                comboCliente=${cmbcli.id_combo_cli} estado=${cmbcli.estado}>
                                ${(cmbcli.estado == 1) ? 'Activo' : 'Inactivo'}    
                            </button>`,
                            (cmbcli.visible == 'S') ? 'Sí' : 'No',
                            // Si está inactivo no se puede editar
                            ((cmbcli.estado == 1) ? `<button class="btn btn-xs btn-warning btnEditComboCliente" comboCliente="${cmbcli.id_combo_cli}" comboEditar="1"><i class="fa fa-pencil"  aria-hidden="true"></i> Editar</button>`
                                : ``)
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

    //*****cargar la pantalla de la derecha "CombosClientes"
   $('#tbl-empresas').on('click', '.btnServicios', function () {

        const empresa = $(this).attr('empresa');
        $('#id_empresa_vw_servicios').val(empresa);
        $('#id_empresa_ser').val(empresa);

        $('#span-cliente-servicios').text($(this).attr('nombre_empresa'));

        $('#div-box-servicios').removeClass('hide');

        //esconde la tabla terceros en caso q este abierto
        $('#div-box-subempresas').addClass('hide');
        $('#div-box-terceros').addClass('hide');
        $('#div-box-usuarios').addClass('hide');

        //oculto una columna de la tabla empresas
        ocultarColumnaDataTable($('#tbl-empresas').DataTable(), [3]);

        $('#div-box-clientes').removeClass('col-md-12');
        $('#div-box-clientes').addClass('col-md-7');
        $('#id_servicios').val(empresa);

        cargarTablaCombosClientes();

    });

    //*****cargar modal de especificaciones de los clientes a Prohumanos
   $('#tbl-empresas').on('click', '.btnEspecificaciones', function () {

        $('#accion').val("PUT");
        const empresa = $(this).attr('empresa');
        //console.log(empresa);
        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/empresa?id_empresa=${empresa}`),
            dataType: "json",
            success: function (resp) {
                $('#id_empresa').val(resp.data.id_empresa);
                $('#especificacion_edit').val(resp.data.especificacion);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddEspecificacion').modal();

    });

    $('#btn-submit-especificaciones').on('click', function (e) {
        e.preventDefault();
        //if(validateFormFormacionEdit()){

            let method = $('#accion').val();    //Se Obtiene el tipo  de Metodo para hacer la accion en la base de datos
            let id_empresa = $('#id_empresa').val()      
            let data = {                                //Se Prepara la Data que va a ser modificada en la BD
                id_empresa: $('#id_empresa').val(),
                especificacion: $('#especificacion_edit').val(),
            }
            
    
               showModalLoading();
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/empresa/especificacion?id_empresa=${id_empresa}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Empresa', 'Empresa guardado satisfactoriamente');
                            cargarTablaEmpresas();
                            $('#formEspecificacion')[0].reset();
                            $('#modalAddEspecificacion').modal('hide')
                        } else {
                            alertSwal('error', 'Empresa', r.code.code);
                            cargarTablaEmpresas();
                        }
                    },
                    error: function (xhr, status, error) {
                        alertSwal('error', 'Error al cargar los datos.', xhr.responseText);
                    },
                    complete: function () {
                        hideModalLoading();
                    }
                });
        //}   
    })


     //Ocultar la pantalla de la derecha CombosCliente
     $('#btnCollapseServicios').on('click', function () {
        $('#div-box-servicios').addClass('hide');
        $('#div-box-clientes').addClass('col-md-12');
        $('#div-box-clientes').removeClass('col-md-7');

    });

    // Activa e Inactiva una Combo Cliente
    $('#tbl-combosCli').on('click', '.btnEstadoComboCliente', function (e) {
        e.preventDefault();
        $('#accion').val("PUT");
        var nuevoEstado = ($(this).attr("estado") == 1) ? 0 : 1;
        var nuevoEstadoDesc = (nuevoEstado == 1) ? "Activar" : "Inactivar";
        var nuevoEstadoMsj = (nuevoEstado == 1) ? "activó" : "inactivó";
        let id_combo_cliente = $(this).attr('comboCliente');

        Swal.fire({
            type: 'question',
            title: `${nuevoEstadoDesc} Combo Cliente`,
            text: `¿Está seguro de ${nuevoEstadoDesc}  este combo cliente?`,
            confirmButtonText: 'OK',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            focusCancel: true
        }).then(function (result) {
            if (result.value) {
                let method = $('#accion').val();
                let data = {
                    id_combo_cliente: id_combo_cliente,
                    estado: nuevoEstado,
                }
                $.ajax({
                    method: method,
                    headers: {
                        "access-token": getToken()
                    },
                    url: url_site(`api/comboCli/cambio-estado?id_combo_cli=${id_combo_cliente}`),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: "json",
                    success: function (r) {
                        if (r.status == "success") {
                            alertSwal('success', 'Combo Cliente', 'El Combo Cliente se ' + nuevoEstadoMsj + ' satisfactoriamente');
                            cargarTablaCombosClientes();
                            $('#formComboCliente')[0].reset();
                        } else {
                            alertSwal('error', 'Producto', r.code.code);
                            cargarTablaCombosClientes();
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


    //Boton agregar combo cliente
    $('.btnAdd-Servicios ').on('click', function () {
        $('.div-crear').removeClass('hide');
        $('.div-editar').addClass('hide');
        $('#formComboCliente')[0].reset();
        $('#accion').val("POST");
        $('#metodo').val("AGREGAR"); 
        
        $('#modalAddComboCliente').modal();    
        const id_empresa = $('#id_empresa_ser').val();

         loadSelectOption({
            url: url_site(`api/combo/lista-combos?estado=1`),
            input: [{
                id: 'id_combo',
                clearOptions: true,
                emptyText: 'Seleccione un Combo Servicio',
                selectedValue: ''
            },],
            columnKey: 'id_combo',
            columnDescription: 'nom_combo',
            responsePath: 'data'
         }) 
        
    });  

   //carga VALORES del COMBO cuando se selecciona
    $('#id_combo').on('change', function () {
        let id_combo = $('#id_combo').val();
        if (id_combo != 0) {

            showModalLoading();
            $.ajax({
                method: 'GET',
                headers: {
                    "access-token": getToken()
                },
                type: "GET",
                url: url_site(`api/combo?id_combo=${id_combo}`),
                dataType: "json",
                success: function (resp) {
                    $('#valor_bogota').val(resp.data.valor_bogota);
                    $('#valor_externo').val(resp.data.valor_externo);
                    $('#id_combo_cli').val(resp.data.id_combo);
                }
            }).done(function () {
                hideModalLoading();
            });
        }

    });


    // Crear Combo Cliente
    $('#btn-submit-comboCliente').on('click', function (e) {
        e.preventDefault(e);

        let metodo = $('#metodo').val();
       let id_combo = '';
       let url = '';
        
        switch (metodo) {
            case 'AGREGAR':
                method = 'POST';
                url = `api/comboCli/add`;
                id_combo = $('#id_combo').val();
                id_empresa = $('#id_empresa_ser').val();
                break;
            case 'EDITAR':
                method = 'PUT';
                id_combo =  $('#id_combo_cliEdit').val();
                url = `api/comboCli?id_combo=${id_combo}`;
                
                id_empresa = $('#id_empresa_ser').val();
                break;
        } 
        if (validateFormComboCli()) {

            let method = $('#accion').val();
            let data = {
                id_combo: id_combo,
                id_empresa: $('#id_empresa_ser').val(),
                valor_bogota: $('#valor_bogota').val(),
                valor_externo: $('#valor_externo').val(),
                estado: $('#estado').val(),
                visible: $('#visible').val()
            }


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
                    if (r.status == "success") {
                        alertSwal('success', 'Combo Clientes', 'Combo Cliente guardado satisfactoriamente');
                        cargarTablaCombosClientes();
                        $('#formComboCliente')[0].reset();
                        $('#modalAddComboCliente').modal('hide')
                    } else {
                        alertSwal('error', 'Combo Clientes', r.code.code);
                        cargarTablaCombosClientes();
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


     // Editar Combo Cliente
     $('#tbl-combosCli').on('click', '.btnEditComboCliente', function (e) {

        e.preventDefault();
        
        $('#empresa2').attr('readonly', true);
        $('#combo').attr('readonly', true);

        $('.div-crear').addClass('hide');
        $('.div-editar').removeClass('hide');
        $('#metodo').val("EDITAR");

        $('#accion').val("PUT");
        let id_combo_cli = $(this).attr('comboCliente');

        showModalLoading();
        $.ajax({
            headers: {
                "access-token": getToken()
            },
            type: "GET",
            url: url_site(`api/comboCli?id_combo_cli=${id_combo_cli}`),
            dataType: "json",
            success: function (resp) {
                $('#id_combo_cliEdit').val(resp.data.id_combo_cli);
                $('#combo').val(resp.data.nom_combo);
                $('#empresa2').val(resp.data.razon_social);
                $('#valor_bogota').val(resp.data.valor_bogota);
                $('#valor_externo').val(resp.data.valor_externo);
                $('#id_empresa').val(resp.data.id_empresa);
                $('#visible').val(resp.data.visible);
            }
        }).done(function () {
            hideModalLoading();
        });
        $('#modalAddComboCliente').modal();

    })



    function validateFormEmpresa() {
    let accion = $('#accion').val();
    let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#razon_social').val() == "" || $('#razon_social').val() == null) {
        alertSwal('error', 'Nombre Empresa', 'Este campo es obligatorio');
        $("#razon_social").focus();
        return false;
    }

    return true;

    }

    function validaChecks() {

    var checkboxEmp = document.getElementById('flag_subemp');
    checkboxEmp.addEventListener("change", validaCheckGroup, false);

    var checkboxGrp = document.getElementById('flag_grup');
    checkboxGrp.addEventListener("change", validaCheckEmp, false);

    function validaCheckGroup() {
        var checked = checkboxEmp.checked;
        if (checked) {
            document.getElementById('flag_grup').disabled = true;
            document.getElementById('flag_subemp').value = 1;
            document.getElementById('flag_grup').value = 0;
        } else {
            document.getElementById('flag_grup').disabled = false;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 0;
        }
    }

    function validaCheckEmp() {
        var checked = checkboxGrp.checked;
        if (checked) {
            document.getElementById('flag_subemp').disabled = true;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 1;
        } else {
            document.getElementById('flag_subemp').disabled = false;
            document.getElementById('flag_subemp').value = 0;
            document.getElementById('flag_grup').value = 0;
        }
    }

    }

    function validarCamposUsuario() {

    var accion = $('#accion').val();
    var expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if ($('#nombres').val() == "" || $('#nombres').val() == null) {
        alertSwal('error', 'Nombres', 'Este campo es obligatorio');
        $("#nombres").focus();
        return false;
    } else if ($('#email').val() == "" || $('#email').val() == null) {
        alertSwal('error', 'E-mail', 'Este campo es obligatorio');
        $("#email").focus();
        return false;
    } else if ($('#password').val() == "" || $('#password').val() == null) {
        alertSwal('error', 'Password', 'Este campo es obligatorio');
        $("#password").focus();
        return false;
    } else if ($('#perfil').val() == "" || $('#perfil').val() == null) {
        alertSwal('error', 'Perfil de Usuario', 'Este campo es obligatorio');
        $("#perfil").focus();
        return false;
    } else if ($('#password').val() != $('#password_confirma').val()) {
        alertSwal('error', 'Password', 'Las contraseñas no son iguales');
        $("#password_confirma").focus();
        return false;
    } else if (accion == "AGREGAR" && !(expreg.test($('#password').val()))) {
        alertSwal('warning', 'Password', 'La contraseña debe contener minimo 8 caracteres, usar al menos una Mayuscula un Número y un Simbolo.');
        $("#password").focus();
        return false;
    }
    else if (accion == "AGREGAR" && /[^a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]/.test($('#username').val())) {
        alertSwal('warning', 'Usuario', 'El usuario no puede tener caracteres especiales');
        $("#username").focus();
        return false;
    }

    return true;

    }

    function validateFormComboCli() {
        let accion = $('#accion').val();
        let expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;

    if (accion == "POST"){     
        if ($('#id_combo') == null || $('#id_combo').val() == "" ) {
            alertSwal('error', 'Combo', 'Este campo es obligatorio');
            $("#id_combo").focus();
            return false;
        } 
        else {
            return true;
        }
    }else if (accion == "PUT"){
        return true;
    }    
    }

    document.getElementById('archivo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const ext = file.name.split('.').pop().toLowerCase();
            if (!['jpg', 'png'].includes(ext)) {
                //alert('Solo se permiten archivos .jpg o .png');
                alertSwal('error', 'Solo se permiten archivos .jpg o .png');
                e.target.value = ''; // Limpia el input
            }
        }
    });

$(document).on('click', '#btnEliminarLogo', function () {
    let idEmpresa = $('#id_empresa').val();
    console.log(idEmpresa);
    let nombreLogo = $('#info-edit').text().trim();

    if (!idEmpresa) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo obtener el ID de la empresa.'
        });
        return;
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: `Se eliminará el logo "${nombreLogo}" de forma permanente.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    "access-token": getToken()
                },
                type: "DELETE", // o "POST" si tu API no acepta DELETE
                url: url_site(`api/empresa/delete_adjunto?id_empresa=${idEmpresa}`),
                data: JSON.stringify({ id_empresa: idEmpresa }),
                contentType: "application/json",
                success: function (resp) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: 'El logo ha sido eliminado correctamente.'
                    });

                    // Limpiar campos visuales
                    $('#info-edit').html('');
                    $('#btnEliminarLogo').hide();
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el logo.'
                    });
                }
            });
        }
    });
});

// Función para cargar empresas en el modal de edición
function cargarEmpresasEnTablaEdicion(idEmpresaUsuario, username, flagSubEmp, empresasUsuarioActual) {
    const usaEmpresasUsuario = String(flagSubEmp) === '1';

    const requestEmpresasDisponibles = $.ajax({
        method: 'GET',
        headers: { "access-token": getToken() },
        url: url_site(`api/empresa/empresausr?IdEmpresa=${idEmpresaUsuario}`)
    });

    if (usaEmpresasUsuario) {
        const requestEmpresasAsignadas = $.ajax({
            method: 'GET',
            headers: { "access-token": getToken() },
            url: url_site(`api/empresa/empresas-usuario?username=${username}`)
        });

        $.when(requestEmpresasDisponibles, requestEmpresasAsignadas)
            .done(function (respDisponibles, respAsignadas) {
                const disponibles = respDisponibles[0];
                const asignadas = respAsignadas[0];
                const empresasAsignadasIds = Array.isArray(asignadas.data)
                    ? asignadas.data.map(emp => String(emp.id_empresa || emp.usr_empresas))
                    : [];

                renderTablaEmpresasDisponibles(disponibles, empresasAsignadasIds);
            })
            .fail(function () {
                alertSwal('error', 'Error', 'No se pudieron cargar las empresas');
                $('#tbody-empresas-edit').html('<tr><td colspan="2" class="text-center">Error al cargar empresas</td></tr>');
            });
    } else {
        requestEmpresasDisponibles
            .done(function (disponibles) {
                const empresasAsignadasIds = Array.isArray(empresasUsuarioActual)
                    ? empresasUsuarioActual.map(emp => String(emp.id_empresa || emp.usr_empresas))
                    : [];

                renderTablaEmpresasDisponibles(disponibles, empresasAsignadasIds);
            })
            .fail(function () {
                alertSwal('error', 'Error', 'No se pudieron cargar las empresas');
                $('#tbody-empresas-edit').html('<tr><td colspan="2" class="text-center">Error al cargar empresas</td></tr>');
            });
    }
}

function renderTablaEmpresasDisponibles(respuestaEmpresas, empresasAsignadasIds = []) {
    if (respuestaEmpresas.status == "success" && Array.isArray(respuestaEmpresas.data) && respuestaEmpresas.data.length > 0) {
        const tbody = $('#tbody-empresas-edit');
        tbody.empty();

        respuestaEmpresas.data.forEach(empresa => {
            const empresaId = String(empresa.usr_empresas);
            const estaSeleccionada = empresasAsignadasIds.includes(empresaId);

            const row = `
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="empresa-checkbox-edit" 
                               value="${empresaId}" 
                               data-razonsocial="${empresa.razon_social_sub}"
                               ${estaSeleccionada ? 'checked' : ''}>
                    </td>
                    <td>${empresa.razon_social_sub}</td>
                </tr>
            `;
            tbody.append(row);
        });

        actualizarContadorEdicion();
        configurarSeleccionarTodosEdicion();
    } else {
        $('#tbody-empresas-edit').html('<tr><td colspan="2" class="text-center">No hay empresas disponibles</td></tr>');
    }
}

// Configurar "Seleccionar todos" para edición
function configurarSeleccionarTodosEdicion() {
    $('#seleccionar-todos-edit').off('change').on('change', function() {
        $('.empresa-checkbox-edit').prop('checked', $(this).prop('checked'));
        actualizarContadorEdicion();
    });
    
    // Actualizar estado de "seleccionar todos" cuando cambien checkboxes individuales
    $('#tbody-empresas-edit').off('change', '.empresa-checkbox-edit').on('change', '.empresa-checkbox-edit', function() {
        const totalCheckboxes = $('.empresa-checkbox-edit').length;
        const checkedCheckboxes = $('.empresa-checkbox-edit:checked').length;
        $('#seleccionar-todos-edit').prop('checked', totalCheckboxes === checkedCheckboxes);
        actualizarContadorEdicion();
    });
}

// Actualizar contador de empresas seleccionadas en edición
function actualizarContadorEdicion() {
    const count = $('.empresa-checkbox-edit:checked').length;
    $('#contador-empresas-edit').text(`(${count} empresa${count !== 1 ? 's' : ''} seleccionada${count !== 1 ? 's' : ''})`);
}

// Obtener empresas seleccionadas en edición
function obtenerEmpresasSeleccionadasEdicion() {
    const empresasSeleccionadas = [];
    $('.empresa-checkbox-edit:checked').each(function() {
        empresasSeleccionadas.push({
            id: $(this).val(),
            razon_social: $(this).data('razonsocial')
        });
    });
    return empresasSeleccionadas;
}

// Modificar el evento de edición de usuarios
$('#tbl-usuarios2').on('click', '.btnEditarUsuariosCli', function (e) {
    const user = $(this).attr('username');
    const id_emp = $(this).attr('id_empresa');
    
    $('#id_user_empresa').val(user);
    $('#id_empresa_usuario_edit').val(id_emp);
    $('#accion').val("PUT");
    $('#username1').val(user).prop('readonly', true);

    // Limpiar y cargar datos del usuario
    $.ajax({
        headers: { 'access-token': getToken() },
        type: "GET",
        url: url_site(`api/usuario/empresasxuser?id_empresa=${id_emp}&user=${user}`),
        dataType: "json",
        success: function (r) {
            if (r.data && r.data.length > 0) {
                const usuario = r.data[0];
                
                // Llenar campos del formulario
                $('#nombres1').val(usuario.nombres);
                $('#apellidos1').val(usuario.apellidos);
                $('#tipo_identificacion1').val(usuario.codigoTipoIden);
                $('#numero_identificacion1').val(usuario.numero_identificacion);
                $('#cargo1').val(usuario.cargo);
                $('#email1').val(usuario.correo);
                $('#bandera_bash1').val(usuario.bandera_bash);

                // Cargar perfil
                loadSelectOption({
                    url: url_site(`api/perfil/lista-perfiles?tipo=E`),
                    input: [{
                        id: 'perfil1',
                        clearOptions: true,
                        emptyText: 'Seleccione un perfil',
                        selectedValue: usuario.idperfil
                    }],
                    columnKey: 'id',
                    columnDescription: 'descripcion',
                    responsePath: 'data'
                });

                // Mostrar/ocultar bandera bash según perfil
                if (['7'].includes(usuario.idperfil)) {
                    $('#bandera_bashinput1').show();
                } else {
                    $('#bandera_bashinput1').hide();
                }

                const flagSubEmp = usuario.flag_subemp;
                $('#flag_subemp_usuario').val(flagSubEmp || 0);
                // Cargar empresas con las actuales seleccionadas
                cargarEmpresasEnTablaEdicion(id_emp, user, flagSubEmp, r.data);
            }
        }
    });

    e.preventDefault();
    $('#modalEditarUsuarioCli').modal();
});

// Modificar el evento de guardar en edición
$('#btn-edit-usuario3').on('click', function (e) {  
    e.preventDefault();   
    
    const empresasSeleccionadas = obtenerEmpresasSeleccionadasEdicion();
    const flagSubEmp = $('#flag_subemp_usuario').val();
    const requiereEmpresas = String(flagSubEmp) === '1';
    
    if (requiereEmpresas && empresasSeleccionadas.length === 0) {
        alertSwal('warning', 'Empresa', 'Debe seleccionar al menos una empresa');
        return false;
    }

    let method = $('#accion').val();
    let data = {
        username: $('#username1').val(),
        empresas: empresasSeleccionadas,
        email: $('#email1').val(),
        nombres: $('#nombres1').val(),
        apellidos: $('#apellidos1').val(),
        tipo_identificacion: $('#tipo_identificacion1').val(),
        numero_identificacion: $('#numero_identificacion1').val(),
        perfil: $('#perfil1').val(),
        cargo: $('#cargo1').val(),
        bandera_bash: $('#bandera_bash1').val(),
        id_empresa_padre: $('#id_empresa_usuario_edit').val(),
        flag_subemp: flagSubEmp
    };

    if (validarCamposUsuarioEdicion()) {
        showModalLoading();
        $.ajax({
            method: method,
            headers: {
                "access-token": getToken()
            },
            url: url_site(`api/usuario/editaruseremp`),
            contentType: 'application/json',
            data: JSON.stringify(data),
            dataType: "json",
            success: function (r) {
                if (r.status == "success") {
                    alertSwal('success', 'Usuario', 'Usuario actualizado satisfactoriamente');
                    cargarTablaUsuarios();
                    $('#formUsuario3')[0].reset();
                    $('#modalEditarUsuarioCli').modal('hide');
                } else {
                    alertSwal('error', 'Usuario', r.code.code);
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

// Función de validación para edición (sin validación de password)
function validarCamposUsuarioEdicion() {
    if ($('#nombres1').val() == "" || $('#nombres1').val() == null) {
        alertSwal('error', 'Nombres', 'Este campo es obligatorio');
        $("#nombres1").focus();
        return false;
    } else if ($('#email1').val() == "" || $('#email1').val() == null) {
        alertSwal('error', 'E-mail', 'Este campo es obligatorio');
        $("#email1").focus();
        return false;
    } else if ($('#perfil1').val() == "" || $('#perfil1').val() == null) {
        alertSwal('error', 'Perfil de Usuario', 'Este campo es obligatorio');
        $("#perfil1").focus();
        return false;
    }
    return true;
}

