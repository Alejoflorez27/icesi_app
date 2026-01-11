<?php

class CtrVivRiesgosFinanciero
{
    //Crear un financiero del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $persona_evaluada, $concepto_financiero, $estado, $descripcion_financiero)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");        

        $obj_vivFinanciero = new VivRiesgosFinanciero();
        $obj_vivFinanciero->setProperty('id_solicitud', $id_solicitud);
        $obj_vivFinanciero->setProperty('id_servicio', $id_servicio);
        $obj_vivFinanciero->setProperty('persona_evaluada', $persona_evaluada);
        $obj_vivFinanciero->setProperty('concepto_financiero', $concepto_financiero);
        $obj_vivFinanciero->setProperty('estado', $estado);
        $obj_vivFinanciero->setProperty('descripcion_financiero', $descripcion_financiero);

        

        $result = $obj_vivFinanciero->insert();
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
            SELECT vf.id_financiero,
            	   vf.id_solicitud,
            	   vf.id_servicio,
            	   fcn_desc_configurations('tipo_persona_evaluada', vf.persona_evaluada) descripcion_persona_evaluda,
            	   fcn_desc_configurations('tipo_riesgo_financiero_vi', vf.concepto_financiero) descripcion_tipo_financiero,
            	   vf.estado,
            	   vf.descripcion_financiero
            FROM viv_riesgos_financieros vf
            WHERE vf.id_solicitud = :id_solicitud
            and vf.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato y su familia");
    }//Fin de listar los financiero del candidato

    //Valida las variables para la dimension financiero-economica
    public static function ExiteVariablePolPre($id_pregunta,$id_solicitud,$id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from viv_riesgos_financieros dr 
                    where dr.concepto_financiero = :id_pregunta
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


    //listar los financiero del candidato y su familia
    public static function findAllPolPre($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT vf.id_financiero,
            	   vf.id_solicitud,
            	   vf.id_servicio,
            	   fcn_desc_configurations('tipo_persona_evaluada', vf.persona_evaluada) descripcion_persona_evaluda,
            	   fcn_desc_configurations('tipo_riesgo_financiero_pol_pre', vf.concepto_financiero) descripcion_tipo_financiero,
            	   vf.estado,
            	   vf.descripcion_financiero
            FROM viv_riesgos_financieros vf
            WHERE vf.id_solicitud = :id_solicitud
            and vf.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato y su familia");
    }//Fin de listar los financiero del candidato

    //listar los financiero del candidato y su familia por no exists
    public static function findAllNoExists($tipo_riesgo_financiero_vi)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT * FROM configurations c 
            WHERE categoria = :tipo_riesgo_financiero_vi
            AND estado = 'ACT'
            AND NOT EXISTS (SELECT 1 
                            FROM viv_riesgos_financieros vr
                            WHERE vr.concepto_financiero = c.codigo )
            SQL,
            array("tipo_riesgo_financiero_vi" => $tipo_riesgo_financiero_vi),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato no repetido");
    }//Fin de listar los estudios del candidato


    //listar los financiero del candidato y su familia por no exists
    public static function findconcepto($concepto_financiero)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT * 
                FROM configurations c 
                WHERE c.categoria = 'tipo_riesgo_financiero_vi'
                AND c.estado = 'ACT'
                AND c.codigo = :concepto_financiero
            SQL,
            array("concepto_financiero" => $concepto_financiero),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato no repetido");
    }//Fin de listar los estudios del candidato

    //listar los financiero del candidato y su familia por no exists
    public static function findconceptoPolPre($concepto_financiero)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT * 
                FROM configurations c 
                WHERE c.categoria = 'tipo_riesgo_financiero_pol_pre'
                AND c.estado = 'ACT'
                AND c.codigo = :concepto_financiero
            SQL,
            array("concepto_financiero" => $concepto_financiero),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero del candidato no repetido");
    }//Fin de listar los estudios del candidato



    //Editar un registro de financiero  del candidato
    public static function findByIdActivos($id_financiero)
    {
        if (!isset($id_financiero) || $id_financiero == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                
                select vf.*, c.descripcion AS descripcion_tipo_concepto, c.observacion
                    from viv_riesgos_financieros vf, sol_solicitud sc, configurations c
                    where vf.id_solicitud  = sc.id_solicitud
                    and  vf.id_financiero  = :id_financiero
                    and c.codigo =  vf.concepto_financiero
                    and c.categoria = 'tipo_riesgo_financiero_vi'
            SQL,
            array("id_financiero" => $id_financiero),
            false,
            "N"
        );

        return Result::success($result, "buscar financiero");
    }//Fin de Editar un registro de financiero del candidato

    //Borrar un registro por id
    public static function delete($id_financiero)
    {
        if (!isset($id_financiero) || $id_financiero == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivRiesgosFinanciero($id_financiero);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_financiero,
        $persona_evaluada,
        $concepto_financiero,
        $estado,
        $descripcion_financiero

    ) {
        if (!isset($id_financiero) || $id_financiero == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivRiesgosFinanciero($id_financiero);
        $dao->setProperty('persona_evaluada', $persona_evaluada);
        $dao->setProperty('concepto_financiero', $concepto_financiero);
        $dao->setProperty('estado', $estado);
        $dao->setProperty('descripcion_financiero', $descripcion_financiero);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
