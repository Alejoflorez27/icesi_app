<?php

# Cargar las funciones para load inicial
require_once 'index.functions.php';

# Cargar todas las variables de configuracion
require_once 'index.config.php';

# cargar todas las constantes  de la aplicacion
loadConf(CONF);

# Cargar todos los modelos y controladores
loadFiles(constant('APP_ROUTES_MODELS'));
loadFiles(constant('APP_ROUTES_CONTROLLERS'));


# --------------------------------------------------
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();

if (constant('APP_DEBUG') == 'true') { //debug
    error_reporting(E_ALL);
} else { //production
    error_reporting(E_ALL & ~(E_WARNING | E_NOTICE | E_DEPRECATED));
}

CtrMiddleware::load();
