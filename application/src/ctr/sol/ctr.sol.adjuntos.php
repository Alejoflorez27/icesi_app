<?php

class CtrSolAdjuntos  
{
    //crea archivo adjunto hoja de vida alejoo
    public static function new($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null, $lista)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];
    
        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
        $nom_empre = $nomEmpresa['razon_social'];
    
        // Generar el nombre encriptado solo una vez
        $extension_archivo_origen = strrchr($nombre, ".");
        $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;
    
        // Le paso también el nombre encriptado
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result = $miObjetoArchivo->uploadFile($nom_empre, $id_solicitud, $nuevo_nombre_archivo);
    
        if ($result != null) {
            $directorio = $result;
    
            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
    
            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");
    
            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");
    
            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");
    
            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");
    
            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);
            $dao->setProperty("lista", $lista);
    
            $result1 = $dao->insert();
    
            return $result1['success'] ? BaseResponse::success($result1) : BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        } else {
            return BaseResponse::error(__FUNCTION__, "Error al subir archivo");
        }
    }
    
/*
    //crea archivo adjunto visita ingreso
    public static function new_visita_ingreso($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_visita_ingreso($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }
*/
/*    //crea archivo adjunto visita ingreso
    public static function new_visita_mantenimiento($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_visita_mantenimiento($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }
    //crea archivo adjunto visita teletrabajo
    public static function new_visita_teletrabajo($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_visita_teletrabajo($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }
    //crea archivo adjunto visita asociado
    public static function new_visita_asociado($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_visita_asociado($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }
*/
    //crea archivo adjunto estudio de confiabilidad con cifin alejo prueba
public static function new_adjuntos($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null, $lista)
{
    $id_solicitud = $id_sol;
    $tipo_doc = $tipo_docp;

    // Datos del archivo
    $file = $_FILES['archivo'];
    $tamano = $file['size'];
    $mime = $file['type'];
    $nombre = $file['name'];

    // Obtener nombre limpio de la empresa
    $miObjetoIdSolicitud = new CtrSolAdjuntos();
    $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
    $nom_empre = $nomEmpresa[0]['razon_social'];

    // Generar el nombre encriptado
    $extension_archivo_origen = strrchr($nombre, ".");
    $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

    // Subir archivo al servidor
    $miObjetoArchivo = new CtrSolAdjuntos();
    $result = $miObjetoArchivo->uploadFile_adjuntos($nom_empre, $id_solicitud, $id_servicio, $nuevo_nombre_archivo);

    if ($result !== null) {
        $directorio = $result;

        // Validaciones mínimas
        if (empty($id_solicitud)) return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (empty($nombre)) return BaseResponse::error(__FUNCTION__, "nombre archivo es requerido");
        if (empty($directorio)) return BaseResponse::error(__FUNCTION__, "directorio es requerido");
        if (empty($mime)) return BaseResponse::error(__FUNCTION__, "tipo de archivo es requerido");
        if (empty($tamano)) return BaseResponse::error(__FUNCTION__, "tamaño archivo es requerido");

        // Guardar registro en BD
        $dao = new SolAdjuntos();
        $dao->setProperty('id_solicitud', $id_solicitud);
        $dao->setProperty('id_servicio', $id_servicio);
        $dao->setProperty("nombre", $nombre);
        $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
        $dao->setProperty("directorio", $directorio);
        $dao->setProperty("tamano", $tamano);
        $dao->setProperty("observacion", $observacion);
        $dao->setProperty("tipo_doc", $tipo_doc);
        $dao->setProperty("ext", $extension_archivo_origen);
        $dao->setProperty("lista", $lista);

        $result1 = $dao->insert();
        return $result1['success'] ? BaseResponse::success($result1) : BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
    } else {
        return BaseResponse::error(__FUNCTION__, "Error al subir archivo");
    }
}

