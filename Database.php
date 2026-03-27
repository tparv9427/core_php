<?php
 
class Database
{
    public $server = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "ecomdb";
    private $conn;
 
    public function connect()
    {
        if ($this->conn) {
            return $this;
        }

        $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->dbname, 9000);
 
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
 
        return $this;
    }
 
    public function insert($query)
    {
        $this->connect();
        if (mysqli_query($this->conn, $query)) {
            $id = mysqli_insert_id($this->conn);
            return $id ? $id : true;
        }
        return false;
    }
 
    public function update($query)
    {
        $this->connect();
        return mysqli_query($this->conn, $query) ? true : false;
    }
 
    public function fetchRow($query)
    {
        $this->connect();
        $result = mysqli_query($this->conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
 
    public function fetchAll($query)
    {
        $this->connect();
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        }
        return false;
    }
 
    public function delete($query)
    {
        $this->connect();
        return mysqli_query($this->conn, $query) ? true : false;
    }
}
?>
