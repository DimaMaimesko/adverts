<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 27.09.2018
 * Time: 22:55
 */

namespace App\Services\Sms;

class Nexmo implements SmsSender
{
    private $apiKey;
    private $apiSecret;
    private $client;

    public function __construct($api)
    {
        if(empty($api['api_key']) || empty($api['api_secret'])){
            throw new \InvalidArgumentException('SMS api_key and api_secret must be set');
        }
        $this->apiKey = $api['api_key'];
        $this->apiSecret = $api['api_secret'];
        $basic  = new \Nexmo\Client\Credentials\Basic($this->apiKey, $this->apiSecret);
        $this->client = new \Nexmo\Client($basic);
    }

    public function send($number, $text): void{
        $this->client->message()->send([
                'from' => 'Adverts',
                'to' => trim($number),
                'text' => $text
        ]);
    }

}