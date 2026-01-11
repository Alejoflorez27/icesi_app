<?php

use ValidateToken;

$permitidos_sin_login = array();
$permitido = in_array($router->get(3), $permitidos_sin_login);

if (!$permitido) {
    if (!ValidateToken::autentication()) {
        echo "Acceso denegado";
        http_response_code(401);
        return;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo themeMenu(convertAdjacencyListToTree(null, CtrMenu::consultarTodos(), 'id', 'padre', 'hijos'), 'hijos');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    /*
     * Si no se llama algun metodo autorizado: 400 Bad Request
     */
    http_response_code(400);
    return;
}