public static function new_adjuntos_multiple($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null, $lista)
{
    $id_solicitud = $id_sol;
    $tipo_doc = $tipo_docp;

    $miObjetoIdSolicitud = new CtrSolAdjuntos();
    $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);
    $nom_empre = $nomEmpresa[0]['razon_social'];

    $dao = new SolAdjuntos();
    $campos_archivos = ['archivo', 'archivo_alt'];

    foreach ($campos_archivos as $campo) {
        if (!isset($_FILES[$campo])) continue;

        $archivos = $_FILES[$campo];
        $cantidad = count($archivos['name']);

        for ($i = 0; $i < $cantidad; $i++) {
            if ($archivos['error'][$i] !== UPLOAD_ERR_OK) continue;

            $nombre = $archivos['name'][$i];
            $tmp_name = $archivos['tmp_name'][$i];
            $type = mime_content_type($tmp_name); // ✅ Detecta tipo real
            $size = $archivos['size'][$i];
            $extension = strtolower(strrchr($nombre, "."));
            $nuevo_nombre_archivo = md5(date("dmYhisA") . $campo . $i) . $extension;

            $upload_result = self::uploadFile_adjuntos_multiple(
                $nom_empre,
                $id_solicitud,
                $id_servicio,
                $nuevo_nombre_archivo,
                ['tmp_name' => $tmp_name, 'type' => $type]
            );

            if ($campo == 'archivo_alt') {
                $tipo_doc_adicional = CtrSolAdjuntos::trae_archivo_adicional($lista);
                $tipo_doc = $tipo_doc_adicional[0]['codigo'] ?? $tipo_doc;
            }

            if ($upload_result) {
                $dao->setProperty('id_solicitud', $id_solicitud);
                $dao->setProperty('id_servicio', $id_servicio);
                $dao->setProperty('nombre', $nombre);
                $dao->setProperty('nombre_encr', $nuevo_nombre_archivo);
                $dao->setProperty('directorio', $upload_result);
                $dao->setProperty('tamano', $size);
                $dao->setProperty('observacion', $observacion);
                $dao->setProperty('tipo_doc', $tipo_doc);
                $dao->setProperty('ext', $extension);
                $dao->setProperty('lista', $lista);
                $dao->insert();
            }
        }
    }

    return BaseResponse::success("Todos los archivos válidos fueron procesados correctamente.");
}


public static function new_adjuntos_auto($id_empre, $usuario)
{
    $id_empresa = $id_empre;
    $username = $usuario;

    // Inicializar variables en NULL por defecto
    $tamano = null;
    $ext = null;
    $nombre = null;
    $nuevo_nombre_archivo = null;
    $directorio = null;

    // Si existe archivo y no está vacío
    if (isset($_FILES['archivo']['name']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $nomEmpresa = CtrTrcEmpresa::findByIdPadre($id_empresa);
        $nom_empre = $nomEmpresa['data'][0]['razon_social'];

        // Generar nombre encriptado
        $extension_archivo_origen = strrchr($nombre, ".");
        $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

        // Subir archivo con nombre encriptado
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result = $miObjetoArchivo->uploadFile_adjuntos_auto($nom_empre, $nuevo_nombre_archivo);

        if ($result != null) {
            $directorio = $result;
        }
    }

    // Insertar aunque no haya archivo
    $dao = new AutoBash();
    $dao->setProperty("id_empresa", $id_empresa);
    $dao->setProperty("usuario", $username);
    $dao->setProperty("nombre_firma", $nombre); // NULL si no hay archivo
    $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
    $dao->setProperty("directorio", $directorio);
    $dao->setProperty("tamano", $tamano);
    $dao->setProperty("ext", $ext);

    $result1 = $dao->insert();

    if ($result1['success']) {
        return BaseResponse::success($result1['id']);
    } else {
        return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
    }
}


    public static function trae_archivo_adicional($lista)
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT codigo
                FROM configurations
                WHERE categoria = :lista
                AND descripcion = 'ARCHIVOS ADICIONALES'
            SQL,
            array("lista" => $lista),
            true,
            "N"
        );
        //print_r($result);
        return $result;
    }



