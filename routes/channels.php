<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat', function ($user) {
  return Auth::check();
  //return true;
});

Broadcast::channel('claims', function ($user) {
  return Auth::check();
  //return true;
});

Broadcast::channel('purchase', function ($user) {
  return Auth::check();
  //return true;
});

Broadcast::channel('reassign', function ($user) {
  return Auth::check();
  //return true;
});

Broadcast::channel('messages', function($user){
  return true;
});
//Broadcast::routes();
