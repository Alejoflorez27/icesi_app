<?php

class CtrRolesTeletrabajo
{
    //Crear una formacion academica
    public static function crear($id_solicitud, $id_servicio, $pregunta, $respuesta)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        /*if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");*/

        $obj_solFamilia = new rolesTeletrabajo();
        $obj_solFamilia->setProperty('id_solicitud', $id_solicitud);
        $obj_solFamilia->setProperty('id_servicio', $id_servicio);
        $obj_solFamilia->setProperty('pregunta', $pregunta);
        $obj_solFamilia->setProperty('respuesta', $respuesta);

        $result = $obj_solFamilia->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una formacion academica



    //listar los estudios del candidato
    public static function findAll($estado = null)
    {

        $result = QuerySQL::select(
            <<<SQL
                select  sf.id_rol ,sf.id_solicitud, sf.id_ciudad_act , sf.parentesco, fcn_desc_configurations('tipo_parentesco', sf.parentesco) des_parentesco,
                sf.nombre, sf.apellido, sf.edad, sf.estado_civil, fcn_desc_configurations('tipo_estado_civil', sf.estado_civil) des_est_civil,
                sf.nivel_escolar, fcn_desc_configurations('tipo_nivel_escolar', sf.nivel_escolar) des_nvl_escolar, sf.ocupacion, sf.empresa, 
                sf.viv_candidato, sf.depende_candidato, sf.residencia, sf.telefono 
                    from roles_teletrabajo sf , sol_candidato sc 
                    where sf.id_solicitud  = sc.id_solicitud   
            SQL,
            null,
            true,
            "N"
        );

        return Result::success($result, "buscar familiar");
    }//Fin de listar los estudios del candidato



    //Editar un registro de formacion academica del candidato
    public static function findByIdRolesTeletrabajo($id_rol)
    {
        if (!isset($id_rol) || $id_rol == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sf.id_rol, 
                       sf.id_solicitud, 
                       sf.id_servicio,
                       sf.pregunta,
                       sf.respuesta, 
                       sf.fch_create, 
                       sf.usr_create
                    from roles_teletrabajo sf
                    where sf.id_rol  = :id_rol

            SQL,
            array("id_rol" => $id_rol),
            false,
            "N"
        );

        return Result::success($result, "buscar familia");
    }//Fin de Editar un registro de formacion academica del candidato

    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionFamiliarTeletrabajo($id_solicitud, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
            SELECT sf.id_rol,
                sf.id_solicitud,
                sf.id_servicio,
                sf.pregunta,
                fcn_desc_configurations('tipo_roles_teletrabajo', sf.pregunta) AS des_pregunta,
                sf.respuesta
            FROM roles_teletrabajo sf
            WHERE sf.id_solicitud = :id_solicitud
            AND sf.id_servicio = :id_servicio
            ORDER BY sf.pregunta ASC;
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar familiares");
    
    }

    //Borrar un registro por id
    public static function delete($id_rol)
    {
        if (!isset($id_rol) || $id_rol == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new rolesTeletrabajo($id_rol);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la Familiar
    public static function update(
        $id_rol,
        $pregunta,
        $respuesta
    ) {
        if (!isset($id_rol) || $id_rol == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new rolesTeletrabajo($id_rol);
        $dao->setProperty('pregunta', $pregunta);
        $dao->setProperty('respuesta', $respuesta);
  

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica


}
