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
    Route::get('apps', 'Api\\V1\\Controllers\\AppListController@index');
    Route::get('apps/ids', 'Api\\V1\\Controllers\\AppListController@downloadableAppIds');
    Route::get('me/{id}', 'Api\\V1\\Controllers\\AppListController@caishenDownload');
    Route::get('news/latest', 'Api\\V1\\Controllers\\AppListController@getLatestNews');
    Route::post('me/login/status', 'Api\\V1\\Controllers\\AppListController@userAvailable');
});


Route::group(['middleware' => ['assign.guard:api', 'jwt.auth'], 'prefix' => 'v1/app'], function($router) {
    Route::get('download/{id}', 'Api\\V1\\Controllers\\AppListController@download');
    Route::get('resource/{id}', 'Api\\V1\\Controllers\\AppListController@resourceDownload');
    Route::get('mile/{id}', 'Api\\V1\\Controllers\\AppListController@getMileResource');
    Route::get('changbao/{id}', 'Api\\V1\\Controllers\\AppListController@changbaoDownload');
});

Route::group(['prefix' => 'download'], function($router) {
    Route::get('caishen/latest', 'Api\\V1\\Controllers\\AppListController@caishenFreeDownload');
});