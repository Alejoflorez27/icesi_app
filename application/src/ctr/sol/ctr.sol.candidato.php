<?php

class CtrSolCandidato
{
    public static function crear($id_solicitud, $id_ciudad_act, $tipo_id, $numero_doc, $nombre,  $apellido, $telefono, $direccion, $email, $cargo_desempeno, $alias = null)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_solCandidato = new SolCandidato();
        $obj_solCandidato->setProperty('id_solicitud', $id_solicitud);
        $obj_solCandidato->setProperty('id_ciudad_act', $id_ciudad_act);
        $obj_solCandidato->setProperty('tipo_id', $tipo_id);
        $obj_solCandidato->setProperty('numero_doc', $numero_doc);
        $obj_solCandidato->setProperty('nombre', $nombre);
        $obj_solCandidato->setProperty('apellido', $apellido);
        $obj_solCandidato->setProperty('telefono', $telefono);
        $obj_solCandidato->setProperty('direccion', $direccion);
        $obj_solCandidato->setProperty('email', $email);
        $obj_solCandidato->setProperty('cargo_desempeno', $cargo_desempeno);
        $obj_solCandidato->setProperty('alias', $alias);

        $result = $obj_solCandidato->insert();
        if ($result['success']) {
            $validCombo =  QuerySQL::select(
                <<<SQL
                            select nvl(ss.id_combo,0) combo
                            from sol_solicitud ss
                            where ss.id_solicitud = :id_solicitud;
                    SQL,
                array(
                    "id_solicitud" =>  $id_solicitud
                ),
                true,
                "N"
            );

            $existeCombo = json_decode(json_encode($validCombo), true);
            $combo = $existeCombo[0]['combo'];
            if ($combo != 0) {
                $resultEnviaCorreo = QuerySQL::select(
                    <<<SQL
                       select nvl(sc2.env_correo,0) env_correo
                        from sol_solicitud ss, srv_combos sc2
                        where ss.id_combo = sc2.id_combo 
                        and ss.id_solicitud  = :id_solicitud;
                    SQL,
                    array("id_solicitud" => $id_solicitud),
                    true,
                    "N"
                );

                $arrayEnviaCorreo = json_decode(json_encode($resultEnviaCorreo), true);
                $env_correo = $arrayEnviaCorreo[0]['env_correo'];

                if ($env_correo == 1) {
                    $resultCorreo = QuerySQL::select(
                        <<<SQL
                        select sc.email email, CONCAT('Estimado(a) ' ,CONCAT(sc.nombre, ' ' ,sc.apellido) , '<br> Usted ha sido vinculado a un proceso de selección con ', te.razon_social,   
                            ' , por favor diligencie su hoja de vida en nuestro sistema accediendo al siguiente link:') mensaje
                            from sol_solicitud ss , trc_empresa te , sol_candidato sc 
                            where ss.id_empresa = te.id_empresa 
                            and ss.id_solicitud = sc.id_solicitud 
                            and ss.id_solicitud = :id_solicitud
                        SQL,
                        array("id_solicitud" => $id_solicitud),
                        true,
                        "N"
                    );

                    $arrayTextoCorreo = json_decode(json_encode($resultCorreo), true);
                    $mensaje = $arrayTextoCorreo[0]['mensaje'];
                    $email = $arrayTextoCorreo[0]['email'];

                    try {

                        $nuevoPassword =  crypt('Prohumanos', constant('APP_KEY'));
                        $resultEnviaCorreo = QuerySQL::update(
                            <<<SQL
                              update usr_usuario
                                set  password = :nuevoPassword,
                                     password_expiration = DATE_SUB(create_time ,INTERVAL 1 YEAR)
                                where username = :numero_doc;
                            SQL,
                            array(
                                "numero_doc" => $numero_doc,
                                "nuevoPassword" => $nuevoPassword
                            ),
                            true,
                            "N"
                        );
                        // Se envía correo con el password
                        $politicas = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/FMEC-003_V4_FORMATO_AUTORIZACION_ESTUDIO_CONFIABILIDAD.pdf';
                        $mensaje_ingreso = "<br>Le aparecerá una casilla en donde usted debe ingresar en usuario el número de su identificación y en contraseña la palabra “Prohumanos”. Una vez haya ingresado la contraseña, el sistema le solicitará la creación de una nueva.<br><br>Debe descargar el <a href=\"$politicas\">formato de autorización de estudio de confiabilidad</a>, el cual debe imprimir, diligenciar en su totalidad y cargar a la plataforma con los demás documentos requeridos.<br><br>Se solicita que todos los documentos requeridos se encuentren en formato PNG o JPG."
                        ."<br><br>Si requiere ayuda por favor comunicarse al teléfono 3112775882 - 3144645216 - 3102986756 en la ciudad de Bogotá o al email confiabilidad@prohumanos.com"
                        ."<br><br>Recuerde que su hoja de vida estará activa por un lapso de 20 horas."
                        ."<br><br><span style=\"color: red;\">Nota: Tenga en cuenta que, si su estudio corresponde a una visita de mantenimiento, no es necesario ingresar al link.</span>";
                        
                        
                        $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                        //$subject = "Correo Confirmación Proceso Selección Candidato";
                        $subject = "INVITACIÓN INGRESO HOJA DE VIDA";
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
                                                                    <a href="'. $_ENV['APP_HOST'].'/candidato?solicitud='.$id_solicitud.'" target="_blank">click aqui</a>
                                                                    <br> ' . $mensaje_ingreso . '
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
            
                        $mail = new MAIL($email, "INVITACIÓN INGRESO HOJA DE VIDA", $body);
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "Envío Correo Candidato", "code" => $e->getMessage());
                    }

                    try {
                        $mail->send();
                        return BaseResponse::success($result);
                    } catch (Exception $e) {
                        return array("success" => false, "action" => "Envío Correo Candidato", "code" => $mail->ErrorInfo);
                    }
                }
                return BaseResponse::success($result);
            } else {
                return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, 'No existe combo');
            }
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($estado = null)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select ss.id_solicitud , ss.estado , case when usuario is not null then 
                        (select CONCAT(uu.nombres, ' ', uu.apellidos) from usr_usuario uu where uu.username = ss.usuario)  				
                    else
                        null
                    end responsable, ss.id_estado_solicitud , sc.id_combo , sc.nom_combo , ss.id_empresa , te.razon_social ,
                    ss.observacion , ss.fch_solicitud , ss.fch_estimada_sol , ss.fch_preliminar , ss.fch_fin_solicitud ,
                    ss.usr_create , ss.fch_create 
                    from sol_solicitud ss, srv_combos sc , trc_empresa te 
                    where ss.id_combo = sc.id_combo 
                    and ss.id_empresa = te.id_empresa
                    and (ss.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar servicio");
    }

    static public function consultarTodos()
    {
        $obj_srvServicio = new SrvServicio();
        return $obj_srvServicio->selectAll();
    }

    public static function deleteFoto($id_candidato)
    {

        //borrar el archivo del directorio
        $miObjetoArchivo = new CtrSolCandidato();
        $result1 =  $miObjetoArchivo->findByIdDoc($id_candidato);
        $directorio = $result1['directorio'];
        $nombre_encr = $result1['nombre_encr'];
        $ruta = "$directorio/$nombre_encr";

        if (unlink($ruta)) {

        }
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('directorio', '');
        $dao->setProperty('nombre_foto', '');
        $dao->setProperty('nombre_encr', '');
        $dao->setProperty('tamano_foto', '');
        $dao->setProperty('ext', '');

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //prueba findById
    public static function findByIdDoc($id_candidato)
    {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");
        if (!is_numeric($id_candidato))
            return Result::error(__FUNCTION__, "id debe ser numerico");

        $result = QuerySQL::select(
            <<<SQL
                select sa.id_candidato, sa.directorio, sa.nombre_encr 
                       from sol_candidato sa
                       where sa.id_candidato = :id_candidato;
                SQL,
            array("id_candidato" => $id_candidato),
            false,
            "N"
        );

        return $result;
    }

    public static function findById($id_servicio)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ss.id_servicio , ss.id_producto, sp.nom_prod , ss.nom_servicio , 
                    ss.estado , ss.usr_create , ss.fch_create 
                    from srv_servicios ss , srv_producto sp 
                    where sp.id_producto = ss.id_producto 
                    and  ss.id_servicio = :id_servicio
            SQL,
            array("id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar servicio");
    }

    //Funcion para obtener los datos de un candidato por el numero de documento
    public static function findById_candidato($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL

            SELECT 
                sc.id_candidato,
                sc.nombre,
                sc.apellido,
                sc.tipo_id,
                sc.numero_doc,
                sc.id_ciudad_nac,
                sc.fch_nacimiento,
                sc.id_ciudad_act,
                sc.id_ciudad_expe,  -- ✅ Nuevo campo
                sc.fch_expedicion,
                sc.edad,
                sc.libreta,
                sc.estado_civil,
                sc.telefono,
                sc.email,
                sc.email1,
                sc.id_solicitud,
                sc.direccion,
                sc.barrio,
                sc.estracto,
                sc.nivel_escolar,
                sc.cargo_desempeno,
                sc.persona_visita,
                sc.parantesco_visita,
                cc.id_dpto,
                cd.id_pais,
                cc2.id_dpto AS dpto_nac,
                cd2.id_pais AS pais_nac,
                cc3.id_dpto AS dpto_expe,      -- ✅ Departamento de la ciudad de experiencia
                cd3.id_pais AS pais_expe       -- ✅ País de la ciudad de experiencia
            FROM sol_candidato sc
            LEFT JOIN usr_usuario u ON u.numero_identificacion = sc.numero_doc
            LEFT JOIN conf_ciudad cc ON sc.id_ciudad_act = cc.id_ciudad
            LEFT JOIN conf_dpto cd ON cc.id_dpto = cd.id_dpto
            LEFT JOIN conf_pais cp ON cd.id_pais = cp.id_pais
            LEFT JOIN conf_ciudad cc2 ON sc.id_ciudad_nac = cc2.id_ciudad
            LEFT JOIN conf_dpto cd2 ON cc2.id_dpto = cd2.id_dpto
            LEFT JOIN conf_pais cp2 ON cd2.id_pais = cp2.id_pais
            LEFT JOIN conf_ciudad cc3 ON sc.id_ciudad_expe = cc3.id_ciudad   -- ✅ Join para ciudad de experiencia
            LEFT JOIN conf_dpto cd3 ON cc3.id_dpto = cd3.id_dpto            -- ✅ Join para dpto de experiencia
            LEFT JOIN conf_pais cp3 ON cd3.id_pais = cp3.id_pais            -- ✅ Join para país de experiencia
            WHERE sc.id_solicitud = :id_solicitud;



            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
        return Result::success($result, "buscar candidato");
    }

    //Funcion para obtener los datos de un candidato por el numero de documento visitas
    public static function findById_candidato_vistas($numero_doc)
    {

        $result = QuerySQL::select(
            <<<SQL

            SELECT 
                sc.id_candidato,
                sc.nombre,
                sc.apellido,
                sc.tipo_id,
                fcn_desc_configurations('tipo_identificacion', sc.tipo_id) AS des_tipo_doc,
                sc.numero_doc,
                sc.id_ciudad_nac,
                sc.fch_nacimiento,
                sc.id_ciudad_act,
                cc.nombre AS nombre_ciu_actual,
                cd.nombre AS nom_dpto_actual,
                cp.nombre AS nombre_pais_actual,
                cc2.nombre AS nombre_ciudad_nac,
                cd2.nombre AS nom_dpto_nac,
                cp2.nombre AS nom_pais_nac,
                sc.edad,
                sc.libreta,
                sc.estado_civil,
                fcn_desc_configurations('tipo_estado_civil', sc.estado_civil) AS des_estado_civil,
                sc.telefono,
                sc.email,
                sc.salario_actual,
                sc.salario_dev,
                sc.id_solicitud,
                sc.direccion,
                sc.barrio,
                sc.estracto,
                sc.nivel_escolar,
                fcn_desc_configurations('tipo_nivel_escolar', sc.nivel_escolar) AS des_nivel_escolar,
                sc.cargo_desempeno,
                sc.persona_visita,
                sc.parantesco_visita,
                sc.salario_anterior,
                sc.tmp_operacion,
                sc.servicio_suministrado,
                sc.horario_operacion,
                sc.fecha_visita,
                sc.razon_social,
                sc.nit,
                sc.nombre_representante,
                sc.apellido_representante,
                sc.act_economica,
                sc.capital_suscrito,
                sc.paises_exterior,
                sc.fch_constituida,
                sc.vol_operaciones,
                sc.instalaciones,
                sc.servicio_suministrado,
                sc.num_resolucion,
                sc.certificacion,
                cc.id_dpto,
                cd.id_pais,
                cc2.id_dpto AS dpto_nac,
                cd2.id_pais AS pais_nac,
                sc.salario_dev,
                sc.jefe_area,
                sc.area,
                sc.arl
            FROM sol_candidato sc
            LEFT JOIN conf_ciudad cc ON sc.id_ciudad_act = cc.id_ciudad
            LEFT JOIN conf_dpto cd ON cc.id_dpto = cd.id_dpto
            LEFT JOIN conf_pais cp ON cd.id_pais = cp.id_pais
            LEFT JOIN conf_ciudad cc2 ON sc.id_ciudad_nac = cc2.id_ciudad
            LEFT JOIN conf_dpto cd2 ON cc2.id_dpto = cd2.id_dpto
            LEFT JOIN conf_pais cp2 ON cd2.id_pais = cp2.id_pais
            WHERE sc.id_solicitud = :numero_doc;


        SQL,
            array("numero_doc" => $numero_doc),
            true,
            "N"
        );
        return Result::success($result, "buscar candidato");
    }

    //Funcion para obtener los datos de un candidato por el numero de documento visitas
    public static function findById_candidato_ec_con_cifin($numero_doc)
    {

        $result = QuerySQL::select(
            <<<SQL

            SELECT 
                sc.id_candidato,
                sc.nombre,
                sc.apellido,
                sc.tipo_id,
                fcn_desc_configurations('tipo_identificacion', sc.tipo_id) AS des_tipo_doc,
                sc.numero_doc,
                sc.id_ciudad_nac,
                sc.fch_nacimiento,
                sc.id_ciudad_act,
                cc.nombre AS nombre_ciu_actual,
                cd.nombre AS nom_dpto_actual,
                cp.nombre AS nombre_pais_actual,
                cc2.nombre AS nombre_ciudad_nac,
                cd2.nombre AS nom_dpto_nac,
                cp2.nombre AS nom_pais_nac,
                sc.edad,
                sc.libreta,
                sc.estado_civil,
                fcn_desc_configurations('tipo_estado_civil', sc.estado_civil) AS des_estado_civil,
                sc.telefono,
                sc.email,
                sc.salario_actual,
                sc.salario_dev,
                sc.id_solicitud,
                sc.direccion,
                sc.barrio,
                sc.estracto,
                sc.nivel_escolar,
                fcn_desc_configurations('tipo_nivel_escolar', sc.nivel_escolar) AS des_nivel_escolar,
                sc.cargo_desempeno,
                sc.referencia_personal,
                cc.id_dpto,
                cd.id_pais,
                cc2.id_dpto AS dpto_nac,
                cd2.id_pais AS pais_nac,
                sc.salario_dev
            FROM sol_candidato sc
            LEFT JOIN conf_ciudad cc ON sc.id_ciudad_act = cc.id_ciudad
            LEFT JOIN conf_dpto cd ON cc.id_dpto = cd.id_dpto
            LEFT JOIN conf_pais cp ON cd.id_pais = cp.id_pais
            LEFT JOIN conf_ciudad cc2 ON sc.id_ciudad_nac = cc2.id_ciudad
            LEFT JOIN conf_dpto cd2 ON cc2.id_dpto = cd2.id_dpto
            LEFT JOIN conf_pais cp2 ON cd2.id_pais = cp2.id_pais
            WHERE sc.id_solicitud = :numero_doc;


        SQL,
            array("numero_doc" => $numero_doc),
            true,
            "N"
        );
        return Result::success($result, "buscar candidato");
    }

