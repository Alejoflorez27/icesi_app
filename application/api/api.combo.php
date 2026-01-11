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
            echo json_encode(CtrSrvCombos::findById($router->param('id_combo')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvCombos::findAll());
            return;
            break;


        case 'listacomboservicio':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvCombos::findAllByCombo($router->param('id_combo')));
            return;
            break;

        case 'combo':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvCombos::findAllActive());
            return;
            break;

        case 'combo-cliente':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvCombos::findAllComboCliente($router->param('id_empresa')));
            return;
            break;

        case 'lista-combos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrSrvCombos::listaCombos());
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
                CtrSrvCombos::crear(
                    $v_nom_combo,
                    $v_valor_bogota,
                    $v_sla_bogota,
                    $v_valor_externo,
                    $v_sla_externo,
                    $v_env_correo
                )
            );
            return;
            break;

        case 'servicio-agregar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSrvComboServicios::crear(
                    $v_id_servicio,
                    $v_id_combo
                )
            );
            return;
            break;

        case 'servicio-eliminar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrSrvComboServicios::delete(
                    $v_id_servicio,
                    $v_id_combo,
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

            if ($router->param('id_combo') != $v_id_combo) {
                echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
                return;
                break;
            }

            echo json_encode(CtrSrvCombos::delete($router->param('id_combo')));
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
                CtrSrvCombos::update(
                    $router->param('id_combo'),
                    $v_nom_combo,
                    $v_valor_bogota,
                    $v_sla_bogota,
                    $v_valor_externo,
                    $v_sla_externo,
                    $v_env_correo
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

            echo json_encode(CtrSrvCombos::cambiarEstado($router->param('id_combo'), $v_estado_nuevo));
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
