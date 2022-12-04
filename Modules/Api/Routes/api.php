<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('/')->group(function () {

    // Need Authenticate
    Route::middleware('auth:api')->group(function () {
        Route::get('/current-user', 'UserController@getCurrentUser');
        Route::get('/setting/{name}', 'SettingController@getSetting');
    });

    Route::group(['middleware' => ['permission:manage_user']], function () {
        Route::get('/user', 'UserController@index');
        Route::get('/user/{id}', 'UserController@show');
        Route::delete('/user/{id}', 'UserController@destroy');
        Route::post('/user', 'UserController@create');
        Route::put('/user/{id}', 'UserController@update')->where('id', '[0-9]+');
        Route::put('/user/reset-password/{id}', 'UserController@resetPassword');

    });
    Route::put('/user/language', 'UserController@setLanguage');

    Route::group(['middleware' => ['permission:sync_file']], function () {
        Route::get('/sync_file/departments', 'SyncFileController@getAllDepartments');
        Route::get('/sync_file/source', 'SyncFileController@getSourceTree');
        Route::get('/sync_file/des', 'SyncFileController@getDesTree');
        Route::post('/sync_file/sync', 'SyncFileController@syncFiles');
        Route::post('/sync_file/delete', 'SyncFileController@deleteItemInTree');
        Route::post('/sync_file/rename', 'SyncFileController@renameItemInTree');
    });
    
    Route::group(['middleware' => ['permission:play_file']], function () {
        Route::get('/playfile/des', 'PlayFileController@getSourceTreeForPlayFile');
        Route::delete('/playlists/delete', 'PlayFileController@deletePlaylists');
        Route::put('/playlists/update/create', 'PlayFileController@updateOrCreatePlaylists');
        Route::put('/line/checked/{id}', 'LineController@updateCheckedForLine')->where('id', '[0-9]+');
        Route::get('/line/user/{userId}', 'LineController@getLinesByUserId')->where('userId', '[0-9]+');
        Route::get('/line/department/{depId}', 'LineController@getLinesByDepId')->where('depId', '[0-9]+');
        Route::get('/line/{id}', 'LineController@show')->where('id', '[0-9]+');
        Route::put('/line/isrunning/{id}', 'LineController@updateIsRunningForLine')->where('id', '[0-9]+');
        Route::get('/line/{lineId}/micros', 'LineController@getMicrosByLineId')->where('lineId', '[0-9]+');
        Route::put('/micro_pc/isrunning', 'MicroPcController@updateIsRunningForMicroPC');
        Route::get('/department/role/{depId}', 'DepartmentController@getDepWidthRoleLine')->where('depId', '[0-9]+');
    });

    Route::group(['middleware' => ['permission:manage_line|play_file']], function () {
        Route::get('line', 'LineController@index');
        Route::post('/line', 'LineController@create');
        Route::put('/line/{id}', 'LineController@update')->where('id', '[0-9]+');
        Route::delete('/line/{id}', 'LineController@destroy')->where('id', '[0-9]+');
        Route::get('/line/add/micros/{depId}', 'LineController@getMicrosByDepIdWidthLineIdNull');
        Route::get('/line/edit/{depId}/{lineId}/micros', 'LineController@getMicrosByDepIdWidthLineIdCurrentOrNull')->where('lineId', '[0-9]+');
    });
    
    Route::group(['middleware' => ['permission:manage_deparment|play_file']], function () {
        Route::get('/department', 'DepartmentController@index');
        Route::delete('/department/{id}', 'DepartmentController@destroy');
        Route::post('/department', 'DepartmentController@create');

        Route::put('/department/{id}', 'DepartmentController@update');
        Route::get('/department/{depId}/users', 'DepartmentController@getUserByDepId')->where('depId', '[0-9]+');
    });
    
    Route::group(['middleware' => ['permission:manage_micro_pc|play_file']], function () {
        Route::get('/micro_pc', 'MicroPcController@index');
        Route::post('/micro_pc', 'MicroPcController@store');
        Route::delete('/micro_pc/{id}', 'MicroPcController@destroy');
        Route::put('/micro_pc/{id}', 'MicroPcController@update');
        Route::post('/micro_pc/shutdown/{id}', 'MicroPcController@shutdownById')->where('id', '[0-9]+');
        Route::post('/micro_pc/reboot/{id}', 'MicroPcController@rebootById')->where('id', '[0-9]+');
    });
    
    Route::group(['middleware' => ['permission:manage_pc']], function () {
        Route::get('/controlpc', 'ControlPcController@index');
        Route::post('/controlpc', 'ControlPcController@create');
        Route::delete('/controlpc/{id}', 'ControlPcController@destroy');
        Route::put('/controlpc/{id}', 'ControlPcController@update');
    });
    
    Route::group(['middleware' => ['permission:setting']], function () {
        Route::get('/setting', 'SettingController@getAllSettings');
        Route::put('/setting/update', 'SettingController@update');
    });
    
    // Don't need Authenticate
    Route::get('/role', 'RolesController@index');
    Route::get('/hello', 'UnAuthApiBaseController@hello');
    Route::get('/download-files/{id}', 'DownloadFileController@download');
});