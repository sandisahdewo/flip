<?php

class Router {

    public static function run() {
        self::routeExists();
    }

    public static function parseRequest($key)
    {
        $parsing = explode("/", $_SERVER['REQUEST_URI']);
        return isset($parsing[$key]) ? $parsing[$key] : null;
    }

    public static function scanControllerFile()
    {
        return str_replace("Controller.php", "", array_diff(\scandir('app/Controllers'), ['..', '.']));
    }

    public static function listControllerLowercase()
    {
        return array_map(function($value) {
            return strtolower($value);
        }, self::scanControllerFile());
    }

    public static function routeExists()
    {
        if(array_search($url = self::parseRequest(1), self::listControllerLowercase()) !== false) {
            self::haveMethod();
        } else {
            self::showUrlNotFound();
        }
    }

    public static function haveMethod()
    {
        if($method = self::parseRequest(2)) {
            if($parameter = self::haveParameter()) {
                self::callWithParameter($method, $parameter);
            } else {
                self::callWithoutParameter($method);
            }
        } else {
            self::callWithoutParameter('index');
        }
    }

    public static function haveParameter()
    {
        if($parameter = self::parseRequest(3)) {
            return $parameter;
        } else {
            self::callWithoutParameter(self::parseRequest(2));
        }
    }

    public static function callWithoutParameter($method) 
    {
        $controllerName = self::parseRequest(1) . 'Controller';
        $controller = new $controllerName();
        call_user_func([$controller, $method]);
    }

    public static function callWithParameter($method, $parameter) 
    {
        $controllerName = self::parseRequest(1) . 'Controller';
        $controller = new $controllerName();
        call_user_func([$controller, $method], $parameter);
    }
    
    public static function methodWant($want = 'POST') 
    {
        if($_SERVER['REQUEST_METHOD'] == $want) return;

        echo json_encode([
            'error' => [
                'code' => 302,
                'message' => "Method not allowed, must use $want method"
            ]
        ]);
        exit();
    }

    public static function showUrlNotFound() 
    {
        echo json_encode([
            'error' => [
                'code' => 404,
                'message' => 'Route not defined'
            ]
        ]);
        exit();
    }

}