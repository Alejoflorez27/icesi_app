<?php

/*  ====== LICENCIA DE USO =======
    MIT License

    Copyright (c) 2020  Sofditech
    https://wwww.sofditech.com

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
 * QuerySQL
 *
 * @autor
 * SOfditeche
 * EMAIL: soporte@sofditech.com
 * LK: https://www.sofditech.com/
 *
 * @purpose
 * Tiene como finalidad realizar consultas complejas(multipleas tablas) a la base de datos
 * Admite condiciones WHERE del tipo: | "A>B" | "A<B" | "A<>B" | "A BETWENN B AND C" | y otras
 * Multiples tablas
 * Agrupamiento GROUP BY, HAVING
 *
 */

class QuerySQL
{
    /*
     * @function select
     * Ejecuta instruccion SQL: SELECT
     *
     * @params
     *      @var $queryBase
     *          [STRING] consulta sql.
     *      @var $parametros
     *          [ARRAY] variables a reemplazar en el query, de la forma {variable1 => valor1, variable2 => valor2 ...}
     *          Si no se envia no se reemplaza ninguna variable si existiera en el $queryBase.
     *      @var $fAll
     *          [BOOLEAN] indica si se regresa una matriz bidimencional, aunque el resultado sea un solo registro. Ej: Array[0][campo1, campo2 ...]
     *          Si no se envia y el resultado es un solo registro se obtiene Array[campo1, campo2 ...]
     */

    public static function select($queryBase, $parametros = array(), $fAll = true, $fIdx = "S")
    {

        if (isset($queryBase) && $queryBase != "") {
            $conn = new DATABASE();
            $stmt = $conn->getDb()->prepare($queryBase);

            if (!empty($parametros)) {
                QuerySQL::PDOBindArray($stmt, $parametros);
            }

            try {
                $stmt->execute();
                $registros = $stmt->rowCount();
                if ($fAll || $registros > 1) {
                    if ($fIdx == "S") {
                        return $stmt->fetchAll();
                    } else {
                        return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                }

                if ($registros == 1) {
                    // return $stmt->fetch();
                    if ($fIdx == "S") {
                        return $stmt->fetch();
                    } else {
                        return $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                }
                return null;
            } catch (Exception $ex) {
                echo $ex->getMessage();
                return null;
            }
        }
    }

    /*
     * @function PDOBindArray
     * Reemplaza en el stmt las variables por los valores correspondientes
     *
     * @params
     *      @var $poStatement
     *          stmt preparado previamente. esta precedido del simobolo "&" para reemplazar el original despues de ser procesado.
     *      @var $paArray
     *          [ARRAY] columnas y valores para reemplazar las variables. de la forma {variable1 => valor1, variable2 => valor2 ...}
     */

    public static function PDOBindArray(&$poStatement, &$paArray)
    {

        foreach ($paArray as $k => $v) {
            if (preg_match('/^[a-zA-Z-_]+$/', $k)) {
                $poStatement->bindValue(':' . $k, $v);
            }
        }
    }

    public function getConexion()
    {
        $conn = new DATABASE();
        return $conn->getDb;
    }

    public static function call($queryBase, $parametros = array(), $fAll = true)
    {

        if (isset($queryBase) && $queryBase != "") {
            $conn = new DATABASE();
            $stmt = $conn->getDb()->prepare($queryBase);

            if (!empty($parametros)) {
                QuerySQL::PDOBindArray($stmt, $parametros);
            }

            try {
                $proc = $stmt->execute();
                return array("success" => $proc, "code" => "Procedimiento ejecutado");
            } catch (Exception $ex) {
                return array("success" => false, "code" => $ex->getMessage());
            }
        }
    }

    public static function update($queryBase, $parametros = array())
    {

        if (isset($queryBase) && $queryBase != "") {
            $conn = new DATABASE();
            $stmt = $conn->getDb()->prepare($queryBase);

            if (!empty($parametros)) {
                QuerySQL::PDOBindArray($stmt, $parametros);
            }

            try {
                $stmt->execute();
                return array("success" => true, "action" => "UPDATE", "rows" => $stmt->rowCount());
            } catch (PDOException $ex) {
                return array("success" => false, "action" => "UPDATE ", "code" => $ex->getMessage());
            }
        }
    }

    public static function delete($queryBase, $parametros = array())
    {

        if (isset($queryBase) && $queryBase != "") {
            $conn = new DATABASE();
            $stmt = $conn->getDb()->prepare($queryBase);

            if (!empty($parametros)) {
                QuerySQL::PDOBindArray($stmt, $parametros);
            }

            try {
                $stmt->execute();
                return array("success" => true, "action" => "DELETE", "rows" => $stmt->rowCount());
            } catch (PDOException $ex) {
                return array("success" => false, "action" => "DELETE ", "code" => $ex->getMessage());
            }
        }
    }

    public static function insert($queryBase, $parametros = array())
    {

        if (isset($queryBase) && $queryBase != "") {
            $conn = new DATABASE();
            $stmt = $conn->getDb()->prepare($queryBase);

            if (!empty($parametros)) {
                QuerySQL::PDOBindArray($stmt, $parametros);
            }

            try {
                $stmt->execute();
                return array("success" => true, "action" => "INSERT", "rows" => $stmt->rowCount());
            } catch (PDOException $ex) {
                return array("success" => false, "action" => "INSERT ", "code" => $ex->getMessage());
            }
        }
    }
}
