<?php

namespace phpQuinielas\models;

use phpQuinielas\config\Connection;
use PDO;

class Partidos {

    static private $tableName = 'partidos';

    static public function getAll() 
    {
        $table = self::$tableName;
        $sql = "SELECT * FROM $table ORDER BY jornada DESC";
        $sql = "SELECT p.*, (SELECT e.nombre FROM equipos e WHERE p.idvisitante = e.id) AS visitante, (SELECT e.nombre FROM equipos e WHERE p.idlocal = e.id) AS local FROM partidos p ORDER BY p.jornada DESC, p.orden ASC";
        //echo $sql;
        $stmt = Connection::getConnection()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function getById($id) 
    {
        $table = self::$tableName;
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = Connection::getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        //return $stmt->fetch();
    }

    static public function getByJornada($jornada) 
    {
        $table = self::$tableName;
        $sql = "SELECT * FROM $table WHERE jornada = :jornada";
        $stmt = Connection::getConnection()->prepare($sql);
        $stmt->bindParam(":jornada", $jornada, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        //return $stmt->fetch();
    }

    static public function insert($data) 
    {
        $table = self::$tableName;
        $columnas = "";
        $valores = "";
        foreach ($data as $key => $value)
        {
            $columnas .= $key . ",";
            $valores .= ":" . $key . ",";
        }
        // Quitamos la ultima coma
        $columnas = substr($columnas, 0, -1);
        $valores  = substr($valores,  0, -1);

        $sql = "INSERT INTO $table ($columnas) VALUES ($valores)";

        $conn = Connection::getConnection();
        $stmt = $conn->prepare($sql);
        foreach ($data as $key => $value) 
        {
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        if ($stmt->execute())
        {
            $response = array(
                'id' => $conn->lastInsertId(),
                'resultado' => 'Registro grabado'
            );
    
            return $response;
        }
        return $conn->errorInfo();
    }

    static public function update($id, $data) 
    {
        $table = self::$tableName;

        // Comprobar que id exista
        $response = Equipos::getById($id);
        if (empty($response))
        {
            return null;
        }

        $columnas = "";
        $valores = "";
        foreach ($data as $key => $value)
        {
            $columnas .= $key . "= :" . $key . ",";
        }
        // Quitamos la ultima coma
        $columnas = substr($columnas, 0, -1);

        $sql = "UPDATE $table SET $columnas WHERE id = :id";

        $conn = Connection::getConnection();
        $stmt = $conn->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $data[$key], PDO::PARAM_STR);
        }
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        if ($stmt->execute())
        {
            $response = array(
                'resultado' => 'Registro actualizado'
            );
            return $response;
        }
        return $conn->errorInfo();        
    }

    static public function delete($id) 
    {
        $table = self::$tableName;

        // Comprobar que id exista
        $response = Equipos::getById($id);
        if (empty($response))
        {
            return null;
        }

        $sql = "DELETE FROM $table WHERE id = :id";

        $conn = Connection::getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        if ($stmt->execute())
        {
            $response = array(
                "resultado" => "Registro borrado"
            );
              return $response;
        }
        return $conn->errorInfo();
    }

    static public function getSelect($id) 
    {
        $data = Partidos::getAll();
        $result = '<option selected>Elegir jornada</option>';
        for($i = 0; $i < count($data); ++$i) {
            $fecha = substr($data[$i]->fecha, 8, 2) . "/" . substr($data[$i]->fecha, 5, 2) . "/" . substr($data[$i]->fecha, 0, 4);
            $result .= '<option value="' . $data[$i]->jornada . '">' . $fecha . '</option>';
        }
        return $result;
    }

}

?>