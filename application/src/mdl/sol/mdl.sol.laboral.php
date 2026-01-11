<?php

class SolLaboral extends TABLE
{

    protected $id_laboral;
    protected $id_solicitud;
    protected $id_servicio;
    protected $nombre_empresa;
    protected $telefono_empresa;
    protected $fch_ingreso;
    protected $fch_retiro;
    protected $cargo_ingreso;
    protected $cargo_finalizo;
    protected $tipo_contrato;
    protected $jefe_inmediato;
    protected $cargo_jefe;
    protected $numero_jefe;
    protected $funciones_desarrolladas;
    protected $tipo_retiro;
    protected $motivo_retiro;
    protected $estado_empresa;
    protected $tmp_total_laborado;
    protected $horario_trabajo;
    protected $observaciones;
    protected $nom_funcionario_valida;
    protected $cargo_funcionario_valida;
    protected $concepto;
    protected $id_ciudad_act;
    protected $usr_create;
    protected $fch_create;


    public function __construct($id_laboral = null)
    {

        parent::__construct("sol_laboral", array("id_laboral"));

        if ($id_laboral != null) {
            $this->id_laboral = $id_laboral;
            $this->select();
        }
    }
}