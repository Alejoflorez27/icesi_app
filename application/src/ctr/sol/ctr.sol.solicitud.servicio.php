<?php

class CtrSolSolicitudServicio
{


    public static function findById($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sss.id , sss.id_servicio , sss.prioridad, ss.nom_servicio , case when sss.estado_proceso is not null then 
                        concat((select descripcion 
                            from configurations c 
                            where categoria = 'estado_servicios'
                            and codigo = sss.estado),' - ',
                            (select descripcion 
                            from configurations c 
                            where categoria = 'estado_servicios'
                            and codigo = sss.estado_proceso))
                    else 
                        null
                     end estado, sss.estado estado_servicio, sss.observacion, sss.calificado 
                from sol_solicitud_servicio sss , srv_servicios ss
                where sss.id_servicio = ss.id_servicio
                and sss.id_solicitud =:id_solicitud
                order by sss.id
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar servicios de una solicitud");
    }

    public static function estado_proceso($id_solicitud, $id_servicio, $estado, $estado_proceso)
    {
        $usuario = CtrUsuario::getUsuarioApp();

        $result = QuerySQL::update(
            <<<SQL
                update sol_solicitud_servicio
                    set estado = :estado,
                        estado_proceso = :estado_proceso,
                        usr_modifica = :usuario,
                        fch_modifica = now()
                  where id_solicitud = :id_solicitud
                    and id_servicio = :id_servicio;
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "estado" => $estado,
                "estado_proceso" => $estado_proceso,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );

        if ($result['success']) {
            $result = Result::getData(self::actualizarSolicitud($id_solicitud));
            return BaseResponse::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //cambio de estado - servicio cuando el asesor guarda la primera parte
    public static function estado_proceso_asesor($id_solicitud, $id_servicio, $estado, $estado_proceso)
    {
        $usuario = CtrUsuario::getUsuarioApp();

        //trae la info de la solicitud
        //$resp = CtrSolSolicitud::findById($id_solicitud);
        //print_r($usuario);

        $resultUser = QuerySQL::select(
            <<<SQL
            select uu.perfil
                from usr_usuario uu 
                where uu.username = :usuario
        SQL,
            array(
                "usuario" => $usuario
            ),
            false,
            "N"
        );

        $perfilConectado = $resultUser['perfil'];


        $result = QuerySQL::select(
            <<<SQL
            select sss.id_solicitud, sss.id_servicio, sss.id_usuario_asig, sss.estado, sss.estado_proceso, uu.perfil  
                from sol_solicitud_servicio sss, usr_usuario uu  
                where sss.id_servicio = :id_servicio
                and sss.id_solicitud = :id_solicitud
                and uu.username = sss.id_usuario_asig 
        SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio
            ),
            false,
            "N"
        );

        $estadoIni = $result['estado'];
        $estadoProcesoIni = $result['estado_proceso'];

        if ($estadoIni == '2' && $estadoProcesoIni == '3') {

            $result = QuerySQL::update(
                <<<SQL
                update sol_solicitud_servicio
                    set estado = :estado,
                        estado_proceso = :estado_proceso,
                        usr_modifica = :usuario,
                        fch_modifica = now()
                  where id_solicitud = :id_solicitud
                    and id_servicio = :id_servicio;
            SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "estado" => $estado,
                    "estado_proceso" => $estado_proceso,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );

            if ($result['success']) {
                $result = Result::getData(self::actualizarSolicitud($id_solicitud));
                return BaseResponse::success($result);
            } else {
                return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
            }
        } //fin if estado
        else if ($estadoIni == '2' && $estadoProcesoIni == '4') {

            $result = QuerySQL::update(
                <<<SQL
                update sol_solicitud_servicio
                    set estado = :estado,
                        estado_proceso = :estado_proceso,
                        usr_modifica = :usuario,
                        fch_modifica = now()
                  where id_solicitud = :id_solicitud
                    and id_servicio = :id_servicio;
            SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "estado" => $estado,
                    "estado_proceso" => $estado_proceso,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );

            if ($result['success']) {
                $result = Result::getData(self::actualizarSolicitud($id_solicitud));
                return BaseResponse::success($result);
            } else {
                return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
            }
        } else if ($estadoIni == '4' && $estadoProcesoIni == '2' and $estado == '5' and ($perfilConectado != '13' or $perfilConectado != '12')) {


            $result = QuerySQL::update(
                <<<SQL
                update sol_solicitud_servicio
                    set estado = :estado,
                        estado_proceso = 2,
                        usr_modifica = :usuario,
                        fch_modifica = now()
                  where id_solicitud = :id_solicitud
                    and id_servicio = :id_servicio;
            SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "estado" => $estado,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );
            // Dallan

            if ($result['success']) {
                $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-corregido'));
                return BaseResponse::success($result);
            } else {
                return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
            }
        } else if ($estadoIni == '8' && $estadoProcesoIni == '6') {
            $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-alcance'));
            return BaseResponse::success($result);
        }
        //fin estado guardar estado servicio


    } //fin estado proceso

    public static function asignar($id_solicitud, $id_servicio, $prestador)
    {
        $usuario = CtrUsuario::getUsuarioApp();


        try {

            $result = QuerySQL::update(
                <<<SQL
                    update sol_solicitud_servicio
                        set id_usuario_asig = :prestador,
                            estado = 2,
                            estado_proceso = 3,
                            fecha_asignado = now(),
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "prestador" => $prestador,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );

            $obj_usuario = new SrvServicio($id_servicio);
            $servicio = $obj_usuario->getNomServicio();

            $resp = CtrSolSolicitud::findById($id_solicitud);
            $solicitud = null;
            if (Result::isSuccess($resp))
                $solicitud = Result::getData($resp);

            $arrayTextoCorreo = json_decode(json_encode($result), true);
            $mensaje = 'Estimado proveedor, le notificamos que le fue asignado un nuevo servicio, ingrese al link ';
                        //.$id_solicitud.' al servicio '. $servicio;

            $obj_usuario = new Usuario($prestador);
            $email = $obj_usuario->getEmail();

            // Se envía correo con el password
            $mensaje_ingreso = 'Se le acaba de asignar a la solicitud # '.$id_solicitud.' al servicio '. $servicio;

            
            $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
            //$subject = "Correo Asignación de Servicio";
            $subject = "SOLICITUD DE SERVICIOS ASIGNADO";
            $text_content = $mensaje;
            $text_content1 = "registre los datos de acceso para la realización del servicio"
                            ."<br><br>Candidato: ".$solicitud['nombre_candidato']
                            ."<br>Cliente: ".$solicitud['cliente_desc']
                            ."<br>Documento de identidad: ".$solicitud['numero_documento'];
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
                                                        ' . $text_content . '
                                                        <a href="'. $_ENV['APP_HOST'].'" target="_blank">click aqui</a>
                                                        ' ."<br>". $text_content1 . '
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

            $mail = new MAIL($email, "SOLICITUD DE SERVICIOS ASIGNADO", $body);
        } catch (Exception $e) {
            return array("success" => false, "action" => "Reenvío de Correo Proveedor", "code" => $e->getMessage());
        }

        try {
            $mail->send();
            $result = Result::getData(self::actualizarSolicitud($id_solicitud));
            return BaseResponse::success($result);
        } catch (Exception $e) {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }

        /*if ($result['success']) {
            $result = Result::getData(self::actualizarSolicitud($id_solicitud));
            return BaseResponse::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }*/
    }

    public static function programar($id_solicitud, $id_servicio, $fecha_programacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");


        if (!isset($fecha_programacion) || $fecha_programacion == "")
            return Result::error(__FUNCTION__, "fecha_programacion es requerido");

        $usuario = CtrUsuario::getUsuarioApp();

        $obj_usuario = new Usuario($usuario);
        $perfil = $obj_usuario->getPerfil();

        $result = QuerySQL::update(
            <<<SQL
                    update sol_solicitud_servicio
                        set fecha_programacion = :fecha_programacion,
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "fecha_programacion" => $fecha_programacion,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );


        if ($perfil != 7 || $perfil != 8 || $perfil != 9) {

            $resp = CtrSolSolicitud::findById($id_solicitud);
            $solicitud = null;
            if (Result::isSuccess($resp))
                $solicitud = Result::getData($resp);

            $numero_documento = $solicitud['numero_documento'];

            $nombre_candidato = $solicitud['nombre_candidato'];
                
            $cliente_desc = $solicitud['cliente_desc'];

            $resultCorreos = QuerySQL::select(
                <<<SQL
                    select uu.email  email
                    from usr_usuario uu 
                    where uu.username in (select usuario 
                                            from sol_solicitud ss 
                                            where id_solicitud = :id_solicitud)
                    and uu.estado = 'ACT'
                    AND uu.email is not null;
            SQL,
                array(
                    "id_solicitud" => $id_solicitud
                ),
                true,
                "N"
            );

            $arrayCorreos = json_decode(json_encode($resultCorreos), true);
            for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                $para = $arrayCorreos[$i]['email'];
                $mensaje = "El Funcionario ha enviado la Programación<br><br>"
                            .$fecha_programacion
                            ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                            ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                //$subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
                $subject = "NOTIFICACIÓN SERVICIO ";
                
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            }
        }

        return BaseResponse::success($result);
    }

