<?php

class Usuario extends TABLE
{

    protected $username;
    protected $id_empresa;
    protected $email;
    protected $password;
    protected $nombres;
    protected $apellidos;
    protected $tipo_identificacion;
    protected $numero_identificacion;
    protected $token;
    protected $estado;
    protected $modo;
    protected $perfil;
    protected $create_time;
    protected $last_login;
    protected $password_expiration;
    protected $access_attempts;
    protected $usuario_sistema;
    protected $fecha_sistema;
    protected $firma;
    protected $nom_firma;
    protected $nombre_encr;
    protected $directorio;
    protected $ext_firma;
    protected $primer_acceso;
    protected $registro;
    protected $cargo;
    protected $bandera_bash;


    public function __construct($username = null)
    {

        parent::__construct("usr_usuario", array("username"));

        if ($username != null) {
            $this->username = $username;
            $this->select();
        }
    }

    /*
     * ****************************************
     *  Getter and Setter
     * ****************************************
     */


    public function getUsername()
    {
        return $this->username;
    }

    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getNombre()
    {
        return $this->nombres;
    }

    public function getApellido()
    {
        return $this->apellidos;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getModo()
    {
        return $this->modo;
    }

    public function getCreate_time()
    {
        return $this->create_time;
    }

    public function getLast_login()
    {
        return $this->last_login;
    }

    public function getUsuario_sistema()
    {
        return $this->usuario_sistema;
    }

    public function getFecha_sistema()
    {
        return $this->fecha_sistema;
    }
    public function getRegistro()
    {
        return $this->registro;
    }
    public function setRegistro($registro)
    {
        $this->registro = $registro;
    }
    
    public function getCargo()
    {
        return $this->cargo;
    }
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password, $on_reset = false)
    {
        $dias = CtrConfiguracion::val("usuarios", "password_expiration_days");
        $dias = (isset($dias) && $dias != "") ? $dias : 60;

        $fecha = new DateTime(date("Y-m-d"));
        if (!$on_reset) {
            $fecha->add(new DateInterval('P' . $dias . 'D'));
        } else {
            $fecha->sub(new DateInterval('P1D'));
        }

        $this->password = $password;
        $this->password_expiration = $fecha->format('Y-m-d');
    }

    public function setNombre($nombres)
    {
        $this->nombres = $nombres;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setModo($modo)
    {
        $this->modo = $modo;
    }

    public function setCreate_time($create_time)
    {
        $this->create_time = $create_time;
    }

    public function setLast_login($last_login)
    {
        $this->last_login = $last_login;
    }

    public function setUsuario_sistema($usuario_sistema)
    {
        $this->usuario_sistema = $usuario_sistema;
    }

    public function setFecha_sistema($fecha_sistema)
    {
        $this->fecha_sistema = $fecha_sistema;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    public function getFirma()
    {
        return $this->firma;
    }

    public function setFirma($firma)
    {
        $this->firma = $firma;
    }

    public function getNom_firma()
    {
        return $this->nom_firma;
    }

    public function setNom_firma($nom_firma)
    {
        $this->nom_firma = $nom_firma;
    }

    public function getnombre_encr()
    {
        return $this->nombre_encr;
    }

    public function setNom_encriptado($nombre_encr)
    {
        $this->nombre_encr = $nombre_encr;
    }

    public function getdirectorio()
    {
        return $this->directorio;
    }

    public function setDirectorio($directorio)
    {
        $this->directorio = $directorio;
    }
    
    public function getExt_firma()
    {
        return $this->ext_firma;
    }

    public function setExt_firma($ext_firma)
    {
        $this->ext_firma = $ext_firma;
    }


    public function getPrimerAcceso()
    {
        return $this->primer_acceso;
    }

    public function setPrimerAcceso($primer_acceso)
    {
        $this->primer_acceso = $primer_acceso;
    }



    public function getAccess_attempts()
    {
        return $this->access_attempts;
    }

    public function setAccess_attempts($access_attempts)
    {
        $this->access_attempts = $access_attempts;
    }

    public function setPassword_expiration($password_expiration)
    {
        $this->password_expiration = $password_expiration;
    }

    public function getPassword_expiration()
    {
        return $this->password_expiration;
    }

    public function getBanderaBash()
    {
        return $this->bandera_bash;
    }

    public function setBanderaBash($bandera_bash)
    {
        $this->bandera_bash = $bandera_bash;
    }



    public function failedAccess()
    {
        $access_attempts = $this->access_attempts;
        $access_attempts++;
        $this->access_attempts = $access_attempts;
        if ($access_attempts >= 6) {
            $this->estado = 'INA';
        }

        $this->update(0);
        $this->accessLog('FAILED');
    }

    public function successAccess()
    {
        $this->setLast_login(date("Y-m-d H:i:s"));
        $this->setAccess_attempts(0);

        $this->update(0);
        $this->accessLog('SUCCESS');
    }

    public function accessLog($result)
    {
        $log = new UsuarioAccessLog(
            $this->username,
            CtrUtil::getClienteIP(),
            $result
        );
        return $log->insert();
    }
}
