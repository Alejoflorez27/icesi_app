<?php

class CtrVivElectrodomesticos
{
    //Crear una distribucion de la vivienda
    public static function crear($id_solicitud, $id_servicio, $tipo_elemento, $cantidad, $estado_electrodomestico, $tenencia_electrodomestico)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");

        $obj_vivElectrodomestico = new VivElectrodomesticos();
        $obj_vivElectrodomestico->setProperty('id_solicitud', $id_solicitud);
        $obj_vivElectrodomestico->setProperty('id_servicio', $id_servicio);
        $obj_vivElectrodomestico->setProperty('tipo_elemento', $tipo_elemento);
        $obj_vivElectrodomestico->setProperty('cantidad', $cantidad);
        $obj_vivElectrodomestico->setProperty('estado_electrodomestico', $estado_electrodomestico);
        $obj_vivElectrodomestico->setProperty('tenencia_electrodomestico', $tenencia_electrodomestico);
        

        $result = $obj_vivElectrodomestico->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una distribucion de la vivienda


    public static function crearElectrodomestico($id_solicitud, $id_servicio, $datos)
    {
        if (empty($id_solicitud)) {
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        }

        if (empty($id_servicio)) {
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");
        }

        // 1. Obtener todos los registros actuales de la BD
        $existentes = self::findAll($id_solicitud, $id_servicio)['data'] ?? [];

        // 2. Reindexar por una clave compuesta
        $existentesIndexados = [];
        foreach ($existentes as $e) {
            $key = $e['tipo_elemento'] . '|' . $e['cantidad']; // puedes ajustar esta clave si hay mejor forma
            $existentesIndexados[$key] = $e;
        }

        $resultados = [];
        $clavesProcesadas = [];

        foreach ($datos as $data) {
            $key = $data['tipo_elemento'] . '|' . $data['cant_electrodomesticos'];
            $clavesProcesadas[] = $key;


            if (isset($existentesIndexados[$key])) {
                // 3. ACTUALIZAR
                $existente = $existentesIndexados[$key];

                $obj_vivElectrodomesticos = new VivElectrodomesticos($existente['id_electrodomestico']);
                //$obj_vivDistribucion->setProperty('id_electrodomestico', $existente['id_electrodomestico']);
                $obj_vivElectrodomesticos->setProperty('cantidad', $data['cant_electrodomesticos'] ?? null);
                $obj_vivElectrodomesticos->setProperty('estado_electrodomestico', $data['estado_electrodomestico'] ?? null);
                $obj_vivElectrodomesticos->setProperty('tenencia_electrodomestico', $data['tenencia_electrodomestico'] ?? null);
                $updateElectrodomestico = $obj_vivElectrodomesticos->update();


                $resultados[] = [
                    'accion' => 'actualizado',
                    'distribucion' => $updateElectrodomestico
                ];
            } else {
                // 4. CREAR NUEVO
                $obj_vivElectrodomesticos = new VivElectrodomesticos();
                $obj_vivElectrodomesticos->setProperty('id_solicitud', $id_solicitud);
                $obj_vivElectrodomesticos->setProperty('id_servicio', $id_servicio);
                $obj_vivElectrodomesticos->setProperty('tipo_elemento', $data['tipo_elemento'] ?? null);
                $obj_vivElectrodomesticos->setProperty('cantidad', $data['cant_electrodomesticos'] ?? null);
                $obj_vivElectrodomesticos->setProperty('estado_electrodomestico', $data['estado_electrodomestico'] ?? null);
                $obj_vivElectrodomesticos->setProperty('tenencia_electrodomestico', $data['tenencia_electrodomestico'] ?? null);

                $insertElectrodomestico = $obj_vivElectrodomesticos->insert();

                $resultados[] = [
                    'accion' => 'creado',
                    'distribucion' => $insertElectrodomestico
                ];
            }
        }

        // 5. ELIMINAR los que no se procesaron
        foreach ($existentesIndexados as $key => $existente) {
            if (!in_array($key, $clavesProcesadas)) {

                $obj_vivElectrodomesticos = new VivElectrodomesticos($existente['id_electrodomestico']);
                $obj_vivElectrodomesticos->delete($existente['id_electrodomestico']);

                $resultados[] = [
                    'accion' => 'eliminado',
                    'id_electrodomestico' => $existente['id_electrodomestico']
                ];
            }
        }

        return Result::success($resultados);
    }

    //listar los mobiliarios del candidato
    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT ve.*, c.descripcion AS descripcion_tipo_elemento, c2.descripcion AS descripcion_estado_electrodomestico, c3.descripcion AS descripcion_tenencia_electrodomestico
            FROM viv_electrodomesticos ve, configurations c, configurations c2, configurations c3 
            WHERE ve.id_solicitud = :id_solicitud
            and ve.id_servicio = :id_servicio
            and c.codigo =  ve.tipo_elemento  
            and c.categoria = 'tipo_elementos_electrodomestico'
            and c2.codigo =  ve.estado_electrodomestico 
            and c2.categoria = 'estado_dotacion'
            and c3.codigo =  ve.tenencia_electrodomestico 
            and c3.categoria = 'tipo_tenencia_dotacion'
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar dotacion mobiliaria");
    }//Fin de listar los estudios del candidato

    public static function findAllElectro($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT ve.*
            FROM viv_electrodomesticos ve
            WHERE ve.id_solicitud = :id_solicitud
            and ve.id_servicio = :id_servicio
            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar dotacion mobiliaria");
    }

    //Editar un registro de formacion academica del candidato
    public static function findByIdFormacion($id_electrodomestico)
    {
        if (!isset($id_electrodomestico) || $id_electrodomestico == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ve.*
                    from viv_electrodomesticos ve, sol_solicitud sc
                    where ve.id_solicitud  = sc.id_solicitud
                    and  ve.id_electrodomestico  = :id_electrodomestico
            SQL,
            array("id_electrodomestico" => $id_electrodomestico),
            false,
            "N"
        );

        return Result::success($result, "buscar dotación mobiliaria");
    }//Fin de Editar un registro de formacion academica del candidato

    //Borrar un registro por id
    public static function delete($id_electrodomestico)
    {
        if (!isset($id_electrodomestico) || $id_electrodomestico == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new VivElectrodomesticos($id_electrodomestico);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la dotacion mobiliaria
    public static function update(
        $id_electrodomestico,
        $tipo_elemento,
        $cantidad,
        $estado_electrodomestico,
        $tenencia_electrodomestico

    ) {
        if (!isset($id_electrodomestico) || $id_electrodomestico == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new VivElectrodomesticos($id_electrodomestico);
        $dao->setProperty('tipo_elemento', $tipo_elemento);
        $dao->setProperty('cantidad', $cantidad);
        $dao->setProperty('estado_electrodomestico', $estado_electrodomestico);
        $dao->setProperty('tenencia_electrodomestico', $tenencia_electrodomestico);
        

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar la dotacion mobiliaria
}
