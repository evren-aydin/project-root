<?php
namespace App\Models;

use PDO;
use PDOException;

class Db {
    private $host = 'localhost'; 
    private $dbName = 'project';  
    private $conn;

    
    public function connect() {
        $this->conn = null;

        try {
            $dsn = "sqlsrv:Server=$this->host;Database=$this->dbName";  
            $this->conn = new PDO($dsn);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>