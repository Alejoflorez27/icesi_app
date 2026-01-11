<?php

$recurso = $router->get(3);

$permitidos_sin_login = array(); //end-points permitidos sin login
$permitido = in_array($router->get(3), $permitidos_sin_login);

if (!$permitido) {
    if (!ValidateToken::autentication()) {
        http_response_code(401);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(BaseResponse::error(__FUNCTION__, "Acceso denegado"));
        return;
    }
}

$put_vars = json_decode(file_get_contents("php://input"), true);

if (isset($put_vars))
    extract($put_vars, EXTR_PREFIX_ALL, "v");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    switch (strtolower($recurso)) {
        case 'lugar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrLista::lugar());
            return;
            break;

        case 'tipo_identificacion':
        case 'cargo':
        case 'rol':
        case 'asignacion':
        case 'turno':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrConfiguracion::consultarTodosCategoria($recurso));
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($recurso)) {

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    switch (strtolower($recurso)) {

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
}
