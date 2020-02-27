<?php

require 'vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
$parseUrl = explode('/', $request);

switch ($parseUrl[1]) {
    case 'find' :
        if(empty($parseUrl[2])) {
            echo json_encode([
                'error' => [
                    'code' => '404', 
                    'message' => 'Method need parameter'
                ]
            ]);
            exit();
        }

        $apiController = new DisburseController();
        $apiController->find($parseUrl[2]);
        break;
    case 'store' :
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode([
                'error' => [
                    'code' => '500', 
                    'message' => 'Method not allowed, must POST'
                ]
            ]);
            exit();
        }

        $apiController = new DisburseController();
        $apiController->store();
        break;
    default:
        echo json_encode([
            'error' => [
                'code' => 404, 
                'message' => 'Route not defined'
            ]
        ]);
        break;
}