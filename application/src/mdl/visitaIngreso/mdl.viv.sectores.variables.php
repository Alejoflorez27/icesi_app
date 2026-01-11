<?php
//para alomacenar las variables del sector con checkbox
class VivSectoresVariables extends TABLE
{

    protected $id_sector_variable;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_sector;
    protected $categoria;
    protected $codigo;
    protected $activo;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_sector_variable = null)
    {
        parent::__construct("viv_sectores_variables", array("id_sector_variable"));

        if ($id_sector_variable != null) {
            $this->id_sector_variable = $id_sector_variable;
            $this->select();
        }
    }
}