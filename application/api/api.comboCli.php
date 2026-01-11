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
            echo json_encode(CtrTrcComboCli::findById($router->param('id_combo_cli')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcComboCli::findAll(
                $router->param('estado') ? $router->param('estado') : '-1' 
            ));
            return;
            break;
        
        case 'listaempresa':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcComboCli::findAllCliente(
                    $router->param('id_empresa')
            ));
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
        case 'add':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            //print_r($v_id_empresa);
            echo json_encode(
                CtrTrcComboCli::crear(
                    $v_id_combo,
                    $v_id_empresa,
                    $v_valor_bogota,
                    $v_valor_externo,
                    $v_estado,
                    $v_visible,
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

            if ($router->param('id_combo_cli') != $v_id_combo_cli) {
                echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
                return;
                break;
            }

            echo json_encode(CtrTrcComboCli::delete($router->param('id_combo_cli')));
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
                CtrTrcComboCli::update(
                    $router->param('id_combo'),
                    $v_valor_bogota,
                    $v_valor_externo,
                    $v_visible,

                )
            );
            return;
            break;

            case 'cambio-estado':
                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);

             /*   if ($v_estado == 1) {
                    $v_estado_nuevo = 0;
                }else { $v_estado_nuevo = 1;} */

                echo json_encode(CtrTrcComboCli::cambiarEstado($router->param('id_combo_cli'),$v_estado));
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
