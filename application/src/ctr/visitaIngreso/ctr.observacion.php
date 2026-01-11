<?php

class CtrObservaciones
{
    //Crear una Observacion General con el tipo al que corresponde
    public static function crear($id_solicitud, $id_servicio, $tipo_observacion, $observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_observaciones = new observaciones();
        $obj_observaciones->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones->setProperty('id_servicio', $id_servicio);
        $obj_observaciones->setProperty('tipo_observacion', $tipo_observacion);
        $obj_observaciones->setProperty('observacion', $observacion);
        
        $result = $obj_observaciones->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una Observacion General con el tipo al que corresponde

    //Crear una Observacion General con el tipo al que corresponde y Admitio
    public static function crearAdmitio($id_solicitud, $id_servicio, $tipo_observacion, $observacion, $item_poligrafia, $admitio, $resumen)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_observaciones = new observaciones();
        $obj_observaciones->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones->setProperty('id_servicio', $id_servicio);
        $obj_observaciones->setProperty('tipo_observacion', $tipo_observacion);
        $obj_observaciones->setProperty('observacion', $observacion);

        CtrAdmisionesPolPre::crear($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen);
        
        $result = $obj_observaciones->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una Observacion General con el tipo al que corresponde y Admitio

    //Crear una Observacion General con el tipo al que corresponde y Admitio y cursos

    public static function crearAdmitioCursos($id_solicitud, $id_servicio, $tipo_observacion, $observacion, $item_poligrafia, $admitio, $resumen, $var1 = NULL, $var2 = NULL, $var3 = NULL, $tipo_observacion1, $cursos, $tipo_observacion2, $edu_no_formal)
    {
        //print_r($tipo_observacion1."hola");
        //print_r($cursos);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_observaciones = new observaciones();
        $obj_observaciones->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones->setProperty('id_servicio', $id_servicio);
        $obj_observaciones->setProperty('tipo_observacion', $tipo_observacion);
        $obj_observaciones->setProperty('observacion', $observacion);

        $obj_observaciones1 = new observaciones();
        $obj_observaciones1->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones1->setProperty('id_servicio', $id_servicio);
        $obj_observaciones1->setProperty('tipo_observacion', $tipo_observacion1);
        $obj_observaciones1->setProperty('observacion', $cursos);

        $obj_observaciones2 = new observaciones();
        $obj_observaciones2->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones2->setProperty('id_servicio', $id_servicio);
        $obj_observaciones2->setProperty('tipo_observacion', $tipo_observacion2);
        $obj_observaciones2->setProperty('observacion', $edu_no_formal);

        CtrAdmisionesPolPre::crear($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen);
        
        $result = $obj_observaciones->insert();
        $result1 = $obj_observaciones1->insert();
        $result2 = $obj_observaciones2->insert();
        if ($result1['success']) {
            return BaseResponse::success($result2);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result2);
        }
    }//Fin de Crear una Observacion General con el tipo al que corresponde y Admitio

    //Crear una Observacion General con el tipo al que corresponde y Admitio
    public static function crearAdmitioLicorSustanciasRutina($id_solicitud, $id_servicio, $tipo_observacion, $observacion, $tipo_observacion_sustancias, $observacion_sustancias, $item_poligrafia, $admitio, $resumen, $item_poligrafia_sustancias, $admitio_sustancias, $resumen_sustancias)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        $obj_observaciones = new observaciones();
        $obj_observaciones->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones->setProperty('id_servicio', $id_servicio);
        $obj_observaciones->setProperty('tipo_observacion', $tipo_observacion);
        $obj_observaciones->setProperty('observacion', $observacion);

        $obj_observaciones1 = new observaciones();
        $obj_observaciones1->setProperty('id_solicitud', $id_solicitud);
        $obj_observaciones1->setProperty('id_servicio', $id_servicio);
        $obj_observaciones1->setProperty('tipo_observacion', $tipo_observacion_sustancias);
        $obj_observaciones1->setProperty('observacion', $observacion_sustancias);
        
        CtrAdmisionesPolPre::crear($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen);
        CtrAdmisionesPolPre::crear($id_solicitud, $id_servicio, $item_poligrafia_sustancias, $admitio_sustancias, $resumen_sustancias);
        
