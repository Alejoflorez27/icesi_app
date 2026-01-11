<?php

class CtrVivAnteriores
{
    //Crear una vivienda anterior
    public static function crear($id_solicitud, $id_servicio, $ubicacion, $Tiempo_estadia, $motivo_cambio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_solFormacion = new VivAnteriores();
        $obj_solFormacion->setProperty('id_solicitud', $id_solicitud);
        $obj_solFormacion->setProperty('id_servicio', $id_servicio);
        $obj_solFormacion->setProperty('ubicacion', $ubicacion);
        $obj_solFormacion->setProperty('Tiempo_estadia', $Tiempo_estadia);
        $obj_solFormacion->setProperty('motivo_cambio', $motivo_cambio);
        

        $result = $obj_solFormacion->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear vivienda anterior
 
    //listar las viviendas anteriores
    public static function findAllVisitas($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT va.id_viv_anterior, va.id_solicitud, va.ubicacion, va.Tiempo_estadia , c2.descripcion AS descripcion_tiempo_reside,
                   va.motivo_cambio , va.usr_create, va.fch_create 
            FROM viv_anteriores va, configurations c2
            WHERE va.id_solicitud = :id_solicitud
            and va.id_servicio = :id_servicio
            and c2.codigo =  va.Tiempo_estadia 
            and c2.categoria = 'tipo_tiempo_estadia' 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar las vivienda anterior del candidato

    //Editar un registro de vivienda anterior del candidato
    public static function findByIdVivAnteriores($id_viv_anterior)
    {
        if (!isset($id_viv_anterior) || $id_viv_anterior == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sf.id_viv_anterior, sf.id_solicitud, sf.ubicacion, sf.Tiempo_estadia, 
                sf.motivo_cambio, sf.usr_create, sf.fch_create
                    from viv_anteriores sf, sol_solicitud sc
                    where sf.id_solicitud  = sc.id_solicitud
                    and  sf.id_viv_anterior = :id_viv_anterior
            SQL,
            array("id_viv_anterior" => $id_viv_anterior),
            false,
            "N"
        );

        return Result::success($result, "buscar formación");
    }//Fin de Editar un registro de vivienda anterior del candidato

    //Borrar un registro por id
    public static function delete($id_viv_anterior)
    {
        if (!isset($id_viv_anterior) || $id_viv_anterior == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivAnteriores($id_viv_anterior);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar las viviendas anteriores
    public static function update(
        $id_viv_anterior,
        $ubicacion,
        $Tiempo_estadia,
        $motivo_cambio

    ) {
        if (!isset($id_viv_anterior) || $id_viv_anterior == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivAnteriores($id_viv_anterior);
        $dao->setProperty('ubicacion', $ubicacion);
        $dao->setProperty('Tiempo_estadia', $Tiempo_estadia);
        $dao->setProperty('motivo_cambio', $motivo_cambio);


        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar las viviendas anteriores
}
