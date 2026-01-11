<?php

class CtrVivConceptoProfesional
{
    //Crear una distribucion de la vivienda
    public static function crear($id_solicitud, 
                                 $id_servicio, 
                                 $expectativas, 
                                 $metas, 
                                 $medio_hv, 
                                 $condicion_laboral, 
                                 $concepto_final, 
                                 $observacion, 
                                 $requisito, 
                                 $calificacion,
                                 $hallazgo, 
                                 $concepto_pertenece,
                                 $pregunta_uno,
                                 $pregunta_dos,
                                 $pregunta_tres,
                                 $otro_dos,
                                 $otro_tres,
                                 $asociado_confiable,
                                 $referencia)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        
        /*if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id servicio es requerido");
        */

        $obj_vivConceptoProfesional = new VivConceptoProfesional();
        $obj_vivConceptoProfesional->setProperty('id_solicitud', $id_solicitud);
        $obj_vivConceptoProfesional->setProperty('id_servicio', $id_servicio);
        $obj_vivConceptoProfesional->setProperty('expectativas', $expectativas);
        $obj_vivConceptoProfesional->setProperty('metas', $metas);
        $obj_vivConceptoProfesional->setProperty('medio_hv', $medio_hv);
        $obj_vivConceptoProfesional->setProperty('condicion_laboral', $condicion_laboral);
        $obj_vivConceptoProfesional->setProperty('concepto_final', $concepto_final);
        $obj_vivConceptoProfesional->setProperty('observacion', $observacion);
        $obj_vivConceptoProfesional->setProperty('requisito', $requisito);
        $obj_vivConceptoProfesional->setProperty('calificacion', $calificacion);
        $obj_vivConceptoProfesional->setProperty('hallazgo', $hallazgo);
        $obj_vivConceptoProfesional->setProperty('concepto_pertenece', $concepto_pertenece);
        $obj_vivConceptoProfesional->setProperty('pregunta_uno', $pregunta_uno);
        $obj_vivConceptoProfesional->setProperty('pregunta_dos', $pregunta_dos);
        $obj_vivConceptoProfesional->setProperty('pregunta_tres', $pregunta_tres);
        $obj_vivConceptoProfesional->setProperty('otro_dos', $otro_dos);
        $obj_vivConceptoProfesional->setProperty('otro_tres', $otro_tres);
        $obj_vivConceptoProfesional->setProperty('asociado_confiable', $asociado_confiable); 
        $obj_vivConceptoProfesional->setProperty('referencia', $referencia);    

        $result = $obj_vivConceptoProfesional->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda

    // Crear una distribucion de la vivienda
    public static function crear_confiabilidad($registros)
    {
        //print_r($registros);
        // Iterar sobre cada registro en el array
        foreach ($registros as $registro) {
            $resultado = CtrVivConceptoProfesional::crear($registro['id_solicitud'],
                                                        $registro['id_servicio'],
                                                        $registro['expectativas'],
                                                        $registro['metas'],
                                                        $registro['medio_hv'],
                                                        $registro['condicion_laboral'],
                                                        $registro['concepto_final'],
                                                        $registro['observacion'],
                                                        $registro['requisito'],
                                                        $registro['calificacion'],
                                                        $registro['hallazgo'],
                                                        $registro['concepto_pertenece'],
                                                        $registro['pregunta_uno'],
                                                        $registro['pregunta_dos'],
                                                        $registro['pregunta_tres'],
                                                        $registro['otro_dos'],
                                                        $registro['otro_tres'],
                                                        $registro['asociado_confiable'],
                                                        $registro['referencia']);

            //print_r($resultado);
        }
        // Después de procesar todos los registros, se retorna un éxito
        return BaseResponse::success('Registros creados exitosamente');
    }

    // Crear una distribucion de la vivienda
    public static function update_confiabilidad($registros)
    {
        //print_r($registros);
        // Iterar sobre cada registro en el array
        foreach ($registros as $registro) {
            $resultado = CtrVivConceptoProfesional::update($registro['id_concepto'],
                                                        $registro['expectativas'],
                                                        $registro['metas'],
                                                        $registro['medio_hv'],
                                                        $registro['condicion_laboral'],
                                                        $registro['concepto_final'],
                                                        $registro['observacion'],
                                                        $registro['referencia']);

            //print_r($resultado);
        }
        // Después de procesar todos los registros, se retorna un éxito
        return BaseResponse::success('Registros actualizados exitosamente');
    }


