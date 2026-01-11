<?php

class PerfilServicio extends TABLE
{
    protected  $perfil;
    protected  $servicio;
    protected  $estado;

    protected $usr_crea;
    protected $fch_create;

    public function __construct(int $perfil = null, int $servicio = null)
    {
        parent::__construct("srv_perfil_servicio", array("perfil", "servicio"));

        if ($perfil != null && $servicio != null) {
            $this->perfil = $perfil;
            $this->servicio = $servicio;
            $this->select();
        }
    }
}
