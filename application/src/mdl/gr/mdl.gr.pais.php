<?php

class Pais extends TABLE
{

    protected $codigo, $nombre, $siglas, $siglas2;

    public function __construct($pais = null)
    {

        parent::__construct("gr_pais", array("codigo"));

        if ($pais != null) {
            $this->codigo = $pais;
            $this->select();
        }
    }
}
