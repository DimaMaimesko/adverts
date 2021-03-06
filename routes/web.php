<?php
Route::get('api/github/{username}', 'Api\ApiController@github')->name('githubuser');
Route::get('api/darksky/{lat}/{lon}', 'Api\ApiController@darksky')->name('darkskyweather');
Route::get('api/weather/form/{weatherObject?}', 'Api\ApiController@showForm')->name('weather.index');
Route::post('api/weather/getWeather', 'Api\ApiController@getWeather')->name('weather.get');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider')->name('facebookauth');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
Auth::routes();


Route::get('/adverts/show/{advert}', 'Adverts\AdvertsController@show')->name('adverts.show');
//Route::get('/adverts/search/{adverts_path?}', 'Adverts\AdvertsController@search')->name('adverts.search')->where('adverts_path', '.+');
Route::get('/adverts/{adverts_path?}', 'Adverts\AdvertsController@index')->name('adverts.index')->where('adverts_path', '.+');

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('verify');

Route::get('/banner/get', 'BannerController@get')->name('banner.get');
Route::get('/banner/{banner}/click', 'BannerController@click')->name('banner.click');

Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
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
        Route::post('/adverts/upload/{advert}', 'Adverts\PhotosController@uploadFiles')->name('adverts.upload');

        Route::get('/favorites', 'FavoriteController@index')->name('favorites.home');
        Route::post('/favorites/{advert}', 'FavoriteController@add')->name('favorites.add');
        Route::delete('/favorites/{advert}', 'FavoriteController@remove')->name('favorites.remove');

        Route::resource('tickets', 'TicketController')->only(['index', 'show', 'create', 'store', 'destroy']);
        Route::post('tickets/{ticket}/message', 'TicketController@message')->name('tickets.message');

        Route::group(['prefix' => 'messages', 'namespace' => 'Messages', 'as' => 'messages.'], function () {
            Route::get('/index', 'MessagesController@index')->name('index');
            Route::get('/show/{dialog}', 'MessagesController@show')->name('show');
            Route::post('/reply/{dialog}', 'MessagesController@reply')->name('reply');
            Route::post('/send/{advert}', 'MessagesController@send')->name('send');
//            Route::get('/show/{advert}', 'AdvertsController@show')->name('show');
//            Route::post('/moderate/{advert}', 'AdvertsController@moderate')->name('moderate');
//            Route::post('/reject/{advert}', 'AdvertsController@reject')->name('reject');

        });


        Route::group([
            'prefix' => 'banners',
            'as' => 'banners.',
            'namespace' => 'Banners',
            // 'middleware' => [App\Http\Middleware\FilledProfile::class],
        ], function () {
            Route::get('/', 'BannerController@index')->name('index');
            Route::get('/create', 'CreateController@category')->name('create');
            Route::get('/create/region/{category}/{region?}', 'CreateController@region')->name('create.region');
            Route::get('/create/banner/{category}/{region?}', 'CreateController@banner')->name('create.banner');
            Route::post('/create/banner/{category}/{region?}', 'CreateController@store')->name('create.banner.store');

            Route::get('/show/{banner}', 'BannerController@show')->name('show');
            Route::get('/{banner}/edit', 'BannerController@editForm')->name('edit');
            Route::put('/{banner}/edit', 'BannerController@edit');
            Route::get('/{banner}/file', 'BannerController@fileForm')->name('file');
            Route::put('/{banner}/file', 'BannerController@file');
            Route::post('/{banner}/send', 'BannerController@send')->name('send');
            Route::post('/{banner}/cancel', 'BannerController@cancel')->name('cancel');
            Route::post('/{banner}/order', 'BannerController@order')->name('order');
            Route::delete('/{banner}/destroy', 'BannerController@destroy')->name('destroy');
        });
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

        Route::get('regions/search', 'RegionsController@search')->name('regions.search');

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
        Route::resource('pages', 'PagesController');
        Route::group(['prefix' => 'pages/{page}', 'as' => 'pages.'], function () {
            Route::post('/first', 'PagesController@first')->name('first');
            Route::post('/up',    'PagesController@up')->name('up');
            Route::post('/down',  'PagesController@down')->name('down');
            Route::post('/last',  'PagesController@last')->name('last');
        });

        Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
            Route::get('/', 'TicketController@index')->name('index');
            Route::get('/{ticket}/show', 'TicketController@show')->name('show');
            Route::get('/{ticket}/edit', 'TicketController@editForm')->name('edit');
            Route::put('/{ticket}/update', 'TicketController@update')->name('update');
            Route::post('{ticket}/message', 'TicketController@message')->name('message');
            Route::post('/{ticket}/close', 'TicketController@close')->name('close');
            Route::post('/{ticket}/approve', 'TicketController@approve')->name('approve');
            Route::post('/{ticket}/reopen', 'TicketController@reopen')->name('reopen');
            Route::delete('/{ticket}/destroy', 'TicketController@destroy')->name('destroy');
        });

        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
            Route::get('/', 'BannerController@index')->name('index');
            Route::get('/{banner}/show', 'BannerController@show')->name('show');
            Route::get('/{banner}/edit', 'BannerController@editForm')->name('edit');
            Route::put('/{banner}/edit', 'BannerController@edit');
            Route::post('/{banner}/moderate', 'BannerController@moderate')->name('moderate');
            Route::get('/{banner}/reject', 'BannerController@rejectForm')->name('reject');
            Route::post('/{banner}/reject', 'BannerController@reject');
            Route::post('/{banner}/pay', 'BannerController@pay')->name('pay');
            Route::delete('/{banner}/destroy', 'BannerController@destroy')->name('destroy');
        });




    }
);

Route::get('/{page_path?}', 'PageController@show')->name('page')->where('page_path', '.+');
