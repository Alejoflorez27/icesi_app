<?php

class VivDistribucion extends TABLE
{

    protected $id_distribucion;
    protected $id_solicitud;
    protected $id_servicio;
    protected $tipo_espacio;
    protected $numero_espacio;
    protected $estado_espacio;
    protected $dotacion_mobiliaria;
    protected $descripcion;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_distribucion = null)
    {

        parent::__construct("viv_distribuciones", array("id_distribucion"));

        if ($id_distribucion != null) {
            $this->id_distribucion = $id_distribucion;
            $this->select();
        }
    }
}