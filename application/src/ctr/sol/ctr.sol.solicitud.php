<?php

class CtrSolSolicitud
{

public static function crear()
{
    if (isset($_POST["servicio_sel"]) && is_array($_POST["servicio_sel"])) {

        if ($_POST['subEmpresa'] == "" || $_POST['subEmpresa'] == null) {
            $id_empresa = $_POST['cliente'];
        } else {
            $id_empresa = $_POST['subEmpresa'];
        }

        $cantidad = count($_POST["servicio_sel"]) - 1;

        $now = new DateTime();
        $hoy =  date_format($now, 'Y-m-d');
        $hora = date_format($now, 'H:i:s');

        $obj_solSolicitud = new SolSolicitud();
        $obj_solSolicitud->setProperty('estado', 1);
        $obj_solSolicitud->setProperty('id_empresa', $id_empresa);
        $obj_solSolicitud->setProperty('doc_candidato', $_POST['numero_doc']);
        $obj_solSolicitud->setProperty('pais_vacante', $_POST['pais']);
        $obj_solSolicitud->setProperty('dpto_vacante', $_POST['departamento']);
        $obj_solSolicitud->setProperty('ciudad_vacante', $_POST['id_ciudad_act']);
        $obj_solSolicitud->setProperty('usuario', $_POST['responsable']);
        $obj_solSolicitud->setProperty('id_estado_solicitud', "ingresado");
        $obj_solSolicitud->setProperty('id_tercero', $_POST['id_tercero']);
        $obj_solSolicitud->setProperty('canal_recepcion', $_POST['canal_recepcion']);
        $obj_solSolicitud->setProperty('observacion', $_POST['observacion']);
        $obj_solSolicitud->setProperty('centro_costo', $_POST['centro_costo']);
        $obj_solSolicitud->setProperty('fch_solicitud', $hoy . ' ' . $hora);

        $insertSolicitud = $obj_solSolicitud->insert();

        $obj_usuario = new Usuario($_POST['responsable']);
        $perfil = $obj_usuario->getPerfil();
        $solicitante = $obj_usuario->getNombre()." ".$obj_usuario->getApellido();

        $obj_empresa = new TrcEmpresa($id_empresa);
        $razon_social = $obj_empresa->getRazonSocial();

        // ENVÍO DE CORREO CON MANEJO DE ERRORES
        if (in_array($perfil, [7, 8, 9])) {
            try {
                $resultCoordinadores = QuerySQL::select(
                    <<<SQL
                        select uu.email, uu.nombres, uu.apellidos
                            from usr_usuario uu
                            where uu.perfil IN (12,1)
                            AND uu.username != 'sofditech'
                            AND uu.estado = 'ACT';
                    SQL,
                    array(),
                    true,
                    "N"
                );

                $arrayCoordinadores = json_decode(json_encode($resultCoordinadores), true);
                if (!empty($arrayCoordinadores)) {
                    foreach ($arrayCoordinadores as $coordinador) {
                        $nombreCompleto = $coordinador['nombres'] . ' ' . $coordinador['apellidos'];
                        $email = $coordinador['email'];
                        
                        $mensaje = 'Estimado(a) coordinador '.$nombreCompleto.', el cliente '.$razon_social.' ha creado la solicitud # '.$insertSolicitud['id'];
                        
                        $url_imagen = $_ENV['APP_HOST'] . $_ENV['APP_URL'] . '/upload/image/sitio/logolargoProhumanos.png';
                        $subject = "SOLICITUD CREADA POR EL CLIENTE";
                        $text_content = $mensaje;
                        $text_content1 = "registre los datos de acceso para la realización del servicio"
                                        ."<br><br>Candidato: ".$_POST['nombre']." ". $_POST['apellido']
                                        ."<br>Cliente Solicitante: ".$solicitante
                                        ."<br>Documento de identidad: ".$_POST['numero_doc'];
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

                        $mail = new MAIL($email, "SOLICITUD CREADA POR EL CLIENTE", $body);
                        $mail->send();
                    }
                }
            } catch (Exception $e) {
                // Solo registrar el error pero continuar con el proceso
                error_log("Error al enviar correo: " . $e->getMessage());
                // Opcionalmente puedes agregar un registro a tu sistema de logs
                // Log::error("Error enviando correo para solicitud #" . $insertSolicitud['id'], $e->getMessage());
            }
        }

        if ($insertSolicitud['success']) {
            /// Se crean los servicios de la solicitud
            for ($i = 0; $i < count($_POST["servicio_sel"]); $i++) {
                $result = CtrSolSolicitudServicio::crear($insertSolicitud['id'], $_POST["servicio_sel"][$i], 1, 'N', $i, $cantidad );
                if (Result::isError($result)) {
                    $obj_solSolicitud = new SolSolicitud($insertSolicitud['id']);
                    $obj_solSolicitud->setProperty('estado', 0);
                    $resulUpd =  $obj_solSolicitud->update();
                    return BaseResponse::error(__FUNCTION__, "Combo no está configurado para el cliente");
                }
            }

            $insertCandidato = CtrSolCandidato::crear($insertSolicitud['id'], $_POST['id_ciudad_act'], $_POST['tipo_id'], $_POST['numero_doc'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['email'], $_POST['cargo_desempeno']);
            if (Result::isError($insertCandidato)) {
                $obj_solSolicitud = new SolSolicitud($insertSolicitud['id']);
                $obj_solSolicitud->setProperty('estado', 0);
                $resulUpd =  $obj_solSolicitud->update();
                return BaseResponse::error(__FUNCTION__, "No hay combo configurado para los servicios seleccionados");
            }
            
            // Se insertan los archivos si adjuntaron
            if (isset($_FILES['archivo']['size']) && $_FILES['archivo']['size'] != "") {
                $tamano = $_FILES['archivo']['size'];
                $nombre_arc = $_FILES['archivo']['name'];

                $extension_archivo_origen = strrchr($nombre_arc, ".");
                $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

                $miObjetoIdSolicitud = new CtrSolAdjuntos();
                $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($insertSolicitud['id']);

                $nom_empre = $nomEmpresa['razon_social'];
                $directorioCargueArchivo =  CtrSolAdjuntos::uploadFile($nom_empre, $insertSolicitud['id'], $nuevo_nombre_archivo );
                $directorio = $directorioCargueArchivo;

                $dao = new SolAdjuntos();
                $dao->setProperty('id_solicitud', $insertSolicitud['id']);
                $dao->setProperty("nombre", $nombre_arc);
                $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
                $dao->setProperty("directorio", $directorio);
                $dao->setProperty("tamano", $tamano);
                $dao->setProperty("observacion", $_POST['descripcion']);
                $dao->setProperty("ext", $extension_archivo_origen);
                $resultAdjuntos =  $dao->insert();
            }
            return Result::success($insertSolicitud);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $insertSolicitud);
        }
    } else {
        return array("success" => false, "action" => "Debe seleccionar al menos un servicio");
    }
}