public static function findById_candidato_poligrafia($numero_doc)
{

    $result = QuerySQL::select(
        <<<SQL

        SELECT 
            sc.id_candidato,
            sc.nombre,
            sc.apellido,
            sc.tipo_id,
            sc.numero_doc,
            sc.id_ciudad_nac,
            sc.fch_nacimiento,
            sc.id_ciudad_act,
            sc.edad,
            sc.libreta,
            sc.estado_civil,
            sc.telefono,
            sc.email,
            sc.email1,
            sc.id_solicitud,
            sc.direccion,
            sc.barrio,
            sc.estracto,
            sc.nivel_escolar,
            sc.cargo_desempeno,
            sc.alias,
            sc.nombre_foto,
            sc.nombre_encr,
            sc.directorio,
            cc.id_dpto,
            cd.id_pais,
            cc2.id_dpto AS dpto_nac,
            cd2.id_pais AS pais_nac
        FROM sol_candidato sc
        LEFT JOIN conf_ciudad cc ON sc.id_ciudad_act = cc.id_ciudad
        LEFT JOIN conf_dpto cd ON cc.id_dpto = cd.id_dpto
        LEFT JOIN conf_pais cp ON cd.id_pais = cp.id_pais
        LEFT JOIN conf_ciudad cc2 ON sc.id_ciudad_nac = cc2.id_ciudad
        LEFT JOIN conf_dpto cd2 ON cc2.id_dpto = cd2.id_dpto
        LEFT JOIN conf_pais cp2 ON cd2.id_pais = cp2.id_pais
        WHERE sc.id_solicitud = :numero_doc;



        SQL,
        array("numero_doc" => $numero_doc),
        true,
        "N"
    );
    return Result::success($result, "buscar candidato");
}

