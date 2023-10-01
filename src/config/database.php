<?php

class Database {
    private $host = MYSQL_HOST;
    private $database = MYSQL_DATABASE;
    private $port = MYSQL_PORT;
    private $user = MYSQL_USER;
    private $password = MYSQL_PASSWORD;

    private $db_connection;
    private $statement;

    public function __construct() 
    {
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->database;

        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->db_connection = new PDO($dsn, $this->user, $this->password, $option);
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }       
    }   

    public function query($query) 
    {
        try {
            $this->statement = $this->db_connection->prepare($query);
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }
    }

    public function bind($param, $value, $type = null)
    {
        try {
            if (is_null($type)) {
                $type = $this->determineParamType($value);
            }

            $this->statement->bindValue($param, $value, $type);
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }
    }

    private function determineParamType($value)
    {
        if (is_int($value)) {
            return PDO::PARAM_INT;
        } elseif (is_bool($value)) {
            return PDO::PARAM_BOOL;
        } elseif (is_null($value)) {
            return PDO::PARAM_NULL;
        } else {
            return PDO::PARAM_STR;
        }
    }

    public function execute()
    {
        try {
            $this->statement->execute();
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }
    }

    public function fetch()
    {
        try {
            $this->execute();
            return $this->statement->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }
    }

    public function fetchAll()
    {
        try {
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }
    }

    public function rowCount()
    {
        try {
            return $this->statement->rowCount();
        } catch (PDOException $e) {
            error_log('Internal Server Error: ' . $e->getMessage());
        }
    }
}