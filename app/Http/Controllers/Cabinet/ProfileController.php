<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ProfileEditValidation;
use App\Services\Profile\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        $user = Auth::user();
        return view('cabinet.profile.home',compact('user'));

    }

    public function edit()
    {
        $user = Auth::user();
        return view('cabinet.profile.edit',compact('user'));

    }

    public function update(ProfileEditValidation $request)
    {
        try {
            $this->service->edit(Auth::id(), $request);
        }catch (\DomainException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('cabinet.profile.home');
    }
}
