<?php

class CtrPregValPolEspecifico
{
    //Crear un preguntas de validacion
    public static function crear($id_solicitud, $id_servicio, $pregunta, $respuesta)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");        

        $obj_validacion = new pregValPolEspecifico();
        $obj_validacion->setProperty('id_solicitud', $id_solicitud);
        $obj_validacion->setProperty('id_servicio', $id_servicio);
        $obj_validacion->setProperty('pregunta', $pregunta);
        $obj_validacion->setProperty('respuesta', $respuesta);

        $result = $obj_validacion->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear pregunta de validacion

    //listar los financiero del candidato y su familia
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT vf.id_validacion,
            	   vf.id_solicitud,
            	   vf.id_servicio,
            	   vf.pregunta,
                   vf.respuesta
            FROM preg_val_pol_especifico vf
            WHERE vf.id_solicitud = :id_solicitud
            and vf.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar lista de validacion de preguntas");
    }//Fin de listar los financiero del candidato

    //Editar un registro de financiero  del candidato
    public static function findByIdValidacion($id_validacion)
    {
        if (!isset($id_validacion) || $id_validacion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                
                select vf.*
                    from preg_val_pol_especifico vf, sol_solicitud sc
                    where vf.id_solicitud  = sc.id_solicitud
                    and  vf.id_validacion  = :id_validacion
            SQL,
            array("id_validacion" => $id_validacion),
            false,
            "N"
        );

        return Result::success($result, "buscar financiero");
    }//Fin de Editar un registro de financiero del candidato

    //Borrar un registro por id
    public static function delete($id_validacion)
    {
        if (!isset($id_validacion) || $id_validacion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new pregValPolEspecifico($id_validacion);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar el egreso del candidato
    public static function update(
        $id_validacion,
        $pregunta,
        $respuesta
    ) {
        if (!isset($id_validacion) || $id_validacion == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new pregValPolEspecifico($id_validacion);
        $dao->setProperty('pregunta', $pregunta);
        $dao->setProperty('respuesta', $respuesta);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
