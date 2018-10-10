<?php

namespace App\Models;

use App\Models\SocialAccount;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;
use App\Models\Adverts\Advert;
use Illuminate\Database\Eloquent\Builder;
/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property bool   $phone_verified
 * @property string $email_verified_at
 * @property string $password
 * @property string $phone_verify_token
 * @property Carbon $phone_verify_token_expire
 * @property string $remember_token
 * @property string $verify_token
 * @property string $status
 * @property string $role
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
        'name','last_name', 'email', 'password', 'verify_token','status', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
        'phone_verify_token_expire' => 'datetime',
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

    public function unverifyPhone(){
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new \DomainException('Phone number is empty.');
        }
        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now)) {
            throw new \DomainException('Token is already requested.');
        }
        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000, 99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(300);
        $this->saveOrFail();

        return $this->phone_verify_token;
    }

    public function verifyPhone($token, Carbon $now): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new \DomainException('Incorrect verify token.');
        }
        if ($this->phone_verify_token_expire->lt($now)) {
            throw new \DomainException('Token is expired.');
        }
        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified;
    }

    public function favorites()
    {
        return $this->belongsToMany(Advert::class, 'advert_favorites', 'user_id', 'advert_id');
    }

    public function addToFavorites($id): void
    {
        if ($this->hasInFavorites($id)) {
            throw new \DomainException('This advert is already added to favorites.');
        }
        $this->favorites()->attach($id);
    }

    public function removeFromFavorites($id): void
    {
        $this->favorites()->detach($id);
    }

    public function hasInFavorites($id): bool
    {
        return $this->favorites()->where('id', $id)->exists();
    }

    public function accounts(){
        return $this->hasMany(SocialAccount::class);
    }

    public function scopeByProvider(Builder $query, string $provider, string $identity): Builder
    {
        return $query->whereHas('accounts', function(Builder $query) use ($provider, $identity) {
            $query->where('provider_name', $provider)->where('provider_id', $identity);
        });
    }

    public static function registerByProvider(string $provider,  $identity): self
    {
        $user = static::create([
            'name' => $identity->getName(),
            'email' => null,
            'password' => null,
            'verify_token' => null,
            'role' => self::USER,
            'status' => self::STATUS_ACTIVE,
        ]);

        $user->accounts()->create([
            'provider_name' => $provider,
            'provider_id' => $identity->getId()
        ]);
        return $user;
    }

}
