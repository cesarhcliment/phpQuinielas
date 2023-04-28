<?php

namespace phpQuinielas\models;

use phpQuinielas\config\Connection;
use PDO;

class Equipos {

    static private $tableName = 'equipos';

    static public function getAll() 
    {
        $table = self::$tableName;
        $sql = "SELECT * FROM $table ORDER BY id";
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
}

?>