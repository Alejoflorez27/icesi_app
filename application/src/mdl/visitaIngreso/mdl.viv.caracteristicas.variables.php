<?php

class VivcaracteristicasVariables extends TABLE
{

    protected $id_caracteristica_variable;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_caracteristica;
    protected $categoria;
    protected $codigo;
    protected $activo;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_caracteristica_variable = null)
    {
        parent::__construct("viv_caracteristicas_variables", array("id_caracteristica_variable"));

        if ($id_caracteristica_variable != null) {
            $this->id_caracteristica_variable = $id_caracteristica_variable;
            $this->select();
        }
    }
}