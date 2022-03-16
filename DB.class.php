<?php

class DB {

    final public const HOSTNAME = 'localhost';
    final public const USERNAME = 'root';
    final public const PASSWORD = '';
    final public const DATABASE = 'shop';

    public $conn;

    private $table;
    private $alias;
    private $column = [];
    private $conditions = [];
    private $values = [];
    private $order = [];
    private $group = [];
    private $innerJoin = [];
    private $leftjoin = [];
    private $outerjoin = [];
    private $limit;

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

    public function table(string $table,string $alias = null)
    {
        $this->table = $alias === null ? $table : "${table} AS ${alias}";
        return $this;
    }

    public function limit(int $limit)
    {
        $this->limit = $limit;
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
    public function group(string ...$group)
    {
        $this->group = $group;
        return $this;
    }
  
    public function order(string ...$order)
    {
        $this->order = $order;
        return $this;
    }
    public function Innerjoin(string ...$innerjoin)
    {
            $this->innerJoin= $innerjoin;
            return $this;
    }
    public function Outerjoin(string ...$outerjoin)
    {
            $this->outerjoin= $outerjoin;
            return $this;
    }
    public function leftjoin(string ...$leftjoin)
    {
            $this->leftjoin= $leftjoin;
            return $this;
    }
    public function values(...$values)
    {
        $this->values = $values;
        return $this;
    }

    public function select()
    {
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' OR ', $this->conditions);
        $order = $this->order === [] ? '' : ' ORDER BY ' . implode(' , ', $this->order);
        $group = $this->group === [] ? '' : ' GROUP BY ' . implode(' , ', $this->group);

        $innerjoin = $this->innerJoin === [] ? '' : ' INNER JOIN '. implode(' INNER JOIN ', $this->innerJoin);
        $outerjoin = $this->outerjoin === [] ? '' : ' OUTER JOIN '.implode(' OUTER JOIN ', $this->outerjoin);
        $leftjoin = $this->leftjoin === [] ? '' : ' LEFT JOIN '. implode(' LEFT JOIN ', $this->leftjoin);
        $limt = $this->limit === null ? '' : ' LIMIT ' . $this->limit;
        $column  = $this->column === [] ? '*' : implode(',', $this->column);

        $sql = "SELECT " . $column . ' FROM ' . $this->table .$leftjoin .$innerjoin. $outerjoin .$where .$group .$order .$limt;
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
        $where = $this->conditions === [] ? '' : ' WHERE ' . implode(' OR ', $this->conditions);

        $sql = "DELETE FROM ". $this->table . $where;
        $this->conn->prepare($sql)->execute();
    }

    public function update(){
        $where = " WHERE " . implode(' OR ', $this->conditions);

        $values = implode(', ', $this->values);

        $sql = "UPDATE ". $this->table . " SET " . $values . $where;
        
        $this->conn->prepare($sql)->execute();
    }



}
$product = new DB();
$product->table('products')->column("COUNT('*')")->order('price')->select();
echo "<hr>";
echo "<h2>Order By</h2>";
foreach ($product->result as $p) {
  
    echo $p['name']."<br>";
    echo $p['price']."<br>";
    echo $p['details']."<br>";
  

}
$product1 = new DB();
$product1->table('products')->column()->group('price')->select();
echo "<hr>";
echo "<h2>Group By</h2>";
foreach ($product1->result as $p) {
  
    echo $p['name']."<br>";
    echo $p['price']."<br>";
    echo $p['details']."<br>";
  

}
echo "<hr>";
echo "<h2>Inner Join</h2>";
$product2 = new DB();
$product2->table('products','p')->column()->Innerjoin('products')->select();
foreach ($product2->result as $p) {
    echo $p['name']."<br>";
    echo $p['price']."<br>";
    echo $p['details']."<br>";
}
echo "<hr>";
echo "<h2>Left Join</h2>";
$product3 = new DB();
$product3->table('products','p')->column()->leftjoin('products')->select();
foreach ($product3->result as $p) {
    echo $p['name']."<br>";
    echo $p['price']."<br>";
    echo $p['details']."<br>";
}
echo "<hr>";
echo "<h2>Outer Join</h2>";
$product3 = new DB();
$product3->table('products','p')->column()->Outerjoin('products')->select();
foreach ($product3->result as $p) {
    echo $p['name']."<br>";
    echo $p['price']."<br>";
    echo $p['details']."<br>";
}
?>