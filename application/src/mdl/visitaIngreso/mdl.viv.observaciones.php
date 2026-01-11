<?php

class observaciones extends TABLE
{

    protected $id_observacion;
    protected $id_solicitud;
    protected $id_servicio;
    protected $tipo_observacion;
    protected $observacion;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_observacion = null)
    {

        parent::__construct("observaciones", array("id_observacion"));

        if ($id_observacion != null) {
            $this->id_observacion = $id_observacion;
            $this->select();
        }
    }
}