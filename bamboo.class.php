<?php
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Client;

class Bamboo {

    protected $bamboo;

    function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();
    }

    public function whosOut()
    {
        $start = date('Y-m-d', strtotime("-7 days"));
        $end = date('Y-m-d', strtotime("+15 days"));
        
        $response = $this->query( "time_off/whos_out?start={$start}&end={$end}" );

        return $response->getBody();
    }

    private function query( $path )
    {
        $this->bamboo = new Client();

        $response = $this->bamboo->get(
            'https://api.bamboohr.com/api/gateway.php/' . $_ENV['BAMBOOHR_DOMAIN'] . '/v1/' . trim( $path, "/" ), 
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'auth' => [
                    $_ENV['BAMBOOHR_TOKEN'], 
                    'x'
                ]
            ]
        );

        return $response;
    }
}