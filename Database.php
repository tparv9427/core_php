<?php

class Database {
    public $server = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "ecomdb";
    public $port = "9000";
    protected $conn = null;

    public function connect() : Database {
        $dsn = "mysql:host={$this->server};port={$this->port};dbname={$this->dbname}";
        $this->conn = new PDO($dsn, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function insert(string $query) {
        $this->conn->exec($query);
        return $this->conn->lastInsertId();
    }

    public function update(string $query) : bool {
        return $this->conn->exec($query) !== false;
    }

    public function delete(string $query) : bool {
        return $this->conn->exec($query) !== false;
    }

    public function fetchRow(string $query) {
        $stmt = $this->conn->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll(string $query) {
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query) {
        $stmt = $this->conn->query($query);
        return $stmt->fetchColumn();
    }

    public function fetchPair(string $query) {
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