public static function new_adjuntos_sol_auto(
    $id_sol, 
    $usuario,
    $contactar_empleador,
    $instituciones,
    $grabacion,
    $registro_foto,
    $acepto,
    $fch_candidato_auto
) {
    $id_solicitud = $id_sol;
    $username = $usuario;

    // Variables por defecto para archivo
    $nombre = "";
    $nuevo_nombre_archivo = "";
    $directorio = "";
    $tamano = 0;
    $extension_archivo_origen = "";

    // Si hay archivo cargado y no está vacío
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === 0 && $_FILES['archivo']['size'] > 0) {
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $extension_archivo_origen = strrchr($nombre, ".");
        $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

        // Subir archivo
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result = $miObjetoArchivo->uploadFile_adjuntos_sol_auto($username, $nuevo_nombre_archivo);

        if ($result != null) {
            $directorio = $result;
        }
    }

    // Crear y guardar el objeto (siempre)
    $dao = new SolAuto();
    $dao->setProperty("id_solicitud", $id_solicitud);
    $dao->setProperty("usuario", $username);
    $dao->setProperty("contactar_empleador", $contactar_empleador);
    $dao->setProperty("instituciones", $instituciones);
    $dao->setProperty("grabacion", $grabacion);
    $dao->setProperty("registro_foto", $registro_foto);
    $dao->setProperty("acepto", $acepto);
    $dao->setProperty("fch_candidato_auto", $fch_candidato_auto);
    $dao->setProperty("nombre_firma", $nombre);
    $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
    $dao->setProperty("directorio", $directorio);
    $dao->setProperty("tamano", $tamano);
    $dao->setProperty("ext", $extension_archivo_origen);

    $result1 = $dao->insert();

    if ($result1['success']) {
        return BaseResponse::success($result1);
    } else {
        return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
    }
}



    
/*
    //crea archivo adjunto estudio de confiabilidad sin cifin
    public static function new_ec_sin_cifin($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_ec_sin_cifin($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }

    //crea archivo adjunto estudio de basico cifin
    public static function new_eb_cons_cifin($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_eb_cons_cifin($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }
    //crea archivo adjunto estudio de basico consulta
    public static function new_eb_consulta($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_eb_consulta($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }

    //crea archivo adjunto estudio de confiabilidad sin cifin
    public static function new_pol_pre($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_pol_pre($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }

    //crea archivo adjunto estudio de confiabilidad sin cifin
    public static function new_pol_rutina($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_pol_rutina($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }

    //crea archivo adjunto estudio de confiabilidad sin cifin
    public static function new_pol_especifico($accion_candidato, $id_sol, $id_servicio, $tipo_docp, $observacion = null)
    {
        $id_solicitud = $id_sol;
        $tipo_doc = $tipo_docp;
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
        $nombre = $_FILES['archivo']['name'];

        $miObjetoIdSolicitud = new CtrSolAdjuntos();
        $nomEmpresa = $miObjetoIdSolicitud->trae_Id_Empresa($id_solicitud);

        //Se saca el valor que viene del array que es el nombre de la empresa
        $nom_empre = $nomEmpresa['razon_social'];

        //uploadFile le mando como argumento el nombre de la empresa y el id de la solicitud
        $miObjetoArchivo = new CtrSolAdjuntos();
        $result =  $miObjetoArchivo->uploadFile_pol_especifico($nom_empre, $id_solicitud, $id_servicio);

        $result1 = null;

        if ($result != null) {
            $directorio = $result;

            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($nombre) || $nombre == "")
                return Result::error(__FUNCTION__, "nombre archivo es requerido");

            if (!isset($directorio) || $directorio == "")
                return Result::error(__FUNCTION__, "directorio es requerido");

            if (!isset($ext) || $ext == "")
                return Result::error(__FUNCTION__, "extension es requerido");

            if (!isset($tamano) || $tamano == "")
                return Result::error(__FUNCTION__, "tamano es requerido");

            // if (!isset($tipo_doc) || $tipo_doc == "")
            //     return Result::error(__FUNCTION__, "tipo documento es requerido");   

            $extension_archivo_origen = strrchr($nombre, ".");
            $nuevo_nombre_archivo = md5(date("dmYhisA")) . $extension_archivo_origen;

            $dao = new SolAdjuntos();
            $dao->setProperty('id_solicitud', $id_solicitud);
            $dao->setProperty('id_servicio', $id_servicio);
            $dao->setProperty("nombre", $nombre);
            $dao->setProperty("nombre_encr", $nuevo_nombre_archivo);
            $dao->setProperty("directorio", $directorio);
            $dao->setProperty("tamano", $tamano);
            $dao->setProperty("observacion", $observacion);
            $dao->setProperty("tipo_doc", $tipo_doc);
            $dao->setProperty("ext", $extension_archivo_origen);

            $result1 =  $dao->insert();
        }

        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }
*/
    //Trae el nombre de la empresa y retorna el nombre de la empresa
    public static function trae_Id_Empresa($id_solicitud)
    {

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
            true,
            "N"
        );

        return $result;
    }
    
        //Trae el nombre de la empresa y retorna el tipo de documento
        public static function descripcionAdjunto($id_solicitud){

        $result = QuerySQL::select(
            <<<SQL
                    select sa.*, c.descripcion 
                    from sol_adjuntos sa, configurations c
                    where sa.id_solicitud = :id_solicitud
                    and sa.id_servicio is NULL 
                    and sa.tipo_doc = c.codigo
                    and c.categoria = 'tipo_adjuntos';
                SQL,
                array("id_solicitud" => $id_solicitud),
                true,
                "N"
            );
    
            return Result::success($result, "buscar documentos digitales");
    
        }
