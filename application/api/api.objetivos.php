<?php

/**
 * API: Objetivos de Aprendizaje
 * Endpoints para gestión de objetivos
 */

header("Content-Type: application/json");

$action = $_REQUEST['action'] ?? 'listar';

try {
    match ($action) {
        'listar' => print(json_encode(CtrTrcObjetivo::listar())),
        'obtener' => print(json_encode(CtrTrcObjetivo::obtener())),
        'crear' => print(json_encode(CtrTrcObjetivo::crear())),
        'actualizar' => print(json_encode(CtrTrcObjetivo::actualizar())),
        'eliminar' => print(json_encode(CtrTrcObjetivo::eliminar())),
        default => print(json_encode(Result::error("Acción no válida", 400)))
    };
} catch (Exception $e) {
    print(json_encode(Result::error($e->getMessage(), 500)));
}
