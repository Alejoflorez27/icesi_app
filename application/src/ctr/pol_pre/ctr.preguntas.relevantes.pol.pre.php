<?php

class CtrPreguntasRelevantesPolPre
{
    //Crear un financiero del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $tipo_rn, $pregunta, $resp_candidato, $calificacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");        

        $obj_preg_relevantes = new preguntasRelevantesPolPre();
        $obj_preg_relevantes->setProperty('id_solicitud', $id_solicitud);
        $obj_preg_relevantes->setProperty('id_servicio', $id_servicio);
        $obj_preg_relevantes->setProperty('tipo_rn', $tipo_rn);
        $obj_preg_relevantes->setProperty('pregunta', $pregunta);
        $obj_preg_relevantes->setProperty('resp_candidato', $resp_candidato);
        $obj_preg_relevantes->setProperty('calificacion', $calificacion);

        

        $result = $obj_preg_relevantes->insert();
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
                SELECT prpp.id_preg_relevante,
                       prpp.id_solicitud,
                       prpp.id_servicio,
                       prpp.tipo_rn,
                       fcn_desc_configurations('tipo_resp_rn_pol_pre', prpp.tipo_rn) descripcion_tipo_rn,
                       prpp.pregunta,
                       prpp.resp_candidato,
                       prpp.calificacion,
                       fcn_desc_configurations('tipo_calificacion_pol_pre', prpp.calificacion) descripcion_calificacion,
                       prpp.usr_create,
                       prpp.fch_create
                FROM preguntas_relevantes_pol_pre prpp
               WHERE prpp.id_solicitud = :id_solicitud
                 AND prpp.id_servicio =:id_servicio
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



    //Editar un registro de financiero  del candidato
    public static function findByIdPreguntaRelevante($id_preg_relevante, $id_solicitud, $id_servicio)
    {
        if (!isset($id_preg_relevante) || $id_preg_relevante == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                 SELECT prpp.id_preg_relevante,
                        prpp.id_solicitud,
                        prpp.id_servicio,
                        prpp.tipo_rn,
                        prpp.pregunta,
                        prpp.resp_candidato,
                        prpp.calificacion,
                        prpp.usr_create,
                        prpp.fch_create
                     FROM preguntas_relevantes_pol_pre prpp
                    WHERE prpp.id_solicitud = :id_solicitud
                     AND prpp.id_servicio =:id_servicio
                     AND prpp.id_preg_relevante = :id_preg_relevante
                
                /*select vf.*, c.descripcion AS descripcion_tipo_concepto, c.observacion
                    from viv_riesgos_financieros vf, sol_solicitud sc, configurations c
                    where vf.id_solicitud  = sc.id_solicitud
                    and  vf.id_preg_relevante  = :id_preg_relevante
                    and c.codigo =  vf.concepto_financiero
                    and c.categoria = 'tipo_riesgo_financiero_vi'*/
            SQL,
            array("id_preg_relevante" => $id_preg_relevante, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar pregunta relevante");
    }//Fin de Editar un registro de financiero del candidato

    //Borrar un registro por id
    public static function delete($id_preg_relevante)
    {
        if (!isset($id_preg_relevante) || $id_preg_relevante == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new preguntasRelevantesPolPre($id_preg_relevante);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_preg_relevante,
        $tipo_rn,
        $pregunta,
        $resp_candidato,
        $calificacion

    ) {
        if (!isset($id_preg_relevante) || $id_preg_relevante == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new preguntasRelevantesPolPre($id_preg_relevante);
        $dao->setProperty('tipo_rn', $tipo_rn);
        $dao->setProperty('pregunta', $pregunta);
        $dao->setProperty('resp_candidato', $resp_candidato);
        $dao->setProperty('calificacion', $calificacion);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
