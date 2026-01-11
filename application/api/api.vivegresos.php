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
            echo json_encode(CtrVivEgresos::findByIdEgresos($router->param('id_egreso')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivEgresos::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'lista_noexists':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrVivEgresos::findAllNoExists($router->param('tipo_concepto_egreso')));
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
                CtrVivEgresos::crear(
                    $v_id_solicitud,
                    $v_id_servicio,
                    $v_concepto_ingreso,
                    $v_otros,
                    $v_periocidad,
                    $v_tipo_familiar,
                    $v_valor_egreso,
                    $v_total_egreso
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
        case 'delete_egresos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivEgresos::delete(
                    $router->param('id_egreso'),
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
        case 'update_egresos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivEgresos::update(
                    $router->param('id_egreso'),
                    $v_concepto_ingreso,
                    $v_otros,
                    $v_periocidad,
                    $v_tipo_familiar,
                    $v_valor_egreso,
                    $v_total_egreso
                )
            );
            return;
            break;
        case 'update_egresos_pol_pre':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrVivEgresos::update_pol_pre(
                    $router->param('id_egreso'),
                    //$v_concepto_ingreso,
                    $v_otros,
                    //$v_periocidad,
                    $v_tipo_familiar,
                    $v_valor_egreso
                    //$v_total_egreso
                )
            );
            return;
            break;
            case 'update_egresos_pol_rutina':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                echo json_encode(
                    CtrVivEgresos::update_pol_rutina(
                        $router->param('id_egreso'),
                        //$v_concepto_ingreso,
                        $v_otros,
                        //$v_periocidad,
                        $v_tipo_familiar,
                        $v_valor_egreso
                        //$v_total_egreso
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
