<?php

class CtrMenu
{

    public static function crear($etiqueta, $descripcion, $html, $href, $padre, $tipo)
    {

        if (isset($etiqueta, $padre) && $etiqueta != "" && $padre != "") {

            $obj_menu = new Menu();
            $obj_menu->setEtiqueta($etiqueta);
            $obj_menu->setDescripcion($descripcion);
            $obj_menu->setHtml($html);
            $obj_menu->setHref($href);
            $obj_menu->setPadre($padre);
            $obj_menu->setTipo($tipo);

            return $obj_menu->insert();
        } else {
            return array("success" => false, "action" => "CREAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function actualizar($id, $etiqueta, $descripcion, $html, $href, $padre, $tipo)
    {

        if (isset($id, $etiqueta, $padre) && $id != "" && $etiqueta != "" && $padre != "") {

            $obj_menu = new Menu($id);
            $obj_menu->setEtiqueta($etiqueta);
            $obj_menu->setDescripcion($descripcion);
            $obj_menu->setHtml($html);
            $obj_menu->setHref($href);
            $obj_menu->setPadre($padre);
            $obj_menu->setTipo($tipo);

            return $obj_menu->update();
        } else {
            return array("success" => false, "action" => "ACTUALIZAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function eliminar($id)
    {
        if (isset($id) && $id != "") {
            $obj_menu = new Menu($id);
            return $obj_menu->delete();
        } else {
            return array("success" => false, "action" => "ELIMINAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function consultar($id = null)
    {
        if (isset($id) && $id != "" && $id != null) {
            $obj_menu = new Menu($id);
            return $obj_menu->getThisAllProperties();
        } else {
            return array("success" => false, "action" => "CONSULTAR", "code" => "Debe ingresar todos los parámetros.");
        }
    }

    public static function consultarTodos()
    {
        $obj_menu = new Menu();
        return $obj_menu->selectAll();
    }

    public static function consultarTodosLista($lista)
    {
        $menu_salida = array();
        $menu_todos = CtrMenu::consultarTodos();

        foreach ($menu_todos as $menu) {
            foreach ($lista as $l) {
                if ($menu["id"] == $l) {
                    array_push($menu_salida, $menu);
                }
            }
        }

        return $menu_salida;

    }

}

/*
 * ------------------------------------------------------------------------------------
 * Utility functions
 * https://www.sitepoint.com/community/t/display-a-hierarchical-menu-using-php/7559/6
 * ------------------------------------------------------------------------------------
 */

/*
 * Convert adjacency list to hierarchical tree
 *
 * @param value of root level parent most likely null or 0
 * @param array result
 * @param str name of primary key column
 * @param str name of parent_id column - most likely parent_id
 * @param str name of index that children will reside ie. children, etc
 * @return array tree
 */

function convertAdjacencyListToTree($intParentId, $arrRows, $strIdField, $strParentsIdField, $strNameResolution)
{

    $arrChildren = array();

    for ($i = 0; $i < count($arrRows); $i++) {
        if ($intParentId == $arrRows[$i][$strParentsIdField]) {
            $arrChildren = array_merge($arrChildren, array_splice($arrRows, $i--, 1));
        }
    }

    $intChildren = count($arrChildren);
    if ($intChildren != 0) {
        for ($i = 0; $i < $intChildren; $i++) {
            $arrChildren[$i][$strNameResolution] = convertAdjacencyListToTree($arrChildren[$i][$strIdField], $arrRows, $strIdField, $strParentsIdField, $strNameResolution);
        }
    }

    return $arrChildren;
}

/*
 * Theme menu
 *
 * @param array menu
 * @param runner (depth)
 * @return str themed menu
 */

function themeMenu($menu, $strNameResolution, $runner = 0)
{

    $out = '';

    if (empty($menu)) {
        return $out;
    }

    if ($runner === 0) {
        $out .= '<ul class="sidebar-menu">';
    } else {
        $out .= '<ul class="treeview-menu">';
    }

    foreach ($menu as $link) {
        $out .= sprintf(
            '<li id="menu-%s" %s><a href="%s">%s<span>%s</span>%s</a>%s</li>'
            , $link['id']
            , (sizeof($link[$strNameResolution]) > 0) ? 'class="treeview"' : 'class="me-menu-li"' //class="treeview"
            , constant('APP_URL') . $link['href']
            , $link['html']
            , $link['etiqueta']
            , (sizeof($link[$strNameResolution]) > 0) ? '<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>' : ''
            , themeMenu($link[$strNameResolution], $strNameResolution, ($runner + 1))
        );
    }

    $out .= '</ul>';
    return $out;
}
