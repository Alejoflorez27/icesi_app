<?php

class CtrPerfilServicio
{
    public static function new(
        $perfil,
        $servicio,
        $estado = 'A'
    ) {
        if (!isset($perfil) || $perfil == "")
            return Result::error(__FUNCTION__, "Perfil es requerido");

        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");


        $dao = new PerfilServicio();
        $dao->setProperty("perfil", $perfil);
        $dao->setProperty("servicio", $servicio);
        $dao->setProperty("estado", $estado);

        $result =  $dao->insert();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function findAll($estado = 'T')
    {
        $result = QuerySQL::select(
            <<<SQL
                select * 
                from srv_perfil_servicio ps 
                where (ps.estado = :estado or :estado = 'T')
            SQL,
            array("estado" => $estado),
            true,
            "N"
        );

        return Result::success($result, "buscar perfiles por tipos de servicio");
    }

    public static function findAllByService($servicio)
    {
        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select * 
                from srv_perfil_servicio ps 
                where (ps.servicio = :servicio )
            SQL,
            array("servicio" => $servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar perfiles por tipos de servicio");
    }

    public static function findAllUserByService($servicio)
    {
        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select uu.username , CONCAT(IFNULL(uu.nombres, ''), ' ', IFNULL(uu.apellidos,'')  )  as nombre_completo, uu.email 
                from srv_perfil_servicio ps, usr_perfil up, usr_usuario uu  
                where ps.perfil = up.id 
                and up.id = uu.perfil
                and servicio = :servicio
                and uu.estado = 'ACT'
            SQL,
            array("servicio" => $servicio),
            true,
            "N"
        );

        return Result::success($result, "buscar usuarios por tipos de servicio");
    }

    public static function findAllUsers($estado_usuario = 'T')
    {
        $result = QuerySQL::select(
            <<<SQL
                select uu.username , CONCAT(IFNULL(uu.nombres, ''), ' ', IFNULL(uu.apellidos,'')  )  as nombre_completo, uu.email 
                from usr_usuario uu  
                where (uu.estado = :estado_usuario or :estado_usuario = 'T')
                and uu.perfil in (select perfil from srv_perfil_servicio)
            SQL,
            array('estado_usuario' => $estado_usuario),
            true,
            "N"
        );

        return Result::success($result, "buscar usuarios prestadores");
    }

    public static function findUserByService($servicio, $usuario)
    {
        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");

        if (!isset($usuario) || $usuario == "")
            return Result::error(__FUNCTION__, "usuario es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select uu.username , CONCAT(IFNULL(uu.nombres, ''), ' ', IFNULL(uu.apellidos,'')  )  as nombre_completo, uu.email 
                from srv_perfil_servicio ps, usr_perfil up, usr_usuario uu  
                where ps.perfil = up.id 
                and up.id = uu.perfil
                and servicio = :servicio
                and uu.username = :usuario
                and uu.estado = 'ACT'
            SQL,
            array("servicio" => $servicio, "usuario" => $usuario),
            true,
            "N"
        );

        return Result::success($result, "buscar usuario por tipos de servicio");
    }

    public static function findAllByProfile($perfil)
    {
        if (!isset($perfil) || $perfil == "")
            return Result::error(__FUNCTION__, "perfil es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select * 
                from srv_perfil_servicio ps 
                where (ps.perfil = :perfil )
            SQL,
            array("perfil" => $perfil),
            true,
            "N"
        );

        return Result::success($result, "buscar perfiles por tipos de servicio");
    }

    public static function findById($id)
    {
        if (!isset($id) || $id == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select ts.*
                from srv_perfil_servicio ps
                where ps.id = :id
            SQL,
            array("id" => $id),
            false,
            "N"
        );

        return Result::success($result, "buscar perfiles por tipo de servicio");
    }

    public static function update_state(
        $perfil,
        $servicio,
        $estado = 'ACT'
    ) {
        if (!isset($perfil) || $perfil == "")
            return Result::error(__FUNCTION__, "perfil es requerido");
        if (!is_numeric($perfil))
            return Result::error(__FUNCTION__, "perfil debe ser numerico");

        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");
        if (!is_numeric($servicio))
            return Result::error(__FUNCTION__, "servicio debe ser numerico");

        $dao = new PerfilServicio($perfil, $servicio);
        $dao->setProperty("estado", $estado);

        $result =  $dao->update();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }

    public static function delete($perfil, $servicio)
    {
        if (!isset($perfil) || $perfil == "")
            return Result::error(__FUNCTION__, "perfil es requerido");
        if (!is_numeric($perfil))
            return Result::error(__FUNCTION__, "perfil debe ser numerico");

        if (!isset($servicio) || $servicio == "")
            return Result::error(__FUNCTION__, "servicio es requerido");
        if (!is_numeric($servicio))
            return Result::error(__FUNCTION__, "servicio debe ser numerico");

        $dao = new PerfilServicio($perfil, $servicio);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }
}
