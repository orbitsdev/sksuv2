<?php

use App\Models\User;
use App\Mail\ResetPassword;
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

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/mail', function(){

    $user = User::first();
    $domain = 'http://127.0.0.1:8000';
    $token = uniqid();
    $set_new_password_url =  $domain."/set-new-password?mail=".$user->mail."&token=".$token;

    
    return new ResetPassword($user, $token, $set_new_password_url,);
});


Route::get('/{any}' , function(){
    return view('app');
})->where('any', '.*');

