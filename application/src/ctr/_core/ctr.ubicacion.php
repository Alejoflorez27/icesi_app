<?php

class CtrUbicacion
{

    public static function findAllPais($idPais = NULL)
    {

        if (!isset($idPais) || $idPais == "")
            $idPais = -1;


        $result = QuerySQL::select(
            <<<SQL
                select cp.id_pais , cp.nombre 
                    from conf_pais cp
                    where (cp.id_pais = :idPais or :idPais = -1) 
            SQL,
            array("idPais" => $idPais),
            true,
            "N"
        );

        return Result::success($result, "buscar países");
    }

    public static function findDtosXPais($id_pais = null, $id_dpto)
    {

        if (!isset($id_pais) || $id_pais == "")
            $id_dpto = -1;

        $result = QuerySQL::select(
            <<<SQL
                 select cd.id_dpto, cd.nombre 
                    from conf_dpto cd 
                    where cd.id_pais = :id_pais
                    and (id_dpto = :id_dpto or :id_dpto = -1)
            SQL,
            array(
                "id_pais" => $id_pais,
                "id_dpto" => $id_dpto,
            ),
            true,
            "N"
        );

        return Result::success($result, "buscar departamentos por país");
    }



    public static function findCiudaXDtos($idDpto = null)
    {
        if (!isset($idDpto) || $idDpto == "")
            $idDpto = -1;

        $result = QuerySQL::select(
            <<<SQL
                select cc.id_ciudad , cc.nombre 
                    from conf_ciudad cc 
                    where (cc.id_dpto = :idDpto or :idDpto = -1)
            SQL,
            array("idDpto" => $idDpto),
            true,
            "N"
        );

        return Result::success($result, "buscar ciudades por departamento");
    }



    public static function findXCiudadxId($idCiudad = null)
    {
        if (!isset($idCiudad) || $idCiudad == "")
            $idCiudad = -1;

        $result = QuerySQL::select(
            <<<SQL
                select cc.id_ciudad , cc.nombre 
                    from conf_ciudad cc 
                    where (cc.id_ciudad = :idCiudad or :idCiudad = -1)
                union all 
                select cc.id_ciudad , cc.nombre 
                    from conf_ciudad cc 
            SQL,
            array("idCiudad" => $idCiudad),
            true,
            "N"
        );

        return Result::success($result, "buscar ciudades por departamento");
    }
}
