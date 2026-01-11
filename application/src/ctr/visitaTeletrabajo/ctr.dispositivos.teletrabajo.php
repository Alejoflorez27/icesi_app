<?php

class CtrDispositivosTeletrabajo
{

    public static function crear($id_solicitud, 
                                 $id_servicio, 
                                 $computador, 
                                 $personal, 
                                 $compartido, 
                                 $num_persona, 
                                 $camara, 
                                 $marca, 
                                 $internet,
                                 $fijo,
                                 $movil,
                                 $limitado,
                                 $ilimitado,
                                 $paquete,
                                 $individual,
                                 $modem,
                                 $banda_ancha,
                                 $megas,
                                 $linea_tele_local,
                                 $linea_tele_p1,
                                 $linea_tele_p2,
                                 $linea_tele_p3,
                                 $windows,
                                 $ram,
                                 $procesador,
                                 $sistema,
                                 $seguridad,
                                 $numero,
                                 $empresa_herramientas)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");
        if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicios es requerido");
        
        $obj_riesgo = new dispositivosTeletrabajo();
        $obj_riesgo->setProperty('id_solicitud', $id_solicitud);
        $obj_riesgo->setProperty('id_servicio', $id_servicio);
        $obj_riesgo->setProperty('computador', $computador);
        $obj_riesgo->setProperty('personal', $personal);
        $obj_riesgo->setProperty('compartido', $compartido);
        $obj_riesgo->setProperty('num_persona', $num_persona);
        $obj_riesgo->setProperty('camara', $camara);
        $obj_riesgo->setProperty('marca', $marca);
        $obj_riesgo->setProperty('internet', $internet);
        $obj_riesgo->setProperty('fijo', $fijo);
        $obj_riesgo->setProperty('movil', $movil);
        $obj_riesgo->setProperty('limitado', $limitado);
        $obj_riesgo->setProperty('ilimitado', $ilimitado);
        $obj_riesgo->setProperty('paquete', $paquete);
        $obj_riesgo->setProperty('individual', $individual);
        $obj_riesgo->setProperty('modem', $modem);
        $obj_riesgo->setProperty('banda_ancha', $banda_ancha);
        $obj_riesgo->setProperty('megas', $megas);
        $obj_riesgo->setProperty('linea_tele_local', $linea_tele_local);
        $obj_riesgo->setProperty('linea_tele_p1', $linea_tele_p1);
        $obj_riesgo->setProperty('linea_tele_p2', $linea_tele_p2);
        $obj_riesgo->setProperty('linea_tele_p3', $linea_tele_p3);
        $obj_riesgo->setProperty('windows', $windows);
        $obj_riesgo->setProperty('ram', $ram);
        $obj_riesgo->setProperty('procesador', $procesador);
        $obj_riesgo->setProperty('sistema', $sistema);
        $obj_riesgo->setProperty('seguridad', $seguridad);
        $obj_riesgo->setProperty('numero', $numero);
        $obj_riesgo->setProperty('empresa_herramientas', $empresa_herramientas);

        

        $result = $obj_riesgo->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($id_solicitud, $id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT ve.*
                FROM dispositivos_teletrabajo ve
                WHERE ve.id_solicitud = :id_solicitud
                and ve.id_servicio = :id_servicio

            SQL,
            array("id_solicitud" => $id_solicitud, "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar los factores de riesgo");
    }

    public static function findByIdEgresos($id_dispositivo)
    {
        if (!isset($id_dispositivo) || $id_dispositivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ve.*
                from dispositivos_teletrabajo ve, sol_solicitud sc
                    WHERE ve.id_dispositivo  = :id_dispositivo
                    and ve.id_solicitud  = sc.id_solicitud
            SQL,
            array("id_dispositivo" => $id_dispositivo),
            false,
            "N"
        );

        return Result::success($result, "buscar dispositivos de teletrabajo");
    }

    public static function delete($id_dispositivo)
    {
        if (!isset($id_dispositivo) || $id_dispositivo == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new dispositivosTeletrabajo($id_dispositivo);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    //Actualizar el egreso del candidato
    public static function update($id_dispositivo,
                                    $computador,
                                    $personal,
                                    $compartido,
                                    $num_persona, 
                                    $camara, 
                                    $marca, 
                                    $internet,
                                    $fijo,
                                    $movil,
                                    $limitado,
                                    $ilimitado,
                                    $paquete,
                                    $individual,
                                    $modem,
                                    $banda_ancha,
                                    $megas,
                                    $linea_tele_local,
                                    $linea_tele_p1,
                                    $linea_tele_p2,
                                    $linea_tele_p3,
                                    $windows,
                                    $ram,
                                    $procesador,
                                    $sistema,
                                    $seguridad,
                                    $numero,
                                    $empresa_herramientas

    ) {
        if (!isset($id_dispositivo) || $id_dispositivo == "")
            return Result::error(__FUNCTION__, "id es requerido");


        $dao = new dispositivosTeletrabajo($id_dispositivo);
        $dao->setProperty('computador', $computador);
        $dao->setProperty('personal', $personal);
        $dao->setProperty('compartido', $compartido);
        $dao->setProperty('num_persona', $num_persona);
        $dao->setProperty('camara', $camara);
        $dao->setProperty('marca', $marca);
        $dao->setProperty('internet', $internet);
        $dao->setProperty('fijo', $fijo);
        $dao->setProperty('movil', $movil);
        $dao->setProperty('limitado', $limitado);
        $dao->setProperty('ilimitado', $ilimitado);
        $dao->setProperty('paquete', $paquete);
        $dao->setProperty('individual', $individual);
        $dao->setProperty('modem', $modem);
        $dao->setProperty('banda_ancha', $banda_ancha);
        $dao->setProperty('megas', $megas);
        $dao->setProperty('linea_tele_local', $linea_tele_local);
        $dao->setProperty('linea_tele_p1', $linea_tele_p1);
        $dao->setProperty('linea_tele_p2', $linea_tele_p2);
        $dao->setProperty('linea_tele_p3', $linea_tele_p3);
        $dao->setProperty('windows', $windows);
        $dao->setProperty('ram', $ram);
        $dao->setProperty('procesador', $procesador);
        $dao->setProperty('sistema', $sistema);
        $dao->setProperty('seguridad', $seguridad);
        $dao->setProperty('numero', $numero);
        $dao->setProperty('empresa_herramientas', $empresa_herramientas);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Actualizar los egresos
}
