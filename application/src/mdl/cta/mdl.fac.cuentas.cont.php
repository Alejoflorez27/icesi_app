<?php

class FacCuentasCont extends TABLE
{

    protected $id_cuenta;
    protected $item;
    protected $concepto;
    protected $combo;
    protected $ubicacion_cuenta;
    protected $destino_cuenta;
    protected $estado ;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_cuenta = null)
    {

        parent::__construct("fac_cuentas_cont", array("id_cuenta"));

        if ($id_cuenta != null) {
            $this->id_cuenta = $id_cuenta;
            $this->select();
        }
    }
}
