<?php

class Ciudad extends TABLE
{

    protected $pais, $depto, $ciudad, $nombre, $siglas;

    public function __construct($pais = null, $depto = null, $ciudad = null)
    {

        parent::__construct("gr_ciudad", array("pais", "depto", "ciudad"));

        if ($pais != null && $depto != null && $ciudad != null) {
            $this->pais = $pais;
            $this->depto = $depto;
            $this->ciudad = $ciudad;
            $this->select();
        }
    }
}
