<?php

class SrvServiciosCalificados extends TABLE
{

    protected $id;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_proveedor;
    protected $pregunta1;
    protected $pregunta2;
    protected $pregunta3;
    protected $pregunta4;
    protected $pregunta5;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id = null)
    {

        parent::__construct("srv_servicios_calificados", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }
}
