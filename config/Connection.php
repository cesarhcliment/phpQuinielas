<?php

namespace phpQuinielas\config;

use PDO;

class Connection {
    private $driver = 'pgsql';
    private $host = 'localhost';
    private $dbname = 'Quinielas';
    private $port = '5432';
    private $user = 'postgres';
    private $password = 'root';
    private $connect;

    static public function getConnection()
    {
        try {
            $connection = new Connection();
            $connection->connect = new PDO("{$connection->driver}:host={$connection->host};port={$connection->port};dbname={$connection->dbname}",$connection->user,$connection->password);
            $connection->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "conectado a la DB";
            return $connection->connect;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
// Connection::getConnection();
?>
