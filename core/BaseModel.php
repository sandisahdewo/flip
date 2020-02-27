<?php

class BaseModel {

    protected $primaryKey = 'id';

    protected $db;

    protected $config;

    public function __construct()
    {
        $this->db = Config::pdoConnection();
    }

    public function find($id)
    {
        $pdo = $this->db->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = ?");
        $pdo->bindValue(1, $id);
        $pdo->execute();

        $result = $pdo->fetch(PDO::FETCH_ASSOC);
        if($result) 
            return $result;

        return;
    }

    protected function insert(array $data)
    {
        $query = "INSERT INTO $this->table ";
        $queryColumns = implode(", ", array_keys($data));
        $queryValues = ":" . implode(", :", array_keys($data));
        
        $query .= "($queryColumns) VALUES ($queryValues)";

        try {
            return $this->db->prepare($query)->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    protected function updating(int $id, array $data)
    {
        $query = "UPDATE $this->table SET ";

        $queryColumns = [];
        foreach($data as $key => $value) {
            $queryColumns[] = $key . "=:" . $key;
        }
        $queryColumns = implode(", ", $queryColumns);

        $query .= "$queryColumns WHERE $this->primaryKey=:id";
        $data = array_merge($data, [$this->primaryKey => $id]);

        try {
            return $this->db->prepare($query)->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}