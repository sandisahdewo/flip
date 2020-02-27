<?php

class Api {

    public static function get($url) 
    {
        $config = Config::get('curl');

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $config['base_url'] . $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $config['key'] . ":");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

        $result = curl_exec($curl);
        curl_close($curl);

        if($result) 
            return $result;
        

        echo json_encode([
            'error' => [
                'code' => 404,
                'message' => 'Resource not found.'
            ]
        ]);
        exit();
    }

    public static function post($url, $data)
    {
        $config = Config::get('curl');

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $config['base_url'] . $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $config['key'] . ":");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        if(isset($result['id'])) return $result;

        echo json_encode([
            'error' => [
                'code' => $result['code'],
                'message' => $result['errors']
            ]
        ]);
        exit();
    }
}