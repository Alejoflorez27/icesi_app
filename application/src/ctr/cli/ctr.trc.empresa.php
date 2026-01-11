<?php

class CtrTrcEmpresa
{

    public static function crear()
    {
        
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_arc = $_FILES['archivo']['name'];
        $directorio = NULL;
        $extension_archivo_origen = NULL;
        $nuevo_nombre_archivo = NULL;

        $razon_social = $_POST['razon_social'];
        $rep_legal = $_POST['rep_legal'];
        $tipo_id = $_POST['tipo_id'];
        $numero_doc = $_POST['numero_doc'];
        $id_ciudad = $_POST['id_ciudad'];
        $email_emp = $_POST['email_emp'];
        $celular = $_POST['celular'];
        $direccion = $_POST['direccion'];
        $email_emp = $_POST['email_emp'];
        $flag_subemp = $_POST['flag_subemp'];
        $flag_grup = $_POST['flag_grup'];
        $id_empresa_padre = NULL;
        

        if(isset($nombre_arc)){ 
            $objEmpresa = new CtrTrcEmpresa();
            $result =  $objEmpresa->uploadFile($razon_social);
            $directorio = $result;

            $extension_archivo_origen = strrchr($nombre_arc, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;
        }    
       // print_r($nombre);
        //print_r($razon_social);
        //print_r($_FILES);

        
        if (!isset($razon_social) || $razon_social == "")
            return BaseResponse::error(__FUNCTION__, "nombre de la empresa es requerido"); 

        if (!isset($rep_legal) || $rep_legal == "")
            return BaseResponse::error(__FUNCTION__, "nombre de representante es requerido");

        if (!isset($tipo_id) || $tipo_id == "")
            return BaseResponse::error(__FUNCTION__, "tipo identificacion es requerido");

        if (!isset($numero_doc) || $numero_doc == "")
            return BaseResponse::error(__FUNCTION__, "Numero identificacion es requerido");

        if (!isset($id_ciudad) || $id_ciudad == "")
            return BaseResponse::error(__FUNCTION__, "Ciudad es requerido");

        if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email_emp) == 0)
            return BaseResponse::error(__FUNCTION__, "email no es valido");

           

        $obj_trcEmpresa = new TrcEmpresa();
        $obj_trcEmpresa->setProperty('razon_social', $razon_social);
        $obj_trcEmpresa->setProperty('rep_legal', $rep_legal);
        $obj_trcEmpresa->setProperty('tipo_id', $tipo_id);
        $obj_trcEmpresa->setProperty('numero_doc', $numero_doc);
        $obj_trcEmpresa->setProperty('id_ciudad', $id_ciudad);
        $obj_trcEmpresa->setProperty('email_emp', $email_emp);
        $obj_trcEmpresa->setProperty('flag_subemp', $flag_subemp);
        $obj_trcEmpresa->setProperty('flag_grup', $flag_grup);
        $obj_trcEmpresa->setProperty('id_empresa_padre', $id_empresa_padre); 
        $obj_trcEmpresa->setProperty("nombre_logo", $nombre_arc);
        $obj_trcEmpresa->setProperty("nombre_encr", $nuevo_nombre_archivo);
        $obj_trcEmpresa->setProperty("directorio", $directorio);
        $obj_trcEmpresa->setProperty("tamano", $tamano);
        $obj_trcEmpresa->setProperty("ext", $extension_archivo_origen);
        $obj_trcEmpresa->setProperty("celular", $celular);
        $obj_trcEmpresa->setProperty("direccion", $direccion);

