<?php

class CtrDimRespuestas
{
    //Crear una formacion academica
    public static function crear($id_pregunta, $id_solicitud, $id_servicio, $nivel_riesgo, $respuesta)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_dimRespuesta = new DimRespuestas();
        $obj_dimRespuesta->setProperty('id_pregunta', $id_pregunta);
        $obj_dimRespuesta->setProperty('id_solicitud', $id_solicitud);
        $obj_dimRespuesta->setProperty('id_servicio', $id_servicio);
        $obj_dimRespuesta->setProperty('nivel_riesgo', $nivel_riesgo);
        $obj_dimRespuesta->setProperty('respuesta', $respuesta);

        

        $result = $obj_dimRespuesta->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una formacion academica

    public static function crearDimCompromiso($id_pregunta, $id_solicitud, $id_servicio, $nivel_riesgo, $respuesta)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        if ($id_servicio == 6) {
            $obj_dimRespuesta1 = new DimRespuestas();
            $obj_dimRespuesta1->setProperty('id_pregunta', $id_pregunta);
            $obj_dimRespuesta1->setProperty('id_solicitud', $id_solicitud);
            $obj_dimRespuesta1->setProperty('id_servicio', 7);
            $obj_dimRespuesta1->setProperty('nivel_riesgo', $nivel_riesgo);
            $obj_dimRespuesta1->setProperty('respuesta', $respuesta);

            $obj_dimRespuesta = new DimRespuestas();
            $obj_dimRespuesta->setProperty('id_pregunta', $id_pregunta);
            $obj_dimRespuesta->setProperty('id_solicitud', $id_solicitud);
            $obj_dimRespuesta->setProperty('id_servicio', $id_servicio);
            $obj_dimRespuesta->setProperty('nivel_riesgo', $nivel_riesgo);
            $obj_dimRespuesta->setProperty('respuesta', $respuesta);
            
            $result1 = $obj_dimRespuesta1->insert();
            $result = $obj_dimRespuesta->insert();
        }else{
            $obj_dimRespuesta1 = new DimRespuestas();
            $obj_dimRespuesta1->setProperty('id_pregunta', $id_pregunta);
            $obj_dimRespuesta1->setProperty('id_solicitud', $id_solicitud);
            $obj_dimRespuesta1->setProperty('id_servicio', 6);
            $obj_dimRespuesta1->setProperty('nivel_riesgo', $nivel_riesgo);
            $obj_dimRespuesta1->setProperty('respuesta', $respuesta);

            $obj_dimRespuesta = new DimRespuestas();
            $obj_dimRespuesta->setProperty('id_pregunta', $id_pregunta);
            $obj_dimRespuesta->setProperty('id_solicitud', $id_solicitud);
            $obj_dimRespuesta->setProperty('id_servicio', $id_servicio);
            $obj_dimRespuesta->setProperty('nivel_riesgo', $nivel_riesgo);
            $obj_dimRespuesta->setProperty('respuesta', $respuesta);
            
            $result1 = $obj_dimRespuesta1->insert();
            $result = $obj_dimRespuesta->insert();
        }


        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Crear una formacion academica
    public static function crearAntecedentesArray($id_pregunta, $id_solicitud, $id_servicio, $nivel_riesgo, $respuesta, $array_area)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $texto_concatenado = ''; // Inicializar el texto concatenado

        // Recorrer el arreglo de validación obtenido en la consulta anterior
        foreach ($array_area as $data) {
            // Verificar si la opción es 'si'
            if ($data['opcion'] == 'si') {
                // Concatenar el valor asociado al texto
                $texto_concatenado .= $data['valor'] . ', ';
            }
        }
        
        // Eliminar la última coma y el espacio después de la última iteración
        $texto_concatenado = rtrim($texto_concatenado, ', ');

        $obj_dimRespuesta = new DimRespuestas();
        $obj_dimRespuesta->setProperty('id_pregunta', $id_pregunta);
        $obj_dimRespuesta->setProperty('id_solicitud', $id_solicitud);
        $obj_dimRespuesta->setProperty('id_servicio', $id_servicio);
        $obj_dimRespuesta->setProperty('nivel_riesgo', $nivel_riesgo);
        //$obj_dimRespuesta->setProperty('respuesta', $texto_concatenado);

