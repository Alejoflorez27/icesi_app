<?php

class SrvCombos extends TABLE
{

    protected $id_combo;
    protected $nom_combo;
    protected $valor_bogota ;
    protected $sla_bogota ;
    protected $valor_externo ;
    protected $sla_externo ;
    protected $env_correo ;
    protected $estado ;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_combo = null)
    {

        parent::__construct("srv_combos", array("id_combo"));

        if ($id_combo != null) {
            $this->id_combo = $id_combo;
            $this->select();
        }
    }

    public function getSlaBogota()
    {
        return $this->sla_bogota;
    }

    public function getSlaExterno()
    {
        return $this->sla_bogota;
    }
}
