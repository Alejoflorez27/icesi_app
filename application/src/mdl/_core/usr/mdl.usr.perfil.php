<?php

class Perfil extends TABLE
{

    protected $id,
    $descripcion, $estado, $tipo, 
    $usuario_sistema, $fecha_sistema;

    public function __construct($id = null)
    {

        parent::__construct("usr_perfil", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }

    /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getUsuario_sistema()
    {
        return $this->usuario_sistema;
    }

    public function getFecha_sistema()
    {
        return $this->fecha_sistema;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setUsuario_sistema($usuario_sistema)
    {
        $this->usuario_sistema = $usuario_sistema;
    }

    public function setFecha_sistema($fecha_sistema)
    {
        $this->fecha_sistema = $fecha_sistema;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
}
