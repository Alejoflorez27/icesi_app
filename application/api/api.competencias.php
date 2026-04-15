<?php

/**
 * API: Competencias Académicas
 * Endpoints para gestión de competencias
 */

header("Content-Type: application/json");

$action = $_REQUEST['action'] ?? 'listar';

try {
    match ($action) {
        'listar' => print(json_encode(CtrTrcCompetencia::listar())),
        'obtener' => print(json_encode(CtrTrcCompetencia::obtener())),
        'crear' => print(json_encode(CtrTrcCompetencia::crear())),
        'actualizar' => print(json_encode(CtrTrcCompetencia::actualizar())),
        'eliminar' => print(json_encode(CtrTrcCompetencia::eliminar())),
        default => print(json_encode(Result::error("Acción no válida", 400)))
    };
} catch (Exception $e) {
    print(json_encode(Result::error($e->getMessage(), 500)));
}

