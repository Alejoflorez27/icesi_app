<?php

class Configuracion extends TABLE
{

    protected
    $categoria, $codigo,
    $descripcion, $observacion, $estado,
    $usuario_sistema, $fecha_sistema;

    public function __construct($categoria = null, $codigo = null)
    {

        parent::__construct("configurations", array("categoria", "codigo"));

        if ($categoria != null && $codigo != null) {
            $this->categoria = $categoria;
            $this->codigo = $codigo;
            $this->select();
        }
    }

    /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getObservacion()
    {
        return $this->observacion;
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

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
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

}
