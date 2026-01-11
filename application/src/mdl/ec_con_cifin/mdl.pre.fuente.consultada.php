<?php

class preFuenteConsultada extends TABLE
{

    protected $id_pre_fuente;
    protected $id_tipo_consulta;
    protected $no_pregunta;
    protected $orden;
    protected $texto;
    protected $variable;
    protected $tipo_variable;
    protected $usr_create;
    protected $fch_create;

    public function __construct($id_pre_fuente = null)
    {

        parent::__construct("pre_fuente_consultada", array("id_pre_fuente"));

        if ($id_pre_fuente != null) {
            $this->id_pre_fuente = $id_pre_fuente;
            $this->select();
        }
    }
}