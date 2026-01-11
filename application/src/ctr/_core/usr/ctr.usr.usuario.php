<?php

class CtrUsuario
{

    public static function crear()
    {
        
        //print_r($_POST);
        //print_r($_FILES);
       
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $tipo_identificacion = $_POST['tipo_identificacion'];
        $numero_identificacion = $_POST['numero_identificacion'];
        $perfil = $_POST['perfil'];
        $registro = $_POST['registro'];
       

        if (!isset($nombres) || $nombres == "")
            return BaseResponse::error(__FUNCTION__, "nombres es requerido");

        if (!isset($apellidos) || $apellidos == "")
            return BaseResponse::error(__FUNCTION__, "apellidos es requerido");

        if (!isset($tipo_identificacion) || $tipo_identificacion == "")
            return BaseResponse::error(__FUNCTION__, "tipo_identificacion es requerido");

        if (!isset($numero_identificacion) || $numero_identificacion == "")
            return BaseResponse::error(__FUNCTION__, "numero_identificacion es requerido");

        if (!isset($perfil) || $perfil == "")
            return BaseResponse::error(__FUNCTION__, "perfil es requerido");

        if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email) == 0)
            return BaseResponse::error(__FUNCTION__, "email no es valido");


        //cargue archivo de firma        
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_arc = $_FILES['archivo']['name'];
        $directorio = NULL;
        $extension_archivo_origen = NULL;
        $nuevo_nombre_archivo = NULL;
        $binario_nombre_temporal = $_FILES['archivo']['tmp_name'];
        $binario_contenido = NULL;

        if(isset($nombre_arc)){ 
            $objusuario = new CtrUsuario();
            $resultdir =  $objusuario->uploadFile($username);
            $directorio = $resultdir;

            //print_r($resultdir);

           // $binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
           // Obtener del array FILES (superglobal) los datos del binario .. nombre, tabamo y tipo.

            $extension_archivo_origen = strrchr($nombre_arc, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;
        }    

       // print_r($directorio);
        
        $obj_usuario = new Usuario();
        $obj_usuario->setUsername($username);
       // $obj_usuario->setProperty('id_empresa', $idEmpresa);
        $obj_usuario->setEmail($email);
        $obj_usuario->setPassword(self::encriptar($password));
        $obj_usuario->setProperty('nombres', $nombres);
        $obj_usuario->setProperty('apellidos', $apellidos);
        $obj_usuario->setProperty('tipo_identificacion', $tipo_identificacion);
        $obj_usuario->setProperty('numero_identificacion', $numero_identificacion);
        $obj_usuario->setPerfil($perfil);
        $obj_usuario->setEstado("ACT");
        $obj_usuario->setProperty("nom_firma", $nombre_arc);
        $obj_usuario->setProperty("nombre_encr", $nuevo_nombre_archivo);
        $obj_usuario->setProperty("directorio", $directorio);
        $obj_usuario->setProperty("tamano", $tamano);
        $obj_usuario->setProperty("ext_firma", $extension_archivo_origen);
        $obj_usuario->setProperty("registro", $registro);
       // $obj_usuario->setProperty("firma", $binario_contenido);


        $result = $obj_usuario->insert(); 
        if ($result['success']) {
            $correo = Result::getData(self::enviarCorreo($username, $nombres .' '. $apellidos, $email,'CREA',$password));
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }  

        //return $directorio; */
    }



    public static function actualizar()
    {
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_arc = $_FILES['archivo']['name'];
        $directorio = NULL;
        $extension_archivo_origen = NULL;
        $nuevo_nombre_archivo = NULL;

    
        $nomLogo = $_POST['nomLogo'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        //$password = $_POST['password'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $tipo_identificacion = $_POST['tipo_identificacion'];
        $numero_identificacion = $_POST['numero_identificacion'];
        $perfil = $_POST['perfil'];
        $nomLogo = $_POST['nomLogo'];
        $registro = $_POST['registro'];

       // print_r($_POST);
       // print_r($_FILES);

        if (!isset($nombres) || $nombres == "")
            return BaseResponse::error(__FUNCTION__, "nombres es requerido");

        if (!isset($apellidos) || $apellidos == "")
            return BaseResponse::error(__FUNCTION__, "apellidos es requerido");

        if (!isset($tipo_identificacion) || $tipo_identificacion == "")
            return BaseResponse::error(__FUNCTION__, "tipo_identificacion es requerido");

        if (!isset($numero_identificacion) || $numero_identificacion == "")
            return BaseResponse::error(__FUNCTION__, "numero_identificacion es requerido");

        if (!isset($perfil) || $perfil == "")
            return BaseResponse::error(__FUNCTION__, "perfil es requerido");

        if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email) == 0)
            return BaseResponse::error(__FUNCTION__, "email no es valido");

        
        $obj_usuario = new Usuario($username);

        if (($tamano != 0) && ($nomLogo != $nombre_arc)){

            $objusuario = new CtrUsuario();
            $resultdir =  $objusuario->uploadFile($username);
            $directorio = $resultdir;

            //print_r($resultdir);

            $extension_archivo_origen = strrchr($nombre_arc, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen; 
            
            $obj_usuario->setEmail($email);
           // $obj_usuario->setPassword(self::encriptar($password));
            $obj_usuario->setProperty('nombres', $nombres);
            $obj_usuario->setProperty('apellidos', $apellidos);
            $obj_usuario->setProperty('tipo_identificacion', $tipo_identificacion);
            $obj_usuario->setProperty('numero_identificacion', $numero_identificacion);
            $obj_usuario->setPerfil($perfil);
            $obj_usuario->setProperty("registro", $registro);
           // $obj_usuario->setEstado("ACT");
            $obj_usuario->setProperty("nom_firma", $nombre_arc);
            $obj_usuario->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $obj_usuario->setProperty("directorio", $directorio);
            $obj_usuario->setProperty("tamano", $tamano);
            $obj_usuario->setProperty("ext_firma", $extension_archivo_origen);
            //$obj_usuario->setProperty("firma", $binario_contenido);
         
        }else{

            $obj_usuario->setEmail($email);
           // $obj_usuario->setPassword(self::encriptar($password));
            $obj_usuario->setProperty('nombres', $nombres);
            $obj_usuario->setProperty('apellidos', $apellidos);
            $obj_usuario->setProperty('tipo_identificacion', $tipo_identificacion);
            $obj_usuario->setProperty('numero_identificacion', $numero_identificacion);
            $obj_usuario->setPerfil($perfil);
            $obj_usuario->setProperty("registro", $registro);
        }


        $result =  $obj_usuario->update();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        } 
    }

    public static function actualizarUserEmp($requestData = null)
    {
        $data = is_array($requestData) && !empty($requestData) ? $requestData : $_POST;

        $nombres = $data['nombres1'] ?? $data['nombres'] ?? null;
        $apellidos = $data['apellidos1'] ?? $data['apellidos'] ?? null;
        $tipo_identificacion = $data['tipo_identificacion1'] ?? $data['tipo_identificacion'] ?? null;
        $numero_identificacion = $data['numero_identificacion1'] ?? $data['numero_identificacion'] ?? null;
        $perfil = $data['perfil1'] ?? $data['perfil'] ?? null;
        $email = $data['email1'] ?? $data['email'] ?? null;
        $username = $data['username1'] ?? $data['username'] ?? null;
        $cargo = $data['cargo1'] ?? $data['cargo'] ?? null;
        $bandera_bash = $data['bandera_bash1'] ?? $data['bandera_bash'] ?? null;
        $id_empresa_padre = $data['id_empresa_usuario_edit'] ?? $data['id_empresa_padre'] ?? null;
        $flag_subemp = $data['flag_subemp_usuario'] ?? $data['flag_subemp'] ?? null;
        $empresasSeleccionadas = $data['empresas'] ?? array();

        if (!isset($nombres) || $nombres == "")
            return BaseResponse::error(__FUNCTION__, "nombres es requerido");

        if (!isset($apellidos) || $apellidos == "")
            return BaseResponse::error(__FUNCTION__, "apellidos es requerido");

        if (!isset($tipo_identificacion) || $tipo_identificacion == "")
            return BaseResponse::error(__FUNCTION__, "tipo_identificacion es requerido");

        if (!isset($numero_identificacion) || $numero_identificacion == "")
            return BaseResponse::error(__FUNCTION__, "numero_identificacion es requerido");

        if (!isset($perfil) || $perfil == "")
            return BaseResponse::error(__FUNCTION__, "perfil es requerido");

        if (!isset($username) || $username == "")
            return BaseResponse::error(__FUNCTION__, "username es requerido");

        if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email) == 0)
            return BaseResponse::error(__FUNCTION__, "email no es valido");

        $esSubEmpresa = intval($flag_subemp) === 1;

        if ($id_empresa_padre == "" || $id_empresa_padre == null) {
            // Si no llega en la solicitud, se intenta recuperar de la empresa actual
            $empresaUsuario = CtrTrcEmpresa::findByIdPadre($data['id_empresa_usuario_edit'] ?? $data['id_empresa'] ?? null);
            if ($empresaUsuario && isset($empresaUsuario['data'][0]['id_empresa'])) {
                $id_empresa_padre = $empresaUsuario['data'][0]['id_empresa'];
                if ($flag_subemp === null) {
                    $flag_subemp = $empresaUsuario['data'][0]['flag_subemp'];
                    $esSubEmpresa = intval($flag_subemp) === 1;
                }
            }
        }

        if ($esSubEmpresa && ($id_empresa_padre == "" || $id_empresa_padre == null)) {
            return BaseResponse::error(__FUNCTION__, "id_empresa_padre es requerido para subempresas");
        }

        $empresasNormalizadas = self::normalizarEmpresasSeleccionadas($empresasSeleccionadas);
        $debeSincronizarEmpresas = $esSubEmpresa && !empty($empresasNormalizadas);

        $obj_usuario = new Usuario($username);
        $obj_usuario->setEmail($email);
        $obj_usuario->setProperty('nombres', $nombres);
        $obj_usuario->setProperty('apellidos', $apellidos);
        $obj_usuario->setProperty('tipo_identificacion', $tipo_identificacion);
        $obj_usuario->setProperty('numero_identificacion', $numero_identificacion);
        $obj_usuario->setProperty('cargo', $cargo);
        $obj_usuario->setProperty('bandera_bash', $bandera_bash);
        $obj_usuario->setPerfil($perfil);

        if ($id_empresa_padre != "" && $id_empresa_padre != null) {
            $obj_usuario->setProperty('id_empresa', $id_empresa_padre);
        }

        $result =  $obj_usuario->update();
        if (!$result['success']) {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }

        if ($debeSincronizarEmpresas) {
            $syncResult = self::sincronizarEmpresasUsuario($username, $empresasNormalizadas);
            if ($syncResult['status'] == 'error') {
                return $syncResult;
            }
        }

        return BaseResponse::success($result);
    }

    private static function normalizarEmpresasSeleccionadas($empresas)
    {
        if (!is_array($empresas)) {
            return array();
        }

        $ids = array();
        foreach ($empresas as $empresa) {
            $id = null;
            if (is_array($empresa)) {
                $id = $empresa['id'] ?? $empresa['id_empresa'] ?? $empresa['usr_empresas'] ?? null;
            } elseif (is_object($empresa)) {
                $id = $empresa->id ?? $empresa->id_empresa ?? $empresa->usr_empresas ?? null;
            } else {
                $id = $empresa;
            }

            if ($id !== null && $id !== '') {
                $ids[] = (string)$id;
            }
        }

        return array_values(array_unique($ids));
    }

    private static function sincronizarEmpresasUsuario($username, $empresasSeleccionadas)
    {
        $actuales = array();
        $actualesResp = CtrTrcEmpresa::findEmpresasByUsuario($username);
        if (isset($actualesResp['status']) && $actualesResp['status'] == 'success' && is_array($actualesResp['data'])) {
            foreach ($actualesResp['data'] as $empresa) {
                if (isset($empresa['id_empresa'])) {
                    $actuales[] = (string)$empresa['id_empresa'];
                }
            }
        }

        $aAgregar = array_diff($empresasSeleccionadas, $actuales);
        $aEliminar = array_diff($actuales, $empresasSeleccionadas);

        foreach ($aAgregar as $idEmpresa) {
            $resp = CtrTrcEmpresa::asignarEmpresaUsuario($username, $idEmpresa);
            if (!isset($resp['success']) || !$resp['success']) {
                return BaseResponse::error(__FUNCTION__, "No fue posible asociar la empresa " . $idEmpresa);
            }
        }

        if (!empty($aEliminar)) {
            $usrEmp = new UsrEmpr();
            foreach ($aEliminar as $idEmpresa) {
                $resp = $usrEmp->deleteWhere(array(
                    "username" => $username,
                    "id_empresa" => $idEmpresa
                ));

                if (!isset($resp['success']) || !$resp['success']) {
                    return BaseResponse::error(__FUNCTION__, "No fue posible eliminar la empresa " . $idEmpresa);
                }
            }
        }

        return BaseResponse::success(null, "sincronizar empresas");
    }
    
    public static function eliminar()
    {

        $username = $_POST['username'];    

        if (!isset($username) || $username == "")
            return BaseResponse::error(__FUNCTION__, "username es requerido");

        $obj_usuario = new Usuario($username);

        $result =  $obj_usuario->delete();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function consultar($username = null)
    {
        if (isset($username) && $username != "" && $username != null) {
            $obj_usuario = new Usuario($username);
            return $obj_usuario->getThisAllProperties();
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    // public static function consultarTodos()
    // {
    //     return QuerySQL::select(SQL_USR_USUARIO_LIST);
    // }

    public static function findAll()
    {
        $result = QuerySQL::select(
            <<<SQL
                    Select u.username, u.id_empresa , u.email, u.password, u.nombres, u.apellidos, u.tipo_identificacion,
                        u.numero_identificacion, u.estado, u.modo, u.perfil, u.last_login, u.nom_firma, p.descripcion AS perfil_desc, 
                        case when u.id_empresa is not null then
                        (select te.razon_social  from trc_empresa te where te.id_empresa = u.id_empresa)
                        else
                        null
                        end empresa
                     FROM  usr_usuario u, usr_perfil p
                WHERE u.perfil=p.id
                 and p.id not in (7,8,9,14)
            SQL,
            array(),
            true,
            "N"
        );

        //print_r($result);
        return BaseResponse::success($result, "buscar usuarios");
    }

    public static function findAllUsrCli()
    {
        $result = QuerySQL::select(
            <<<SQL
                    Select u.username, u.id_empresa , u.email, u.password, u.nombres, u.apellidos, u.tipo_identificacion,
                        u.numero_identificacion, u.estado, u.modo, u.perfil, u.last_login, u.nom_firma, p.descripcion AS perfil_desc, 
                        case when u.id_empresa is not null then
                        (select te.razon_social  from trc_empresa te where te.id_empresa = u.id_empresa)
                        else
                        null
                        end empresa
                     FROM  usr_usuario u, usr_perfil p
                WHERE u.perfil=p.id
                 and p.id not in (1,10,11,12,13,14,15,16)
            SQL,
            array(),
            true,
            "N"
        );

        //print_r($result);
        return BaseResponse::success($result, "buscar usuarios");
    }



    public static function findAllProveedores()
    {
        $result = QuerySQL::select(
            <<<SQL
                Select u.*, concat(u.nombres, ' ', u.apellidos) nombre_completo
                FROM  usr_usuario u
                WHERE u.perfil in (10,11,15,16)
            SQL,
            array(),
            true,
            "N"
        );

        return BaseResponse::success($result, "buscar usuarios");
    }

    public static function consultarTodosPerfil($perfil)
    {
        if (isset($perfil) && $perfil != "" && $perfil != null) {
            $obj_usuario = new Usuario();
            return $obj_usuario->selectAll(array("estado" => 'ACT', "perfil" => $perfil), array("username", "email", "nombres", "apellidos"), array(), true, false);
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function encriptar($valor)
    {
        return crypt($valor, constant('APP_KEY'));
    }

    public static function login($username, $password)
    {

        if (
            isset($username, $password) &&
            $username != "" && $username != null &&
            $password != "" && $password != null
        ) {
            $obj_usuario = new Usuario($username);
            $password_encryp = self::encriptar($password);

            if ($obj_usuario->getEstado() != "ACT") {
                $obj_usuario->failedAccess();
                return array("success" => false, "action" => "LOGIN", "code" => "Usuario no existe o no está activo.");
            } elseif ($obj_usuario->getPassword() !== $password_encryp) {
                $obj_usuario->failedAccess();
                return array("success" => false, "action" => "LOGIN", "code" => "Usuario y password no coincide.");
            } elseif ($obj_usuario->getPassword() === $password_encryp) {
                $obj_usuario->successAccess();
                self::setSESSION($username);
                $token = self::setToken($username);
                $obj_usuario = new Usuario($username);
                $perfil = $obj_usuario->getPerfil();
                $bandera_bash = $obj_usuario->getBanderaBash();
                $id_empresa = $obj_usuario->getIdEmpresa();

                $auto_bash = CtrTrcEmpresa::findByAutoXempre($id_empresa);
                //print_r($perfil);
                return array("success" => true, "action" => "LOGIN", "code" => "Acceso Correcto.", "token" => $token, "perfil" => $perfil , "bandera_bash" => $bandera_bash, "id_empresa" => $id_empresa, "auto_bash" => $auto_bash);
            } else {
                return array("success" => false, "action" => "LOGIN", "code" => "{}");
            }
        } else {
            return array("success" => false, "action" => "LOGIN", "code" => "Debe ingresar todos los parámetros.");
        }
    }


    public static function cambiarPassword($username, $password_old, $password_new)
    {
        if (
            isset($username, $password_old, $password_new) &&
            $username != "" && $username != null &&
            $password_old != "" && $password_old != null &&
            $password_new != "" && $password_new != null
        ) {
            $obj_usuario = new Usuario($username);
            $password_new_encryp = self::encriptar($password_new);

            $obj_login = self::login($username, $password_old);
            if ($obj_login['success']) {
                $obj_usuario->setPassword($password_new_encryp);
                $obj_usuario->successAccess();
                return array("success" => true, "action" => "PASSWORD", "code" => "Password actualizado con éxito.");
            } else {
                return array("success" => false, "action" => "PASSWORD", "code" => $obj_login['code']);
            }
        } else {
            return array("success" => false, "action" => "PASSWORD", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function resetPassword($username)
    {
        if (
            isset($username) &&
            $username != "" && $username != null
        ) {
            $obj_usuario = new Usuario($username);
            $password_new = CtrUtil::generarRandomString();
            $email = $obj_usuario->getEmail();
            $password_new_encryp = self::encriptar($password_new);

            if ($obj_usuario->getEstado() != "ACT") {
                $obj_usuario->failedAccess();
                return array("success" => false, "action" => "RESET PASSWORD", "code" => "Usuario no está activo.");
            } else {

                $obj_usuario->setPassword($password_new_encryp, true);
                $respuesta_usr = $obj_usuario->update();

                if ($respuesta_usr['success']) {

                    $mensaje = constant('APP_NAME') . ": Ha soliciado restablecer su contraseña. Para ingresar usa esta nueva: <b>$password_new</b>";

                    $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                    $subject = 'Ha soliciado restablecer su contraseña';
                    $text_content = $mensaje;
                    $body = '
                    <!DOCTYPE html>
                    <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width,initial-scale=1">
                        <meta name="x-apple-disable-message-reformatting">
                        <title></title>
                        <!--[if mso]>
                        <noscript>
                            <xml>
                                <o:OfficeDocumentSettings>
                                    <o:PixelsPerInch>96</o:PixelsPerInch>
                                </o:OfficeDocumentSettings>
                            </xml>
                        </noscript>
                        <![endif]-->
                        <style>
                            table, td, div, h1, p {font-family: Arial, sans-serif;}
                        </style>
                    </head>
                    <body style="margin:0;padding:0; padding-top:3%;">
                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                            <tr>
                                <td align="center" style="padding:0;">
                                    <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                        <tr>
                                            <td align="center" style="padding:40px 0 30px 0;background:#748fc5;">
                                                <img width="160" height="120" src="' . $url_imagen . '" alt="" width="90%" style="height:auto;display:block;" />
                                                <!--<h1 style="font-size:24px;margin:0;color:#ffffff;">ESTADO GENERAL DE CARTERA </h1> -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:36px 30px 42px 30px;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                    <tr>
                                                        <td style="padding:0 0 36px 0;color:#153643;">
                                                            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                                                                ' . $subject . '
                                                            </h1>
                                                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                                                ' . $text_content . '<br>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:10px;background:#748fc5;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                                    <tr>
                                                        <td style="padding:0;width:50%;" align="left">
                                                        </td>
                                                        <!-- <td style="padding:0;width:50%;" align="right">
                                                            <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                                                <tr>
                                                                    <td style="padding:0 0 0 10px;width:38px;">
                                                                        <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                                                    </td>
                                                                    <td style="padding:0 0 0 10px;width:38px;">
                                                                        <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td> -->
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>';

                    try {
                        $mail = new MAIL($obj_usuario->getEmail(), constant('APP_NAME') . " Password", $body);
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "RESET PASSWORD", "code" => $e->getMessage());
                    }

                    try {
                        $mail->send();
                        return array("success" => true, "action" => "RESET PASSWORD", "code" => "Password actualizado con éxito. Se envió email con nuevo password.");
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "RESET PASSWORD", "code" => $mail->ErrorInfo);
                    }
                } else {
                    return $respuesta_usr;
                }
            }
        } else {
            return array("success" => false, "action" => "RESET PASSWORD", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function cambiarEstado($username,$estado)
    {
        $username = $_POST['username'];
        //$estado = $_POST['accion'];
        //print_r($username);
        //print_r($estado);
        /*$username = $_POST['username'];
        $estado = $_POST['accion'];*/
        /*$estado_nuevo = substr($estado, 0, 3);
        $estado_nuevo = strtoupper($estado_nuevo);*/
        
        if (isset($username, $estado) && $username != "" /*&& preg_match('/^[a-zA-Z0-9]+$/', $username)*/ && $estado != "") {
            $obj_usuario = new Usuario($username);
            $obj_usuario->setEstado($estado);
            $obj_usuario->setAccess_attempts(0);
            // Agregar expiración de contraseña a 2 meses desde hoy
            $password_expiration = date('Y-m-d', strtotime('+2 months'));
            $obj_usuario->setProperty('password_expiration', $password_expiration);
        
            return $obj_usuario->update();
            return array("success" => true, "action" => "ACTUALIZAR", "code" => "Actualizo.");
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }
    //Inactivar candidato
    public static function cambiarEstadoCandidato($username)
    {
       
        //$username = $_POST['username'];
        //$estado = $_POST['accion'];
        //$estado_nuevo = substr($estado, 0, 3);
        $estado_nuevo = 'INA';
       
        if (isset($username, $estado_nuevo) && $estado_nuevo != "") {
            $obj_usuario = new Usuario($username);
            $obj_usuario->setEstado($estado_nuevo);
            return $obj_usuario->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function cambiarEstadoUsuario($username, $estado)
    {
       
        //$username = $_POST['username'];
        //$estado = $_POST['accion'];
        //$estado_nuevo = substr($estado, 0, 3);
        $estado_nuevo = $estado;
       
        if (isset($username, $estado_nuevo) && $estado_nuevo != "") {
            $obj_usuario = new Usuario($username);
            $obj_usuario->setEstado($estado_nuevo);
            return $obj_usuario->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function consultarLista($lista)
    {
        if (isset($lista) && !empty($lista)) {
            $obj_usuario = new Usuario();
            $todos = $obj_usuario->selectAll();
            $encontrados = array();
            foreach ($todos as $t) {
                foreach ($lista as $l) {
                    if ($t["username"] == $l["usuario"]) {
                        array_push($encontrados, array_merge($t, $l));
                    }
                }
            }
            return $encontrados;
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function cambiarSkin($username, $color)
    {
        if (
            isset($username, $color) && $username != "" && $color != "" &&
            preg_match('/^[a-zA-Z0-9]+$/', $username)
        ) {
            $obj_usuario = new Usuario($username);
            $obj_usuario->setModo($color);
            return $obj_usuario->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function getUsuarioApp($allDataUser = false)
    {
        if ($allDataUser)
            return $_SESSION[constant('APP_NAME')]['user'] ?? null;

        return $_SESSION[constant('APP_NAME')]['user']['username'];
    }

    public static function getUsuarioAppProperty($property = 'username')
    {
        return $_SESSION[constant('APP_NAME')]['user'][$property] ?? null;
    }

    public static function isLogged($put = false)
    {
        $timeout_duration = constant('APP_TIMEOUT');

        if (isset($_SESSION[constant('APP_NAME')]["status"]) && $_SESSION[constant('APP_NAME')]["status"] === "LOGIN") {

            if (isset($_SESSION[constant('APP_NAME')]['last_activity'])) {

                $last_activity = $_SESSION[constant('APP_NAME')]['last_activity'];
                if (time() - $last_activity < $timeout_duration) {
                    if ($put) {
                        $_SESSION[constant('APP_NAME')]['last_activity'] = time();
                    }
                    return true;
                } else {
                    self::logout();
                    return false;
                }
            } else {
                self::logout();
                return false;
            }
        } else {
            self::logout();
            return false;
        }
    }

    public static function logout()
    {
        @session_unset(); // unset $_SESSION variable for the run-time
        @session_destroy(); // destroy session data in storage
    }

    public static function setSESSION($v_username)
    {
        $_SESSION[constant('APP_NAME')]['user'] = self::consultar($v_username);
        $_SESSION[constant('APP_NAME')]['status'] = 'LOGIN';
        $_SESSION[constant('APP_NAME')]['last_activity'] = time();

        if ($_SESSION[constant('APP_NAME')]['user']['modo'] == null || $_SESSION[constant('APP_NAME')]['user']['modo'] == "") {
            $_SESSION[constant('APP_NAME')]['user']['modo'] = constant('APP_skin_default');
        }

        self::setSessionMenu($_SESSION[constant('APP_NAME')]['user']['perfil']);
        unset(
            $_SESSION[constant('APP_NAME')]['user']['password'],
            $_SESSION[constant('APP_NAME')]['user']['token'],
            $_SESSION[constant('APP_NAME')]['token'],
        );
    }

    public static function setSessionMenu($perfil)
    {
        $_SESSION[constant('APP_NAME')]['menu'] = "";
        if (isset($perfil) && $perfil != "" && $perfil != "") {
            $menu_perfil = CtrPerfilMenu::consultarTodosPerfil($perfil);
            $lista_menu = [];
            foreach ($menu_perfil as $m) {
                array_push($lista_menu, $m['nodo']);
            }

            $menu = CtrMenu::consultarTodosLista($lista_menu);
            $menu_html = themeMenu(convertAdjacencyListToTree(null, $menu, 'id', 'padre', 'hijos'), 'hijos');
            $_SESSION[constant('APP_NAME')]['menu'] = $menu_html;
        }
    }

    public static function accessLog($username = null)
    {
        if (isset($username) && $username != "" && $username != null) {
            $obj_log = new UsuarioAccessLog();
            return $obj_log->selectAll(
                array("username" => $username),
                array(),
                array("fecha_acceso desc"),
                true,
                false
            );
        } else {
            return array("success" => false, "action" => "ACCESS LOG", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function setToken($username)
    {
        $token = md5(uniqid(rand(), true));
        $_SESSION[constant('APP_NAME')]['token'] = $token;
        if (
            isset($username) && $username != "" &&
            preg_match('/^[a-zA-Z0-9]+$/', $username)
        ) {
            $obj_usuario = new Usuario($username);
            $obj_usuario->setToken($token);
            $result =  $obj_usuario->update();
            if ($result['success']) {
                return $token;
            } else {
                return false;
            }
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function getIdEmpresa($username)
    {
        $obj_usuario = new Usuario($username);
        $obj_usuario->getIdEmpresa();

        return $obj_usuario;

        // if ($onlyId) {
        //     $idEmprsa = $_SESSION[constant('APP_NAME')]['id_empresa'];
        //     if (!isset($idEmprsa))
        //         $idEmprsa = $_SESSION[constant('APP_NAME')]['id_empresa'];

        //     return $idEmprsa ?? null;
        // }

        // return $_SESSION[constant('APP_NAME')]['id_empresa'] ?? null;
    }

    //Revisar los roles para que deacuerdo al usuario creado le aparesca el que corresponde
    public static function getClienteRol($onlyId = false)
    {
        if ($onlyId) {
            $cliente_rol = $_SESSION[constant('APP_NAME')]['user']['id_empresa'];
            if (!isset($cliente_rol))
                $cliente_rol = $_SESSION[constant('APP_NAME')]['user']['id_empresa'];

            return $cliente_rol ?? null;
        }

        return $_SESSION[constant('APP_NAME')]['id_empresa'] ?? null;
    }

    public static function isSelectableClientRol(): bool
    {
        $roles_priv_selectable =
            array(
                1,  // Administrador
                7,  // Cliente Administrador
                8,  // Cliente Sin Informe
                9,  // Cliente con Informe
                10, // Visitador
                11, // Poligrafista
                12, // Coordinador
                13, // Calidad
                15, // Analista de riesgo
            );

        return in_array($_SESSION[constant('APP_NAME')]['user']['perfil'], $roles_priv_selectable);
    }
    
    public static function findByUsrXEmpresa($id_empresa = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select uu.username, 
                       up.descripcion perfil_desc, 
                       uu.nombres , uu.apellidos , 
                       cf.descripcion tipo_identificacion , 
                       uu.numero_identificacion ,  
                       uu.email correo, 
                       te.razon_social empresa, 
                       uu.estado, 
                       uu.cargo,
                       uu.bandera_bash
                from usr_usuario uu,
                configurations cf,
                usr_perfil up,
                trc_empresa te
                where uu.id_empresa in  (select id_empresa from trc_empresa where id_empresa = :id_empresa or id_empresa_padre = :id_empresa)
                and uu.perfil = up.id
                and cf.codigo = uu.tipo_identificacion
                and cf.categoria = 'tipo_identificacion' 
                and te.id_empresa = uu.id_empresa
                and uu.perfil != 14
                and cf.categoria = 'tipo_identificacion'
            SQL,
            array("id_empresa" => $id_empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar usuarios de la empresa");
    }

    public static function findByUsrXEmpresaUser($id_empresa = null, $username = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select uu.username, 
                       up.descripcion perfil_desc, 
                       up.id idperfil,  uu.nombres , 
                       uu.apellidos , 
                       cf.descripcion tipo_identificacion, 
                       cf.codigo codigoTipoIden, 
                       uu.numero_identificacion ,  
                       uu.email correo, 
                       te.razon_social empresa, 
                       te.id_empresa, 
                       te.flag_subemp,
                       uu.estado, 
                       uu.cargo,
                       uu.bandera_bash
                from usr_usuario uu,
                configurations cf,
                usr_perfil up,
                trc_empresa te
                where uu.id_empresa in  (select id_empresa from trc_empresa where id_empresa = :id_empresa or id_empresa_padre = :id_empresa)
                and uu.perfil = up.id
                and cf.codigo = uu.tipo_identificacion
                and cf.categoria = 'tipo_identificacion' 
                and te.id_empresa= uu.id_empresa
                and cf.categoria = 'tipo_identificacion'
                and uu.username = :username
            SQL,
            array(
                "id_empresa" => $id_empresa,
                "username" => $username
            ),
            true,
            "N"
        );

        return BaseResponse::success($result, "buscar usuarios de la empresa");
    }

    public static function enviarCorreo($username, $nombre = null, $email, $tipo, $password)
    {

        if ($tipo == 'CREA') {

            $usuario_perfil = '';
            $asunto = '';
            $instructivo = "";
            $politicas = "";

            //En esta parte dependiendo del perfil se manda la plantilla
            $obj_usuario = new Usuario($username);
            $perfil = $obj_usuario->getPerfil();
            $pass = $obj_usuario->getPerfil();

            //Descrpcion del perfil
            $obj_perfil = new Perfil($perfil);
            $perfilDes = $obj_perfil->getDescripcion();

            if ($perfil == 10 || $perfil == 11 || $perfil == 13 || $perfil == 15 || $perfil == 16) { //envio de correo del proveedor
                $usuario_perfil = 'proveedor';
                $asunto = 'REGISTRO USUARIO PROVEEDOR';
                if ($perfil == 10) { //visitador
                    $instructivo = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/INSTRUCTIVO_USO_DE_LA_PLATAFORMA_-_PROFESIONALES_DE_VISITAS_DOMICILIARIA.pdf';
                }else if ($perfil == 11){ //Poligrafista
                    $instructivo = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/INSTRUCTIVO_USO_DE_LA_PLATAFORMA_POLIGRAFISTA.pdf';
                }else if ($perfil == 15){ //Analista de Riesgo
                    $instructivo = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/INSTRUCTIVO_USO_DE_LA_PLATAFORMA_-_ANALISTA_DE_RIESGO.pdf';
                }else if ($perfil == 13){ //Calidad
                    $instructivo = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/INSTRUCTIVO_ANALISTA_DE_CALIDAD_.pdf';
                }else{
                    $instructivo = "";
                }
                
                $politicas = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/PTPE-003_V2_POLITICA_DE_USO_DEL_MANEJO_DE_TIC.pdf';
            } else if ($perfil == 7 || $perfil == 8 || $perfil == 9) { //envio de correo del cliente
                $usuario_perfil = 'cliente';
                $asunto = 'REGISTRO USUARIO CLIENTE';
                $instructivo = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/Instructivo_uso_de_la_plaforma_cliente.pdf';
                $politicas = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/PTPE-003_V2_POLITICA_DE_USO_DEL_MANEJO_DE_TIC.pdf';
            } else if ($perfil == 1 || $perfil == 12){  //envio de correo del de admin y coordinador
                $usuario_perfil = 'usuario';
                $asunto = 'REGISTRO USUARIO';
                $instructivo = "";
                $politicas = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/PTPE-003_V2_POLITICA_DE_USO_DEL_MANEJO_DE_TIC.pdf';
            }
            


            $para = $email;
            $usuario = $username;
            /*$mensaje = "Apreciado " . $nombre . " se acabó de realizar la creación de su usuario para el ingreso a la aplicación Prohumanos, debe hacerlo por el siguiente link: <b> ". $_SERVER["HTTP_HOST"]  . " </b> 
                         para el ingreso a la aplicación debe hacerlo con el siguiente usuario <b>". $usuario . "</b>  y la contraseña que le fue asignada por el administrador";*/
            $mensaje = "Estimado  " . $usuario_perfil . ", le notificamos que se ha creado perfil como ". $perfilDes ." <br><br>Para acceder debe ingresar al  <a href='". $_ENV['APP_HOST'] ."' target='_blank'>link</a>
                                    , y registrar los datos de acceso relacionados a continuación<br><br><b>Usuario: ". $usuario . "<br>Contraseña: ". $password . 
                                    "</b><br><br>Una vez haya ingresado la contraseña, el sistema le solicitará la creación de una nueva."
                                    ."<br>A continuación, encontrara el instructivo de uso del aplicativo Prohumanos y política de uso de manejo del aplicativo Prohumanos."
                                    ."<br><br><a href='". $instructivo."' target='_blank'>Descargar instructivo</a>"
                                    ."<br><br><a href='".$politicas."' target='_blank'>Descargar politicas de uso</a>"
                                    ."<br><br>Si requiere ayuda por favor comunicarse al teléfono 3225104825 - 3112775882 en la ciudad de Bogotá o al email consultor@prohumanos.com o confiabilidad@prohumanos.com. "
                                    ."<br><br><strong>SISTEMA DE GESTION Y AUTENTICACION DE USUARIOS PROHUMANOS ALIADOS ESTRATEGICOS SAS <br>Telf. 7330717 - 3143324470</strong>"
                                    ."<br><br>Esta información, su contenido y cualquier archivo adjunto o anexo son de carácter confidencial y son de propiedad de PROHUMANOS ALIADOS ESTRATEGICOS SAS y para uso exclusivo del destinatario. Puede contener información confidencial o de acceso y uso legalmente privilegiado. El uso, interceptación, sustracción, extravío, lectura o reproducción total o parcial, está prohibida para cualquier persona diferente del destinatario legítimo. Si usted recibió este correo por error, equivocación u omisión, por favor contacte e informe al originador del mismo y destruya todas las copias del mensaje original. Cualquier utilización, copia, reimpresión, reenvió o cualquier acción tomada sobre este correo queda estrictamente prohibida y podría ser ilegal.
                                    <br><br>Las apreciaciones personales del remitente, opiniones, conclusiones y cualquier otra información similar no relacionada con el negocio de PROHUMANOS ALIADOS ESTRATEGICOS SAS, deben entenderse como personales y de ninguna manera son avaladas por PROHUMANOS ALIADOS ESTRATEGICOS SAS.
                                    <br><br>PROHUMANOS ALIADOS ESTRATEGICOS SAS. Cuenta con herramientas para mantener la integridad de los correos y minimizar los riesgos de que este mensaje y sus anexos contengan virus informáticos que puedan llegar a afectar los sistemas que lo reciben, sin embargo esto no exime la responsabilidad del destinatario de verificar la limpieza del correo al momento de su recepción, en consecuencia, PROHUMANOS ALIADOS ESTRATEGICOS SAS., se exonera de cualquier tipo de responsabilidad por daños, alteraciones, falsificaciones  o perjuicios que se ocasionen con su recepción o uso.";
            
            $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
            $subject = $asunto;
            $text_content = $mensaje;
            $body = '
            <!DOCTYPE html>
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="x-apple-disable-message-reformatting">
                <title></title>
                <!--[if mso]>
                <noscript>
                    <xml>
                        <o:OfficeDocumentSettings>
                            <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                    </xml>
                </noscript>
                <![endif]-->
                <style>
                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                </style>
            </head>
            <body style="margin:0;padding:0; padding-top:3%;">
                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                    <tr>
                        <td align="center" style="padding:0;">
                            <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                <tr>
                                    <td align="center" style="padding:40px 0 30px 0;background:#748fc5;">
                                        <img width="160" height="120" src="' . $url_imagen . '" alt="" width="90%" style="height:auto;display:block;" />
                                        <!--<h1 style="font-size:24px;margin:0;color:#ffffff;">ESTADO GENERAL DE CARTERA </h1> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:36px 30px 42px 30px;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                            <tr>
                                                <td style="padding:0 0 36px 0;color:#153643;">
                                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">
                                                        ' . $subject . '
                                                    </h1>
                                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                                        ' . $text_content . '<br>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;background:#748fc5;">
                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                            <tr>
                                                <td style="padding:0;width:50%;" align="left">
                                                </td>
                                                <!-- <td style="padding:0;width:50%;" align="right">
                                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                                        <tr>
                                                            <td style="padding:0 0 0 10px;width:38px;">
                                                                <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                                                            </td>
                                                            <td style="padding:0 0 0 10px;width:38px;">
                                                                <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td> -->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>';

        } 
        try {
            $mail = new MAIL($para, $asunto, $body);
        } catch (Exception $e) {
            return array("success" => false, "action" => "Envío Prefactura", "code" => $e->getMessage());
        }

        try {
            $mail->send();
        } catch (Exception $e) {
            return array("success" => false, "action" => "Envío Prefactura", "code" => $mail->ErrorInfo);
        }
    }

    //subir archivo firma usuarios
    public static function uploadFile($nombreUsuario)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/prohumanos/USERS/";

        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        if (!file_exists($nuevodirectorio)) {
            mkdir($nuevodirectorio, 0775, true);
        }

        $uploaddir = "$nuevodirectorio/";
        $filesize  = $tamano;
        $tipo      = $ext;
        $filename  = trim($nombre); // (trim elimina los posibles espacios al final y al principio del nombre del archivo)
        $filename  = str_replace(" ", "_", $filename); // (con esta función eliminamos posibles espacios entre los caracteres del nombre) 
        $encrip = strrchr($filename, ".");
        $file_encrip = md5(date("dmYhisA")) . $encrip;
        $uploadfile = $uploaddir . $file_encrip;

       // return  $uploadfile;

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
            return $nuevodirectorio;
        } else {
            return null;
        }  
    }

    public static function imagen($user = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT nom_firma, ext_firma, firma 
                FROM usr_usuario u 
                WHERE u.username = :user
            SQL,
            array("username" => $user),
            true,
            "N"
        );

        return Result::success($result, "buscar imagen");
    }

}
