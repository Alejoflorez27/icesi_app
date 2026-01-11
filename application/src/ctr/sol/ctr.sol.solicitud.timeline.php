<?php

class CtrSolSolicitudTimeLine
{
    public static function findAllByService($solicitud, $servicio, $usuario,  $order = 'desc')
    {
        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");
        if (!is_numeric($servicio))
            return Result::error(__FUNCTION__, "servicio debe ser númerico");

        if ($order != 'asc' && $order != 'desc')
            return Result::error(__FUNCTION__, "order debe ser asc o desc");

        $resultCount = CtrUsuario::consultar($usuario);
        $perfil = $resultCount['perfil'];

        $result = QuerySQL::select(
            <<<SQL
            select *, 
                case when usr_create is not null then 
                    (select CONCAT(uu2.nombres, ' ', uu2.apellidos) 
                    from usr_usuario uu2
                    where username = usr_create )  
                else
                usr_create
                end usuario
            from sol_solicitud_timeline
            where 1 = 1
              and id_solicitud = :solicitud
              and id_servicio = :servicio
              and case when :perfil in (7,8,9) then 
                accion not in ('Programación servicio','Reprogramación servicio','Envío mensaje','Envío nuevo mensaje')
              else 
                1=1
              end 
            order by fch_create desc
        SQL,
            array(
                "solicitud" => $solicitud,
                "servicio" => $servicio,
                "perfil" => $perfil,

            ),
            true,
            "N"
        );

        return Result::success($result, "buscar timeline de servicio de solicitud");
    }
}
