<?php

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
    return redirect('login');
    // return view('test');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::middleware(['check-admin'])->group(function () {
        Route::resource('positions', 'PositionController');
        Route::resource('sub-admins', 'SubAdminController');
        Route::post('sub-admins-delete/{id}', 'SubAdminController@destroy');
        Route::post('add-noti', 'NotificationController@addNotification');
    });
    Route::post('delete-notification', 'NotificationController@deleteNotification');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('stocks', 'StockController');
    Route::resource('notifications', 'NotificationController');
    Route::resource('tips', 'TipController');
    Route::post('tip-delete/{id}', 'TipController@destroy');
    Route::post('stock-delete/{id}', 'StockController@destroy');
    Route::get('/get-notification', 'NotificationController@getNotification');
    Route::get('/autocomplete-search', 'NotificationController@autocompleteSearch');

   
});

