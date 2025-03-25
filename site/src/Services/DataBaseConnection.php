<?php

namespace App\Services;

use Exception;
use PDO;

class DataBaseConnection
{
    private $hostName;
    private $userName;
    private $password;
    private $dbName;
    private $port;
    private $connection;

    public function __construct(
        string $hostName,
        string $userName,
        string $password,
        string $dbName,
        string $port
    ) {
        $this->hostName = $hostName;
        $this->userName = $userName;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->port = $port;
    }

    public function connect(): ?PDO
    {
        try {
            $dsn = "mysql:host={$this->hostName};dbname={$this->dbName};port={$this->port}";
            $this->connection = new PDO($dsn, $this->userName, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            error_log('Connection failed: ' . $e->getMessage());
            throw new Exception("Connection failed: " . $e->getMessage());
        }

        return $this->connection;
    }
}
