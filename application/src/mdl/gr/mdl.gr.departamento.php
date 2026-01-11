<?php

class Departamento extends TABLE
{

    protected $pais, $depto, $nombre, $siglas;

    public function __construct($pais = null, $depto = null)
    {

        parent::__construct("gr_departamento", array("pais", "depto"));

        if ($pais != null && $depto != null) {
            $this->pais = $pais;
            $this->depto = $depto;
            $this->select();
        }
    }
}
