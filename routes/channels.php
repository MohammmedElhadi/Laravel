<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
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

Broadcast::channel('demands_channel_{id}', function ($user, $id) {
    return  Auth::id() ===  $user->id;
});
Broadcast::channel('response_for_{id}', function ($user, $id) {
    return  Auth::id() ===  $user->id;
});

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return true;
// });