public static function findById_candidato_visita_asociado($id_solicitud)
{

    $result = QuerySQL::select(
        <<<SQL

            SELECT 
                sc.id_candidato,
                sc.nombre,
                sc.apellido,
                sc.tipo_id,
                sc.numero_doc,
                sc.id_ciudad_nac,
                sc.fch_nacimiento,
                sc.id_ciudad_act,
                sc.edad,
                sc.libreta,
                sc.estado_civil,
                sc.telefono,
                sc.email,
                sc.email1,
                sc.id_solicitud,
                sc.direccion,
                sc.barrio,
                sc.estracto,
                sc.nivel_escolar,
                sc.cargo_desempeno,
                sc.nombre_foto,
                sc.fecha_visita,
                sc.razon_social,
                sc.nit,
                sc.nombre_representante,
                sc.apellido_representante,
                sc.act_economica,
                sc.capital_suscrito,
                sc.paises_exterior,
                sc.fch_constituida,
                sc.vol_operaciones,
                sc.instalaciones,
                sc.servicio_suministrado,
                sc.tmp_operacion,
                sc.horario_operacion,
                sc.num_resolucion,
                sc.certificacion,
                sc.directorio,
                sc.nombre_encr,
                cc.id_dpto,
                cd.id_pais,
                cc2.id_dpto AS dpto_nac,
                cd2.id_pais AS pais_nac
            FROM sol_candidato sc
            LEFT JOIN conf_ciudad cc ON sc.id_ciudad_act = cc.id_ciudad
            LEFT JOIN conf_dpto cd ON cc.id_dpto = cd.id_dpto
            LEFT JOIN conf_pais cp ON cd.id_pais = cp.id_pais
            LEFT JOIN conf_ciudad cc2 ON sc.id_ciudad_nac = cc2.id_ciudad
            LEFT JOIN conf_dpto cd2 ON cc2.id_dpto = cd2.id_dpto
            LEFT JOIN conf_pais cp2 ON cd2.id_pais = cp2.id_pais
            WHERE sc.id_solicitud = :id_solicitud;

        SQL,
        array("id_solicitud" => $id_solicitud),
        true,
        "N"
    );
    return Result::success($result, "buscar candidato visita asociado de negocio");
}


        //print_r($result);

    public static function update(
        $id_candidato,
        $tipo_id,
        $numero_doc,
        $nombre,
        $apellido,
        $id_ciudad_act,
        $localidad,
        $email,
        $telefono,
        $direccion,
        $cargo
    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('tipo_id', $tipo_id);
        $dao->setProperty('numero_doc', $numero_doc);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('localidad', $localidad);
        $dao->setProperty('email', $email);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('cargo_desempeno', $cargo);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Funcion de Actualizar el candidato
    public static function update_candidato(
        $id_candidato,
        $id_ciudad_nac,
        $id_ciudad_act,
        $tipo_id,
        $numero_doc,
        $nombre,
        $apellido,
        $fch_nacimiento,
        $edad,
        $libreta,
        $estado_civil,
        $telefono,
        $direccion,
        $barrio,
        $estracto,
        $id_solicitud,
        $id_ciudad_expe,
        $fch_expedicion

    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('tipo_id', $tipo_id);
        $dao->setProperty('numero_doc', $numero_doc);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('fch_nacimiento', $fch_nacimiento);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('libreta', $libreta);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('barrio', $barrio);
        $dao->setProperty('estracto', $estracto);
        $dao->setProperty('id_ciudad_expe', $id_ciudad_expe);
        $dao->setProperty('fch_expedicion', $fch_expedicion);
        
        $daoSolicitud = new SolSolicitud($id_solicitud);
        $daoSolicitud->setDocCandidato($numero_doc);
        $daoSolicitud->update();

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_candidato_visita_ingreso(
        $id_candidato,
        $id_ciudad_nac,
        $id_ciudad_act,
        $tipo_id,
        $numero_doc,
        $nombre,
        $apellido,
        $fch_nacimiento,
        $edad,
        $libreta,
        $estado_civil,
        $telefono,
        $email,
        $salario_dev,
        $direccion,
        $barrio,
        $estracto,
        $nivel_escolar,
        $cargo_desempeno,
        $persona_visita,
        $parantesco_visita,
        $id_solicitud

    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('tipo_id', $tipo_id);
        $dao->setProperty('numero_doc', $numero_doc);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('fch_nacimiento', $fch_nacimiento);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('libreta', $libreta);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('email', $email);
        $dao->setProperty('salario_dev', $salario_dev);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('barrio', $barrio);
        $dao->setProperty('estracto', $estracto);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('cargo_desempeno', $cargo_desempeno);
        $dao->setProperty('persona_visita', $persona_visita);
        $dao->setProperty('parantesco_visita', $parantesco_visita);

        $daoSolicitud = new SolSolicitud($id_solicitud);
        $daoSolicitud->setDocCandidato($numero_doc);
        $daoSolicitud->update();

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_candidato_visita_mantenimiento(
        $id_candidato,
        $id_ciudad_nac,
        $id_ciudad_act,
        $tipo_id,
        $numero_doc,
        $nombre,
        $apellido,
        $fch_nacimiento,
        $edad,
        $libreta,
        $estado_civil,
        $telefono,
        $email,
        $salario_actual,
        $direccion,
        $barrio,
        $estracto,
        $nivel_escolar,
        $cargo_desempeno,
        $persona_visita,
        $parantesco_visita,
        $id_solicitud

    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('tipo_id', $tipo_id);
        $dao->setProperty('numero_doc', $numero_doc);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('fch_nacimiento', $fch_nacimiento);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('libreta', $libreta);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('email', $email);
        $dao->setProperty('salario_actual', $salario_actual);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('barrio', $barrio);
        $dao->setProperty('estracto', $estracto);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('cargo_desempeno', $cargo_desempeno);
        $dao->setProperty('persona_visita', $persona_visita);
        $dao->setProperty('parantesco_visita', $parantesco_visita);

        $daoSolicitud = new SolSolicitud($id_solicitud);
        $daoSolicitud->setDocCandidato($numero_doc);
        $daoSolicitud->update();

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_candidato_visita_teletrabajo(
        $id_candidato,
        $id_ciudad_nac,
        $id_ciudad_act,
        $tipo_id,
        $numero_doc,
        $nombre,
        $apellido,
        $fch_nacimiento,
        $edad,
        $libreta,
        $estado_civil,
        $telefono,
        $email,
        $salario_actual,
        $direccion,
        $barrio,
        $estracto,
        $nivel_escolar,
        $cargo_desempeno,
        $persona_visita,
        $parantesco_visita,
        $id_solicitud

    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('tipo_id', $tipo_id);
        $dao->setProperty('numero_doc', $numero_doc);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('fch_nacimiento', $fch_nacimiento);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('libreta', $libreta);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('email', $email);
        $dao->setProperty('salario_actual', $salario_actual);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('barrio', $barrio);
        $dao->setProperty('estracto', $estracto);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('cargo_desempeno', $cargo_desempeno);
        $dao->setProperty('persona_visita', $persona_visita);
        $dao->setProperty('parantesco_visita', $parantesco_visita);

        $daoSolicitud = new SolSolicitud($id_solicitud);
        $daoSolicitud->setDocCandidato($numero_doc);
        $daoSolicitud->update();

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_salarioVM(
        $id_candidato,
        $salario_anterior

    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('salario_anterior', $salario_anterior);


        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_candidato_ec_con_cifin(
        $id_candidato,
        $id_ciudad_nac,
        $id_ciudad_act,
        $tipo_id,
        $numero_doc,
        $nombre,
        $apellido,
        $fch_nacimiento,
        $edad,
        $libreta,
        $estado_civil,
        $telefono,
        $email,
        $salario_dev,
        //$salario_actual,
        $direccion,
        $barrio,
        $estracto,
        $nivel_escolar,
        $cargo_desempeno,
        $referencia_personal,
        $id_solicitud

    ) {
        if (!isset($id_candidato) || $id_candidato == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolCandidato($id_candidato);
        $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('tipo_id', $tipo_id);
        $dao->setProperty('numero_doc', $numero_doc);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('fch_nacimiento', $fch_nacimiento);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('libreta', $libreta);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('email', $email);
        $dao->setProperty('salario_dev', $salario_dev);
        //$dao->setProperty('salario_actual', $salario_actual);
        $dao->setProperty('direccion', $direccion);
        $dao->setProperty('barrio', $barrio);
        $dao->setProperty('estracto', $estracto);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('cargo_desempeno', $cargo_desempeno);
        $dao->setProperty('referencia_personal', $referencia_personal);

        $daoSolicitud = new SolSolicitud($id_solicitud);
        $daoSolicitud->setDocCandidato($numero_doc);
        $daoSolicitud->update();

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_candidato_pol_pre($id_candidato) {

        //print_r($_POST);   
        $tamano_foto = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_foto = $_FILES['archivo']['name'];

        //print_r($nombre_foto);
        
       
        $id_ciudad_nac = $_POST['id_ciudad_nac'];
        $id_ciudad_act = $_POST['id_ciudad_act'];
        $tipo_id = $_POST['tipo_id'];
        $numero_doc = $_POST['numero_doc'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fch_nacimiento = $_POST['fch_nacimiento'];
        $edad = $_POST['edad'];
        $estado_civil = $_POST['estado_civil'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email1'];
        $email1 = $_POST['email2'];
        $direccion = $_POST['direccion'];
        $barrio = $_POST['barrio'];
        $estracto = $_POST['estracto'];
        $nivel_escolar = $_POST['nivel_escolar'];
        $cargo_desempeno = $_POST['cargo_desempeno'];
        $alias = $_POST['alias'];
        $id_solicitud = $_POST['id_solicitud'];
        $id_servicio = $_POST['id_servicio'];
        $nomFoto = $_POST['nomFoto'];
        $directorio = NULL;
        //print_r($id_solicitud);

        if (!isset($id_candidato) || $id_candidato == "")
        return Result::error(__FUNCTION__, "id es requerido");

        //if(isset($nombre_foto)){
            $dao = new SolCandidato($id_candidato);


            //print_r($nom_empre);
            if (($tamano_foto != 0) && ($nomFoto != $nombre_foto)) {

                $miObjetoIdSolicitud = new CtrSolCandidato();
                $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
        
                //Se saca el valor que viene del array que es el nombre de la empresa
                $nom_empre = $nomEmpresa['razon_social'];
                
                $obj_candidato_pol_pre = new CtrSolCandidato();
                $result =  $obj_candidato_pol_pre->uploadFile_pol_pre($nom_empre, $id_solicitud, $id_servicio);
                $directorio = $result;

                $extension_archivo_origen = strrchr($nombre_foto, ".");
                $nombre_encr = md5(date("dmYhisA")) . $extension_archivo_origen;

                $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
                $dao->setProperty('id_ciudad_act', $id_ciudad_act);
                $dao->setProperty('tipo_id', $tipo_id);
                $dao->setProperty('numero_doc', $numero_doc);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('apellido', $apellido);
                $dao->setProperty('fch_nacimiento', $fch_nacimiento);
                $dao->setProperty('edad', $edad);
                $dao->setProperty('estado_civil', $estado_civil);
                $dao->setProperty('telefono', $telefono);
                $dao->setProperty('email', $email);
                $dao->setProperty('email1', $email1);
                $dao->setProperty('direccion', $direccion);
                $dao->setProperty('barrio', $barrio);
                $dao->setProperty('estracto', $estracto);
                $dao->setProperty('nivel_escolar', $nivel_escolar);
                $dao->setProperty('cargo_desempeno', $cargo_desempeno);
                $dao->setProperty('alias', $alias);
                $dao->setProperty("nombre_foto", $nombre_foto);
                $dao->setProperty("nombre_encr", $nombre_encr);
                $dao->setProperty("directorio", $directorio);
                $dao->setProperty("tamano_foto", $tamano_foto);
                $dao->setProperty("ext", $ext);
    

            }else{ 
                
                $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
                $dao->setProperty('id_ciudad_act', $id_ciudad_act);
                $dao->setProperty('tipo_id', $tipo_id);
                $dao->setProperty('numero_doc', $numero_doc);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('apellido', $apellido);
                $dao->setProperty('fch_nacimiento', $fch_nacimiento);
                $dao->setProperty('edad', $edad);
                $dao->setProperty('estado_civil', $estado_civil);
                $dao->setProperty('telefono', $telefono);
                $dao->setProperty('email', $email);
                $dao->setProperty('email1', $email1);
                $dao->setProperty('direccion', $direccion);
                $dao->setProperty('barrio', $barrio);
                $dao->setProperty('estracto', $estracto);
                $dao->setProperty('nivel_escolar', $nivel_escolar);
                $dao->setProperty('cargo_desempeno', $cargo_desempeno);
                $dao->setProperty('alias', $alias);
                

            }
            $daoSolicitud = new SolSolicitud($id_solicitud);
            $daoSolicitud->setDocCandidato($numero_doc);
            $daoSolicitud->update();

            $result1 =  $dao->update();
        
        if ($result1['success']) {
            return Result::success($result1);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }  
    }

    public static function update_candidato_pol_rutina($id_candidato) {

        //print_r($_POST);   
        $tamano_foto = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_foto = $_FILES['archivo']['name'];

        //print_r($nombre_foto);
        
       
        $id_ciudad_nac = $_POST['id_ciudad_nac'];
        $id_ciudad_act = $_POST['id_ciudad_act'];
        $tipo_id = $_POST['tipo_id'];
        $numero_doc = $_POST['numero_doc'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fch_nacimiento = $_POST['fch_nacimiento'];
        $edad = $_POST['edad'];
        $estado_civil = $_POST['estado_civil'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email1'];
        $email1 = $_POST['email2'];
        $direccion = $_POST['direccion'];
        $barrio = $_POST['barrio'];
        $estracto = $_POST['estracto'];
        $nivel_escolar = $_POST['nivel_escolar'];
        $cargo_desempeno = $_POST['cargo_desempeno'];
        $alias = $_POST['alias'];
        $id_solicitud = $_POST['id_solicitud'];
        $id_servicio = $_POST['id_servicio'];
        $nomFoto = $_POST['nomFoto'];
        $directorio = NULL;
        //print_r($id_solicitud);

        if (!isset($id_candidato) || $id_candidato == "")
        return Result::error(__FUNCTION__, "id es requerido");

        //if(isset($nombre_foto)){
            $dao = new SolCandidato($id_candidato);


            //print_r($nom_empre);
            if (($tamano_foto != 0) && ($nomFoto != $nombre_foto)) {

                $miObjetoIdSolicitud = new CtrSolCandidato();
                $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
        
                //Se saca el valor que viene del array que es el nombre de la empresa
                $nom_empre = $nomEmpresa['razon_social'];
                
                $obj_candidato_pol_pre = new CtrSolCandidato();
                $result =  $obj_candidato_pol_pre->uploadFile_pol_rutina($nom_empre, $id_solicitud, $id_servicio);
                $directorio = $result;

                $extension_archivo_origen = strrchr($nombre_foto, ".");
                $nombre_encr = md5(date("dmYhisA")) . $extension_archivo_origen;

                $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
                $dao->setProperty('id_ciudad_act', $id_ciudad_act);
                $dao->setProperty('tipo_id', $tipo_id);
                $dao->setProperty('numero_doc', $numero_doc);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('apellido', $apellido);
                $dao->setProperty('fch_nacimiento', $fch_nacimiento);
                $dao->setProperty('edad', $edad);
                $dao->setProperty('estado_civil', $estado_civil);
                $dao->setProperty('telefono', $telefono);
                $dao->setProperty('email', $email);
                $dao->setProperty('email1', $email1);
                $dao->setProperty('direccion', $direccion);
                $dao->setProperty('barrio', $barrio);
                $dao->setProperty('estracto', $estracto);
                $dao->setProperty('nivel_escolar', $nivel_escolar);
                $dao->setProperty('cargo_desempeno', $cargo_desempeno);
                $dao->setProperty('alias', $alias);
                $dao->setProperty("nombre_foto", $nombre_foto);
                $dao->setProperty("nombre_encr", $nombre_encr);
                $dao->setProperty("directorio", $directorio);
                $dao->setProperty("tamano_foto", $tamano_foto);
                $dao->setProperty("ext", $ext);
    

            }else{ 
                
                $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
                $dao->setProperty('id_ciudad_act', $id_ciudad_act);
                $dao->setProperty('tipo_id', $tipo_id);
                $dao->setProperty('numero_doc', $numero_doc);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('apellido', $apellido);
                $dao->setProperty('fch_nacimiento', $fch_nacimiento);
                $dao->setProperty('edad', $edad);
                $dao->setProperty('estado_civil', $estado_civil);
                $dao->setProperty('telefono', $telefono);
                $dao->setProperty('email', $email);
                $dao->setProperty('email1', $email1);
                $dao->setProperty('direccion', $direccion);
                $dao->setProperty('barrio', $barrio);
                $dao->setProperty('estracto', $estracto);
                $dao->setProperty('nivel_escolar', $nivel_escolar);
                $dao->setProperty('cargo_desempeno', $cargo_desempeno);
                $dao->setProperty('alias', $alias);
                

            }
            $daoSolicitud = new SolSolicitud($id_solicitud);
            $daoSolicitud->setDocCandidato($numero_doc);
            $daoSolicitud->update();

            $result1 =  $dao->update();
        
        if ($result1['success']) {
            return Result::success($result1);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }  
    }

    public static function update_candidato_pol_especifico($id_candidato) {

        //print_r($_POST);   
        $tamano_foto = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_foto = $_FILES['archivo']['name'];

        //print_r($nombre_foto);
        
       
        $id_ciudad_nac = $_POST['id_ciudad_nac'];
        $id_ciudad_act = $_POST['id_ciudad_act'];
        $tipo_id = $_POST['tipo_id'];
        $numero_doc = $_POST['numero_doc'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fch_nacimiento = $_POST['fch_nacimiento'];
        $edad = $_POST['edad'];
        $estado_civil = $_POST['estado_civil'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email1'];
        $email1 = $_POST['email2'];
        $direccion = $_POST['direccion'];
        $barrio = $_POST['barrio'];
        $estracto = $_POST['estracto'];
        $nivel_escolar = $_POST['nivel_escolar'];
        $cargo_desempeno = $_POST['cargo_desempeno'];
        $alias = $_POST['alias'];
        $id_solicitud = $_POST['id_solicitud'];
        $id_servicio = $_POST['id_servicio'];
        $nomFoto = $_POST['nomFoto'];
        $directorio = NULL;
        //print_r($id_solicitud);

        if (!isset($id_candidato) || $id_candidato == "")
        return Result::error(__FUNCTION__, "id es requerido");

        //if(isset($nombre_foto)){
            $dao = new SolCandidato($id_candidato);


            //print_r($nom_empre);
            if (($tamano_foto != 0) && ($nomFoto != $nombre_foto)) {

                $miObjetoIdSolicitud = new CtrSolCandidato();
                $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
        
                //Se saca el valor que viene del array que es el nombre de la empresa
                $nom_empre = $nomEmpresa['razon_social'];
                
                $obj_candidato_pol_pre = new CtrSolCandidato();
                $result =  $obj_candidato_pol_pre->uploadFile_pol_especifico($nom_empre, $id_solicitud, $id_servicio);
                $directorio = $result;

                $extension_archivo_origen = strrchr($nombre_foto, ".");
                $nombre_encr = md5(date("dmYhisA")) . $extension_archivo_origen;

                $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
                $dao->setProperty('id_ciudad_act', $id_ciudad_act);
                $dao->setProperty('tipo_id', $tipo_id);
                $dao->setProperty('numero_doc', $numero_doc);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('apellido', $apellido);
                $dao->setProperty('fch_nacimiento', $fch_nacimiento);
                $dao->setProperty('edad', $edad);
                $dao->setProperty('estado_civil', $estado_civil);
                $dao->setProperty('telefono', $telefono);
                $dao->setProperty('email', $email);
                $dao->setProperty('email1', $email1);
                $dao->setProperty('direccion', $direccion);
                $dao->setProperty('barrio', $barrio);
                $dao->setProperty('estracto', $estracto);
                $dao->setProperty('nivel_escolar', $nivel_escolar);
                $dao->setProperty('cargo_desempeno', $cargo_desempeno);
                $dao->setProperty('alias', $alias);
                $dao->setProperty("nombre_foto", $nombre_foto);
                $dao->setProperty("nombre_encr", $nombre_encr);
                $dao->setProperty("directorio", $directorio);
                $dao->setProperty("tamano_foto", $tamano_foto);
                $dao->setProperty("ext", $ext);
    

            }else{ 
                
                $dao->setProperty('id_ciudad_nac', $id_ciudad_nac);
                $dao->setProperty('id_ciudad_act', $id_ciudad_act);
                $dao->setProperty('tipo_id', $tipo_id);
                $dao->setProperty('numero_doc', $numero_doc);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('apellido', $apellido);
                $dao->setProperty('fch_nacimiento', $fch_nacimiento);
                $dao->setProperty('edad', $edad);
                $dao->setProperty('estado_civil', $estado_civil);
                $dao->setProperty('telefono', $telefono);
                $dao->setProperty('email', $email);
                $dao->setProperty('email1', $email1);
                $dao->setProperty('direccion', $direccion);
                $dao->setProperty('barrio', $barrio);
                $dao->setProperty('estracto', $estracto);
                $dao->setProperty('nivel_escolar', $nivel_escolar);
                $dao->setProperty('cargo_desempeno', $cargo_desempeno);
                $dao->setProperty('alias', $alias);
                

            }
            $daoSolicitud = new SolSolicitud($id_solicitud);
            $daoSolicitud->setProperty('doc_candidato', $numero_doc);
            $resultSolicitud =  $daoSolicitud->update();

            $result1 =  $dao->update();
        
        if ($result1['success']) {
            return Result::success($result1);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }  
    }

// Visita de asociado de negocio

public static function update_candidato_visita_asociado($id_candidato) {

    //print_r($_POST);
    //Datos del archivo   
    $tamano_foto = $_FILES['archivo']['size'];
    $ext = $_FILES['archivo']['type'];
    $nombre_foto = $_FILES['archivo']['name'];

    //Datos de visita asociado
    $id_ciudad_act = $_POST['id_ciudad_act'];
    $tipo_id = $_POST['tipo_id'];
    $numero_doc = $_POST['numero_doc'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email1'];
    $direccion = $_POST['direccion'];
    $cargo_desempeno = $_POST['cargo_desempeno'];
    $id_solicitud = $_POST['id_solicitud'];
    $id_servicio = $_POST['id_servicio'];
    $nomFoto = $_POST['nomFoto'];
    $directorio = NULL;
    $fecha_visita = $_POST['fecha_visita'];
    $razon_social = $_POST['razon_social'];
    $servicio_suministrado = $_POST['servicio_suministrado'];
    $tmp_operacion = $_POST['tmp_operacion'];
    $horario_operacion = $_POST['horario_operacion']; 

    //Datos de visita asociado nuevo
    $nit = $_POST['nit'];
    $nombre_representante = $_POST['nombre_representante'];
    $apellido_representante = $_POST['apellido_representante']; 
    $act_economica = $_POST['act_economica']; 
    $capital_suscrito = $_POST['capital_suscrito']; 
    $paises_exterior = $_POST['paises_exterior']; 
    $fch_constituida = $_POST['fch_constituida']; 
    $vol_operaciones = $_POST['vol_operaciones']; 
    $instalaciones = $_POST['instalaciones'];    

    if (!isset($id_candidato) || $id_candidato == "")
    return Result::error(__FUNCTION__, "id es requerido");

    //if(isset($nombre_foto)){
        $dao = new SolCandidato($id_candidato);


        //print_r($nom_empre);
        if (($tamano_foto != 0) && ($nomFoto != $nombre_foto)) {

            $miObjetoIdSolicitud = new CtrSolCandidato();
            $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
    
            //Se saca el valor que viene del array que es el nombre de la empresa
            $nom_empre = $nomEmpresa['razon_social'];
            
            $obj_candidato_pol_pre = new CtrSolCandidato();
            $result =  $obj_candidato_pol_pre->uploadFile_visita_asociado($nom_empre, $id_solicitud, $id_servicio);
            $directorio = $result;

            $extension_archivo_origen = strrchr($nombre_foto, ".");
            $nombre_encr = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao->setProperty('id_ciudad_act', $id_ciudad_act);
            $dao->setProperty('tipo_id', $tipo_id);
            $dao->setProperty('numero_doc', $numero_doc);
            $dao->setProperty('nombre', $nombre);
            $dao->setProperty('apellido', $apellido);
            $dao->setProperty('telefono', $telefono);
            $dao->setProperty('email', $email);
            $dao->setProperty('direccion', $direccion);
            $dao->setProperty('cargo_desempeno', $cargo_desempeno);
            $dao->setProperty('fecha_visita', $fecha_visita);
            $dao->setProperty('razon_social', $razon_social);
            $dao->setProperty('servicio_suministrado', $servicio_suministrado);
            $dao->setProperty('tmp_operacion', $tmp_operacion);
            $dao->setProperty('horario_operacion', $horario_operacion);
            $dao->setProperty('nit', $nit);
            $dao->setProperty('nombre_representante', $nombre_representante);
            $dao->setProperty('apellido_representante', $apellido_representante);
            $dao->setProperty('act_economica', $act_economica);
            $dao->setProperty('capital_suscrito', $capital_suscrito);
            $dao->setProperty('paises_exterior', $paises_exterior);
            $dao->setProperty('fch_constituida', $fch_constituida);
            $dao->setProperty('vol_operaciones', $vol_operaciones);
            $dao->setProperty('instalaciones', $instalaciones);
            $dao->setProperty("nombre_foto", $nombre_foto);
            $dao->setProperty("nombre_encr", $nombre_encr);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano_foto", $tamano_foto);
            $dao->setProperty("ext", $ext);

        }else{ 
            
            $dao->setProperty('id_ciudad_act', $id_ciudad_act);
            $dao->setProperty('tipo_id', $tipo_id);
            $dao->setProperty('numero_doc', $numero_doc);
            $dao->setProperty('nombre', $nombre);
            $dao->setProperty('apellido', $apellido);
            $dao->setProperty('telefono', $telefono);
            $dao->setProperty('email', $email);
            $dao->setProperty('direccion', $direccion);
            $dao->setProperty('cargo_desempeno', $cargo_desempeno);
            $dao->setProperty('fecha_visita', $fecha_visita);
            $dao->setProperty('razon_social', $razon_social);
            $dao->setProperty('servicio_suministrado', $servicio_suministrado);
            $dao->setProperty('tmp_operacion', $tmp_operacion);
            $dao->setProperty('horario_operacion', $horario_operacion);
            $dao->setProperty('nit', $nit);
            $dao->setProperty('nombre_representante', $nombre_representante);
            $dao->setProperty('apellido_representante', $apellido_representante);
            $dao->setProperty('act_economica', $act_economica);
            $dao->setProperty('capital_suscrito', $capital_suscrito);
            $dao->setProperty('paises_exterior', $paises_exterior);
            $dao->setProperty('fch_constituida', $fch_constituida);
            $dao->setProperty('vol_operaciones', $vol_operaciones);
            $dao->setProperty('instalaciones', $instalaciones);           

        }
        $daoSolicitud = new SolSolicitud($id_solicitud);
        $daoSolicitud->setDocCandidato($numero_doc);
        $daoSolicitud->update();

        $result1 =  $dao->update();
    
    if ($result1['success']) {
        return Result::success($result1);
    } else {
        return Result::error(__CLASS__ . "." . __FUNCTION__, $result1);
    }  
}

// fin de visita de asociado de negocio


    //Trae el nombre de la empresa y retorna el nombre de la empresa
    public static function trae_Id_Empresa($id_solicitud)
    {
        //print_r($id_solicitud);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id_solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select te.razon_social 
                    from sol_solicitud ss, trc_empresa te
                    where  ss.id_empresa = te.id_empresa
                    and ss.id_solicitud = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud),
            false,
            "N"
        );

        return $result;
    }

    public static function uploadFile_visita_asociado($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/vsa_$id_servicio";

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

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
            return $nuevodirectorio;
        } else {
            return null;
        }
    }

    //subir archivo visita poligrafia
    public static function uploadFile_pol_pre($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/pol_pre_$id_servicio";

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

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
            return $nuevodirectorio;
        } else {
            return null;
        }
    }

    //subir archivo visita poligrafia
    public static function uploadFile_pol_rutina($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/pol_rutina_$id_servicio";

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

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
            return $nuevodirectorio;
        } else {
            return null;
        }
    }

    //subir archivo visita poligrafia
    public static function uploadFile_pol_especifico($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/pol_especifico_$id_servicio";

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

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
            return $nuevodirectorio;
        } else {
            return null;
        }
    }



    public static function cambiarEstado($id_servicio, $estado)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $resultCount = QuerySQL::select(
            <<<SQL
                    select count(1) cant 
                        from srv_combo_servicios scs , srv_servicios ss 
                        where scs.id_servicio = ss.id_servicio 
                        and scs.activo = 1
                        and ss.id_servicio  = :id_servicio;
                SQL,
            array("id_servicio" => $id_servicio),
            true,
            "N"
        );

        $arrayResult = json_decode(json_encode($resultCount), true);
        $cantidad = $arrayResult[0]['cant'];

        if ($cantidad > 0) {
            return Result::error(__FUNCTION__, "No se puede inactivar el Servicio, tiene Combos Servicios activos");
        } else {

            $result = QuerySQL::update(
                <<<SQL
                update srv_servicios 
                 set estado = :estado 
                where  id_servicio = :id_servicio
            SQL,
                array(
                    "id_servicio" => $id_servicio,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado producto");
        }
    }

    //consultar el registroa a editar
    public static function SolAutoById($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sa.id_auto, 
                        sa.id_solicitud,
                        sa.usuario,
                        sa.contactar_empleador,
                        sa.instituciones,
                        sa.grabacion,
                        sa.registro_foto,
                        sa.acepto,
                        sa.fch_candidato_auto,
                        sa.nombre_firma,
                        sa.directorio,
                        sa.nombre_encr
                    from sol_auto sa
                    where sa.id_solicitud = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar autorizacion por solicitud evaluado");
    }
    //consultar el registroa a editar
    public static function SolAutoServicioById($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                CASE 
                    WHEN EXISTS (
                        SELECT 1
                        FROM srv_combo_servicios scs
                        JOIN srv_servicios ss ON scs.id_servicio = ss.id_servicio
                        JOIN sol_solicitud so ON so.id_combo = scs.id_combo
                        WHERE scs.activo = 1
                        AND so.id_solicitud = :id_solicitud
                        AND ss.id_servicio IN (3, 6, 7, 11)
                    ) THEN 'muestra_auto'
                    ELSE 'no_aplica'
                END AS resultado,
                sa.id_auto, 
                sa.id_solicitud,
                sa.usuario,
                sa.contactar_empleador,
                sa.instituciones,
                sa.grabacion,
                sa.registro_foto,
                sa.acepto,
                sa.fch_candidato_auto,
                sa.nombre_firma,
                sa.directorio,
                sa.nombre_encr
            FROM sol_solicitud so
            LEFT JOIN sol_auto sa 
                ON sa.id_solicitud = so.id_solicitud
            WHERE so.id_solicitud = :id_solicitud;
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar autorizacion por solicitud evaluado");
    }

    //delete hoja de vida
    public static function delete($id_adjunto)
    {
        //borrar el archivo del directorio
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result1 =  $miObjetoArchivo->findByIdDoc($id_adjunto);
        $directorio = $result1['directorio'];
        $nombre_encr = $result1['nombre_encr'];
        $ruta = "$directorio/$nombre_encr";

        if (unlink($ruta)) {

        }
        if (!isset($id_adjunto) || $id_adjunto == "")
        return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolAdjuntos($id_adjunto);
        $result =  $dao->delete();

        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    
}
