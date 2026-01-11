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

parse_str(file_get_contents("php://input"), $put_vars);
extract($put_vars, EXTR_PREFIX_ALL, "v");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    switch (strtolower(trim($recurso))) {
        case 'aspecto_descripcion':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrConfiguracion::consultar_factor(
                    $router->param('categoria'),
                    $router->param('codigo')
                )
            );
            return;

        case 'estado_proceso':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrConfiguracion::estado_proceso_srv($router->param('categoria'))
            );
            return;

        default: // 👈 aquí va lo genérico ($recurso cualquiera)
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrConfiguracion::consultarTodosCategoria($recurso));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($recurso)) {
        case 'agregar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrConfiguracion::crear($v_categoria, $v_codigo, $v_descripcion, $v_observacion));
            return;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {
        case 'editar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrConfiguracion::actualizar($v_categoria, $v_codigo, $v_descripcion, $v_observacion, $v_estado));
            return;
            break;
        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {
        case 'eliminar':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrConfiguracion::eliminar($v_categoria, $v_codigo));
            return;
            break;
        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            echo json_encode(BaseResponse::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
}
