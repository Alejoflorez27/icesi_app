<?php

class Dimension extends TABLE
{

    protected $id_dimension;
    protected $id_servicio;
    protected $nombre_dimension;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_dimension = null)
    {

        parent::__construct("dimensiones", array("id_dimension"));

        if ($id_dimension != null) {
            $this->id_dimension = $id_dimension;
            $this->select();
        }
    }
}