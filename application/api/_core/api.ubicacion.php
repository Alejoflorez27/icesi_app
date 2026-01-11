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

        case 'pais':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findAllPais($router->param('idPais') ? $router->param('idPais') : '-1'));
            return;
            break;

        case 'dto':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findDtosXPais($router->param('idPais'), $router->param('id_dpto') ? $router->param('id_dpto') : '-1'));
            return;
            break;

        case 'ciudad':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findCiudaXDtos($router->param('idDpto')));
            return;
            break;

        case 'ciudad-id':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findXCiudadxId($router->param('idCiudad')));
            return;
            break;
        
        
        case 'pais-edit':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findAllPais($router->param('idPais') ? $router->param('idPais') : '-1'));
            return;
            break;
               

        case 'dto-edit':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findDtosXPais($router->param('idPais'), $router->param('id_dpto') ? $router->param('id_dpto') : '-1'));
            return;
            break;

        case 'ciudad-edit':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUbicacion::findCiudaXDtos($router->param('idDpto')));
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
}
