<?php

class VivIngresos extends TABLE
{

    protected $id_ingreso;
    protected $id_solicitud;
    protected $id_servicio;
    protected $tipo_familiar;
    protected $valor_ingreso;
    protected $valor_aporte;
    protected $ingreso_proveniente;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_ingreso = null)
    {

        parent::__construct("viv_ingresos", array("id_ingreso"));

        if ($id_ingreso != null) {
            $this->id_ingreso = $id_ingreso;
            $this->select();
        }
    }
}