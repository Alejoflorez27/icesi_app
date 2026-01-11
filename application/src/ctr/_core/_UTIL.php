<?php

class CtrUtil
{

    public static function alertSwal($type, $title, $text)
    {
        echo '<script>
                    Swal.fire({
                            type: "' . $type . '",
                            title: "' . $title . '",
                            text: "' . $text . '",
                            showConfirmButton: false,
                            confirmButtonText: "Cerrar"
                    });
                </script>';
    }

    public static function alertSwalR($type, $title, $text, $redirect)
    {
        echo '<script>
                    Swal.fire({
                            type: "' . $type . '",
                            title: "' . $title . '",
                            text: "' . $text . '",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                    }).then(function(result){
                            if(result.value){
                                    window.location = "' . $redirect . '";
                            }
                    });
                </script>';
    }

    public static function console_log($m)
    {
        echo "<script>console.log(\"$m\")</script>";
    }

    public static function redirect($redirect)
    {
        echo '<script>window.location = "' . $redirect . '"; </script>';
    }

    public static function alertJs($m)
    {
        echo "<script>alert(\"$m\")</script>";
    }

    public static function fechaAdd($fecha, $dias_add = 0, $meses_add = 0, $anos_add = 0)
    {

        $fecha_inicial = $fecha;

        $fecha_final = mktime(
            0,
            0,
            0 //hora, minuto, segundo
            ,
            date("m", $fecha_inicial) + $meses_add //mes
            ,
            date("d", $fecha_inicial) + $dias_add //dia
            ,
            date("Y", $fecha_inicial) + $anos_add //año
        );

        return $fecha_final;
    }

    public static function generarPIN($longitud)
    {
        $pin = "";
        for ($i = 0; $i < $longitud; $i++) {
            $pin .= rand(0, 9);
        }
        return $pin;
    }

