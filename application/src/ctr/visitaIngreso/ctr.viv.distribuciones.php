<?php

class CtrVivDistribuciones
{
    //Crear una distribucion de la vivienda
    public static function crear($id_solicitud, $id_servicio, $tipo_espacio, $numero_espacio, $estado_espacio, $dotacion_mobiliaria, $descripcion, $ocupante)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_vivDistribucion = new VivDistribucion();
        $obj_vivDistribucion->setProperty('id_solicitud', $id_solicitud);
        $obj_vivDistribucion->setProperty('id_servicio', $id_servicio);
        $obj_vivDistribucion->setProperty('tipo_espacio', $tipo_espacio);
        $obj_vivDistribucion->setProperty('numero_espacio', $numero_espacio);
        $obj_vivDistribucion->setProperty('estado_espacio', $estado_espacio);
        $obj_vivDistribucion->setProperty('dotacion_mobiliaria', $dotacion_mobiliaria);
        $obj_vivDistribucion->setProperty('descripcion', $descripcion);
        $obj_vivDistribucion->setProperty('ocupante', $ocupante);
        

        $result = $obj_vivDistribucion->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda

/*    public static function crearDistribucion($id_solicitud, $id_servicio, $datos)
    {
        $tipo_elemento = '';
        //$texto_concatenado = ''; // Inicializar el texto concatenado

        // Recorrer el arreglo de validación obtenido en la consulta anterior
        foreach ($datos as $data) {
            //print_r($texto_concatenado);
            if (!isset($id_solicitud) || $id_solicitud == "")
                return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

            if (!isset($id_servicio) || $id_servicio == "")
                return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

            //Creacion de la distribuciion
            $obj_vivDistribucion = new VivDistribucion();
            $obj_vivDistribucion->setProperty('id_solicitud', $id_solicitud);
            $obj_vivDistribucion->setProperty('id_servicio', $id_servicio);
            $obj_vivDistribucion->setProperty('tipo_espacio', $data['tipo_espacio']);
            $obj_vivDistribucion->setProperty('numero_espacio', $data['cant_espacios']);
            $obj_vivDistribucion->setProperty('estado_espacio', $data['estado_espacio']);
            $obj_vivDistribucion->setProperty('dotacion_mobiliaria', $data['dotacion']);
            //$obj_vivDistribucion->setProperty('descripcion', $data['descripcion']);
            //$obj_vivDistribucion->setProperty('ocupante', $data['ocupante']);
            $insertDistribucion = $obj_vivDistribucion->insert();
            if ($insertDistribucion['success']) {
                //$mobiliario = CtrVivMobiliarios::crear($id_solicitud, $id_servicio, $insertDistribucion['id_distribucion']);

                switch ($data['tipo_espacio']) {
                    case 'BA':
                        $tipo_elemento = 'BAT';
                        break;
                    case 'BAL':
                        $tipo_elemento = 'MB';
                        break;
                    case 'COC':
                        $tipo_elemento = 'MC';
                        break;
                    case 'COM':
                        $tipo_elemento = 'MT';
                        break;
                    case 'DEP':
                        $tipo_elemento = 'MD';
                        break;
                    case 'EST':
                        $tipo_elemento = 'ME';
                        break;
                    case 'GA':
                        $tipo_elemento = 'MG';
                        break;
                    case 'HAB':
                        $tipo_elemento = 'MH';
                        break;
                    case 'SAL':
                        $tipo_elemento = 'MS';
                        break;
                    case 'TE':
                        $tipo_elemento = 'MTE';
                        break;
                    case 'ZL':
                        $tipo_elemento = 'ML';
                        break;
                    default:
                        break;
                }
                
                $obj_vivMobiliario = new VivMobilElectro();
                $obj_vivMobiliario->setProperty('id_solicitud', $id_solicitud);
                $obj_vivMobiliario->setProperty('id_servicio', $id_servicio);
                $obj_vivMobiliario->setProperty('id_distribucion', $insertDistribucion['id_distribucion']);
                $obj_vivMobiliario->setProperty('tipo_elemento', $tipo_elemento);
                $obj_vivMobiliario->setProperty('cantidad', $data['cant_mobiliario']);
                $obj_vivMobiliario->setProperty('estado_mobiliario', $data['estado_mobiliario']);
                $obj_vivMobiliario->setProperty('tenencia_mobiliario', $data['tenencia']);
                $insertMobiliario = $obj_vivMobiliario->insert();

                return Result::success($insertDistribucion);
            } else {
                return Result::error(__CLASS__ . "." . __FUNCTION__, $insertDistribucion);
            }

        }
        
        
    }*/
    public static function crearDistribucion($id_solicitud, $id_servicio, $datos)
    {
        if (empty($id_solicitud)) {
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        }

        if (empty($id_servicio)) {
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");
        }

        // 1. Obtener todos los registros actuales de la BD
        $existentes = self::findAllDidtribucionMobiliaria($id_solicitud, $id_servicio)['data'] ?? [];

        // 2. Reindexar por una clave compuesta
        $existentesIndexados = [];
        foreach ($existentes as $e) {
            $key = $e['tipo_espacio'] . '|' . $e['numero_espacio']; // puedes ajustar esta clave si hay mejor forma
            $existentesIndexados[$key] = $e;
        }

        $resultados = [];
        $clavesProcesadas = [];

        foreach ($datos as $data) {
            $key = $data['tipo_espacio'] . '|' . $data['cant_espacios'];
            $clavesProcesadas[] = $key;

            // MAPA para tipo_elemento
            $mapTipos = [
                'BA'  => 'BAT',
                'BAL' => 'MB',
                'COC' => 'MC',
                'COM' => 'MT',
                'DEP' => 'MD',
                'EST' => 'ME',
                'GA'  => 'MG',
                'HAB' => 'MH',
                'SAL' => 'MS',
                'TE'  => 'MTE',
                'ZL'  => 'ML',
                'ESTU'  => 'MESTU',
            ];
            $tipo_elemento = $mapTipos[$data['tipo_espacio'] ?? ''] ?? null;

            if (isset($existentesIndexados[$key])) {
                // 3. ACTUALIZAR
                $existente = $existentesIndexados[$key];

                $obj_vivDistribucion = new VivDistribucion($existente['id_distribucion']);
                $obj_vivDistribucion->setProperty('id_distribucion', $existente['id_distribucion']);
                $obj_vivDistribucion->setProperty('estado_espacio', $data['estado_espacio'] ?? null);
                $obj_vivDistribucion->setProperty('dotacion_mobiliaria', $data['dotacion'] ?? null);
                $updateDistribucion = $obj_vivDistribucion->update();

                $obj_vivMobiliario = new VivMobilElectro($existente['id_mobiliario']);
                $obj_vivMobiliario->setProperty('id_mobiliario', $existente['id_mobiliario']);
                $obj_vivMobiliario->setProperty('tipo_elemento', $tipo_elemento);
                $obj_vivMobiliario->setProperty('cantidad', $data['cant_mobiliario'] ?? null);
                $obj_vivMobiliario->setProperty('estado_mobiliario', $data['estado_mobiliario'] ?? null);
                $obj_vivMobiliario->setProperty('tenencia_mobiliario', $data['tenencia'] ?? null);
                $updateMobiliario = $obj_vivMobiliario->update();

                $resultados[] = [
                    'accion' => 'actualizado',
                    'distribucion' => $updateDistribucion,
                    'mobiliario' => $updateMobiliario
                ];
            } else {
                // 4. CREAR NUEVO
                $obj_vivDistribucion = new VivDistribucion();
                $obj_vivDistribucion->setProperty('id_solicitud', $id_solicitud);
                $obj_vivDistribucion->setProperty('id_servicio', $id_servicio);
                $obj_vivDistribucion->setProperty('tipo_espacio', $data['tipo_espacio'] ?? null);
                $obj_vivDistribucion->setProperty('numero_espacio', $data['cant_espacios'] ?? null);
                $obj_vivDistribucion->setProperty('estado_espacio', $data['estado_espacio'] ?? null);
                $obj_vivDistribucion->setProperty('dotacion_mobiliaria', $data['dotacion'] ?? null);

                $insertDistribucion = $obj_vivDistribucion->insert();

                $obj_vivMobiliario = new VivMobilElectro();
                $obj_vivMobiliario->setProperty('id_solicitud', $id_solicitud);
                $obj_vivMobiliario->setProperty('id_servicio', $id_servicio);
                $obj_vivMobiliario->setProperty('id_distribucion', $insertDistribucion['id'] ?? null);
                $obj_vivMobiliario->setProperty('tipo_elemento', $tipo_elemento);
                $obj_vivMobiliario->setProperty('cantidad', $data['cant_mobiliario'] ?? null);
                $obj_vivMobiliario->setProperty('estado_mobiliario', $data['estado_mobiliario'] ?? null);
                $obj_vivMobiliario->setProperty('tenencia_mobiliario', $data['tenencia'] ?? null);
                $insertMobiliario = $obj_vivMobiliario->insert();

                $resultados[] = [
                    'accion' => 'creado',
                    'distribucion' => $insertDistribucion,
                    'mobiliario' => $insertMobiliario
                ];
            }
        }

        // 5. ELIMINAR los que no se procesaron
        foreach ($existentesIndexados as $key => $existente) {
            if (!in_array($key, $clavesProcesadas)) {
                $obj_vivMobiliario = new VivMobilElectro($existente['id_mobiliario']);
                $obj_vivMobiliario->delete($existente['id_mobiliario']);

                $obj_vivDistribucion = new VivDistribucion($existente['id_distribucion']);
                $obj_vivDistribucion->delete($existente['id_distribucion']);

                $resultados[] = [
                    'accion' => 'eliminado',
                    'id_distribucion' => $existente['id_distribucion'],
                    'id_mobiliario' => $existente['id_mobiliario']
                ];
            }
        }

        return Result::success($resultados);
    }
    public static function deleteMobiliario($id_mobiliario)
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
    }


    public static function findAllDidtribucionMobiliaria($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT vd.id_distribucion,
                vd.id_solicitud,
                vd.id_servicio,
                vd.tipo_espacio,
                vd.numero_espacio,
                vd.estado_espacio,
                vd.dotacion_mobiliaria,
                vme.id_mobiliario,
                vme.tipo_elemento,
                vme.cantidad,
                vme.estado_mobiliario,
                vme.tenencia_mobiliario
            FROM viv_distribuciones vd, viv_mobil_electro vme
            where vd.id_solicitud = vme.id_solicitud
            and vd.id_servicio  = vme.id_servicio
            and vd.id_distribucion = vme.id_distribucion
            AND vd.id_solicitud =:id_solicitud
            AND vd.id_servicio =:id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "Buscar Didtribucion Mobiliaria");
    }


    //listar los estudios del candidato
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT vd.id_distribucion,
                    vd.id_solicitud,
                    vd.id_servicio,
                    fcn_desc_configurations('tipo_espacios', vd.tipo_espacio) descripcion_tipo_espacios,
                    vd.numero_espacio,
                    fcn_desc_configurations('tipo_estado_espacios', vd.estado_espacio) descripcion_estado_espacios,
                    fcn_desc_configurations('tipo_dotacion_mobiliaria', vd.dotacion_mobiliaria) descripcion_dotacion_mob,
                    vd.descripcion,
                    vd.ocupante
                FROM viv_distribuciones vd
                WHERE vd.id_solicitud = :id_solicitud
                AND vd.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //listar los estudios del candidato
    public static function findAllTeletrabajo($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT vd.id_distribucion,
                    vd.id_solicitud,
                    vd.id_servicio,
                    fcn_desc_configurations('tipo_espacios_teletrabajo', vd.tipo_espacio) descripcion_tipo_espacios,
                    vd.numero_espacio,
                    fcn_desc_configurations('tipo_estado_espacios', vd.estado_espacio) descripcion_estado_espacios,
                    fcn_desc_configurations('tipo_dotacion_mobiliaria', vd.dotacion_mobiliaria) descripcion_dotacion_mob,
                    vd.descripcion,
                    vd.ocupante
                FROM viv_distribuciones vd
                WHERE vd.id_solicitud = :id_solicitud
                AND vd.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //listar los estudios del candidato
    public static function findByEspacio($id_solicitud, $id_servicio, $tipo_espacio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT vd.id_distribucion,
                    vd.id_solicitud,
                    vd.id_servicio,
                    fcn_desc_configurations('tipo_espacios_teletrabajo', vd.tipo_espacio) descripcion_tipo_espacios,
                    vd.numero_espacio,
                    fcn_desc_configurations('tipo_estado_espacios', vd.estado_espacio) descripcion_estado_espacios,
                    fcn_desc_configurations('tipo_dotacion_mobiliaria', vd.dotacion_mobiliaria) descripcion_dotacion_mob,
                    vd.descripcion,
                    vd.ocupante
                FROM viv_distribuciones vd
                WHERE vd.id_solicitud = :id_solicitud
                AND vd.id_servicio = :id_servicio
                AND vd.tipo_espacio = :tipo_espacio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio, "tipo_espacio" => $tipo_espacio),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //Editar un registro de formacion academica del candidato
    public static function findByIdFormacion($id_distribucion)
    {
        if (!isset($id_distribucion) || $id_distribucion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select vd.*,
                       fcn_desc_configurations('tipo_espacios', vd.tipo_espacio) descripcion_tipo_distribucion
                    from viv_distribuciones vd, sol_solicitud sc
                    where vd.id_solicitud  = sc.id_solicitud
                    and  vd.id_distribucion  = :id_distribucion
            SQL,
            array("id_distribucion" => $id_distribucion),
            false,
            "N"
        );

        return Result::success($result, "buscar formación");
    }//Fin de Editar un registro de formacion academica del candidato

    //Borrar un registro por id
    public static function delete($id_distribucion)
    {
        if (!isset($id_distribucion) || $id_distribucion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivDistribucion($id_distribucion);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la Formacion Academica
    public static function update(
        $id_distribucion,
        $tipo_espacio,
        $numero_espacio,
        $estado_espacio,
        $dotacion_mobiliaria

    ) {
        if (!isset($id_distribucion) || $id_distribucion == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivDistribucion($id_distribucion);
        $dao->setProperty('tipo_espacio', $tipo_espacio);
        $dao->setProperty('numero_espacio', $numero_espacio);
        $dao->setProperty('estado_espacio', $estado_espacio);
        $dao->setProperty('dotacion_mobiliaria', $dotacion_mobiliaria);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica

    //Actualizar la Formacion Academica
    public static function update_teletrabajo(
        $id_distribucion,
        $tipo_espacio,
        $numero_espacio,
        $descripcion,
        $ocupante

    ) {
        if (!isset($id_distribucion) || $id_distribucion == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivDistribucion($id_distribucion);
        $dao->setProperty('tipo_espacio', $tipo_espacio);
        $dao->setProperty('numero_espacio', $numero_espacio);
        $dao->setProperty('descripcion', $descripcion);
        $dao->setProperty('ocupante', $ocupante);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la Formacion Academica
}
