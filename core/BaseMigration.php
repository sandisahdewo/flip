<?php

class BaseMigration extends AbstractMigration {

    public static function create($tableName, array $columns = [])
    {
        (new self)->createTable($tableName, $columns);
    }

    public static function drop($tableName)
    {
        (new self)->dropTable($tableName);
    }
}