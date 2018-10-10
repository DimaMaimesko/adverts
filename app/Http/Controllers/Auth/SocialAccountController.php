<?php

namespace App\Http\Controllers\Auth;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Services\Auth\ProviderService;

class SocialAccountController extends Controller
{
    //
    private $service;

    public function __construct(ProviderService $service)
    {
        $this->service = $service;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $data = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong!');
        }
        try {
            $user = $this->service->auth($provider, $data);
            Auth::login($user);
            return redirect()->intended();
        } catch (\DomainException $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }

//    public function findOrCreateUser($socialUser, $provider){
//        $account = SocialAccount::where('provider_name', $provider)
//            ->where('provider_id', $socialUser->getId())->first();
//        if ($account){
//            return $account->user;
//        }else{
//            $user = User::where('email', $socialUser->getEmail())->first();
//            if (!$user){
//                $user = User::create([
//                    'email' => $socialUser->getEmail(),
//                    'name' => $socialUser->getName(),
//                    'status' => User::STATUS_WAIT,
//                    'verify_token' => Str::random(16),
//                ]);
//            }
//            $user->accounts()->create([
//                'provider_name' => $provider,
//                'provider_id' => $socialUser->getId()
//            ]);
//            return $user;
//        }
//    }
//    public function handleProviderCallback($provider)
//    {
//        try {
//            $user = Socialite::driver($provider)->user();
//        } catch (\Exception $e) {
//            return redirect('/login')->with('error', 'Something went wrong!');
//        }
//
//        $authUser = $this->findOrCreateUser($user, $provider);
//
//        Auth::login($authUser, true);
//
//        return redirect('/home');
//    }
//
//    public function findOrCreateUser($socialUser, $provider){
//        $account = SocialAccount::where('provider_name', $provider)
//            ->where('provider_id', $socialUser->getId())->first();
//        if ($account){
//            return $account->user;
//        }else{
//            $user = User::where('email', $socialUser->getEmail())->first();
//            if (!$user){
//                $user = User::create([
//                    'email' => $socialUser->getEmail(),
//                    'name' => $socialUser->getName(),
//                    'status' => User::STATUS_WAIT,
//                    'verify_token' => Str::random(16),
//                ]);
//            }
//            $user->accounts()->create([
//                'provider_name' => $provider,
//                'provider_id' => $socialUser->getId()
//            ]);
//            return $user;
//        }
//    }
}
