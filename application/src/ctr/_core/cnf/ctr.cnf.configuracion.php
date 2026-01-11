<?php

class CtrConfiguracion
{

    public static function crear($categoria, $codigo, $descripcion, $observacion)
    {
        if (
            isset($categoria, $codigo, $descripcion) &&
            $categoria != "" && $codigo != "" && $descripcion != ""
        ) {
            $obj_ref = new Configuracion();
            $obj_ref->setCategoria($categoria);
            $obj_ref->setCodigo($codigo);
            $obj_ref->setDescripcion($descripcion);
            $obj_ref->setObservacion($observacion);
            $obj_ref->setEstado("ACT");
            return $obj_ref->insert();
        } else {
            return array("success" => false, "action" => "CREAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function actualizar($categoria, $codigo, $descripcion, $observacion, $estado = "")
    {
        if (
            isset($categoria, $codigo, $descripcion) &&
            $categoria != "" && $codigo != "" && $descripcion != ""
        ) {
            $obj_ref = new Configuracion($categoria, $codigo);
            $obj_ref->setDescripcion($descripcion);
            $obj_ref->setObservacion($observacion);
            if ($estado != "") {
                $obj_ref->setEstado($estado);
            }

            return $obj_ref->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function eliminar($categoria, $codigo)
    {
        if (isset($categoria, $codigo) && $categoria != "" && $codigo != "") {
            $obj_ref = new Configuracion($categoria, $codigo);
            return $obj_ref->delete();
        } else {
            return array("success" => false, "action" => "ELIMINAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function consultar($categoria, $codigo)
    {
        if (isset($categoria, $codigo) && $categoria != "" && $codigo != "") {
            $obj_ref = new Configuracion($categoria, $codigo);
            return $obj_ref->getThisAllProperties();
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function consultarTodos()
    {
        $obj_ref = new Configuracion();
        return $obj_ref->selectAll();
    }

    public static function consultarTodosCategoria($categoria)
    {
        if (isset($categoria) && $categoria != "") {
            $obj_ref = new Configuracion();
            return $obj_ref->selectAll(
                array("categoria" => $categoria),
                array(
                    "codigo",
                    "descripcion",
                    "observacion",
                    "estado",
                    "usuario_sistema",
                    "fecha_sistema",
                    "categoria"
                )
            );
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    //Editar
    public static function consultar_factor($categoria, $codigo)
    {

        //print_r($categoria, $codigo);
        $result = QuerySQL::select(
            <<<SQL
                select  c.*
                    from configurations c
                    where c.categoria = :categoria
                    and  c.codigo = :codigo 
            SQL,
            array("categoria" => $categoria, "codigo" => $codigo),
            false,
            "N"
        );

        return Result::success($result, "buscar descripcion");
    }//Fin de Editar

    public static function estado_proceso_srv($categoria)
    {

        //print_r($categoria, $codigo);
        $result = QuerySQL::select(
            <<<SQL
                select  c.*
                    from configurations c
                    where c.categoria = :categoria
                    and  c.codigo in (1, 2, 3, 4, 5, 6); 
            SQL,
            array("categoria" => $categoria),
            false,
            "N"
        );

        return Result::success($result, "buscar descripcion");
    }
    

    public static function cambiarEstado($categoria, $codigo)
    {
        if (
            isset($categoria, $codigo) &&
            $categoria != "" && $codigo != ""
        ) {
            $obj_ref = new Configuracion($categoria, $codigo);
            $obj_ref->setEstado(($obj_ref->getEstado() == "ACT") ? "INA" : "ACT");
            return $obj_ref->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function val($categoria, $codigo)
    {
        if (isset($categoria, $codigo) && $categoria != "" && $codigo != "") {
            $obj_ref = new Configuracion($categoria, $codigo);
            return $obj_ref->getDescripcion();
        } else {
            return array("success" => false, "action" => "VAL", "code" => "Debe ingresar todos los parámetros.");
        }
    }
}
