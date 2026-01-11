<?php

class CtrVivActivos
{
    //Crear un activo del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $concepto_activo, $otros, $tipo_familiar, $otro_propietario, $descripcion_general_viv, $valor_activo, $valor_activo_catastral)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_vivActivo = new VivActivos();
        $obj_vivActivo->setProperty('id_solicitud', $id_solicitud);
        $obj_vivActivo->setProperty('id_servicio', $id_servicio);
        $obj_vivActivo->setProperty('concepto_activo', $concepto_activo);
        $obj_vivActivo->setProperty('otros', $otros);
        $obj_vivActivo->setProperty('tipo_familiar', $tipo_familiar);
        $obj_vivActivo->setProperty('otro_propietario', $otro_propietario);
        $obj_vivActivo->setProperty('descripcion_general_viv', $descripcion_general_viv);
        $obj_vivActivo->setProperty('valor_activo', $valor_activo);
        $obj_vivActivo->setProperty('valor_activo_catastral', $valor_activo_catastral);
        

        $result = $obj_vivActivo->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una activo de la vivienda

    //listar los activos del funcionario y su familia
    public static function findAllCandidato($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT va.*,
            	   fcn_desc_configurations('tipo_activo_vi', va.concepto_activo) descripcion_tipo_activo,
            	   fcn_desc_configurations('tipo_responsable_egreso_vi', va.tipo_familiar) descripcion_tipo_responsable
              FROM viv_activos va 
             WHERE va.id_solicitud = :id_solicitud
               AND va.id_servicio = :id_servicio 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar activo del funcionario y su familia");
    }//Fin de listar los activos del funcionario
    
    //listar los activos del funcionario y su familia
    public static function findAllFuncionario($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT va.*,
            	   fcn_desc_configurations('tipo_activo_vi', va.concepto_activo) descripcion_tipo_activo,
            	   fcn_desc_configurations('tipo_responsable_egreso_vm', va.tipo_familiar) descripcion_tipo_responsable
              FROM viv_activos va 
             WHERE va.id_solicitud = :id_solicitud
               AND va.id_servicio = :id_servicio 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar activo del funcionario y su familia");
    }//Fin de listar los activos del funcionario

    //listar los activo del candidato y su familia por no exists
    public static function findAllNoExists($tipo_activo_vi)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT * FROM configurations c 
            WHERE categoria = :tipo_activo_vi
            AND estado = 'ACT'
            AND NOT EXISTS (SELECT 1 
                            FROM viv_activos va
                            WHERE va.concepto_activo = c.codigo )
            SQL,
            array("tipo_activo_vi" => $tipo_activo_vi),
            true,
            "N"
        );

        return Result::success($result, "buscar activo del candidato no repetido");
    }//Fin de listar los estudios del candidato

    //Editar un registro de activos  del candidato
    public static function findByIdActivos($id_activo)
    {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select va.*, c.descripcion AS descripcion_tipo_concepto
                    from viv_activos va, sol_solicitud sc, configurations c
                    where va.id_solicitud  = sc.id_solicitud
                    and  va.id_activo  = :id_activo
                    and c.codigo =  va.concepto_activo
                    and c.categoria = 'tipo_activo_vi'
            SQL,
            array("id_activo" => $id_activo),
            false,
            "N"
        );

        return Result::success($result, "buscar activos");
    }//Fin de Editar un registro de activos del candidato

    //Editar un registro de activos  del candidato
    public static function findByIdActivosPolPre($id_activo)
    {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select va.*
                    from viv_activos va, sol_solicitud sc
                    where va.id_solicitud  = sc.id_solicitud
                    and  va.id_activo  = :id_activo

            SQL,
            array("id_activo" => $id_activo),
            false,
            "N"
        );

        return Result::success($result, "buscar activos");
    }//Fin de Editar un registro de activos del candidato
    //Editar un registro de activos  del candidato
    public static function findByIdActivosPolRutina($id_activo)
    {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select va.*
                    from viv_activos va, sol_solicitud sc
                    where va.id_solicitud  = sc.id_solicitud
                    and  va.id_activo  = :id_activo

            SQL,
            array("id_activo" => $id_activo),
            false,
            "N"
        );

        return Result::success($result, "buscar activos");
    }//Fin de Editar un registro de activos del candidato
    //Borrar un registro por id
    public static function delete($id_activo)
    {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivActivos($id_activo);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_activo,
        $concepto_activo,
        $otros,
        $tipo_familiar,
        $otro_propietario,
        $descripcion_general_viv,
        $valor_activo,
        $valor_activo_catastral

    ) {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivActivos($id_activo);
        $dao->setProperty('concepto_activo', $concepto_activo);
        $dao->setProperty('otros', $otros);
        $dao->setProperty('tipo_familiar', $tipo_familiar);
        $dao->setProperty('otro_propietario', $otro_propietario);
        $dao->setProperty('descripcion_general_viv', $descripcion_general_viv);
        $dao->setProperty('valor_activo', $valor_activo);
        $dao->setProperty('valor_activo_catastral', $valor_activo_catastral);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    //Actualizar el egreso del candidato
    public static function updatePolPre(
        $id_activo,
        $otros

    ) {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivActivos($id_activo);
        $dao->setProperty('otros', $otros);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos

    //Actualizar el egreso del candidato
    public static function updatePolRutina(
        $id_activo,
        $otros

    ) {
        if (!isset($id_activo) || $id_activo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivActivos($id_activo);
        $dao->setProperty('otros', $otros);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
