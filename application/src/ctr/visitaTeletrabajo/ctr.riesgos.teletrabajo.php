<?php

class CtrRiesgosTeletrabajo
{

    public static function crear($id_solicitud, $id_servicio, $factor, $aspecto, $descripcion, $calificacion, $observacion, $list_aspecto)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicios es requerido");
        $obj_riesgo = new riesgosTeletrabajo();
        $obj_riesgo->setProperty('id_solicitud', $id_solicitud);
        $obj_riesgo->setProperty('id_servicio', $id_servicio);
        $obj_riesgo->setProperty('factor', $factor);
        $obj_riesgo->setProperty('aspecto', $aspecto);
        $obj_riesgo->setProperty('descripcion', $descripcion);
        $obj_riesgo->setProperty('calificacion', $calificacion);
        $obj_riesgo->setProperty('observacion', $observacion);
        $obj_riesgo->setProperty('list_aspecto', $list_aspecto);

        

        $result = $obj_riesgo->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT ve.id_riesgo,
                        ve.id_solicitud,
                        ve.id_servicio,
                        fcn_desc_configurations('tipo_factores_riesgo', ve.factor) factor,
                        ve.aspecto,
                        fcn_desc_configurations(ve.list_aspecto, ve.descripcion) descripcion,
                        ve.calificacion,
                        ve.observacion,
                        ve.usr_create,
                        ve.fch_create
                FROM riesgos_teletrabajo ve
                WHERE ve.id_solicitud = :id_solicitud
                and ve.id_servicio = :id_servicio

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar los factores de riesgo");
    }

    public static function findByIdEgresos($id_riesgo)
    {
        if (!isset($id_riesgo) || $id_riesgo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select ve.id_riesgo,
                        ve.id_solicitud,
                        ve.id_servicio,
                        ve.factor,
                        ve.aspecto,
                        ve.descripcion,
                        ve.calificacion,
                        ve.observacion,
                        ve.list_aspecto,
                        ve.usr_create,
                        ve.fch_create
                        from riesgos_teletrabajo ve, sol_solicitud sc
                            WHERE ve.id_riesgo  = :id_riesgo
                            and ve.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_riesgo" => $id_riesgo),
            false,
            "N"
        );

        return Result::success($result, "buscar factor de riesgo");
    }

    public static function delete($id_riesgo)
    {
        if (!isset($id_riesgo) || $id_riesgo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new riesgosTeletrabajo($id_riesgo);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Valida las variables para la dimension financiero-economica
    public static function ExiteVariable($descripcion, $list_aspecto ,$id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            select 1 existe
                from riesgos_teletrabajo dr 
                where dr.descripcion  = :descripcion
                and list_aspecto = :list_aspecto 
                and dr.id_solicitud = :id_solicitud
            SQL,
            array("descripcion" => $descripcion,
                  "list_aspecto" => $list_aspecto,
                  "id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }//Fin listar las preguntas del candidato para la dimension financiero

    //Valida las variables para la dimension financiero-economica
    public static function preguntasFaltantes($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT c.categoria, c.codigo, c.descripcion
            FROM configurations c
            LEFT JOIN riesgos_teletrabajo rt 
                ON c.categoria = rt.list_aspecto 
                AND c.codigo = rt.descripcion 
                AND rt.id_solicitud = :id_solicitud
            WHERE c.categoria IN ('tipo_factor_tarea', 'tipo_factor_organizacion_tmp', 'tipo_factor_estructura_organizacion')
            AND c.estado = 'ACT'
            AND rt.id_solicitud IS NULL;
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }//Fin listar las preguntas del candidato para la dimension financiero

    //Actualizar el egreso del candidato
    public static function update(
        $id_riesgo,
        $factor,
        $aspecto,
        $calificacion,
        $observacion

    ) {
        if (!isset($id_riesgo) || $id_riesgo == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new riesgosTeletrabajo($id_riesgo);
        $dao->setProperty('factor', $factor);
        $dao->setProperty('aspecto', $aspecto);
        $dao->setProperty('calificacion', $calificacion);
        $dao->setProperty('observacion', $observacion);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
