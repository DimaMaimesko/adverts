<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $verify_token
 * @property string $status
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles;

    public const STATUS_WAIT = "wait";
    public const STATUS_ACTIVE = "active";

    public const SUPERADMIN = 'Superadmin';
    public const MODERATOR = 'Moderator';
    public const USER = 'User';
    // manager roles
    const ADMIN_ROLES = [self::SUPERADMIN,self::MODERATOR];

    protected $fillable = [
        'name', 'email', 'password', 'verify_token','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function rolesList(): array
    {
        return [
            self::USER => 'User',
            self::MODERATOR => 'Moderator',
            self::SUPERADMIN => 'Admin',
        ];
    }

    public function isWait(){
        if ($this->status == self::STATUS_WAIT)
            return true;
        return false;
    }

    public function isActive(){
        if ($this->status == self::STATUS_ACTIVE)
            return true;
        return false;
    }

}
