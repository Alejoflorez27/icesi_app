<?php

class VivActivos extends TABLE
{

    protected $id_activo;
    protected $id_solicitud;
    protected $id_servicio;
    protected $concepto_activo;
    protected $otros;
    protected $tipo_familiar;
    protected $otro_propietario;
    protected $descripcion_general_viv;
    protected $valor_activo;
    protected $valor_activo_catastral;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_activo = null)
    {

        parent::__construct("viv_activos", array("id_activo"));

        if ($id_activo != null) {
            $this->id_activo = $id_activo;
            $this->select();
        }
    }
}