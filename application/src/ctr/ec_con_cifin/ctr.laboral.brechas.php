<?php

class CtrLaboralBrechas
{
    //Crear un activo del candidato o de su familia
    public static function crear($id_solicitud, $id_servicio, $pregunta_uno, $pregunta_dos)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_brechas = new laboralBrechas();
        $obj_brechas->setProperty('id_solicitud', $id_solicitud);
        $obj_brechas->setProperty('id_servicio', $id_servicio);
        $obj_brechas->setProperty('pregunta_uno', $pregunta_uno);
        $obj_brechas->setProperty('pregunta_dos', $pregunta_dos);

        $result = $obj_brechas->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una activo de la vivienda

    //listar las brechas laborales
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT lb.*
              FROM laboral_brechas lb
             WHERE lb.id_solicitud = :id_solicitud
               AND lb.id_servicio = :id_servicio 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar las brechas laborales");
    }//Fin de listar las obligaciones financieras
    

    //Editar un registro de activos  del candidato
    public static function findByIdBrechas($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
             SELECT lb.*
              FROM laboral_brechas lb, sol_solicitud ss
             WHERE lb.id_solicitud = ss.id_solicitud
               AND lb.id_solicitud = :id_solicitud
               AND lb.id_servicio = :id_servicio

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar brechas laborales");
    }//Fin de Editar un registro de activos del candidato

    //Borrar un registro por id
    public static function delete($id_laboral_brechas)
    {
        if (!isset($id_laboral_brechas) || $id_laboral_brechas == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new laboralBrechas($id_laboral_brechas);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_laboral_brechas,
        $pregunta_uno, 
        $pregunta_dos

    ) {
        if (!isset($id_laboral_brechas) || $id_laboral_brechas == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new laboralBrechas($id_laboral_brechas);
        $dao->setProperty('pregunta_uno', $pregunta_uno);
        $dao->setProperty('pregunta_dos', $pregunta_dos);

        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
