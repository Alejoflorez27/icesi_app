<?php

class UsuarioAccessLog extends TABLE
{

    protected $username, $fecha_acceso, $ip_acceso, $resultado;

    public function __construct($username = null, $ip_acceso = null, $resultado = null)
    {
        parent::__construct("usr_usuario_access_log", array());
        
        if ($username)
            $this->username = $username;

        if ($ip_acceso)
            $this->ip_acceso = $ip_acceso;

        if ($resultado)
            $this->resultado = $resultado;
    }
}
