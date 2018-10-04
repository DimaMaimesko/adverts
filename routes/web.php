<?php

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');


Auth::routes();


Route::get('/adverts/show/{advert}', 'Adverts\AdvertsController@show')->name('adverts.show');
Route::get('/adverts/{adverts_path?}', 'Adverts\AdvertsController@index')->name('adverts.index')->where('adverts_path', '.+');

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('verify');
Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ],
    function (){
        Route::get('/', 'HomeController@index')->name('home');
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
            Route::get('/', 'ProfileController@index')->name('home');
            Route::get('/edit', 'ProfileController@edit')->name('edit');
            Route::put('/update', 'ProfileController@update')->name('update');
            Route::post('/phone', 'PhoneController@request')->name('request');
            Route::get('/phone', 'PhoneController@form')->name('phone');
            Route::put('/phone', 'PhoneController@verify')->name('phone.verify');
        });
        Route::get('/adverts', 'Adverts\AdvertsController@index')->name('adverts.home')->middleware(\App\Http\Middleware\FilledProfile::class);
        Route::get('/adverts/create/category', 'Adverts\CreateController@category')->name('adverts.create.category');
        Route::get('/adverts/create/region/{category}/{region?}', 'Adverts\CreateController@region')->name('adverts.create.region');
        Route::get('/adverts/create/advert/{category}/{region?}', 'Adverts\CreateController@advert')->name('adverts.create.advert');
        Route::post('/adverts/create/store/{category}/{region?}', 'Adverts\CreateController@store')->name('adverts.create.store');
        Route::post('/adverts/tomoderation/{advert}', 'Adverts\AdvertsController@tomoderation')->name('adverts.tomoderation');
        Route::delete('/adverts/delete/{advert}', 'Adverts\AdvertsController@delete')->name('adverts.delete');

        Route::get('/adverts/edit/{advert}', 'Adverts\AdvertsController@edit')->name('adverts.edit');
        Route::post('/adverts/update/{advert}', 'Adverts\AdvertsController@update')->name('adverts.update');


    }
);

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth'],
    ],
    function (){
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UsersController');
        Route::resource('permissions', 'PermissionsController');
        Route::resource('roles', 'RolesController');
        Route::get('regions/sub/{parent_id}', 'RegionsController@createsubregion')->name('subregion');
        Route::resource('regions', 'RegionsController');
        Route::group(['prefix' => 'regions/{region}', 'as' => 'regions.'], function () {
            Route::post('/first', 'RegionsController@first')->name('first');
            Route::post('/up',    'RegionsController@up')->name('up');
            Route::post('/down',  'RegionsController@down')->name('down');
            Route::post('/last',  'RegionsController@last')->name('last');
        });
        Route::resource('categories', 'CategoriesController');
        Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
            Route::post('/first', 'CategoriesController@first')->name('first');
            Route::post('/up',    'CategoriesController@up')->name('up');
            Route::post('/down',  'CategoriesController@down')->name('down');
            Route::post('/last',  'CategoriesController@last')->name('last');
            Route::resource('attributes', 'AttributesController')->except('index');
        });
        Route::group(['prefix' => 'adverts',  'as' => 'adverts.'], function () {
            Route::get('/index', 'AdvertsController@index')->name('index');
            Route::get('/show/{advert}', 'AdvertsController@show')->name('show');
            Route::post('/moderate/{advert}', 'AdvertsController@moderate')->name('moderate');
            Route::post('/reject/{advert}', 'AdvertsController@reject')->name('reject');

        });



    }
);