        // Crear o actualizar registros adicionales a partir de $array_area
        foreach ($array_area as $area) {
            $validacion = CtrPreguntaSaludPolPre::findAllByComboCodigo($area['aspectoviv'],$area['codigo'], $area['id_solicitud'],$area['id_servicio']);

            // Verificar si la consulta fue exitosa y si hay datos en la respuesta
            if ($validacion['status'] == 'success' && !empty($validacion['data'])) {
                // Iterar sobre los datos obtenidos
                foreach ($validacion['data'] as $data) {
                    // Imprimir el valor de id_preg_salud_pol
                    //echo "Valor de id_preg_salud_pol: " . $data['id_preg_salud_pol'] . "\n";
                    //print_r("PUT");
                    $resultado = CtrPreguntaSaludPolPre::updateAntrecedentesArray(
                        $data['id_preg_salud_pol'],
                        $area['valor'],
                        $area['opcion']);
                }
            } else {
                //echo "No se encontraron datos para la consulta.\n";
                //print_r("POST");
                $resultado = CtrPreguntaSaludPolPre::crear(
                    $id_solicitud,
                    $id_servicio,
                    $area['codigo'],
                    $area['aspectoviv'],
                    $area['valor'],
                    $area['opcion'],
                    $area['id_pregunta'],);

                //print_r($resultado);
            }
            
        }

        $result = $obj_dimRespuesta->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
    //Crear una formacion academica
    public static function crearAntecedentes(
        $id_pre_fuente,
        $id_solicitud,
        $id_servicio,
        $p_fecha,
        $p_nombre,
        $p_numcupo,
        $p_fecha_eps,
        $p_nom_eps,
        $p_tipo_eps,
        $p_seleccion,
        $p_fecha_runt,
        $p_nombre_cand_runt,
        $p_numcupo_runt,
        $p_categoria,
        $p_estado,
        $p_num_libreta
    ) {
        // Define un array con los parámetros que quieres verificar
        $parametros = [
            'p_fecha' => $p_fecha,
            'p_nombre' => $p_nombre,
            'p_numcupo' => $p_numcupo,
            'p_fecha_eps' => $p_fecha_eps,
            'p_nom_eps' => $p_nom_eps,
            'p_tipo_eps' =>  $p_tipo_eps,
            'p_seleccion' => $p_seleccion,
            'p_fecha_runt' => $p_fecha_runt,
            'p_nombre_cand_runt' => $p_nombre_cand_runt,
            'p_numcupo_runt' => $p_numcupo_runt,
            'p_categoria' => $p_categoria,
            'p_estado' =>  $p_estado,
            'p_num_libreta' => $p_num_libreta
        ];
    
        foreach ($parametros as $nombre_variable => $respuesta) {
            if ($respuesta !== null && $respuesta !== "") {
                CtrDimRespuestas::crearAntecedentesDoc($id_pre_fuente, $id_solicitud, $id_servicio, $respuesta, $nombre_variable);
            }
        }
    }
    //Fin de Crear una formacion academica

