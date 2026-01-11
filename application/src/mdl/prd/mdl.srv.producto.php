<?php

class SrvProducto extends TABLE
{

    protected $id_producto;
    protected $nom_prod;
    protected $estado ;
    protected $usr_create;
    protected $fch_create;


    public function __construct($idProducto = null)
    {

        parent::__construct("srv_producto", array("id_producto"));

        if ($idProducto != null) {
            $this->id_producto = $idProducto;
            $this->select();
        }
    }
}
