<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public const STATUS_WAIT = "wait";
    public const STATUS_ACTIVE = "active";


    protected $fillable = [
        'name', 'email', 'password', 'verify_token','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
