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

    public function __construct($apiKey = '42b2afe0', $apiSecret = 'dWbo8f3jzvZ79LQ7')
    {
        if(empty($apiKey) || empty($apiSecret)){
            throw new \InvalidArgumentException('SMS api_key and api_secret must be set');
        }
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
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