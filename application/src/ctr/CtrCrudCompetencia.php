<?php

/**
 * Controlador: CRUD Competencias
 */
class CtrCrudCompetencia {
    
    private $mdl;
    
    public function __construct() {
        $this->mdl = new MdlCompetencia();
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
