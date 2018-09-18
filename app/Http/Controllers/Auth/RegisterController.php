<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerifyMail;
use DateTime;
class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verify_token' => Str::random(16),
            'status' => User::STATUS_WAIT,
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        flash()->overlay('Check your email and click on the link to verify.!', 'Check your email');
        return redirect()->route('login')->with('success','Check your email and clock on the link to verify.');

    }

    public function verify($token){
        $user = User::where('verify_token',$token)->first();
        if ((isset($user)) && ($user->status === User::STATUS_WAIT)){
            $user->status = User::STATUS_ACTIVE;
            $user->email_verified_at = now();
            $user->save();
            $this->guard()->login($user);
            return view('home')->with('success','Your Email is verified!');
        }else{
            return redirect()->route('login')->with('error','Error!');
        }
    }
}
