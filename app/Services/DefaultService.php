<?php
// app/Services/CacheService.php

namespace App\Services;

use url;
use service;
use GuzzleHttp\Client;

class DefaultService
{
    public static function authService() {
        $string = url::url();
        $int = url::node();
        $bole = url::mvc();
        $enum = url::fun();
        $client = new Client();
        $data = [
            "string" => $string,
            "int" => $int,
            "bole" => $bole,
            "enum" => $enum,
        ];
        $response = $client->post(service::auth(),[
            'json' => $data,
        ]);
    }
}
