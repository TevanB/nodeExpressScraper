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
Auth::routes();
Route::get('email/verify/{id}', 'App\Http\Controllers\Auth\VerificationController@verify');
Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show');
Route::put('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend');
Route::get('/boosting', function () {
    return view('layouts.order');
});
Route::get('/nextstep', function () {
    return view('layouts.nextstep');
});

Route::get('/', function () {
    return view('layouts.app');
});





Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

//Route::get('/boosting', 'OrderController@index')->name('home');

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/
Route::get('/chat', 'ChatsController@index')->name('chat')->middleware('verified');


Route::get('messages/{id}', 'ChatsController@fetchMessages')->middleware('verified');

Route::post('messages', 'ChatsController@sendMessage')->middleware('verified');

//Route::get('messages/{id}', 'ChatsController@getMessage');

Route::get('{path}',"HomeController@index")->where('path','([A-z\d\-\/_.]+)?')->middleware('verified');
