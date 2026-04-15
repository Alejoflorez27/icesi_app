<?php

/**
 * API: Programas Académicos
 * Endpoints para gestión de programas
 */

header("Content-Type: application/json");

$action = $_REQUEST['action'] ?? 'listar';

try {
    match ($action) {
        'listar' => print(json_encode(CtrTrcPrograma::listar())),
        'obtener' => print(json_encode(CtrTrcPrograma::obtener())),
        'crear' => print(json_encode(CtrTrcPrograma::crear())),
        'actualizar' => print(json_encode(CtrTrcPrograma::actualizar())),
        'eliminar' => print(json_encode(CtrTrcPrograma::eliminar())),
        default => print(json_encode(Result::error("Acción no válida", 400)))
    };
} catch (Exception $e) {
    print(json_encode(Result::error($e->getMessage(), 500)));
}
