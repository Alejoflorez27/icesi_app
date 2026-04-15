<?php

/**
 * Controlador: CRUD Relación Curso-Objetivo
 */
class CtrCrudCursoObjetivo {
    
    private $mdl;
    
    public function __construct() {
        $this->mdl = new MdlCursoObjetivo();
    }
    
    public function listar() {
        return $this->mdl->obtenerTodas();
    }
    
    public function obtener($id) {
        return $this->mdl->obtenerPorId($id);
    }
    
    public function crear($datos) {
        return $this->mdl->crear($datos);
    }
    
    public function actualizar($id, $datos) {
        return $this->mdl->actualizar($id, $datos);
    }
    
    public function eliminar($id) {
        return $this->mdl->eliminar($id);
    }
}