    //Crear una formacion academica
    public static function crearAntecedentesDoc($id_pre_fuente,
                                                $id_solicitud,
                                                $id_servicio,
                                                $respuesta,
                                                $nombre_variable)
    {
        //print_r($nombre_variable);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");
        if (!isset($nombre_variable) || $nombre_variable == "")
            return BaseResponse::error(__FUNCTION__, "nombre variable es requerido".$nombre_variable);

        $obj_dimRespuesta = new respFuenteConsultada();
        $obj_dimRespuesta->setProperty('id_pre_fuente', $id_pre_fuente);
        $obj_dimRespuesta->setProperty('id_solicitud', $id_solicitud);
        $obj_dimRespuesta->setProperty('id_servicio', $id_servicio);
        $obj_dimRespuesta->setProperty('respuesta', $respuesta);
        $obj_dimRespuesta->setProperty('nombre_variable', $nombre_variable);

        

        $result = $obj_dimRespuesta->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una formacion academica


    //actualizar documentos
    public static function updateAntecedentes(
        $id_pre_fuente,
        $id_solicitud,
        $id_servicio,
        $p_fecha,
        $p_nombre,
        $p_numcupo,
        $p_fecha_eps,
        $p_nom_eps,
        $p_tipo_eps,
        $p_seleccion,
        $p_fecha_runt,
        $p_nombre_cand_runt,
        $p_numcupo_runt,
        $p_categoria,
        $p_estado,
        $p_num_libreta
    ) {
        // Define un array con los parámetros que quieres verificar
        $parametros = [
            'p_fecha' => $p_fecha,
            'p_nombre' => $p_nombre,
            'p_numcupo' => $p_numcupo,
            'p_fecha_eps' => $p_fecha_eps,
            'p_nom_eps' => $p_nom_eps,
            'p_tipo_eps' =>  $p_tipo_eps,
            'p_seleccion' => $p_seleccion,
            'p_fecha_runt' => $p_fecha_runt,
            'p_nombre_cand_runt' => $p_nombre_cand_runt,
            'p_numcupo_runt' => $p_numcupo_runt,
            'p_categoria' => $p_categoria,
            'p_estado' =>  $p_estado,
            'p_num_libreta' => $p_num_libreta
        ];
    
        foreach ($parametros as $nombre_variable => $respuesta) {
            if ($respuesta !== null && $respuesta !== "") {
                CtrDimRespuestas::saberIdDocumentosYActualizarRespuesta($id_pre_fuente, $id_solicitud, $id_servicio, $respuesta, $nombre_variable);
            }
        }
    }
    //fin Actualizar una formacion documentos


// Actualizar un registro existente
public static function saberIdDocumentosYActualizarRespuesta($id_pre_fuente, $id_solicitud, $id_servicio, $respuesta, $nombre_variable) {
    // Busca si existe un registro con los parámetros proporcionados
    $result = QuerySQL::select(
        <<<SQL
        SELECT *
        FROM resp_fuente_consultada rfc
        WHERE rfc.id_pre_fuente = :id_pre_fuente
        AND rfc.id_solicitud = :id_solicitud
        AND rfc.id_servicio = :id_servicio
        AND rfc.nombre_variable = :nombre_variable
        SQL,
        array("id_pre_fuente" => $id_pre_fuente, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "nombre_variable" => $nombre_variable),
        true,
        "N"
    );

    if ($result) {
        //print_r($result);
        // Si existe un registro, actualiza su campo de respuesta
        $id_resp_fuente = $result[0]['id_resp_fuente']; // Suponiendo que solo se espera un registro
        $id_pre_fuente = $result[0]['id_pre_fuente'];
        $id_solicitud = $result[0]['id_solicitud'];
        $id_servicio = $result[0]['id_servicio'];
        $nombre_variable = $result[0]['nombre_variable'];
        $registro = $result[0];
        $registro['respuesta'] = $respuesta;
        
        CtrDimRespuestas::updateAntecedentesDoc($id_resp_fuente, $id_pre_fuente, $id_solicitud, $id_servicio, $registro['respuesta'], $nombre_variable);
    }
}

    //Actualizar una formacion documentos
    public static function updateAntecedentesDoc($id_resp_fuente,
                                                $id_pre_fuente,
                                                $id_solicitud,
                                                $id_servicio,
                                                $respuesta,
                                                $nombre_variable)
    {
        //print_r($nombre_variable);
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");
        if (!isset($nombre_variable) || $nombre_variable == "")
            return BaseResponse::error(__FUNCTION__, "nombre variable es requerido".$nombre_variable);

        $dao = new respFuenteConsultada($id_resp_fuente);
        $dao->setProperty('id_pre_fuente', $id_pre_fuente);
        $dao->setProperty('id_solicitud', $id_solicitud);
        $dao->setProperty('id_servicio', $id_servicio);
        $dao->setProperty('respuesta', $respuesta);
        $dao->setProperty('nombre_variable', $nombre_variable);

        $result = $dao->update();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }    //fin Actualizar una formacion documentos

    //listar las preguntas del candidato para la dimensiones
    public static function findAllVariables($id_servicio, $id_dimension)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, 
                   dp.nombre_pregunta,
                   dp.descripcion 
            FROM dimensiones d, dim_preguntas dp 
            WHERE dp.id_servicio = :id_servicio
            AND dp.id_dimension = :id_dimension
            AND d.id_dimension = dp.id_dimension 
            SQL,
            array("id_servicio" => $id_servicio, "id_dimension" => $id_dimension),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin listar las preguntas del candidato para la dimensiones

    //listar las preguntas del candidato para la dimensiones
    public static function findAllVariablesRutina($id_servicio, $id_dimension)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, 
                   dp.nombre_pregunta,
                   dp.descripcion 
            FROM dimensiones d, dim_preguntas dp 
            WHERE dp.id_servicio = :id_servicio
            AND dp.id_dimension = :id_dimension
            AND d.id_dimension = dp.id_dimension
            AND dp.id_pregunta != 73 
            SQL,
            array("id_servicio" => $id_servicio, "id_dimension" => $id_dimension),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin listar las preguntas del candidato para la dimensiones

    //listar las preguntas del candidato para la dimension familiar
    public static function findAllVariableDescripcionVM($id_pregunta)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, dp.nombre_pregunta, dp.descripcion, dp.plantilla
            FROM dim_preguntas dp 
            WHERE dp.id_pregunta = :id_pregunta
            SQL,
            array("id_pregunta" => $id_pregunta),
            true,
            "N"
        );

