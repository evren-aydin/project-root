<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
class Database
{
    private $host = "localhost";
    private $dbName = "project";
    private $username = "sa";
    private $password = "1";

    public function getConnection(): PDO
    {
            $pdo =new PDO("sqlsrv:server=$this->host;Database=$this->dbName", $this->username, $this->password,
            [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]

    );

    return $pdo;
    }

}