/*
        //Trae el nombre de la empresa y retorna el tipo de documento
        public static function descripcionAdjuntoVisitaIngreso($id_solicitud/*, $id_servicio){

            $result = QuerySQL::select(
                <<<SQL
                    select sa.id_adjunto,
                    	   sa.id_solicitud,
                    	   sa.id_servicio,
                    	   sa.nombre,
                    	   sa.nombre_encr,
                    	   sa.directorio,
                    	   sa.tipo_doc,
                    	   sa.tamano,
                    	   sa.ext,
                    	   sa.observacion,
                    	   fcn_desc_configurations('tipo_adjuntos_visita_ingreso', sa.tipo_doc) descripcion
                    from sol_adjuntos sa
                    where sa.id_solicitud = :id_solicitud
                    -- and sa.id_servicio = :id_servicio
                    SQL,
            array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio),
                    true,
                    "N"
                );
        
                return Result::success($result, "buscar documentos digitales");
        
        }
            
        //Trae el nombre de la empresa y retorna el tipo de documento
        public static function descripcionAdjuntoVisitaTeletrabajo($id_solicitud/*, $id_servicio){

            $result = QuerySQL::select(
                <<<SQL
                    select sa.id_adjunto,
                    	   sa.id_solicitud,
                    	   sa.id_servicio,
                    	   sa.nombre,
                    	   sa.nombre_encr,
                    	   sa.directorio,
                    	   sa.tipo_doc,
                    	   sa.tamano,
                    	   sa.ext,
                    	   sa.observacion,
                    	   fcn_desc_configurations('tipo_adjuntos_visita_teletrabajo', sa.tipo_doc) descripcion
                    from sol_adjuntos sa
                    where sa.id_solicitud = :id_solicitud
                    -- and sa.id_servicio = :id_servicio
                    SQL,
            array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio),
                    true,
                    "N"
                );
        
                return Result::success($result, "buscar documentos digitales");
        
        }

        public static function descripcionAdjuntoVisitaAsociado($id_solicitud/*, $id_servicio){

            $result = QuerySQL::select(
                <<<SQL
                    select sa.id_adjunto,
                    	   sa.id_solicitud,
                    	   sa.id_servicio,
                    	   sa.nombre,
                    	   sa.nombre_encr,
                    	   sa.directorio,
                    	   sa.tipo_doc,
                    	   sa.tamano,
                    	   sa.ext,
                    	   sa.observacion,
                    	   fcn_desc_configurations('tipo_adjuntos_visita_asociado', sa.tipo_doc) descripcion
                    from sol_adjuntos sa
                    where sa.id_solicitud = :id_solicitud
                    -- and sa.id_servicio = :id_servicio
                    SQL,
            array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio),
                    true,
                    "N"
                );
        
                return Result::success($result, "buscar documentos digitales");
        
        }
*/
    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionAdjuntos($id_solicitud/*, $id_servicio*/){

        $result = QuerySQL::select(
            <<<SQL
                select sa.id_adjunto,
                        sa.id_solicitud,
                        sa.id_servicio,
                        sa.nombre,
                        sa.nombre_encr,
                        sa.directorio,
                        sa.tipo_doc,
                        sa.tamano,
                        sa.ext,
                        sa.observacion,
                        fcn_desc_configurations(sa.lista, sa.tipo_doc) descripcion
                from sol_adjuntos sa
                where sa.id_solicitud = :id_solicitud
                 -- and sa.id_servicio = :id_servicio
                SQL,
        array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio*/),
                true,
                "N"
            );

            return Result::success($result, "buscar documentos digitales");

    }

    public static function descripcionAdjuntosValida($id_solicitud/*, $id_servicio*/){

        $result = QuerySQL::select(
            <<<SQL
                SELECT sa.*, c.descripcion  
                FROM sol_adjuntos sa, configurations c 
                WHERE 1 = 1
                AND c.codigo = sa.tipo_doc 
                AND c.observacion = 'GEO'
                AND id_solicitud = :id_solicitud;
                SQL,
                array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio*/),
                true,
                "N"
            );

            return Result::success($result, "buscar documentos digitales");

    }
    public static function descripcionAdjuntosValidaTel($id_solicitud/*, $id_servicio*/){

        $result = QuerySQL::select(
            <<<SQL
                SELECT sa.*, c.descripcion  
                FROM sol_adjuntos sa, configurations c 
                WHERE 1 = 1
                AND c.codigo = sa.tipo_doc 
                AND c.observacion = 'TEL'
                AND id_solicitud = :id_solicitud;
                SQL,
                array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio*/),
                true,
                "N"
            );

            return Result::success($result, "buscar documentos digitales");

    }
