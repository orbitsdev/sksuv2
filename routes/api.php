<?php

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Mail\NewPasswordMailController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// AUTH
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// GOOGLE SIGNIN
Route::get('/authorize/{provider}/redirect', [GoogleController::class ,'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class ,'handleProviderCallback']);

// PASSWORD RESET
Route::post('/request-password-reset', [NewPasswordMailController::class, 'sendEmailForPasswordReset']);
Route::post('/set-password', [NewPasswordMailController::class, 'setNewPassword']);

Route::get('/role', function(){
    return redirect()->to('/authorize/google/callback?code=anna');
});






