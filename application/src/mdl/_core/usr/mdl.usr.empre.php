<?php

class UsrEmpr extends TABLE
{
    protected $id;
    protected $username;
    protected $id_empresa;


    public function __construct($id = null)
    {

        parent::__construct("usr_empre", array("id"));

        if ($id != null) {
            $this->id = $id;
            $this->select();
        }
    }


}
