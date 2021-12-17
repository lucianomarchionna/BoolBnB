<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// TEST
Route::get('/', 'HomeController@indexHome')->name('index');




// Route::get('/', 'HomeController@index')->name('index');
// Route::get('/about-us', 'HomeController@about')->name('about-us');

Route::resource('/apartments', 'ApartmentController');
Route::post('/new-message', 'MessageController@store')->name('store-message');
Auth::routes();
// Route::get('/discover', 'HomeController@search')->name('discoverPage');

// Route::get('/dashboard', 'HomeController@index')->name('home');

Route::middleware('auth')->namespace('Host')->prefix('host')->name('host.')
->group(function(){

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/messages', 'HomeController@listMessage')->name('messages');
    Route::get('/messages/show/{message}', 'HomeController@showMessage')->name('show-message');
    Route::get('/apartments/advertise/{id}', 'ApartmentController@sponsor')->name('apartments.advertise');
    Route::get('/apartments/advertise/payment/{id}', 'SponsorController@index')->name('apartments.advertise.payment');
    Route::post('/apartments/advertise/checkout/{id}', 'SponsorController@checkout')->name('apartments.advertise.checkout');
    Route::delete('/messages/delete/{message}', 'HomeController@destroyMessage')->name('delete-message');
    Route::resource('/apartments', 'ApartmentController');
    Route::get('/statistics/{id}', 'StatisticController@statistics')->name('statistics-page');
    Route::get('/stastic/{id}', 'StatisticController@show')->name('statistic');
});


Route::get('/{any}', function () {
    return view('guest.homepage');
})->where("any", ".*");



Route::prefix('api')->namespace('Api')->middleware('auth')->group(function (){
    Route::get('/user', function(){
        $auth = Auth::user();
        return response()->json([
            'success'=>true,
            'user' => $auth
        ]);
});
});