        $result = $obj_observaciones->insert();
        $result1 = $obj_observaciones1->insert();
        if ($result1['success']) {
            return BaseResponse::success($result1);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result1);
        }
    }//Fin de Crear una Observacion General con el tipo al que corresponde y Admitio

    //Actualizar una Observacion General con el tipo al que corresponde
    public static function update($id_observacion, $observacion)
    {
        if (!isset($id_observacion) || $id_observacion == "")
            return Result::error(__FUNCTION__, "id Observacion es requerido");


        $dao = new observaciones($id_observacion);
        $dao->setProperty('observacion', $observacion);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de una Observacion General con el tipo al que corresponde


    //Actualizar una Observacion General con el tipo al que corresponde
    public static function updateAdmitio($id_solicitud, $id_servicio, $id_observacion, $observacion, $item_poligrafia, $admitio, $resumen)
    {
        if (!isset($id_observacion) || $id_observacion == "")
            return Result::error(__FUNCTION__, "id Observacion es requerido");


        $dao = new observaciones($id_observacion);
        $dao->setProperty('observacion', $observacion);
        
        CtrAdmisionesPolPre::update_items($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de una Observacion General con el tipo al que corresponde

    //Actualizar una Observacion General con el tipo al que corresponde
    public static function updateAdmitioCursos($id_solicitud, $id_servicio, $id_observacion, $observacion, $item_poligrafia, $admitio, $resumen, $id_observacion2, $tipo_observacion1, $cursos, $id_observacion3, $tipo_observacion2, $edu_no_formal)
    {
        if (!isset($id_observacion) || $id_observacion == "")
            return Result::error(__FUNCTION__, "id Observacion es requerido");

        /*if (!isset($id_observacion2) || $id_observacion2 == "")
            return Result::error(__FUNCTION__, "id Observacion2 es requerido");*/

        /*if (!isset($id_observacion3) || $id_observacion3 == "")
            return Result::error(__FUNCTION__, "id Observacion3 es requerido");*/


        $dao = new observaciones($id_observacion);
        $dao->setProperty('observacion', $observacion);

        $dao2 = new observaciones($id_observacion2);
        $dao2->setProperty('observacion', $cursos);

        $dao3 = new observaciones($id_observacion3);
        $dao3->setProperty('observacion', $edu_no_formal);
        
        CtrAdmisionesPolPre::update_items($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen);

        $result =  $dao->update();
        $result2 =  $dao2->update();
        $result3 =  $dao3->update();

        if ($result2['success']) {
            return Result::success($result2);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result2);
        }
    }//Fin de una Observacion General con el tipo al que corresponde

    //Actualizar una Observacion General con el tipo al que corresponde
    public static function updateAdmitioAlcoholSustancias($id_solicitud, $id_servicio, $id_observacion, $observacion, $id_observacion_sustancias, $observacion_sustancias, $item_poligrafia, $admitio, $resumen, $item_poligrafia_sustancias, $admitio_sustancias, $resumen_sustancias)
    {
        if (!isset($id_observacion) || $id_observacion == "")
            return Result::error(__FUNCTION__, "id Observacion es requerido");

        if (!isset($id_observacion_sustancias) || $id_observacion_sustancias == "")
            return Result::error(__FUNCTION__, "id Observacion es requerido");


        $dao = new observaciones($id_observacion);
        $dao->setProperty('observacion', $observacion);

        $dao1 = new observaciones($id_observacion_sustancias);
        $dao1->setProperty('observacion', $observacion_sustancias);
        
        CtrAdmisionesPolPre::update_items($id_solicitud, $id_servicio, $item_poligrafia, $admitio, $resumen);
        CtrAdmisionesPolPre::update_items($id_solicitud, $id_servicio, $item_poligrafia_sustancias, $admitio_sustancias, $resumen_sustancias);

        $result1 =  $dao1->update();
        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de una Observacion General con el tipo al que corresponde

    //Editar un registro de formacion academica del candidato
    public static function observacionById($id_solicitud, $id_servicio, $tipo_observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
            if (!isset($tipo_observacion) || $tipo_observacion == "")
            return Result::error(__FUNCTION__, "id tipo observacion es requerido");
        $result = QuerySQL::select(
            <<<SQL
                select o.id_observacion, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.tipo_observacion, 
                        o.observacion 
                    from observaciones o 
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
                    and o.tipo_observacion = :tipo_observacion 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "tipo_observacion" => $tipo_observacion),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }//Fin de Editar un registro de formacion academica del candidato

    //Editar un registro de formacion academica del candidato
    public static function observacionCursosById($id_solicitud, $id_servicio, $tipo_observacion, $tipo_observacion_dos, $tipo_observacion_tres)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!isset($tipo_observacion) || $tipo_observacion == "")
            return Result::error(__FUNCTION__, "id tipo observacion es requerido");
        
        $result = QuerySQL::select(
            <<<SQL
                select o.id_observacion, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.tipo_observacion, 
                        o.observacion,
                        o2.id_observacion as id_observacion2, 
                        o2.tipo_observacion as tipo_observacion_cursos, 
                        o2.observacion as observacion_cursos,
                        o3.id_observacion as id_observacion3, 
                        o3.tipo_observacion as tipo_observacion_no_formal, 
                        o3.observacion as observacion_no_formal
                    from observaciones o, observaciones o2, observaciones o3
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
                    and o.tipo_observacion = :tipo_observacion
                    and o2.id_solicitud  = :id_solicitud
                    and o2.id_servicio = :id_servicio
                    and o2.tipo_observacion = :tipo_observacion_dos
                    and o3.id_solicitud  = :id_solicitud
                    and o3.id_servicio = :id_servicio
                    and o3.tipo_observacion = :tipo_observacion_tres
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "tipo_observacion" => $tipo_observacion, "tipo_observacion_dos" => $tipo_observacion_dos, "tipo_observacion_tres" => $tipo_observacion_tres),
            false,
            "N"
        );

        return Result::success($result, "buscar observación formacion pol_pre");
    }//Fin de Editar un registro de formacion academica del candidato


    //Editar un registro de formacion academica del candidato
    public static function observacionCursosByIdRutina($id_solicitud, $id_servicio, $tipo_observacion, $tipo_observacion_dos, $tipo_observacion_tres)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        if (!isset($tipo_observacion) || $tipo_observacion == "")
            return Result::error(__FUNCTION__, "id tipo observacion es requerido");
        
        $result = QuerySQL::select(
            <<<SQL
                select o.id_observacion, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.tipo_observacion, 
                        o.observacion,
                        o3.id_observacion as id_observacion3, 
                        o3.tipo_observacion as tipo_observacion_no_formal, 
                        o3.observacion as observacion_no_formal
                    from observaciones o, observaciones o3
                    where o.id_solicitud  = :id_solicitud
                    and o.id_servicio = :id_servicio
                    and o.tipo_observacion = :tipo_observacion
                    and o3.id_solicitud  = :id_solicitud
                    and o3.id_servicio = :id_servicio
                    and o3.tipo_observacion = :tipo_observacion_tres
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "tipo_observacion" => $tipo_observacion, "tipo_observacion_dos" => $tipo_observacion_dos, "tipo_observacion_tres" => $tipo_observacion_tres),
            false,
            "N"
        );

        return Result::success($result, "buscar observación formacion pol_rutina");
    }//Fin de Editar un registro de formacion academica del candidato

    //Editar un registro de formacion academica del candidato
    public static function observacionSustanciaLicorById($id_solicitud, $id_servicio, $tipo_observacion, $tipo_observacion_sustancias)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
            if (!isset($tipo_observacion) || $tipo_observacion == "")
            return Result::error(__FUNCTION__, "id tipo observacion es requerido");
        $result = QuerySQL::select(
            <<<SQL
                SELECT o.id_observacion, 
                    o.id_solicitud, 
                    o.id_servicio, 
                    o.tipo_observacion, 
                    o.observacion 
                FROM observaciones o 
                WHERE o.id_solicitud = :id_solicitud
                AND o.id_servicio = :id_servicio
                AND (o.tipo_observacion = :tipo_observacion OR o.tipo_observacion = :tipo_observacion_sustancias)
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "tipo_observacion" => $tipo_observacion, "tipo_observacion_sustancias" => $tipo_observacion_sustancias),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }//Fin de Editar un registro de formacion academica del candidato
    
    //Editar un registro de formacion academica del candidato
    public static function observacionSinSrvById($id_solicitud, $tipo_observacion)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($tipo_observacion) || $tipo_observacion == "")
        return Result::error(__FUNCTION__, "id tipo observacion es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select o.id_observacion, 
                        o.id_solicitud, 
                        o.id_servicio, 
                        o.tipo_observacion, 
                        o.observacion 
                    from observaciones o 
                    where o.id_solicitud  = :id_solicitud
                    and o.tipo_observacion = :tipo_observacion 
            SQL,
            array("id_solicitud" => $id_solicitud,"tipo_observacion" => $tipo_observacion),
            false,
            "N"
        );

        return Result::success($result, "buscar observación");
    }//Fin de Editar un registro de formacion academica del candidato
}
