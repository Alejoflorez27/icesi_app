<?php

class CtrPreguntaAlcoholPolPre
{

    public static function crear($id_solicitud, $id_servicio, $pregunta_uno)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido"); 
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido"); 

        $obj_caracteristicaVariable = new preguntaAlcoholPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('pregunta_uno', $pregunta_uno);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar las preguntas de alcohol
    public static function update($id_preg_alcohol_pol, $pregunta_uno)
    {
        if (!isset($id_preg_alcohol_pol) || $id_preg_alcohol_pol == "")
            return Result::error(__FUNCTION__, "id id_preg_alcohol_pol es requerido");


        $dao = new preguntaAlcoholPolPre($id_preg_alcohol_pol);
        $dao->setProperty('pregunta_uno', $pregunta_uno);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de actualizar lo del alcohol


    //Borrar un registro por id
    public static function delete($id_caracteristica_variable)
    {
        if (!isset($id_caracteristica_variable) || $id_caracteristica_variable == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new preguntaSaludPolPre($id_caracteristica_variable);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    public static function findAllByCombo($categoria, $id_solicitud, $id_servicio)
    {
        /*if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");*/

        $result = QuerySQL::select(
            <<<SQL
                    select vcv.*, c.descripcion  
                    from preguntas_salud_pol_pre vcv, configurations c
                    where vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.categoria = :categoria
                    and vcv.activo = 1
                    and vcv.categoria = c.categoria 
                    and vcv.codigo = c.codigo
            SQL,
            array("categoria" => $categoria, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }

    public static function findAByAspecto($categoria, $codigo, $id_solicitud, $id_servicio)
    {
        /*if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");*/

        $result = QuerySQL::select(
            <<<SQL
                    SELECT vcv.id_preg_salud_pol, 
                        vcv.id_solicitud,
                        vcv.id_servicio,
                        vcv.categoria,
                        vcv.codigo,
                        vcv.activo
                    FROM preguntas_salud_pol_pre vcv 
                    WHERE vcv.codigo = :codigo
                    and vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.categoria = :categoria
            SQL,
            array("categoria" => $categoria, "codigo" => $codigo, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por codigo");
    }

    //consultar el registroa a editar
    public static function alcoholPolPreById($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_preg_alcohol_pol, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.pregunta_uno
                    from preguntas_alcohol_pol_pre o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }//Fin de Editar un registro de formacion academica del candidato

}
