<?php

trait ValidateToken
{
    public static function autentication()
    {
        if (!constant('APP_SAFE')) {
            return true;
        }

        $username = $_SESSION[constant('APP_NAME')]['user']['username'];
        $token = CtrUsuario::consultar($username)['token'];

        // El usuario no tiene token
        if (!isset($token) && !empty($token)) {
            return false;
        }

        // la sesion no esta logueada
        if (!constant('APP_SAFE') && $_SESSION[constant('APP_NAME')]['status'] !== "LOGIN") {
            return false;
        }

        foreach (getallheaders() as $nombre => $valor) {
            if ($nombre === 'access-token') {
                if ($valor === $token) {
                    return true;
                }
            }
        }
        return false;
    }
}

trait BaseResponse
{
    public static function success($_data = null, $_message = null)
    {
        http_response_code(200);
        return array(
            "status" => 'success',
            "action" => $_message,
            "data" => $_data
        );
    }

    public static function error($_action, $_code, $_data = null)
    {
        if (http_response_code() != 401)
            http_response_code(400);
        return array(
            "status" => 'error',
            "action" => $_action,
            "code" => array(
                "success" => false,
                "action" => $_action,
                "code" => isset($_code['code']) ? $_code['code'] : $_code,
            ),
            "data" => $_data
        );
    }

public static function errorprueba($action, $message)
{
    return [
        'status' => 'error',
        'action' => $action,
        'message' => $message,
        'data' => null
    ];
}

    public static function getData($_result)
    {
        return $_result['status'] == 'success' ? $_result['data'] : null;
    }

    public static function isSuccess($_result)
    {
        return $_result['status'] == 'success';
    }

    public static function isError($_result_)
    {
        return $_result_['status'] == 'error';
    }
}

trait Validate
{
    private static function field($name, $var, $type = 'string', $required = false, $min_length = null, $max_length = null)
    {
        $name = str_replace('_', ' ', $name);

        if ($required)
            if (!isset($var) || $var == "")
                return array("valid" => false, "message" => "$name es requerido");

        if (in_array(strtolower($type), ['numeric', 'number', 'double', 'int', 'integer']))
            if (!is_numeric($var) && $required)
                return array("valid" => false, "message" => "$name debe ser númerico");

        if (in_array(strtolower($type), ['array', 'list']))
            if (!is_array($var) && $required)
                return array("valid" => false, "message" => "$name debe ser un array");

        if (in_array(strtolower($type), ['email', 'mail']))
            if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $var) == 0 && $required)
                return array("valid" => false, "message" => 'email no es válido');

        if (in_array(strtolower($type), ['date', 'datetime', 'time']))
            if (strtotime($var) === false  && $required)
                return array("valid" => false, "message" => "$name no es válido");

        if ((isset($var) && $var != "") && (isset($min_length) && (strlen($var) < $min_length)))
            return array("valid" => false, "message" => "$name debe tener longitud mínima $min_length");

        if ((isset($var) && $var != "") && (isset($max_length) && (strlen($var) > $max_length)))
            return array("valid" => false, "message" => "$name debe tener longitud máxima $max_length");

        return array("valid" => true);
    }

    public static function fields(&$data)
    {
        $valid = true;
        $data['validation'] = array("valid" => $valid, "message" => "");
        foreach ($data['inputs'] as $idx => &$input) {
            $input['validation'] =
                self::field(
                    $input['name'],
                    $input['value'],
                    $input['type'] ?? 'string',
                    $input['required'] ?? false,
                    $input['min_length'] ?? null,
                    $input['max_length'] ?? null
                );
            if ($valid && !$input['validation']['valid'])
                $data['validation'] = $input['validation'];

            $valid = $valid && $input['validation']['valid'];
        }
        return $data;
    }
}


trait Result
{
    public static function success($_data = null, $_message = null)
    {
        return array(
            "status" => 'success',
            "action" => $_message,
            "data" => $_data
        );
    }

    public static function error($_action, $_code, $_data = null)
    {
        return array(
            "status" => 'error',
            "action" => $_action,
            "code" => array(
                "success" => false,
                "action" => $_action,
                "code" => isset($_code['code']) ? $_code['code'] : $_code,
            ),
            "data" => $_data
        );
    }

    public static function getData($_result)
    {
        return $_result['status'] == 'success' ? $_result['data'] : null;
    }

    public static function isSuccess($_result)
    {
        return $_result['status'] == 'success';
    }

    public static function isError($_result_)
    {
        return $_result_['status'] == 'error';
    }
}