    public static function findWithFilter($filter = array())
    {

        if (!isset($filter['fecha_desde']) || $filter['fecha_desde'] == "")
            $filter['fecha_desde'] = null;

        if (!isset($filter['fecha_hasta']) || $filter['fecha_hasta'] == "")
            $filter['fecha_hasta'] = null;

        if (!isset($filter['cliente']) || $filter['cliente'] == "")
            $filter['cliente'] = 'all';

        if (!isset($filter['estado']) || $filter['estado'] == "")
            $filter['estado'] = 'all';

        if (!isset($filter['combo']) || $filter['combo'] == "")
            $filter['combo'] = 'all';

        if (!isset($filter['subempresa']) || $filter['subempresa'] == "")
            $filter['subempresa'] = 'all';

        $usuario = CtrUsuario::getUsuarioApp();
        $resultCount = CtrUsuario::consultar($usuario);
        $perfil = $resultCount['perfil'];
        $empresa = $resultCount['id_empresa'];

        // Perfiles: Administrador (1) -  Coordinador( 12): Puede ver todas las solicitudes.
        // Perfiles: Cliente sin informe (8) - Cliente sin informe (9): ve sólo las solicitudes de su empresa
        // Perfil: Cliente administrador(7), puede ver las de la empresa padre y empresas hijas
        // Perfiles: Visitador (10), Poligrafista (11), Asesor (), Sólo pueden ver las solicitudes que tengan asigan servicios asignados a ellos.

        $result = QuerySQL::select(
            <<<SQL

            WITH empresas_filtradas AS (
                -- Pre-filtrar empresas según cliente (una sola vez)
                SELECT DISTINCT te.id_empresa
                FROM trc_empresa te
                WHERE :cliente = 'all' 
                OR :cliente = COALESCE(te.id_empresa_padre, te.id_empresa)
            ),
            empresas_perfil AS (
                -- Pre-filtrar empresas según perfil 7
                SELECT DISTINCT te3.id_empresa
                FROM trc_empresa te3
                WHERE te3.estado = 1
                AND (:empresa = COALESCE(te3.id_empresa_padre, te3.id_empresa) 
                    OR :empresa = te3.id_empresa)
                AND (:subempresa = 'all' OR te3.id_empresa = :subempresa)
            ),
            solicitudes_usuario AS (
                -- Pre-filtrar solicitudes según usuario asignado
                SELECT DISTINCT sss.id_solicitud
                FROM sol_solicitud_servicio sss
                WHERE (:perfil IN (10,11,15,16) AND sss.id_usuario_asig = :usuario)
                OR (:perfil = 13 AND sss.id_usuario_calidad = :usuario)
            ),
            servicios_count AS (
                -- Pre-calcular conteo de servicios por solicitud
                SELECT id_solicitud, COUNT(*) as total_servicios
                FROM sol_solicitud_servicio
                GROUP BY id_solicitud
            ),
            servicios_anteriores_count AS (
                -- Pre-calcular servicios anteriores por candidato y empresa
                SELECT doc_candidato, id_empresa, COUNT(*) as total_anteriores
                FROM sol_solicitud
                WHERE estado = 1
                GROUP BY doc_candidato, id_empresa
            ),
            subempresas_usuario AS (
                -- Pre-filtrar subempresas del usuario
                SELECT DISTINCT ue.id_empresa
                FROM usr_empre ue
                WHERE ue.username = :usuario
            )
            SELECT 
                ss.id_solicitud,
                ss.ciudad_vacante,
                fnc_nombre_ciudad(ss.ciudad_vacante) AS ciudad_nombre,
                ss.id_empresa,
                te.razon_social,
                ss.doc_candidato,
                sc.nom_combo,
                COALESCE(
                    CONCAT('# *', sc2.numero_doc, ' - *', sc2.nombre, ' - *', sc2.apellido, ' - *', sc2.cargo_desempeno),
                    'N/A'
                ) AS candidato,
                ss.usuario,
                CONCAT(uu.nombres, ' ', uu.apellidos) AS responsable,
                ss.id_estado_solicitud,
                ss.fch_solicitud,
                ss.fch_estimada_sol,
                ss.fch_estimada_sol_nueva,
                ss.fch_preliminar,
                ss.fch_fin_solicitud,
                COALESCE(svc.total_servicios, 0) AS servicios,
                COALESCE(sac.total_anteriores, 0) AS servicios_anteriores,
                ss.estado,
                ss.fch_create
            FROM sol_solicitud ss
            INNER JOIN trc_empresa te ON te.id_empresa = ss.id_empresa
            INNER JOIN usr_usuario uu ON uu.username = ss.usuario
            INNER JOIN srv_combos sc ON ss.id_combo = sc.id_combo
            LEFT JOIN sol_candidato sc2 ON ss.id_solicitud = sc2.id_solicitud
            LEFT JOIN servicios_count svc ON ss.id_solicitud = svc.id_solicitud
            LEFT JOIN servicios_anteriores_count sac 
                ON ss.doc_candidato = sac.doc_candidato 
                AND ss.id_empresa = sac.id_empresa
            -- Filtros según perfil usando JOINs en lugar de subconsultas
            LEFT JOIN empresas_filtradas ef ON ss.id_empresa = ef.id_empresa
            LEFT JOIN empresas_perfil ep ON ss.id_empresa = ep.id_empresa
            LEFT JOIN solicitudes_usuario su ON ss.id_solicitud = su.id_solicitud
            LEFT JOIN subempresas_usuario seu ON ss.id_empresa = seu.id_empresa
            WHERE ss.estado = 1
            AND ss.fch_solicitud BETWEEN 
                COALESCE(:fecha_desde, DATE_SUB(NOW(), INTERVAL 6 MONTH)) 
                AND COALESCE(:fecha_hasta, date_add(now(), interval 5 year))
            -- Filtro cliente
            AND (:cliente = 'all' OR ef.id_empresa IS NOT NULL)
            -- Filtro estado
            AND (
                    (:estado = 'all' AND ss.id_estado_solicitud NOT IN ('finalizada', 'cancelada'))
                    OR (:estado != 'all' AND ss.id_estado_solicitud = :estado)
                )
            -- Filtro combo
            AND (:combo = 'all' OR ss.id_combo = :combo)
            -- Filtro según perfil (estructura simplificada)
            AND (
                    -- Perfil 1,12
                    (:perfil IN (1,12) AND 
                        (te.id_empresa = ss.id_empresa OR 
                        EXISTS (SELECT 1 FROM trc_empresa te2 
                                WHERE te2.id_empresa_padre = ss.id_empresa 
                                AND te2.estado = 1)))
                    OR
                    -- Perfil 8,9
                    (:perfil IN (8,9) AND 
                        CASE 
                            WHEN EXISTS (SELECT 1 FROM trc_empresa 
                                        WHERE id_empresa = ss.id_empresa 
                                        AND (flag_subemp = 1 OR id_empresa_padre IS NOT NULL))
                            THEN seu.id_empresa IS NOT NULL AND ss.usuario = :usuario
                            ELSE ss.usuario = :usuario
                        END)
                    OR
                    -- Perfil 7
                    (:perfil = 7 AND ep.id_empresa IS NOT NULL)
                    OR
                    -- Perfil 10,11,15,16,13
                    (:perfil IN (10,11,15,16,13) AND su.id_solicitud IS NOT NULL)
                    OR
                    -- Default (no debería llegar aquí si todo está bien configurado)
                    (:perfil NOT IN (1,12,7,8,9,10,11,13,15,16) AND 1=0)
                )
            ORDER BY ss.id_solicitud
            SQL,
            array(
                "fecha_desde" => $filter['fecha_desde'],
                "fecha_hasta" => $filter['fecha_hasta'],
                "cliente" => $filter['cliente'],
                "subempresa" => $filter['subempresa'],
                "estado" => $filter['estado'],
                "combo" => $filter['combo'],
                "perfil" => $perfil,
                "empresa" => $empresa,
                "usuario" => $usuario,
            ),
            true,
            "N"
        );

        return Result::success($result, "buscar servicios");
    }

