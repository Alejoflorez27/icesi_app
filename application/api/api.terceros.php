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
            echo json_encode(Result::error(__FUNCTION__, "RASTREEEOOOOOOO  GET"));
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcTerceros::findById($router->param('id_empresa')));
            return;
            break;

        case 'lista':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcTerceros::findById($router->param('id_empresa')));
            return;
            break;

        case 'listasub':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrTrcTerceros::findByIdSube($router->param('id_empresa')));
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
                CtrTrcTerceros::crear(
                    $v_nom_tercero,
                    $v_id_empresa


                    // $v_razon_social,
                    // $v_rep_legal,
                    // $v_tipo_id,
                    // $v_numero_doc,
                    // $v_id_ciudad,
                    // $v_email_emp,
                    // $v_flag_subemp,
                    // $v_flag_grup,
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
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    switch (strtolower($recurso)) {
            // case 'activar':
            // case 'inactivar':
            //     header("Content-Type: application/json; charset=UTF-8");
            //     http_response_code(200);
            //     echo json_encode(
            //         CtrTrcTerceros::update_state(
            //             $router->param('id'),
            //             strtolower($recurso) == 'activar' ? 'A' : 'I'
            //         )
            //     );
            //     return;
            //     break;
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

            // case "ACTIVAR":
            // case "INACTIVAR":
            //     header("Content-Type: application/json; charset=UTF-8");
            //     http_response_code(200);
            //     $nuevo_estado = strtoupper(substr($router->get(3), 0, 1));
            //     $resp_empresa = CtrTrcTerceros::cambiarEstado($v_id, $nuevo_estado);
            //     echo json_encode($resp_empresa);
            //     return;
            //     break;

            // case "":
            //     header("Content-Type: application/json; charset=UTF-8");
            //     http_response_code(200);
            //     echo json_encode(
            //         CtrTrcTerceros::update(
            //             $router->param('id_empresa'),
            //             $v_razon_social,
            //             $v_rep_legal,
            //             $v_tipo_id,
            //             $v_numero_doc,
            //             $v_id_ciudad,
            //             $v_email_emp,
            //             $v_flag_subemp,
            //             $v_flag_grup
            //         )
            //     );
            //     return;
            //     break;

            case 'cambio-estado':

                header("Content-Type: application/json; charset=UTF-8");
                http_response_code(200);
                
                
              /*  if ($v_estado_ter == 1) {
                    $v_estado_nuevo = 0;
                } else {
                    $v_estado_nuevo = 1;
                } */

                echo json_encode(CtrTrcTerceros::cambiarEstado($router->param('id_tercero'), $v_estado_ter));
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