/*
    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionAdjuntoPOP($id_solicitud/*, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                select sa.id_adjunto,
                        sa.id_solicitud,
                        sa.id_servicio,
                        sa.nombre,
                        sa.nombre_encr,
                        sa.directorio,
                        sa.tipo_doc,
                        sa.tamano,
                        sa.ext,
                        sa.observacion,
                        fcn_desc_configurations('tipo_adjuntos_pol_pre', sa.tipo_doc) descripcion
                from sol_adjuntos sa
                where sa.id_solicitud = :id_solicitud
                -- and sa.id_servicio = :id_servicio
                SQL,
        array("id_solicitud" => $id_solicitud/*, "id_servicio" => $id_servicio),
                true,
                "N"
            );

            return Result::success($result, "buscar documentos digitales");

    }
*/
    //subir archivo hoja de vida alejoo
    /*public static function uploadFile($nom_empre, $id_solicitud)
    {
        $empresa =  CtrSolAdjuntos::limpiar_cadena($nom_empre);
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/sol_$id_solicitud";

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
        if (($tamano > 0 && $tamano < 8000000) || $ext == 'image/jpg' || $ext == 'pdf') {
            // El archivo es pequeño o es JPEG, no es necesario comprimir
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
                return $nuevodirectorio;
            } else {
                return null; // Error al mover el archivo
            }
        } elseif ($tamano >= 8000000 && $ext == 'image/png') {
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
    }*/
    public static function uploadFile($nom_empre, $id_solicitud, $file_encrip)
    {
        $empresa = CtrSolAdjuntos::limpiar_cadena($nom_empre);
        $dia = date("d");
        $mes = date("m");
        $anno = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/sol_$id_solicitud";
    
        $tamano = $_FILES['archivo']['size'];
        $ext = $_FILES['archivo']['type'];
    
        if (!file_exists($nuevodirectorio)) {
            mkdir($nuevodirectorio, 0775, true);
        }
    
        $uploaddir = "$nuevodirectorio/";
        $uploadfile = $uploaddir . $file_encrip;
    
        // Verificar el tamaño y el tipo del archivo
        if (($tamano > 0 && $tamano < 8000000) || $ext == 'image/jpg' || $ext == 'pdf') {
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
                return $nuevodirectorio;
            } else {
                return null;
            }
        } elseif ($tamano >= 8000000 && $ext == 'image/png') {
            $quality = 5;
            if (self::compressImage($_FILES['archivo']['tmp_name'], $uploadfile, $quality)) {
                return $nuevodirectorio;
            } else {
                unlink($uploadfile);
                return null;
            }
        } else {
            return null;
        }
    }
    
/*
    //subir archivo visita ingreso
    public static function uploadFile_visita_ingreso($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/vsi_$id_servicio";

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
*/
/*
    //subir archivo visita ingreso
    public static function uploadFile_visita_mantenimiento($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/vsm_$id_servicio";

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
*/
/*
    //subir archivo visita teletrabajo
    public static function uploadFile_visita_teletrabajo($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/vst_$id_servicio";

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
*/
/*
    //subir archivo visita asociado
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
*/
    //subir archivo estudio de confiabilidad con cifin
/*    public static function uploadFile_adjuntos($nom_empre, $id_solicitud, $id_servicio)
    {   
        $servicio="";
        switch ($id_servicio) {
            case 1:
                $servicio="ant_$id_servicio";
                break;
            case 3:
                $servicio="vsi_$id_servicio";
                break;
            case 4:
                $servicio="vsm_$id_servicio";
                break;
            case 5:
                $servicio="vst_$id_servicio";
                break;
            case 6:
                $servicio="laboral_$id_servicio";
                break;
            case 7:
                $servicio="academica_$id_servicio";
                break;
            case 8:
                $servicio="pol_pre_$id_servicio";
                break;
            case 9:
                $servicio="pol_rutina_$id_servicio";
                break;
            case 10:
                $servicio="pol_especifico_$id_servicio";
                break;
            case 11:
                $servicio="cifin_$id_servicio";
                break;
            case 12:
                $servicio="vsa_$id_servicio";
                break;
            default:
                echo "La opción no es válida";
        }

        $empresa =  CtrSolAdjuntos::limpiar_cadena($nom_empre);
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/sol_$id_solicitud/$servicio";

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
        if (($tamano > 0 && $tamano < 8000000) || $ext == 'image/jpg' || $ext == 'pdf') {
            // El archivo es pequeño o es JPEG, no es necesario comprimir
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
                return $nuevodirectorio;
            } else {
                return null; // Error al mover el archivo
            }
        } elseif ($tamano >= 8000000 && $ext == 'image/png') {
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
    }*/

    //funcion de archivos que funciona alejo prueba
public static function uploadFile_adjuntos($nom_empre, $id_solicitud, $id_servicio, $file_encrip)
{
    // Determinar nombre del subdirectorio por servicio
    $servicios = [
        1 => 'ant', 3 => 'vsi', 4 => 'vsm', 5 => 'vst', 6 => 'laboral',
        7 => 'academica', 8 => 'pol_pre', 9 => 'pol_rutina', 10 => 'pol_especifico',
        11 => 'cifin', 12 => 'vsa'
    ];

    if (!isset($servicios[$id_servicio])) {
        return "La opción no es válida";
    }

    $servicio = $servicios[$id_servicio] . "_$id_servicio";
    $empresa = CtrSolAdjuntos::limpiar_cadena($nom_empre);
    $anno = date("y");
    $mes = date("m");
    $dia = date("d");

    $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/sol_$id_solicitud/$servicio";
    if (!file_exists($nuevodirectorio)) {
        mkdir($nuevodirectorio, 0775, true);
    }

    $file = $_FILES['archivo'];
    $nombre = $file['name'];
    $tmpPath = $file['tmp_name'];
    $tamano = $file['size'];
    $mime = $file['type'];
    $ext = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
    $uploadfile = "$nuevodirectorio/$file_encrip";

    // Extensiones y MIME permitidos
    $ext_permitidas = ['jpg', 'jpeg', 'png', 'pdf'];
    $mime_permitidos = ['image/jpeg', 'image/png', 'application/pdf'];

    // Validar tipo y tamaño
    if (!in_array($ext, $ext_permitidas) || !in_array($mime, $mime_permitidos)) {
        error_log("Tipo de archivo no permitido: $ext ($mime)");
        return null;
    }

    if ($tamano > 8000000) { // > 8MB
        error_log("Archivo demasiado grande: $tamano bytes");
        return null;
    }

    // Procesar imágenes
    if (strpos($mime, 'image/') === 0) {
        $quality = 70;
        if (self::compressImage($tmpPath, $uploadfile, $quality)) {
            return $nuevodirectorio;
        } else {
            error_log("Error al comprimir imagen");
            return null;
        }
    }

    // Procesar PDFs
    if ($mime === 'application/pdf') {
        if (move_uploaded_file($tmpPath, $uploadfile)) {
            return $nuevodirectorio;
        } else {
            error_log("Error al mover archivo PDF: $tmpPath");
            return null;
        }
    }

    return null;
}



