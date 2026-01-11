<?php

class DimConceptoFinal extends TABLE
{

    protected $id_dim_concepto;
    protected $id_solicitud;
    protected $id_servicio;
    protected $id_dimension;
    protected $observacion;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_dim_concepto = null)
    {

        parent::__construct("dim_concepto_final", array("id_dim_concepto"));

        if ($id_dim_concepto != null) {
            $this->id_dim_concepto = $id_dim_concepto;
            $this->select();
        }
    }
}