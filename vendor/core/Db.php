<?php

namespace vendor\core;

class Db
{
    public $pdo;
    protected static $instance;

    protected function __construct()
    {
        $conn = [
            'dsn' => 'mysql:host=127.0.0.1;dbname=app;charset=utf8',
            'login' => 'root',
            'password' => '',
        ];
        $this->pdo = new \PDO($conn["dsn"], $conn["login"], $conn["password"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function execute($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function prepare($sql, $values)
    {
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute($values);
            return $sth;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    // get row
    public function getRow($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // get rows
    public function getRows($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // insert row
    public function insertRow($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return TRUE;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // insert row
    public function insertEmptyRow($query)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // update row
    public function updateRow($query, $params = [])
    {
        $this->insertRow($query, $params);
    }

    // delete row
    public function deleteRow($query, $params = [])
    {
        $this->insertRow($query, $params);
    }

    // find row
    public function findRow($query, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

}