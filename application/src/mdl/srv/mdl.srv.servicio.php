<?php

class SrvServicio extends TABLE
{

    protected $id_servicio;
    protected $id_producto;
    protected $nom_servicio;
    protected $tipo_servicio;
    protected $estado;
    protected $reporte;
    protected $nomReporte;
    protected $ruta_reporte;
    protected $valor_bogota;
    protected $valor_fuera_bogota;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_servicio = null)
    {

        parent::__construct("srv_servicios", array("id_servicio"));

        if ($id_servicio != null) {
            $this->id_servicio = $id_servicio;
            $this->select();
        }
    }

        /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */


     public function getIdServicio()
     {
         return $this->id_servicio;
     }
 
     public function getNomServicio()
     {
         return $this->nom_servicio;
     }
 
}
