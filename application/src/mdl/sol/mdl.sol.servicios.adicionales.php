<?php

class SolServiciosAdicionales extends TABLE
{

    protected $id;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_cuenta;
    protected $observacion;
    protected $valor;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id = null)
    {

        parent::__construct("sol_servicios_adicionales", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }
}