    //Editar un registro de formacion academica del candidato
    public static function findByIdConcepto($id_solicitud, $id_servicio)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return Result::error(__FUNCTION__, "id servicio es requerido");
        $result = QuerySQL::select(
            <<<SQL
                select vc.*, 
                fcn_desc_configurations('tipo_concepto_profesional', vc.concepto_final) des_concepto,
                fcn_desc_configurations('tipo_pregunta_uno_visita_asociado', vc.pregunta_uno) des_p_uno
                    from viv_concepto_profesional vc
                    where vc.id_solicitud  = :id_solicitud
                    and vc.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar dotación mobiliaria");
    }//Fin de Editar un registro de formacion academica del candidato

    public static function findByIdConceptoConfiabilidad($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");
        $result = QuerySQL::select(
            <<<SQL
            SELECT vc.*, 
                fcn_desc_configurations('tipo_concepto_profesional', vc.concepto_final) AS des_concepto
            FROM viv_concepto_profesional vc
            WHERE vc.id_solicitud = :id_solicitud
            AND vc.id_servicio IN (1, 6, 7, 11);

            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar dotación mobiliaria");
    }
    //Editar un registro de formacion academica del candidato
    public static function findByIdConceptoSinSrv($id_concepto)
    {
        if (!isset($id_concepto) || $id_concepto == "")
            return Result::error(__FUNCTION__, "id concepto es requerido");

        $result = QuerySQL::select(
            <<<SQL
                    select vc.id_concepto,
                        vc.id_solicitud,
                        vc.id_servicio,
                        vc.expectativas,
                        vc.metas,
                        vc.medio_hv,
                        vc.condicion_laboral,
                        vc.concepto_final,
                        vc.observacion, -- fcn_desc_configurations('tipo_concepto_profesional', vc.concepto_final) des_concepto
                        vc.requisito,
                        vc.calificacion,
                        vc.hallazgo,
                        vc.concepto_pertenece,
                        vc.usr_create,
                        vc.fch_create
                    from viv_concepto_profesional vc
                    where vc.id_concepto  = :id_concepto
            SQL,
            array("id_concepto" => $id_concepto),
            true,
            "N"
        );

        return Result::success($result, "buscar concepto");
    }//Fin de Editar un registro de formacion academica del candidato

    //Editar un registro de formacion academica del candidato
    public static function findByAllConceptoSinSrv($id_solicitud)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return Result::error(__FUNCTION__, "id solicitud es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vc.*, 
                        fcn_desc_configurations('tipo_concepto_profesional', vc.concepto_final) des_concepto
                    from viv_concepto_profesional vc
                    where vc.id_solicitud  = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar dotación mobiliaria");
    }//Fin de Editar un registro de formacion academica del candidato

    //Fin de Actualizar el concepto
    public static function update(
        $id_concepto,
        $expectativas, 
        $metas, 
        $medio_hv, 
        $condicion_laboral, 
        $concepto_final, 
        $observacion,
        $referencia

    ) {
        if (!isset($id_concepto) || $id_concepto == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivConceptoProfesional($id_concepto);
        $dao->setProperty('expectativas', $expectativas);
        $dao->setProperty('metas', $metas);
        $dao->setProperty('medio_hv', $medio_hv);
        $dao->setProperty('condicion_laboral', $condicion_laboral);
        $dao->setProperty('concepto_final', $concepto_final);
        $dao->setProperty('observacion', $observacion);
        $dao->setProperty('referencia', $referencia);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar el concepto

    public static function update_vsa(
        $id_concepto,
        $pregunta_uno,
        $pregunta_dos, 
        $pregunta_tres, 
        $otro_dos, 
        $otro_tres, 
        $asociado_confiable,
        $requisito,
        $observacion

    ) {
        if (!isset($id_concepto) || $id_concepto == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivConceptoProfesional($id_concepto);
        $dao->setProperty('pregunta_uno', $pregunta_uno);
        $dao->setProperty('pregunta_dos', $pregunta_dos);
        $dao->setProperty('pregunta_tres', $pregunta_tres);
        $dao->setProperty('otro_dos', $otro_dos);
        $dao->setProperty('otro_tres', $otro_tres);
        $dao->setProperty('asociado_confiable', $asociado_confiable);
        $dao->setProperty('requisito', $requisito);
        $dao->setProperty('observacion', $observacion);        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar el concepto

    //Borrar un registro por id 
    public static function delete($id_concepto)
    {
        if (!isset($id_concepto) || $id_concepto == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivConceptoProfesional($id_concepto);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id
}
