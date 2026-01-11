<?php

use ValidateToken;

$permitidos_sin_login = array("login", "is-logged", "reset-password", "autenticar");
$permitido = in_array($router->get(3), $permitidos_sin_login);

if (!$permitido) {
    if (!ValidateToken::autentication()) {
        echo "Acceso denegado";
        http_response_code(401);
        return;
    }
}

$raw_input = file_get_contents("php://input");
$put_vars = null;

if ($raw_input !== false && $raw_input !== "") {
    $json_body = json_decode($raw_input, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($json_body)) {
        $put_vars = $json_body;
    } else {
        $parsed = [];
        parse_str($raw_input, $parsed);
        if (!empty($parsed)) {
            $put_vars = $parsed;
        }
    }
}

if (empty($put_vars)) {
    if (isset($_POST) && !empty($_POST)) {
        $put_vars = $_POST;
    } else {
        $put_vars = $_GET;
    }
}

extract($put_vars, EXTR_PREFIX_ALL, "v");

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    switch (strtolower($router->get(3))) {
        case "roles":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode($_SESSION[constant('APP_NAME')]['user']['roles']);
            return;
            break;

        case "session":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode($_SESSION);
            return;
            break;

        case "is-logged":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(array("logged" => CtrUsuario::isLogged(false)));
            return;
            break;

        case "lista":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::findAll());
            return;
            break;

        case "lista_usr_cli":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::findAllUsrCli());
            return;
            break;

        case "existe":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $existe = CtrUsuario::consultar($router->param('username'));
            if ($existe['password'] != null) {
                echo json_encode(array_merge(array(
                    'existe' => true,
                    "nombre" => $existe['nombres'],
                    "email" => $existe['email']
                )));
                return;
            } else {
                echo json_encode(array('existe' => false));
                return;
            }
            break;

        case "empresas":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::findByUsrXEmpresa($router->param('id_empresa')));
            return;
            break;

        case "empresasxuser":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
                    echo json_encode(CtrUsuario::findByUsrXEmpresaUser($router->param('id_empresa'),$router->param('user') ));
            return;
            break;   

        case "info":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::consultar($router->get(4)));
            return;
            break;

        case "expired-password":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $usuario = CtrUsuario::getUsuarioApp();
            $respuesta_usr = CtrUsuario::consultar($usuario);
            $now = new DateTime(date("Y-m-d"));
            $expires_on = new  DateTime($respuesta_usr['password_expiration']);
            if ($now > $expires_on || ($respuesta_usr['primer_acceso'] == 'N')) {
                $expired = true;
                if ($respuesta_usr['primer_acceso'] == 'N') {
                    $mensaje = 'Es el primer acceso cambie la contraseña';
                    $obj_usuario = new Usuario($usuario);
                    $obj_usuario->setPrimerAcceso('S');
                    $obj_usuario->update();
                }else{
                    $mensaje = 'Su contraseña ha expirado y debe cambiarla';
                }
            }
            //$expired = $now > $expires_on;
            //print_r($respuesta_usr['primer_acceso']);
            echo json_encode(array(
                'expired' => $expired,
                'mensaje' => $mensaje,
                "expires_on" => $expires_on->format('Y-m-d'),
                "now" => $now->format('Y-m-d')
            ));
            return;
            break;

        case "access-log":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::accessLog($router->get(4)));
            return;
            break;

        case "proveedores-lista":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::findAllProveedores());
            return;
            break;


        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

    switch (strtolower($router->get(3))) {
        case "activar":
        case "inactivar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::cambiarEstado($v_username, strtoupper(substr($router->get(3), 0, 3))));
            return;
            break;

        case "editaruseremp":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_usr = CtrUsuario::actualizarUserEmp($put_vars);
            echo json_encode($respuesta_usr);
            return;
            break; 
              
        case "editar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_usr = CtrUsuario::actualizar(
                $v_username,
                $v_id_empresa,
                $v_email,
                $v_nombres,
                $v_apellidos,
                $v_tipo_identificacion,
                $v_numero_identificacion,
                $v_perfil
            );
            echo json_encode($respuesta_usr);
            return;
            break;
        case "login":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta = CtrUsuario::login($v_username, $v_password);
            echo json_encode($respuesta);
            return;
            break;

        case "cambiar-password":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(
                CtrUsuario::cambiarPassword(
                    $_SESSION[constant('APP_NAME')]['user']['username'],
                    $v_password_old,
                    $v_password_new
                )
            );
            return;
            break;

        case "reset-password":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_usr = CtrUsuario::resetPassword($v_username);
            echo json_encode($respuesta_usr);
            return;
            break;

        case "skin":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_skin = CtrUsuario::cambiarSkin($_SESSION[constant('APP_NAME')]['user']['username'], $router->get(4));
            if ($respuesta_skin['success']) {
                $_SESSION[constant('APP_NAME')]['user']['modo'] = $router->get(4);
            }
            echo json_encode($respuesta_skin);
            return;
            break;

        case "autenticar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta = CtrUsuario::login($v_username, $v_password);
            echo json_encode($respuesta);
            break;

        case "agregar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_usr = CtrUsuario::crear(
                $v_username,
                $v_id_empresa,
                $v_email,
                $v_password,
                $v_nombres,
                $v_apellidos,
                $v_tipo_identificacion,
                $v_numero_identificacion,
                $v_perfil
            );
            echo json_encode($respuesta_usr);
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
    switch (strtolower($router->get(3))) {
        case "activar":
        case "inactivar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::cambiarEstado($v_username, strtoupper(substr($router->get(3), 0, 3))));
            return;
            break;
        case "inactivar-candidato":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode(CtrUsuario::cambiarEstadoCandidato($router->param('username')));
            return;
            break;
        case "editar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_usr = CtrUsuario::actualizar(
                $v_username,
                $v_id_empresa,
                $v_email,
                $v_nombres,
                $v_apellidos,
                $v_tipo_identificacion,
                $v_numero_identificacion,
                $v_perfil
            );
            echo json_encode($respuesta_usr);
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    switch (strtolower($router->get(3))) {
        case "eliminar":
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            $respuesta_usr = CtrUsuario::eliminar($v_username);
            echo json_encode($respuesta_usr);
            return;
            break;

        default:
            /*
            * Si no se llama algun metodo autorizado: 400 Bad Request
            */
            http_response_code(400);
            return;
            break;
    }
}
