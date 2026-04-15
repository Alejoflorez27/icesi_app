<?php

/**
 * API: Cursos Académicos
 * Endpoints para gestión de cursos
 */

header("Content-Type: application/json");

$action = $_REQUEST['action'] ?? 'listar';

try {
    match ($action) {
        'listar' => print(json_encode(CtrTrcCurso::listar())),
        'obtener' => print(json_encode(CtrTrcCurso::obtener())),
        'crear' => print(json_encode(CtrTrcCurso::crear())),
        'actualizar' => print(json_encode(CtrTrcCurso::actualizar())),
        'eliminar' => print(json_encode(CtrTrcCurso::eliminar())),
        default => print(json_encode(Result::error("Acción no válida", 400)))
    };
} catch (Exception $e) {
    print(json_encode(Result::error($e->getMessage(), 500)));
}

