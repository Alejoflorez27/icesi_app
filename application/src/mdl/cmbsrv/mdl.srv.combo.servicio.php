<?php

class SrvComboServicios extends TABLE
{

    protected $id_comb_ser;
    protected $id_servicio;
    protected $id_combo;
    protected $activo;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_comb_ser = null)
    {

        parent::__construct("srv_combo_servicios", array("id_comb_ser"));

        if ($id_comb_ser != null) {
            $this->id_comb_ser = $id_comb_ser;
            $this->select();
        }
    }
}


