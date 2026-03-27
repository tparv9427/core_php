<?php
include("Database.php");

class Row
{
    public $tableName = "";
    public $primaryKey = "";
    protected $db = null;
    public $data = [];

    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

        public function value($key, $value = null)
    {
        if ($key === null) {
            throw new Exception("Key should not be null");
        }

        if ($value !== null) {
            $this->data[$key] = $value;
            return $this;
        }

        return $this->data[$key] ?? null;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->value($key, $value);
        }
        return $this;
    }
}

class Product extends Row
{
    public $tableName = "product";
    public $primaryKey = "product_id";
}


?>
