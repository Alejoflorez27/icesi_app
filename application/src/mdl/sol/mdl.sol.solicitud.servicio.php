<?php

class SolSolicitudServicio extends TABLE
{


  protected $id;
  protected $id_solicitud;
  protected $id_servicio;
  protected $id_usuario_asig;
  protected $fecha_asignado;
  protected $fecha_termina_proveedor;
  protected $id_usuario_calidad;
  protected $prioridad;
  protected $fecha_programacion;
  protected $asistio;
  protected $observacion_asistio;
  protected $calificado;
  protected $observacion_finalizacion;
  protected $observacion;
  protected $para;
  protected $mensaje;
  protected $estado;
  protected $estado_proceso;
  protected $motivo_cancelado;
  protected $facturado;
  protected $servicio_adicionado;
  protected $ultimo;
  protected $cont_proceso;

    public function __construct($id = null)
    {

        parent::__construct("sol_solicitud_servicio", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }

    public function getCalificado()
    {
        return $this->calificado;
    }
}