    static public function consultarTodos()
    {
        $obj_srvServicio = new SrvServicio();
        return $obj_srvServicio->selectAll();
    }

    public static function delete($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolSolicitud($id_solicitud);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findById($id)
    {
        if (!isset($id) || $id == "")
            return Result::error(__FUNCTION__, "id es requerido");

        if (!is_numeric($id))
            return Result::error(__FUNCTION__, "id debe ser númerico");


        $result = QuerySQL::select(
            <<<SQL
                select ss.*, cc.nombre as des_ciudad, sc.razon_social,
                    case when ss.usuario is not null then 
                        (select concat(u.nombres, ' ', u.apellidos) from usr_usuario u where u.username = ss.usuario) 
                    else 
                        null
                    end as resposable,
                    case when ss.usuario is not null then 
                        (select email from usr_usuario u where u.username = ss.usuario) 
                    else 
                        null
                    end as correo_resposable,
                    case when ss.canal_recepcion is not null then 
                        (select descripcion from configurations c2 where c2.categoria = 'canal_recepcion'
                        and c2.codigo = ss.canal_recepcion)
                    else
                        null
                    end as desc_recepcion,
                    te.razon_social as cliente_desc,
                    (select descripcion 
                    from configurations c
                    where c.categoria = 'estado_solicitud'
                    and c.codigo = ss.id_estado_solicitud) as estado_desc, 
                    CONCAT(sc.nombre, ' ', sc.apellido) as nombre_candidato,  
                    sc.numero_doc as numero_documento,
                    fcn_desc_configurations('tipo_identificacion', sc.tipo_id) as des_documento, -- tipo de documento
                    sc.cargo_desempeno as cargo, 
                    sc.telefono, 
                    sc.email, 
                    sc.direccion,
                    sc.fch_expedicion,
                    fnc_nombre_ciudad(sc.id_ciudad_expe) as ciudad_exp,
                    te.direccion as dir_cli,
                    concat('[#', sc2.id_combo, '] - ', sc2.nom_combo) as nom_combo,
                    fcn_desc_configurations('tipo_concepto_profesional', ss.concepto_final) as des_concepto
                from sol_solicitud ss
                inner join trc_empresa te on ss.id_empresa = te.id_empresa
                inner join sol_candidato sc on ss.id_solicitud = sc.id_solicitud
                inner join srv_combos sc2 on ss.id_combo = sc2.id_combo
                left join conf_pais cp on ss.pais_vacante = cp.id_pais
                left join conf_dpto cd on ss.dpto_vacante = cd.id_dpto
                left join conf_ciudad cc on ss.ciudad_vacante = cc.id_ciudad
                where ss.id_solicitud = :id;

                SQL,
            array(
                "id" => $id,
            ),
            false,
            "N"
        );

        if (isset($result)) {
            //print_r( $result['id_solicitud'] );
            $result['servicios'] = Result::getData(CtrSrvServicio::solicitudServicios($result['id_solicitud']));
            //print_r( $result['servicios'] );
            $result['archivos'] = Result::getData(CtrSolAdjuntos::findByAllBySolicitud($result['id_solicitud']));
        }
        return Result::success($result, "buscar servicio");
    }


    public static function update(
        $id_solicitud,
        $doc_candidato,
        $observacion,
        $pais_edit,
        $departamento_edit,
        $id_ciudad_act
        //$localidad
    ) {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolSolicitud($id_solicitud);
        $dao->setProperty('doc_candidato', $doc_candidato);
        $dao->setProperty('observacion', $observacion);
        $dao->setProperty('pais_vacante', $pais_edit);
        $dao->setProperty('dpto_vacante', $departamento_edit);
        $dao->setProperty('ciudad_vacante', $id_ciudad_act);
        //$dao->setProperty('observacion', $localidad);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function updateCalidad($id_solicitud, $obs_calidad, $concepto_final) 
    {
        //print_r($id_solicitud, $obs_calidad, $concepto_final);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolSolicitud($id_solicitud);
        $dao->setProperty('obs_calidad', $obs_calidad);
        $dao->setProperty('concepto_final', $concepto_final);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function updateCentroCosto($id_solicitud, $centro_costo) 
    {
        //print_r($id_solicitud, $centro_costo);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolSolicitud($id_solicitud);
        $dao->setProperty('centro_costo', $centro_costo);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function preliminar(
        $id_solicitud
    ) {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new SolSolicitud($id_solicitud);
        $dao->setProperty('preliminar', 'S');


        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


    public static function cambiarEstado($id_solicitud, $estado, $motivo_inactivo)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::update(
            <<<SQL
                update sol_solicitud 
                 set estado = :estado ,
                     motivo_inactivo = :motivo_inactivo
                where  id_solicitud = :id_solicitud
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "estado" => $estado,
                "motivo_inactivo" => $motivo_inactivo
            ),
            false,
            "N"
        );

        return Result::success($result, "Cambiar estado solicitud");
    }

    public static function cancelarSolicitud($id_solicitud, $motivo_cancelacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::update(
            <<<SQL
                update sol_solicitud 
                 set id_estado_solicitud = 'cancelada' ,
                     motivo_cancelacion = :motivo_cancelacion
                where  id_solicitud = :id_solicitud
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "motivo_cancelacion" => $motivo_cancelacion
            ),
            false,
            "N"
        );

        if (isset($result)) {
            // Envía correo
            $perfiles = CtrConfiguracion::val("acciones_perfil", "correo_cancela_solicitud");
            $resultCorreos = QuerySQL::select(
                <<<SQL
                select uu.email  email
                from usr_usuario uu 
                where uu.perfil in (:perfiles)
                    and uu.username != 'sofditech'
                    and uu.estado = 'ACT'
                    and uu.email is not null
                union all 
                select uu.email  email
                from usr_usuario uu 
                where  uu.estado = 'ACT'
                    and username = (select ss.usuario  from sol_solicitud ss where ss.id_solicitud = :id_solicitud)

            SQL,
                array(
                    "perfiles" => $perfiles,
                    "id_solicitud" => $id_solicitud
                ),
                true,
                "N"
            );

            $arrayCorreos = json_decode(json_encode($resultCorreos), true);
            for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
                $para = $arrayCorreos[$i]['email'];
                $mensaje = "Ha sido cancelada una Solicitud " . $motivo_cancelacion;

                try {
                    $mail = new MAIL($para, "Cancelación de Solicitud", $mensaje);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CANCELACIÓN SOLICITUD", "code" => $e->getMessage());
                }

                try {
                    $mail->send();
                    // return BaseResponse::success($result);
                } catch (Exception $e) {
                    return array("success" => false, "action" => "CANCELACIÓN SOLICITUD", "code" => $mail->ErrorInfo);
                }
            }
        }

        return Result::success($result, "Cancelar solicitud");
    }

    public static function dashboardResume()
    {
        $id_empresa = CtrUsuario::getClienteRol(true);
        if (!isset($id_empresa) || $id_empresa == "")
            $id_empresa = -1;

        //print_r($id_empresa);

        $username = CtrUsuario::getUsuarioApp();

        //print_r($username);

        $result = QuerySQL::select(
            <<<SQL
            SELECT  
                IFNULL(sum(IF(s.id_estado_solicitud = 'ingresado', s.total, 0)), 0) as ingresado, 
                IFNULL(sum(IF(s.id_estado_solicitud = 'gestion', s.total, 0)), 0) as gestion,
                IFNULL(sum(IF(s.id_estado_solicitud = 'finalizada', s.total, 0)), 0) as finalizada
            FROM (
                SELECT s.id_estado_solicitud, COUNT(0) as total  
                FROM sol_solicitud s
                WHERE 
                    s.id_estado_solicitud NOT IN ('pendiente', 'cancelada') AND
                    s.estado = 1 AND
                    (
                        -- Administradores y Coordinadores
                        EXISTS (SELECT 1 FROM usr_usuario u WHERE u.perfil IN (1, 12) AND u.username = :username)
                        -- Cliente administrador (perfil 7)
                        OR EXISTS (
                            SELECT 1 FROM usr_usuario u 
                            WHERE u.perfil IN (7) 
                            AND u.username = :username
                            AND (s.id_empresa = u.id_empresa OR EXISTS (
                                SELECT 1 FROM trc_empresa te 
                                WHERE te.id_empresa = s.id_empresa 
                                AND te.id_empresa_padre = u.id_empresa
                            ))
                        )
                        -- Clientes con/sin informe (perfiles 8,9) - CORREGIDO
                        OR (
                            EXISTS (SELECT 1 FROM usr_usuario u WHERE u.perfil IN (8,9) AND u.username = :username)
                            AND
                            (
                                -- CASO 1: Es subempresa - usar usr_empre PERO solo las solicitudes del usuario
                                (EXISTS (
                                    SELECT 1 
                                    FROM usr_empre ue 
                                    JOIN trc_empresa te ON ue.id_empresa = te.id_empresa
                                    WHERE ue.username = :username 
                                    AND ue.id_empresa = s.id_empresa
                                    AND (te.flag_subemp = 1 OR te.id_empresa_padre IS NOT NULL)
                                ) AND s.usuario = :username)  -- IMPORTANTE: Solo solicitudes del usuario
                                OR
                                -- CASO 2: No es subempresa - usar usuario de la solicitud
                                (s.usuario = :username AND NOT EXISTS (
                                    SELECT 1 
                                    FROM trc_empresa te 
                                    WHERE te.id_empresa = s.id_empresa 
                                    AND (te.flag_subemp = 1 OR te.id_empresa_padre IS NOT NULL)
                                ))
                            )
                        )
                        -- Otros perfiles (Asesores, Visitadores, etc.)
                        OR EXISTS (
                            SELECT 1 FROM usr_usuario u
                            WHERE u.perfil IN (16, 10, 11, 15, 13)
                            AND u.username = :username
                            AND s.id_solicitud IN (
                                SELECT ss.id_solicitud 
                                FROM sol_solicitud_servicio ss 
                                WHERE ss.id_usuario_asig = u.username OR ss.id_usuario_calidad = u.username
                            )
                        )
                    )
                GROUP BY s.id_estado_solicitud
            ) s;

            SQL,

            array(
                "id_empresa" => $id_empresa,
                "username" => $username
            ),
            false,
            "N"
        );

        return Result::success($result, "dashboard resume");
    }

public static function getMonthlyTrendData()
{
    $id_empresa = CtrUsuario::getClienteRol(true);
    if (!isset($id_empresa) || $id_empresa == "") {
        $id_empresa = -1;
    }

    $username = CtrUsuario::getUsuarioApp();

    $sql = <<<SQL
    SELECT 
        DATE_FORMAT(s.fch_solicitud, '%Y-%m') as mes,
        MONTHNAME(s.fch_solicitud) as nombre_mes,
        COUNT(*) as total_solicitudes,
        SUM(CASE WHEN s.id_estado_solicitud = 'ingresado' THEN 1 ELSE 0 END) as ingresadas,
        SUM(CASE WHEN s.id_estado_solicitud = 'gestion' THEN 1 ELSE 0 END) as en_gestion,
        SUM(CASE WHEN s.id_estado_solicitud = 'finalizada' THEN 1 ELSE 0 END) as finalizadas,
        SUM(CASE WHEN s.id_estado_solicitud = 'pendiente' THEN 1 ELSE 0 END) as pendientes
        -- SUM(CASE WHEN s.id_estado_solicitud = 'cancelada' THEN 1 ELSE 0 END) as canceladas
    FROM sol_solicitud s
    WHERE 
        s.estado = 1 
        AND YEAR(s.fch_solicitud) = YEAR(CURDATE())
        AND (
            -- Administradores y Coordinadores
            EXISTS (SELECT 1 FROM usr_usuario u WHERE u.perfil IN (1, 12) AND u.username = :username)
            -- Cliente administrador (perfil 7)
            OR EXISTS (
                SELECT 1 FROM usr_usuario u 
                WHERE u.perfil IN (7) 
                AND u.username = :username
                AND (s.id_empresa = u.id_empresa OR EXISTS (
                    SELECT 1 FROM trc_empresa te 
                    WHERE te.id_empresa = s.id_empresa 
                    AND te.id_empresa_padre = u.id_empresa
                ))
            )
            -- Clientes con/sin informe (perfiles 8,9) - CORREGIDO
            OR (
                EXISTS (SELECT 1 FROM usr_usuario u WHERE u.perfil IN (8,9) AND u.username = :username)
                AND
                (
                    -- CASO 1: Es subempresa - usar usr_empre PERO solo las solicitudes del usuario
                    (EXISTS (
                        SELECT 1 
                        FROM usr_empre ue 
                        JOIN trc_empresa te ON ue.id_empresa = te.id_empresa
                        WHERE ue.username = :username 
                        AND ue.id_empresa = s.id_empresa
                        AND (te.flag_subemp = 1 OR te.id_empresa_padre IS NOT NULL)
                    ) AND s.usuario = :username)
                    OR
                    -- CASO 2: No es subempresa - usar usuario de la solicitud
                    (s.usuario = :username AND NOT EXISTS (
                        SELECT 1 
                        FROM trc_empresa te 
                        WHERE te.id_empresa = s.id_empresa 
                        AND (te.flag_subemp = 1 OR te.id_empresa_padre IS NOT NULL)
                    ))
                )
            )
            -- Otros perfiles (Asesores, Visitadores, etc.)
            OR EXISTS (
                SELECT 1 FROM usr_usuario u
                WHERE u.perfil IN (16, 10, 11, 15, 13)
                AND u.username = :username
                AND s.id_solicitud IN (
                    SELECT ss.id_solicitud 
                    FROM sol_solicitud_servicio ss 
                    WHERE ss.id_usuario_asig = u.username OR ss.id_usuario_calidad = u.username
                )
            )
        )
    GROUP BY DATE_FORMAT(s.fch_solicitud, '%Y-%m'), MONTHNAME(s.fch_solicitud)
    ORDER BY DATE_FORMAT(s.fch_solicitud, '%Y-%m') DESC
    LIMIT 6
    SQL;

    $result = QuerySQL::select(
        $sql,
        array(
            "id_empresa" => $id_empresa,
            "username" => $username
        ),
        false,
        "N"
    );

    return Result::success($result, "monthly trend data");
}

/*/public static function update_state(
    $solicitud,
    $cliente,
    $estado
) {
    if (!isset($cliente) || $cliente == "")
        return Result::error(__FUNCTION__, "id_cliente es requerido");

    if (!is_numeric($cliente))
        return Result::error(__FUNCTION__, "id_cliente debe ser numérico");

    if (!isset($solicitud) || $solicitud == "")
        return Result::error(__FUNCTION__, "id es requerido");

    if (!is_numeric($solicitud))
        return Result::error(__FUNCTION__, "id debe ser numérico");

    if (!isset($estado) || $estado == "")
        return Result::error(__FUNCTION__, "estado es requerido");

    $estados_solicitud = CtrConfiguracion::consultarTodosCategoria('estado_solicitud');
    $estados = array();
    foreach ($estados_solicitud as $e)
        array_push($estados, $e['codigo']);

    if (!in_array($estado, $estados))
        return Result::error(__FUNCTION__, "estado no permitido");

    $servicios = Result::getData(CtrSolSolicitudServicio::findById($solicitud));

    $estados_requiere_servicio = array('pendiente', 'gestion', 'finalizada');
    if (empty($servicios) && in_array($estado, $estados_requiere_servicio))
        return Result::error(__FUNCTION__, "no se encontraron servicios");

    $algun_servicio_calilficado = false;
    $todos_servicios_calilficados = true;

    foreach ($servicios as $s) {
        $estado_servicio = $s['estado_servicio'];
        $calificado = $s['calificado'];

        // Si el servicio está cancelado y no calificado, lo ignoramos
        if ($estado_servicio == 0 && $calificado == 'N') {
            continue;
        }

        // Marcamos si hay alguno finalizado
        if ($estado_servicio == 8) {
            $algun_servicio_calilficado = true;
        }

        // Verificamos si todos están finalizados y calificados
        if (!($estado_servicio == 8 && $calificado == 'S')) {
            $todos_servicios_calilficados = false;
        }
    }

    if ($algun_servicio_calilficado && $estado == 'cancelada')
        return Result::error(__FUNCTION__, "No se puede cancelar solicitud si tiene servicios Finalizados");

    if (!$todos_servicios_calilficados && $estado == 'finalizada')
        return Result::error(__FUNCTION__, "No se puede finalizar la solicitud si tiene servicios sin Finalizar o No está calificado");

    $dao = new SolSolicitud($solicitud);

    if ($dao->getProperty('id_empresa') != $cliente)
        return Result::error(__FUNCTION__, "cliente no corresponde");

    $dao->setProperty('id_estado_solicitud', $estado);

    if ($estado == 'finalizada')
        $dao->setProperty('fch_fin_solicitud', date('Y-m-d H:i:s'));

    $result =  $dao->update();
    return BaseResponse::success($result);
}*/

public static function update_state(
    $solicitud,
    $cliente,
    $estado
) {
    if (!isset($cliente) || $cliente == "")
        return Result::error(__FUNCTION__, "id_cliente es requerido");

    if (!is_numeric($cliente))
        return Result::error(__FUNCTION__, "id_cliente debe ser numérico");

    if (!isset($solicitud) || $solicitud == "")
        return Result::error(__FUNCTION__, "id es requerido");

    if (!is_numeric($solicitud))
        return Result::error(__FUNCTION__, "id debe ser numérico");

    if (!isset($estado) || $estado == "")
        return Result::error(__FUNCTION__, "estado es requerido");

    $estados_solicitud = CtrConfiguracion::consultarTodosCategoria('estado_solicitud');
    $estados = array();
    foreach ($estados_solicitud as $e)
        array_push($estados, $e['codigo']);

    if (!in_array($estado, $estados))
        return Result::error(__FUNCTION__, "estado no permitido");

    $servicios = Result::getData(CtrSolSolicitudServicio::findById($solicitud));

    $estados_requiere_servicio = array('pendiente', 'gestion', 'finalizada');
    if (empty($servicios) && in_array($estado, $estados_requiere_servicio))
        return Result::error(__FUNCTION__, "no se encontraron servicios");

    // ✅ Obtener si el combo tiene un servicio manual
    $solicitudData = CtrSolSolicitud::findById($solicitud);
    $id_combo = $solicitudData['data']['id_combo'];

    $manual = CtrSrvCombos::findAllByComboManual($id_combo);
    $condicion_manual = ($manual['data'][0]['tiene_manual'] == "1");

    $manual_srv = CtrSrvCombos::findAllByNombreManual($solicitud);
    $nombre_srv = $manual_srv['data'][0]['nom_servicio'];

    if ($condicion_manual && !empty($nombre_srv)) {
        return Result::error(__FUNCTION__, "No se puede finalizar la solicitud si tiene servicios sin Finalizar ".$nombre_srv);
    }

    $algun_servicio_calificado = false;
    $todos_servicios_calificados = true;

    foreach ($servicios as $s) {
        $estado_servicio = $s['estado_servicio'];
        $calificado = $s['calificado'];

        if ($estado_servicio == 0 && $calificado == 'N') {
            continue;
        }

        if ($estado_servicio == 8) {
            $algun_servicio_calificado = true;
        }

        if (!($estado_servicio == 8 && $calificado == 'S')) {
            $todos_servicios_calificados = false;
        }
    }

    if ($algun_servicio_calificado && $estado == 'cancelada')
        return Result::error(__FUNCTION__, "No se puede cancelar solicitud si tiene servicios Finalizados");

    // ✅ Ajuste: Si hay manual, se permite finalizar sin validar calificaciones
    if (!$todos_servicios_calificados && $estado == 'finalizada' && !$condicion_manual)
        return Result::error(__FUNCTION__, "No se puede finalizar la solicitud si tiene servicios sin Finalizar o No está calificado");

    $dao = new SolSolicitud($solicitud);

    if ($dao->getProperty('id_empresa') != $cliente)
        return Result::error(__FUNCTION__, "cliente no corresponde");

    $dao->setProperty('id_estado_solicitud', $estado);

    if ($estado == 'finalizada')
        $dao->setProperty('fch_fin_solicitud', date('Y-m-d H:i:s'));

    $result =  $dao->update();
    return BaseResponse::success($result);
}




    public static function reenviarCorreo(
        $id_solicitud
    ) {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        if (!is_numeric($id_solicitud))
            return Result::error(__FUNCTION__, "id debe ser númerico");

        $resultExtUsr = QuerySQL::select(
            <<<SQL
                    select COUNT(1) cant 
                    from usr_usuario uu 
                    where username = (select ss.doc_candidato  from sol_solicitud ss where ss.id_solicitud = :id_solicitud);
                    SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        $arrayExtUsr = json_decode(json_encode($resultExtUsr), true);
        $cant = $arrayExtUsr[0]['cant'];

        if ($cant == 0) {

            $resultCandidato = QuerySQL::select(
                <<<SQL
                           select ss.doc_candidato,  te.id_empresa,  sc.email email, sc.nombre,  sc.apellido, sc.tipo_id
                            from sol_solicitud ss , trc_empresa te , sol_candidato sc 
                            where ss.id_empresa = te.id_empresa 
                            and ss.id_solicitud = sc.id_solicitud 
                            and ss.id_solicitud = :id_solicitud
                        SQL,
                array("id_solicitud" => $id_solicitud),
                true,
                "N"
            );

            $arrayCandidato = json_decode(json_encode($resultCandidato), true);
            $username = $arrayCandidato[0]['doc_candidato'];
            $idEmpresa = $arrayCandidato[0]['id_empresa'];
            $email = $arrayCandidato[0]['email'];
            $nombres = $arrayCandidato[0]['nombre'];
            $apellidos = $arrayCandidato[0]['apellido'];
            $tipo_identificacion = $arrayCandidato[0]['tipo_id'];

            $obj_usuario = new Usuario();
            $obj_usuario->setUsername($username);
            $obj_usuario->setProperty('id_empresa', $idEmpresa);
            $obj_usuario->setEmail($email);
            $obj_usuario->setProperty('nombres', $nombres);
            $obj_usuario->setProperty('apellidos', $apellidos);
            $obj_usuario->setProperty('tipo_identificacion', $tipo_identificacion);
            $obj_usuario->setProperty('numero_identificacion', $username);
            $obj_usuario->setProperty('perfil', 14);
            $obj_usuario->setEstado("ACT");
            //$obj_usuario->setProperty('access_attempts', 0);
            $result = $obj_usuario->insert();
        }

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

            $updCandidato = QuerySQL::update(
                <<<SQL
                        UPDATE sol_candidato
                        SET correo_reenviado = 'S'
                        WHERE id_solicitud = :id_solicitud;

                    SQL,
                array(
                    "id_solicitud" => $id_solicitud
                ),
                true,
                "N"
            );

            //$mail->send();
            $nuevoPassword =  crypt('Prohumanos', constant('APP_KEY'));
            $resultEnviaCorreo = QuerySQL::update(
                <<<SQL
                          update usr_usuario
                            set  password = :nuevoPassword,
                                 password_expiration = DATE_ADD(create_time ,INTERVAL 1 YEAR),
                                 estado = 'ACT',
                                 access_attempts = 0
                            where username = (select sc.numero_doc from sol_candidato sc where sc.id_solicitud = :id_solicitud);
                        SQL,
                array(
                    "id_solicitud" => $id_solicitud,
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
            return array("success" => false, "action" => "Reenvío de Correo Candidato", "code" => $e->getMessage());
        }

        try {
            $mail->send();
            return BaseResponse::success($updCandidato);
        } catch (Exception $e) {
            return array("success" => false, "action" => "Envío Correo Candidato", "code" => $mail->ErrorInfo);
        }
    }

    // public static function valorAdicional($id_solicitud, $observacion, $valor)
    // {

    //     if (!isset($id_solicitud) || $id_solicitud == "")
    //         return Result::error(__FUNCTION__, "id es requerido");

    //     if (!isset($observacion) || $observacion == "")
    //         return Result::error(__FUNCTION__, "Observación es requerido");

    //     if (!isset($valor) || $valor == "")
    //         return Result::error(__FUNCTION__, "id es requerido");

    //     if (!is_numeric($valor))
    //         return Result::error(__FUNCTION__, "Valor debe ser númerico");

    //     $resultCount = QuerySQL::select(
    //         <<<SQL
    //                     select count(1) cant
    //                     from sol_servicios_adicionales ss 
    //                     where id_solicitud = :id_solicitud;
    //                 SQL,
    //         array("id_solicitud" => $id_solicitud),
    //         true,
    //         "N"
    //     );

    //     $arrayResult = json_decode(json_encode($resultCount), true);
    //     $cantidad = $arrayResult[0]['cant'];

    //     if ($cantidad > 0) {
    //         $result = QuerySQL::select(
    //             <<<SQL
    //                        update sol_servicios_adicionales 
    //                          set valor = :valor,
    //                              observacion = :observacion
    //                         where id_solicitud = :id_solicitud;
    //                     SQL,
    //             array(
    //                 "id_solicitud" => $id_solicitud,
    //                 "valor" => $valor,
    //                 "observacion" => $observacion
    //             ),
    //             true,
    //             "N"
    //         );
    //         return Result::success($result, "Servicio Actualizado");
    //     } else {
    //         $id_cuenta = CtrConfiguracion::val("cuenta_srv_adc", "id_cuenta");


    //         $obj_srvValorAdicional = new SolServiciosAdicionales();
    //         $obj_srvValorAdicional->setProperty('id_solicitud', $id_solicitud);
    //         $obj_srvValorAdicional->setProperty('observacion', $observacion);
    //         $obj_srvValorAdicional->setProperty('valor', $valor);
    //         $obj_srvValorAdicional->setProperty('id_cuenta', $id_cuenta);

    //         $result = $obj_srvValorAdicional->insert();
    //         if ($result['success']) {
    //             return BaseResponse::success($result);
    //         } else {
    //             return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
    //         }
    //     }
    // }

    public static function qry_solicitud($id_solicitud, $id_servicio)
    {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    te.razon_social,
                    cc.nombre AS ciudad_vacante,
                    ss.fch_solicitud,
                    ss.fch_fin_solicitud,
                    ss.id_empresa,
                    sss.id_usuario_asig,
                    fnc_nombre_proveedor(sss.id_usuario_asig) AS proveedor,
                    up.perfil AS perfil_proveedor, -- PERFIL DEL PROVEEDOR
                    up.registro,
                    sst.fch_create AS fch_asistio,
                    CONCAT(uu.nombres, ' ', uu.apellidos) AS nom_usuario,
                    fnc_nombre_proveedor(sss.id_usuario_calidad) AS usr_calidad,
                    sss.id_usuario_calidad,
                    sss.fecha_termina_proveedor,
                    sss.fecha_programacion,
                    ss.obs_calidad,
                    ss.concepto_final
                FROM 
                    sol_solicitud ss
                    JOIN trc_empresa te ON ss.id_empresa = te.id_empresa
                    JOIN conf_ciudad cc ON ss.ciudad_vacante = cc.id_ciudad
                    JOIN usr_usuario uu ON uu.username = ss.usuario
                    JOIN sol_solicitud_servicio sss ON ss.id_solicitud = sss.id_solicitud
                    LEFT JOIN sol_solicitud_timeline sst 
                        ON sss.id_solicitud = sst.id_solicitud 
                        AND sss.id_servicio = sst.id_servicio
                        AND sss.asistio = 1
                        AND sst.accion = 'Asiste candidato'
                    LEFT JOIN usr_usuario up ON up.username = sss.id_usuario_asig -- UNIR CON PERFIL DEL PROVEEDOR
                WHERE 
                    ss.id_solicitud = :id_solicitud 
                    AND sss.id_servicio = :id_servicio;
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio,
            ),
            true,
            "N"
        );

        return Result::success($result);
    }

    public static function qry_solicitudSinSrv($id_solicitud)
    {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    te.razon_social,
                    cc.nombre AS ciudad_vacante,
                    ss.fch_solicitud,
                    ss.fch_fin_solicitud,
                    ss.id_empresa,
                    sss.id_usuario_asig,
                    fnc_nombre_proveedor(sss.id_usuario_asig) AS proveedor,
                    up.perfil AS perfil_proveedor, -- PERFIL DEL PROVEEDOR
                    up.registro,
                    sst.fch_create AS fch_asistio,
                    CONCAT(uu.nombres, ' ', uu.apellidos) AS nom_usuario,
                    fnc_nombre_proveedor(sss.id_usuario_calidad) AS usr_calidad,
                    sss.id_usuario_calidad,
                    sss.fecha_termina_proveedor,
                    sss.fecha_programacion,
                    ss.obs_calidad,
                    ss.concepto_final
                FROM 
                    sol_solicitud ss
                    JOIN trc_empresa te ON ss.id_empresa = te.id_empresa
                    JOIN conf_ciudad cc ON ss.ciudad_vacante = cc.id_ciudad
                    JOIN usr_usuario uu ON uu.username = ss.usuario
                    JOIN sol_solicitud_servicio sss ON ss.id_solicitud = sss.id_solicitud
                    LEFT JOIN sol_solicitud_timeline sst 
                        ON sss.id_solicitud = sst.id_solicitud 
                        AND sss.id_servicio = sst.id_servicio
                        AND sss.asistio = 1
                        AND sst.accion = 'Asiste candidato'
                    LEFT JOIN usr_usuario up ON up.username = sss.id_usuario_asig -- UNIR CON PERFIL DEL PROVEEDOR
                WHERE 
                    ss.id_solicitud = :id_solicitud 
                    -- AND sss.id_servicio = :id_servicio;
            SQL,
            array(
                "id_solicitud" => $id_solicitud
            ),
            true,
            "N"
        );

        return Result::success($result);
    }

