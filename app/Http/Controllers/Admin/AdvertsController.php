<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\EditRequest;
use App\Models\Adverts\Advert;
use App\Notifications\StatusChangedNotification;
use Illuminate\Support\Facades\Auth;
use App\Services\Advert\AdvertService;
use App\Http\Requests\Adverts\RejectRequest;

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
        $adverts = Advert::latest()->paginate(20);
        return view('admin.adverts.home', [
            'adverts' => $adverts,
        ]);
    }

    public function tomoderation($advert)
    {
        $this->service->sendToModeration($advert);
        return back();
    }

    public function show($advert)
    {
        $advert = Advert::find($advert);
        return view('admin.adverts.show', compact('advert'));
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

    public function moderate($advert)
    {
      $advert = Advert::find($advert);
      $advert->moderate(now());
        $advert->user->notify(new StatusChangedNotification($advert->status, $advert->title));

      return redirect()->route('admin.adverts.index')->with('success', 'Advert is activated!');
    }

    public function reject(RejectRequest $request, $advert)
    {
       $advert = Advert::find($advert);
       $advert->reject( $request->input('reject_reason'));

       return redirect()->route('admin.adverts.index')->with('warning', 'Advert is rejected!');
    }





}