<?php

namespace App\Models\Adverts;

use App\Models\Adverts\Advert\Value;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
/**
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $region_id
 * @property string $title
 * @property string $content
 * @property int $price
 * @property string $address
 * @property string $status
 * @property string $reject_reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $published_at
 * @property Carbon $expires_at
 *
 * @property User $user
 * @property Region $region
 * @property Category $category
 * @property Value[] $values
 * @property Photo[] $photos
 * @method Builder active()
 * @method Builder forUser(User $user)
 */
class Advert extends Model
{
    public const EXPIRES_DAYS = 15;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_MODERATION = 'moderation';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CLOSED = 'closed';

    protected $table = 'advert_adverts';

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function values()
    {
        return $this->hasMany(Value::class, 'advert_id', 'id');
    }

//    public function photos()
//    {
//        return $this->hasMany(Photo::class, 'advert_id', 'id');
//    }


    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isOnModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isClosed(): bool
    {
        return $this->status === self::STATUS_CLOSED;
    }

    public function scopeActive()
    {
        return $this->where('status', self::STATUS_ACTIVE);
    }

    public function scopeOnModeration()
    {
        return $this->where('status', self::STATUS_MODERATION);
    }

    public function scopeMyAdverts()
    {
        return $this->where('user_id', Auth::id())->orderByDesc('updated_at');
    }

    public function scopeForCategory(Builder $query, Category $category)
    {
        return $query->whereIn('category_id', array_merge(
            [$category->id], $category->descendants()->pluck('id')->toArray()));
    }

    public function scopeForRegion(Builder $query, Region $region)
    {
        $ids = [$region->id];
        $childrenIds = $ids;
        while ($childrenIds = Region::where(['parent_id' => $childrenIds])->pluck('id')->toArray()) {
            $ids = array_merge($ids, $childrenIds);
        }
        return $query->whereIn('region_id', $ids);
    }

    public function sendToModeration(){
        if (!$this->isDraft()){
            throw new \DomainException('The advert is not a draft!');
        }
        //здесь должна быть логика проверки заполненности полей: фотки, аттрибуты и т.д.

        //если все хорошо заполнено  - меняем статус на moderation
        $this->update([
            'status' => self::STATUS_MODERATION,
        ]);
    }

    public function moderate(Carbon $date){
        if (!$this->isOnModeration()){
            throw new \DomainException('The advert should have moderation status');
        }
        $this->update([
            'published_at' => $date,
            'expires_at' => $date->copy()->addDays(self::EXPIRES_DAYS),
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function reject($reason){
        if (!$this->isOnModeration()){
            throw new \DomainException('The advert should have moderation status');
        }
        $this->update([
            'reject_reason' => $reason,
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function expire(){
        $this->update([
            'status' => self::STATUS_CLOSED,
        ]);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'advert_favorites', 'advert_id', 'user_id');
    }

    public function scopeFavoredByUser(Builder $query, User $user)
    {
        return $query->whereHas('favorites', function(Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function getValue($id)
    {
        foreach ($this->values as $value) {
            if ($value->attribute_id === $id) {
                return $value->value;
            }
        }
        return null;
    }



}