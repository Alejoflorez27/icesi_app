<?php

class CtrPerfilMenu
{

    static public function crear($perfil, $nodo)
    {
        if (isset($perfil, $nodo) && $perfil != "" && $nodo != "") {
            $obj_perfil_menu = new PerfilMenu();
            $obj_perfil_menu->setPerfil($perfil);
            $obj_perfil_menu->setNodo($nodo);
            return $obj_perfil_menu->insert();
        } else {
            return array("success" => FALSE, "action" => "CREAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function actualizar($perfil, $nodo)
    {
        /**
         * No se requiere ningun metodo para actualizar
         */
        return array("success" => FALSE, "action" => "ACTUALIZAR", "code" => "Método no definido.");
    }

    static public function eliminar($perfil, $nodo)
    {
        if (isset($perfil, $nodo) && $perfil != "" && $nodo != "") {
            $obj_perfil_menu = new PerfilMenu($perfil, $nodo);
            return $obj_perfil_menu->delete();
        } else {
            return array("success" => FALSE, "action" => "ELIMINAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function consultar($perfil, $nodo)
    {
        if (isset($perfil, $nodo) && $perfil != "" && $nodo != "") {
            $obj_perfil_menu = new PerfilMenu($perfil, $nodo);
            return $obj_perfil_menu->getThisAllProperties();
        } else {
            return array("success" => FALSE, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function consultarTodosPerfil($perfil)
    {
        if (isset($perfil) && $perfil != "") {

            $obj_perfil = new Perfil($perfil);

            if ($obj_perfil->getEstado() == "I") {
                $perfil = -1;
            }

            $obj_perfil_menu = new PerfilMenu();
            return $obj_perfil_menu->selectAll(array("perfil" => $perfil));
        } else {
            return array("success" => FALSE, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    static public function consultarTree($perfil)
    {
        if (isset($perfil) && $perfil != "") {
            return QuerySQL::select(
                SQL_USR_PERFIL_MENU_TREE,
                array("perfil" => $perfil),
                true,
                "N"
            );
        } else {
            return array("success" => FALSE, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }
}

# Query SQL
define(
    'SQL_USR_PERFIL_MENU_TREE',
    "select * 
        from vw_usr_menu_perfil
        where perfil = :perfil
        order by sort"
);
