<?php

namespace App\Http\Controllers\Cabinet;

use App\Models\Adverts\Advert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Adverts\FavoritesService;

class FavoriteController extends Controller
{
    private $service;

    public function __construct(FavoritesService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        $adverts = Advert::favoredByUser(Auth::user())->orderByDesc('id')->paginate(20);

        return view('cabinet.favorites.home', compact('adverts'));
    }

    public function add(Advert $advert)
    {
        try {
            $this->service->add(Auth::id(), $advert->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.favorites.home', $advert)
            ->with('success', 'The advert' . $advert->name . ' is added to your Favorites');
    }

    public function remove(Advert $advert)
    {
        try {
            $this->service->remove(Auth::id(), $advert->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.favorites.home', $advert)
            ->with('warning', 'The advert' . $advert->name . ' is removed from your Favorites');

    }
}
