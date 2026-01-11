<?php

class VivMobilElectro extends TABLE
{

    protected $id_mobiliario;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_distribucion;
    //protected $tipo_elemento;
    protected $cantidad;
    protected $estado_mobiliario;
    protected $tenencia_mobiliario;
    protected $mobiliario_electro;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_mobiliario = null)
    {

        parent::__construct("viv_mobil_electro", array("id_mobiliario"));

        if ($id_mobiliario != null) {
            $this->id_mobiliario = $id_mobiliario;
            $this->select();
        }
    }
}