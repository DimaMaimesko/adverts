<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