public static function uploadFile_adjuntos_multiple($nom_empre, $id_solicitud, $id_servicio, $file_encrip, $file)
{
    $servicios = [
        1 => 'ant', 3 => 'vsi', 4 => 'vsm', 5 => 'vst', 6 => 'laboral',
        7 => 'academica', 8 => 'pol_pre', 9 => 'pol_rutina',
        10 => 'pol_especifico', 11 => 'cifin', 12 => 'vsa'
    ];

    if (!isset($servicios[$id_servicio])) return null;
    $servicio = $servicios[$id_servicio] . "_$id_servicio";

    $empresa = CtrSolAdjuntos::limpiar_cadena($nom_empre);
    $fecha = date("Y/m/d");
    list($anno, $mes, $dia) = explode("/", $fecha);

    $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/sol_$id_solicitud/$servicio";
    if (!file_exists($nuevodirectorio)) mkdir($nuevodirectorio, 0775, true);

    $tmpPath = $file['tmp_name'];
    $mimeType = $file['type'];
    $uploadfile = "$nuevodirectorio/$file_encrip";

    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $quality = 70;

    // 🖼️ Si es imagen, comprime
    if (in_array($mimeType, $allowedImageTypes)) {
        return self::compressImage($tmpPath, $uploadfile, $quality)
            ? $nuevodirectorio : null;
    }

    // 📄 Si es PDF
    if ($mimeType === 'application/pdf') {
        if (!move_uploaded_file($tmpPath, $uploadfile)) {
            error_log("Error moviendo PDF: $tmpPath → $uploadfile");
            return null;
        }

        // ⚠️ Procesar con Ghostscript si está disponible
        $gsPath = trim(shell_exec('which gs'));
        if ($gsPath) {
            $tempOut = $uploadfile . "_opt.pdf";
            $cmd = "$gsPath -sDEVICE=pdfwrite -dCompatibilityLevel=1.6 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=" . escapeshellarg($tempOut) . " " . escapeshellarg($uploadfile);
            exec($cmd, $output, $exitCode);

            if ($exitCode === 0 && file_exists($tempOut)) {
                rename($tempOut, $uploadfile);
            } else {
                error_log("Ghostscript error o ausente, PDF guardado sin compresión.");
            }
        }

        return $nuevodirectorio;
    }

    // ❌ Tipo no permitido
    error_log("Tipo de archivo no permitido: $mimeType");
    return null;
}


    public static function uploadFile_adjuntos_auto($nom_empre, $file_encrip)
    {
    
        $empresa = CtrSolAdjuntos::limpiar_cadena($nom_empre);
        $fecha = date("y/m/d");
        list($anno, $mes, $dia) = explode("/", $fecha);
        $nuevodirectorio = "upload/arch_adjuntos/$anno/$mes/$empresa/autotizacion";
    
        if (!file_exists($nuevodirectorio)) {
            mkdir($nuevodirectorio, 0775, true);
        }
    
        $file = $_FILES['archivo'];
        $ext = $file['type'];
        $uploadfile = "$nuevodirectorio/$file_encrip";

        $tmpPath = $file['tmp_name'];

    
        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $quality = 70;
    
        if (in_array($ext, $allowedImageTypes)) {
            if (self::compressImage($file['tmp_name'], $uploadfile, $quality)) {
                return $nuevodirectorio;
            } else {
                return null;
            }
        } elseif ($ext === 'application/pdf') {
            $uploadTemp = $uploadfile . "_original.pdf";

            if (move_uploaded_file($tmpPath, $uploadTemp)) {
                $comando = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.6 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=" . escapeshellarg($uploadfile) . " " . escapeshellarg($uploadTemp);
                exec($comando, $output, $exitCode);

                if ($exitCode === 0) {
                    unlink($uploadTemp);
                    return $nuevodirectorio;
                } else {
                    error_log("Ghostscript error: " . implode("\n", $output));
                    return null;
                }
            } else {
                error_log("No se pudo mover el archivo: $tmpPath -> $uploadTemp");
                return null;
            }
        } else {
            return null;
        }
    }

    public static function uploadFile_adjuntos_sol_auto($usuario, $file_encrip)
    {
    
        $empresa = CtrSolAdjuntos::limpiar_cadena($usuario);
        $fecha = date("y/m/d");
        list($anno, $mes, $dia) = explode("/", $fecha);
        $nuevodirectorio = "upload/arch_adjuntos/autotizacion/$anno/$mes/$usuario";
    
        if (!file_exists($nuevodirectorio)) {
            mkdir($nuevodirectorio, 0775, true);
        }
    
        $file = $_FILES['archivo'];
        $ext = $file['type'];
        $uploadfile = "$nuevodirectorio/$file_encrip";

        $tmpPath = $file['tmp_name'];

    
        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $quality = 70;
    
        if (in_array($ext, $allowedImageTypes)) {
            if (self::compressImage($file['tmp_name'], $uploadfile, $quality)) {
                return $nuevodirectorio;
            } else {
                return null;
            }
        } elseif ($ext === 'application/pdf') {
            $uploadTemp = $uploadfile . "_original.pdf";

            if (move_uploaded_file($tmpPath, $uploadTemp)) {
                $comando = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.6 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=" . escapeshellarg($uploadfile) . " " . escapeshellarg($uploadTemp);
                exec($comando, $output, $exitCode);

                if ($exitCode === 0) {
                    unlink($uploadTemp);
                    return $nuevodirectorio;
                } else {
                    error_log("Ghostscript error: " . implode("\n", $output));
                    return null;
                }
            } else {
                error_log("No se pudo mover el archivo: $tmpPath -> $uploadTemp");
                return null;
            }
        } else {
            return null;
        }
    }


    
