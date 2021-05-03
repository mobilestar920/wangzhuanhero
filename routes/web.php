<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    if (Auth::check()) {
        if (Auth::user()->role == 0) {
            return redirect()->route('sellers');
        } else {
            return redirect()->route('verifyCodes');
        }
    } else {
        return view('auth.login');
    }
});

Route::namespace('Auth')->group(function () {
    Route::get('/login','LoginController@show_login_form')->name('login');
    Route::post('/login','LoginController@process_login')->name('login_post');
    Route::get('/register','LoginController@show_signup_form')->name('register');
    Route::post('/register','LoginController@process_signup')->name('register_post');
    Route::get('/logout','LoginController@logout')->name('logout');
});

Route::namespace('Manager')->group(function () {
    Route::get('/sellers','ManageSellerController@index')->name('sellers');
    Route::post('/sellers/block','ManageSellerController@blockSeller')->name('block_seller');

    Route::get('/customers','ManageCustomerController@index')->name('customers');

    Route::get('/apps','ManageAppController@index')->name('apps');
    Route::post('/newapp', 'ManageAppController@addNewApp')->name('new_app');
    Route::post('/apps/edit', 'ManageAppController@editApp')->name('edit_app');
    Route::post('/apps/delete', 'ManageAppController@deleteApp')->name('delete_app');


    Route::get('/scripts', 'ManageScriptController@index')->name('scripts');
    Route::post('/scripts/upload', 'ManageScriptController@uploadResource')->name('upload_scripts');
    Route::post('/scripts/update', 'ManageScriptController@updateResource')->name('update_scripts');
    
    Route::get('/me/apps', 'ManageMyAppController@index')->name('myApps');
    Route::post('/me/app/new', 'ManageMyAppController@addNewVersion')->name('addNewVersion');

    // News
    Route::get('/news', 'ManageNewsController@index')->name('news');
    Route::post('/news/new', 'ManageNewsController@createNews')->name('addNews');

    // Selling Status
    Route::get('/sellings', 'ManageShellingStatusController@index')->name('sellings');
    Route::get('/sellings/{type}', 'ManageShellingStatusController@showDetail')->name('selling_detail');

});

Route::namespace('Seller')->group(function () {
    // Generate Code
    Route::get('/generation', 'GenerateCodeController@index')->name('verifyCodes');
    Route::get('/generation/{type}', 'GenerateCodeController@getVerificationCode')->name('verifyCodesByType');
    Route::post('/generation/code', 'GenerateCodeController@generateCode')->name('codeGenerate');

    // Selling Status
    Route::get('/seller/sellings', 'SellerSellingStatusController@index')->name('seller_sellings');

    Route::get('books/download', 'GenerateCodeController@exportToExcel')->name('exportExcel');
    // Route::get('/generation/{type}', 'SellerSellingStatusController@getVerificationCode')->name('verifyCodesByType');
});