    public static function qry_infSolicitud($id_solicitud)
    {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");
        $result = QuerySQL::select(
            <<<SQL
                SELECT DISTINCT  ss.fch_solicitud,
                       ss.fch_fin_solicitud,
                       te.razon_social,
                       cc.nombre AS ciudad_vacante,
                       CONCAT(ua.nombres, ' ', ua.apellidos) AS nom_cliente,
                       ua.cargo,
                       ua.username id_cliente,
                       CONCAT(up.nombres, ' ', up.apellidos) AS nom_proveedor,
                       up.username id_proveedor,
                       CONCAT(uc.nombres, ' ', uc.apellidos) AS evaluador_calidad,
                       uc.username id_calidad,
                       up.perfil
                FROM  sol_solicitud ss
                INNER JOIN  trc_empresa te ON ss.id_empresa = te.id_empresa
                INNER JOIN  conf_ciudad cc ON ss.ciudad_vacante = cc.id_ciudad
                INNER JOIN  usr_usuario ua ON ss.usuario = ua.username -- CLiente
                 LEFT JOIN  sol_solicitud_servicio sss ON ss.id_solicitud = sss.id_solicitud
                 LEFT JOIN  usr_usuario uc ON sss.id_usuario_calidad = uc.username  -- Evaluador de calidad
                 LEFT JOIN  usr_usuario up ON sss.id_usuario_asig  = up.username -- Proveedor
                WHERE  ss.id_solicitud = :id_solicitud
                  AND CONCAT(uc.nombres, ' ', uc.apellidos) is not null
            SQL,
            array(
                "id_solicitud" => $id_solicitud
            ),
            true,
            "N"
        );

        return Result::success($result);
    }

