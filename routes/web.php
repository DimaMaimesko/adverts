<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('verify');

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
        Route::resource('regions', 'RegionsController');
        Route::group(['prefix' => 'regions/{region}', 'as' => 'regions.'], function () {
            Route::post('/first', 'RegionsController@first')->name('first');
            Route::post('/up',    'RegionsController@up')->name('up');
            Route::post('/down',  'RegionsController@down')->name('down');
            Route::post('/last',  'RegionsController@last')->name('last');
        });
        Route::get('regions/sub/{parent_id}', 'RegionsController@createsubregion')->name('subregion');
        Route::resource('categories', 'CategoriesController');


    }
);