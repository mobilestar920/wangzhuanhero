<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1/auth'], function($router) {
    Route::post('login/customer', 'Api\\CustomerLoginController@login');
});

Route::group(['middleware' => ['assign.guard:api', 'jwt.auth'], 'prefix' => 'v1'], function($router) {
    Route::get('apps', 'Api\\AppListController@index');
    Route::get('apps/ids', 'Api\\AppListController@downloadableAppIds');
    Route::get('me/{id}', 'Api\\AppListController@caishenDownload');
    Route::get('news/latest', 'Api\\AppListController@getLatestNews');
    Route::post('me/login/status', 'Api\\AppListController@userAvailable');
});


Route::group(['middleware' => ['assign.guard:api', 'jwt.auth'], 'prefix' => 'v1/app'], function($router) {
    Route::get('download/{id}', 'Api\\AppListController@download');
    Route::get('resource/{id}', 'Api\\AppListController@resourceDownload');
    Route::get('mile/{id}', 'Api\\AppListController@getMileResource');
    Route::get('changbao/{id}', 'Api\\AppListController@changbaoDownload');
});

Route::group(['prefix' => 'download'], function($router) {
    Route::get('caishen/latest', 'Api\\AppListController@caishenFreeDownload');
});