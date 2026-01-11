<?php

use ValidateToken;

$permitidos_sin_login = array();
$permitido = in_array($router->get(3), $permitidos_sin_login);

if (!$permitido) {
    if (!ValidateToken::autentication()) {
        echo "Acceso denegado";
        http_response_code(401);
        return;
    }
}

parse_str(file_get_contents("php://input"), $put_vars);
extract($put_vars, EXTR_PREFIX_ALL, "v");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    switch (strtolower($router->get(3))) {

        case "lista":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPerfil::consultarTodos());
            return;
            break;
        
        case "lista-perfiles":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $tipo = $router->param('tipo');
         //   print_r($tipo);
            echo json_encode(CtrPerfil::consultarPerfiles($tipo));
            return;
            break;  

        case "perfiles-servicios":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPerfil::consultarPerfilesServicios());
            return;
            break;

        case "asig-perfiles-servicios":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPerfil::consultarAsigPerfilesServicios());
            return;
            break;

        case "info":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPerfil::consultar($router->get(4)));
            return;
            break;


        case "menu":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrPerfilMenu::consultarTree($router->get(4)));
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($router->get(3))) {
        case "agregar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $resp_perfil = CtrPerfil::crear($v_descripcion, $v_estado);
            echo json_encode($resp_perfil);
            return;
            break;

        case "activar":
        case "inactivar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $nuevo_estado = strtoupper(substr($router->get(3), 0, 1));
            $resp_perfil = CtrPerfil::cambiarEstado($v_id, $nuevo_estado);
            echo json_encode($resp_perfil);
            return;
            break;

        case "agregar-menu":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $resp_perfil_menu = CtrPerfilMenu::crear($v_perfil, $v_nodo);
            echo json_encode($resp_perfil_menu);
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    switch (strtolower($router->get(3))) {

        case "editar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $resp_perfil = CtrPerfil::actualizar($v_id, $v_descripcion, $v_estado);
            echo json_encode($resp_perfil);
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    switch (strtolower($router->get(3))) {


        case "eliminar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $resp_perfil = CtrPerfil::eliminar($v_id);
            echo json_encode($resp_perfil);
            return;
            break;

        case "eliminar-menu":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $resp_perfil_menu = CtrPerfilMenu::eliminar($v_perfil, $v_nodo);
            echo json_encode($resp_perfil_menu);
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
    }
}
