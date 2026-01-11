<?php

class TrcTerceros extends TABLE
{
  
     protected$id_tercero;
     protected$id_empresa;
     protected$nom_tercero;
     protected$estado;
     protected $usr_create;
     protected $fch_create;

    public function __construct($idTercero = null)
    {

        parent::__construct("trc_terceros", array("id_tercero"));

        if ($idTercero != null) {
            $this->id_tercero = $idTercero;
            $this->select();
        }
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}
