<?php
namespace App\Http\Controllers\Cabinet\Adverts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdvertsController extends Controller
{
    public function index()
    {
        return view('cabinet.adverts.home');
    }

    public function create()
    {
        return view('cabinet.adverts.create');
    }

    public function edit()
    {
        return view('cabinet.adverts.edit');
    }

}