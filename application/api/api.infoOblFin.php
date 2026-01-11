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
            echo json_encode(CtrInfoOblFin::findByIdInfoOblFin($router->param('id_info_obl_fin')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrInfoOblFin::findAll($router->param('id_solicitud'), $router->param('id_servicio')));
            return;
            break;

        case 'totales':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrInfoOblFin::totales($router->param('id_solicitud'), $router->param('id_servicio')));
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
                CtrInfoOblFin::crear(
                    $v_id_solicitud, 
                    $v_id_servicio, 
                    $v_entidad, 
                    $v_producto_clase, 
                    $v_fch_expedicion, 
                    $v_fch_terminacion, 
                    $v_cupo_inicial, 
                    $v_saldo_pendiente, 
                    $v_pago_minimo, 
                    $v_estado_obligacion, 
                    $v_calidad, 
                    $v_valor_mora, 
                    $v_edad_mora
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
        case 'delete_info_obl_fin':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrInfoOblFin::delete(
                    $router->param('id_info_obl_fin'),
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
        case 'update_info_obl_fin':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrInfoOblFin::update(
                    $router->param('id_info_obl_fin'),
                    $v_entidad, 
                    $v_producto_clase, 
                    $v_fch_expedicion, 
                    $v_fch_terminacion, 
                    $v_cupo_inicial, 
                    $v_saldo_pendiente, 
                    $v_pago_minimo, 
                    $v_estado_obligacion, 
                    $v_calidad, 
                    $v_valor_mora, 
                    $v_edad_mora
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
