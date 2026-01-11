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
            echo json_encode(CtrRefPersonales::findByIdRefPersonal($router->param('id_ref_personal')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrRefPersonales::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'lista_sin_srv':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrRefPersonales::findSinSrvAll($router->param('id_solicitud')));
            return;
            break;

        case 'obs_ref_personales':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionById($router->param('id_solicitud'), $router->param('id_servicio'), $router->param('tipo_observacion')));
            return;
            break;

        case 'obs_ref_personales_sin_svr':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrObservaciones::observacionSinSrvById($router->param('id_solicitud'), $router->param('tipo_observacion')));
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
                CtrRefPersonales::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_referencia_personal,
                    $v_nombre,
                    $v_telefono,
                    $v_concepto,
                    $v_observacion_adicional,
                )
            );
            return;
            break;
            case 'crear_obs_referencia':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrObservaciones::crear(
                        $v_id_solicitud,
                        $v_id_servicio,
                        $v_tipo_observacion,
                        $v_observacion

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
        case 'delete_obs_adicional':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrRefPersonales::delete(
                    $router->param('id_ref_personal'),
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
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {
        case 'update_obs_adicional':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrRefPersonales::update(
                    $router->param('id_ref_personal'),
                    $v_referencia_personal,
                    $v_nombre,
                    $v_telefono,
                    $v_concepto,
                    //$v_observacion_adicional,
                )
            );
            return;
            break;
        case 'update_obs_referencia':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrObservaciones::update(
                    $v_id_observacion,
                    $v_observacion

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
            break;
    }
}
