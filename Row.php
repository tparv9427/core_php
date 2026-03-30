<?php

class Row
{
    public $tableName = "";
    public $primaryKey = "";
    public $db = null;
    public $data = [];

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function load($value, string $column = null): Row|false
    {
        if ($column === null) {
            $column = $this->primaryKey;
        }
        $safeValue = $this->db->getConnection()->quote($value);
        $sql = "SELECT * FROM {$this->tableName} WHERE {$column} = {$safeValue} LIMIT 1";
        $result = $this->db->fetchRow($sql);
        if ($result) {
            $this->data = $result;
            return $this;
        }
        return false;
    }

    public function insert(): Row|false
    {
        $columnNames = "";
        $columnValues = "";

        foreach ($this->data as $column => $value) {
            $columnNames = $columnNames . $column . ", ";
            $safeValue = $this->db->getConnection()->quote($value);
            $columnValues = $columnValues . $safeValue . ", ";
        }

        $columnNames = rtrim($columnNames, ", ");
        $columnValues = rtrim($columnValues, ", ");

        $sql = "INSERT INTO $this->tableName ($columnNames) VALUES ($columnValues)";

        $newId = $this->db->insert($sql);
        if ($newId) {
            $this->data[$this->primaryKey] = $newId;
            return $this;
        }
        return false;
    }

    public function update(): Row|false
    {
        $primaryKeyValue = $this->data[$this->primaryKey];
        if (!$primaryKeyValue) {
            return false;
        }

        $updateString = "";
        foreach ($this->data as $column => $value) {
            if ($column == $this->primaryKey) {
                continue;
            }
            $safeValue = $this->db->getConnection()->quote($value);
            $updateString = $updateString . "$column = $safeValue, ";
        }
        $updateString = rtrim($updateString, ", ");

        $safeId = $this->db->getConnection()->quote($primaryKeyValue);
        $sql = "UPDATE $this->tableName SET $updateString WHERE $this->primaryKey = $safeId";

        if ($this->db->update($sql)) {
            return $this;
        }
        return false;
    }

    public function save(): Row|false
    {
        if (isset($this->data[$this->primaryKey]) && !empty($this->data[$this->primaryKey])) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    public function value(string $key, $value = null)
    {
        if (!$key) {
            throw new Exception("key should not be null");
        }

        if ($value !== null) {
            $this->data[$key] = $value;
            return $this;
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }
}