    public static function qry_infSolicitudCombo($id_solicitud, $id_servicio)
    {

        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");
        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    (CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM sol_solicitud_servicio 
                            WHERE id_solicitud = :id_solicitud 
                            AND id_servicio = :id_servicio
                        ) THEN 1
                        ELSE 0
                    END) AS resultado,
                    sss.id_solicitud,
                    sss.id_servicio,
                    sss.id_usuario_asig,
                    u.registro,
                    CONCAT(u.nombres, ' ', u.apellidos) AS nombre_proveedor
                FROM sol_solicitud_servicio sss
                LEFT JOIN usr_usuario u ON sss.id_usuario_asig = u.username
                WHERE sss.id_solicitud = :id_solicitud 
                AND sss.id_servicio = :id_servicio;

            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio
            ),
            true,
            "N"
        );

        return Result::success($result);
    }

    public static function enviarCorreo()
    {
        $perfiles = CtrConfiguracion::val("acciones_perfil", "correo_nueva_solicitud");
        $resultCorreos = QuerySQL::select(
            <<<SQL
                            select uu.email  email
                            from usr_usuario uu 
                            where uu.perfil in (:perfiles)
                            and uu.estado = 'ACT'
                            and uu.email is not null;

                    SQL,
            array(
                "perfiles" => $perfiles
            ),
            true,
            "N"
        );

        $arrayCorreos = json_decode(json_encode($resultCorreos), true);
        for ($i = 0; $i <= count($arrayCorreos) - 1; $i++) {
            $para = $arrayCorreos[$i]['email'];
            $mensaje = "Una nueva solicitud ha sido creada";

            try {
                $mail = new MAIL($para, "Creación de Solicitud", $mensaje);
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

    //Mirar por cedula servicios que ya existan
    public static function ExiteServicioEvaluado($doc_candidato)
    {
        //print_r($doc_candidato);
        $result = QuerySQL::select(
            <<<SQL
            SELECT sss.id_solicitud,
                    sss.id_servicio,
                    ss.nom_servicio,
                    -- sss.estado,
                    fcn_desc_configurations('estado_servicios', sss.estado) estado,
                    -- sss.estado_proceso,
                    fcn_desc_configurations('estado_servicios', sss.estado_proceso) estado_proceso,
                    sss.fch_create
                FROM sol_solicitud sc, sol_solicitud_servicio sss, srv_servicios ss
                WHERE sc.doc_candidato = :doc_candidato
                AND sc.id_solicitud = sss.id_solicitud
                AND ss.id_servicio = sss.id_servicio
                AND sc.id_estado_solicitud != 'cancelada'
            SQL,
            array(
                "doc_candidato" => $doc_candidato
            ),
            true,
            "N"
        );

        return BaseResponse::success($result, "Servicios del Evaluado");
    }

public static function importFile(
    $cliente,
    $subEmpresa,
    $tercero,
    $responsable,
    $separador = ';',
    $separador_servicios = '*'
) {
    if (!isset($cliente) || $cliente === "") {
        return BaseResponse::error(__FUNCTION__, "cliente es requerido");
    }
    if (!is_numeric($cliente)) {
        return BaseResponse::error(__FUNCTION__, "cliente debe ser numérico");
    }

    $destination_directory = constant('APP_ROUTES_UPLOADS') . 'tmp/';
    $upload_file = CtrUtil::uploadFile("cargue", $destination_directory, 'cargue_solicitudes', true, ['csv', 'txt', 'prn']);
    if (!BaseResponse::isSuccess($upload_file)) {
        return BaseResponse::error(__FUNCTION__, $upload_file);
    }

    $length_in_columns = 9;
    $data_file = CtrUtil::readFileContentToArray($upload_file['data']['full_path'], $separador, $length_in_columns, true, true);
    if (!BaseResponse::isSuccess($data_file)) {
        return BaseResponse::error(__FUNCTION__, $data_file, $data_file['data']);
    }

    $structure = [
        'nombre_candidato' => 0,
        'apellido_candidato' => 1,
        'nro_identidad' => 2,
        'email' => 3,
        'cargo_desempeno' => 4,
        'telefono' => 5,
        'ciudad_vacante' => 6,
        'observacion' => 7,
        'servicios' => 8
    ];

    $solicitudes = BaseResponse::getData($data_file);
    $solicitudes = array_filter($solicitudes, fn($fila) => count(array_filter($fila)) > 0);

    // Limpieza
    foreach ($solicitudes as &$sol) {
        $sol[8] = trim(str_replace(["\r", "\n"], '', $sol[8]));
        $sol[8] = !empty($sol[8])
            ? array_map('intval', array_map('trim', explode($separador_servicios, $sol[8])))
            : [];
    }

    $cargueId = uniqid();
    $errores = [];
    $solicitudes_correctas = [];

    foreach ($solicitudes as $k => &$sol) {
        array_splice($sol, $length_in_columns);

        try {
            $sol = array_combine(array_keys($structure), $sol);
        } catch (Exception $e) {
            $errores[] = ['fila' => $k + 1, 'error' => 'Error al combinar estructura: ' . $e->getMessage()];
            continue;
        }

        $campos_obligatorios = ['nombre_candidato', 'apellido_candidato', 'nro_identidad', 'email', 'cargo_desempeno', 'telefono', 'ciudad_vacante','servicios'];
        foreach ($campos_obligatorios as $campo) {
            if (empty($sol[$campo])) {
                $errores[] = ['fila' => $k + 1, 'error' => "El campo {$campo} está vacío"];
                continue 2;
            }
        }

        // Llama a crearDesdeImportacion
        $result = self::crearDesdeImportacion(
            $cliente,
            $subEmpresa,
            $tercero,
            $responsable,
            $sol['nombre_candidato'],
            $sol['apellido_candidato'],
            $sol['nro_identidad'],
            $sol['email'],
            $sol['cargo_desempeno'],
            $sol['telefono'],
            $sol['ciudad_vacante'],
            $sol['observacion'],
            $sol['servicios'],
            $cargueId
        );

        if (!BaseResponse::isSuccess($result)) {
            $errores[] = [
                'fila' => $k + 1,
                'error' => $result['message'] ?? json_encode($result)
            ];
            continue;
        }

        $solicitudes_correctas[] = $sol;
    }

    $solicitudes_all = CtrSolSolicitud::solicitudesMasivas($cargueId);

    return BaseResponse::success([
        'solicitudes_correctas' => $solicitudes_all,
        'errores' => $errores
    ], "Solicitud Masiva");
}


    /***************************************************************************
     * Funcion devuelve las solicitudes .
     *********************************************************************/
    public static function solicitudesMasivas($cargue)
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT s.id_solicitud, 
                        c.numero_doc, 
                        c.nombre, 
                        c.apellido,
                        c.cargo_desempeno, 
                        c.email
                FROM sol_solicitud s, sol_candidato c
                where s.cargue = :cargue
                    and s.id_solicitud = c.id_solicitud
            SQL,
            array("cargue" => $cargue),
            true,
            "N"
        );

        return $result;
    }

public static function crearDesdeImportacion(
    $cliente,
    $subEmpresa,
    $tercero,
    $responsable,
    $nombre,
    $apellido,
    $numero_doc,
    $email,
    $cargo,
    $telefono,
    $ciudad_vacante,
    $observacion,
    $servicios,
    $cargueId
) {

    $resultCiudades = QuerySQL::select(
        <<<SQL
            SELECT cp.nombre as nombre_pais,
                cp.id_pais as codigo_pais,
                cd.nombre as nombre_dpto,
                cd.id_dpto as codigo_dpto,
                cc.nombre as nombre_ciudad,
                cc.id_ciudad  as codigo_ciudad
            FROM conf_pais cp,
                conf_dpto cd,
                conf_ciudad cc
            WHERE cp.id_pais = cd.id_pais
            AND cd.id_dpto = cc.id_dpto
            AND cc.id_ciudad = :ciudad_vacante
        SQL,
        array("ciudad_vacante" => $ciudad_vacante),
        true,
        "N"
    );
    $arrayCiudades = json_decode(json_encode($resultCiudades), true);

    $codigo_pais = $arrayCiudades[0]['codigo_pais'];
    $codigo_dpto = $arrayCiudades[0]['codigo_dpto'];

    $id_empresa = ($subEmpresa == "" || $subEmpresa == null) ? $cliente : $subEmpresa;

    $now = new DateTime();
    $hoy = $now->format('Y-m-d');
    $hora = $now->format('H:i:s');
    $cantidad = count($servicios) - 1;

    $obj_solSolicitud = new SolSolicitud();
    $obj_solSolicitud->setProperty('estado', 1);
    $obj_solSolicitud->setProperty('id_empresa', $cliente);
    $obj_solSolicitud->setProperty('doc_candidato', $numero_doc);
    $obj_solSolicitud->setProperty('pais_vacante', $codigo_pais);
    $obj_solSolicitud->setProperty('dpto_vacante', $codigo_dpto);
    $obj_solSolicitud->setProperty('ciudad_vacante', $ciudad_vacante);
    $obj_solSolicitud->setProperty('observacion', $observacion);
    $obj_solSolicitud->setProperty('usuario', $responsable);
    $obj_solSolicitud->setProperty('id_estado_solicitud', 'ingresado');
    $obj_solSolicitud->setProperty('id_tercero', $tercero);
    $obj_solSolicitud->setProperty('fch_solicitud', $hoy . ' ' . $hora);
    $obj_solSolicitud->setProperty('usr_create', CtrUsuario::getUsuarioApp());
    $obj_solSolicitud->setProperty('fch_create', $hoy . ' ' . $hora);
    $obj_solSolicitud->setProperty('cargue', $cargueId);

    $insertSolicitud = $obj_solSolicitud->insert();

    if (!$insertSolicitud['success']) {
        return BaseResponse::error(__FUNCTION__, "Fallo insertSolicitud: " . json_encode($insertSolicitud));
    }
    //print_r($servicios);
    foreach ($servicios as $i => $servicio) {
        $result = CtrSolSolicitudServicio::crear($insertSolicitud['id'], $servicio, 1, 'N', $i, $cantidad);
        if (Result::isError($result)) {
            $obj_solSolicitud = new SolSolicitud($insertSolicitud['id']);
            $obj_solSolicitud->setProperty('estado', 0);
            $obj_solSolicitud->update();
            return BaseResponse::errorprueba(__FUNCTION__, "El combo no está configurado para el cliente");

        }
    }

    $insertCandidato = CtrSolCandidato::crear(
        $insertSolicitud['id'], $ciudad_vacante, null,
        $numero_doc, $nombre, $apellido,
        $telefono, null, $email, $cargo, null
    );

    if (Result::isError($insertCandidato)) {
        $obj_solSolicitud->setProperty('estado', 0);
        $obj_solSolicitud->update();
        return BaseResponse::error(__FUNCTION__, "Fallo al crear candidato: " . json_encode($insertCandidato));
    }

    return BaseResponse::success([
        'id_solicitud' => $insertSolicitud['id'],
        'nombre' => $nombre,
        'apellido' => $apellido
    ]);
}




}
