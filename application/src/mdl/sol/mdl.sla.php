<?php

class sla extends TABLE
{
    protected $id_sla;
    protected $inicio_verde;
    protected $fin_verde;
    protected $inicio_amarillo;
    protected $fin_amarillo;
    protected $inicio_rojo;
    protected $fin_rojo;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_sla  = null)
    {
        parent::__construct("sla", array("id_sla"));

        if ($id_sla != null) {
            $this->id_sla = $id_sla;
            $this->select();
        }
    }
}