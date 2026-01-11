<?php

class CtrMiddleware
{

    public static function load()
    {
        date_default_timezone_set(constant('APP_TIMEZONE'));

        $router = new Router(true);

        $src_core_list = array('listas', 'menu', 'perfil', 'configuracion', 'usuario', 'ubicacion',   'salir', 'no_found');


        if ($router->get(1) == "api") {
            $dir_file_api = 'api/';
            if (in_array($router->get(2), $src_core_list))
                $dir_file_api .= '_core/';

            $file_api = 'api.' . $router->get(2) . '.php';

            require_once $dir_file_api . $file_api;
        } else {
            $module = constant('APP_ROUTES_MODULE_' . $router->get(1));
            // trigger_error("module:$module^^^");

            if ($router->get(1) == 'salir') {
                $file_view = "_salir.php";
            } elseif (!(isset($module))) {
                // $router->get(1) = 'no_found';
                //$file_view = "_404.php";
                $file_view = ("vw.dashboard.php");
            } else {
                $file_view = ("vw." . $router->get(1) . (($router->get(2) != "") ? "." : "") . $router->get(2) . ".php");
            }
            // trigger_error("file_view:$file_view^^^"); 

            $modules_route = (in_array($router->get(1), $src_core_list) ? '_core/' : constant('APP_ROUTES_MODULES'));
            // trigger_error("modules_route:$modules_route^^^"); 
            
            require_once "app/view/_core/__view.php";
        }
    }
}
