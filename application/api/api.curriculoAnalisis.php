<?php

$recurso = $router->get(3);

$permitidos_sin_login = array();
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

        case 'dashboard':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrCurriculo::dashboard());
            return;
            break;

        case 'listar-cursos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);

            $filtros = array(
                'programa' => ($router->param('programa') === false || $router->param('programa') == '') ? '' : $router->param('programa'),
                'competencia' => ($router->param('competencia') === false || $router->param('competencia') == '') ? '' : $router->param('competencia'),
                'objetivo' => ($router->param('objetivo') === false || $router->param('objetivo') == '') ? '' : $router->param('objetivo'),
                'nivel' => ($router->param('nivel') === false || $router->param('nivel') == '') ? '' : $router->param('nivel')
            );

            echo json_encode(CtrCurriculo::listarCursos($filtros));
            return;
            break;

        case 'listar-programas':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrCurriculo::listarProgramas());
            return;
            break;

        case 'listar-competencias':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrCurriculo::listarCompetencias());
            return;
            break;

        case 'listar-objetivos':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrCurriculo::listarObjetivos());
            return;
            break;

        case 'analisis-cobertura':
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrCurriculo::obtenerAnalisisCobertura());
            return;
            break;

        default:
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch (strtolower($recurso)) {

        default:
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    switch (strtolower($recurso)) {

        default:
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    switch (strtolower($recurso)) {

        default:
            http_response_code(400);
            echo json_encode(Result::error(__FUNCTION__, "Recurso no encontrado"));
            return;
            break;
    }
}
