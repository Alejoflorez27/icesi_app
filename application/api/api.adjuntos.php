<?php

$recurso = $router->get(3);

$permitidos_sin_login = array(); //end-points permitidos sin login
$permitido = in_array($router->get(3), $permitidos_sin_login);  

if (!$permitido) {
    if (!ValidateToken::autentication()) {
        http_response_code(403);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Result::error(__FUNCTION__, "Acceso denegado"));
        return;
    }
}

$put_vars = json_decode(file_get_contents("php://input"), true);
if (!isset($put_vars))
    $put_vars = isset($_POST) && !empty($_POST) ? $_POST : $_GET;
extract($put_vars, EXTR_PREFIX_ALL, "v");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    switch (strtolower($recurso)) {
        case 'empresa':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolAdjuntos::trae_Id_Empresa($router->param('id_solicitud')));
            return;
            break;
        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolAdjuntos::findAll());
            return;
            break;
        case 'descripcion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolAdjuntos::descripcionAdjunto($router->param('id_solicitud')));
            return;
            break;

        case 'descripcion_visita_ingreso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
        echo json_encode(CtrSolAdjuntos::descripcionAdjuntoVisitaIngreso($router->param('id_solicitud')/*, $router->param('id_servicio')*/));
            return;
            break;
        case 'descripcion_visita_teletrabajo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
        echo json_encode(CtrSolAdjuntos::descripcionAdjuntoVisitaTeletrabajo($router->param('id_solicitud')/*, $router->param('id_servicio')*/));
            return;
            break;
        case 'descripcion_visita_asociado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
        echo json_encode(CtrSolAdjuntos::descripcionAdjuntoVisitaAsociado($router->param('id_solicitud')/*, $router->param('id_servicio')*/));
            return;
            break;

        case 'descripcion_adjuntos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
        echo json_encode(CtrSolAdjuntos::descripcionAdjuntos($router->param('id_solicitud')/*, $router->param('id_servicio')*/));
            return;
            break;
        case 'descripcion_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
        echo json_encode(CtrSolAdjuntos::descripcionAdjuntoPOP($router->param('id_solicitud')/*, $router->param('id_servicio')*/));
            return;
            break;
        case 'cliente_solicitud':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolAdjuntos::findByClienteSolicitud($router->param('id_solicitud')));
            return;
            break;
        case 'validar_variable':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolAdjuntos::ExiteVariable($router->param('id_pregunta'), $router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

       /* case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            $expected_filters = ['fecha_desde', 'fecha_hasta', 'cliente', 'estado', 'servicio', 'asesor'];
            $filter = array();
            foreach ($expected_filters as $f) {
                $filter[$f] = ($router->param($f) === false || $router->param($f) == '') ? '' : $router->param($f);
            }
            echo json_encode(CtrSolicitud::findAllWithFilters($filter));
            return;
            break;
        case 'dashboard':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolicitud::dashboardResume());
            return;
            break;
            */
        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($recurso)) {
        case 'archivo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api recibe todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                    $v_lista
                )
            );
            return;
            break;
        case 'archivo_visita_ingreso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_visita_ingreso( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_visita_mantenimiento':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_visita_mantenimiento( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_visita_teletrabajo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_visita_teletrabajo( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_visita_asociado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_visita_asociado( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivos_adjuntos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_adjuntos( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                    $v_lista
                )
            );
            return;
        break;
        case 'archivos_adjuntos_multiple':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_adjuntos_multiple( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                    $v_lista
                )
            );
            return;
        break;
        case 'archivos_adjuntos_auto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_adjuntos_auto( 
                    $v_id_empresa,
                    $v_usuario
                )
            );
            return;
        break;
        case 'archivos_sol_auto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_adjuntos_sol_auto( 
                    $router->param('id_solicitud'),
                    $v_usuario,
                    $v_contactar_empleador,
                    $v_instituciones,
                    $v_grabacion,
                    $v_registro_foto,
                    $v_acepto,
                    $v_fch_candidato_auto
                )
            );
            return;
        break;
        case 'archivo_ec_sin_cifin':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_ec_sin_cifin( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_eb_cons_cifin':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_eb_cons_cifin( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_eb_consulta':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_eb_consulta( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_pol_pre( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
        case 'archivo_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_pol_rutina( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;

        case 'archivo_pol_especifico':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                //Este api resive todos los datos que esten dentro del fomulario tanto en el html y los hidden
                CtrSolAdjuntos::new_pol_especifico( 
                    $v_accion_candidato,
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_tipo_doc,
                    $v_observacion,
                )
            );
            return;
        break;
       /*     case 'archivo':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrSolAdjuntos::new(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_nombre,
                        $v_directorio,
                        $v_ext,
                        $v_tamano,
                        $v_tipo_doc
                    )
                );
                return;
                break; */
        /*
        case 'cargue':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolicitud::importFile($v_cliente));
            return;
            break;
        */
    /*    case 'archivo':
           // print_r('HOLA');
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolAdjuntos::fileUpload(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_nombre,
                    $v_directorio,
                    $v_ext,
                    $v_tipo_doc
                )
            );
            return;
            break;   */     

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {
        /*case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                SolAdjuntos::update(
                    $router->param('id'),
                    $v_nombre_candidato,
                    $v_numero_identificacion,
                    $v_celular,
                    $v_email,
                    $v_direccion,
                    $v_cargo
                )
            );
            return;
            break;
        */
        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {
        case 'delete_adjunto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSolAdjuntos::delete(
                    $router->param('id_adjunto'),
                )
            );
            return;
            break;
        case 'eliminarDoc':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSolAdjuntos::findByIdDoc($v_id_adjunto));
            return;
            break;
        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    switch (strtolower($recurso)) {
        case 'publicar':
        case 'gestionar':
        case 'finalizar':
        /*case 'cancelar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $estado = array(
                'publicar' => 'pendiente',
                'gestionar' => 'gestion',
                'finalizar' => 'finalizada',
                'cancelar' => 'cancelada'
            );
            echo json_encode(
                CtrSolicitud::update_state(
                    $router->param('cliente'),
                    $router->param('id'),
                    $estado[strtolower($recurso)]
                )
            );
            return;
            break;*/
        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
}
