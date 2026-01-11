<?php

class ConfDiasFestivos extends TABLE
{

    protected
        $id_dias, $ano, $mes, $fecha, $descripcion, $usr_create, $fch_create;

    /*public function __construct($ano = null, $mes = null, $fecha = null)
    {

        parent::__construct("conf_dias_festivos", array("ano", "mes", "fecha"));

        if ($ano != null && $mes != null) {
            $this->ano = $ano;
            $this->mes = $mes;
            $this->fecha = $fecha;
            $this->select();
        }
    }*/

    public function __construct($id_dias  = null)
    {
        parent::__construct("conf_dias_festivos", array("id_dias"));

        if ($id_dias != null) {
            $this->id_dias = $id_dias;
            $this->select();
        }
    }

    /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */

    public function getAno()
    {
        return $this->ano;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

}
