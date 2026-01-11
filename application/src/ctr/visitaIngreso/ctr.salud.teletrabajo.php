<?php

class CtrSaludTeletrabajo
{
    //Crear una distribucion de la vivienda
    public static function crear($id_solicitud, $id_servicio, $aspecto, $observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_salud = new saludTeletrabajo();
        $obj_salud->setProperty('id_solicitud', $id_solicitud);
        $obj_salud->setProperty('id_servicio', $id_servicio);
        $obj_salud->setProperty('aspecto', $aspecto);
        $obj_salud->setProperty('observacion', $observacion);

        

        $result = $obj_salud->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda

    //listar los estudios del candidato
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT vd.id_salud,
                    vd.id_solicitud,
                    vd.id_servicio,
                    fcn_desc_configurations('tipo_salud_teletrabajo', vd.aspecto) aspecto,
                    vd.observacion
                FROM salud_teletrabajo vd
                WHERE vd.id_solicitud = :id_solicitud
                AND vd.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //Editar un registro de formacion academica del candidato
    public static function findByIdSalud($id_salud)
    {
        if (!isset($id_salud) || $id_salud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vd.*
                    from salud_teletrabajo vd, sol_solicitud sc
                    where vd.id_solicitud  = sc.id_solicitud
                    and  vd.id_salud  = :id_salud
            SQL,
            array("id_salud" => $id_salud),
            false,
            "N"
        );

        return Result::success($result, "buscar formación");
    }//Fin de Editar un registro de formacion academica del candidato

    //Valida las variables para la dimension financiero-economica
    public static function ExiteVariable($aspecto,$id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from salud_teletrabajo dr 
                    where dr.aspecto = :aspecto
                    and dr.id_solicitud = :id_solicitud
            SQL,
            array("aspecto" => $aspecto,
                  "id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }//Fin listar las preguntas del candidato para la dimension financiero

    //Borrar un registro por id
    public static function delete($id_salud)
    {
        if (!isset($id_salud) || $id_salud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new saludTeletrabajo($id_salud);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la Formacion Academica
    public static function update(
        $id_salud,
        $aspecto,
        $observacion

    ) {
        if (!isset($id_salud) || $id_salud == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new saludTeletrabajo($id_salud);
        $dao->setProperty('aspecto', $aspecto);
        $dao->setProperty('observacion', $observacion);

        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica
}
