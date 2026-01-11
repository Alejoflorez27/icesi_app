<?php

class CtrSolFamiliar
{
    //Crear una formacion academica
    public static function crear($id_solicitud, $id_servicio, $id_ciudad_act, $parentesco, $nombre, $apellido, $edad, $estado_civil,
                                 $nivel_escolar, $ocupacion, $empresa,
                                 $viv_candidato, $depende_candidato, $telefono, $residencia)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        /*if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");*/

        $obj_solFamilia = new SolFamiliar();
        $obj_solFamilia->setProperty('id_solicitud', $id_solicitud);
        $obj_solFamilia->setProperty('id_servicio', $id_servicio);
        $obj_solFamilia->setProperty('id_ciudad_act', $id_ciudad_act);
        $obj_solFamilia->setProperty('parentesco', $parentesco);
        $obj_solFamilia->setProperty('nombre', $nombre);
        $obj_solFamilia->setProperty('apellido', $apellido);
        $obj_solFamilia->setProperty('edad', $edad);
        $obj_solFamilia->setProperty('estado_civil', $estado_civil);
        $obj_solFamilia->setProperty('nivel_escolar', $nivel_escolar);
        $obj_solFamilia->setProperty('ocupacion', $ocupacion);
        $obj_solFamilia->setProperty('empresa', $empresa);
        $obj_solFamilia->setProperty('viv_candidato', $viv_candidato);
        $obj_solFamilia->setProperty('depende_candidato', $depende_candidato);
        $obj_solFamilia->setProperty('telefono', $telefono);
        $obj_solFamilia->setProperty('residencia', $residencia);

        $result = $obj_solFamilia->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una formacion academica

    //Crear una familiar academica visita ingreso
    public static function crearVisitaIngreso($id_solicitud, $id_servicio, $id_ciudad_act, $parentesco, $nombre, $apellido, $edad, $estado_civil,
                                 $nivel_escolar, $ocupacion, $empresa,
                                 $viv_candidato, $depende_candidato, $telefono, $horario, $identificacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_solFamilia = new SolFamiliar();
        $obj_solFamilia->setProperty('id_solicitud', $id_solicitud);
        $obj_solFamilia->setProperty('id_servicio', $id_servicio);
        $obj_solFamilia->setProperty('id_ciudad_act', $id_ciudad_act);
        $obj_solFamilia->setProperty('parentesco', $parentesco);
        $obj_solFamilia->setProperty('nombre', $nombre);
        $obj_solFamilia->setProperty('apellido', $apellido);
        $obj_solFamilia->setProperty('edad', $edad);
        $obj_solFamilia->setProperty('estado_civil', $estado_civil);
        $obj_solFamilia->setProperty('nivel_escolar', $nivel_escolar);
        $obj_solFamilia->setProperty('ocupacion', $ocupacion);
        $obj_solFamilia->setProperty('empresa', $empresa);
        $obj_solFamilia->setProperty('viv_candidato', $viv_candidato);
        $obj_solFamilia->setProperty('depende_candidato', $depende_candidato);
        $obj_solFamilia->setProperty('telefono', $telefono);
        $obj_solFamilia->setProperty('horario', $horario);
        $obj_solFamilia->setProperty('identificacion', $identificacion);

        $result = $obj_solFamilia->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una familiar visita ingreso

    //Crear una familiar academica visita mantenimiento
    public static function crearVisitaMantenimiento($id_solicitud, $id_servicio, $id_ciudad_act, $parentesco, $nombre, $apellido, $edad, $estado_civil,
                                 $nivel_escolar, $ocupacion,
                                 $viv_candidato, $depende_candidato, $telefono, $identificacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_solFamilia = new SolFamiliar();
        $obj_solFamilia->setProperty('id_solicitud', $id_solicitud);
        $obj_solFamilia->setProperty('id_servicio', $id_servicio);
        $obj_solFamilia->setProperty('id_ciudad_act', $id_ciudad_act);
        $obj_solFamilia->setProperty('parentesco', $parentesco);
        $obj_solFamilia->setProperty('nombre', $nombre);
        $obj_solFamilia->setProperty('apellido', $apellido);
        $obj_solFamilia->setProperty('edad', $edad);
        $obj_solFamilia->setProperty('estado_civil', $estado_civil);
        $obj_solFamilia->setProperty('nivel_escolar', $nivel_escolar);
        $obj_solFamilia->setProperty('ocupacion', $ocupacion);
        $obj_solFamilia->setProperty('viv_candidato', $viv_candidato);
        $obj_solFamilia->setProperty('depende_candidato', $depende_candidato);
        $obj_solFamilia->setProperty('telefono', $telefono);
        $obj_solFamilia->setProperty('identificacion', $identificacion);

        $result = $obj_solFamilia->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una familiar visita mantenimiento

    //listar los estudios del candidato
    public static function findAll($estado = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select  sf.id_familia ,sf.id_solicitud, sf.id_ciudad_act , sf.parentesco, fcn_desc_configurations('tipo_parentesco', sf.parentesco) des_parentesco,
                sf.nombre, sf.apellido, sf.edad, sf.estado_civil, fcn_desc_configurations('tipo_estado_civil', sf.estado_civil) des_est_civil,
                sf.nivel_escolar, fcn_desc_configurations('tipo_nivel_escolar', sf.nivel_escolar) des_nvl_escolar, sf.ocupacion, sf.empresa, 
                sf.viv_candidato, sf.depende_candidato, sf.residencia, sf.telefono 
                    from sol_familiar sf , sol_candidato sc 
                    where sf.id_solicitud  = sc.id_solicitud   
            SQL,
            null,
            true,
            "N"
        );

        return Result::success($result, "buscar familiar");
    }//Fin de listar los estudios del candidato

    //Editar un registro de formacion academica del candidato
    public static function findByIdFamilia($id_familia)
    {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                sf.id_familia,
                sf.id_solicitud,
                sf.id_ciudad_act,
                sf.nivel_escolar,
                sf.nombre,
                sf.apellido,
                sf.identificacion,
                sf.edad,
                sf.estado_civil,
                sf.ocupacion,
                sf.empresa,
                sf.viv_candidato,
                sf.depende_candidato,
                sf.telefono,
                sf.residencia,
                sf.parentesco,
                sf.fch_create,
                sf.usr_create,
                cc.id_dpto,
                cd.id_pais
            FROM sol_familiar sf
            JOIN sol_solicitud sc ON sf.id_solicitud = sc.id_solicitud
            LEFT JOIN conf_ciudad cc ON sf.id_ciudad_act = cc.id_ciudad
            LEFT JOIN conf_dpto cd ON cc.id_dpto = cd.id_dpto
            LEFT JOIN conf_pais cp ON cd.id_pais = cp.id_pais
            WHERE sf.id_familia = :id_familia;

            SQL,
            array("id_familia" => $id_familia),
            false,
            "N"
        );

        return Result::success($result, "buscar familia");
    }//Fin de Editar un registro de formacion academica del candidato


