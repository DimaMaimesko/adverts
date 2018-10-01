<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 30.09.2018
 * Time: 11:47
 */

namespace App\Services\Advert;
use App\Http\Requests\Adverts\CreateRequest;
use App\Models\Adverts\Advert;
use App\Models\User;
use App\Models\Region;
use App\Models\Adverts\Category;
use Illuminate\Support\Facades\DB;

class AdvertService
{
    public function create($userId, $categoryId, $regionId, CreateRequest $request)
    {
        $user = User::findOrFail($userId);
        $category = Category::findOrFail($categoryId);
        $region = $regionId ? Region::findOrFail($regionId) : null;

        return DB::transaction(function () use ($request, $user, $category, $region) {
            $advert = Advert::make([
                'title' => $request['title'],
                'content' => $request['content'],
                'price' => $request['price'],
                'address' => $request['address'],
                'status' => Advert::STATUS_DRAFT,
            ]);
            $advert->user()->associate($user); //$advert->user_id = $user->id
            $advert->category()->associate($category);
            $advert->region()->associate($region);
            $advert->saveOrFail();
            foreach ($category->allAttributes() as $attribute) {
                $value = $request['attributes'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }
            return $advert;
        });
    }

}