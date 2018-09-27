<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 27.09.2018
 * Time: 22:58
 */

namespace App\Services\Sms;


interface SmsSender
{
    public function send($phoneNumber, $textMessage): void;

}