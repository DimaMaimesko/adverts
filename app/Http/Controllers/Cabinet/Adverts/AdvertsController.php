<?php
namespace App\Http\Controllers\Cabinet\Adverts;
use App\Http\Controllers\Controller;
use App\Models\Adverts\Advert;
use Illuminate\Support\Facades\Auth;
use App\Services\Advert\AdvertService;

class AdvertsController extends Controller
{
    private $service;

    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $adverts = Advert::myAdverts()->paginate(10);
        return view('cabinet.adverts.home', [
            'adverts' => $adverts,
        ]);
    }

    public function tomoderation($advert)
    {
        $this->service->sendToModeration($advert);
        return back();
    }

    public function delete($advert)
    {
        Advert::destroy($advert);
        flash('Advert destroyed')->warning();
        return redirect()->route('cabinet.adverts.home');
    }



}