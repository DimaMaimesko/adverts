<?php
namespace App\Http\Controllers\Cabinet\Adverts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\EditRequest;
use App\Models\Adverts\Advert;
use Illuminate\Support\Facades\Auth;
use App\Services\Advert\AdvertService;

use Illuminate\Support\Facades\Request;

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

    public function edit($advert)
    {
        $advert = Advert::find($advert);
        return view('cabinet.adverts.edit', compact('advert'));
    }

    public function update(EditRequest $request, $advert)
    {
        $advert = Advert::find($advert);
        $advert->update($request->input());
        return redirect()->route('cabinet.adverts.home')->with('success', 'Advert successfully updated');
    }

    public function delete($advert)
    {
        Advert::destroy($advert);
        flash('Advert destroyed')->warning();
        return redirect()->route('cabinet.adverts.home');
    }



}