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

    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        $adverts = Advert::favoredByUser($user)->orderByDesc('id')->paginate(20);
        return AdvertListResource::collection($adverts);
    }

    public function add(Advert $advert)
    {
        $this->service->add(Auth::id(), $advert->id);
        return response()->json([], Response::HTTP_CREATED);
    }

    public function remove(Advert $advert)
    {
        $this->service->remove(Auth::id(), $advert->id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
