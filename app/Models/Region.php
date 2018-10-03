<?php
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 *
 * @property Region $parent
 * @property Region[] $children
 *
 * @method Builder roots()
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name','slug','parent_id','sort'];

    public function parent(){
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children(){
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function getAddress(): string
    {
        return ($this->parent ? $this->parent->getAddress() . ', ' : '') . $this->name;
    }

    public function scopeRoots(Builder $query){
        return $query->where('parent_id', null);
    }
    public function getPath(): string
    {
        return ($this->parent ? $this->parent->getPath() . '/' : '') . $this->slug;
    }


}