<?php

class CtrMenuFormatos
{

    public static function findAll($id_servicio)
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT mf.*,ss.nom_servicio
                FROM menu_formatos mf , srv_servicios ss
                WHERE mf.id_servicio = :id_servicio
                AND mf.id_servicio = ss.id_servicio
                AND mf.estado = 'ACT';
            SQL,
            array( "id_servicio" => $id_servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar menu");
    }

 
}
