<?php

class SolSolicitud extends TABLE
{

    protected $id_solicitud;
    protected $estado;
    protected $id_combo;
    protected $id_cuenta;
    protected $id_empresa;
    protected $doc_candidato;
    protected $pais_vacante;
    protected $dpto_vacante;
    protected $ciudad_vacante;
    protected $usuario;
    protected $id_estado_solicitud;
    protected $id_tercero;
    protected $canal_recepcion = null;
    protected $observacion;
    protected $fch_solicitud;
    protected $fch_estimada_sol;
    protected $fch_estimada_sol_nueva;
    protected $preliminar = 'N';
    protected $obs_calidad;
    protected $usr_create;
    protected $fch_create;
    protected $centro_costo;

    public function __construct($id_solicitud = null)
    {

        parent::__construct("sol_solicitud", array("id_solicitud"));

        if ($id_solicitud != null) {
            $this->id_solicitud = $id_solicitud;
            $this->select();
        }
    }

    /*
    * ****************************************
    *  Getter and Setter
    * ****************************************
    */

    public function getIdCombo()
    {
        return $this->id_combo;
    }
    public function getFchSolicitud()
    {
        return $this->fch_solicitud;
    }
    public function getCiudad()
    {
        return $this->ciudad_vacante;
    }
    public function setFchNuevaEstimacion($fch_estimada_sol_nueva)
    {
        $this->fch_estimada_sol_nueva = $fch_estimada_sol_nueva;
    }

    public function getDocCandidato()
    {
        return $this->doc_candidato;
    }
    public function setDocCandidato($doc_candidato)
    {
        $this->doc_candidato = $doc_candidato;
    }


    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }
    public function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }


}
