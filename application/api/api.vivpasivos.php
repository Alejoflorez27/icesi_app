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
            echo json_encode(CtrVivPasivos::findByIdPasivos($router->param('id_pasivo')));
            return;
            break;

        case 'pasivo_by_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivPasivos::findByIdPasivosPolPre($router->param('id_pasivo')));
            return;
            break;

        case 'pasivo_by_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivPasivos::findByIdPasivosPolRutina($router->param('id_pasivo')));
            return;
            break;

        case 'lista_vi':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivPasivos::findAllCandidato($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'lista_vm':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivPasivos::findAllFuncionario($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'totales':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivPasivos::totales($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;
        case 'lista_noexists':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivPasivos::findAllNoExists($router->param('tipo_pasivo_vi')));
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
                CtrVivPasivos::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_concepto_pasivo,
                    $v_otros,
                    $v_tipo_familiar,
                    $v_otro_propietario,
                    $v_valor_pasivo,
                    $v_plazo_pasivo,
                    $v_couta,
                    $v_estado_obligacion,
                    $v_valor_mora,

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
        case 'delete_pasivos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivPasivos::delete(
                    $router->param('id_pasivo'),
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
        case 'update_pasivos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivPasivos::update(
                    $router->param('id_pasivo'),
                    $v_concepto_pasivo,
                    $v_otros,
                    $v_tipo_familiar,
                    $v_otro_propietario,
                    $v_valor_pasivo,
                    $v_plazo_pasivo,
                    $v_couta,
                    $v_estado_obligacion,
                    $v_valor_mora
                )
            );
            return;
            break;

        case 'update_pasivos_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivPasivos::updatePolPre(
                    $router->param('id_pasivo'),
                    $v_otros)
            );
            return;
            break;

        case 'update_pasivos_pol_rutina':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivPasivos::updatePolRutina(
                    $router->param('id_pasivo'),
                    $v_otros)
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
