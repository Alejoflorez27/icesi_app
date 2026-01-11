<?php

class VivAnteriores extends TABLE
{

    protected $id_viv_anterior;
    protected $id_solicitud;
    protected $id_servicio;
    protected $ubicacion;
    protected $Tiempo_estadia;
    protected $motivo_cambio;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_viv_anterior = null)
    {

        parent::__construct("viv_anteriores", array("id_viv_anterior"));

        if ($id_viv_anterior != null) {
            $this->id_viv_anterior = $id_viv_anterior;
            $this->select();
        }
    }
}