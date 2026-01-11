<?php

class CtrVivMobiliarios
{
    //Crear una mobiliario y electrodomesticos de la vivienda
    public static function crear($id_solicitud, $id_servicio, $id_distribucion, $tipo_elemento, $cantidad, $estado_mobiliario, $tenencia_mobiliario/*, $mobiliario_electro*/)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_vivMobiliario = new VivMobilElectro();
        $obj_vivMobiliario->setProperty('id_solicitud', $id_solicitud);
        $obj_vivMobiliario->setProperty('id_servicio', $id_servicio);
        $obj_vivMobiliario->setProperty('id_distribucion', $id_distribucion);
        $obj_vivMobiliario->setProperty('tipo_elemento', $tipo_elemento);
        $obj_vivMobiliario->setProperty('cantidad', $cantidad);
        $obj_vivMobiliario->setProperty('estado_mobiliario', $estado_mobiliario);
        $obj_vivMobiliario->setProperty('tenencia_mobiliario', $tenencia_mobiliario);
        //$obj_vivMobiliario->setProperty('mobiliario_electro', $mobiliario_electro);
        

        $result = $obj_vivMobiliario->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda

    //listar los mobiliarios y electrodomesticos del candidato
    public static function findAll($id_solicitud, $id_servicio, $id_distribucion)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT  vm.id_mobiliario,
                vm.id_solicitud,
                vm.id_servicio,
                vm.id_distribucion,
                tipo_elemento,
                fcn_desc_configurations('tipo_elementos_mobiliario', vm.tipo_elemento)tipo_elemento,
                vm.tipo_elemento as codigo,
                vm.cantidad,
                estado_mobiliario,
                fcn_desc_configurations('estado_dotacion', vm.estado_mobiliario) des_estado_mobiliario,
                tenencia_mobiliario,
                fcn_desc_configurations('tipo_tenencia_dotacion', vm.tenencia_mobiliario) des_tipo_tenencia_dotacion,
                vm.usr_create,
                vm.fch_create,
                mobiliario_electro 
                FROM viv_mobil_electro vm
                WHERE vm.id_solicitud = :id_solicitud
                AND vm.id_servicio = :id_servicio
                AND vm.id_distribucion = :id_distribucion
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "id_distribucion" => $id_distribucion),
            true,
            "N"
        );

        return Result::success($result, "buscar dotacion mobiliaria");
    }//Fin de listar los mobiliarios y electrodomesticos del candidato

    //Editar un registro de formacion academica del candidato
    public static function findByIdMobiliarioElectro($id_mobiliario)
    {
        if (!isset($id_mobiliario) || $id_mobiliario == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vm.*
                    from viv_mobil_electro vm, sol_solicitud sc
                    where vm.id_solicitud  = sc.id_solicitud
                    and  vm.id_mobiliario  = :id_mobiliario
            SQL,
            array("id_mobiliario" => $id_mobiliario),
            false,
            "N"
        );

        return Result::success($result, "buscar dotación mobiliaria");
    }//Fin de Editar un registro de formacion academica del candidato

    //Borrar un registro por id
    public static function delete($id_mobiliario)
    {
        if (!isset($id_mobiliario) || $id_mobiliario == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivMobilElectro($id_mobiliario);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la dotacion mobiliaria
    public static function update(
        $id_mobiliario,
        $tipo_elemento,
        $cantidad,
        $estado_mobiliario,
        $tenencia_mobiliario,
        $mobiliario_electro

    ) {
        if (!isset($id_mobiliario) || $id_mobiliario == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivMobilElectro($id_mobiliario);
        $dao->setProperty('tipo_elemento', $tipo_elemento);
        $dao->setProperty('cantidad', $cantidad);
        $dao->setProperty('estado_mobiliario', $estado_mobiliario);
        $dao->setProperty('tenencia_mobiliario', $tenencia_mobiliario);
        $dao->setProperty('mobiliario_electro', $mobiliario_electro);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            //return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la dotacion mobiliaria
}
