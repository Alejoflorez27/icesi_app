<?php

class VivEgresos extends TABLE
{

    protected $id_egreso;
    protected $id_solicitud;
    protected $id_servicio;
    protected $concepto_ingreso;
    protected $otros;
    protected $periocidad;
    protected $tipo_familiar;
    protected $valor_egreso;
    protected $total_egreso;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_egreso = null)
    {

        parent::__construct("viv_egresos", array("id_egreso"));

        if ($id_egreso != null) {
            $this->id_egreso = $id_egreso;
            $this->select();
        }
    }
}