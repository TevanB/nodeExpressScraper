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

Route::middleware(['auth:api', 'scope:view-orders'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources(['user'=>'API\UserController']);
/*Route::get('/user', function () {
    // Access token has both "check-status" and "place-orders" scopes...
    Route::apiResources(['user'=>'API\UserController']);

})->middleware(['auth:api', 'scope:view-orders']);
*/
//Route::apiResources(['user'=>'API\UserController']);
/*Route::group(['middleware' => 'client_credentials'], function () {
//your route

});
*/
