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


Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/play_file/{id}', function(){
    return view('web::file-player');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'RootController@index');
    Route::get('/{vue_capture?}', 'RootController@index')->where('vue_capture', '[\/\w\.-]*')->name('vue');
});


