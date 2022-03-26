<?php

use App\Models\User;
use App\Notifications\TestNotification;
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

Route::get('/test', function () {
    $user = User::find(11);
    $user->notify(new TestNotification());
});
//
//// Auth::routes();
//
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//
// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any', '.*');
//Broadcast::routes();
