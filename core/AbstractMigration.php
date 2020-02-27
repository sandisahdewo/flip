<?php

abstract class AbstractMigration {

    protected $pdo;

    protected $query;

    public function __construct()
    {
        $this->pdo = Config::pdoConnection();
    }

    public function addTableName($tableName)
    {
        $this->query .= $tableName;
    }

    public function createTable($tableName, $columns)
    {
        echo "Migrating table $tableName" . PHP_EOL;

        $this->query = "CREATE TABLE IF NOT EXISTS ";
        $this->addTableName($tableName);
        $this->generateColumns($columns);

        $this->pdo->exec($this->query);
        echo "Migrated table $tableName" . PHP_EOL;
    }

    public function beginColumn()
    {
        $this->query .= " (";
    }

    public function generateColumns($columns)
    {
        $this->beginColumn();
        foreach($columns as $key => $column) {
            $this->addColumnName($column);

            $this->addColumnType($column);

            $this->addColumnLength($column);
            
            $this->addPrimary($column);

            $this->addNullable($column);

            $this->addDefault($column);

            if($key != count($columns) - 1) {
                $this->query .= ", ";
            }
        }
        $this->endColumn();
    }

    public function addColumnName($column)
    {
        $this->query .= "" . $column['name'];
    }

    public function addColumnType($column)
    {
        $this->query .= " " . $column['type'];
    }

    public function addColumnLength($column)
    {
        if(isset($column['length'])) {
            $length = $column['length'];
            $this->query .= " ($length) ";
        }
    }

    public function addPrimary($column)
    {
        if(isset($column['primary'])) {
            $this->query .= " AUTO_INCREMENT PRIMARY KEY";
        }
    }

    public function addNullable($column)
    {
        if(isset($column['null']) && $column['null'] == true) {
            $this->query .= " NULL";
        } else {
            $this->query .= " NOT NULL";
        }
    }

    public function addDefault($column)
    {
        if(isset($column['default'])) {
            $default = $column['default'];

            $query .= " DEFAULT '$default'";
        }
    }

    public function endColumn()
    {
        $this->query .= ")";
    }

    public function dropTable($tableName)
    {
        echo "Dropping table $tableName" . PHP_EOL;

        $query = "DROP TABLE IF EXISTS $tableName";
        $this->pdo->exec($query);

        echo "Dropped table $tableName" . PHP_EOL;
    }
}