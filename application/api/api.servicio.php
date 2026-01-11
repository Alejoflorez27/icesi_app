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
if (isset($put_vars))
    extract($put_vars, EXTR_PREFIX_ALL, "v");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    switch (strtolower($recurso)) {
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::findByIdServicio($router->param('id_servicio')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::findAll(
                $router->param('estado') ? $router->param('estado') : '-1'
            ));
            return;
            break;

        case 'listas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::consultarTodos());
            return;
            break;

        case 'calidad-lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosCalidad());
            return;
            break;

        case 'calidad-lista-agrupada':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosCalidadAgrupados());
            return;
            break;

        case 'asignar-lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosAsignar());
            return;
            break;

        case 'seguimiento-lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosSeguimiento($router->param('username_asig'),$router->param('perfil'),$router->param('estado_servicio')));
            return;
            break;

        case 'usuarios-calidad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::usuariosCalidad());
            return;
            break;

        case 'usuarios-asignacion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::usuariosAsignacion($router->param('perfil')));
            return;
            break;

        case 'info-servicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::infoServicio($router->param('servicio')));
            return;
            break;

        case 'servicios-finalizados':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosFinalizados($router->param('username')));
            return;
            break;

        case 'servicios-calificados':

            $expected_filters = ['fecha_desde', 'fecha_hasta', 'proveedor'];
            $filter = array();
            foreach ($expected_filters as $f) {
                $filter[$f] = ($router->param($f) === false || $router->param($f) == '') ? '' : $router->param($f);
            }

            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosCalificados($filter));
            return;
            break;



        case 'sol-servicio-calificado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::infoServicioByFact($router->param('id')));
            return;
            break;
            
        case 'producto-servicios':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvServicio::serviciosXProductos($router->param('cliente'), $router->param('producto')));
            return;
            break;

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
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSrvServicio::crear(
                    $v_id_producto,
                    $v_nom_servicio,
                    $v_tipo_servicio,
                    $v_estado,
                    $v_reporte,
                    $v_ruta_reporte,
                    $v_valor_bogota,
                    $v_valor_fuera_bogota,
                    $v_valor_adicional,
                )
            );
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */

            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            if ($router->param('id_servicio') != $v_id_servicio) {
                echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
                return;
                break;
            }

            echo json_encode(CtrSrvServicio::delete($router->param('id_servicio')));
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {
        case '':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSrvServicio::update(
                    $router->param('id_servicio'),
                    $v_id_producto,
                    $v_nom_servicio,
                    $v_tipo_servicio,
                    $v_estado,
                    $v_reporte,
                    $v_ruta_reporte,
                    $v_valor_bogota,
                    $v_valor_fuera_bogota,
                    $v_valor_adicional,
                )
            );
            return;
            break;

        case 'cambio-estado':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            if ($v_estado == 1) {
                $v_estado_nuevo = 0;
            } else {
                $v_estado_nuevo = 1;
            }

            echo json_encode(CtrSrvServicio::cambiarEstado($router->param('id_servicio'), $v_estado_nuevo));
            return;
            break;

        case 'asig-usrcalidad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrSrvServicio::asigUsrCalidad($router->param('id'), $v_id_usuario_calidad, $v_prioridad));
            return;
            break;

        case 'asig-usrcalidad-masivo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrSrvServicio::asigUsrCalidadMasivo($v_array, $v_id_usuario_calidad, $v_prioridad));
            return;
            break;

        case 'asig-usr-masivo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            echo json_encode(CtrSrvServicio::asigUsrMasivo($v_array, $v_id_usuario_calidad));
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
}
