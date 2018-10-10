<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'Api\HomeController@home');
Route::post('/register', 'Api\Auth\RegisterController@register');
