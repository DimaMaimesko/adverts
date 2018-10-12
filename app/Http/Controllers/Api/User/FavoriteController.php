<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Resources\Adverts\AdvertListResource;
use App\Models\Adverts\Advert;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Adverts\FavoritesService;
use Illuminate\Http\Response;
class FavoriteController extends Controller
{
    private $service;

    public function __construct(FavoritesService $service)
    {
        $this->service = $service;
    }
    /**
     * @SWG\Get(
     *     path="/user/favorites",
     *     tags={"Favorites"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/AdvertList")
     *         ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        $adverts = Advert::favoredByUser($user)->orderByDesc('id')->paginate(20);
        return AdvertListResource::collection($adverts);
    }
    /**
     * @SWG\Post(
     *     path="/user/favorites/{advertId}",
     *     tags={"Favorites"},
     *     @SWG\Parameter(name="advertId", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function add(Advert $advert)
    {
        $this->service->add(Auth::id(), $advert->id);
        return response()->json([], Response::HTTP_CREATED);
    }
    /**
     * @SWG\Delete(
     *     path="/user/favorites/{advertId}",
     *     tags={"Favorites"},
     *     @SWG\Parameter(name="advertId", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function remove(Advert $advert)
    {
        $this->service->remove(Auth::id(), $advert->id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