        $result = $obj_trcEmpresa->insert();
        if ($result['success']) {
            $correo = Result::getData(self::enviarCorreo($email_emp,'CREA'));
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        } 
    }


    //crear SUBempresa
    public static function crearSubEmp()
    {
        
        $tamano = $_FILES['archivoSub']['size'];
        $ext = $_FILES['archivoSub']['type'];
        $nombre_arc = $_FILES['archivoSub']['name'];
        $directorio = NULL;
        $extension_archivo_origen = NULL;
        $nuevo_nombre_archivo = NULL;

        $razon_social = $_POST['sube_razon_social'];
        $rep_legal = $_POST['sube_rep_legal'];
        $tipo_id = $_POST['sube_tipo_id'];
        $numero_doc = $_POST['sube_numero_doc'];
        $id_ciudad = $_POST['sube_id_ciudad'];
        $email_emp = $_POST['sube_email_emp'];
        $celular = $_POST['sube_celular'];
        $direccion = $_POST['sube_direccion'];
        $email_emp = $_POST['sube_email_emp'];
        $flag_subemp = 0;
        $flag_grup = 0;
        $id_empresa_padre = $_POST['id_empresaSubemp'];;
        

        if(isset($nombre_arc)){ 
            $objEmpresa = new CtrTrcEmpresa();
            $result =  $objEmpresa->uploadFileSubEmpresa($razon_social);
            $directorio = $result;

            $extension_archivo_origen = strrchr($nombre_arc, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;
        }    
       // print_r($nombre);
        //print_r($razon_social);
        //print_r($_FILES);

        
        if (!isset($razon_social) || $razon_social == "")
            return BaseResponse::error(__FUNCTION__, "nombre de la empresa es requerido"); 

        if (!isset($rep_legal) || $rep_legal == "")
            return BaseResponse::error(__FUNCTION__, "nombre de representante es requerido");

        if (!isset($tipo_id) || $tipo_id == "")
            return BaseResponse::error(__FUNCTION__, "tipo identificacion es requerido");

        if (!isset($numero_doc) || $numero_doc == "")
            return BaseResponse::error(__FUNCTION__, "Numero identificacion es requerido");

        if (!isset($id_ciudad) || $id_ciudad == "")
            return BaseResponse::error(__FUNCTION__, "Ciudad es requerido");

        if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email_emp) == 0)
            return BaseResponse::error(__FUNCTION__, "email no es valido");

           

        $obj_trcEmpresa = new TrcEmpresa();
        $obj_trcEmpresa->setProperty('razon_social', $razon_social);
        $obj_trcEmpresa->setProperty('rep_legal', $rep_legal);
        $obj_trcEmpresa->setProperty('tipo_id', $tipo_id);
        $obj_trcEmpresa->setProperty('numero_doc', $numero_doc);
        $obj_trcEmpresa->setProperty('id_ciudad', $id_ciudad);
        $obj_trcEmpresa->setProperty('email_emp', $email_emp);
        $obj_trcEmpresa->setProperty('flag_subemp', $flag_subemp);
        $obj_trcEmpresa->setProperty('flag_grup', $flag_grup);
        $obj_trcEmpresa->setProperty('id_empresa_padre', $id_empresa_padre); 
        $obj_trcEmpresa->setProperty("nombre_logo", $nombre_arc);
        $obj_trcEmpresa->setProperty("nombre_encr", $nuevo_nombre_archivo);
        $obj_trcEmpresa->setProperty("directorio", $directorio);
        $obj_trcEmpresa->setProperty("tamano", $tamano);
        $obj_trcEmpresa->setProperty("ext", $extension_archivo_origen);
        $obj_trcEmpresa->setProperty("celular", $celular);
        $obj_trcEmpresa->setProperty("direccion", $direccion);

        $result = $obj_trcEmpresa->insert();
        if ($result['success']) {
            $correo = Result::getData(self::enviarCorreo($email_emp,'CREA'));
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        } 
    }


    public static function enviarCorreo($email, $tipo)
    {

        if ($tipo == 'CREA') {

            $para = $email;
            $instructivo = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/Instructivo_uso_de_la_plaforma_cliente.pdf';
            $politicas = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . 'upload/image/sitio/PTPE-003_V2_POLITICA_DE_USO_DEL_MANEJO_DE_TIC.pdf';
            $asunto = 'BIENVENIDO A PLATAFORMA VERUM';
            /*$mensaje = "Apreciado " . $nombre . " se acabó de realizar la creación de su usuario para el ingreso a la aplicación Prohumanos, debe hacerlo por el siguiente link: <b> ". $_SERVER["HTTP_HOST"]  . " </b> 
                         para el ingreso a la aplicación debe hacerlo con el siguiente usuario <b>". $usuario . "</b>  y la contraseña que le fue asignada por el administrador";*/
            $mensaje = "Respetado Cliente
                        <br><br><strong>PROHUMANOS ALIADOS ESTRATÉGICOS SAS, le da la bienvenida a nuestra plataforma VERUM; nuestro equipo de trabajo estará atento a responder a sus requerimientos de manera oportuna; esperamos poder generar una relación comercial sólida, convirtiéndonos en una aliado estratégico para su organización.
                        </strong><br><br>Le notificamos que su compañía ya se encuentra registrada como cliente en nuestro aplicativo PROHUMANOS, medio por el cual podrá realizar la solicitud de sus servicios y descargue de los informes correspondiente. 
                        <br><br>Adicionalmente informamos que, con el documento de solicitud de creación de usuarios, enviado con anterioridad, se realizara la creación de dichos usuarios a quienes les llegará una notificación al correo electrónico registrado, donde les notificara usuario y contraseña provisional. 
                        <br><br>A continuación, encontrara el instructivo de uso del aplicativo VERUM.
                        <br><br><a href=". $instructivo." target=".'_blank'.">Descargar instructivo</a>
                        <br><br>Por temas de seguridad de la información se solicita que sean reportadas las inactivaciones de credenciales de funcionarios que hayan tenido acceso a la plataforma y que ya no se encuentren vinculados en la compañía, para evitar accesos no autorizados. 
                        <br><br>Nota: Si durante el periodo de 6 meses, usted no realiza solicitudes los usuarios que se encuentre bajo el nombre de la razón social, serán inactivados, y cuando requiera realizar una nueva solicitud pasado este periodo, por favor realizar la solicitud de activación.
                        <br><br>Nuestros canales de atención son: 
                        <br><br>Comercial y activación de usuarios: en la línea telefónica 3225104825 o al correo electrónico consultor@prohumanos.com 
                        <br><br>Solicitud de servicios: en las líneas telefónicas 3112775882 - 3144645216 - 3102986756 o al correo electrónico confiabilidad@prohumanos.com
                        "."<br><br>A continuación, encontrara la politica de uso del manejo de TIC de uso del aplicativo.<br> 
                        <a href=". $politicas." target=".'_blank'.">Descargar politica</a>";
            
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
            return array("success" => false, "action" => "Envío a empresa", "code" => $e->getMessage());
        }

        try {
            $mail->send();
        } catch (Exception $e) {
            return array("success" => false, "action" => "Envío empresa", "code" => $mail->ErrorInfo);
        }
    }

    public static function findAll($estado = null)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select id_empresa, te.id_ciudad, gc.nombre nom_ciudad, tipo_id, numero_doc, razon_social, rep_legal, email_emp, estado, id_empresa_padre, flag_subemp, flag_grup, te.usr_create, te.fch_create
                from trc_empresa te , conf_ciudad gc 
                WHERE te.id_ciudad = gc.id_ciudad
                 and (te.estado = :estado or :estado = -1)  
                 and  id_empresa_padre is null
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa todos");
    }

    public static function empresaPadreLista($estado = null)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select id_empresa, te.id_ciudad, gc.nombre nom_ciudad, tipo_id, numero_doc, razon_social, rep_legal, email_emp, estado, id_empresa_padre, flag_subemp, flag_grup, te.usr_create, te.fch_create
                from trc_empresa te , conf_ciudad gc 
                WHERE te.id_ciudad = gc.id_ciudad
                 and te.id_empresa_padre is null
                 and (te.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa todos");
    }

    public static function empresaPadreListaBy($estado = null, $id_empresa)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select id_empresa, te.id_ciudad, gc.nombre nom_ciudad, tipo_id, numero_doc, razon_social, rep_legal, email_emp, estado, id_empresa_padre, flag_subemp, flag_grup, te.usr_create, te.fch_create
                from trc_empresa te , conf_ciudad gc 
                WHERE te.id_ciudad = gc.id_ciudad
                 and te.id_empresa_padre is null
                 and te.id_empresa = :id_empresa
                 and (te.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado,"id_empresa" => $id_empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa todos");
    }

    public static function empresasPadre()
    {        
        $result = QuerySQL::select(
            <<<SQL
                select te.id_empresa,  te.razon_social
                from trc_empresa te 
                WHERE te.id_empresa_padre is null
                 and te.estado = 1   
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa todos");
    }

    public static function findAllEmpresaPadre($estado = null)
    {
        if (!isset($estado) || $estado == "")
            $estado = -1;

        $result = QuerySQL::select(
            <<<SQL
                select id_empresa, te.id_ciudad, gc.nombre nom_ciudad, tipo_id, numero_doc, razon_social, rep_legal, email_emp, estado, id_empresa_padre, flag_subemp, flag_grup, te.usr_create, te.fch_create
                from trc_empresa te , conf_ciudad gc 
                WHERE te.id_ciudad = gc.id_ciudad
                 and te.id_empresa_padre is null
                 and (te.estado = :estado or :estado = -1)   
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa padre");
    }

    public static function findSubEmpresas($subEempresa = null)
    {
        $usuario = CtrUsuario::getUsuarioApp();
        $resultCount = CtrUsuario::consultar($usuario);
        $perfil = $resultCount['perfil'];
        $empresa = $resultCount['id_empresa'];
        //print_r($usuario);
        //print_r($perfil);

        if ($perfil == 9 || $perfil == 8) {


            $result = QuerySQL::select(
            <<<SQL
                select ue.id_empresa, te.razon_social
                from usr_empre ue
                left join trc_empresa te on te.id_empresa = ue.id_empresa
                where ue.username = :usuario
            SQL,
            array("usuario" => $usuario),
            true,
            "N"
            );
            

        }else{
            $result = QuerySQL::select(
                <<<SQL
                    select id_empresa, te.razon_social 
                    from trc_empresa te 
                    WHERE te.id_empresa_padre = :subEempresa
                    and te.estado = 1
                SQL,
                array("subEempresa" => $subEempresa),
                true,
                "N"
            );
        }

        // Perfiles: Administrador (1) -  Coordinador( 12): Puede ver todas las solicitudes.
        // Perfiles: Cliente sin informe (8) - Cliente sin informe (9): ve sólo las solicitudes de su empresa
        // Perfil: Cliente administrador(7), puede ver las de la empresa padre y empresas hijas
        // Perfiles: Visitador (10), Poligrafista (11), Asesor (), Sólo pueden ver las solicitudes que tengan asigan servicios asignados a ellos.



        return Result::success($result, "buscar empresa");
    }

    public static function findSubEmpresasUsr($IdEmpresa = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select te.id_empresa usr_empresas,te.razon_social razon_social_sub
                from trc_empresa te 
                WHERE te.id_empresa = :IdEmpresa
                and te.estado = 1
                union ALL
                select te.id_empresa usr_empresas,te.razon_social razon_social_sub
                from trc_empresa te 
                WHERE te.id_empresa_padre = :IdEmpresa
                and te.estado = 1
            SQL,
            array("IdEmpresa" => $IdEmpresa),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findEmpresasByUsuario($username)
    {
        $result = QuerySQL::select(
            <<<SQL
                select ue.id_empresa, te.razon_social
                from usr_empre ue
                left join trc_empresa te on te.id_empresa = ue.id_empresa
                where ue.username = :username
            SQL,
            array("username" => $username),
            true,
            "N"
        );

        return Result::success($result, "buscar empresas por usuario");
    }

    public static function findSubEmpresasAll($IdEmpresa = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select te.id_empresa id_empresas2,te.razon_social razon_social2
                from trc_empresa te 
                WHERE te.id_empresa = :IdEmpresa
                and te.estado = 1
                union ALL
                select te.id_empresa usr_empresas,te.razon_social razon_social_sub
                from trc_empresa te 
                WHERE te.id_empresa_padre = :IdEmpresa
                and te.estado = 1
            SQL,
            array("IdEmpresa" => $IdEmpresa),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }


    public static function findTerceros($empresa = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select  id_tercero , nom_tercero 
                    from trc_terceros
                    where estado = 1
                    and id_empresa = :empresa
            SQL,
            array("empresa" => $empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar tercero");
    }

/*    public static function findResponsables($empresa = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select username , CONCAT(nombres, ' ', apellidos) responsable 
                    from usr_usuario uu 
                    where id_empresa = :empresa
                    and estado = 'ACT'
            SQL,
            array("empresa" => $empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }
*/
    /*****************************************************
     * Encontrar los responsables por empresa
     *******************************************/

    public static function findResponsables($empresa = null)
    {
        $perfil = CtrUsuario::getUsuarioAppProperty('perfil'); 
        $usuario = CtrUsuario::getUsuarioApp();   

        if(/*$perfil == '7' ||*/ $perfil == '8' || $perfil == '9'){
            $result = QuerySQL::select(
                <<<SQL
                    select username , CONCAT(nombres, ' ', apellidos) responsable 
                        from usr_usuario uu 
                        where username = :user
                        and estado = 'ACT'
                SQL,
                array("user" => $usuario),
                true,
                "N"
            );  
        
        } else {    
            // Primero verificamos si es subempresa
            $esSubempresa = QuerySQL::select(
                <<<SQL
                    SELECT 
                        CASE 
                            WHEN e.flag_subemp = 1 THEN 'SI'
                            WHEN e.id_empresa_padre IS NOT NULL THEN 'SI'
                            ELSE 'NO'
                        END as es_subempresa
                    FROM trc_empresa e
                    WHERE e.id_empresa = :empresa
                SQL,
                array("empresa" => $empresa),
                false,
                "N"
            );
            
            if ($esSubempresa && $esSubempresa['es_subempresa'] == 'SI') {
                // Es subempresa - usa la consulta con join a usr_empre
                $result = QuerySQL::select(
                    <<<SQL
                        select uu.username, CONCAT(uu.nombres, ' ', uu.apellidos) responsable 
                        from usr_usuario uu, usr_empre ue
                        where ue.id_empresa = :empresa
                        and uu.username = ue.username
                        and uu.estado = 'ACT'
                    SQL,
                    array("empresa" => $empresa),
                    true,
                    "N"
                );
            } else {
                // No es subempresa - usa la consulta normal
                $result = QuerySQL::select(
                    <<<SQL
                        select username, CONCAT(nombres, ' ', apellidos) responsable 
                        from usr_usuario uu 
                        where id_empresa = :empresa
                        and estado = 'ACT'
                    SQL,
                    array("empresa" => $empresa),
                    true,
                    "N"
                );
            }
        }    
        
        return BaseResponse::success($result, "buscar empresa");
    }


    public static function update_state(
        $id_empresa,
        $estado = 'ACT'
    ) {
        $dao = new TrcEmpresa($id_empresa);

        $dao->setProperty('estado', $estado);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findById($id_empresa)
    {

        $result = QuerySQL::select(
            <<<SQL
                select te.id_empresa, te.id_ciudad, te.tipo_id, te.numero_doc, te.razon_social, te.rep_legal, te.email_emp, te.estado, te.id_empresa_padre, te.flag_subemp, te.flag_grup, te.usr_create, te.
                fch_create,te.especificacion , cd.id_dpto , cd.id_pais , cd.nombre as nombre_dpto, cc.nombre as nombre_ciudad, te.celular, te.direccion, te.nombre_logo, te.directorio, te.nombre_encr
                from trc_empresa te, conf_dpto cd , conf_ciudad cc, conf_pais cp  
                where  te.id_empresa = :id_empresa
                    and (cd.id_dpto = cc.id_dpto)
                    and (te.id_ciudad = cc.id_ciudad)
                    and (cd.id_pais = cp.id_pais)
            SQL,
            array("id_empresa" => $id_empresa),
            false,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findByIdEspecificacion($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT te.especificacion
                  FROM sol_solicitud ss, trc_empresa te
                 WHERE ss.id_solicitud = :id_solicitud
                   AND ss.id_empresa = te.id_empresa
            SQL,
            array("id_solicitud" => $id_solicitud),
            false,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findByIdPadre($id_empresa)
    {

        $result = QuerySQL::select(
            <<<SQL
                select te.id_empresa, te.id_ciudad, te.tipo_id, te.numero_doc, te.razon_social, te.rep_legal, te.email_emp, te.estado, te.id_empresa_padre, te.flag_subemp, te.flag_grup, te.usr_create, te.
                fch_create, te.celular, te.direccion, te.nombre_logo, te.directorio, te.nombre_encr
                from trc_empresa te
                where  te.id_empresa = :id_empresa
            SQL,
            array("id_empresa" => $id_empresa),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findByAutoXempre($id_empresa)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT COUNT(*) AS total
                FROM auto_bash
                WHERE id_empresa = :id_empresa
                AND YEAR(fch_cliente_auto) = YEAR(CURDATE())
            SQL,
            array("id_empresa" => $id_empresa),
            false,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findAutoXempre()
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT ab.id_auto,
                ab.id_empresa,
                te.razon_social,
                ab.usuario,
                uu.nombres,
                uu.apellidos,
                ab.fch_cliente_auto,
                ab.nombre_firma,
                ab.nombre_encr,
                ab.directorio,
                ab.usr_create,
                ab.fch_create
            FROM auto_bash ab, trc_empresa te, usr_usuario uu
            WHERE ab.id_empresa = te.id_empresa
            AND ab.usuario = uu.username
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findByAutoBash($id_empresa, $id_auto)
    {

        $result = QuerySQL::select(
            <<<SQL
               SELECT ab.id_auto,
                    ab.id_empresa,
                    ab.usuario,
                    uu.nombres,
                    uu.apellidos,
                    ab.fch_cliente_auto,
                    ab.nombre_firma,
                    ab.nombre_encr,
                    ab.directorio,
                    ab.usr_create,
                    ab.fch_create
                 FROM auto_bash ab, usr_usuario uu
                WHERE ab.id_empresa = :id_empresa
                  AND ab.usuario = uu.username
                  AND ab.id_auto = :id_auto
                  AND YEAR(ab.fch_cliente_auto) = YEAR(CURDATE())
            SQL,
            array("id_empresa" => $id_empresa,"id_auto" => $id_auto),
            false,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function findByAutoBashAnos($id_empresa, $id_auto)
    {

        $result = QuerySQL::select(
            <<<SQL
               SELECT ab.id_auto,
                    ab.id_empresa,
                    ab.usuario,
                    uu.nombres,
                    uu.apellidos,
                    ab.fch_cliente_auto,
                    ab.nombre_firma,
                    ab.nombre_encr,
                    ab.directorio,
                    ab.usr_create,
                    ab.fch_create
                 FROM auto_bash ab, usr_usuario uu
                WHERE ab.id_empresa = :id_empresa
                  AND ab.usuario = uu.username
                  AND ab.id_auto = :id_auto
            SQL,
            array("id_empresa" => $id_empresa,"id_auto" => $id_auto),
            false,
            "N"
        );

        return Result::success($result, "buscar empresa");
    }

    public static function update()
    {
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre_arc = $_FILES['archivo']['name'];
        $directorio = NULL;
        $extension_archivo_origen = NULL;
        $nuevo_nombre_archivo = NULL;

        $id_empresa = $_POST['id_empresa'];
        $razon_social = $_POST['razon_social'];
        $rep_legal = $_POST['rep_legal'];
        $tipo_id = $_POST['tipo_id'];
        $numero_doc = $_POST['numero_doc'];
        //$id_ciudad = $_POST['id_ciudad'];
        $id_ciudadEdit = $_POST['id_ciudadEdit'];
        $email_emp = $_POST['email_emp'];
        $celular = $_POST['celular'];
        $direccion = $_POST['direccion'];
        $flag_subemp = $_POST['flag_subemp'];
        $flag_grup = $_POST['flag_grup'];
        $nomLogo = $_POST['nomLogo'];

       


        if (!isset($id_empresa) || $id_empresa == "")
        return Result::error(__FUNCTION__, "id es requerido");
    
        if (!isset($razon_social) || $razon_social == "")
            return BaseResponse::error(__FUNCTION__, "nombre de la empresa es requerido"); 

        if (!isset($rep_legal) || $rep_legal == "")
            return BaseResponse::error(__FUNCTION__, "nombre de representante es requerido");

        if (!isset($tipo_id) || $tipo_id == "")
            return BaseResponse::error(__FUNCTION__, "tipo identificacion es requerido");

        if (!isset($numero_doc) || $numero_doc == "")
            return BaseResponse::error(__FUNCTION__, "Numero identificacion es requerido");

        if (!isset($id_ciudadEdit) || $id_ciudadEdit == ""){    
            return BaseResponse::error(__FUNCTION__, "Ciudad es requerido");
        }
            

        if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email_emp) == 0)
            return BaseResponse::error(__FUNCTION__, "email no es valido");

        
        $dao = new TrcEmpresa($id_empresa); 

       // print_r($_POST);
       //si el archivo tiene tamaño y es diferente al ya guardado se ahce todo el proceso
       if (($tamano != 0) && ($nomLogo != $nombre_arc)){

            $objEmpresa = new CtrTrcEmpresa();
            $result =  $objEmpresa->uploadFile($razon_social);
            $directorio = $result;

            $extension_archivo_origen = strrchr($nombre_arc, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen; 

            
            $dao->setProperty('razon_social', $razon_social);
            $dao->setProperty('rep_legal', $rep_legal);
            $dao->setProperty('tipo_id', $tipo_id);
            $dao->setProperty('numero_doc', $numero_doc);
            $dao->setProperty('id_ciudad', $id_ciudadEdit);
            $dao->setProperty('email_emp', $email_emp);
            $dao->setProperty('celular', $celular);
            $dao->setProperty('direccion', $direccion);
            $dao->setProperty('flag_subemp', $flag_subemp);
            $dao->setProperty('flag_grup', $flag_grup);
            $dao->setProperty("nombre_logo", $nombre_arc);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("ext", $extension_archivo_origen);

       }else{
            
            $dao->setProperty('razon_social', $razon_social);
            $dao->setProperty('rep_legal', $rep_legal);
            $dao->setProperty('tipo_id', $tipo_id);
            $dao->setProperty('numero_doc', $numero_doc);
            $dao->setProperty('id_ciudad', $id_ciudadEdit);
            $dao->setProperty('email_emp', $email_emp);
            $dao->setProperty('celular', $celular);
            $dao->setProperty('direccion', $direccion);
            $dao->setProperty('flag_subemp', $flag_subemp);
            $dao->setProperty('flag_grup', $flag_grup);

       }
       
       
        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
    public static function especificacion(
        $id_empresa,
        $especificacion
    ) {
        $dao = new TrcEmpresa($id_empresa);

        $dao->setProperty('especificacion', $especificacion);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function cambiarEstado($id_empresa, $estado)
    {
        if (!isset($id_empresa) || $id_empresa == "") {
            return Result::error(__FUNCTION__, "id es requerido");
        } else {
            $result = QuerySQL::update(
                <<<SQL
                update trc_empresa 
                 set estado = :estado 
                where  id_empresa = :id_empresa
            SQL,
                array(
                    "id_empresa" => $id_empresa,
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado empresa");
        }
    }

    public static function cambiarEstadoUsuario($username, $estado)
    {
        if (!isset($username) || $username == "") {
            return Result::error(__FUNCTION__, "username es requerido");
        } else {
            $result = QuerySQL::update(
                <<<SQL
                update usr_usuario
                 set estado = :estado 
                where  username = :username
            SQL,
                array(
                    "username" => $username, 
                    "estado" => $estado
                ),
                false,
                "N"
            );

            return Result::success($result, "Cambiar estado usuario");
        }
    }

    public static function encriptar($valor)
    {
        return crypt($valor, constant('APP_KEY'));
    }
    
public static function crearUsuario($valida_usr_sub, $username, $idEmpresa, $email, $password, $nombres, $apellidos, $tipo_identificacion, $numero_identificacion, $perfil, $cargo, $bandera_bash, $empresas)
{
    // Verificar si el usuario pertenece a una subempresa
    $flag_subemp = CtrTrcEmpresa::findByIdPadre($valida_usr_sub);

    /**
     * CASO 1: Empresa con flag_subemp = 1
     * El usuario puede tener múltiples empresas (array $empresas)
     */
    if ($flag_subemp['data'][0]['flag_subemp'] == 1) {

        // Primero asignamos la empresa padre
        $idEmpresa = $valida_usr_sub;

        // Registrar usuario indicando empresa padre
        // NO asignamos aquí las empresas hijas (esto se hace luego)
    }
    else {
        /**
         * CASO 2: Empresa normal
         * Se fuerza siempre la empresa única del usuario
         */
        $idEmpresa = $flag_subemp['data'][0]['id_empresa'];
    }

    // ======================
    // VALIDACIONES
    // ======================
    if (!isset($nombres) || trim($nombres) == "")
        return BaseResponse::error(__FUNCTION__, "nombres es requerido");

    if (!isset($idEmpresa) || $idEmpresa == "")
        return BaseResponse::error(__FUNCTION__, "idEmpresa es requerido");

    if (!isset($apellidos) || trim($apellidos) == "")
        return BaseResponse::error(__FUNCTION__, "apellidos es requerido");

    if (!isset($tipo_identificacion) || trim($tipo_identificacion) == "")
        return BaseResponse::error(__FUNCTION__, "tipo_identificacion es requerido");

    if (!isset($numero_identificacion) || trim($numero_identificacion) == "")
        return BaseResponse::error(__FUNCTION__, "numero_identificacion es requerido");

    if (!isset($perfil) || trim($perfil) == "")
        return BaseResponse::error(__FUNCTION__, "perfil es requerido");

    if (preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $email) == 0)
        return BaseResponse::error(__FUNCTION__, "email no es valido");

    // ======================
    // Crear usuario
    // ======================
    $obj_usuario = new Usuario();
    $obj_usuario->setUsername($username);
    $obj_usuario->setProperty('id_empresa', $idEmpresa);
    $obj_usuario->setEmail($email);
    $obj_usuario->setPassword(self::encriptar($password));
    $obj_usuario->setProperty('nombres', $nombres);
    $obj_usuario->setProperty('apellidos', $apellidos);
    $obj_usuario->setProperty('tipo_identificacion', $tipo_identificacion);
    $obj_usuario->setProperty('numero_identificacion', $numero_identificacion);
    $obj_usuario->setProperty('bandera_bash', $bandera_bash);
    $obj_usuario->setPerfil($perfil);
    $obj_usuario->setCargo($cargo);
    $obj_usuario->setEstado("ACT");

    $result = $obj_usuario->insert();

    if (!$result['success']) {
        return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
    }

    // ======================
    // SI ES SUBEMPRESA, SE ASIGNAN TODAS LAS EMPRESAS
    // ======================
    if ($flag_subemp['data'][0]['flag_subemp'] == 1 && is_array($empresas)) {

        foreach ($empresas as $empresa) {

            // Puede venir como array u objeto
            $idEmp = is_array($empresa) ? $empresa['id'] : $empresa;

            // Asignar empresa al usuario
            CtrTrcEmpresa::asignarEmpresaUsuario($username, $idEmp);
        }
    }

    // Enviar correo de creación
    CtrUsuario::enviarCorreo($username, $nombres . ' ' . $apellidos, $email, 'CREA', $password);

    return BaseResponse::success($result);
}


    // Función para asignar una empresa individual al usuario
    public static function asignarEmpresaUsuario($idUsuario, $idEmpresa)
    {
        // Aquí implementa la lógica específica para tu base de datos
        // Por ejemplo, si tienes una tabla usuario_empresas:
        //print_r($idEmpresa);
        
        $usuarioEmpresa = new UsrEmpr(); // Asumiendo que tienes este modelo
        $usuarioEmpresa->setProperty('username', $idUsuario);
        $usuarioEmpresa->setProperty('id_empresa', $idEmpresa);
        
        return $usuarioEmpresa->insert();
    }




     //subir archivo
     public static function uploadFile($nom_empre)
     {
        $empresa =  CtrSolAdjuntos::limpiar_cadena($nom_empre);
         $max             = 8000718;
         $dia            = date("d");
         $mes            = date("m");
         $anno            = date("y");
         $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/";
 
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
 
        // Verificar el tamaño y el tipo del archivo
        if (($tamano > 0 && $tamano < 2000000) || $ext == 'image/jpg' || $ext == 'pdf') {
            // El archivo es pequeño o es JPEG, no es necesario comprimir
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
                return $nuevodirectorio;
            } else {
                return null; // Error al mover el archivo
            }
        } elseif ($tamano >= 2000000 && $ext == 'image/png') {
            // El archivo es grande y es PNG, comprimir
            $quality = 5; // Calidad de compresión predeterminada
            if (self::compressImage($_FILES['archivo']['tmp_name'], $uploadfile, $quality)) {
                // Renombrar el archivo comprimido con el mismo nombre que el original
                $compressed_filename = md5(date("dmYhisA")) . $encrip;
                $compressed_filepath = $uploaddir . $compressed_filename;
                rename($uploadfile, $compressed_filepath);
                return $nuevodirectorio;
            } else {
                // Si falla la compresión, eliminar el archivo comprimido
                unlink($uploadfile);
                return null;
            }
        } else {
            return null; // El archivo está vacío o no se pudo obtener su tamaño
        }
     }

     //subir archivo subempresa
     public static function uploadFileSubEmpresa($nom_empre)
     {
        $empresa =  CtrSolAdjuntos::limpiar_cadena($nom_empre);
         $max             = 8000718;
         $dia            = date("d");
         $mes            = date("m");
         $anno            = date("y");
         $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/";
 
         $tamano = $_FILES['archivoSub']['size'];
         $ext = $_FILES['archivoSub']['type'];
         $nombre = $_FILES['archivoSub']['name'];
 
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
 
        // Verificar el tamaño y el tipo del archivo
        if (($tamano > 0 && $tamano < 2000000) || $ext == 'image/jpg' || $ext == 'pdf') {
            // El archivo es pequeño o es JPEG, no es necesario comprimir
            if (move_uploaded_file($_FILES['archivoSub']['tmp_name'], $uploadfile)) {
                return $nuevodirectorio;
            } else {
                return null; // Error al mover el archivo
            }
        } elseif ($tamano >= 2000000 && $ext == 'image/png') {
            // El archivo es grande y es PNG, comprimir
            $quality = 5; // Calidad de compresión predeterminada
            if (self::compressImage($_FILES['archivoSub']['tmp_name'], $uploadfile, $quality)) {
                // Renombrar el archivo comprimido con el mismo nombre que el original
                $compressed_filename = md5(date("dmYhisA")) . $encrip;
                $compressed_filepath = $uploaddir . $compressed_filename;
                rename($uploadfile, $compressed_filepath);
                return $nuevodirectorio;
            } else {
                // Si falla la compresión, eliminar el archivo comprimido
                unlink($uploadfile);
                return null;
            }
        } else {
            return null; // El archivo está vacío o no se pudo obtener su tamaño
        }
     }

     public static function findAllEmpresas()
     {
         if (!isset($estado) || $estado == "")
             $estado = -1;
 
         $result = QuerySQL::select(
             <<<SQL
                 select te.*
                 from trc_empresa te ;
             SQL,
             array(),
             true,
             "N"
         );
 
         return Result::success($result, "buscar todas las empresas");
     }


     public static function limpiar_cadena($cadena) {
        // Reemplazar espacios con guiones bajos
        $cadena = str_replace(' ', '_', $cadena);
        
        // Reemplazar caracteres especiales
        $caracteres_especiales = array(
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'ñ' => 'n', 'Ñ' => 'N'
        );
        
        $cadena = strtr($cadena, $caracteres_especiales);
        
        return $cadena;
    }

    function compressImage($source, $destination, $quality) {
        // Obtener información de la imagen
        $info = getimagesize($source);
        $mime = $info['mime'];
    
        // Crear una nueva imagen basada en el tipo de imagen
        switch ($mime) {
            case 'image/jpg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                return false; // Tipo de imagen no soportado
        }
    
        // Guardar la imagen comprimida en el destino
        switch ($mime) {
            case 'image/jpg':
                $result = imagejpeg($image, $destination, $quality);
                break;
            case 'image/png':
                $result = imagepng($image, $destination, 9 - round($quality / 10));
                break;
            case 'image/gif':
                $result = imagegif($image, $destination);
                break;
        }
    
        // Liberar memoria
        imagedestroy($image);
    
        return $result;
    }

    public static function deleteFoto($id_empresa)
    {

        //borrar el archivo del directorio
        $miObjetoArchivo = new CtrTrcEmpresa();
        $result1 =  $miObjetoArchivo->findByIdDoc($id_empresa);
        $directorio = $result1['directorio'];
        $nombre_encr = $result1['nombre_encr'];
        $ruta = "$directorio/$nombre_encr";

        if (unlink($ruta)) {

        }
        if (!isset($id_empresa) || $id_empresa == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new TrcEmpresa($id_empresa);
        $dao->setProperty('directorio', '');
        $dao->setProperty('nombre_logo', '');
        $dao->setProperty('nombre_encr', '');
        $dao->setProperty('tamano', '');
        $dao->setProperty('ext', '');

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //prueba findById
    public static function findByIdDoc($id_empresa)
    {
        if (!isset($id_empresa) || $id_empresa == "")
            return Result::error(__FUNCTION__, "id es requerido");
        if (!is_numeric($id_empresa))
            return Result::error(__FUNCTION__, "id debe ser numerico");

        $result = QuerySQL::select(
            <<<SQL
                select sa.id_empresa, sa.directorio, sa.nombre_encr 
                       from trc_empresa sa
                       where sa.id_empresa = :id_empresa;
                SQL,
            array("id_empresa" => $id_empresa),
            false,
            "N"
        );

        return $result;
    }
}
