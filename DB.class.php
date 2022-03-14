<?php

class DB {

    final public const HOSTNAME = 'localhost';
    final public const USERNAME = 'root';
    final public const PASSWORD = '';
    final public const DATABASE = 'shop';

    public $conn;

    private $table;
    private $column = [];
    private $conditions = [];
    private $values = [];

    public $result;

    public function __construct() 
    {
        try 
        {
            $this->conn = new PDO("mysql:host=".self::HOSTNAME.";dbname=".self::DATABASE."", self::USERNAME, self::PASSWORD);
        }
        catch(PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function column(string ...$column)
    {
        $this->column = $column;
        return $this;
    }

    public function where(string ...$where)
    {
        $this->conditions = $where;
        return $this;
    }

    public function values(...$values)
    {
        $this->values = $values;
        return $this;
    }

    public function select()
    {
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);

        $column  = $this->column === [] ? '*' : implode(',', $this->column);

        $sql = "SELECT " . $column . ' FROM ' . $this->table . $where;
        $stm = $this->conn->prepare($sql);
        if ($stm->execute())
        {
            $this->result = $stm->fetchAll();
        }
    }

    public function insert()
    {
        $column = $this->column === [] ? '' : " (". implode(',', $this->column) .") ";
        $values = "(' ". implode("','", $this->values) . " ')";

        $sql = "INSERT INTO " . $this->table . $column . " VALUES " . $values;

        $this->conn->prepare($sql)->execute();
    }

    public function delete()
    {
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);

        $sql = "DELETE FROM ". $this->table . $where;
        $this->conn->prepare($sql)->execute();
    }

    public function update(){
        $where = " WHERE " . implode(' AND ', $this->conditions);

        $values = implode(', ', $this->values);

        $sql = "UPDATE ". $this->table . " SET " . $values . $where;
        
        $this->conn->prepare($sql)->execute();
    }

}