    public static function asistencia($id_solicitud, $id_servicio, $asistio, $observacion_asistio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        $usuario = CtrUsuario::getUsuarioApp();

        $result = QuerySQL::update(
            <<<SQL
                    update sol_solicitud_servicio
                        set asistio = :asistio,
                        observacion_asistio = :observacion_asistio,
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "asistio" => $asistio,
                "observacion_asistio" => $observacion_asistio,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );

        return BaseResponse::success($result);
    }

    public static function proceso($id_solicitud, $id_servicio, $cont_proceso)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        $usuario = CtrUsuario::getUsuarioApp();

        $result = QuerySQL::update(
            <<<SQL
                    update sol_solicitud_servicio
                        set cont_proceso = :cont_proceso,
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "cont_proceso" => $cont_proceso,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );

        //return BaseResponse::success($result);
        if ($cont_proceso == 'N') {
            return BaseResponse::success($result);
        } else {
            $resp = CtrSolSolicitud::findById($id_solicitud);
            $solicitud = null;
            if (Result::isSuccess($resp))
                $solicitud = Result::getData($resp);

            $numero_documento = $solicitud['numero_documento'];

            $nombre_candidato = $solicitud['nombre_candidato'];
                
            $cliente_desc = $solicitud['cliente_desc'];

            $resultCorreos = QuerySQL::select(
                <<<SQL
                  SELECT uu.email email 
                    FROM sol_solicitud_servicio sss, usr_usuario uu 
                   WHERE id_solicitud = :id_solicitud 
                    AND sss.id_usuario_asig = uu.username
                    AND uu.estado = 'ACT'
                    AND uu.email is not null
                    AND sss.id_servicio != 1;

            SQL,
                array(
                    "id_solicitud" => $id_solicitud
                ),
                true,
                "N"
            );

            $arrayCorreos = json_decode(json_encode($resultCorreos), true);
            for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                $para = $arrayCorreos[$i]['email'];
                $mensaje = "El Coordinador ha enviado la siguiente novedad, puede continuar con el estudio"
                            ."<br><br>Para ver ingrese a ". $_ENV['APP_HOST']
                            ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                //$subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
                $subject = "NOTIFICACIÓN CONTINUAR CON EL ESTUDIO";
                
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN CONTINUAR CON EL ESTUDIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "NOTIFICACIÓN CONTINUAR CON EL ESTUDIO", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "NOTIFICACIÓN CONTINUAR CON EL ESTUDIO", "code" => $mail->ErrorInfo);
                }
            }
            return BaseResponse::success($result);
        }
    }


    public static function finalizar($id_solicitud, $id_servicio, $estado, $mensaje)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        $usuario = CtrUsuario::getUsuarioApp();

        $validacion = QuerySQL::select(
            <<<SQL
                SELECT 
                    COUNT(*) AS total
                FROM sol_solicitud_servicio sss
                WHERE id_solicitud   = :id_solicitud
                AND id_servicio    = :id_servicio
                AND estado         = 8
                AND estado_proceso = 6;

            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio"  => $id_servicio
            ),
            true,
            "N"
        );

        $arrayCorreo = json_decode(json_encode($validacion), true);
        $val_alcance = $arrayCorreo[0]['total'];

        //print_r($val_alcance);


        if ($estado == 6 || $estado ==  7) {

            $manual = CtrSrvServicio::idServicio($id_servicio);

            $ultimoSrv = CtrSrvServicio::valUltimoSrv($id_solicitud);

            //print_r($manual['data']['tipo_servicio']);
            if ($manual['data']['tipo_servicio'] == "F") {

                // ✅ Validar
                if ($ultimoSrv && isset($ultimoSrv['data']['validacion'])) {
                    if (($ultimoSrv['data']['validacion'] === 'Completo')) {
                        //echo "✅ Todo completo, continuando con el proceso...";
                        // Aquí pones el código para continuar
                        $result = QuerySQL::update(
                            <<<SQL
                                update sol_solicitud_servicio sss
                                    set sss.estado = 8,
                                    sss.estado_proceso = :estado_proceso,
                                    sss.fecha_termina_proveedor = now(),
                                    sss.observacion_finalizacion = :observacion,
                                    sss.calificado = 'S',
                                        sss.usr_modifica = :usuario,
                                        sss.fch_modifica = now()
                                where sss.id_solicitud = :id_solicitud
                                    and sss.id_servicio = :id_servicio;


                                update sol_solicitud s
                                    set s.fch_fin_solicitud = now()
                                where s.id_solicitud = :id_solicitud;
                            SQL,
                            array(
                                "id_solicitud" => $id_solicitud,
                                "id_servicio" => $id_servicio,
                                "estado_proceso" => $estado,
                                "observacion" => $mensaje,
                                "usuario" => $usuario,
                            ),
                            true,
                            "N"
                        );
                        if ($result['success']) {
                            if ($estado == 6) {
                                $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado-alcance', $mensaje));
                                if ($val_alcance != 1) {
                                    // ✅ Solo entra aquí si la condición es verdadera
                                    $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado', $mensaje));
                                }
                            } else {
                                
                                if ($val_alcance != 1) {
                                    // ✅ Solo entra aquí si la condición es verdadera
                                    $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado', $mensaje));
                                }
                                
                            }
                            
                            return BaseResponse::success($result);
                        }
                    } else {
                        //echo "⚠ " . $ultimoSrv['data']['validacion'];
                        // Aquí puedes detener el flujo o mostrar alerta
                        //return BaseResponse::error(__FUNCTION__,"⚠ " . $ultimoSrv['data']['validacion']);
                        return [
                        "status" => "error",
                        "action" => __FUNCTION__,
                        "message" => "⚠ " . $ultimoSrv['data']['validacion']
                        ];

                    }
                }else if ($ultimoSrv['data'] == '') {
                    //print_r('hola');
                        $result = QuerySQL::update(
                            <<<SQL
                                update sol_solicitud_servicio sss
                                    set sss.estado = 8,
                                    sss.estado_proceso = :estado_proceso,
                                    sss.fecha_termina_proveedor = now(),
                                    sss.observacion_finalizacion = :observacion,
                                    sss.calificado = 'S',
                                        sss.usr_modifica = :usuario,
                                        sss.fch_modifica = now()
                                where sss.id_solicitud = :id_solicitud
                                    and sss.id_servicio = :id_servicio;


                                update sol_solicitud s
                                    set s.fch_fin_solicitud = now()
                                where s.id_solicitud = :id_solicitud;
                            SQL,
                            array(
                                "id_solicitud" => $id_solicitud,
                                "id_servicio" => $id_servicio,
                                "estado_proceso" => $estado,
                                "observacion" => $mensaje,
                                "usuario" => $usuario,
                            ),
                            true,
                            "N"
                        );
                        if ($result['success']) {
                            if ($estado == 6) {
                                $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado-alcance', $mensaje));
                                if ($val_alcance != 1) {
                                    // ✅ Solo entra aquí si la condición es verdadera
                                    $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado', $mensaje));
                                }
                            } else {
                                if ($val_alcance != 1) {
                                    // ✅ Solo entra aquí si la condición es verdadera
                                    $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado', $mensaje));
                                }
                            }
                            return BaseResponse::success($result);
                        }
                }

            } else {
                $result = QuerySQL::update(
                    <<<SQL
                        update sol_solicitud_servicio sss
                            set sss.estado = 8,
                            sss.estado_proceso = :estado_proceso,
                            sss.fecha_termina_proveedor = now(),
                            sss.observacion_finalizacion = :observacion,
                            sss.calificado = 'S',
                                sss.usr_modifica = :usuario,
                                sss.fch_modifica = now()
                        where sss.id_solicitud = :id_solicitud
                            and sss.id_servicio = :id_servicio;


                        update sol_solicitud s
                            set s.fch_fin_solicitud = now()
                        where s.id_solicitud = :id_solicitud;
                    SQL,
                    array(
                        "id_solicitud" => $id_solicitud,
                        "id_servicio" => $id_servicio,
                        "estado_proceso" => $estado,
                        "observacion" => $mensaje,
                        "usuario" => $usuario,
                    ),
                    true,
                    "N"
                );
                if ($result['success']) {
                    if ($estado == 6) {
                        $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado-alcance', $mensaje));
                        if ($val_alcance != 1) {
                            // ✅ Solo entra aquí si la condición es verdadera
                            $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado', $mensaje));
                        }
                    } else {
                        if ($val_alcance != 1) {
                            // ✅ Solo entra aquí si la condición es verdadera
                            $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-finalizado', $mensaje));
                        }
                    }
                    return BaseResponse::success($result);
                }
            }
            

            //return BaseResponse::success($result);

        } else {
            $result = QuerySQL::update(
                <<<SQL
                    update sol_solicitud_servicio
                        set estado = 4,
                           estado_proceso = 2,
                           observacion_finalizacion = :observacion,
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "observacion" => $mensaje,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );

            if ($result['success']) {
                $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-rechazado', $mensaje));
                return BaseResponse::success($result);
            }
        }
    }




    public static function cancelar($id_solicitud, $id_servicio, $motivo)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        $usuario = CtrUsuario::getUsuarioApp();

        $consulta = QuerySQL::select(
            <<<SQL
                    select  count(1)  permite
                    from sol_solicitud_servicio s
                    where s.id_solicitud = :id_solicitud
                    and s.id_servicio = :id_servicio
                    and s.estado not in (0, 5, 6, 7, 8, 9 )
                    and estado_proceso not in (2, 4 );
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
            ),
            true,
            "N"
        );


        $arrayPermite = json_decode(json_encode($consulta), true);
        $permitido = $arrayPermite[0]['permite'];


        if ($permitido == 1) {

            $result = QuerySQL::update(
                <<<SQL
                        update sol_solicitud_servicio
                            set estado = 0,
                                motivo_cancelado = :motivo,
                                usr_modifica = :usuario,
                                fch_modifica = now()
                          where id_solicitud = :id_solicitud
                            and id_servicio = :id_servicio;
                    SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "motivo" => $motivo,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );
            if ($result['success']) {
                $correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-cancelado', $motivo));
                return BaseResponse::success($result);
            } else {
                return Result::error(__FUNCTION__, "No se puede cancelar el servicio, el combo resultante no está configurado para el cliente, por favor revise.");
            }
        } else {
            return Result::error(__FUNCTION__, "No se puede Cancelar el servico, ya fue iniciado");
        }
    }

    public static function cancelarAsignacion($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        $usuario = CtrUsuario::getUsuarioApp();

        $consulta = QuerySQL::select(
            <<<SQL
                    select  count(1)  permite
                    from sol_solicitud_servicio s
                    where s.id_solicitud = :id_solicitud
                    and s.id_servicio = :id_servicio
                    and s.estado not in (0, 5, 6, 7, 8, 9)
                    and estado_proceso not in (2);
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
            ),
            true,
            "N"
        );


        $arrayPermite = json_decode(json_encode($consulta), true);
        $permitido = $arrayPermite[0]['permite'];


        if ($permitido == 1) {

            $result = QuerySQL::update(
                <<<SQL
                        update sol_solicitud_servicio
                            set estado = 1,
                                estado_proceso = 1,
                                usr_modifica = :usuario,
                                fch_modifica = now(),
                                id_usuario_asig = null,
                                fecha_asignado = null
                          where id_solicitud = :id_solicitud
                            and id_servicio = :id_servicio;
                    SQL,
                array(
                    "id_solicitud" => $id_solicitud,
                    "id_servicio" => $id_servicio,
                    "usuario" => $usuario,
                ),
                true,
                "N"
            );
            if ($result['success']) {
                // Solo si se logró cancelar el servicio

                // Verificar si quedan otros servicios activos
                $consultaActivos = QuerySQL::select(
                    <<<SQL
                        select count(1) activos
                        from sol_solicitud_servicio
                        where id_solicitud = :id_solicitud
                        and estado != 0;
                    SQL,
                    array("id_solicitud" => $id_solicitud),
                    true,
                    "N"
                );

                $activos = intval($consultaActivos[0]['activos']);
                //print_r($activos);

                // Si ya no hay más servicios activos, actualizar estado de la solicitud
                if ($activos == 1) {
                    QuerySQL::update(
                        <<<SQL
                            update sol_solicitud
                            set id_estado_solicitud = 'ingresado'  -- "1" representa 'ingresado' (ajusta si es otro ID)
                            where id_solicitud = :id_solicitud;
                        SQL,
                        array("id_solicitud" => $id_solicitud),
                        true,
                        "N"
                    );
                }
                //$correo = Result::getData(self::enviarCorreo($id_solicitud, $id_servicio, 'servicio-cancelado'));
                return BaseResponse::success($result);
            } else {
                return Result::error(__FUNCTION__, "No se puede cancelar asignación");
            }
        } else {
            return Result::error(__FUNCTION__, "No se puede Cancelar el servico, ya fue iniciado");
        }
    }
