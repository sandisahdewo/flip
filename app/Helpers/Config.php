<?php

class Config {

    public static function get($filename) 
    {
        return require_once 'config/' . $filename . '.php';
    }

    public static function pdoConnection()
    {
        $config = self::get('database');
       
        $host = $config['host'];
        $name = $config['name'];
        $user = $config['user'];
        $password = $config['password'];

        $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}