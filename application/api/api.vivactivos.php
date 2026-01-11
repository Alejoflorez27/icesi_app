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
            echo json_encode(CtrVivActivos::findByIdActivos($router->param('id_activo')));
            return;
            break;
        case 'activos_by_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivActivos::findByIdActivosPolPre($router->param('id_activo')));
            return;
            break;

        case 'activos_by_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivActivos::findByIdActivosPolRutina($router->param('id_activo')));
            return;
            break;

        case 'lista_vi':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivActivos::findAllCandidato($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'lista_vm':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivActivos::findAllFuncionario($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'lista_noexists':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivActivos::findAllNoExists($router->param('tipo_activo_vi')));
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
                CtrVivActivos::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_concepto_activo,
                    $v_otros,
                    $v_tipo_familiar,
                    $v_otro_propietario,
                    $v_descripcion_general_viv,
                    $v_valor_activo,
                    $v_valor_activo_catastral
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
        case 'delete_activos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivActivos::delete(
                    $router->param('id_activo'),
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
        case 'update_activos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivActivos::update(
                    $router->param('id_activo'),
                    $v_concepto_activo,
                    $v_otros,
                    $v_tipo_familiar,
                    $v_otro_propietario,
                    $v_descripcion_general_viv,
                    $v_valor_activo,
                    $v_valor_activo_catastral,
                )
            );
            return;
            break;
        case 'update_activos_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivActivos::updatePolPre(
                    $router->param('id_activo'),
                    $v_otros
                )
            );
            return;
            break;
        case 'update_activos_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivActivos::updatePolRutina(
                    $router->param('id_activo'),
                    $v_otros
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