    //Editar un registro de formacion academica del candidato
    public static function findByIdFamiliaTeletrabajo($id_familia)
    {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sf.id_familia, sf.id_solicitud, sf.id_ciudad_act, sf.nivel_escolar, sf.nombre, sf.ocupacion, sf.empresa, 
                       sf.viv_candidato, sf.depende_candidato, sf.telefono, sf.residencia, sf.apellido,sf.identificacion, sf.parentesco, sf.edad,
                       sf.estado_civil, sf.horario, sf.fch_create, sf.usr_create
                    from sol_familiar sf, sol_solicitud sc
                    where sf.id_solicitud  = sc.id_solicitud
                    and  sf.id_familia  = :id_familia

            SQL,
            array("id_familia" => $id_familia),
            false,
            "N"
        );

        return Result::success($result, "buscar familia");
    }//Fin de Editar un registro de formacion academica del candidato

    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionFamiliarCandidato($id_solicitud){

        $result = QuerySQL::select(
            <<<SQL
                    select sf.id_familia,
                        sf.id_solicitud,
                        sf.id_servicio,
                        sf.parentesco as descripcion_parentesco,
                        sf.nombre,
                        sf.apellido,
                        sf.edad,
                        fcn_desc_configurations('tipo_estado_civil', sf.estado_civil) descripcion_estado_civil,
                        fcn_desc_configurations('tipo_nivel_escolar', sf.nivel_escolar) descripcion_niv_escol,
                        sf.ocupacion,
                        sf.empresa,
                        fcn_desc_configurations('tipo_vive_depende_candidato', sf.viv_candidato) viv_candidato,
                        fcn_desc_configurations('tipo_vive_depende_candidato', sf.depende_candidato) depende_candidato,
                        sf.telefono,
                        sf.horario,
                        sf.residencia,
                        cc.nombre as id_ciudad_act,
                        pa.nombre as nombre_pais	   
                    from sol_familiar sf, conf_ciudad cc, conf_dpto dp, conf_pais pa
                    where sf.id_solicitud = :id_solicitud
                    -- and sf.id_servicio = :id_servicio
                    and sf.id_ciudad_act = cc.id_ciudad
                    and cc.id_dpto = dp.id_dpto 
                    and dp.id_pais = pa.id_pais
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
    
        return Result::success($result, "buscar familiares");
    
    }
    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionFamiliar($id_solicitud){

        $result = QuerySQL::select(
            <<<SQL
            SELECT 
                sf.id_familia,
                sf.id_solicitud,
                sf.id_servicio,
                sf.parentesco AS descripcion_parentesco,
                sf.nombre,
                sf.apellido,
                sf.identificacion,
                sf.edad,
                fcn_desc_configurations('tipo_estado_civil', sf.estado_civil) AS descripcion_estado_civil,
                fcn_desc_configurations('tipo_nivel_escolar', sf.nivel_escolar) AS descripcion_niv_escol,
                sf.ocupacion,
                sf.empresa,
                fcn_desc_configurations('tipo_vive_depende_candidato', sf.viv_candidato) AS descripcion_viv_candidato,
                fcn_desc_configurations('tipo_vive_depende_candidato', sf.depende_candidato) AS descripcion_depende_candidato,
                sf.telefono,
                sf.horario,
                COALESCE(cc.nombre, 'Sin ciudad') AS descripcion_ciudad,
                COALESCE(pa.nombre, 'Sin país') AS nombre_pais
            FROM sol_familiar sf
            LEFT JOIN conf_ciudad cc ON sf.id_ciudad_act = cc.id_ciudad
            LEFT JOIN conf_dpto dp ON cc.id_dpto = dp.id_dpto
            LEFT JOIN conf_pais pa ON dp.id_pais = pa.id_pais
            WHERE sf.id_solicitud = :id_solicitud
            -- AND sf.id_servicio = :id_servicio

            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );
    
        return Result::success($result, "buscar familiares");
    
    }

    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionFamiliarTeletrabajo($id_solicitud, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                    select sf.id_familia,
                        sf.id_solicitud,
                        sf.id_servicio,
                        sf.parentesco as descripcion_parentesco,
                        sf.nombre,
                        sf.apellido,
                        sf.identificacion,
                        sf.edad,
                        fcn_desc_configurations('tipo_estado_civil', sf.estado_civil) descripcion_estado_civil,
                        fcn_desc_configurations('tipo_nivel_escolar', sf.nivel_escolar) descripcion_niv_escol,
                        sf.ocupacion,
                        sf.empresa,
                        fcn_desc_configurations('tipo_vive_depende_candidato', sf.viv_candidato) descripcion_viv_candidato,
                        fcn_desc_configurations('tipo_vive_depende_candidato', sf.depende_candidato) descripcion_depende_candidato,
                        sf.telefono,
                        sf.horario 
                    from sol_familiar sf
                    where sf.id_solicitud = :id_solicitud
                    and sf.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar familiares");
    
    }

    //Borrar un registro por id
    public static function delete($id_familia)
    {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolFamiliar($id_familia);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la Familiar
    public static function update(
        $id_familia,
        $id_ciudad_act,
        $parentesco,
        $nombre,
        $apellido,
        $edad,
        $estado_civil,
        $nivel_escolar,
        $ocupacion,
        $empresa,
        $viv_candidato,
        $depende_candidato,
        $telefono,
        $residencia,
        $identificacion

    ) {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolFamiliar($id_familia);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('parentesco', $parentesco);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('ocupacion', $ocupacion);
        $dao->setProperty('empresa', $empresa);
        $dao->setProperty('viv_candidato', $viv_candidato);
        $dao->setProperty('depende_candidato', $depende_candidato);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('residencia', $residencia);
        $dao->setProperty('identificacion', $identificacion);    

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica

    //Actualizar la Familiar pol pre
    public static function update_pol_pre(
        $id_familia,
        $id_ciudad_act,
        $parentesco,
        $nombre,
        $apellido,
        $edad,
        //$estado_civil,
        //$nivel_escolar,
        $ocupacion
        //$viv_candidato,
        //$depende_candidato

    ) {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolFamiliar($id_familia);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('parentesco', $parentesco);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('edad', $edad);
        //$dao->setProperty('estado_civil', $estado_civil);
        //$dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('ocupacion', $ocupacion);
        //$dao->setProperty('viv_candidato', $viv_candidato);
        //$dao->setProperty('depende_candidato', $depende_candidato);  

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar familiar polpre

    //Actualizar la Familiar pol rutina
    public static function update_pol_rutina(
        $id_familia,
        $id_ciudad_act,
        $parentesco,
        $nombre,
        $apellido,
        $edad,
        $estado_civil,
        $nivel_escolar,
        $ocupacion,
        $viv_candidato,
        $depende_candidato

    ) {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolFamiliar($id_familia);
        $dao->setProperty('id_ciudad_act', $id_ciudad_act);
        $dao->setProperty('parentesco', $parentesco);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('estado_civil', $estado_civil);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('ocupacion', $ocupacion);
        $dao->setProperty('viv_candidato', $viv_candidato);
        $dao->setProperty('depende_candidato', $depende_candidato);  

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar familiar pol rutina

    //Actualizar la Familiar
    public static function update_teletrabajo(
        $id_familia,
        $parentesco,
        $nombre,
        $apellido,
        $edad,
        $nivel_escolar,
        $ocupacion,
        $depende_candidato,
        $horario,
        $identificacion


    ) {
        if (!isset($id_familia) || $id_familia == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolFamiliar($id_familia);
        $dao->setProperty('parentesco', $parentesco);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('apellido', $apellido);
        $dao->setProperty('edad', $edad);
        $dao->setProperty('nivel_escolar', $nivel_escolar);
        $dao->setProperty('ocupacion', $ocupacion);
        $dao->setProperty('depende_candidato', $depende_candidato);
        $dao->setProperty('horario', $horario); 
        $dao->setProperty('identificacion', $identificacion);    

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica
}
