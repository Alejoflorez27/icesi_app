<?php

class CtrPerfil
{

    static public function crear($descripcion, $estado = "A")
    {

        if (isset($descripcion, $estado) && $descripcion != "" && $estado != "") {

            $obj_perfil = new Perfil();
            $obj_perfil->setDescripcion($descripcion);
            $obj_perfil->setEstado($estado);

            return $obj_perfil->insert();
        } else {
            return array("success" => FALSE, "action" => "CREAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function actualizar($id, $descripcion, $estado)
    {

        if (isset($id, $descripcion, $estado) && $id != "" && $descripcion != "" && $estado != "") {

            $obj_perfil = new Perfil($id);
            $obj_perfil->setDescripcion($descripcion);
            $obj_perfil->setEstado($estado);

            return $obj_perfil->update();
        } else {
            return array("success" => FALSE, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function eliminar($id)
    {
        if (isset($id) && $id != "") {
            $obj_perfil = new Perfil($id);
            return $obj_perfil->delete();
        } else {
            return array("success" => FALSE, "action" => "ELIMINAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function consultar($id = null)
    {
        if (isset($id) && $id != "" && $id != null) {
            $obj_perfil = new Perfil($id);
            return $obj_perfil->getThisAllProperties();
        } else {
            return array("success" => FALSE, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function consultarTodos()
    {
        $obj_perfil = new Perfil();
        return $obj_perfil->selectAll();
    }

    //consulta los perfiles si es Interno o Externo
    static public function consultarPerfiles($tipo)
    {
        $result = QuerySQL::select(
            <<<SQL
                select *
                from prohumanos.usr_perfil up 
                where up.estado = 'A'
                and up.tipo = :tipo
            SQL,
            array("tipo" => $tipo),
            false,
            "S"
        );
        
        return Result::success($result);
    }

    public static function cambiarEstado($id, $estado_nuevo)
    {
        if (isset($id, $estado_nuevo) && $id != "" && $estado_nuevo != "") {
            $obj_perfil = new Perfil($id);
            $obj_perfil->setEstado($estado_nuevo);
            return $obj_perfil->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function consultarPerfilesServicios()
    {

        $result = QuerySQL::select(
            <<<SQL
                select up.id, up.descripcion 
                    from usr_perfil up 
                    where up.estado = 'A'
                    and up.tipo = 'I'
            SQL,
            array(),
            false,
            "S"
        );

        return Result::success($result, "buscar perfiles");
    }

    public static function consultarAsigPerfilesServicios()
    {

        $result = QuerySQL::select(
            <<<SQL
                SELECT up.id, up.descripcion 
                FROM usr_perfil up 
                WHERE up.estado = 'A'
                AND up.tipo = 'I'
                AND up.id IN (10, 11, 15, 16, 13);
            SQL,
            array(),
            false,
            "S"
        );

        return Result::success($result, "buscar perfiles");
    }
}
