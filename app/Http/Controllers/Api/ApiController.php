<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\AddressValidation;

class ApiController extends Controller
{

    public function github($username)
    {
        $client = new GuzzleClient();
        $result = $client->get("https://api.github.com/users/$username");
        $bodyStr = $result->getBody()->getContents();
        $bodyJson = json_decode($bodyStr);
        dd($bodyJson);
    }

    public function darksky($lat,$lon)//$lat = 46.9684007;$lon = 32.0156948;
    {
        $secret = env('DARKSKY_API_SECRET');
        $client = new GuzzleClient();
//      $result = $client->get("https://api.darksky.net/forecast/$secret/$lat,$lon");
        $result = $client->get("https://api.darksky.net/forecast/$secret/$lat,$lon", [
            'query' => [
                'exclude'     => 'minutely,hourly,daily,alerts,flags',
                'units'       => 'si',
            ]
        ]);
        $bodyStr = $result->getBody()->getContents();
        $bodyJson = json_decode($bodyStr);
        return view('cabinet.weather.show', ['bodyJson' => $bodyJson]);
    }

    public function showForm()
    {
        return view('cabinet.weather.show');
    }

    public function getWeather(AddressValidation $request)
    {
        $googleClient = new GuzzleClient();
        $googleResult = $googleClient->get('https://maps.googleapis.com/maps/api/geocode/json', [
            'query' => [
                'address' => $request->address,
                'key'     => env('GOOGLE_API_KEY'),
            ]
        ]);
        $googleBody = $googleResult->getBody()->getContents();
        $coords = json_decode($googleBody)->results[0]->geometry->location;

        $client = new GuzzleClient();
        $weatherResult = $client->get("https://api.darksky.net/forecast/" . env('DARKSKY_API_SECRET') . "/$coords->lat,$coords->lng", [
            'query' => [
                'exclude'     => 'minutely,hourly,daily,alerts,flags',
                'units'       => 'si',
            ]
        ]);
        $weatherBody = $weatherResult->getBody()->getContents();
        $weather = json_decode($weatherBody);

        return view('cabinet.weather.show', [
            'weather' => $weather,
            'address' => json_decode($googleBody)->results[0],
        ]);

    }
}