    public static function generarRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#.<>()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getContents($url)
    {
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'GET',
            )
        );
        $context = stream_context_create($options);
        $result = json_decode((file_get_contents($url, false, $context)), true);

        return $result;
    }

    public static function encontrarEnLista($lista, $valor, $columnaBuscar = 0, $columnaRetornar = 1)
    {
        foreach ($lista as $k => $v) {
            if ($v[$columnaBuscar] == $valor) {
                return $v[$columnaRetornar];
            }
        }
    }

    // public static function getListaSRC($ruta)
    // {
    //     $app_domain = CtrReferencias::val('app', 'domain');
    //     $app_url = CtrReferencias::val('app', 'url');
    //     $url_lista = $app_domain . $constant('APP_URL') . $ruta;
    //     $lista = CtrUtil::getContents($url_lista);
    //     return $lista;
    // }

    // public static function url_site($ruta)
    // {
    //     $app_domain = CtrReferencias::val('app', 'domain');
    //     $app_url = CtrReferencias::val('app', 'url');
    //     return $app_domain . $constant('APP_URL') . $ruta;
    // }

    public static function DateToArray($input)
    {
        $fecha = explode('-', explode(' ', $input)[0]);
        $hora = explode(':', explode(' ', $input)[1]);

        $output = array(
            "year" => $fecha[0],
            "month" => $fecha[1],
            "day" => $fecha[2],
            "hour" => $hora[0],
            "minutes" => $hora[1],
            "seconds" => $hora[2]
        );

        return $output;
    }

    public static function getClienteIP()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function distanciaGps($point1, $point2, $unit = 'm', $decimals = 2)
    {
        $point1_lat = $point1[0];
        $point1_long = $point1[1];

        $point2_lat = $point2[0];
        $point2_long = $point2[1];

        // Cálculo de la distancia en grados
        $degrees =
            rad2deg(
                acos(
                    (sin(deg2rad($point1_lat)) *
                        sin(deg2rad($point2_lat))) +
                        (cos(deg2rad($point1_lat)) *
                            cos(deg2rad($point2_lat)) *
                            cos(deg2rad($point1_long - $point2_long)))
                )
            );

        // Conversión de la distancia en grados a la unidad escogida (kilómetros, millas o millas naúticas)
        switch (strtolower($unit)) {
            case 'km':
                $distance = $degrees * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
                break;
            case 'm':
                $distance = $degrees * (111.13384 * 1000); // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
                break;
            case 'mi':
                $distance = $degrees * 69.05482; // 1 grado = 69.05482 millas, basándose en el diametro promedio de la Tierra (7.913,1 millas)
                break;
            case 'nmi':
                $distance =  $degrees * 59.97662; // 1 grado = 59.97662 millas naúticas, basándose en el diametro promedio de la Tierra (6,876.3 millas naúticas)
        }
        return round($distance, $decimals);
    }

    public static function wtf($var)
    {
        error_log(var_export($var, true));
    }

    public static function log($var)
    {
        self::wtf($var);
    }

    public static function uploadFile($input_name, $destination_directory = null, $destination_file_name = null, $private_username = false, $only_file_types = array())
    {
        if (!empty($_FILES)) {

            $username = CtrUsuario::getUsuarioApp();
            $origin_file = $_FILES[$input_name]['tmp_name'];
            $extension_file =   strrchr($_FILES[$input_name]['name'], ".");

            if (is_array($only_file_types) && !empty($only_file_types)) {
                if (!in_array(substr($extension_file, 1), $only_file_types)) {
                    return BaseResponse::error(__FUNCTION__, "Tipo de archivo no permitido: " . $extension_file);
                }
            }

            $destination_directory = isset($destination_directory) ? $destination_directory : constant('APP_ROUTES_UPLOADS') . 'tmp/';

            $destination_file_name = isset($destination_file_name) ? $destination_file_name : self::UUIDv4();
            $destination_file_name .= $extension_file;
            $destination_file_name = $private_username ? $username . '_' . $destination_file_name : $destination_file_name;

            $destination_full_path = $destination_directory . $destination_file_name;

            $file_info = array(
                "origin_file" => $origin_file,
                "directory" => $destination_directory,
                "file_name" => $destination_file_name,
                "full_path" => $destination_full_path,
                "extension" => $extension_file
            );

            if (is_uploaded_file($origin_file)) {
                if (move_uploaded_file($origin_file, $destination_full_path)) {
                    return BaseResponse::success($file_info, "Archivo cargado con éxito.");
                } else {
                    return BaseResponse::error(__FUNCTION__, "No se pudo guardar el archivo en directorio destino.", $file_info);
                }
            } else {
                return BaseResponse::error(__FUNCTION__, "No se pudo cargar el archivo.", $file_info);
            }
        } else {
            return BaseResponse::error(__FUNCTION__, "No existen archivos para cargar.");
        }
    }

    public static function readFileContentToArray($origin_file, $separador = ",", $min_columns = 1, $onlyStrictColumns = false)
    {
        $data = array();

        if (is_dir($origin_file)) {
            return BaseResponse::error(__FUNCTION__, "No es archivo, es un directorio.");
        }

        if (!file_exists($origin_file)) {
            return BaseResponse::error(__FUNCTION__, "Archivo no existe.");
        }

        $fp = fopen($origin_file, "r");

        if ($fp === false) {
            return BaseResponse::error(__FUNCTION__, "No se pudo abrir el archivo.");
        }

        while (!feof($fp)) {
            $current_line = fgets($fp);
            $array_on_line = explode($separador, $current_line);
            if (($onlyStrictColumns && sizeof($array_on_line) >= $min_columns) || !$onlyStrictColumns)
                array_push($data, $array_on_line);
        }

        fclose($fp);

        if (empty($data))
            return BaseResponse::error(__FUNCTION__, "No se pudo leer el archivo o no se encontraron lineas.");

        return BaseResponse::success($data, "Archivo leído con éxito.");
    }

    public static function UUIDv4($data = null)
    {
        // Fuente:   https://www.uuidgenerator.net/dev-corner/php
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
