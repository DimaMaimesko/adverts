<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('user', 'Api\User\ProfileController@show')->middleware('auth:api');

Route::put('user', 'Api\User\ProfileController@update');


Route::group(['as' => 'api.', 'namespace' => 'Api'],
    function () {
        Route::get('/', 'HomeController@home');
        Route::post('/register', 'Auth\RegisterController@register');

        Route::middleware('auth:api')->group(function () {

            Route::get('adverts/index', 'Adverts\AdvertsController@index');
            Route::get('adverts/show/{advert}', 'Adverts\AdvertsController@show');

            Route::get('/adverts/{user}/favorite', 'User\FavoriteController@index');
            Route::post('/adverts/{advert}/favorite', 'User\FavoriteController@add');
            Route::delete('/adverts/{advert}/favorite', 'User\FavoriteController@remove');

            Route::get('user', 'User\ProfileController@show');
            Route::put('user', 'User\ProfileController@update');


        });
    });
