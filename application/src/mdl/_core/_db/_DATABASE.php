<?php

/*  ====== LICENCIA DE USO =======
    MIT License

    Copyright (c) 2020  Sofditech
    http://www.sofditech.com

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
 */


/*
 * @class 
 * DATABASE
 * 
 * @autor
 * SOFDITECH
 * 
 * @purpose
 * Tiene como finalidad la generar la conexion con la base de datos
 */

class DATABASE
{
    /*
     * @var $db
     * Conexion de base de datos
     */

    private $db; //db es $conn objeto PDO

    function __construct($init = 0)
    {
        if ($init == 1) {
            $this->db = $this->conectar();
        }
    }

    function getDb()
    {
        if (!$this->db) {
            $this->db = $this->conectar();
        }
        return $this->db;
    }

    protected function conectar()
    {

        try {
            $dsn = constant('DB_DRIVER') . ":";
            $dsn .= "host=" . constant('DB_HOST') . ";";
            $dsn .= "dbname=" . constant('DB_NAME') . ";";
            $dsn .= "charset=" . constant('DB_CHARSET');

            $conn = new PDO($dsn, constant('DB_USER'), constant('DB_PASSWORD'));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
