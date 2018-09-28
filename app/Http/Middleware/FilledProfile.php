<?php
/**
 * Created by PhpStorm.
 * User: дз
 * Date: 28.09.2018
 * Time: 20:12
 */

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

class FilledProfile
{

    public function handle($request, \Closure $next)
    {
        $user = Auth::user();
        if (empty($user->name) || empty($user->last_name) || $user->isPhoneVerified()){
            return  redirect()
                ->route('cabinet.profile.home')
                ->with('error', 'Please fill in your profile and verify your phone');
        }

        return $next($request);
    }

}