        return Result::success($result, "buscar familiar visita mantenimiento");
    }//Fin listar las preguntas del candidato para la dimension familia

    //listar las preguntas del candidato para la dimension financiero estudio confiabilidad
    public static function findAllVariablesFinancieroEC($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, dp.nombre_pregunta 
            FROM dimensiones d, dim_preguntas dp 
            WHERE d.id_servicio = 11
            AND d.id_dimension = dp.id_dimension 
            AND dp.id_dimension = 12
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar financiero");
    }//Fin listar las preguntas del candidato para la dimension financiero estudio confiabilidad

    //listar las preguntas del candidato para la dimension academico estudio confiabilidad
    public static function findAllVariablesAcademicoEC($id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, dp.nombre_pregunta 
            FROM dimensiones d, dim_preguntas dp 
            WHERE d.id_servicio = :id_servicio
            AND d.id_dimension = dp.id_dimension 
            AND dp.id_dimension = 13
            SQL,
            array("id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar academico");
    }//Fin listar las preguntas del candidato para la dimension academico estudio confiabilidad

    // Validación dimencion de Verificacion Academica gvanegas 15032024
    public static function ValidacionDimension($id_solicitud, $id_servicio, $id_dimension){

        $result = QuerySQL::select(
            <<<SQL
                SELECT d.nombre_dimension, TRUNCATE(SUM(dp.puntaje *(c.observacion/3)),1) as porcentaje
                  FROM dimensiones d, 
                       dim_preguntas dp, 
                       dim_respuestas dr, 
                       configurations c 
                 WHERE 1 = 1
                    AND d.id_dimension = dp.id_dimension
                    AND dp.id_pregunta = dr.id_pregunta
                    AND categoria  = 'tipo_nivel_riesgo'
                    AND dr.nivel_riesgo = c.codigo 
                    AND dr.id_servicio = :id_servicio
                    AND dr.id_solicitud = :id_solicitud
                    AND d.id_dimension = :id_dimension
                    GROUP BY d.id_dimension
            SQL,
            array("id_solicitud" => $id_solicitud,
                  "id_servicio"  => $id_servicio,
                  "id_dimension" => $id_dimension),
            true,
            "N"
        );
    
        return Result::success($result);
    
    }
    //listar las preguntas del candidato para la dimension compromiso estudio confiabilidad
    public static function findAllVariablesCompromisoEC($id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, dp.nombre_pregunta 
            FROM dimensiones d, dim_preguntas dp 
            WHERE d.id_servicio = :id_servicio
            AND d.id_dimension = dp.id_dimension 
            AND (dp.id_dimension = 16 OR dp.id_dimension = 15);
            SQL,
            array("id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar compromiso");
    }//Fin listar las preguntas del candidato para la dimension compromiso estudio confiabilidad

    //listar las preguntas del candidato para la dimension financiero
    public static function findAllVariablesCompromisoPolPre($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT dp.id_pregunta, dp.nombre_pregunta 
            FROM dimensiones d, dim_preguntas dp 
            WHERE d.id_servicio = 8 
            AND d.id_dimension = dp.id_dimension 
            AND dp.id_dimension = 17 
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar Compromiso");
    }//Fin listar las preguntas del candidato para la dimension financiero

    //Trae la descripcion de las respuestas de las dimenciones
    public static function descripcionDimension($id_solicitud, $id_dimension, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                select dr.id_respuesta, 
                       dr.id_pregunta, 
                       dr.nivel_riesgo, 
                       dr.respuesta, 
                       dr.id_solicitud, 
                       dr.id_servicio,
                       dp.nombre_pregunta,
                       dp.descripcion,
                       dr.texto_completo,
                       fcn_desc_configurations('tipo_nivel_riesgo', dr.nivel_riesgo) descripcion_niv_riesgo
                from dim_respuestas dr, dim_preguntas dp
                where dr.id_solicitud = :id_solicitud 
                and dp.id_dimension = :id_dimension
                and dr.id_servicio = :id_servicio
                and dr.id_pregunta = dp.id_pregunta
                ORDER BY id_pregunta ASC;
            SQL,
            array("id_solicitud" => $id_solicitud, "id_dimension" => $id_dimension, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables familiares");
    
    }

    //Trae la descripcion de las respuestas de las dimenciones
    public static function descripcionDimensionEstudioConfiabilidad($id_solicitud, $id_dimension , $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                select dr.id_respuesta, 
                       dr.id_pregunta, 
                       dr.nivel_riesgo, 
                       dr.respuesta, 
                       dr.id_solicitud, 
                       dr.id_servicio,
                       dp.nombre_pregunta,
                       dp.descripcion,
                       dr.texto_completo,
                       fcn_desc_configurations('tipo_nivel_riesgo', dr.nivel_riesgo) descripcion_niv_riesgo
                from dim_respuestas dr, dim_preguntas dp
                where dr.id_solicitud = :id_solicitud 
                and dp.id_dimension = :id_dimension
                and dr.id_servicio = :id_servicio
                and dr.id_pregunta = dp.id_pregunta
                ORDER BY id_pregunta ASC;
            SQL,
            array("id_solicitud" => $id_solicitud, "id_dimension" => $id_dimension, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables familiares");
    
    }

    //Trae la descripcion de las respuestas de las dimenciones
    public static function descripcionDimensionByPreguntaAntecedentes($id_solicitud, $id_dimension, $id_servicio, $id_pregunta){

        $result = QuerySQL::select(
            <<<SQL
                select dr.id_respuesta, 
                       dr.id_pregunta, 
                       dr.nivel_riesgo, 
                       dr.respuesta, 
                       dr.id_solicitud, 
                       dr.id_servicio,
                       dp.nombre_pregunta,
                       dp.descripcion,
                       dr.texto_completo,
                       fcn_desc_configurations('tipo_nivel_riesgo', dr.nivel_riesgo) descripcion_niv_riesgo
                from dim_respuestas dr, dim_preguntas dp
                where dr.id_solicitud = :id_solicitud 
                and dp.id_dimension = :id_dimension
                and dr.id_servicio = :id_servicio
                and dr.id_pregunta = :id_pregunta
                and dp.id_pregunta = :id_pregunta
            SQL,
            array("id_solicitud" => $id_solicitud, "id_dimension" => $id_dimension, "id_servicio" => $id_servicio, "id_pregunta" => $id_pregunta),
            true,
            "N"
        );
    
        return Result::success($result, "buscar respuesta del Antecedente");
    
    }

    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionCompromisodimensionPolPre($id_solicitud, $id_dimension, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                select dr.id_respuesta, 
                       dr.id_pregunta, 
                       dr.nivel_riesgo, 
                       dr.respuesta, 
                       dr.id_solicitud, 
                       dr.id_servicio,
                       dp.nombre_pregunta,
                       fcn_desc_configurations('tipo_compromiso_pol_pre', dr.nivel_riesgo) descripcion_niv_riesgo
                from dim_respuestas dr, dim_preguntas dp
                where dr.id_solicitud = :id_solicitud 
                and dp.id_dimension = :id_dimension
                and dr.id_servicio = :id_servicio
                and dr.id_pregunta = dp.id_pregunta

            SQL,
            array("id_solicitud" => $id_solicitud, "id_dimension" => $id_dimension, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables familiares");
    
    }
    //Trae el nombre de la empresa y retorna el tipo de documento
    public static function descripcionTextoAntecedente($id_solicitud, $id_pre_fuente, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
            SELECT rfc.id_resp_fuente,
                rfc.id_pre_fuente,
                rfc.id_solicitud,
                rfc.id_servicio,
                rfc.respuesta,
                pfc.texto, 
                pfc.orden, 
                pfc.variable
            FROM resp_fuente_consultada rfc
            INNER JOIN pre_fuente_consultada pfc ON rfc.id_pre_fuente = pfc.no_pregunta
            WHERE rfc.id_solicitud = :id_solicitud 
            AND rfc.id_servicio = :id_servicio
            AND rfc.id_pre_fuente = :id_pre_fuente
            AND (rfc.nombre_variable = pfc.variable OR pfc.variable = '' OR pfc.variable IS NULL)
            GROUP BY pfc.texto
            ORDER BY pfc.orden ASC; 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_pre_fuente" => $id_pre_fuente, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables textos antecedentes");
    
    }
   
    //Trae la pregunta y respuesta concatenada en una sola linea
    public static function respFuenteConsultada($id_solicitud, $id_servicio, $id_pre_fuente){

        $result = QuerySQL::select(
            <<<SQL
            SELECT GROUP_CONCAT(REPLACE(pfc.texto, '&nbsp;', rfc.respuesta) SEPARATOR ' ') AS text_conca
              FROM resp_fuente_consultada rfc
             INNER JOIN pre_fuente_consultada pfc ON rfc.id_pre_fuente = pfc.no_pregunta
             WHERE rfc.id_solicitud = :id_solicitud 
               AND rfc.id_servicio = :id_servicio
               AND rfc.id_pre_fuente = :id_pre_fuente
               AND (rfc.nombre_variable = pfc.variable OR pfc.variable = '' OR pfc.variable IS NULL)
             GROUP BY rfc.id_solicitud, rfc.id_servicio, rfc.id_pre_fuente
             ORDER BY pfc.orden ASC; 
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "id_pre_fuente" => $id_pre_fuente),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables textos antecedentes");
    
    }

    public static function fuentesConsultadas($id_solicitud, $id_servicio, $id_pregunta){

        $result = QuerySQL::select(
            <<<SQL
            SELECT pspp.categoria,
                pspp.codigo,
                pspp.descripcion as texto_completo,
                fcn_desc_configurations(pspp.categoria , pspp.codigo) fuente,
                CASE pspp.descripcion
                when 'Sin hallazgo' THEN pspp.descripcion
                ELSE 'Con hallazgo'  end as descripcion
                -- pspp.descripcion
            FROM dim_respuestas dr, preguntas_salud_pol_pre pspp
            WHERE pspp.id_pregunta = dr.id_pregunta
            AND pspp.id_pregunta  = :id_pregunta
            AND pspp.id_solicitud = dr.id_solicitud
            AND pspp.id_servicio = :id_servicio
            AND pspp.id_solicitud = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "id_pregunta" => $id_pregunta),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables textos antecedentes");
    
    }

    //Editar un registro de formacion academica del candidato
    public static function findByIdDimRespuesta($id_respuesta)
    {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select dr.id_respuesta, dr.id_pregunta, dr.id_solicitud, dr.nivel_riesgo, dr.respuesta, dr.usr_create, dr.fch_create
                    from dim_respuestas dr, sol_solicitud ss
                    where dr.id_solicitud = ss.id_solicitud
                    and dr.id_respuesta = :id_respuesta 
            SQL,
            array("id_respuesta" => $id_respuesta),
            false,
            "N"
        );

        return Result::success($result, "buscar respuesta de dimension");
    }//Fin de Editar un registro de formacion academica del candidato

    //Borrar un registro por id
    public static function delete($id_respuesta)
    {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new DimRespuestas($id_respuesta);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id



    //Borrar un registro por id
    public static function deleteCompromiso($id_respuesta, $id_pregunta, $id_solicitud, $id_servicio)
    {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $id_servicio_sel = 0;

        if ($id_servicio == 6) {
            $id_servicio_sel = 7;
        }else{
            $id_servicio_sel = 6;
        }
        $result1 = QuerySQL::select(
            <<<SQL
                DELETE FROM dim_respuestas
                WHERE id_pregunta = :id_pregunta
                AND id_solicitud = :id_solicitud
                AND id_servicio = :id_servicio_sel;
            SQL,
            array("id_pregunta" => $id_pregunta, "id_solicitud" => $id_solicitud, "id_servicio_sel" => $id_servicio_sel),
            true,
            "N"
        );
        $dao = new DimRespuestas($id_respuesta);
        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

// Borrar un registro por id ademas borra las otras asociadas por fuente consultada
public static function delete_doc($id_respuesta, $id_pregunta, $id_solicitud, $id_servicio)
{
    if (!isset($id_respuesta) || $id_respuesta == "") {
        return Result::error(__FUNCTION__, "id es requerido");
    }

    // Primero, elimina los registros asociados
    self::eliminarRegistrosAsociados($id_pregunta, $id_solicitud, $id_servicio);

    // Luego, elimina el registro principal
    $dao = new DimRespuestas($id_respuesta);

    $result = $dao->delete();
    if ($result['success']) {
        return Result::success($result);
    } else {
        return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
    }
}

// Eliminar registros asociados
private static function eliminarRegistrosAsociados($id_pregunta, $id_solicitud, $id_servicio)
{
    // Busca registros asociados con los parámetros proporcionados
    $result1 = QuerySQL::select(
        <<<SQL
        SELECT *
        FROM resp_fuente_consultada rfc
        WHERE rfc.id_pre_fuente = :id_pregunta
        AND rfc.id_solicitud = :id_solicitud
        AND rfc.id_servicio = :id_servicio
        SQL,
        array("id_pregunta" => $id_pregunta, "id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
        true,
        "N"
    );

    if ($result1) {
        foreach ($result1 as $registro) {
            // Elimina cada registro asociado
            $id_resp_fuente = $registro['id_resp_fuente'];
            self::eliminarRegistroAsociado($id_resp_fuente);
        }
    }
}

// Eliminar un registro asociado
private static function eliminarRegistroAsociado($id_resp_fuente)
{
    // Elimina el registro asociado con el ID proporcionado
        // Luego, elimina el registro principal
        $dao = new respFuenteConsultada($id_resp_fuente);

        $dao->delete();
    /*QuerySQL::delete(
        "resp_fuente_consultada",
        array("id_resp_fuente" => $id_resp_fuente)
    );*/
}


    //Actualizar la Formacion Academica
    public static function update_dimensiones_familia(
        $id_respuesta,
        $id_pregunta,
        $nivel_riesgo,
        $respuesta
    ) {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new DimRespuestas($id_respuesta);
        $dao->setProperty('id_pregunta', $id_pregunta);
        $dao->setProperty('nivel_riesgo', $nivel_riesgo);
        $dao->setProperty('respuesta', $respuesta);
        
        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica

    //
    public static function update_dim_compromiso(
        $id_respuesta,
        $id_pregunta,
        $nivel_riesgo,
        $respuesta,
        $id_solicitud,
        $id_servicio
    ) {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");

            $id_servicio_sel = 0;

            if ($id_servicio == 6) {
                $id_servicio_sel = 7;
            }else{
                $id_servicio_sel = 6;
            }
            $result1 = QuerySQL::select(
                <<<SQL
                UPDATE dim_respuestas
                    SET nivel_riesgo  = :nivel_riesgo , respuesta  = :respuesta 
                    WHERE id_pregunta = :id_pregunta
                    AND id_solicitud = :id_solicitud
                    AND id_servicio = :id_servicio_sel;
                SQL,
                array("nivel_riesgo" => $nivel_riesgo, "respuesta" => $respuesta, "id_pregunta" => $id_pregunta, "id_solicitud" => $id_solicitud, "id_servicio_sel" => $id_servicio_sel),
                true,
                "N"
            );

        $dao = new DimRespuestas($id_respuesta);
        $dao->setProperty('id_pregunta', $id_pregunta);
        $dao->setProperty('nivel_riesgo', $nivel_riesgo);
        $dao->setProperty('respuesta', $respuesta);
        
        $result =  $dao->update();


        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar la Formacion Academica
    public static function updateAntecedentesArray(
        $id_respuesta,
        $id_pregunta,
        $nivel_riesgo,
        $respuesta,
        $array_area
    ) {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new DimRespuestas($id_respuesta);
        $dao->setProperty('id_pregunta', $id_pregunta);
        $dao->setProperty('nivel_riesgo', $nivel_riesgo);
        //$dao->setProperty('respuesta', $respuesta);

        // Crear o actualizar registros adicionales a partir de $array_area
        foreach ($array_area as $area) {
            $validacion = CtrPreguntaSaludPolPre::findAllByComboCodigo($area['aspectoviv'],$area['codigo'], $area['id_solicitud'],$area['id_servicio']);

            // Verificar si la consulta fue exitosa y si hay datos en la respuesta
            if ($validacion['status'] == 'success' && !empty($validacion['data'])) {
                // Iterar sobre los datos obtenidos
                foreach ($validacion['data'] as $data) {
                    // Imprimir el valor de id_preg_salud_pol
                    //echo "Valor de id_preg_salud_pol: " . $data['id_preg_salud_pol'] . "\n";
                    //print_r("PUT");
                    $resultado = CtrPreguntaSaludPolPre::updateAntrecedentesArray(
                        $data['id_preg_salud_pol'],
                        $area['valor'],
                        $area['opcion']);
                }
            } else {
                //echo "No se encontraron datos para la consulta.\n";
                //print_r("POST");
                $resultado = CtrPreguntaSaludPolPre::crear(
                    $area['id_solicitud'],
                    $area['id_servicio'],
                    $area['codigo'],
                    $area['aspectoviv'],
                    $area['valor'],
                    $area['opcion'],
                    $area['id_pregunta']);

                //print_r($resultado);
            }
            
        }
        
        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function update_dimensiones_antecedentes(
        $id_respuesta,
        $texto_completo
    ) {
        if (!isset($id_respuesta) || $id_respuesta == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new DimRespuestas($id_respuesta);
        $dao->setProperty('texto_completo', $texto_completo);
        
        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Valida las variables para la dimension financiero-economica
    public static function ExiteVariable($id_pregunta,$id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from dim_respuestas dr 
                    where dr.id_pregunta = :id_pregunta
                    and dr.id_solicitud = :id_solicitud
            SQL,
            array("id_pregunta" => $id_pregunta,
                  "id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }//Fin listar las preguntas del candidato para la dimension financiero

    //Valida las variables para la dimension financiero-economica
    public static function ExiteVariableEC($id_pregunta,$id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from dim_respuestas dr 
                    where dr.id_pregunta = :id_pregunta
                    and dr.id_solicitud = :id_solicitud
                    -- and dr.id_servicio = :id_servicio
            SQL,
            array("id_pregunta" => $id_pregunta,
                  "id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }//Fin listar las preguntas del candidato para la dimension financiero

    public static function ExiteVariablePolPre($id_pregunta,$id_solicitud,$id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                 select 1 existe
                    from preguntas_relevantes_pol_pre dr 
                    where dr.tipo_rn = :id_pregunta
                    and dr.id_solicitud = :id_solicitud
                    and dr.id_servicio = :id_servicio
            SQL,
            array("id_pregunta" => $id_pregunta,
                  "id_solicitud" => $id_solicitud,
                  "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "validar si existe");
    }

/*
Funcion que trae calificacion encabezado informes
@gvanegas
*/
    public static function PorcentajeDimension($id_solicitud, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                SELECT d.nombre_dimension, 
                    TRUNCATE(SUM(dp.puntaje * (c.observacion/3)),1) as porcentaje
                FROM dimensiones d,
                    dim_preguntas dp,
                    dim_respuestas dr,
                    configurations c
                WHERE 1 = 1
                AND d.id_dimension = dp.id_dimension
                AND dp.id_pregunta = dr.id_pregunta 
                AND dp.id_servicio = dr.id_servicio
                AND dr.nivel_riesgo = c.codigo
                AND c.categoria  = 'tipo_nivel_riesgo'
                AND dr.id_solicitud = :id_solicitud
                AND dr.id_servicio = :id_servicio
                GROUP BY d.id_dimension
            SQL,
            array("id_solicitud" => $id_solicitud,
                  "id_servicio"  => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result);
    
    }

    public static function PorcentajeDimensionConcepto($id_solicitud, $id_servicio, $id_dimension){

        $result = QuerySQL::select(
            <<<SQL
                SELECT d.nombre_dimension, 
                    TRUNCATE(SUM(dp.puntaje * (c.observacion/3)),1) as porcentaje
                FROM dimensiones d,
                    dim_preguntas dp,
                    dim_respuestas dr,
                    configurations c
                WHERE 1 = 1
                AND d.id_dimension = dp.id_dimension
                AND dp.id_pregunta = dr.id_pregunta 
                AND dp.id_servicio = dr.id_servicio
                AND dr.nivel_riesgo = c.codigo
                AND c.categoria  = 'tipo_nivel_riesgo'
                AND dr.id_solicitud = :id_solicitud
                AND dr.id_servicio = :id_servicio
                AND d.id_dimension = :id_dimension
                GROUP BY d.id_dimension
            SQL,
            array("id_solicitud" => $id_solicitud,
                  "id_servicio"  => $id_servicio,
                  "id_dimension"  => $id_dimension),
            true,
            "N"
        );
    
        return Result::success($result);
    
    }


    public static function respDimension($id_solicitud, $id_dimension, $id_servicio){

        $result = QuerySQL::select(
            <<<SQL
                SELECT dp.nombre_pregunta, 
                       dp.puntaje,
                       dr.respuesta,
                       dr.nivel_riesgo,
                       fcn_desc_configurations('tipo_nivel_riesgo', dr.nivel_riesgo) des_nvl_riesgo
                  FROM dim_preguntas dp , 
                       dim_respuestas dr
                 WHERE 1 = 1
                   AND dp.id_dimension = :id_dimension
                   AND dp.id_servicio = :id_servicio
                   AND dp.id_pregunta = dr.id_pregunta 
                   AND dr.id_solicitud = :id_solicitud
            SQL,
            array("id_solicitud" => $id_solicitud, "id_dimension" => $id_dimension, "id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar variables familiares");
    
    }


    public static function dimencionXservicio($id_servicio){

        $result = QuerySQL::select(
            <<<SQL
            SELECT DISTINCT d.id_dimension
            from dimensiones d, dim_preguntas dp 
            WHERE d.id_dimension = dp.id_dimension 
            AND dp.id_servicio = :id_servicio
            SQL,
            array("id_servicio" => $id_servicio),
            true,
            "N"
        );
    
        return Result::success($result, "buscar dimenciones por Servicios");
    
    }

}
