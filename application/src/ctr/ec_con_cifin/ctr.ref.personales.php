<?php

class CtrRefPersonales
{
    //Crear una formacion academica
    public static function crear($id_solicitud, $id_servicio, $referencia_personal, $nombre, $telefono, $concepto, $observacion_adicional)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        /*if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");*/

        $obj_refPersonales = new refPersonales();
        $obj_refPersonales->setProperty('id_solicitud', $id_solicitud);
        $obj_refPersonales->setProperty('id_servicio', $id_servicio);
        $obj_refPersonales->setProperty('referencia_personal', $referencia_personal);
        $obj_refPersonales->setProperty('nombre', $nombre);
        $obj_refPersonales->setProperty('telefono', $telefono);
        $obj_refPersonales->setProperty('concepto', $concepto);
        $obj_refPersonales->setProperty('observacion_adicional', $observacion_adicional);

        $result = $obj_refPersonales->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una formacion academica

    //listar los referancias personales del candidato
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT rp.id_ref_personal,
                rp.id_solicitud,
                rp.id_servicio,
                rp.referencia_personal,
                rp.nombre,
                rp.telefono,
                rp.concepto,
                rp.observacion_adicional
            FROM ref_personales rp
            WHERE rp.id_solicitud = :id_solicitud
            AND rp.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //listar los referancias personales del candidato
    public static function findSinSrvAll($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT rp.id_ref_personal,
                rp.id_solicitud,
                rp.id_servicio,
                rp.referencia_personal,
                rp.nombre,
                rp.telefono,
                rp.concepto,
                rp.observacion_adicional
            FROM ref_personales rp
            WHERE rp.id_solicitud = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato


    //Editar un registro de referencia personales del candidato
    public static function findByIdRefPersonal($id_ref_personal)
    {
        if (!isset($id_ref_personal) || $id_ref_personal == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
            SELECT rp.id_ref_personal,
                rp.id_solicitud,
                rp.id_servicio,
                rp.referencia_personal,
                rp.nombre,
                rp.telefono,
                rp.concepto,
                rp.observacion_adicional
            FROM ref_personales rp, sol_solicitud sc
            WHERE rp.id_solicitud = sc.id_solicitud 
            AND rp.id_ref_personal = :id_ref_personal
            SQL,
            array("id_ref_personal" => $id_ref_personal),
            false,
            "N"
        );

        return Result::success($result, "buscar id_ref_personal");
    }//Fin de Editar un registro de referencia personal del candidato

    //Borrar un registro por id
    public static function delete($id_ref_personal)
    {
        if (!isset($id_ref_personal) || $id_ref_personal == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new refPersonales($id_ref_personal);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la referencia personal
    public static function update(
        $id_ref_personal,
        $referencia_personal,
        $nombre,
        $telefono,
        $concepto
        //$observacion_adicional
    ) {
        if (!isset($id_ref_personal) || $id_ref_personal == "")
            return Result::error(__FUNCTION__, "id es requerido");
        


        $dao = new refPersonales($id_ref_personal);
        $dao->setProperty('referencia_personal', $referencia_personal);
        $dao->setProperty('nombre', $nombre);
        $dao->setProperty('telefono', $telefono);
        $dao->setProperty('concepto', $concepto);
        //$dao->setProperty('observacion_adicional', $observacion_adicional);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Referencia Personal
}
