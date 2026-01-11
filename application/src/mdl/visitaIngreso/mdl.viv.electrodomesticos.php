<?php

class VivElectrodomesticos extends TABLE
{

    protected $id_electrodomestico;
    protected $id_solicitud;
    protected $id_servicio;
    protected $tipo_elemento;
    protected $cantidad;
    protected $estado_electrodomestico;
    protected $tenencia_electrodomestico;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_electrodomestico = null)
    {

        parent::__construct("viv_electrodomesticos", array("id_electrodomestico"));

        if ($id_electrodomestico != null) {
            $this->id_electrodomestico = $id_electrodomestico;
            $this->select();
        }
    }
}