/*public static function cancelarAsignacion($id_solicitud, $id_servicio)
{
    if (!isset($id_solicitud) || $id_solicitud == "")
        return Result::error(__FUNCTION__, "id solicitud es requerido");
    if (!is_numeric($id_solicitud))
        return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

    if (!isset($id_servicio) || $id_servicio == "")
        return Result::error(__FUNCTION__, "id servicio es requerido");
    if (!is_numeric($id_servicio))
        return Result::error(__FUNCTION__, "id servicio debe ser númerico");

    $usuario = CtrUsuario::getUsuarioApp();

    // Verificar si se permite cancelar
    $consulta = QuerySQL::select(
        <<<SQL
            select count(1) permite
            from sol_solicitud_servicio s
            where s.id_solicitud = :id_solicitud
              and s.id_servicio = :id_servicio
              and s.estado not in (0, 5, 6, 7, 8, 9)
              and s.estado_proceso not in (2);
        SQL,
        array(
            "id_solicitud" => $id_solicitud,
            "id_servicio" => $id_servicio,
        ),
        true,
        "N"
    );

    $arrayPermite = json_decode(json_encode($consulta), true);
    $permitido = $arrayPermite[0]['permite'];

    if ($permitido == 1) {

        // Cancelar el servicio
        $result = QuerySQL::update(
            <<<SQL
                update sol_solicitud_servicio
                set estado = 0,
                    estado_proceso = 1,
                    usr_modifica = :usuario,
                    fch_modifica = now(),
                    id_usuario_asig = null,
                    fecha_asignado = null
                where id_solicitud = :id_solicitud
                  and id_servicio = :id_servicio;
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );



            return BaseResponse::success($result);
        
    } else {
        return Result::error(__FUNCTION__, "No se puede Cancelar el servicio, ya fue iniciado");
    }
}*/


    //Esta la observacion de servicio dentro de solicitud
    public static function observacion($id_solicitud, $id_servicio, $observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        if (!isset($observacion) || $observacion == "")
            return Result::error(__FUNCTION__, "Observación / Novedad se encuentra vacio");

        $usuario = CtrUsuario::getUsuarioApp();

        $obj_usuario = new Usuario($usuario);
        $perfil = $obj_usuario->getPerfil();

        $result = QuerySQL::update(
            <<<SQL
                    update sol_solicitud_servicio
                        set observacion = :observacion,
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "observacion" => $observacion,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );

        //cracion de mensajes dependiendo de origen y destino
        //$coor_cli = $para == 'cliente';

        if ($perfil == 7 || $perfil == 8 || $perfil == 9) {

            $resp = CtrSolSolicitud::findById($id_solicitud);
            $solicitud = null;
            if (Result::isSuccess($resp))
                $solicitud = Result::getData($resp);

            $numero_documento = $solicitud['numero_documento'];

            $nombre_candidato = $solicitud['nombre_candidato'];
                
            $cliente_desc = $solicitud['cliente_desc'];

            $resultCorreos = QuerySQL::select(
                <<<SQL
                    select uu.email  email
                    from usr_usuario uu 
                    where uu.estado = 'ACT'
                    AND uu.email is not null
                    AND uu.perfil = 12;

            SQL,
                array(
                    "id_solicitud" => $id_solicitud
                ),
                true,
                "N"
            );

            $arrayCorreos = json_decode(json_encode($resultCorreos), true);
            for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                $para = $arrayCorreos[$i]['email'];
                $mensaje = "El Cliente ha enviado la siguiente novedad<br><br>"
                            .$observacion
                            ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                            ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                //$subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
                $subject = "NOTIFICACIÓN SERVICIO ";
                
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            }
        }else{
            $resp = CtrSolSolicitud::findById($id_solicitud);
            $solicitud = null;
            if (Result::isSuccess($resp))
                $solicitud = Result::getData($resp);

            $numero_documento = $solicitud['numero_documento'];

            $nombre_candidato = $solicitud['nombre_candidato'];
                
            $cliente_desc = $solicitud['cliente_desc'];

            $resultCorreos = QuerySQL::select(
                <<<SQL
                    select uu.email  email
                    from usr_usuario uu 
                    where uu.username in (select usuario 
                                            from sol_solicitud ss 
                                            where id_solicitud = :id_solicitud)
                    and uu.estado = 'ACT'
                    AND uu.email is not null;

            SQL,
                array(
                    "id_solicitud" => $id_solicitud
                ),
                true,
                "N"
            );

            $arrayCorreos = json_decode(json_encode($resultCorreos), true);
            for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                $para = $arrayCorreos[$i]['email'];
                $mensaje = "El Funcionario ha enviado la siguiente novedad<br><br>"
                            .$observacion
                            ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                            ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                //$subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
                $subject = "NOTIFICACIÓN SERVICIO ";
                
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            }
        }

        return BaseResponse::success($result);
    }

    public static function mensaje($id_solicitud, $id_servicio, $para, $mensaje, $perfil_campo, $origen)
    {
        //print_r($perfil_campo. $origen);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id solicitud debe ser númerico");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!is_numeric($id_servicio))
            return Result::error(__FUNCTION__, "id servicio debe ser númerico");

        $usuario = CtrUsuario::getUsuarioApp();

        $result = QuerySQL::update(
            <<<SQL
                    update sol_solicitud_servicio
                        set mensaje = :mensaje,
                            para = :para,
                            usr_modifica = :usuario,
                            fch_modifica = now()
                      where id_solicitud = :id_solicitud
                        and id_servicio = :id_servicio;
                SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
                "para" => $para,
                "mensaje" => $mensaje,
                "usuario" => $usuario,
            ),

            true,
            "N"
        );

        //cracion de mensajes dependiendo de origen y destino
        $coor_cli = ($perfil_campo == 1 || $perfil_campo == 12) && $para == 'cliente';
        $cli_coor = ($perfil_campo == 7 || $perfil_campo == 8 || $perfil_campo == 9) && $para == 'coordinador';
        $prov_coor = ($perfil_campo == 10 || $perfil_campo == 11 || $perfil_campo == 15 || $perfil_campo == 16) && $para == 'coordinador';
        $cali_prov = ($perfil_campo == 13) && $para == 'proveedor';
        $cali_coor = ($perfil_campo == 13) && $para == 'coordinador';

        $obj_usuario = new Usuario($origen);
        $nombre = $obj_usuario->getNombre();
        $apellido = $obj_usuario->getApellido();

        $funcionario = $nombre." ".$apellido;

        $resp = CtrSolSolicitud::findById($id_solicitud);
        $solicitud = null;
        if (Result::isSuccess($resp))
            $solicitud = Result::getData($resp);

        $numero_documento = $solicitud['numero_documento'];

        $nombre_candidato = $solicitud['nombre_candidato'];
            
        $cliente_desc = $solicitud['cliente_desc'];

        // Se envían los correos
        if (isset($result)) {
            if (/*$para == 'calidad' || $para == 'coordinador'*/$cli_coor) {
                //$perfil = CtrConfiguracion::val("destinatario_mensaje", $para);

                /*$resultCorreos = QuerySQL::select(
                    <<<SQL
                    select uu.email  email
                    from usr_usuario uu 
                    where uu.perfil in (select id
                                        from usr_perfil
                                        where descripcion = :perfil)
                    and uu.estado = 'ACT'
                    AND uu.email is not null;

                SQL,
                    array(
                        "perfil" => $perfil
                    ),
                    true,
                    "N"
                );*/

                $resultCorreos = QuerySQL::select(
                    <<<SQL
                        select uu.email  email
                        from usr_usuario uu 
                        where uu.username in (select usuario 
                                                from sol_solicitud ss 
                                                where id_solicitud = :id_solicitud)
                        and uu.estado = 'ACT'
                        AND uu.email is not null;

                SQL,
                    array(
                        "id_solicitud" => $id_solicitud
                    ),
                    true,
                    "N"
                );

                $arrayCorreos = json_decode(json_encode($resultCorreos), true);
                for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                    $para = $arrayCorreos[$i]['email'];
                    //$mensaje = $mensaje;

                    $mensaje = "El funcionario ".$funcionario." de la empresa ". $cliente_desc . " ha enviado la siguiente novedad<br><br>"
                    .$mensaje
                    ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                    ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;

                    $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                    $subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
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
                                                                ' . $mensaje . '<br>
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
                        $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                    }

                    try {
                        $mail->send();
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                    }
                }
            } elseif (/*$para == 'cliente'*/$coor_cli) {

                $resultCorreos = QuerySQL::select(
                    <<<SQL
                        select uu.email  email
                        from usr_usuario uu 
                        where uu.username in (select usuario 
                                                from sol_solicitud ss 
                                                where id_solicitud = :id_solicitud)
                        and uu.estado = 'ACT'
                        AND uu.email is not null;

                SQL,
                    array(
                        "id_solicitud" => $id_solicitud
                    ),
                    true,
                    "N"
                );

                $arrayCorreos = json_decode(json_encode($resultCorreos), true);
                for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                    $para = $arrayCorreos[$i]['email'];
                    $mensaje = "El funcionario ".$funcionario." ha enviado la siguiente novedad<br><br>"
                                .$mensaje
                                ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                                ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                    $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                    //$subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
                    $subject = "NOTIFICACIÓN SERVICIO ";
                    
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
                                                                ' . $mensaje . '<br>
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
                        $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                    }

                    try {
                        $mail->send();
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                    }
                }
            } elseif (/*$para == 'proveedor'*/$prov_coor) {
                $resultCorreos = QuerySQL::select(
                    <<<SQL
                        select uu.email  email
                            from usr_usuario uu 
                            where username in (select id_usuario_asig 
                                                from sol_solicitud_servicio sss
                                                where id_solicitud = :id_solicitud
                                                and id_servicio = :id_servicio)
                        and uu.estado = 'ACT'
                        AND uu.email is not null;

                SQL,
                    array(
                        "id_solicitud" => $id_solicitud,
                        "id_servicio" => $id_servicio,
                    ),
                    true,
                    "N"
                );

                $arrayCorreos = json_decode(json_encode($resultCorreos), true);
                $para = $arrayCorreos[0]['email'];
                //$mensaje = $mensaje;
                $mensaje = "El proveedor ".$funcionario." ha registrado la siguiente novedad:<br><br>"
                ."Comentario del proveedor ".$mensaje
                ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                $subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            } elseif (/*$para == 'proveedor'*/$cali_prov) {
                $resultCorreos = QuerySQL::select(
                    <<<SQL
                        select uu.email  email
                            from usr_usuario uu 
                            where username in (select id_usuario_asig 
                                                from sol_solicitud_servicio sss
                                                where id_solicitud = :id_solicitud
                                                and id_servicio = :id_servicio)
                        and uu.estado = 'ACT'
                        AND uu.email is not null;

                SQL,
                    array(
                        "id_solicitud" => $id_solicitud,
                        "id_servicio" => $id_servicio,
                    ),
                    true,
                    "N"
                );

                $arrayCorreos = json_decode(json_encode($resultCorreos), true);
                $para = $arrayCorreos[0]['email'];
                //$mensaje = $mensaje;
                $mensaje = "El funcionario ".$funcionario." (analista de calidad) ha enviado la siguiente novedad:<br><br>"
                ."Se devuelve proceso al proveedor por ".$mensaje
                ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                $subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            } elseif (/*$para == 'proveedor'*/$cali_coor) {
                $resultCorreos = QuerySQL::select(
                    <<<SQL
                        select uu.email  email
                            from usr_usuario uu 
                            where username in (select id_usuario_asig 
                                                from sol_solicitud_servicio sss
                                                where id_solicitud = :id_solicitud
                                                and id_servicio = :id_servicio)
                        and uu.estado = 'ACT'
                        AND uu.email is not null;

                SQL,
                    array(
                        "id_solicitud" => $id_solicitud,
                        "id_servicio" => $id_servicio,
                    ),
                    true,
                    "N"
                );

                $arrayCorreos = json_decode(json_encode($resultCorreos), true);
                $para = $arrayCorreos[0]['email'];
                //$mensaje = $mensaje;
                $mensaje = "El funcionario ".$funcionario." (analista de calidad) ha enviado la siguiente novedad:<br><br>"
                ."Se devuelve proceso al coordinador por ".$mensaje
                ."<br><br>Para ver el historial ingrese a ". $_ENV['APP_HOST']
                ."<br><br>Candidato: ".$nombre_candidato."<br>Empresa: ".$cliente_desc." <br>Documento: ".$numero_documento;
                $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                $subject = "Han registrado un mensaje en la Solicitud " . $id_solicitud;
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
                                                            ' . $mensaje . '<br>
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
                    $mail = new MAIL($para, "NOTIFICACIÓN SERVICIO " /*. $id_solicitud*/, $body);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CREACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            }
        }

        return BaseResponse::success($result);
    }



    public static function enviarCorreo($solicitud, $servicio, $tipo, $p_mensaje = null)
    {

        if ($tipo == 'servicio-cancelado') {
            $resultCorreo = QuerySQL::select(
                <<<SQL
                   select email email_emp, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario
                    from usr_usuario uu
                    where username = (
                    select id_usuario_asig
                    from sol_solicitud_servicio 
                    where id_solicitud = :solicitud
                    and id_servicio = :servicio);
    
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio
                ),
                true,
                "N"
            );

            $resultServicio = QuerySQL::select(
                <<<SQL
                   select nom_servicio 
                    from srv_servicios ss 
                    where ss.id_servicio = :servicio;                        
            SQL,
                array(
                    "servicio" => $servicio
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $para = $arrayCorreo[0]['email_emp'];
            $responsable = $arrayCorreo[0]['nom_usuario'];
            $asunto = "Servicio Cancelado";

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];
            $mensaje = "Apreciado " . $responsable . " se acabó de realizar la cancelación del servicio " . $servicio . " de la solicitud: " .  $solicitud .
                " por la siguiente razón: " . $p_mensaje;

        } else  if ($tipo == 'servicio-corregido') {
            $resultCorreo = QuerySQL::select(
                <<<SQL
                   select email email_emp, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario
                    from usr_usuario uu
                    where username = (select id_usuario_calidad
                                        from sol_solicitud_servicio 
                                        where id_solicitud = :solicitud
                                        and id_servicio = :servicio);
    
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio
                ),
                true,
                "N"
            );

            $resultServicio = QuerySQL::select(
                <<<SQL
                   select CONCAT(ss1.nom_servicio , ' para el candidato con número de documento: ',  ss.doc_candidato, ' por favor revisar su bandeja') nom_servicio
                    from sol_solicitud_servicio sss, sol_solicitud ss , srv_servicios ss1 
                    where ss.id_solicitud = :solicitud
                    and sss.id_servicio = :servicio
                    and ss.id_solicitud = sss.id_solicitud  
                    and ss1.id_servicio = sss.id_servicio ;                      
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio,
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $para = $arrayCorreo[0]['email_emp'];
            $responsable = $arrayCorreo[0]['nom_usuario'];
            $asunto = "Corrección a Servicio Rechazado";

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];

            $mensaje = "Apreciado " . $responsable . " se acabó de realizar la revisión del servicio " . $servicio . " de la solicitud: " .  $solicitud .
                " , el proveedor ya realizo la revisión.";

        } else if ($tipo == 'servicio-finalizado'){     //Correo de Finalizacion del servicio
            $resultCorreo = QuerySQL::select(
                <<<SQL
                   select email email_emp, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario
                    from usr_usuario uu
                    where username = (select usuario
                                        from sol_solicitud
                                        where id_solicitud = :solicitud);
            SQL,
                array(
                    "solicitud" => $solicitud
                ),
                true,
                "N"
            );

            $resultServicio = QuerySQL::select(
                <<<SQL
                   select CONCAT(ss1.nom_servicio , ' para el candidato con número de documento: ',  ss.doc_candidato, ' por favor revisar su bandeja') nom_servicio
                    from sol_solicitud_servicio sss, sol_solicitud ss , srv_servicios ss1 
                    where ss.id_solicitud = :solicitud
                    and sss.id_servicio = :servicio
                    and ss.id_solicitud = sss.id_solicitud  
                    and ss1.id_servicio = sss.id_servicio ;                      
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio,
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $para = $arrayCorreo[0]['email_emp'];
            $responsable = $arrayCorreo[0]['nom_usuario'];
            $asunto = "Finalización del Servicio";

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];

            $mensaje = "Apreciado " . $responsable . " se acabó de finalizar el servicio " . $servicio . " de la solicitud: " .  $solicitud;


            //cuerpo de correo
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
        } else if ($tipo == 'servicio-finalizado-alcance'){     //Correo de Finalizacion del servicio
            $resultCorreo = QuerySQL::select(
                <<<SQL
                   select email email_emp, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario
                    from usr_usuario uu
                    where username = (SELECT id_usuario_asig
                                        FROM sol_solicitud_servicio
                                       WHERE id_solicitud = :solicitud
                                         AND id_servicio = :servicio);
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio
                ),
                true,
                "N"
            );

            $resultServicio = QuerySQL::select(
                <<<SQL
                   select CONCAT(ss1.nom_servicio , ' para el candidato con número de documento: ',  ss.doc_candidato, ' por favor revisar su bandeja') nom_servicio
                    from sol_solicitud_servicio sss, sol_solicitud ss , srv_servicios ss1 
                    where ss.id_solicitud = :solicitud
                    and sss.id_servicio = :servicio
                    and ss.id_solicitud = sss.id_solicitud  
                    and ss1.id_servicio = sss.id_servicio ;                      
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio,
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $para = $arrayCorreo[0]['email_emp'];
            $responsable = $arrayCorreo[0]['nom_usuario'];
            $asunto = "Alcance Externo del Servicio";

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];

            $mensaje = "Apreciado Proveedor " . $responsable . " se acabó de finalizar con alcance externo el servicio " . $servicio . " de la solicitud: " .  $solicitud."\n"." por la siguiente razón: " . $p_mensaje;


            //cuerpo de correo
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
        } else if ($tipo == 'servicio-alcance'){     //Correo de Finalizacion del servicio
            $resultCorreo = QuerySQL::select(
                <<<SQL
                   select email email_emp, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario
                    from usr_usuario uu
                    where username = (SELECT id_usuario_calidad
                                        FROM sol_solicitud_servicio
                                       WHERE id_solicitud = :solicitud
                                         AND id_servicio = :servicio);
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio
                ),
                true,
                "N"
            );

            $resultServicio = QuerySQL::select(
                <<<SQL
                   select CONCAT(ss1.nom_servicio , ' para el candidato con número de documento: ',  ss.doc_candidato, ' por favor revisar su bandeja') nom_servicio
                    from sol_solicitud_servicio sss, sol_solicitud ss , srv_servicios ss1 
                    where ss.id_solicitud = :solicitud
                    and sss.id_servicio = :servicio
                    and ss.id_solicitud = sss.id_solicitud  
                    and ss1.id_servicio = sss.id_servicio ;                      
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio,
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $para = $arrayCorreo[0]['email_emp'];
            $responsable = $arrayCorreo[0]['nom_usuario'];
            $asunto = "Alcance Externo del Servicio";

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];

            $mensaje = "Apreciado Proveedor " . $responsable . " se acabó de completar el servicio con alcance externo el servicio " . $servicio . " de la solicitud: " .  $solicitud."\n"." por la siguiente razón: " . $p_mensaje;


            //cuerpo de correo
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
        } else {
            $resultCorreo = QuerySQL::select(
                <<<SQL
                   select email email_emp, CONCAT(uu.nombres, ' ', uu.apellidos) nom_usuario
                    from usr_usuario uu
                    where username = (
                    select id_usuario_asig
                    from sol_solicitud_servicio 
                    where id_solicitud = :solicitud
                    and id_servicio = :servicio);
    
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio
                ),
                true,
                "N"
            );

            $resultServicio = QuerySQL::select(
                <<<SQL
                   select CONCAT(ss1.nom_servicio , ' para el candidato con número de documento: ',  ss.doc_candidato, ' por favor revisar su bandeja') nom_servicio
                    from sol_solicitud_servicio sss, sol_solicitud ss , srv_servicios ss1 
                    where ss.id_solicitud = :solicitud
                    and sss.id_servicio = :servicio
                    and ss.id_solicitud = sss.id_solicitud  
                    and ss1.id_servicio = sss.id_servicio ;                      
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio,
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultCorreo), true);
            $para = $arrayCorreo[0]['email_emp'];
            $responsable = $arrayCorreo[0]['nom_usuario'];
            $asunto = "Servicio Rechazado";

            $arrayServicio = json_decode(json_encode($resultServicio), true);
            $servicio = $arrayServicio[0]['nom_servicio'];
            $mensaje = "Apreciado " . $responsable . " se acabó de realizar el rechazado del servicio " . $servicio . " de la solicitud: " .  $solicitud .
                " por la siguiente razón: " . $p_mensaje;

            //cuerpo de correo
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

    public static function actualizarSolicitud($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolSolicitud($id_solicitud);
        $dao->setProperty('id_estado_solicitud', 'gestion');

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Crear un valor adicional
    public static function valorAdicional($id, $solicitud, $servicio, $valor_adicional, $observacion)
    {
        //print_r($id);
        if (!isset($solicitud) || $solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $id_cuenta = CtrConfiguracion::val("cuenta_srv_adc", "id_cuenta");

        if ($id == null || $id == '') {
            $dao = new SolServiciosAdicionales;
            $dao->setProperty('id_solicitud', $solicitud);
            $dao->setProperty('id_servicio', $servicio);
            $dao->setProperty('id_cuenta', $id_cuenta);
            $dao->setProperty('observacion', $observacion);
            $dao->setProperty('valor', $valor_adicional);
            $result =  $dao->insert();
        } else {
            $dao = new SolServiciosAdicionales($id);
            $dao->setProperty('id_solicitud', $solicitud);
            $dao->setProperty('id_servicio', $servicio);
            $dao->setProperty('id_cuenta', $id_cuenta);
            $dao->setProperty('observacion', $observacion);
            $dao->setProperty('valor', $valor_adicional);
            $result =  $dao->update();
        }

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findByIdValorAdicional($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    SELECT ve.id,
                           ve.observacion,
                           ve.valor,
                           ve.usr_create,
                           ve.fch_create
                      FROM sol_servicios_adicionales ve
                     WHERE ve.id_solicitud  = :id_solicitud
                       AND ve.id_servicio  = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar factor de riesgo");
    }


    public static function calificar($solicitud, $servicio, $v1, $v2, $v3, $v4)
    {
        if (!isset($solicitud) || $solicitud == "")
            return Result::error(__FUNCTION__, "solicitud es requerido");

        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");


        if (!isset($v1) || $v1 == "" || $v1 == 0)
            return Result::error(__FUNCTION__, "Calificación 1 es requerido");

        if (!isset($v2) || $v2 == "" || $v2 == 0)
            return Result::error(__FUNCTION__, "Calificación  2 es requerido");

        if (!isset($v3) || $v3 == "" || $v3 == 0)
            return Result::error(__FUNCTION__, "Calificación  3 es requerido");

        if (!isset($v4) || $v4 == "" || $v4 == 0)
            return Result::error(__FUNCTION__, "Calificación  4 es requerido");


        $result = QuerySQL::update(
            <<<SQL
                        update sol_solicitud_servicio
                            set calificado = 'S'
                          where id_solicitud = :solicitud
                            and id_servicio = :servicio;
                    SQL,
            array(
                "solicitud" => $solicitud,
                "servicio" => $servicio,
            ),
            true,
            "N"
        );

        if ($result['success']) {

            $resultProveedor = QuerySQL::select(
                <<<SQL
                   select id_usuario_asig
                    from sol_solicitud_servicio sss 
                    where id_solicitud =  :solicitud;                    
                    and id_servicio =  :servicio;                    
            SQL,
                array(
                    "solicitud" => $solicitud,
                    "servicio" => $servicio,
                ),
                true,
                "N"
            );

            $arrayCorreo = json_decode(json_encode($resultProveedor), true);
            $proveedor = $arrayCorreo[0]['id_usuario_asig'];

            $dao = new SrvServiciosCalificados;
            $dao->setProperty('id_solicitud', $solicitud);
            $dao->setProperty('id_servicio', $servicio);
            $dao->setProperty('id_proveedor', $proveedor);
            $dao->setProperty('pregunta1', $v1);
            $dao->setProperty('pregunta2', $v2);
            $dao->setProperty('pregunta3', $v3);
            $dao->setProperty('pregunta4', $v4);

            $result =  $dao->insert();
            if ($result['success']) {
                return Result::success($result);
            } else {
                return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
            }
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function crear($solicitud, $servicio, $estado, $servicio_adicionado, $idx, $cantidad)
    {
        //print_r($servicio."-".$cantidad."-".$servicio_adicionado);
        if (!isset($solicitud) || $solicitud == "")
            return Result::error(__FUNCTION__, "solicitud es requerido");

        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");

        if ($idx != $cantidad) {
            $ultimo =  'N';
        } else {
            $ultimo =  'S';
        }

        $dao = new SolSolicitudServicio;
        $dao->setProperty('id_solicitud', $solicitud);
        $dao->setProperty('id_servicio', $servicio);
        $dao->setProperty('estado', $estado);
        $dao->setProperty('servicio_adicionado', $servicio_adicionado);
        $dao->setProperty('ultimo', $ultimo);
        $dao->setProperty('usr_create', CtrUsuario::getUsuarioApp());

        $result =  $dao->insert();
        if ($result['success']) {
            return Result::success($result);
        } else {
            //print_r($result);
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function agregar()
    {
        if (!isset($_POST['idSolicitud']) || $_POST['idSolicitud'] == "") {
            return Result::error(__FUNCTION__, "La solicitud es requerida");
        }
    
        if (isset($_POST["servicio_sel"]) && !is_array($_POST["servicio_sel"])) {
            return Result::error(__FUNCTION__, "Los servicios deben ser un array");
        }
    
        $obj_solSolicitud = new SolSolicitud($_POST['idSolicitud']);
        $combo = $obj_solSolicitud->getIdCombo('id_combo');
        $fecha_solicitud = new DateTime($obj_solSolicitud->getFchSolicitud('fch_solicitud'));
    
        $cantidad = count($_POST["servicio_sel"]) - 1;
        for ($i = 0; $i < count($_POST["servicio_sel"]); $i++) {
            $result = Result::getData(self::crear($_POST['idSolicitud'], $_POST["servicio_sel"][$i], 1, 'S', $i, $cantidad));
            if (Result::isError($result)) {
                return BaseResponse::error(__FUNCTION__, "Error creando los servicios");
            }
        }
    
        if ($combo != '') {
            $obj_solSolicitud2 = new SolSolicitud($_POST['idSolicitud']);
            $combo_nuevo = $obj_solSolicitud2->getIdCombo('id_combo');
            $ciudad_vacante = $obj_solSolicitud2->getCiudad('ciudad_vacante');
    
            $obj_sla_combo = new SrvCombos($combo_nuevo);
            $sla = ($ciudad_vacante == 149) ? $obj_sla_combo->getSlaBogota('sla_bogota') : $obj_sla_combo->getSlaExterno('sla_externo');
    
            while ($sla > 0) {
                // Incrementar la fecha estimada
                $fecha_solicitud->modify('+1 day');
                
                // Verificar si la fecha es fin de semana o festivo
                if (self::esFinDeSemanaOFestivo($fecha_solicitud->format('Y-m-d'))) {
                    continue; // Si es fin de semana o festivo, pasar al siguiente día
                }
                
                $sla--; // Decrementar el contador de días hábiles
            }
    
            $fecha = $fecha_solicitud->format('Y-m-d H:i:s');
    
            // Realizar la actualización
            $result1 = QuerySQL::update(
                <<<SQL
                    UPDATE sol_solicitud 
                    SET fch_estimada_sol_nueva = :fecha 
                    WHERE id_solicitud = :idSolicitud
                SQL,
                array(
                    "idSolicitud" => $_POST['idSolicitud'],
                    "fecha" => $fecha
                )
            );
    
            // Verificar el resultado de la actualización
            if (!$result1['success']) {
                error_log("Error actualizando la fecha estimada: " . json_encode($result1));
                return Result::error(__FUNCTION__, 'Error actualizando la fecha estimada');
            }
        }
    
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, 'No se puede agregar el servicio, el combo resultante no está configurado para el cliente');
        }
    }
    
    public static function esFinDeSemanaOFestivo($fecha)
    {
        $dateTime = new DateTime($fecha);
        $dayOfWeek = $dateTime->format('N'); // 1: lunes, 2: martes, ..., 6: sábado, 7: domingo
    
        // Verificar si es fin de semana
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            return true;
        }
    
        // Obtener los días festivos de la base de datos
        $festivosColombia = self::getFestivosColombia();

        //print_r($festivosColombia);

        // Crear un nuevo arreglo para almacenar las fechas de festivos
        $fechasFestivos = array();

        // Iterar sobre el arreglo multidimensional y guardar las fechas en el nuevo arreglo
        foreach ($festivosColombia as $festivo) {
            $fechasFestivos[] = $festivo['fecha'];
        }

        // Imprimir el nuevo arreglo de fechas de festivos
        //print_r($fechasFestivos);
        
        // Formatear la fecha en formato Y-m-d
        $fechaFormateada = $dateTime->format('Y-m-d');
    
        // Verificar si la fecha es un día festivo en Colombia
        if (in_array($fechaFormateada, $fechasFestivos)) {
            return true;
        }
    
        return false;
    }
    
    public static function getFestivosColombia()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT DATE(fecha) AS fecha
                FROM conf_dias_festivos;
            SQL,
            array(),
            true,
            "N"
        );
        
        return $result;
    }
    
    
    
    
    
    
    
    
}
