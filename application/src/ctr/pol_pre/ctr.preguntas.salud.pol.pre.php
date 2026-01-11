<?php

class CtrPreguntaSaludPolPre
{

    public static function crear($id_solicitud, $id_servicio, $id_caracteristica_tipo, $categoria, $descripcion, $opcion, $id_pregunta)
    {
        //print_r($id_caracteristica_tipo);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");
        if (!isset($id_caracteristica_tipo) || $id_caracteristica_tipo == "")
            return BaseResponse::error(__FUNCTION__, "Id codigo es requerido");
        if (!isset($categoria) || $categoria == "")
            return BaseResponse::error(__FUNCTION__, "Id categoria es requerido");

        $obj_caracteristicaVariable = new preguntaSaludPolPre();
        $obj_caracteristicaVariable->setProperty('id_solicitud', $id_solicitud);
        $obj_caracteristicaVariable->setProperty('id_servicio', $id_servicio);
        $obj_caracteristicaVariable->setProperty('categoria', $categoria);
        $obj_caracteristicaVariable->setProperty('codigo', $id_caracteristica_tipo);
        $obj_caracteristicaVariable->setProperty('activo', 1);
        $obj_caracteristicaVariable->setProperty('descripcion', $descripcion);
        $obj_caracteristicaVariable->setProperty('opcion', $opcion);
        $obj_caracteristicaVariable->setProperty('id_pregunta', $id_pregunta);

        $result = $obj_caracteristicaVariable->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }


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
    } //Fin de Borrar un registro por id

    public static function findAllByCombo($categoria, $id_solicitud, $id_servicio)
    {
        /*if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");*/

        $result = QuerySQL::select(
            <<<SQL
            	select vcv.id_preg_salud_pol,
            		   vcv.id_solicitud,
            		   vcv.id_servicio,
            		   vcv.categoria,
            		   vcv.codigo,
            		   vcv.activo,
            		   vcv.descripcion as texto,
                       vcv.opcion,
            		   vcv.usr_create,
            		   c.descripcion 
                    from preguntas_salud_pol_pre vcv, configurations c
                    where vcv.id_solicitud = :id_solicitud 
                    and vcv.id_servicio = :id_servicio
                    and vcv.categoria = :categoria
                    and vcv.activo = 1
                    and vcv.categoria = c.categoria 
                    and vcv.codigo = c.codigo;
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

    public static function respByCategoria($categoria, $id_solicitud, $id_servicio)
    {
        $result = QuerySQL::select(
            <<<SQL
                    SELECT c.codigo AS codigo_pregunta,
                           c.descripcion AS pregunta,
                           CASE WHEN vcv.activo = 1 THEN 'SI' 
                               ELSE 'NO' 
                           END AS respuesta
                       FROM configurations c
                       LEFT JOIN preguntas_salud_pol_pre vcv ON c.categoria = vcv.categoria
                       AND c.codigo = vcv.codigo
                       AND vcv.id_solicitud = :id_solicitud 
                       AND vcv.id_servicio =:id_servicio
                     WHERE c.categoria = :categoria
                SQL,
            array("categoria" => $categoria, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return Result::success($result, "buscar aspectos por caracteristica");
    }




    public static function findAllByComboCodigo($categoria, $codigo, $id_solicitud, $id_servicio)
    {
        /*if (!isset($id_caracteristica) || $id_caracteristica == "")
            return Result::error(__FUNCTION__, "caracteristica es requerido");*/

        $result = QuerySQL::select(
            <<<SQL
                    select vcv.id_preg_salud_pol,
                        vcv.id_solicitud,
                        vcv.id_servicio,
                        vcv.categoria,
                        vcv.codigo,
                        vcv.activo,
                        vcv.descripcion as texto,
                        vcv.opcion,
                        vcv.usr_create,
                        c.descripcion 
                        from preguntas_salud_pol_pre vcv, configurations c
                        where vcv.id_solicitud = :id_solicitud 
                        and vcv.id_servicio = :id_servicio
                        and vcv.categoria = :categoria
                        and vcv.activo = 1
                        and vcv.categoria = c.categoria 
                        and vcv.codigo = c.codigo
                        and vcv.codigo = :codigo;
            SQL,
            array("categoria" => $categoria, "codigo" => $codigo, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
        return BaseResponse::success($result, "buscar validacion de checks");
    }



    public static function updateAntrecedentesArray($id_preg_salud_pol, $descripcion, $opcion) {

        if (!isset($id_preg_salud_pol) || $id_preg_salud_pol == "")
            return BaseResponse::error(__FUNCTION__, "id es requerido");

        $dao = new preguntaSaludPolPre($id_preg_salud_pol);
        $dao->setProperty('descripcion', $descripcion);
        $dao->setProperty('opcion', $opcion);

        $result =  $dao->update();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
}
