<?php

class TrcEmpresa extends TABLE
{
  
    protected$id_empresa;
    protected$id_ciudad;
    protected$tipo_id;
    protected$numero_doc;
    protected$razon_social;
    protected$rep_legal;
    protected$email_emp;
    protected$estado;
    protected$id_empresa_padre;
    protected$flag_subemp;
    protected$flag_grup;
    protected$usr_create;
    protected$fch_create;
    protected$nombre_logo;
    protected$nombre_encr;
    protected$directorio;
    protected$tamano;
    protected$ext;
    protected$celular;
    protected$direccion;
    protected$especificacion;




    //protected$id_dpto;

    public function __construct($idEmpresa = null)
    {

        parent::__construct("trc_empresa", array("id_empresa"));

        if ($idEmpresa != null) {
            $this->id_empresa = $idEmpresa;
            $this->select();
        }
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getRazonSocial()
    {
        return $this->razon_social;
    }

    public function setRazonSocial($razon_social)
    {
        $this->razon_social = $razon_social;
    }

}