/*
    //subir archivo estudio de confiabilidad sin cifin
    public static function uploadFile_ec_sin_cifin($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/esc_$id_servicio";

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
*/
/*
    //subir archivo estudio de confiabilidad sin cifin
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
*/
/*
    //subir archivo estudio de confiabilidad sin cifin
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
*/
/*
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
*/
/*
    //subir archivo estudio de confiabilidad sin cifin
    public static function uploadFile_eb_cons_cifin($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/ebc_$id_servicio";

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
*/
/*    //subir archivo estudio de confiabilidad sin cifin
    public static function uploadFile_eb_consulta($nom_empre, $id_solicitud, $id_servicio)
    {
        $max             = 8000718;
        $dia            = date("d");
        $mes            = date("m");
        $anno            = date("y");
        $nuevodirectorio = "upload/arch_adjuntos/$nom_empre/$anno/$mes/$dia/sol_$id_solicitud/ebco_$id_servicio";

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
*/
    public static function update(
        $id_adjunto,
        $id_solicitud,
        $id_servicio,
        $nombre,
        $directorio,
        $tipo_doc,
        $ext
    ) {
        if (!isset($id_adjunto) || $id_adjunto == "")
            return Result::error(__FUNCTION__, "id_adjunto es requerido");
        if (!is_numeric($id_adjunto))
            return Result::error(__FUNCTION__, "id debe ser numerico");

        if (!isset($nombre) || $nombre == "")
            return Result::error(__FUNCTION__, "nombre_archivo es requerido");

        if (!isset($directorio) || $directorio == "")
            return Result::error(__FUNCTION__, "directorio es requerido");

        if (!isset($tipo_doc) || $tipo_doc == "")
            return Result::error(__FUNCTION__, "tipo documento es requerido");

        if (!isset($ext) || $ext == "")
            return Result::error(__FUNCTION__, "extension es requerido");

        $dao = new SolAdjuntos($id_adjunto);
        $dao->setProperty('id_solicitud', $id_solicitud);
        $dao->setProperty('id_servicio', $id_servicio);
        $dao->setProperty("nombre", $nombre);
        $dao->setProperty("directorio", $directorio);
        $dao->setProperty("tipo_doc", $tipo_doc);
        $dao->setProperty("ext", $ext);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll()
    {
        $result = new SolAdjuntos();
        $result = $result->selectAll();

        return Result::success($result, "buscar documentos digitales");
    }

    public static function findById($id_adjunto)
    {
        if (!isset($id_adjunto) || $id_adjunto == "")
            return Result::error(__FUNCTION__, "id_adjunto es requerido");

        $result = new SolAdjuntos($id_adjunto);
        $result->setProperty('fullpath', $result->getProperty('directorio') . $result->getProperty('nombre'));
        $result = $result->getThisAllProperties();

        return Result::success($result, "buscar documento digital");
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


    //prueba findById
    public static function findByIdDoc($id_adjunto)
    {
        if (!isset($id_adjunto) || $id_adjunto == "")
            return Result::error(__FUNCTION__, "id es requerido");
        if (!is_numeric($id_adjunto))
            return Result::error(__FUNCTION__, "id debe ser numerico");

        $result = QuerySQL::select(
            <<<SQL
                select sa.id_adjunto, sa.directorio, sa.nombre_encr 
                       from sol_adjuntos sa
                       where sa.id_adjunto = :id_adjunto;
                SQL,
            array("id_adjunto" => $id_adjunto),
            false,
            "N"
        );

        return $result;
    }

    public static function findByAllBySolicitud($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select  sa.id_adjunto , sa.id_solicitud , sa.id_servicio , sa.nombre , sa.nombre_encr, sa.directorio , sa.observacion
                from sol_adjuntos sa 
                where id_solicitud = :id_solicitud
                 and id_servicio is null;
            SQL,
            array(
                "id_solicitud" => $id_solicitud
            ),
            true,
            "S"
        );

        return Result::success($result, "buscar archivos por solicitud");
    }

    public static function findByAllByServicio($id_solicitud, $id_servicio)
    {
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select  sa.id_adjunto , sa.id_solicitud , sa.id_servicio , sa.nombre , sa.nombre_encr, sa.directorio , sa.observacion
                from sol_adjuntos sa 
                where id_solicitud = :id_solicitud
                  and id_servicio = :id_servicio;
            SQL,
            array(
                "id_solicitud" => $id_solicitud,
                "id_servicio" => $id_servicio
            ),
            true,
            "S"
        );

        return Result::success($result, "buscar archivos por servicio");
    }

    public static function findByClienteSolicitud($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                SELECT ss.id_empresa
                FROM sol_solicitud ss 
                WHERE ss.id_solicitud = :id_solicitud 
            SQL,
            array(
                "id_solicitud" => $id_solicitud
            ),
            true,
            "S"
        );

        return Result::success($result, "buscar id cliente");
    }
    //Valida las variables para la dimension financiero-economica
    public static function ExiteVariable($id_pregunta, $id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from sol_adjuntos dr 
                    where dr.tipo_doc = :id_pregunta
                    and dr.id_solicitud = :id_solicitud
                    and dr.id_servicio = :id_servicio
            SQL,
            array("id_pregunta" => $id_pregunta,
                  "id_solicitud" => $id_solicitud,
                  "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }//Fin listar las preguntas del candidato para la dimension financiero
    public static function mostrarArchivo($archivo) {
        // Obtén la ruta completa desde la raíz del proyecto
        // Verificar si el archivo existe
        if (file_exists($archivo)) {

            // Verificar los permisos de lectura
            if (is_readable($archivo)) {

                // Verificar los permisos de ejecución (para directorios)
                if (is_dir(dirname($archivo)) && is_executable(dirname($archivo))) {

                    // Abre el archivo
                    $contenido = file_get_contents($archivo);

                    // Haz lo que necesites con el contenido
                    echo $contenido;
                    return Result::success($contenido, "Archivo");

                } else {
                    echo "No tienes permisos para ejecutar el directorio.";
                }

            } else {
                echo "No tienes permisos de lectura para el archivo.";
            }

        } else {
            echo "El archivo no existe.";
        }
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
/*
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
*/
public static function compressImage($source, $destination, $quality)
{
    $info = getimagesize($source);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
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
            return false;
    }

    // Tamaño deseado
    $new_width = 959;
    $new_height = 1280;

    // Crear imagen redimensionada
    $resized = imagecreatetruecolor($new_width, $new_height);

    // ✅ Preservar transparencia para PNG y GIF
    if ($mime === 'image/png' || $mime === 'image/gif') {
        imagecolortransparent($resized, imagecolorallocatealpha($resized, 0, 0, 0, 127));
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
    }

    // Redimensionar
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $new_width, $new_height, imagesx($image), imagesy($image));

    // Corregir orientación solo para JPEG
    if (($mime === 'image/jpeg' || $mime === 'image/jpg') && function_exists('exif_read_data')) {
        $exif = @exif_read_data($source);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3:
                    $resized = imagerotate($resized, 180, 0);
                    break;
                case 6:
                    $resized = imagerotate($resized, -90, 0);
                    break;
                case 8:
                    $resized = imagerotate($resized, 90, 0);
                    break;
            }
        }
    }

    // Guardar imagen
    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            imagejpeg($resized, $destination, $quality);
            break;
        case 'image/png':
            imagepng($resized, $destination, 9 - round($quality / 10)); // de 0 (mejor calidad) a 9 (más comprimido)
            break;
        case 'image/gif':
            imagegif($resized, $destination);
            break;
    }

    imagedestroy($image);
    imagedestroy($resized);

    return true;
}








}
