<?php

class CtrVivProtocoloSeguridad
{
    //Crear un financiero del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $concepto_seguridad, $respuesta, $descripcion_seguridad)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");

        $obj_vivProtocoloSeguridad = new VivProtocoloSeguridad();
        $obj_vivProtocoloSeguridad->setProperty('id_solicitud', $id_solicitud);
        $obj_vivProtocoloSeguridad->setProperty('id_servicio', $id_servicio);
        $obj_vivProtocoloSeguridad->setProperty('concepto_seguridad', $concepto_seguridad);
        $obj_vivProtocoloSeguridad->setProperty('respuesta', $respuesta);
        $obj_vivProtocoloSeguridad->setProperty('descripcion_seguridad', $descripcion_seguridad);

        

        $result = $obj_vivProtocoloSeguridad->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una financiero de la vivienda

    //listar los financiero del candidato y su familia
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT vs.*,c.descripcion AS descripcion_tipo_seguridad
            FROM viv_protocolo_seguridad vs, configurations c
            WHERE vs.id_solicitud = :id_solicitud
            and vs.id_servicio = :id_servicio
            and c.codigo =  vs.concepto_seguridad  
            and c.categoria = 'tipo_protocolo_seguridad_vi'
            order BY vs.concepto_seguridad
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato y su familia");
    }//Fin de listar los financiero del candidato

    //listar los financiero del candidato y su familia por no exists
    public static function findAllNoExists($tipo_protocolo_seguridad_vi)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT * FROM configurations c 
            WHERE categoria = :tipo_protocolo_seguridad_vi
            AND estado = 'ACT'
            AND NOT EXISTS (SELECT 1 
                            FROM viv_protocolo_seguridad vp
                            WHERE vp.concepto_seguridad = c.codigo )
            SQL,
            array("tipo_protocolo_seguridad_vi" => $tipo_protocolo_seguridad_vi),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato no repetido");
    }//Fin de listar los estudios del candidato


    //listar los financiero del candidato y su familia por no exists
    public static function findconceptovi($concepto_seguridad)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT * 
                FROM configurations c 
                WHERE c.categoria = 'tipo_protocolo_seguridad_vi'
                AND c.estado = 'ACT'
                AND c.codigo = :concepto_seguridad
            SQL,
            array("concepto_seguridad" => $concepto_seguridad),
            true,
            "N"
        );

        return Result::success($result, "buscar seguridad del candidato no repetido");
    }//Fin de listar los estudios del candidato

    //listar los financiero del candidato y su familia por no exists
    public static function findconceptovm($concepto_seguridad)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT * 
                FROM configurations c 
                WHERE c.categoria = 'tipo_protocolo_seguridad_vm'
                AND c.estado = 'ACT'
                AND c.codigo = :concepto_seguridad
            SQL,
            array("concepto_seguridad" => $concepto_seguridad),
            true,
            "N"
        );

        return Result::success($result, "buscar seguridad del candidato no repetido");
    }//Fin de listar los estudios del candidato


    //Editar un registro de Protocolo de seguridad del candidato
    public static function findByIdActivos($id_seguridad)
    {
        if (!isset($id_seguridad) || $id_seguridad == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vs.*, c.descripcion AS descripcion_tipo_concepto
                    from viv_protocolo_seguridad vs, sol_solicitud sc, configurations c
                    where vs.id_solicitud  = sc.id_solicitud
                    and  vs.id_seguridad  = :id_seguridad
                    and c.codigo =  vs.concepto_seguridad
                    and c.categoria = 'tipo_protocolo_seguridad_vi'
            SQL,
            array("id_seguridad" => $id_seguridad),
            false,
            "N"
        );

        return Result::success($result, "buscar financiero");
    }//Fin de Editar un registro de financiero del candidato

    //Borrar un registro por id
    public static function delete($id_seguridad)
    {
        if (!isset($id_seguridad) || $id_seguridad == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivProtocoloSeguridad($id_seguridad);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_seguridad,
        $concepto_seguridad,
        $respuesta,
        $descripcion_seguridad

    ) {
        if (!isset($id_seguridad) || $id_seguridad == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivProtocoloSeguridad($id_seguridad);
        $dao->setProperty('concepto_seguridad', $concepto_seguridad);
        $dao->setProperty('respuesta', $respuesta);
        $dao->setProperty('descripcion_seguridad', $descripcion_seguridad);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos


    public static function ExiteVariable($id_pregunta,$id_solicitud,$id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from viv_protocolo_seguridad dr 
                    where dr.concepto_seguridad = :id_pregunta
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
    }
}
